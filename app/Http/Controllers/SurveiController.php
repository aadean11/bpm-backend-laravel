<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiSurvei;
use App\Models\TemplateSurvei;

use Barryvdh\DomPDF\Facade\Pdf;

class SurveiController extends Controller
{
    /**
     * Index
     * Menampilkan daftar transaksi dengan fitur pencarian dan paginasi
     */
    public function index(Request $request)
    {
        $query = $request->input('search'); // Ambil input pencarian

        // Ambil data transaksi dengan filter pencarian dan paginasi
        $transaksi_survei = TransaksiSurvei::when($query, function ($queryBuilder, $search) {
            return $queryBuilder->where('trs_responden', 'LIKE', "%{$search}%")
                ->orWhere('trs_created_by', 'LIKE', "%{$search}%");
        })->paginate(10); // Paginate hasil

        // Kirim data ke view
        return view('Survei.index', [
            'transaksi_survei' => $transaksi_survei,
            'search' => $query
        ]);
    }

    /**
     * Create
     * Menampilkan form untuk menambahkan data transaksi baru
     */
    public function create()
    {
        $template_survei = TemplateSurvei::all();
        return view('Survei.create', [
            'template_survei' => $template_survei
        ]);
    }

    /**
     * Store
     * Menambahkan data transaksi baru
     */
    public function save(Request $request)
    {
        $request->validate([
            'trs_id' => 'required|string|max:50',
            'trs_responden' => 'required|string|max:100',
            'trs_tanggal' => 'required|date',
        ]);

        Survei::create([
            'trs_id' => $request->input('trs_id'),
            'tsu_id' => $request->input('tsu_id'),
            'trs_responden' => $request->input('trs_responden'),
            'trs_tanggal' => $request->input('trs_tanggal'),
            'trs_status' => 1, // Status aktif
            'trs_created_by' => auth()->user()->name, // Ambil user login
            'trs_created_date' => now(),
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Survei berhasil ditambahkan');
    }

    /**
     * Edit
     * Menampilkan form edit berdasarkan ID
     */
    public function edit($id)
    {
        $transaksi = Survei::find($id);
        if (!$transaksi) {
            return redirect()->route('transaksi.index')->with('error', 'Survei tidak ditemukan');
        }

        return view('Survei.edit', compact('transaksi'));
    }

    /**
     * Update
     * Mengupdate data transaksi berdasarkan ID
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'trs_responden' => 'required|string|max:100',
            'trs_status' => 'required|integer',
        ]);

        $transaksi = Survei::find($id);
        if (!$transaksi) {
            return redirect()->route('transaksi.index')->with('error', 'Survei tidak ditemukan');
        }

        $transaksi->update([
            'trs_responden' => $request->input('trs_responden'),
            'trs_status' => $request->input('trs_status'),
            'trs_modif_by' => auth()->user()->name,
            'trs_modif_date' => now(),
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Survei berhasil diperbarui');
    }

    /**
     * Delete
     * Menghapus data transaksi berdasarkan ID
     */
    public function destroy($id)
    {
        $transaksi = Survei::find($id);
        if (!$transaksi) {
            return redirect()->route('transaksi.index')->with('error', 'Survei tidak ditemukan');
        }

        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Survei berhasil dihapus');
    }

}
