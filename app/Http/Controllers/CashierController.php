<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sales;
use App\Models\Supplier;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index(Request $request){

        $categories = Category::all();
        $suppliers = Supplier::all();
        $cart = session('cart',[]);


        $subtotal = collect($cart)->sum(fn($item) => $item['subtotal']);
        $discount = 20000;
        $total = max(0, $subtotal - $discount);

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

        return view('cashier.index', compact('products', 'categories', 'suppliers','cart', 'subtotal', 'discount', 'total'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['total']++;
            $cart[$product->id]['subtotal'] = $cart[$product->id]['total'] * $product->price;
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'total' => 1,
                'unit_price' => $product->price,
                'subtotal' => $product->price,
            ];
        }

        session(['cart' => $cart]);

        return back();
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            $cart[$productId]['total']--;
            if ($cart[$productId]['total'] <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['subtotal'] = $cart[$productId]['total'] * $cart[$productId]['unit_price'];
            }
        }

        session(['cart' => $cart]);

        return back();
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);
        $subtotal = collect($cart)->sum(fn($item) => $item['subtotal']);
        $discount = 20000;
        $total = max(0, $subtotal - $discount);

        $sale = Sale::create([
            'user_id' => auth()->id(),
            'total_price' => $total,
            'payment_method' => $request->payment_method,
        ]);

        foreach ($cart as $item) {
            $sale->items()->create([
                'product_id' => $item['product_id'],
                'total' => $item['total'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('kasir')->with('success', 'Transaksi berhasil disimpan!');
    }
}
