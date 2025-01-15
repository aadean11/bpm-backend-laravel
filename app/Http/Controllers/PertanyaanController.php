<?php

namespace App\Http\Controllers;

use App\Models\KriteriaSurvei;
use App\Models\SkalaPenilaian;
use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PertanyaanExport;
use Maatwebsite\Excel\Facades\Excel;

class PertanyaanController extends Controller
{
    /**
     * Menampilkan daftar pertanyaan.
     * Termasuk fitur pencarian, filter status, dan pengurutan berdasarkan tanggal pembuatan.
     */
    public function index(Request $request)
    {
        $query = Pertanyaan::query();

        // Filter pencarian berdasarkan kolom tertentu
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('pty_pertanyaan', 'LIKE', "%{$search}%")
                  ->orWhere('pty_status', 'LIKE', "%{$search}%")
                  ->orWhere('pty_created_by', 'LIKE', "%{$search}%")
                  ->orWhere('pty_created_date', 'LIKE', "%{$search}%")
                  ->orWhere('pty_isheader', 'LIKE', "%{$search}%")
                  ->orWhere('pty_isgeneral', 'LIKE', "%{$search}%")
                  ->orWhere('pty_modif_by', 'LIKE', "%{$search}%")
                  ->orWhere('pty_modif_date', 'LIKE', "%{$search}%")
                  ->orWhere('ksr_id', 'LIKE', "%{$search}%")
                  ->orWhere('skp_id', 'LIKE', "%{$search}%")
                  ->orWhere('pty_role_responden', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if ($request->filled('pty_status')) {
            $query->where('pty_status', $request->pty_status);
        } else {
            $query->where('pty_status', 1); // Default hanya menampilkan data aktif
        }

        // Pengurutan berdasarkan tanggal pembuatan
        if ($request->filled('pty_created_date_order')) {
            $query->orderBy('pty_created_date', $request->pty_created_date_order);
        } else {
            $query->orderBy('pty_created_date', 'asc'); // Default pengurutan
        }

        // Paginasi hasil pencarian
        $pertanyaan = $query->paginate(10);

        // Return ke view index dengan data yang difilter
        return view('Pertanyaan.index', compact('pertanyaan'))->with([
            'search' => $request->search,
            'pty_status' => $request->pty_status,
            'pty_created_date_order' => $request->pty_created_date_order
        ]);
    }

    /**
     * Menampilkan form untuk membuat pertanyaan baru.
     */
    public function create()
    {
        $kriteria_survei = KriteriaSurvei::all(); // Ambil semua data kriteria survei
        $skala_penilaian = SkalaPenilaian::all(); // Ambil semua data skala penilaian
        return view('pertanyaan.create', compact('kriteria_survei', 'skala_penilaian'));
    }

    /**
     * Menyimpan data pertanyaan baru.
     */
    public function save(Request $request)
    {
        // Validasi input form
        $request->validate([
            'pty_pertanyaan' => 'required|string|max:255',
            'pty_isheader' => 'nullable|boolean',  // Validasi checkbox
            'pty_isgeneral' => 'required|boolean', // Validasi radio button
            'ksr_id' => $request->pty_isgeneral == 0 ? 'required|exists:bpm_mskriteriasurvei,ksr_id' : 'nullable',
            'skp_id' => $request->pty_isgeneral == 0 ? 'required|exists:bpm_msskalapenilaian,skp_id' : 'nullable',
        ]);

        // Buat pertanyaan baru
        Pertanyaan::create([
            'pty_pertanyaan' => $request->pty_pertanyaan,
            'pty_isheader' => $request->has('pty_isheader') ? 1 : 0,  // Cek apakah checkbox dicentang
            'pty_isgeneral' => $request->pty_isgeneral,
            'pty_status' => 1,
            'pty_created_by' => auth()->user()->name ?? 'default_user',
            'pty_created_date' => now(),
            'pty_modif_by' => auth()->user()->name ?? 'default_user',
            'pty_modif_date' => now(),
            'ksr_id' => $request->pty_isgeneral == 0 ? $request->ksr_id : null,
            'skp_id' => $request->pty_isgeneral == 0 ? $request->skp_id : null,
        ]);

        return redirect()->route('Pertanyaan.index')->with('success', 'Pertanyaan berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit pertanyaan berdasarkan ID.
     */
    public function edit($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $kriteria_survei = KriteriaSurvei::all();
        $skala_penilaian = SkalaPenilaian::all();

        return view('Pertanyaan.edit', compact('pertanyaan', 'kriteria_survei', 'skala_penilaian'));
    }

    /**
     * Memperbarui data pertanyaan.
     */
    public function update(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        $pertanyaan->pty_isgeneral = $request->input('pty_isgeneral');
        $pertanyaan->pty_pertanyaan = $request->input('pty_pertanyaan');
        $pertanyaan->ksr_id = $request->input('ksr_id');
        $pertanyaan->skp_id = $request->input('skp_id');
        $pertanyaan->pty_isheader = $request->input('pty_isheader', 0); // Default 0 jika tidak dicentang

        $pertanyaan->save();

        return redirect()->route('Pertanyaan.index')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Menghapus data pertanyaan secara soft delete.
     */
    public function delete($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->update([
            'pty_status' => 0,
            'pty_modif_by' => auth()->user()->name ?? 'default_user',
            'pty_modif_date' => now(),
        ]);

        return redirect()->route('Pertanyaan.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }

    /**
     * Menampilkan detail pertanyaan berdasarkan ID.
     */
    public function detail($id)
    {
        $pertanyaan = Pertanyaan::find($id);

        if (!$pertanyaan) {
            return redirect()->route('Pertanyaan.index')->with('error', 'Pertanyaan tidak ditemukan.');
        }

        return view('Pertanyaan.detail', compact('pertanyaan'));
    }

    /**
     * Mengekspor data ke file Excel.
     */
    public function exportExcel(Request $request)
    {
        $query = Pertanyaan::query();

        if ($request->filled('search')) {
            $query->where('pty_pertanyaan', 'LIKE', "%{$request->search}%");
        }

        if ($request->filled('pty_status')) {
            $query->where('pty_status', $request->pty_status);
        }

        $pertanyaan = $query->where('pty_status', 1)->get();

        return Excel::download(new PertanyaanExport($pertanyaan), 'pertanyaan_survei.xlsx');
    }

    /**
     * Mengunduh template file Excel.
     */
    public function downloadTemplate()
    {
        $templateDokumen = 'Template_Kuesioner.xlsx';
        $filePath = storage_path('app/public/templates/' . $templateDokumen);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }
    }
}
