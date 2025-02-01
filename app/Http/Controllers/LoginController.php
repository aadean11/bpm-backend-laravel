<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
{
    $request->validate([
        'kry_username' => 'required|string',
        'kry_password' => 'required|string',
    ]);

    $karyawan = Karyawan::where('kry_username', $request->kry_username)
        ->where('kry_status_kary', 1)
        ->first();

    if ($karyawan && $request->kry_password == $karyawan->kry_password) {
        Session::put('karyawan', [
            'id' => $karyawan->kry_id,
            'nama_lengkap' => $karyawan->kry_nama_lengkap,
            'role' => $karyawan->kry_role,
        ]);
        return redirect('/index');
    }
    return redirect()->back()->with('alert', 'Username atau password salah.');
}

    public function logout(Request $request)
    {
        $nama = Session::get('karyawan.nama_lengkap');
        Session::forget('karyawan');
        
        return redirect()->route('login')
            ->with('alert', 'Terima kasih ' . $nama . ', Anda telah berhasil logout.')
            ->with('alert_type', 'success');
    }
}