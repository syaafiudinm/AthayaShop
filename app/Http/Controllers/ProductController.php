<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ProductController extends Controller
{
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
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/produk'), $fileName);
            $product->image = $fileName;

            $manager = new ImageManager(Driver::class);

            $img = $manager->read(public_path('uploads/produk/' . $fileName));
            $img->resize(300, 200);
            $img->save(public_path('uploads/produk/thumb/' . $fileName));
        }

        $product->save();

        return redirect()->route('products')->with('success', 'Product created successfully'); 
    }

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

    public function destroy(int $id) {
        $product = Product::findOrFail($id);

            $imagePath = public_path('uploads/produk/' . $product->image);
            $thumbPath = public_path('uploads/produk/thumb/' . $product->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            if (file_exists($thumbPath)) {
                unlink($thumbPath);
            }

        $product->delete();
        
        return redirect()->route('products')->with('success', 'Product deleted successfully!');
    }
}
