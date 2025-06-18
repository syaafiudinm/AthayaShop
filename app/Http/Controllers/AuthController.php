<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Class AuthController
 *
 * Controller ini mengelola semua proses otentikasi pengguna, termasuk registrasi,
 * login, dan logout. Ini menangani validasi input pengguna, pembuatan akun,
 * proses otentikasi kredensial, dan penghancuran sesi saat logout.
 *
 * @package App\Http\Controllers
 */

class AuthController extends Controller
{

    /**
     * Menampilkan halaman formulir registrasi pengguna.
     *
     * Metode ini menyiapkan dan menampilkan view untuk pendaftaran akun baru,
     * serta mengirimkan daftar peran (roles) yang tersedia ke view.
     *
     * @return \Illuminate\View\View
     */

    public function register(){

        $roles = ['admin', 'cashier', 'owner'];

        return view('auth.register', compact('roles'));
    }

    /**
     * Menyimpan data pengguna baru dari formulir registrasi.
     *
     * Metode ini memvalidasi data yang dikirimkan dari formulir registrasi.
     * Jika validasi berhasil, ia akan membuat pengguna baru dengan data tersebut,
     * mengenkripsi password, dan menyimpannya ke database.
     *
     * @param \Illuminate\Http\Request $request Data dari formulir registrasi.
     * @return \Illuminate\Http\RedirectResponse
     */

    public function registerStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:admin,cashier,owner'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('login')->with('success', 'Account created successfully');
    }

    /**
     * Menampilkan halaman formulir login.
     *
     * Metode ini akan menampilkan halaman login jika pengguna belum terotentikasi.
     * Jika pengguna sudah login, ia akan dialihkan ke halaman beranda.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */

    public function login(){

        if (Auth::check()) {
            // Jika ada, logout user yang saat ini aktif
            return redirect()->route('beranda')->with('error', 'anda sudah login');
        }

        return view('auth.login');
    }

    /**
     * Mengotentikasi pengguna berdasarkan kredensial yang diberikan.
     *
     * Metode ini memvalidasi email dan password yang dikirim dari formulir login.
     * Jika kredensial valid dan cocok dengan data di database, sesi login
     * akan dibuat dan pengguna dialihkan ke halaman beranda.
     *
     * @param \Illuminate\Http\Request $request Kredensial login (email dan password).
     * @return \Illuminate\Http\RedirectResponse
     */

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            return redirect()->route('beranda');
        }else{
            return redirect()->route('login')->with('error', 'Either email or password is incorrect');
        }

    }

    /**
     * Mengeluarkan pengguna dari sesi aktif (logout).
     *
     * Metode ini akan menghapus sesi otentikasi pengguna yang sedang aktif,
     * membatalkan sesi lama, dan membuat token sesi baru untuk keamanan sebelum
     * mengalihkannya ke halaman login.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function logout(Request $request){
        if (Auth::check()) {
            Auth::logout();

            // Invalidate session lama dan buat token baru untuk keamanan
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return redirect()->route('login');
    }
}
