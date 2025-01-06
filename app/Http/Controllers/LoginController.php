<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        return view('login'); // Menampilkan halaman login
    }

    public function processLogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'kry_username' => 'required|string',
            'kry_password' => 'required|string',
        ]);

        // Ambil input dari form
        $username = $request->input('kry_username');
        $password = $request->input('kry_password');

        try {
            // Cek apakah username ada di database
            $user = Karyawan::where('kry_username', $username)->first();

            if ($user) {
                // Jika user ditemukan, periksa apakah password cocok
                if (Hash::check($password, $user->kry_password)) {
                    // Jika login berhasil, simpan data user ke session
                    Session::put('user_id', $user->kry_id);
                    Session::put('user_role', $user->kry_role);

                    // Arahkan ke halaman dashboard atau halaman yang diinginkan
                    return redirect()->route('dashboard')->with('alert', 'Login berhasil!');
                } else {
                    // Password tidak cocok
                    return redirect()->route('login')->with('alert', 'Password salah.')->withInput();
                }
            } else {
                // Username tidak ditemukan
                return redirect()->route('login')->with('alert', 'Username tidak ditemukan.')->withInput();
            }
        } catch (\Exception $e) {
            // Tangani jika terjadi error
            return redirect()->route('login')->with('alert', 'Terjadi kesalahan saat login: ' . $e->getMessage())->withInput();
        }
    }

    public function logout()
    {
        // Menghapus sesi user saat logout
        Session::forget('user_id');
        Session::forget('user_role');
        return redirect()->route('login')->with('alert', 'Anda telah logout.');
    }
}
