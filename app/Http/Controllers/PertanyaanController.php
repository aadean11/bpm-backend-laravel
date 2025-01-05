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
