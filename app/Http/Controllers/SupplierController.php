<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Class SupplierController
 *
 * Controller ini menangani operasi CRUD (Create, Read, Update, Delete) untuk model Supplier.
 * Ini mencakup menampilkan daftar supplier, menyimpan supplier baru, memperbarui
 * yang sudah ada, dan menghapusnya dari database.
 *
 * @package App\Http\Controllers
 */
class SupplierController extends Controller
{
    /**
     * Menampilkan daftar supplier dengan fungsionalitas pencarian dan paginasi.
     *
     * Metode ini juga membuat token unik ('submissionToken') untuk form pembuatan data baru
     * guna mencegah pengiriman ganda.
     *
     * @param \Illuminate\Http\Request $request Untuk menangani query pencarian.
     * @return \Illuminate\View\View
     */

    public function index(Request $request){

        $search = $request->query('search');
        $submissionToken = Str::random(32);

        $suppliers = Supplier::when($search, function ($query, $search) {
            return $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('contact', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
        })->paginate(5)->withQueryString();

        return view('suppliers.index', compact('suppliers', 'submissionToken'));
    }

    /**
     * Menyimpan data supplier baru ke dalam database.
     *
     * Metode ini menggunakan token sesi untuk mencegah pengiriman formulir ganda.
     * Ini akan memvalidasi input, dan jika berhasil, membuat record supplier baru.
     *
     * @param \Illuminate\Http\Request $request Data dari formulir pembuatan supplier.
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(Request $request){

        $submissionToken = $request->input('submission_token');

        if(session()->has("submission_token_{$submissionToken}")){
            return redirect()->route('suppliers')->with('error', 'Duplicate submission detected!');
        }

        session()->put("submission_token_{$submissionToken}", true);

        $rules = [
            'name' => 'required',
            'contact' => 'required',
            'address' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            session()->forget("submission_token_{$submissionToken}");
            return redirect()->back()->withErrors($validator)->withInput()->with('modal', 'create');
        }

        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->contact = $request->contact;
        $supplier->address = $request->address;
        $supplier->save();

        return redirect()->route('suppliers')->with('success', 'Supplier created successfully');
    }

    /**
     * Memperbarui data supplier yang sudah ada di database.
     *
     * Metode ini mencari supplier berdasarkan ID, memvalidasi data baru yang dikirimkan,
     * dan jika validasi berhasil, akan memperbarui record tersebut.
     *
     * @param int $id ID dari supplier yang akan diperbarui.
     * @param \Illuminate\Http\Request $request Data baru untuk supplier.
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(int $id, Request $request){

        $rules = [
            'name' => 'required',
            'contact' => 'required',
            'address' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return redirect()->route('suppliers', ['id' => $id])
                         ->withInput()
                         ->withErrors($validator);
        }

        $supplier = Supplier::findOrFail($id);
        $supplier->name = $request->name;
        $supplier->contact = $request->contact;
        $supplier->address = $request->address;
        $supplier->save();

        return redirect()->route('suppliers')->with('success', 'Supplier updated successfully');
    }

    /**
     * Menghapus sebuah supplier dari database.
     *
     * Metode ini akan mencari supplier berdasarkan ID yang diberikan dan
     * menghapusnya secara permanen.
     *
     * @param int $id ID dari supplier yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy(int $id) {

        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('suppliers')->with('success', 'Supplier deleted successfully!');
    }
}
