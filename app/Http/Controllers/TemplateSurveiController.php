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

        // Ambil data template survei dengan filter status dan pencarian
        $template_survei = TemplateSurvei::whereIn('tsu_status', [0, 1]) // Filter tsu_status
            ->when($query, function ($queryBuilder, $search) {
                return $queryBuilder->where(function ($q) use ($search) {
                    $q->where('tsu_nama', 'LIKE', "%{$search}%")
                        ->orWhere('tsu_created_by', 'LIKE', "%{$search}%");
                });
            })
            ->paginate(10); // Paginate hasil

        if ($request->ajax()) {
            // Kembalikan hasil pencarian dalam format HTML
            return response()->json([
                'html' => view('TemplateSurvei._templateSurveiData', [
                    'template_survei' => $template_survei,
                ])->render()
            ]);
        }

        // Kirim data ke view
        return view('TemplateSurvei.index', [
            'template_survei' => $template_survei,
            'search' => $query
        ]);
    }
    public function create()
    {
        // Mengambil hanya data dengan status aktif
        $kriteria_survei = KriteriaSurvei::where('ksr_status', 1)->get();
        $skala_penilaian = SkalaPenilaian::where('skp_status', 1)->get();

        return view('TemplateSurvei.create', [
            'kriteria_survei' => $kriteria_survei,
            'skala_penilaian' => $skala_penilaian
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
        ], [
            'tsu_nama.required' => 'Nama template survei wajib diisi.',
            'tsu_nama.string' => 'Nama template survei harus berupa teks.',
            'tsu_nama.max' => 'Nama template survei tidak boleh lebih dari 50 karakter.',
            'ksr_id.required' => 'Kriteria survei harus dipilih.',
            'ksr_id.integer' => 'ID kriteria survei harus berupa angka.',
            'skp_id.required' => 'Skala penilaian harus dipilih.',
            'skp_id.integer' => 'ID skala penilaian harus berupa angka.',
        ]);

        TemplateSurvei::create([
            'tsu_nama' => $request->input('tsu_nama'),
            'tsu_status' => 0,  // 0 = Draft
            'tsu_created_by' => 'retno.widiastuti',  // Data statis sementara
            'tsu_created_date' => now(),
            'ksr_id' => $request->input('ksr_id'),
            'skp_id' => $request->input('skp_id'),
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('TemplateSurvei.index')->with('success', 'Template Survei berhasil dibuat.');
    }

    /**
     * Buat Template Detail
     * Menambahkan data Pertanyaan untuk Template Survei
     */
    public function ajaxSave(Request $request)
    {
        // Validasi input
        $request->validate([
            'tsu_nama' => 'required|string|max:255',
            'ksr_id' => 'required|exists:kriteria_survei,ksr_id',
            'skp_id' => 'required|exists:skala_penilaian,skp_id',
        ]);

        // Simpan data template
        $template = TemplateSurvei::create([
            'tsu_nama' => $request->tsu_nama,
            'ksr_id' => $request->ksr_id,
            'skp_id' => $request->skp_id,
        ]);

        // Kembalikan data template sebagai response JSON
        return response()->json([
            'success' => true,
            'template' => $template,
            'message' => 'Template berhasil disimpan. Anda dapat menambahkan pertanyaan.',
        ]);
    }


    /**
     * Edit
     * Menampilkan data Template Survei untuk diubah berdasarkan ID
     */
    public function edit($id)
    {
        // Ambil data kriteria survei dan skala penilaian
        $kriteria_survei = KriteriaSurvei::all();
        $skala_penilaian = SkalaPenilaian::all();

        // Cari template survei berdasarkan ID
        $templateSurvei = TemplateSurvei::find($id);
        if (!$templateSurvei) {
            return redirect()->route('TemplateSurvei.index')->with('error', 'Template Survei tidak ditemukan.');
        }

        // Kirim data ke view
        return view('TemplateSurvei.edit', compact('templateSurvei', 'kriteria_survei', 'skala_penilaian'));
    }

    /**
     * Update
     * Mengupdate data Template Survei berdasarkan ID
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tsu_nama' => 'required|string|max:50',
            'ksr_id' => 'required|integer',
            'skp_id' => 'required|integer',
        ], [
            'tsu_nama.required' => 'Nama template survei wajib diisi.',
            'tsu_nama.string' => 'Nama template survei harus berupa teks.',
            'tsu_nama.max' => 'Nama template survei tidak boleh lebih dari 50 karakter.',
            'ksr_id.required' => 'Kriteria survei harus dipilih.',
            'ksr_id.integer' => 'ID kriteria survei harus berupa angka.',
            'skp_id.required' => 'Skala penilaian harus dipilih.',
            'skp_id.integer' => 'ID skala penilaian harus berupa angka.',
        ]);

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
     * Finalize
     * Mengubah status Template Survei menjadi Final
     */
    public function final($id)
    {
        $templateSurvei = TemplateSurvei::find($id);
        if (!$templateSurvei) {
            return redirect()->route('TemplateSurvei.index')->with('error', 'Template Survei tidak ditemukan.');
        }

        $templateSurvei->update([
            'tsu_status' => 1, // Final
            'tsu_modif_by' => 'retno.widiastuti', // Data statis sementara
            'tsu_modif_date' => now(),
        ]);

        return redirect()->route('TemplateSurvei.index')->with('success', 'Template Survei berhasil difinalisasi.');
    }

    /**
     * Detail
     * Menampilkan detail Template Survei
     */
    public function detail($id)
    {
        $templateSurvei = TemplateSurvei::find($id);
        if (!$templateSurvei) {
            return redirect()->route('TemplateSurvei.index')->with('error', 'Template Survei tidak ditemukan.');
        }

        return view('TemplateSurvei.detail', compact('templateSurvei'));
    }

    /**
     * Delete
     * Melakukan soft delete pada data Template Survei berdasarkan ID
     */
    public function delete($id)
    {
        $templateSurvei = TemplateSurvei::find($id);
        if (!$templateSurvei) {
            return redirect()->route('TemplateSurvei.index')->with('error', 'Template Survei tidak ditemukan.');
        }

        // Soft delete dengan mengubah status menjadi 2 (Tidak Aktif)
        $templateSurvei->update([
            'tsu_status' => 2, // Mengubah status menjadi "Tidak Aktif"
            'tsu_modif_by' => 'retno.widiastuti', // Data statis sementara
            'tsu_modif_date' => now()
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('TemplateSurvei.index')->with('success', 'Template Survei berhasil dinonaktifkan.');
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