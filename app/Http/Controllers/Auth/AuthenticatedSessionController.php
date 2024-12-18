<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    // Menampilkan halaman login
    public function create()
    {
        return view('login');
    }

    // Menangani login
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => ['required', 'username'],
            'password' => ['required', 'string'],
        ]);

        // Cek kredensial
        if (Auth::attempt($request->only('username', 'password'))) {
            // Jika berhasil login, redirect ke halaman yang diinginkan
            return redirect()->intended('/indexs');
        }

        // Jika gagal login, kembali dengan pesan error
        return back()->withErrors([
            'username' => 'username atau password salah.',
        ]);
    }

    // Menangani logout
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
