<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Str;

/**
 * Class CategoryController
 *
 * Controller ini menangani operasi CRUD (Create, Read, Update, Delete) untuk model Category.
 * Ini mencakup menampilkan daftar kategori, menyimpan kategori baru, memperbarui
 * yang sudah ada, dan menghapusnya dari database.
 *
 * @package App\Http\Controllers
 */


class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori dengan fungsionalitas pencarian dan paginasi.
     *
     * Metode ini juga membuat token unik untuk form submission ('submissionToken')
     * guna mencegah pengiriman ganda saat membuat kategori baru.
     *
     * @param \Illuminate\Http\Request $request Untuk menangani query pencarian.
     * @return \Illuminate\View\View
     */

    public function index(Request $request){

        $search = $request->query('search');
        $submissionToken = Str::random(32);

        $categories = Category::when($search, function ($query, $search) {
            return $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
                })->paginate(5)->withQueryString();

        return view('categories.index', compact('categories', 'search', 'submissionToken'));
    }


    /**
     * Menyimpan kategori baru ke dalam database.
     *
     * Metode ini menyertakan mekanisme untuk mencegah pengiriman formulir ganda
     * dengan menggunakan token sesi. Ini memvalidasi input, dan jika berhasil,
     * membuat record kategori baru.
     *
     * @param \Illuminate\Http\Request $request Data dari formulir pembuatan kategori.
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(Request $request){

        $submissionToken = $request->input('submission_token');

        if(session()->has("submission_token_{$submissionToken}")){
            return redirect()->route('categories')->with('error', 'Duplicate submission detected!');
        }

        session()->put("submission_token_{$submissionToken}", true);

        $rules = [
            'name' => 'required|min:3',
            'description' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            session()->forget("submission_token_{$submissionToken}");
            return redirect()->back()->withErrors($validator)->withInput()->with('modal', 'create');
        }

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('categories')->with('success', 'Category created successfully');
    }

    /**
     * Memperbarui data kategori yang sudah ada di database.
     *
     * Metode ini mencari kategori berdasarkan ID, memvalidasi data baru yang dikirimkan,
     * dan jika validasi berhasil, akan memperbarui record kategori tersebut.
     *
     * @param int $id ID dari kategori yang akan diperbarui.
     * @param \Illuminate\Http\Request $request Data baru untuk kategori.
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(int $id, Request $request){

        $category = Category::findOrFail($id);

        $rules = [
            'name' => 'required|min:3',
            'description' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return redirect()->route('categories.edit', ['id' => $id])
                         ->withInput()
                         ->withErrors($validator);
        }

        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('categories')->with('success', 'Category updated successfully');
    }

    /**
     * Menghapus sebuah kategori dari database.
     *
     * Metode ini akan mencari kategori berdasarkan ID yang diberikan dan
     * menghapusnya secara permanen.
     *
     * @param int $id ID dari kategori yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy(int $id) {

        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories')->with('success', 'Category deleted successfully!');
    }
}
