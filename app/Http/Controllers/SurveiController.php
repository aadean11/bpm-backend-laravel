<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survei;
use App\Models\TemplateSurvei;

class SurveiController extends Controller
{
    public function index(Request $request)
    {
        $query = Survei::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('sur_nama', 'LIKE', "%{$search}%")
                ->orWhere('sur_created_by', 'LIKE', "%{$search}%");
        }

        // Filter berdasarkan modifikasi tanggal
        if ($request->filled('sur_modif_date')) {
            $query->where('sur_modif_date', 'LIKE', "%{$request->sur_modif_date}%");
        }

        $survei = $query->paginate(10);

        return view('survei.index', [
            'survei' => $survei,
            'search' => $request->search,
            'sur_modif_date' => $request->sur_modif_date,
        ]);
    }

    public function create()
    {
        $template_survei = TemplateSurvei::all();

        return view('survei.create', [
            'template_survei' => $template_survei,
        ]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'sur_nama' => 'required|string|max:200',
            'tsu_id' => 'required|integer|exists:bpm_mstemplatesurvei,tsu_id',
        ], [
            'sur_nama.required' => 'Nama survei wajib diisi.',
            'sur_nama.string' => 'Nama survei harus berupa teks.',
            'sur_nama.max' => 'Nama survei tidak boleh lebih dari 200 karakter.',
            'tsu_id.required' => 'Template survei harus dipilih.',
            'tsu_id.integer' => 'ID template survei harus berupa angka.',
            'tsu_id.exists' => 'Template survei tidak valid.',
        ]);

        Survei::create([
            'sur_nama' => $request->input('sur_nama'),
            'tsu_id' => $request->input('tsu_id'),
            'sur_created_by' => 'retno.widiastuti', // Data statis sementara
            'sur_created_date' => now(),
        ]);

        return redirect()->route('Survei.create')->with('success', 'Survei berhasil dibuat.');
    }

    public function edit($id)
    {
        $template_survei = TemplateSurvei::all();
        $survei = Survei::find($id);

        if (!$survei) {
            return redirect()->route('Survei.index')->with('error', 'Survei tidak ditemukan.');
        }

        return view('survei.edit', compact('survei', 'template_survei'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sur_nama' => 'required|string|max:200',
            'tsu_id' => 'required|integer|exists:bpm_mstemplatesurvei,tsu_id',
        ], [
            'sur_nama.required' => 'Nama survei wajib diisi.',
            'sur_nama.string' => 'Nama survei harus berupa teks.',
            'sur_nama.max' => 'Nama survei tidak boleh lebih dari 200 karakter.',
            'tsu_id.required' => 'Template survei harus dipilih.',
            'tsu_id.integer' => 'ID template survei harus berupa angka.',
            'tsu_id.exists' => 'Template survei tidak valid.',
        ]);

        $survei = Survei::find($id);

        if (!$survei) {
            return redirect()->route('Survei.index')->with('error', 'Survei tidak ditemukan.');
        }

        $survei->update([
            'sur_nama' => $request->input('sur_nama'),
            'tsu_id' => $request->input('tsu_id'),
            'sur_modif_by' => 'retno.widiastuti', // Data statis sementara
            'sur_modif_date' => now(),
        ]);

        return redirect()->route('Survei.index')->with('success', 'Survei berhasil diupdate.');
    }

    public function delete($id)
    {
        $survei = Survei::find($id);

        if (!$survei) {
            return redirect()->route('Survei.index')->with('error', 'Survei tidak ditemukan.');
        }

        $survei->delete();

        return redirect()->route('Survei.index')->with('success', 'Survei berhasil dihapus.');
    }
}