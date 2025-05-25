<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absen;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    public function index(){
        $users = User::all();
        

        return view('absen.index');
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
