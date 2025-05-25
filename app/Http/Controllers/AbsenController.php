<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absen;
use Illuminate\Http\Request;

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
                    ->orWhere('check_out', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->paginate(5)
            ->withQueryString();
        return view('absen.index', compact('absens', 'users'));
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
}
