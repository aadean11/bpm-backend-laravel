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
    
    // Search filter
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('skp_skala', 'LIKE', "%{$search}%")
              ->orWhere('skp_deskripsi', 'LIKE', "%{$search}%")
              ->orWhere('skp_tipe', 'LIKE', "%{$search}%")
              ->orWhere('skp_created_by', 'LIKE', "%{$search}%");
        });
    }
    
    // Type filter
    if ($request->filled('skp_tipe')) {
        $query->where('skp_tipe', $request->skp_tipe);
    }
    
    // Status filter
    if ($request->filled('skp_status')) {
        $query->where('skp_status', $request->skp_status);
    } else {
        // By default, only show active records
        $query->where('skp_status', 1);
    }
    
    // Get distinct types for dropdown
    $tipe_options = SkalaPenilaian::select('skp_tipe')
        ->distinct()
        ->pluck('skp_tipe');
    
    $skala_penilaian = $query->paginate(10);
    
    return view('SkalaPenilaian.index', compact(
        'skala_penilaian',
        'tipe_options'
    ))->with([
        'search' => $request->search,
        'skp_tipe' => $request->skp_tipe,
        'skp_status' => $request->skp_status
    ]);

}


    /**
     * Save
     * Menambahkan data Skala Penilaian baru
     */
    public function save(Request $request)
    {
        $request->validate([
            'skp_skala' => 'required|integer',
            'skp_deskripsi' => 'required|string',
            'skp_tipe' => 'required|string|max:50',
        ]);
        
        $loggedInUsername = Session::get('karyawan.nama_lengkap');

        SkalaPenilaian::create([
            'skp_skala' => $request->input('skp_skala'),
            'skp_deskripsi' => $request->input('skp_deskripsi'),
            'skp_tipe' => $request->input('skp_tipe'),
            'skp_status' => 1,  // 1 = Aktif
            'skp_created_by' =>  $loggedInUsername, // Data statis sementara
            'skp_created_date' => now(),
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('SkalaPenilaian.index')->with('success', 'Skala Penilaian created successfully');
        
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

        return view('SkalaPenilaian.edit', compact('skalaPenilaian'));
    }

    public function add()
    {
        return view('SkalaPenilaian.add');
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
    ]);

    // Get logged in username from session
    $loggedInUsername = Session::get('karyawan.nama_lengkap');
    
    if (!$loggedInUsername) {
        return redirect()->route('login')->with('alert', 'Session telah berakhir. Silakan login kembali.');
    }

    $skalaPenilaian = SkalaPenilaian::find($id);
    if (!$skalaPenilaian) {
        return redirect()->route('SkalaPenilaian.index')->with('error', 'Skala Penilaian not found');
    }

    $skalaPenilaian->update([
        'skp_skala' => $request->input('skp_skala'),
        'skp_deskripsi' => $request->input('skp_deskripsi'),
        'skp_tipe' => $request->input('skp_tipe'),
        'skp_modif_by' => $loggedInUsername,
        'skp_modif_date' => now()
    ]);

    return redirect()->route('SkalaPenilaian.index')->with('success', 'Skala Penilaian updated successfully');
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
    $skalaPenilaian = SkalaPenilaian::find($id);
    if (!$skalaPenilaian) {
        return response()->json(['success' => false], 404);
    }

    $skalaPenilaian->update([
        'skp_status' => !$skalaPenilaian->skp_status,
        'skp_modif_by' => 'retno.widiastuti',
        'skp_modif_date' => now()
    ]);

    return response()->json(['success' => true]);
}
}
