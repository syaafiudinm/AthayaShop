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
        $totalPegawai = User::where('role', '!=', 'owner')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalKasir = User::where('role', 'cashier')->count();
        $hadirCount = Absen::where('tanggal', $tanggal)
            ->where('status', 'Hadir')
            ->count();
        $percent = $totalPegawai> 0 ? round(($hadirCount / $totalPegawai) * 100) : 0;
        return view('absen.index', compact('absens', 'users', 'totalPegawai', 'hadirCount', 'percent', 'tanggal', 'totalAdmin', 'totalKasir'));
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


    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:Hadir,Sakit,Izin',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('dokumen')) {
            $filePath = $request->file('dokumen')->store('dokumen', 'public');
        }

        Absen::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now('Asia/Makassar')->toDateString(),
            'check_in' => now('Asia/Makassar')->format('H:i:s'),
            'status' => $request->status,
            'dokumen' => $filePath,
            'approval_status' => in_array($request->status, ['Sakit', 'Izin']) ? 'Pending' : null,
        ]);

        return redirect()->route('absen')->with('success', 'Absensi berhasil dikirim.');
    }


}
