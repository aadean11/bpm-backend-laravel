<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'kry_username' => 'required|string',
            'kry_password' => 'required|string',
        ]);

        try {
            // Query the database to find the user
            $user = DB::table('mskaryawan')
                ->where('kry_username', $request->kry_username)
                ->where('kry_status_kary', 1)  // Only active employees
                ->first();

            // Check if user exists and password matches
            if ($user && $request->kry_password === $user->kry_password) {
                // Store user data in session
                $request->session()->put('user', [
                    'kry_id' => $user->kry_id,
                    'kry_username' => $user->kry_username,
                    'kry_nama_lengkap' => $user->kry_nama_lengkap,
                    'kry_role' => $user->kry_role
                ]);

                // Redirect to dashboard with success message
                return redirect()->route('index')->with('alert', 'Login berhasil!');
            }

            // If authentication fails
            return back()->with('alert', 'Username atau password salah!');

        } catch (\Exception $e) {
            return back()->with('alert', 'Terjadi kesalahan saat login: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->flush();
        return redirect()->route('login')->with('alert', 'Berhasil logout!');
    }
}