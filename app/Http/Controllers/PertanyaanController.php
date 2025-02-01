<?php
namespace App\Http\Controllers;

use App\Models\KriteriaSurvei;
use App\Models\SkalaPenilaian;
use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PertanyaanExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DetailBankPertanyaan;


class PertanyaanController extends Controller
{
    // Menampilkan daftar pertanyaan dengan filter pencarian, status, dan pengurutan
    public function index(Request $request)
{
    // Ambil semua data kriteria dan skala
    $kriteria_survei = KriteriaSurvei::all();
    $skala_penilaian = SkalaPenilaian::all();
    
    // Mulai query untuk Pertanyaan
    $query = Pertanyaan::query();

    // Filter berdasarkan pencarian teks
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('pty_pertanyaan', 'LIKE', "%{$search}%")
              ->orWhere('pty_status', 'LIKE', "%{$search}%")
              ->orWhere('pty_created_by', 'LIKE', "%{$search}%")
              ->orWhere('pty_created_date', 'LIKE', "%{$search}%")
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
    }

    // Filter berdasarkan Kriteria
    if ($request->filled('ksr_id')) {
        $query->where('ksr_id', $request->ksr_id);
    }

    // Filter berdasarkan Skala
    if ($request->filled('skp_id')) {
        $query->where('skp_id', $request->skp_id);
    }

    // Filter berdasarkan urutan tanggal pembuatan
    if ($request->filled('pty_created_date_order')) {
        $query->orderBy('pty_created_date', $request->pty_created_date_order);
    } else {
        // Default: urutkan berdasarkan tanggal pembuatan secara ascending
        $query->orderBy('pty_created_date', 'asc');
    }

    // Ambil hasil query dengan paginasi
    $pertanyaan = $query->paginate(10);

    // Kirim data ke view
    return view('Pertanyaan.index', compact('pertanyaan', 'kriteria_survei', 'skala_penilaian'))->with([
        'search' => $request->search,
        'pty_status' => $request->pty_status,
        'pty_created_date_order' => $request->pty_created_date_order,
        'ksr_id' => $request->ksr_id,
        'skp_id' => $request->skp_id,
    ]);
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
        // Validasi form
        $request->validate([
            'pty_pertanyaan' => 'required|string|max:255',
            'ksr_id' => 'required|exists:bpm_mskriteriasurvei,ksr_id',
            'skp_id' => 'required|exists:bpm_msskalapenilaian,skp_id',
        ]);

        // Mengambil data role responden
        $roles = $request->input('role_responden', []); // Jika tidak ada yang dipilih, set default sebagai array kosong

        // Menggabungkan array role_responden menjadi string
        $rolesString = implode(', ', $roles);

        // Membuat pertanyaan baru
        // Mengambil data pertanyaan yang baru disimpan
            $pertanyaan = Pertanyaan::create([
                'pty_pertanyaan' => $request->pty_pertanyaan,
                'pty_status' => 1,
                'pty_created_by' => auth()->user()->name ?? 'default_user',
                'pty_created_date' => now(),
                'pty_modif_by' => auth()->user()->name ?? 'default_user',
                'pty_modif_date' => now(),
                'ksr_id' => $request->ksr_id,
                'skp_id' => $request->skp_id,
                'pty_role_responden' => $rolesString
            ]);

           if (!auth()->check()) {
    return redirect()->route('login')->with('error', 'Anda harus login untuk melakukan aksi ini.');
        }

        $kry_id = auth()->user()->id;

        DetailBankPertanyaan::create([
            'pty_id' => $pertanyaan->pty_id,
            'kry_id' => $kry_id,
            'dtl_status' => 'active',
            'dtl_created_by' => auth()->user()->name,
            'dtl_created_date' => now(),
        ]);


        return redirect()->route('Pertanyaan.index')->with('success', 'Pertanyaan berhasil dibuat.');
    }

    public function edit($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $kriteria_survei = KriteriaSurvei::all();
        $skala_penilaian = SkalaPenilaian::all();

        return view('Pertanyaan.edit', compact('pertanyaan', 'kriteria_survei', 'skala_penilaian'));
    }

    // Memperbarui data pertanyaan
    public function update(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->pty_pertanyaan = $request->input('pty_pertanyaan');
        $pertanyaan->ksr_id = $request->input('ksr_id');
        $pertanyaan->skp_id = $request->input('skp_id');

        $pertanyaan->save();

        return redirect()->route('Pertanyaan.index')->with('success', 'Pertanyaan Data berhasil diperbarui');
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

    // Menampilkan detail pertanyaan
    public function detail($id)
    {
        $pertanyaan = Pertanyaan::find($id);

        if (!$pertanyaan) {
            return redirect()->route('Pertanyaan.index')->with('error', 'Pertanyaan tidak ditemukan.');
        }

        return view('Pertanyaan.detail', compact('pertanyaan'));
    }

    // Method untuk ekspor data ke Excel
    public function exportExcel(Request $request)
    {
        $query = Pertanyaan::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('pty_pertanyaan', 'LIKE', "%{$search}%");
        }

        if ($request->filled('pty_status')) {
            $query->where('pty_status', $request->pty_status);
        }

        $pertanyaan = $query->where('pty_status', 1)->get();

        return Excel::download(new PertanyaanExport($pertanyaan), 'pertanyaan_survei.xlsx');
    }

    // Method untuk mengunduh template
    public function downloadTemplate()
    {
        $templateDokumen = 'Template_Kuesioner.xlsx';
        $filePath = storage_path('app/public/templates/' . $templateDokumen);

        // Debugging check file path
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }
    }
    
}
