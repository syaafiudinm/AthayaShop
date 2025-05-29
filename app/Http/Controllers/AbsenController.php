<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenController extends Controller
{
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
            ->paginate(5)
            ->withQueryString();

        // data kehadiran //
        $tanggal = Carbon::now('Asia/Makassar')->toDateString();
        $totalUsers = User::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalKasir = User::where('role', 'cashier')->count();
        $hadirCount = Absen::where('tanggal', $tanggal)
            ->where('status', 'Hadir')
            ->count();
        $percent = $totalUsers > 0 ? round(($hadirCount / $totalUsers) * 100) : 0;
        return view('absen.index', compact('absens', 'users', 'totalUsers', 'hadirCount', 'percent', 'tanggal', 'totalAdmin', 'totalKasir'));
    }

    public function verify($token)
    {
        $witaNow = now('Asia/Makassar');
        $user = User::where('qr_code', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'QR Code tidak valid'], 404);
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

    public function uploadDokumen(Request $request)
    {
        $request->validate([
            'status' => 'required|in:Sakit,Izin',
            'dokumen' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = Auth::user();
        $today = now('Asia/Makassar')->toDateString();

        $existing = Absen::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($existing) {
            return back()->with('error', 'Kamu sudah melakukan absensi hari ini.');
        }

        $path = $request->file('dokumen')->store('dokumen-absen', 'public');

        Absen::create([
            'user_id' => $user->id,
            'tanggal' => $today,
            'status' => $request->status,
            'dokumen' => $path,
            'check_in' => null, // karena bukan Hadir
        ]);

        return back()->with('success', 'Dokumen berhasil dikirim. Status: ' . $request->status);
    }

}
