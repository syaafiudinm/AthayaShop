<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request){

        $status = $request->query('status');
        $search = $request->query('search');

        $sales = Sale::with(['items.product', 'user'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($search, function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                ->orWhereHas('user', fn($q) => 
                    $q->where('name', 'like', "%{$search}%")
                );
            })
            ->orderByDesc('created_at')
            ->paginate(6)
            ->withQueryString();

        return view('sales.index', compact('sales'));
    }
}
