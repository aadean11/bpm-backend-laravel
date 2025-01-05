<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use Barryvdh\DomPDF\Facade\Pdf;

class PertanyaanController extends Controller
{
    // Menampilkan daftar pertanyaan
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pertanyaan = Pertanyaan::where('pty_status', 1)
            ->when($search, function ($query, $search) {
                $query->where('pty_pertanyaan', 'LIKE', "%{$search}%")
                      ->orWhere('pty_created_by', 'LIKE', "%{$search}%");
            })
            ->paginate(10);

        return view('Pertanyaan.index', compact('pertanyaan', 'search'));
    }

    // Menyimpan pertanyaan baru
    public function save(Request $request)
    {
        $request->validate([
            'pty_pertanyaan' => 'required|string',
            'pty_isheader' => 'required|integer',
            'pty_isgeneral' => 'required|integer',
        ]);

        Pertanyaan::create([
            'pty_pertanyaan' => $request->pty_pertanyaan,
            'pty_isheader' => $request->pty_isheader,
            'pty_isgeneral' => $request->pty_isgeneral,
            'pty_status' => 1,
            'pty_created_by' => auth()->user()->name ?? 'retno.widiastuti',
            'pty_created_date' => now(),
            'pty_modif_by' => auth()->user()->name ?? 'retno.widiastuti',
            'pty_modif_date' => now(),
        ]);

        return redirect()->route('Pertanyaan.index')->with('success', 'Pertanyaan berhasil ditambahkan!');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        return view('Pertanyaan.edit', compact('pertanyaan'));
    }

    // Memperbarui data pertanyaan
    public function update(Request $request, $id)
    {
        $request->validate([
            'pty_pertanyaan' => 'required|string',
            'pty_isheader' => 'required|integer',
            'pty_isgeneral' => 'required|integer',
        ]);

        $pertanyaan = Pertanyaan::findOrFail($id);

        $pertanyaan->update([
            'pty_pertanyaan' => $request->pty_pertanyaan,
            'pty_isheader' => $request->pty_isheader,
            'pty_isgeneral' => $request->pty_isgeneral,
            'pty_modif_by' => auth()->user()->name ?? 'retno.widiastuti',
            'pty_modif_date' => now(),
        ]);

        return redirect()->route('Pertanyaan.index')->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    // Menghapus pertanyaan (soft delete)
    public function delete($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        $pertanyaan->update([
            'pty_status' => 0,
            'pty_modif_by' => auth()->user()->name ?? 'retno.widiastuti',
            'pty_modif_date' => now(),
        ]);

        return redirect()->route('Pertanyaan.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }

    // Mengekspor data pertanyaan ke PDF
    public function exportPdf(Request $request)
    {
        $search = $request->input('search');

        $pertanyaan = Pertanyaan::where('pty_status', 1)
            ->when($search, function ($query, $search) {
                $query->where('pty_pertanyaan', 'LIKE', "%{$search}%")
                      ->orWhere('pty_created_by', 'LIKE', "%{$search}%");
            })
            ->get();

        $pdf = Pdf::loadView('Pertanyaan.pertanyaan_pdf', compact('pertanyaan'));

        return $pdf->download('pertanyaan.pdf');
    }


public function create()
{
    return view('Pertanyaan.create');
}


public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'pty_pertanyaan' => 'required|string|max:255',
        'pty_isheader' => 'required|boolean',
        'pty_isgeneral' => 'required|boolean',
    ]);

    // Simpan data ke database
    Pertanyaan::create([
        'pty_pertanyaan' => $request->pty_pertanyaan,
        'pty_isheader' => $request->pty_isheader,
        'pty_isgeneral' => $request->pty_isgeneral,
    ]);

    // Redirect kembali ke halaman daftar dengan pesan sukses
    return redirect()->route('Pertanyaan.index')->with('success', 'Data berhasil ditambahkan');
}

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KriteriaSurvei;
use Barryvdh\DomPDF\Facade\Pdf;
use SweetAlert;

class PertanyaanController extends Controller
{
    /**
     * Index
     * Menampilkan daftar Kriteria Survei dengan fitur pencarian dan paginasi
     */
    public function index(Request $request)
    {
        $query = $request->input('search'); // Ambil input pencarian

        // Ambil data kriteria survei dengan filter pencarian dan paginasi
        $kriteria_survei = KriteriaSurvei::when($query, function ($queryBuilder, $search) {
            return $queryBuilder->where('ksr_nama', 'LIKE', "%{$search}%")
                ->orWhere('ksr_created_by', 'LIKE', "%{$search}%");
        })->paginate(10); // Paginate hasil

        // Kirim data ke view
        return view('PertanyaanSurvei.index', [
            'kriteria_survei' => $kriteria_survei,
            'search' => $query
        ]);
    }

    public function add(Request $request)
    {
        $query = $request->input('search'); // Ambil input pencarian

        // Ambil data kriteria survei dengan filter pencarian dan paginasi
        $kriteria_survei = KriteriaSurvei::when($query, function ($queryBuilder, $search) {
            return $queryBuilder->where('ksr_nama', 'LIKE', "%{$search}%")
                ->orWhere('ksr_created_by', 'LIKE', "%{$search}%");
        })->paginate(10); // Paginate hasil

        // Kirim data ke view
        return view('SkalaPenilaian.add');
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
    public function delete($id)
    {
        $kriteriaSurvei = KriteriaSurvei::find($id);
        if (!$kriteriaSurvei) {
            return redirect()->route('KriteriaSurvei.index')->with('error', 'Kriteria Survei not found');
        }

        $kriteriaSurvei->delete();

        // Redirect to index page with success message
        return redirect()->route('KriteriaSurvei.index')->with('success', 'Kriteria Survei deleted successfully');
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
