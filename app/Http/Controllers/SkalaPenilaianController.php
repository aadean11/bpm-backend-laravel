<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SkalaPenilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use SweetAlert;
use Illuminate\Support\Facades\Session;


class SkalaPenilaianController extends Controller
{
    public function index(Request $request)
{
    $query = SkalaPenilaian::query();

    // Filter berdasarkan pencarian
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('skp_skala', 'LIKE', "%{$search}%")
              ->orWhere('skp_deskripsi', 'LIKE', "%{$search}%")
              ->orWhere('skp_tipe', 'LIKE', "%{$search}%")
              ->orWhere('skp_created_by', 'LIKE', "%{$search}%");
        });
    }

    // Filter berdasarkan tipe
    if ($request->filled('skp_tipe')) {
        $query->where('skp_tipe', $request->skp_tipe);
    }

    // Filter berdasarkan status
    if ($request->filled('skp_status')) {
        if ($request->skp_status !== 'all') {
            $query->where('skp_status', $request->skp_status);
        }
    } else {
        $query->where('skp_status', 1); // default: hanya yang aktif
    }

    // Ambil daftar tipe unik untuk dropdown filter
    $tipe_options = SkalaPenilaian::select('skp_tipe')
        ->distinct()
        ->pluck('skp_tipe');

    // Hitung total aktif dan nonaktif
    $totalAktif = SkalaPenilaian::where('skp_status', 1)->count();
    $totalNonaktif = SkalaPenilaian::where('skp_status', 0)->count();
    $totalKeseluruhan = $totalAktif + $totalNonaktif;

    // Clone query sebelum paginasi
    $skala_penilaian = (clone $query)->paginate(10);

    return view('SkalaPenilaian.index', compact(
        'skala_penilaian', 'tipe_options', 
        'totalAktif', 'totalNonaktif', 'totalKeseluruhan'
    ))->with([
        'search' => $request->search,
        'skp_tipe' => $request->skp_tipe,
        'skp_status' => $request->skp_status
    ]);
}

public function save(Request $request)
{
    $request->validate([
        'skp_skala' => 'required|integer|max:10', // Memastikan skala tidak lebih dari 10
        'skp_deskripsi' => 'required|string|max:50', // Deskripsi maksimum 50 karakter
        'skp_tipe' => 'required|string|max:50',
    ], [
        'skp_skala.required' => 'Skala Penilaian harus diisi.',
        'skp_skala.integer' => 'Skala Penilaian harus berupa angka.',
        'skp_skala.max' => 'Skala Penilaian tidak boleh lebih dari 10.',
        'skp_deskripsi.required' => 'Deskripsi Skala Penilaian harus diisi.',
        'skp_deskripsi.string' => 'Deskripsi Skala Penilaian harus berupa teks.',
        'skp_tipe.required' => 'Tipe Skala Penilaian harus diisi.',
        'skp_tipe.string' => 'Tipe Skala Penilaian harus berupa teks.',
        'skp_tipe.max' => 'Tipe Skala Penilaian tidak boleh lebih dari 50 karakter.',
    ]);

    // Validasi jumlah kata dalam deskripsi
    $deskripsi = $request->input('skp_deskripsi');
    $wordCount = str_word_count($deskripsi);
    if ($wordCount > 50) {
        return back()
            ->withInput()
            ->withErrors(['skp_deskripsi' => 'Deskripsi tidak boleh lebih dari 50 kata.'])
            ->with('alert', [
                'type' => 'error',
                'message' => 'Deskripsi tidak boleh lebih dari 50 kata.'
            ]);
    }

    // Cek duplikasi data - untuk data aktif dan nonaktif
    $existingData = SkalaPenilaian::where('skp_tipe', $request->skp_tipe)
        ->where('skp_skala', $request->skp_skala)
        ->where('skp_deskripsi', $request->skp_deskripsi)
        ->first();

    if ($existingData) {
        $status = $existingData->skp_status ? 'aktif' : 'nonaktif';
        return back()
            ->withInput()
            ->withErrors([ 
                'duplicate' => "Data dengan tipe '{$request->skp_tipe}', skala '{$request->skp_skala}', dan deskripsi yang sama sudah ada dalam sistem ($status)."
            ])
            ->with('alert', [
                'type' => 'error',
                'message' => "Data dengan tipe '{$request->skp_tipe}', skala '{$request->skp_skala}', dan deskripsi yang sama sudah ada dalam sistem ($status)."
            ]);
    }

    $loggedInUsername = Session::get('karyawan.nama_lengkap');
    
    if (!$loggedInUsername) {
        return redirect()->route('login')
            ->with('alert', [
                'type' => 'error',
                'message' => 'Session telah berakhir. Silakan login kembali.'
            ]);
    }

    // Simpan data baru
    SkalaPenilaian::create([
        'skp_skala' => $request->input('skp_skala'),
        'skp_deskripsi' => $request->input('skp_deskripsi'),
        'skp_tipe' => $request->input('skp_tipe'),
        'skp_status' => 1,  // 1 = Aktif
        'skp_created_by' => $loggedInUsername,
        'skp_created_date' => now(),
    ]);

    return redirect()
        ->route('SkalaPenilaian.index')
        ->with('alert', [
            'type' => 'success',
            'message' => 'Skala Penilaian berhasil dibuat.'
        ]);
}

    /**
     * Edit
     * Menampilkan data Skala Penilaian untuk diubah berdasarkan ID
     */
    public function edit($id)
{
    $skalaPenilaian = SkalaPenilaian::find($id);
    if (!$skalaPenilaian) {
        return redirect()->route('SkalaPenilaian.index')->with('error', 'Skala Penilaian not found');
    }

    // Fetch all existing data for duplicate checking
    $existing_data = SkalaPenilaian::all();

    return view('SkalaPenilaian.edit', compact('skalaPenilaian', 'existing_data'));
}

    public function add()
{
    // Fetch all active and inactive data for duplicate checking
    $existing_data = SkalaPenilaian::all();
    return view('SkalaPenilaian.add', compact('existing_data'));
}

    /**
     * Update
     * Mengupdate data Skala Penilaian berdasarkan ID
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'skp_skala' => 'required|integer',
        'skp_deskripsi' => 'required|string',
        'skp_tipe' => 'required|string|max:50',
    ], [
        'skp_skala.required' => 'Skala Penilaian harus diisi.',
        'skp_skala.integer' => 'Skala Penilaian harus berupa angka.',
        'skp_deskripsi.required' => 'Deskripsi Skala Penilaian harus diisi.',
        'skp_deskripsi.string' => 'Deskripsi Skala Penilaian harus berupa teks.',
        'skp_tipe.required' => 'Tipe Skala Penilaian harus diisi.',
        'skp_tipe.string' => 'Tipe Skala Penilaian harus berupa teks.',
        'skp_tipe.max' => 'Tipe Skala Penilaian tidak boleh lebih dari 50 karakter.',
    ]);

    $loggedInUsername = Session::get('karyawan.nama_lengkap');
    
    if (!$loggedInUsername) {
        return redirect()->route('login')
            ->with('alert', [
                'type' => 'error',
                'message' => 'Session telah berakhir. Silakan login kembali.'
            ]);
    }

    $skalaPenilaian = SkalaPenilaian::find($id);
    if (!$skalaPenilaian) {
        return redirect()->route('SkalaPenilaian.index')
            ->with('alert', [
                'type' => 'error',
                'message' => 'Skala Penilaian tidak ditemukan.'
            ]);
    }

    // Cek duplikasi data, kecuali data saat ini
    $existingData = SkalaPenilaian::where('skp_tipe', $request->skp_tipe)
        ->where('skp_skala', $request->skp_skala)
        ->where('skp_deskripsi', $request->skp_deskripsi)
        ->where('skp_id', '!=', $id)
        ->first();

    if ($existingData) {
        $status = $existingData->skp_status ? 'aktif' : 'nonaktif';
        return back()
            ->withInput()
            ->withErrors([
                'duplicate' => "Data dengan tipe '{$request->skp_tipe}', skala '{$request->skp_skala}', dan deskripsi yang sama sudah ada dalam sistem ($status)."
            ])
            ->with('alert', [
                'type' => 'error',
                'message' => "Data dengan tipe '{$request->skp_tipe}', skala '{$request->skp_skala}', dan deskripsi yang sama sudah ada dalam sistem ($status)."
            ]);
    }

    $skalaPenilaian->update([
        'skp_skala' => $request->input('skp_skala'),
        'skp_deskripsi' => $request->input('skp_deskripsi'),
        'skp_tipe' => $request->input('skp_tipe'),
        'skp_modif_by' => $loggedInUsername,
        'skp_modif_date' => now()
    ]);

    return redirect()->route('SkalaPenilaian.index')
        ->with('alert', [
            'type' => 'success',
            'message' => 'Skala Penilaian berhasil diperbarui.'
        ]);
}
    public function detail($id)
    {
        // Find the SkalaPenilaian by ID
        $skalaPenilaian = SkalaPenilaian::find($id);
        
        // If not found, redirect back with error message
        if (!$skalaPenilaian) {
            return redirect()
                ->route('SkalaPenilaian.index')
                ->with('error', 'Skala Penilaian tidak ditemukan');
        }

        // Return the detail view with the data
        return view('SkalaPenilaian.detail', compact('skalaPenilaian'));
    }

    /**
     * Delete (Soft Delete)
     * Menghapus data Skala Penilaian berdasarkan ID
     */
    // public function delete($id)
    // {
    //     $skalaPenilaian = SkalaPenilaian::find($id);
    //     if (!$skalaPenilaian) {
    //         return redirect()->route('SkalaPenilaian.index')->with('error', 'Skala Penilaian not found');
    //     }

    //     $skalaPenilaian->update([
    //         'skp_status' => 0,  // Nonaktifkan (soft delete)
    //         'skp_modif_by' => 'retno.widiastuti',  // Data statis sementara
    //         'skp_modif_date' => now()
    //     ]);

    //     // Redirect to index page with success message
    //     return redirect()->route('SkalaPenilaian.index')->with('success', 'Skala Penilaian deleted successfully');
    // }

    // // In SkalaPenilaianController.php
// Di SkalaPenilaianController.php
public function toggleStatus($id)
{
    // Get logged in username from session
    $loggedInUsername = Session::get('karyawan.nama_lengkap');
        
    if (!$loggedInUsername) {
        return redirect()->route('login')->with('alert', 'Session telah berakhir. Silakan login kembali.');
    }

    $skalaPenilaian = SkalaPenilaian::find($id);
    if (!$skalaPenilaian) {
        return response()->json(['success' => false], 404);
    }

    $skalaPenilaian->update([
        'skp_status' => !$skalaPenilaian->skp_status,
        'skp_modif_by' => $loggedInUsername,
        'skp_modif_date' => now()
    ]);

    return response()->json(['success' => true]);
}
}
