<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'kry_username' => 'required|string',
            'kry_password' => 'required|string',
        ]);

        // Ambil input dari request
        $username = $request->input('kry_username');
        $password = $request->input('kry_password');

        try {
            // Panggil stored procedure bpm_login
            $result = DB::select('CALL bpm_login(?, ?)', [$username, $password]);

            // Periksa hasil dari stored procedure
            if (!empty($result)) {
                $message = $result[0]->message;

                if ($message === 'Login berhasil') {
                    // Login berhasil, arahkan ke halaman index
                    return view('index', ['alert' => 'Login berhasil!']);
                } else {
                    // Login gagal, tampilkan pesan error
                    return view('login', ['alert' => $message]);
                }
            } else {
                // Jika hasil dari prosedur kosong
                return view('login', ['alert' => 'Login gagal. Server tidak merespons.']);
            }
        } catch (\Exception $e) {
            // Tangani error
            return view('login', ['alert' => 'Terjadi kesalahan saat login: ' . $e->getMessage()]);
        }
    }
}
