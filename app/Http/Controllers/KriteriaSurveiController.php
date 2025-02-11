<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KriteriaSurvei;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use SweetAlert;

class KriteriaSurveiController extends Controller
{
    public function index(Request $request)
{
    $totalAktif = KriteriaSurvei::where('ksr_status', 1)->count();
    $totalNonaktif = KriteriaSurvei::where('ksr_status', 0)->count();
    $totalKeseluruhan = KriteriaSurvei::count();

    $query = KriteriaSurvei::query();

    // Search functionality
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('ksr_nama', 'LIKE', "%{$search}%")
                ->orWhere('ksr_created_by', 'LIKE', "%{$search}%");
        });
    }

    // Status filter
    if ($request->filled('ksr_status')) {
        if ($request->ksr_status !== 'all') {
            $query->where('ksr_status', $request->ksr_status);
        }
    }

    $kriteria_survei = $query->paginate(10);

    return view('kriteriasurvei.index', [
        'kriteria_survei' => $kriteria_survei,
        'totalAktif' => $totalAktif,
        'totalNonaktif' => $totalNonaktif,
        'totalKeseluruhan' => $totalKeseluruhan,
        'search' => $request->search,
        'ksr_status' => $request->ksr_status,
    ]);
}

    public function detail($id)
    {
        $kriteriaSurvei = KriteriaSurvei::find($id);

        if (!$kriteriaSurvei) {
            return redirect()
                ->route('KriteriaSurvei.index')
                ->with('error', 'Kriteria Survei tidak ditemukan');
        }

        return view('KriteriaSurvei.detail', compact('kriteriaSurvei'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'ksr_nama' => 'required|string|max:50|unique:bpm_mskriteriasurvei,ksr_nama',
        ], [
            'ksr_nama.required' => 'Nama Kriteria Survei harus diisi.',
            'ksr_nama.max' => 'Nama Kriteria Survei tidak boleh lebih dari 50 karakter.',
            'ksr_nama.unique' => 'Nama Kriteria Survei sudah ada, silakan pilih nama lain.',
        ]);

        $createdBy = Session::get('karyawan.username');

        KriteriaSurvei::create([
            'ksr_nama' => $request->input('ksr_nama'),
            'ksr_status' => 1,
            'ksr_created_by' => $createdBy,
            'ksr_created_date' => now(),
        ]);

        return redirect()->route('KriteriaSurvei.index')->with('success', 'Kriteria Survei berhasil dibuat');
    }

    public function edit($id)
    {
        $kriteria_survei = KriteriaSurvei::find($id);
        if (!$kriteria_survei) {
            return redirect()->route('KriteriaSurvei.index')->with('error', 'Kriteria Survei tidak ditemukan');
        }

        return view('KriteriaSurvei.edit', compact('kriteria_survei'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ksr_nama' => 'required|unique:bpm_mskriteriasurvei,ksr_nama,' . $id . ',ksr_id'
        ], [
            'ksr_nama.required' => 'Nama Kriteria harus diisi!',
            'ksr_nama.unique' => 'Nama Kriteria sudah ada, silakan gunakan nama lain!'
        ]);

        $kriteria_survei = KriteriaSurvei::find($id);
        if (!$kriteria_survei) {
            return redirect()->route('KriteriaSurvei.index')->with('error', 'Data tidak ditemukan!');
        }

        try {
            DB::beginTransaction();

            $modifBy = Session::get('karyawan.username');

            $kriteria_survei->ksr_nama = $request->input('ksr_nama');
            $kriteria_survei->ksr_modif_by = $modifBy;
            $kriteria_survei->ksr_modif_date = now();
            $kriteria_survei->save();

            DB::commit();

            return redirect()->route('KriteriaSurvei.index')->with('success', 'Kriteria berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('KriteriaSurvei.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $kriteria_survei = KriteriaSurvei::find($id);

        if (!$kriteria_survei) {
            return redirect()->route('KriteriaSurvei.index')->with('error', 'Kriteria Survei tidak ditemukan');
        }

        $modifBy = Session::get('karyawan.username');

        $kriteria_survei->update([
            'ksr_status' => 0,
            'ksr_modif_by' => $modifBy,
            'ksr_modif_date' => now(),
        ]);

        return redirect()->route('KriteriaSurvei.index')->with('success', 'Kriteria Survei berhasil diperbarui');
    }
}
