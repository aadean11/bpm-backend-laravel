<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Session;

class KaryawanController extends Controller
{
    /**
     * Index
     * Menampilkan daftar karyawan dengan fitur pencarian dan filter.
     */
    public function index(Request $request)
    {
        $query = Karyawan::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kry_nama_lengkap', 'LIKE', "%{$search}%")
                  ->orWhere('kry_email', 'LIKE', "%{$search}%")
                  ->orWhere('kry_username', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if ($request->filled('kry_status_kary')) {
            $query->where('kry_status_kary', $request->kry_status_kary);
        } else {
            $query->where('kry_status_kary', 1); // Default hanya menampilkan karyawan aktif
        }

        $karyawan = $query->paginate(10);

        return view('karyawan.index', [
            'karyawan' => $karyawan,
            'search' => $request->search,
            'kry_status_kary' => $request->kry_status_kary,
        ]);
    }

    /**
     * Save
     * Menambahkan data karyawan baru.
     */
    public function save(Request $request)
{
    $karyawan = new Karyawan();
    $karyawan->kry_username = trim($request->kry_username); // trim to remove any whitespace
    $karyawan->kry_password = bcrypt($request->kry_password);
    $karyawan->kry_nama_lengkap = $request->kry_nama_lengkap;
    $karyawan->kry_email = $request->kry_email;
    $karyawan->kry_role = $request->kry_role;
    $karyawan->kry_status_kary = 1;
    $karyawan->kry_created_date = now();
    
    if($karyawan->save()) {
        return redirect()->route('Karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }
    
    return redirect()->back()->with('error', 'Gagal menambahkan karyawan.');
}
    /**
     * Edit
     * Menampilkan data karyawan untuk diubah berdasarkan ID.
     */
    public function edit(Request $request)
    {
        $id = $request->input('kry_id');

        $karyawan = Karyawan::find($id);
        if (!$karyawan) {
            return redirect()->route('Karyawan.index')->with('error', 'Karyawan tidak ditemukan.');
        }

        return view('karyawan.edit', compact('karyawan'));
    }

    /**
     * Update
     * Mengupdate data karyawan berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return redirect()->route('Karyawan.index')->with('error', 'Karyawan tidak ditemukan.');
        }

        $request->validate([
            'kry_username' => 'required|string|max:50|unique:mskaryawan,kry_username,' . $id . ',kry_id',
            'kry_nama_lengkap' => 'required|string|max:100',
            'kry_email' => 'required|email|max:100|unique:mskaryawan,kry_email,' . $id . ',kry_id',
            'kry_role' => 'required|string|max:20',
        ]);

        $modifBy = Session::get('karyawan.username');

        $karyawan->update([
            'kry_username' => $request->input('kry_username'),
            'kry_nama_lengkap' => $request->input('kry_nama_lengkap'),
            'kry_email' => $request->input('kry_email'),
            'kry_role' => $request->input('kry_role'),
            'kry_modif_by' => $modifBy,
            'kry_modif_date' => now(),
        ]);

        return redirect()->route('Karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Delete
     * Menghapus data karyawan dengan mengubah status menjadi nonaktif.
     */
    public function delete(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return redirect()->route('Karyawan.index')->with('error', 'Karyawan tidak ditemukan.');
        }

        $modifBy = Session::get('karyawan.username');

        $karyawan->update([
            'kry_status_kary' => 0, // Nonaktif
            'kry_modif_by' => $modifBy,
            'kry_modif_date' => now(),
        ]);

        return redirect()->route('Karyawan.index')->with('success', 'Karyawan berhasil dinonaktifkan.');
    }
}