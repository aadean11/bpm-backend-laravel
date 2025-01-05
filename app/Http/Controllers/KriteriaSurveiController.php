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
        $query = $request->input('search'); // Ambil input pencarian

        // Ambil data kriteria survei dengan filter pencarian, paginasi, dan status aktif (ksr_status = 1)
        $kriteria_survei = KriteriaSurvei::where('ksr_status', 1)
            ->when($query, function ($queryBuilder, $search) {
                return $queryBuilder->where('ksr_nama', 'LIKE', "%{$search}%")
                    ->orWhere('ksr_created_by', 'LIKE', "%{$search}%");
            })->paginate(10); // Paginate hasil

        // Kirim data ke view
        return view('KriteriaSurvei.index', [
            'kriteria_survei' => $kriteria_survei,
            'search' => $query
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
        $kriteriaSurvei = KriteriaSurvei::find($id);
        if (!$kriteriaSurvei) {
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
        $kriteria = KriteriaSurvei::find($id);
        $kriteria->ksr_nama = $request->input('ksr_nama');
        $kriteria->save();

        return redirect()->route('KriteriaSurvei.index')->with('success', 'Kriteria berhasil diperbarui!');
    }

    /**
     * Delete
     * Melakukan soft delete pada data Kriteria Survei berdasarkan ID
     */
    public function delete(Request $request, $id)
    {
        $request->validate([
            'ksr_nama' => 'required|string|max:50',
            'ksr_status' => 'required|integer',
            'ksr_modif_by' => 'nullable|string|max:50'
        ]);

        $kriteriaSurvei = KriteriaSurvei::find($id);
        if (!$kriteriaSurvei) {
            return redirect()->route('KriteriaSurvei.index')->with('error', 'Kriteria Survei not found');
        }

        $kriteriaSurvei->update([
            'ksr_nama' => $request->input('ksr_nama'),
            'ksr_status' => $request->input('ksr_status'),
            'ksr_modif_by' => $request->input('ksr_modif_by'),
            'ksr_modif_date' => now()
        ]);

        // Redirect to index page with success message
        return redirect()->route('KriteriaSurvei.index')->with('success', 'Kriteria Survei updated successfully');
    }

    /**
     * Delete
     * Menghapus data Kriteria Survei berdasarkan ID
     */
    public function delete(Request $request, $id)
    {
        $request->validate([    
            'ksr_nama' => 'required|string|max:50',
            'ksr_status' => 'required|integer',
            'ksr_modif_by' => 'nullable|string|max:50'
        ]);

        $kriteriaSurvei = KriteriaSurvei::find($id);
        if (!$kriteriaSurvei) {
            return redirect()->route('KriteriaSurvei.index')->with('error', 'Kriteria Survei not found');
        }

        $kriteriaSurvei->update([
            'ksr_nama' => $request->input('ksr_nama'),
            'ksr_status' => 0,
            'ksr_modif_by' => $request->input('ksr_modif_by'),
            'ksr_modif_date' => now()
        ]);

        // Redirect to index page with success message
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
    //     return $pdf->download('kriteria_survei.pdf'); // Unduh PDF
    // }
}
