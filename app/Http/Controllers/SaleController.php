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

    public function showDetail($id)
    {
        $sale = Sale::with(['items.product', 'user'])->findOrFail($id);
        return view('sales._detail_modal', compact('sale'))->render();
    }

    public function destroy($id)
    {
        $sale = Sale::find($id);
        if ($sale) {
            $sale->delete();
            return redirect()->route('sales.index')->with('success', 'Transaksi berhasil dihapus.');
        }
        return redirect()->route('sales.index')->with('error', 'Transaksi tidak ditemukan.');
    }
}
