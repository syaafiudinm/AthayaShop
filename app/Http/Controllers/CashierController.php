<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index(Request $request){

        $categories = Category::all();
        $suppliers = Supplier::all();

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

        return view('cashier.index', compact('products', 'categories', 'suppliers'));
    }
}
