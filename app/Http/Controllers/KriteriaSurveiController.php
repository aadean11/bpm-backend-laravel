<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KriteriaSurvei;
use Barryvdh\DomPDF\Facade\Pdf;
use SweetAlert;

class KriteriaSurveiController extends Controller
{
    /**
     * Index
     * Menampilkan daftar Kriteria Survei dengan fitur pencarian dan paginasi
     */
    public function index(Request $request)
    {
        $query = KriteriaSurvei::query();
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ksr_nama', 'LIKE', "%{$search}%")
                ->orWhere('ksr_created_by', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter berdasarkan nama
        if ($request->filled('ksr_nama')) {
            $query->where('ksr_nama', 'LIKE', "%{$request->ksr_nama}%");
        }
        
        // Status filter
        if ($request->filled('ksr_status')) {
            $query->where('ksr_status', $request->ksr_status);
        } else {
            // By default, only show active records
            $query->where('ksr_status', 1);
        }
        
        $kriteria_survei = $query->paginate(10);
        
        return view('kriteriasurvei.index', [
            'kriteria_survei' => $kriteria_survei,
            'search' => $request->search,
            'ksr_nama' => $request->ksr_nama,
            'ksr_status' => $request->ksr_status,
        ]);
    }



    /**
     * Save
     * Menambahkan data Kriteria Survei baru
     */
    public function save(Request $request)
    {
        $request->validate([
            'ksr_nama' => 'required|string|max:50',
        ]);

        KriteriaSurvei::create([
            'ksr_nama' => $request->input('ksr_nama'),
            'ksr_status' => 1,  // 1 = Aktif
            'ksr_created_by' => 'retno.widiastuti',  // Data statis sementara
            'ksr_created_date' => now(),
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('KriteriaSurvei.index')->with('success', 'Kriteria Survei created successfully');
    }


    /**
     * Edit
     * Menampilkan data Kriteria Survei untuk diubah berdasarkan ID
     */
    public function edit($id)
    {
        // Ambil ID dari inputan
        $id = $request->input('ksr_id'); 
    
        // Cari data berdasarkan ID
        $kriteria_survei = KriteriaSurvei::find($id);
        if (!$kriteria_survei) {
            return redirect()->route('KriteriaSurvei.index')->with('error', 'Kriteria Survei not found');
        }

        return view('KriteriaSurvei.edit', compact('kriteriaSurvei'));
    }

    /**
     * Update
     * Mengupdate data Kriteria Survei berdasarkan ID
     */
    public function update(Request $request, $id)
    {
        $id = $request->input('ksr_id');
        $kriteria_survei = KriteriaSurvei::find($id);
        $kriteria_survei->ksr_nama = $request->input('ksr_nama');
        $kriteria_survei->save();

        return redirect()->route('KriteriaSurvei.index')->with('success', 'Kriteria berhasil diperbarui!');
    }

    /**
     * Delete
     * Menghapus data Kriteria Survei berdasarkan ID
     */
    public function delete(Request $request, $id)
    {
        // Cari data Kriteria Survei berdasarkan ID
        $kriteria_survei = KriteriaSurvei::find($id);

        // Validasi jika data tidak ditemukan
        if (!$kriteria_survei) {
            return redirect()->route('KriteriaSurvei.index')->with('error', 'Kriteria Survei not found');
        }

        // Update status menjadi nonaktif (0) dan tambahkan informasi modifikasi
        $kriteria_survei->update([
            'ksr_status' => 0,
            'ksr_modif_by' => 'ardhane', // Data dari input form
            'ksr_modif_date' => now(), // Tanggal saat ini
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('KriteriaSurvei.index')->with('success', 'Kriteria Survei updated successfully');
    }

    // /**
    //  * Export PDF
    //  * Mengekspor daftar Kriteria Survei ke dalam format PDF
    //  */
    // public function exportPdf(Request $request)
    // {
    //     $query = $request->input('search'); // Ambil input pencarian
    //     $kriteriaSurvei = KriteriaSurvei::when($query, function ($queryBuilder, $search) {
    //         return $queryBuilder->where('ksr_nama', 'LIKE', "%{$search}%")
    //             ->orWhere('ksr_created_by', 'LIKE', "%{$search}%");
    //     })->get(); // Ambil semua data sesuai pencarian

    //     $pdf = Pdf::loadView('kriteria_survei_pdf', compact('kriteriaSurvei')); // Render view PDF
    //     return $pdf->download('kriteria_survei.pdf'); // Unduh PDF}
    //}
}