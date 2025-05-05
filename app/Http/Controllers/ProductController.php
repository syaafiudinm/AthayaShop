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
    public function index(){
        $products = Product::with('category', 'supplier')->get();
        $categories = Category::all();
        $suppliers = Supplier::all();
        $submissionToken = Str::random(32);

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
            'stock' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($validator->fails()){
            session()->forget("submission_token_{$submissionToken}");
            return redirect()->back()->withErrors($validator)->withInput();
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
            $img->resize(300, 170);
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
            'stock' => 'required',
            'price' => 'required',
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

}
