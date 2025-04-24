<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index(){

        $suppliers = Supplier::all();

        return view('suppliers.index', compact('suppliers'));
    }

    public function store(Request $request){
       
        $rules = [
            'name' => 'required',
            'contact' => 'required',
            'address' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
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
