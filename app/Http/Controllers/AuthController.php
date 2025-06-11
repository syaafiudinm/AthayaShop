<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(){

        $roles = ['admin', 'cashier', 'owner'];

        return view('auth.register', compact('roles'));
    }

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

    public function login(){

        if (Auth::check()) {
            // Jika ada, logout user yang saat ini aktif
            return redirect()->route('beranda')->with('error', 'you have to logout first');
        }

        return view('auth.login');
    }

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
