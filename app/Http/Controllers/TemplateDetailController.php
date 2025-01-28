<?php

namespace App\Http\Controllers;

use App\Models\TemplateDetail;
use App\Models\TemplateSurvei;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TemplateDetailExport;
use Maatwebsite\Excel\Facades\Excel;

class TemplateDetailController extends Controller
{
    /**
     * Menampilkan daftar detail template survei.
     * Termasuk fitur pencarian, filter status, dan pengurutan berdasarkan tanggal pembuatan.
     */
    public function index(Request $request)
    {
        $query = TemplateDetail::query();

        // Filter pencarian berdasarkan kolom tertentu
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tsd_pertanyaan', 'LIKE', "%{$search}%")
                    ->orWhere('tsd_status', 'LIKE', "%{$search}%")
                    ->orWhere('tsd_created_by', 'LIKE', "%{$search}%")
                    ->orWhere('tsd_created_date', 'LIKE', "%{$search}%")
                    ->orWhere('tsd_isheader', 'LIKE', "%{$search}%")
                    ->orWhere('tsd_jenis', 'LIKE', "%{$search}%")
                    ->orWhere('tsd_modif_by', 'LIKE', "%{$search}%")
                    ->orWhere('tsd_modif_date', 'LIKE', "%{$search}%")
                    ->orWhere('tsu_id', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if ($request->filled('tsd_status')) {
            $query->where('tsd_status', $request->tsd_status);
        } else {
            $query->where('tsd_status', 1); // Default hanya menampilkan data aktif
        }

        // Pengurutan berdasarkan tanggal pembuatan
        if ($request->filled('tsd_created_date_order')) {
            $query->orderBy('tsd_created_date', $request->tsd_created_date_order);
        } else {
            $query->orderBy('tsd_created_date', 'asc'); // Default pengurutan
        }

        // Paginasi hasil pencarian
        $templateDetails = $query->paginate(10);

        return view('TemplateDetail.index', compact('templateDetails'))->with([
            'search' => $request->search,
            'tsd_status' => $request->tsd_status,
            'tsd_created_date_order' => $request->tsd_created_date_order
        ]);
    }
    

    /**
     * Menampilkan form untuk membuat detail template survei baru.
     */
    public function create()
    {
        // Mengambil semua data Template Survei yang aktif
        $template_survei = TemplateSurvei::where('tsu_status', 1)->get();

        return view('TemplateDetail.create', [
            'template_survei' => $template_survei,
        ]);
    }

    /**
     * Menyimpan data ke dalam tabel bpm_mstemplatesurveidetail.
     */
    public function save(Request $request)
    {
        // Validasi input
        $request->validate([
            'tsu_id' => 'required|exists:bpm_mstemplatesurvei,tsu_id',
            'tsd_pertanyaan' => 'required|string|max:255',
            'tsd_isheader' => 'nullable|boolean',
            'tsd_jenis' => 'required|string|max:50',
        ], [
            'tsu_id.required' => 'Template survei harus dipilih.',
            'tsu_id.exists' => 'Template survei yang dipilih tidak valid.',
            'tsd_pertanyaan.required' => 'Pertanyaan wajib diisi.',
            'tsd_pertanyaan.string' => 'Pertanyaan harus berupa teks.',
            'tsd_pertanyaan.max' => 'Pertanyaan tidak boleh lebih dari 255 karakter.',
            'tsd_isheader.boolean' => 'Header harus berupa nilai boolean.',
            'tsd_jenis.required' => 'Jenis pertanyaan harus dipilih.',
            'tsd_jenis.string' => 'Jenis pertanyaan harus berupa teks.',
            'tsd_jenis.max' => 'Jenis pertanyaan tidak boleh lebih dari 50 karakter.',
        ]);

        // Menyimpan data
        TemplateDetail::create([
            'tsu_id' => $request->input('tsu_id'),
            'tsd_pertanyaan' => $request->input('tsd_pertanyaan'),
            'tsd_isheader' => $request->has('tsd_isheader') ? 1 : 0,
            'tsd_jenis' => $request->input('tsd_jenis'),
            'tsd_status' => 1, // Aktif
            'tsd_created_by' => 'retno.widiastuti', // Data statis sementara
            'tsd_created_date' => now(),
            'tsd_modif_by' => 'retno.widiastuti',
            'tsd_modif_date' => now(),
        ]);

        // Redirect ke halaman create dengan pesan sukses
        return redirect()->route('TemplateDetail.create')->with('success', 'Detail Template Survei berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit detail template survei berdasarkan ID.
     */
    public function edit($id)
{
    // Mengambil data Template Detail berdasarkan ID
    $templateDetail = TemplateDetail::findOrFail($id);

    // Mengambil semua data Template Survei yang aktif
    $template_survei = TemplateSurvei::where('tsu_status', 1)->get();

    // Mengirimkan data ke view
    return view('TemplateDetail.edit', [
        'templateDetail' => $templateDetail,
        'template_survei' => $template_survei,
    ]);
}


    /**
     * Memperbarui data detail template survei.
     */
    public function update(Request $request, $id)
{
    // Mengambil data Template Detail berdasarkan ID
    $templateDetail = TemplateDetail::findOrFail($id);

    // Validasi input
    $request->validate([
        'tsu_id' => 'required|exists:bpm_mstemplatesurvei,tsu_id',
        'tsd_pertanyaan' => 'required|string|max:255',
        'tsd_isheader' => 'nullable|boolean',
        'tsd_jenis' => 'required|string|max:50',
    ], [
        'tsu_id.required' => 'Template survei harus dipilih.',
        'tsu_id.exists' => 'Template survei yang dipilih tidak valid.',
        'tsd_pertanyaan.required' => 'Pertanyaan wajib diisi.',
        'tsd_pertanyaan.string' => 'Pertanyaan harus berupa teks.',
        'tsd_pertanyaan.max' => 'Pertanyaan tidak boleh lebih dari 255 karakter.',
        'tsd_isheader.boolean' => 'Header harus berupa nilai boolean.',
        'tsd_jenis.required' => 'Jenis pertanyaan harus dipilih.',
        'tsd_jenis.string' => 'Jenis pertanyaan harus berupa teks.',
        'tsd_jenis.max' => 'Jenis pertanyaan tidak boleh lebih dari 50 karakter.',
    ]);

    // Update data
    $templateDetail->update([
        'tsu_id' => $request->input('tsu_id'),
        'tsd_pertanyaan' => $request->input('tsd_pertanyaan'),
        'tsd_isheader' => $request->has('tsd_isheader') ? 1 : 0,
        'tsd_jenis' => $request->input('tsd_jenis'),
        'tsd_modif_by' => 'retno.widiastuti', // Data statis sementara
        'tsd_modif_date' => now(),
    ]);

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('TemplateDetail.index')->with('success', 'Detail Template Survei berhasil diperbarui.');
}


    /**
     * Menghapus data detail template survei secara soft delete.
     */
    public function delete($id)
    {
        $templateDetail = TemplateDetail::findOrFail($id);
        $templateDetail->update([
            'tsd_status' => 0,
            'tsd_modif_by' => 'retno.widiastuti',
            'tsd_modif_date' => now(),
        ]);

        return redirect()->route('TemplateDetail.index')->with('success', 'Detail Template Survei berhasil dihapus.');
    }

    /**
     * Mengekspor data ke file Excel.
     */
    public function exportExcel(Request $request)
    {
        $query = TemplateDetail::query();

        if ($request->filled('search')) {
            $query->where('tsd_pertanyaan', 'LIKE', "%{$request->search}%");
        }

        if ($request->filled('tsd_status')) {
            $query->where('tsd_status', $request->tsd_status);
        }

        $templateDetails = $query->where('tsd_status', 1)->get();

        // return Excel::download(new TemplateDetailExport($templateDetails), 'template_detail_survei.xlsx');
    }

    /**
     * Mengunduh template file Excel.
     */
    public function downloadTemplate()
    {
        $templateDokumen = 'Template_Detail_Survei.xlsx';
        $filePath = storage_path('app/public/templates/' . $templateDokumen);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }
    }
    public function detail($id)
{
    // Cari detail berdasarkan ID
    $detail = TemplateDetail::find($id);

    // Jika tidak ditemukan, kembalikan pesan error
    if (!$detail) {
        return redirect()->route('TemplateDetail.index')->with('error', 'Detail tidak ditemukan.');
    }

    // Kirim data ke view
    return view('TemplateDetail.detail', compact('detail'));
}

}


