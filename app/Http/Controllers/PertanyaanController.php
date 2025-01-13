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
    // Menampilkan daftar pertanyaan
    public function index()
{
    $search = request()->get('search', '');
    $pertanyaan = Pertanyaan::with(['kriteria', 'skala'])
        ->where('pty_status', 1)  // Menambahkan kondisi untuk status = 1
        ->when($search, function ($query, $search) {
            $query->where('pty_pertanyaan', 'LIKE', "%$search%");
        })
        ->paginate(10);

    return view('Pertanyaan.index', compact('pertanyaan', 'search'));
}

    // Menampilkan form untuk membuat pertanyaan baru
    public function create()
    {
        $kriteria_survei = KriteriaSurvei::all();
        $skala_penilaian = SkalaPenilaian::all();
        return view('pertanyaan.create', compact('kriteria_survei', 'skala_penilaian'));
    }

    // Menyimpan data pertanyaan baru
    public function save(Request $request)
    {
        $request->validate([
            'pty_pertanyaan' => 'required|string|max:255',
            'pty_isheader' => 'required|boolean',
            'pty_isgeneral' => 'required|boolean',
            'ksr_id' => 'exists:bpm_mskriteriasurvei,ksr_id',
            'skp_id' => 'exists:bpm_msskalapenilaian,skp_id',
        ]);

        // $request->validate([
        //     'pty_pertanyaan' => 'required|string|max:255',
        //     'pty_isheader' => 'required|boolean',
        //     'pty_isgeneral' => 'required|boolean',
        //     'ksr_id' => 'required|exists:bpm_mskriteriasurvei,ksr_id',
        //     'skp_id' => 'required|exists:bpm_msskalapenilaian,skp_id',
        // ]);

        Pertanyaan::create([
            'pty_id' => $request->pty_id,
            'pty_pertanyaan' => $request->pty_pertanyaan,
            'pty_isheader' => $request->pty_isheader,
            'pty_isgeneral' => $request->pty_isgeneral,
            'pty_status' => 1,
            'pty_created_by' => auth()->user()->name ?? 'default_user',
            'pty_created_date' => now(),
            'pty_modif_by' => auth()->user()->name ?? 'default_user',
            'pty_modif_date' => now(),
            'ksr_id' => $request->ksr_id,
            'skp_id' => $request->skp_id,
        ]);

        return redirect()->route('Pertanyaan.index')->with('success', 'Pertanyaan berhasil dibuat.');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $kriteria_survei = KriteriaSurvei::all(); // Fetch all Kriteria Survei
        $skala_penilaian = SkalaPenilaian::all(); // Fetch all Skala Penilaian
    
        return view('Pertanyaan.edit', compact('pertanyaan', 'kriteria_survei', 'skala_penilaian'));
    }

    // Memperbarui data pertanyaan
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'pty_pertanyaan' => 'required|string|max:255',
            'pty_isheader' => 'required|boolean',
            'pty_isgeneral' => 'required|boolean',
            'ksr_id' => $request->pty_isgeneral ? 'nullable' : 'required|exists:bpm_mskriteriasurvei,ksr_id',
            'skp_id' => $request->pty_isgeneral ? 'nullable' : 'required|exists:bpm_msskalapenilaian,skp_id',
        ]);
    
        // Cari data berdasarkan ID
        $pertanyaan = Pertanyaan::findOrFail($id);
    
        // Update data
        $pertanyaan->pty_pertanyaan = $request->pty_pertanyaan;
        $pertanyaan->pty_isheader = $request->pty_isheader;
        $pertanyaan->pty_isgeneral = $request->pty_isgeneral;
        $pertanyaan->pty_status = 1;
        $pertanyaan->pty_modif_by = auth()->user()->name ?? 'default_user';
        $pertanyaan->pty_modif_date = now();
        $pertanyaan->ksr_id = $request->pty_isgeneral ? null : $request->ksr_id;
        $pertanyaan->skp_id = $request->pty_isgeneral ? null : $request->skp_id;
    
        // Simpan data
        $pertanyaan->save();
    
        // Redirect dengan pesan sukses
        return redirect()->route('Pertanyaan.index')->with('success', 'Data berhasil diperbarui.');
    }
    

    // Menghapus pertanyaan (soft delete)
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

    // // Mengekspor data pertanyaan ke PDF
    // public function exportPdf(Request $request)
    // {
    //     $search = $request->input('search');

    //     $pertanyaan = Pertanyaan::where('pty_status', 1)
    //         ->when($search, function ($query, $search) {
    //             $query->where('pty_pertanyaan', 'LIKE', "%$search%")
    //                   ->orWhere('pty_created_by', 'LIKE', "%$search%");
    //         })
    //         ->get();

    //     $pdf = Pdf::loadView('pertanyaan.pertanyaan_pdf', compact('pertanyaan'));
    //     return $pdf->download('pertanyaan.pdf');
    // }

        public function exportPdf()
        {
            // Ambil data dari database
            $pertanyaan = Pertanyaan::all();
    
            // Buat PDF menggunakan DomPDF
            $pdf = Pdf::loadView('pertanyaan_pdf', compact('pertanyaan'));
    
            // Kembalikan file PDF untuk diunduh
            return $pdf->download('pertanyaan_survei.pdf');
        }
    // Method untuk ekspor Excel
    public function exportExcel()
    {
        return Excel::download(new PertanyaanExport, 'pertanyaan_survei.xlsx');
    }
}

