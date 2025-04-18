<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Session;

class CategoryController extends Controller
{
    public function index(Request $request){

        $search = $request->query('search');

        $categories = Category::when($search, function ($query, $search) {
            return $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
                })->paginate(10); 

        return view('categories.index', compact('categories', 'search'));
    }

    public function create(){
        return view('categories.create');
    }

    public function store(Request $request){
        $rules = [
            'name' => 'required',
            'description' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return redirect()->route('categories.create')->withInput()->withErrors($validator);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('categories')->with('success', 'Category created successfully');
    }

    public function edit(int $id){
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }  

    public function update(int $id, Request $request){
        
        $category = Category::findOrFail($id);
        
        $rules = [
            'name' => 'required',
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

    public function destroy(int $id) {
  
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories')->with('success', 'Category deleted successfully!');
    }
}
