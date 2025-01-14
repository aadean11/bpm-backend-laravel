<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthKaryawan
{
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah session 'karyawan' ada
        if (!Session::has('karyawan')) {
            return redirect()->route('login')->with('alert', 'Silakan login terlebih dahulu.');
        }

        // Periksa apakah user memiliki akses ke halaman tertentu (opsional)
        $currentRouteName = $request->route()->getName(); // Nama rute saat ini
        $karyawan = Session::get('karyawan');

        // Logika tambahan: batasi akses berdasarkan peran (opsional)
        if ($currentRouteName === 'index' && $karyawan['role'] !== 'admin') {
            return redirect()->route('login')->with('alert', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
