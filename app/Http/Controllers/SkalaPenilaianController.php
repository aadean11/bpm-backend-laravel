<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SkalaPenilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use SweetAlert;

class SkalaPenilaianController extends Controller
{
   
    public function index(Request $request)
    {
        $query = $request->input('search'); // Ambil input pencarian

        // Ambil data skala penilaian dengan filter pencarian dan paginasi
        $skala_penilaian = SkalaPenilaian::when($query, function ($queryBuilder, $search) {
            return $queryBuilder->where('skp_skala', 'LIKE', "%{$search}%")
                ->orWhere('skp_deskripsi', 'LIKE', "%{$search}%")
                ->orWhere('skp_created_by', 'LIKE', "%{$search}%");
        })->where('skp_status', 1)->paginate(10); // Hanya ambil yang aktif dan paginate hasil

        // Kirim data ke view
        return view('SkalaPenilaian.index', [
            'skala_penilaian' => $skala_penilaian,
            'search' => $query
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

        SkalaPenilaian::create([
            'skp_skala' => $request->input('skp_skala'),
            'skp_deskripsi' => $request->input('skp_deskripsi'),
            'skp_tipe' => $request->input('skp_tipe'),
            'skp_status' => 1,  // 1 = Aktif
            'skp_created_by' => 'retno.widiastuti',  // Data statis sementara
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
            'skp_status' => 'required|integer',
            'skp_modif_by' => 'nullable|string|max:50'
        ]);

        $skalaPenilaian = SkalaPenilaian::find($id);
        if (!$skalaPenilaian) {
            return redirect()->route('SkalaPenilaian.index')->with('error', 'Skala Penilaian not found');
        }

        $skalaPenilaian->update([
            'skp_skala' => $request->input('skp_skala'),
            'skp_deskripsi' => $request->input('skp_deskripsi'),
            'skp_tipe' => $request->input('skp_tipe'),
            'skp_status' => $request->input('skp_status'),
            'skp_modif_by' => $request->input('skp_modif_by'),
            'skp_modif_date' => now()
        ]);

        // Redirect to index page with success message
        return redirect()->route('SkalaPenilaian.index')->with('success', 'Skala Penilaian updated successfully');
    }

    /**
     * Delete (Soft Delete)
     * Menghapus data Skala Penilaian berdasarkan ID
     */
    public function delete($id)
    {
        $skalaPenilaian = SkalaPenilaian::find($id);
        if (!$skalaPenilaian) {
            return redirect()->route('SkalaPenilaian.index')->with('error', 'Skala Penilaian not found');
        }

        $skalaPenilaian->update([
            'skp_status' => 0,  // Nonaktifkan (soft delete)
            'skp_modif_by' => 'retno.widiastuti',  // Data statis sementara
            'skp_modif_date' => now()
        ]);

        // Redirect to index page with success message
        return redirect()->route('SkalaPenilaian.index')->with('success', 'Skala Penilaian deleted successfully');
    }
}
