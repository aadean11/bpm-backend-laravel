<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    /**
     * Menampilkan daftar karyawan dengan pencarian dan filter.
     */
    public function index(Request $request)
{
    $query = Karyawan::query();

    // Pencarian
    $search = $request->search;
    if (!empty($search)) {
        $query->where('kry_nama_lengkap', 'LIKE', "%{$search}%")
              ->orWhere('kry_email', 'LIKE', "%{$search}%")
              ->orWhere('kry_username', 'LIKE', "%{$search}%");
    }

    if ($request->filled('kry_role')) {
        $query->where('kry_role', $request->kry_role);
    }else if ($request->filled('kry_status_kary')) {
        $query->where('kry_status_kary', $request->kry_status_kary);
    } else {
        $query->where('kry_status_kary', 1); // Default hanya menampilkan yang aktif
    }

    // Ambil data dengan pagination
    $karyawan = $query->paginate(10);

    return view('karyawan.index', compact('karyawan', 'search'));
}


    /**
     * Menyimpan data karyawan baru.
     */
    public function save(Request $request)
    {
        $request->validate([
            'kry_username' => 'required|string|max:50|unique:mskaryawan,kry_username',
            'kry_password' => 'required|string|min:6',
            'kry_nama_lengkap' => 'required|string|max:100',
            'kry_email' => 'required|email|max:100|unique:mskaryawan,kry_email',
            'kry_role' => 'required|string|max:20',
        ]);

        Karyawan::create([
            'kry_username' => trim($request->kry_username),
            'kry_password' => Hash::make($request->kry_password), // Simpan password dalam bentuk hash
            'kry_nama_lengkap' => $request->kry_nama_lengkap,
            'kry_email' => $request->kry_email,
            'kry_role' => $request->kry_role,
            'kry_status_kary' => 1,
            'kry_created_by' => Session::get('karyawan.username'),
            'kry_created_date' => now(),
        ]);

        return redirect()->route('Karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }
    /**
     * Mengupdate data karyawan berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $request->validate([
            'kry_username' => 'required|string|max:50|unique:mskaryawan,kry_username,' . $id . ',kry_id',
            'kry_email' => 'required|email|max:100|unique:mskaryawan,kry_email,' . $id . ',kry_id',
            'kry_nama_lengkap' => 'required|string|max:100',
            'kry_role' => 'required|string|max:20',
        ]);

        $karyawan->update([
            'kry_username' => $request->kry_username,
            'kry_email' => $request->kry_email,
            'kry_nama_lengkap' => $request->kry_nama_lengkap,
            'kry_role' => $request->kry_role,
            'kry_modif_by' => Session::get('karyawan.username'),
            'kry_modif_date' => now(),
        ]);

        return redirect()->route('Karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Menghapus data karyawan dengan mengubah status menjadi nonaktif.
     */
    public function delete($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $karyawan->update([
            'kry_status_kary' => 0,
            'kry_modif_by' => Session::get('karyawan.username'),
            'kry_modif_date' => now(),
        ]);

        return redirect()->route('Karyawan.index')->with('success', 'Karyawan berhasil dinonaktifkan.');
    }
}
