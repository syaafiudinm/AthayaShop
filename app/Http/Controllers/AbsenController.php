<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Class AbsenController
 *
 * Controller ini bertanggung jawab untuk mengelola semua logika yang terkait dengan absensi pegawai.
 * Ini mencakup menampilkan data absensi, memverifikasi absensi melalui QR code,
 * memproses pengajuan absensi manual (seperti sakit atau izin), dan menangani persetujuan
 * oleh pemilik (owner).
 *
 * @package App\Http\Controllers
 * @property \App\Models\User $user
 * @property \App\Models\Absen $absen
 */

class AbsenController extends Controller
{

    /**
     * Menampilkan halaman utama absensi dengan daftar data absensi dan statistik.
     *
     * Metode ini mengambil semua data absensi, memungkinkan pencarian berdasarkan nama pegawai,
     * tanggal, waktu check-in, dan status. Metode ini juga menghitung statistik harian
     * seperti total pegawai, jumlah yang hadir, dan persentase kehadiran.
     * Data yang diambil kemudian dipaginasi dan dikirim ke view 'absen.index'.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */

    public function index(Request $request){

        $search = $request->query('search');
        $users = User::whereHas('absens')->get();

        $absens = Absen::with('user') // biar eager load relasi user
            ->when($search, function ($query, $search) {
                return $query
                    ->whereHas('user', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('tanggal', 'like', "%{$search}%")
                    ->orWhere('check_in', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(5)
            ->withQueryString();

        // data kehadiran //
        $tanggal = Carbon::now('Asia/Makassar')->toDateString();
        $totalPegawai = User::where('role', '!=', 'owner')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalKasir = User::where('role', 'cashier')->count();
        $hadirCount = Absen::where('tanggal', $tanggal)
            ->where('status', 'Hadir')
            ->count();
        $percent = $totalPegawai> 0 ? round(($hadirCount / $totalPegawai) * 100) : 0;
        return view('absen.index', compact('absens', 'users', 'totalPegawai', 'hadirCount', 'percent', 'tanggal', 'totalAdmin', 'totalKasir'));
    }

    /**
     * Memverifikasi dan mencatat absensi pegawai melalui pemindaian QR code.
     *
     * Metode ini berfungsi sebagai endpoint API untuk validasi QR code.
     * Ini mencari pengguna berdasarkan token QR, memeriksa apakah pengguna sudah absen
     * pada hari itu, dan jika belum, mencatat absensi 'Hadir' untuk pengguna tersebut.
     *
     * @param string $token Token unik dari QR code pengguna.
     * @return \Illuminate\Http\JsonResponse
     */

    public function verify($token)
    {
        $witaNow = now('Asia/Makassar');
        $user = Auth::user();
        $user = User::where('qr_code', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'QR Code tidak valid'], 404);
        }

        if ($user->id !== Auth::id()) {
            return response()->json(['message' => 'You cannot mark attendance for another user'], 403);
        }


        $absen = Absen::where('user_id', $user->id)
            ->whereDate('tanggal', $witaNow->toDateString())
            ->first();

        if ($absen) {
            return response()->json(['message' => 'Absensi sudah tercatat!'], 400);
        }


        Absen::create([
            'user_id' => $user->id,
            'tanggal' => $witaNow->toDateString(),
            'check_in' => $witaNow->format('H:i:s'),
            'status' => 'Hadir',
        ]);

        return response()->json(['message' => 'Absensi berhasil!']);
    }

    /**
     * Menangani persetujuan atau penolakan pengajuan absensi (Sakit/Izin) oleh owner.
     *
     * Metode ini hanya dapat diakses oleh pengguna dengan peran 'owner'.
     * Ini memperbarui kolom 'approval_status' pada catatan absensi menjadi 'Approved' atau 'Rejected'
     * berdasarkan input dari request.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id ID dari record absensi yang akan diproses.
     * @return \Illuminate\Http\RedirectResponse
     */

    public function approval(Request $request, $id)
    {
        $absen = Absen::where('user_id', Auth::user()->id)
            ->whereDate('tanggal', now('Asia/Makassar')->toDateString())
            ->first();

        if ($absen) {
            return back()->with('error', 'Absensi sudah dilakukan hari ini!');
        }

        $absen = Absen::findOrFail($id);

        if (Auth::user()->role !== 'owner') {
            abort(403);
        }

        $action = $request->input('action');
        if (!in_array($action, ['approve', 'reject'])) {
            return back()->with('error', 'Aksi tidak valid.');
        }

        $absen->approval_status = $action === 'approve' ? 'Approved' : 'Rejected';
        $absen->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    /**
     * Menyimpan data absensi baru yang diajukan oleh pegawai.
     *
     * Digunakan ketika pegawai melakukan absensi manual, seperti untuk status 'Sakit' atau 'Izin'.
     * Jika ada dokumen pendukung yang diunggah, file tersebut akan disimpan ke S3 bucket
     * dan URL-nya akan disimpan di database. Untuk status 'Sakit' atau 'Izin',
     * status persetujuan ('approval_status') akan diatur ke 'Pending'.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:Hadir,Sakit,Izin',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $fileUrl = null; // Initialize as null
        if ($request->hasFile('dokumen')) {
            $path = $request->file('dokumen')->storePublicly('dokumen', 's3');
            // Store the file on the 's3' disk in the 'dokumen' folder
            $fileUrl = Storage::disk('s3')->url($path);
        }

        Absen::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now('Asia/Makassar')->toDateString(),
            'check_in' => now('Asia/Makassar')->format('H:i:s'),
            'status' => $request->status,
            'dokumen' => $fileUrl, // Save the path returned by S3
            'approval_status' => in_array($request->status, ['Sakit', 'Izin']) ? 'Pending' : null,
        ]);

        return redirect()->route('absen')->with('success', 'Absensi berhasil dikirim.');
    }


}
