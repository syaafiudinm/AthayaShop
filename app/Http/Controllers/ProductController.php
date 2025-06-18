<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;

/**
 * Class ProductController
 *
 * Controller ini mengelola semua operasi CRUD (Create, Read, Update, Delete) untuk produk.
 * Ini termasuk menampilkan daftar produk, menangani pembuatan produk baru dengan upload
 * gambar ke S3, memperbarui produk, dan menghapus produk beserta file gambarnya dari S3.
 *
 * @package App\Http\Controllers
 */

class ProductController extends Controller
{
    /**
     * Menampilkan halaman daftar produk dengan filter dan pencarian.
     *
     * Metode ini mengambil daftar produk yang dapat difilter berdasarkan nama, deskripsi,
     * kategori, atau supplier. Ini juga menyediakan data kategori, supplier, dan
     * token unik untuk form pembuatan produk baru.
     *
     * @param \Illuminate\Http\Request $request Untuk menangani query pencarian dan filter.
     * @return \Illuminate\View\View
     */

    public function index(Request $request){
        $categories = Category::all();
        $suppliers = Supplier::all();
        $submissionToken = Str::random(32);

        $search = $request->query('search');
        $category = $request->query('category');

        $products = Product::when($search, function ($query, $search) {
            return $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('supplier', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });

                })
                ->when($category && $category !== 'all', function ($query) use ($category) {
                    return $query->where('category_id', $category);
                })
                ->paginate(7)
                ->withQueryString();

        return view('products.index', compact('products', 'categories', 'suppliers', 'submissionToken'));
    }

    /**
     * Menyimpan produk baru ke database dan mengunggah gambar ke S3.
     *
     * Metode ini memvalidasi data produk baru, termasuk gambar. Jika valid,
     * gambar akan di-resize menggunakan Intervention/Image dan diunggah ke S3.
     * URL gambar dari S3 kemudian disimpan ke database.
     * Termasuk mekanisme pencegahan pengiriman ganda.
     *
     * @param \Illuminate\Http\Request $request Data dari formulir pembuatan produk.
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(Request $request){

        $submissionToken = $request->input('submission_token');

        if(session()->has("submission_token_{$submissionToken}")){
            return redirect()->route('products')->with('error', 'Duplicate submission detected!');
        }

        session()->put("submission_token_{$submissionToken}", true);

        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'supplier_id' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($validator->fails()){
            session()->forget("submission_token_{$submissionToken}");
            return redirect()
                            ->back()
                            ->withInput()
                            ->withErrors($validator)
                            ->with('modal', 'create');
        }

        $product = new Product();
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->stock = $request->stock;
        $product->price = $request->price;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            try {
                $file = $request->file('image');

                // Buat nama file yang unik untuk menghindari konflik di S3
                $fileName = Str::slug($product->name) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $folder = "products";
                $path = $folder  . '/' . $fileName;

                // Inisialisasi ImageManager
                $manager = new ImageManager(new Driver());

                // Baca dan proses gambar
                $image = $manager->read($file);
                $image->resize(300,200); // Resize gambar, tinggi menyesuaikan aspek rasio

                // Encode gambar yang sudah di-resize untuk di-upload
                $encodedImage = $image->encode();

                // Upload gambar yang telah diproses ke S3
//                Storage::disk('s3')->put($path, $encodedImage, 'public');
                Storage::disk('s3')->put($path, $encodedImage->__toString(), 'public');
                // Jika berhasil, baru isi kolom 'image' dengan URL dari S3
                $product->image = Storage::disk('s3')->url($path);

            } catch (Exception $e) {
                // Jika terjadi error saat upload, batalkan semua proses.
                // Kembalikan pengguna ke form dengan pesan error yang jelas.
                // Di aplikasi production, catat error ini ke log.
                // Log::error('S3 Upload Error: ' . $e->getMessage());
                return redirect()->back()
                    ->with('error', 'Gagal mengupload gambar. Silakan coba lagi.')
                    ->withInput();
            }
        }

        $product->save();

        return redirect()->route('products')->with('success', 'Product created successfully');
    }

    /**
     * Memperbarui data produk yang sudah ada.
     *
     * Metode ini memvalidasi dan memperbarui atribut produk. Jika gambar baru diunggah,
     * metode ini akan menyimpannya ke direktori lokal dan membuat thumbnail.
     *
     * @param int $id ID dari produk yang akan diperbarui.
     * @param \Illuminate\Http\Request $request Data baru untuk produk.
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(int $id, Request $request){
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($validator->fails()){
            return redirect()->route('products')
                        ->withInput()
                        ->withErrors($validator)
                        ->with('modal', 'edit')
                        ->with('product_id', $id);
        }

        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->stock = $request->stock;
        $product->price = $request->price;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/produk'), $fileName);
            $product->image = $fileName;

            $manager = new ImageManager(Driver::class);

            $img = $manager->read(public_path('uploads/produk/' . $fileName));
            $img->resize(300, 170);
            $img->save(public_path('uploads/produk/thumb/' . $fileName));
        }

        $product->save();

        return redirect()->route('products')->with('success', 'Product updated successfully');
    }

    /**
     * Menghapus produk dari database dan gambar terkait dari S3.
     *
     * Metode ini akan mencari produk berdasarkan ID, menghapus file gambar yang terkait
     * dari S3 (jika ada), lalu menghapus record produk dari database.
     *
     * @param int $id ID dari produk yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy(int $id) {
        $product = Product::findOrFail($id);

        // Ambil path relatif dari URL S3
        if ($product->image) {
            // Contoh image URL: https://athaya-shop-bucket.s3.ap-southeast-2.amazonaws.com/products/namafile.jpg
            $parsed = parse_url($product->image);
            $relativePath = ltrim($parsed['path'], '/'); // hasil: products/namafile.jpg

            if (Storage::disk('s3')->exists($relativePath)) {
                Storage::disk('s3')->delete($relativePath);
            }
        }

        $product->delete();

        return redirect()->route('products')->with('success', 'Product deleted successfully!');
    }
}
