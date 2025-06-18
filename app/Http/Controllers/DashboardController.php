<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Absen;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 *
 * Controller ini bertanggung jawab untuk mengumpulkan dan menampilkan data agregat
 * dari berbagai bagian aplikasi ke halaman dashboard utama. Ini berfungsi sebagai
 * pusat informasi yang merangkum statistik penjualan, kehadiran, dan data penting lainnya.
 *
 * @package App\Http\Controllers
 */

class DashboardController extends Controller
{
    /**
     * Menyiapkan dan menampilkan halaman dashboard utama.
     *
     * Metode ini mengambil berbagai data dari database untuk ditampilkan dalam bentuk ringkasan,
     * seperti total pendapatan, jumlah pesanan, statistik kehadiran harian (hadir, sakit, izin),
     * serta data penjualan dan produk terkini. Semua data ini kemudian dikirimkan
     * ke view 'dashboard.index'.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tanggal = Carbon::now('Asia/Makassar')->toDateString();
        $witaNow = now('Asia/Makassar')->format('H:i:s');

        $categories = Category::with('products')->get();

        $TotalOrder = Sale::where('status', 'paid')->count();
        $totalIncome = Sale::where('status', 'paid')->sum('total_price');

        $sales = Sale::with(['items.product', 'user'])->get();
        $products = Product::with('salesItems')->get();

        $sakitCount = Absen::whereDate('tanggal', $tanggal)->where('status', 'Sakit')->count();
        $izinCount = Absen::whereDate('tanggal', $tanggal)->where('status', 'Izin')->count();
        $hadirCount = Absen::whereDate('tanggal', $tanggal)->where('status', 'Hadir')->count();

        $newestIncome = optional(
                            Sale::where('status', 'paid')->orderBy('created_at', 'desc')->first()
                        )->total_price ?? 0;


        return view('dashboard.index', [
            'categories' => $categories,
            'TotalOrder' => $TotalOrder,
            'totalIncome' => $totalIncome,
            'sakitCount' => $sakitCount,
            'izinCount' => $izinCount,
            'hadirCount' => $hadirCount,
            'newestIncome' => $newestIncome,
            'witaNow' => $witaNow,
            'tanggal' => $tanggal,
            'sales' => $sales,
            'products' => $products,
        ]);
    }
}
