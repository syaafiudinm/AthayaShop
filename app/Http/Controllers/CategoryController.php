<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
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

    public function destroy(int $id) {
  
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories')->with('success', 'Category deleted successfully!');
    }
}
