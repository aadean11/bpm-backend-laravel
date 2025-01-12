<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'kry_username' => 'required|string',
            'kry_password' => 'required|string',
        ]);

        // Attempt login
        if (Auth::attempt(['username' => $request->kry_username, 'password' => $request->kry_password])) {
            // Redirect ke halaman utama setelah login sukses
            return redirect()->route('dashboard')->with('alert', 'Login berhasil!');
        }

        // Jika gagal login
        return back()->with('alert', 'Username atau password salah.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form')->with('alert', 'Anda telah logout.');
    }
}
