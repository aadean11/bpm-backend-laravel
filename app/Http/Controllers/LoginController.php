<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); // Sesuaikan dengan nama file view Anda
    }

    public function processLogin(Request $request)
    {
        $request->validate([
            'kry_username' => 'required|string',
            'kry_password' => 'required|string',
        ]);

        // Cari karyawan berdasarkan username dan status aktif
        $karyawan = Karyawan::where('kry_username', $request->kry_username)
            ->where('kry_status_kary', 1) // Pastikan hanya karyawan aktif
            ->first();

        // Cek jika karyawan ditemukan dan password cocok
        if ($karyawan && $request->kry_password == $karyawan->kry_password) {
            // Simpan data ke session
            Session::put('karyawan', [
                'id' => $karyawan->kry_id,
                'nama_lengkap' => $karyawan->kry_nama_lengkap,
                'role' => $karyawan->kry_role,
            ]);

            return redirect()->route('index')->with('alert', 'Login berhasil!');
        }

        // Jika login gagal
        return redirect()->back()->with('alert', 'Username atau password salah.');
    }

    public function logout()
    {
        Session::forget('karyawan');
        return redirect()->route('login')->with('alert', 'Anda telah logout.');
    }
}
