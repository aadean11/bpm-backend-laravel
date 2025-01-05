<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemplateSurvei;
use App\Models\KriteriaSurvei;
use App\Models\SkalaPenilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use SweetAlert;

class TemplateSurveiController extends Controller
{
    /**
     * Index
     * Menampilkan daftar Template Survei dengan fitur pencarian dan paginasi
     */
    public function index(Request $request)
    {
        $query = $request->input('search'); // Ambil input pencarian

        // Ambil data template survei dengan filter pencarian, paginasi, dan status aktif (tsu_status = 1)
        $template_survei = TemplateSurvei::where('tsu_status', 1)
            ->when($query, function ($queryBuilder, $search) {
                return $queryBuilder->where('tsu_nama', 'LIKE', "%{$search}%")
                    ->orWhere('tsu_created_by', 'LIKE', "%{$search}%");
            })->paginate(10);

        $kriteria_survei = KriteriaSurvei::all(); // Ambil data Kriteria Survei
        $skala_penilaian = SkalaPenilaian::all(); // Ambil data Skala Penilaian

        return view('TemplateSurvei.index', [
            'template_survei' => $template_survei,
            'kriteria_survei' => $kriteria_survei,
            'skala_penilaian' => $skala_penilaian,
            'search' => $query
        ]);
    }



    /**
     * Save
     * Menambahkan data Template Survei baru
     */
    public function save(Request $request)
    {
        $request->validate([
            'tsu_nama' => 'required|string|max:50',
            'ksr_id' => 'required|integer',
            'skp_id' => 'required|integer',
        ]);

        TemplateSurvei::create([
            'tsu_nama' => $request->input('tsu_nama'),
            'tsu_status' => 1,  // 1 = Aktif
            'tsu_created_by' => 'retno.widiastuti',  // Data statis sementara
            'tsu_created_date' => now(),
            'ksr_id' => $request->input('ksr_id'),
            'skp_id' => $request->input('skp_id'),
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('TemplateSurvei.index')->with('success', 'Template Survei created successfully');
    }


    /**
     * Edit
     * Menampilkan data Template Survei untuk diubah berdasarkan ID
     */
    public function edit($id)
    {
        $templateSurvei = TemplateSurvei::find($id);
        if (!$templateSurvei) {
            return redirect()->route('TemplateSurvei.index')->with('error', 'Template Survei not found');
        }

        return view('TemplateSurvei.edit', compact('templateSurvei'));
    }

    /**
     * Update
     * Mengupdate data Template Survei berdasarkan ID
     */
    public function update(Request $request, $id)
    {
        $template = TemplateSurvei::find($id);
        $template->update([
            'tsu_nama' => $request->input('tsu_nama'),
            'ksr_id' => $request->input('ksr_id'),
            'skp_id' => $request->input('skp_id'),
            'tsu_modif_by' => 'retno.widiastuti',
            'tsu_modif_date' => now(),
        ]);

        return redirect()->route('TemplateSurvei.index')->with('success', 'Template Survei berhasil diperbarui!');
    }

    /**
     * Delete
     * Melakukan soft delete pada data Template Survei berdasarkan ID
     */
    public function delete($id)
    {
        $templateSurvei = TemplateSurvei::find($id);
        if (!$templateSurvei) {
            return redirect()->route('TemplateSurvei.index')->with('error', 'Template Survei not found');
        }

        // Soft delete dengan mengubah status menjadi 0
        $templateSurvei->update([
            'tsu_status' => 0,
            'tsu_modif_by' => 'retno.widiastuti', // Data statis sementara
            'tsu_modif_date' => now()
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('TemplateSurvei.index')->with('success', 'Template Survei deleted successfully');
    }


    // /**
    //  * Export PDF
    //  * Mengekspor daftar Template Survei ke dalam format PDF
    //  */
    // public function exportPdf(Request $request)
    // {
    //     $query = $request->input('search'); // Ambil input pencarian
    //     $templateSurvei = TemplateSurvei::when($query, function ($queryBuilder, $search) {
    //         return $queryBuilder->where('tsu_nama', 'LIKE', "%{$search}%")
    //             ->orWhere('tsu_created_by', 'LIKE', "%{$search}%");
    //     })->get(); // Ambil semua data sesuai pencarian

    //     $pdf = Pdf::loadView('template_survei_pdf', compact('templateSurvei')); // Render view PDF
    //     return $pdf->download('template_survei.pdf'); // Unduh PDF
    // }
}
