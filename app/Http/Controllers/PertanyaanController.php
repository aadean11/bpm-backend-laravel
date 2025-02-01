<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\KriteriaSurvei;
use App\Models\SkalaPenilaian;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PertanyaanExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PertanyaanController extends Controller
{
    /**
     * Menampilkan daftar pertanyaan dengan relasi kriteria dan skala penilaian.
     */
    public function index(Request $request)
{
    $query = Pertanyaan::with(['kriteria', 'skala']); // Eager loading untuk menghindari N+1 query

    // Filter pencarian
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('pty_pertanyaan', 'LIKE', "%{$search}%");
    }

    // Filter status
    if ($request->filled('pty_status')) {
        $query->where('pty_status', $request->pty_status);
    }

    $pertanyaan = $query->paginate(10);

    return view('Pertanyaan.index', compact('pertanyaan'));
}


    /**
     * Menampilkan form untuk membuat pertanyaan baru.
     */
    public function create()
    {
        $kriteria_survei = KriteriaSurvei::all();
        $skala_penilaian = SkalaPenilaian::all();
        return view('Pertanyaan.create', compact('kriteria_survei', 'skala_penilaian'));
    }

    /**
     * Menyimpan data pertanyaan baru.
     */
    public function save(Request $request)
    {
        // Validasi input

        $request->validate([
            'pty_pertanyaan' => 'required|string|max:255',
            'ksr_id' => 'required|exists:bpm_mskriteriasurvei,ksr_id',
            'skp_id' => 'required|exists:bpm_msskalapenilaian,skp_id',
        ]);

        $loggedInUsername = Session::get('karyawan.nama_lengkap');
    
        if (!$loggedInUsername) {
            return redirect()->route('login')->with('alert', 'Session telah berakhir. Silakan login kembali.');
        }

        // Simpan pertanyaan baru
        Pertanyaan::create([
            'pty_pertanyaan' => $request->pty_pertanyaan,
            'pty_status' => 1,
            'pty_created_by' => $loggedInUsername,
            'pty_created_date' => now(),
            'pty_modif_by' => $loggedInUsername,
            'pty_modif_date' => now(),
            'ksr_id' => $request->ksr_id,
            'skp_id' => $request->skp_id,
        ]);

        return redirect()->route('Pertanyaan.index')->with('success', 'Pertanyaan berhasil dibuat.');
    }

    /**
     * Menampilkan form edit pertanyaan.
     */
    public function edit($id)
    {
        $pertanyaan = Pertanyaan::with(['kriteria', 'skala'])->findOrFail($id);
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

        $request->validate([
            'pty_pertanyaan' => 'required|string|max:255',
            'ksr_id' => 'required|exists:bpm_mskriteriasurvei,ksr_id',
            'skp_id' => 'required|exists:bpm_msskalapenilaian,skp_id',
        ]);

        $pertanyaan->update([
            'pty_pertanyaan' => $request->pty_pertanyaan,
            'ksr_id' => $request->ksr_id,
            'skp_id' => $request->skp_id,
            'pty_modif_by' => Auth::user()->name ?? 'default_user',
            'pty_modif_date' => now(),
        ]);

        return redirect()->route('Pertanyaan.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Soft delete pertanyaan.
     */
    public function delete($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->update([
            'pty_status' => 0,
            'pty_modif_by' => Auth::user()->name ?? 'default_user',
            'pty_modif_date' => now(),
        ]);

        return redirect()->route('Pertanyaan.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }

    /**
     * Detail pertanyaan dengan informasi Kriteria dan Skala.
     */
    public function detail($id)
    {
        $pertanyaan = Pertanyaan::with(['kriteria', 'skala'])->findOrFail($id);
        return view('Pertanyaan.detail', compact('pertanyaan'));
    }

    /**
     * Ekspor data pertanyaan ke Excel.
     */
    public function exportExcel(Request $request)
    {
        $query = Pertanyaan::with(['kriteria', 'skala'])->where('pty_status', 1);

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('pty_pertanyaan', 'LIKE', "%{$request->search}%");
        }

        // Filter status
        if ($request->filled('pty_status')) {
            $query->where('pty_status', $request->pty_status);
        }

        $pertanyaan = $query->get();

        return Excel::download(new PertanyaanExport($pertanyaan), 'pertanyaan_survei.xlsx');
    }

    /**
     * Download template Excel
     */
    public function downloadTemplate()
    {
        $filePath = storage_path('app/public/templates/Template_Kuesioner.xlsx');

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }
    }
}
