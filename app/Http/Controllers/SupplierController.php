<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
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

    public function destroy(int $id) {
  
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('suppliers')->with('success', 'Supplier deleted successfully!');
    }
}
