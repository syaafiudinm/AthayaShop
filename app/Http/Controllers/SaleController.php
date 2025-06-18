<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

/**
 * Class SaleController
 *
 * Controller ini bertugas untuk mengelola data transaksi penjualan (sales).
 * Ini mencakup menampilkan daftar semua transaksi, menampilkan detail transaksi
 * individual, dan menghapus data transaksi.
 *
 * @package App\Http\Controllers
 */
class SaleController extends Controller
{
    /**
     * Menampilkan daftar transaksi penjualan dengan filter dan pencarian.
     *
     * Metode ini mengambil data penjualan beserta relasi ke item, produk, dan pengguna.
     * Data dapat difilter berdasarkan status transaksi dan dicari berdasarkan ID
     * transaksi atau nama pengguna. Hasilnya diurutkan dan dipaginasi.
     *
     * @param \Illuminate\Http\Request $request Untuk menangani query filter dan pencarian.
     * @return \Illuminate\View\View
     */

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

    /**
     * Mengambil dan merender detail dari satu transaksi untuk ditampilkan (biasanya dalam modal).
     *
     * Metode ini dirancang untuk permintaan AJAX, di mana ia akan mencari transaksi
     * berdasarkan ID, lalu mengembalikan konten HTML dari partial view
     * yang berisi detail lengkap transaksi tersebut.
     *
     * @param int $id ID dari transaksi penjualan yang akan ditampilkan.
     * @return string Konten HTML yang telah dirender.
     */

    public function showDetail($id)
    {
        $sale = Sale::with(['items.product', 'user'])->findOrFail($id);
        return view('sales._detail_modal', compact('sale'))->render();
    }


    /**
     * Menghapus data transaksi penjualan dari database.
     *
     * Metode ini akan mencari transaksi berdasarkan ID dan menghapusnya.
     * Perlu diperhatikan bahwa metode ini tidak mengembalikan stok produk
     * yang terkait dengan transaksi yang dihapus.
     *
     * @param int $id ID dari transaksi yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse
     */

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
