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

        // Filter status karyawan
        if ($request->filled('kry_status_kary')) {
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
        // Validasi inputan
        $request->validate([
            'kry_username' => 'required|string|max:50',
            'kry_password' => 'required|string|min:1',
            'kry_nama_lengkap' => 'required|string|max:100',
            'kry_email' => 'required|string|max:100',
            'kry_role' => 'required|string|max:20',
        ]);
        // Pastikan session sudah ada
        if (!Session::has('karyawan.username')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Simpan data karyawan baru
        Karyawan::create([
            'kry_username' => trim($request->kry_username),
            'kry_password' => $request->kry_password,
            'kry_nama_lengkap' => $request->kry_nama_lengkap,
            'kry_email' => $request->kry_email,
            'kry_role' => $request->kry_role,
            'kry_status_kary' => 1, // Status aktif
            'kry_created_by' => Session::get('karyawan.username'),
            'kry_created_date' => now(),
        ]);

        // Redirect ke halaman daftar karyawan setelah berhasil
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Mengupdate data karyawan berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        // Validasi inputan
        $request->validate([
            'kry_username' => 'required|string|max:50|unique:mskaryawan,kry_username,' . $id . ',kry_id',
            'kry_nama_lengkap' => 'required|string|max:100',
            'kry_email' => 'required|email|max:100|unique:mskaryawan,kry_email,' . $id . ',kry_id',
            'kry_role' => 'required|string|max:20',
        ]);

        // Update data karyawan
        $karyawan->update([
            'kry_username' => $request->kry_username,
            'kry_nama_lengkap' => $request->kry_nama_lengkap,
            'kry_email' => $request->kry_email,
            'kry_role' => $request->kry_role,
            'kry_modif_by' => Session::get('karyawan.username'),
            'kry_modif_date' => now(),
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Menghapus data karyawan dengan mengubah status menjadi nonaktif.
     */
    public function delete($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $karyawan->update([
            'kry_status_kary' => 0, // Set status nonaktif
            'kry_modif_by' => Session::get('karyawan.username'),
            'kry_modif_date' => now(),
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dinonaktifkan.');
    }
}
