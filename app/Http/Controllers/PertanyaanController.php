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
use App\Models\DetailBankPertanyaan;
use App\Models\Karyawan;
use Illuminate\Validation\Rule;

class PertanyaanController extends Controller
{
    /**
     * Menampilkan daftar pertanyaan dengan relasi kriteria dan skala penilaian.
     */
    public function index(Request $request)
{
    // Get counts
    $totalAktif = Pertanyaan::where('pty_status', 1)->count();
    $totalNonaktif = Pertanyaan::where('pty_status', 0)->count();
    $totalKeseluruhan = Pertanyaan::count();

    $query = Pertanyaan::with(['kriteria', 'skala']);

    // Filter pencarian
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('pty_pertanyaan', 'LIKE', "%{$search}%");
    }

    // Filter status
    if ($request->filled('pty_status')) {
        if ($request->pty_status !== 'all') {  // Tambahkan kondisi ini
            $query->where('pty_status', $request->pty_status);
        }
    } else {
        $query->where('pty_status', 1); // Default tampilkan yang aktif saja
    }

    // Sorting berdasarkan tanggal
    if ($request->filled('pty_created_date_order')) {
        $orderDirection = $request->pty_created_date_order === 'asc' ? 'asc' : 'desc';
        $query->orderBy('pty_created_date', $orderDirection);
    } else {
        // Default sorting (jika tidak ada filter sorting yang dipilih)
        $query->orderBy('pty_created_date', 'desc');
    }

    $pertanyaan = $query->paginate(10);
    
    // Maintain query parameters pada pagination links
    $pertanyaan->appends([
        'search' => $request->search,
        'pty_status' => $request->pty_status,
        'pty_created_date_order' => $request->pty_created_date_order
    ]);

    return view('Pertanyaan.index', compact('pertanyaan', 'totalAktif', 'totalNonaktif', 'totalKeseluruhan'));
}


    /**
     * Menampilkan form untuk membuat pertanyaan baru.
     */
    public function create()
    {
        $kriteria_survei = KriteriaSurvei::all();
        $skala_penilaian = SkalaPenilaian::where('skp_status', 1)->get()->map(function ($skala) {
    return [
        'skp_id' => $skala->skp_id,
        'skp_deskripsi' => "{$skala->skp_skala} ({$skala->skp_deskripsi})"
    ];
});

    
        $karyawan = Karyawan::all(); // Ambil data karyawan untuk dipilih
    
        return view('Pertanyaan.create', compact('kriteria_survei', 'skala_penilaian', 'karyawan'));
    }
    


    /**
     * Menyimpan data pertanyaan baru.
     */
    public function save(Request $request)
    {
        $request->validate([
            'pty_pertanyaan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bpm_mspertanyaan', 'pty_pertanyaan')->where(function ($query) {
                    return $query->where('pty_status', 1);
                })
            ],
            'ksr_id' => 'required|exists:bpm_mskriteriasurvei,ksr_id',
            'skp_id' => 'required|exists:bpm_msskalapenilaian,skp_id',
            'kry_id' => 'required|exists:mskaryawan,kry_id',
        ], [
            'pty_pertanyaan.unique' => 'Pertanyaan ini sudah ada dalam database.',
            'pty_pertanyaan.required' => 'Pertanyaan harus diisi.',
            'pty_pertanyaan.max' => 'Pertanyaan tidak boleh lebih dari 255 karakter.',
            'ksr_id.required' => 'Kriteria survei harus dipilih.',
            'skp_id.required' => 'Skala penilaian harus dipilih.',
            'kry_id.required' => 'Responden harus dipilih.',
        ]);

        $loggedInUsername = Session::get('karyawan.nama_lengkap');
        
        if (!$loggedInUsername) {
            return redirect()->route('login')->with('alert', 'Session telah berakhir. Silakan login kembali.');
        }

        // Check for duplicate combination of question and criteria
        $existingQuestion = Pertanyaan::where('pty_pertanyaan', $request->pty_pertanyaan)
            ->where('ksr_id', $request->ksr_id)
            ->where('pty_status', 1)
            ->first();

        if ($existingQuestion) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['pty_pertanyaan' => 'Kombinasi pertanyaan dan kriteria survei ini sudah ada.']);
        }

        // Simpan pertanyaan baru
        $pertanyaan = Pertanyaan::create([
            'pty_pertanyaan' => $request->pty_pertanyaan,
            'pty_status' => 1,
            'pty_created_by' => $loggedInUsername,
            'pty_created_date' => now(),
            'pty_modif_by' => $loggedInUsername,
            'pty_modif_date' => now(),
            'ksr_id' => $request->ksr_id,
            'skp_id' => $request->skp_id,
        ]);

        // Simpan karyawan terkait ke dalam tabel DetailBankPertanyaan
        DetailBankPertanyaan::create([
            'pty_id' => $pertanyaan->pty_id,
            'kry_id' => $request->kry_id,
            'dtl_status' => 1,
            'dtl_created_by' => $loggedInUsername,
            'dtl_created_date' => now(),
            'dtl_modif_by' => $loggedInUsername,
            'dtl_modif_date' => now(),
        ]);

        return redirect()->route('Pertanyaan.index')->with('success', 'Pertanyaan dan Responden berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit pertanyaan.
     */
    public function edit($id)
    {
        $pertanyaan = Pertanyaan::with(['kriteria', 'skala', 'detailBankPertanyaan.karyawan'])->findOrFail($id);
        $kriteria_survei = KriteriaSurvei::all();
        $skala_penilaian = SkalaPenilaian::where('skp_status', 1)->get()->map(function ($skala) {
            return [
                'skp_id' => $skala->skp_id,
                'skp_deskripsi' => "{$skala->skp_skala} ({$skala->skp_deskripsi})"
            ];
        });
        

        $karyawan = Karyawan::all();

        return view('Pertanyaan.edit', compact('pertanyaan', 'kriteria_survei', 'skala_penilaian', 'karyawan'));
    }


    /**
     * Memperbarui data pertanyaan.
     */
    public function update(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        $request->validate([
            'pty_pertanyaan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bpm_mspertanyaan', 'pty_pertanyaan')
                    ->where(function ($query) {
                        return $query->where('pty_status', 1);
                    })
                    ->ignore($id, 'pty_id')
            ],
            'ksr_id' => 'required|exists:bpm_mskriteriasurvei,ksr_id',
            'skp_id' => 'required|exists:bpm_msskalapenilaian,skp_id',
            'kry_id' => 'required|array|min:1',
            'kry_id.*' => 'exists:mskaryawan,kry_id',
        ], [
            'pty_pertanyaan.unique' => 'Pertanyaan ini sudah ada dalam database.',
            'pty_pertanyaan.required' => 'Pertanyaan harus diisi.',
            'pty_pertanyaan.max' => 'Pertanyaan tidak boleh lebih dari 255 karakter.',
            'ksr_id.required' => 'Kriteria survei harus dipilih.',
            'skp_id.required' => 'Skala penilaian harus dipilih.',
            'kry_id.required' => 'Minimal satu responden harus dipilih.',
        ]);

        $loggedInUsername = Session::get('karyawan.nama_lengkap');
        
        if (!$loggedInUsername) {
            return redirect()->route('login')->with('alert', 'Session telah berakhir. Silakan login kembali.');
        }

        // Check for duplicate combination of question and criteria
        $existingQuestion = Pertanyaan::where('pty_pertanyaan', $request->pty_pertanyaan)
            ->where('ksr_id', $request->ksr_id)
            ->where('pty_status', 1)
            ->where('pty_id', '!=', $id)
            ->first();

        if ($existingQuestion) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['pty_pertanyaan' => 'Kombinasi pertanyaan dan kriteria survei ini sudah ada.']);
        }

        // Update data pertanyaan
        $pertanyaan->update([
            'pty_pertanyaan' => $request->pty_pertanyaan,
            'ksr_id' => $request->ksr_id,
            'skp_id' => $request->skp_id,
            'pty_modif_by' => $loggedInUsername,
            'pty_modif_date' => now(),
        ]);

        // Update responden
        DetailBankPertanyaan::where('pty_id', $id)->delete();
        foreach ($request->kry_id as $karyawan_id) {
            DetailBankPertanyaan::create([
                'pty_id' => $id,
                'kry_id' => $karyawan_id,
                'dtl_status' => 1,
                'dtl_created_by' => $loggedInUsername,
                'dtl_created_date' => now(),
                'dtl_modif_by' => $loggedInUsername,
                'dtl_modif_date' => now(),
            ]);
        }

        return redirect()->route('Pertanyaan.index')->with('success', 'Pertanyaan dan data responden berhasil diperbarui.');
    }


    /**
     * Soft delete pertanyaan.
     */
    public function delete($id)
{
    $pertanyaan = Pertanyaan::findOrFail($id);
    $loggedInUsername = Session::get('karyawan.nama_lengkap');

    if (!$loggedInUsername) {
        return redirect()->route('login')->with('alert', 'Session telah berakhir. Silakan login kembali.');
    }

    // Update status di bpm_mspertanyaan (soft delete)
    $pertanyaan->update([
        'pty_status' => 0,
        'pty_modif_by' => $loggedInUsername,
        'pty_modif_date' => now(),
    ]);

    // Hapus semua data terkait di bpm_dtbankpertanyaan (hard delete)
    DetailBankPertanyaan::where('pty_id', $id)->delete();

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
