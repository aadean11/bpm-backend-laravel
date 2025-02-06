<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailTemplateSurvei;
use App\Models\TemplateSurvei;
use App\Models\Pertanyaan;
use Illuminate\Support\Facades\DB;

class DetailTemplateSurveiController extends Controller
{
    public function index(Request $request)
    {
        $query = DetailTemplateSurvei::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('templateSurvei', function($q) use ($search) {
                $q->where('tsu_nama', 'LIKE', "%{$search}%");
            })->orWhereHas('pertanyaan', function($q) use ($search) {
                $q->where('pty_pertanyaan', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan template survei
        if ($request->filled('tsu_id')) {
            $query->where('tsu_id', $request->tsu_id);
        }

        // Filter berdasarkan pertanyaan
        if ($request->filled('pty_id')) {
            $query->where('pty_id', $request->pty_id);
        }

        $detail_template_survei = $query->with(['templateSurvei', 'pertanyaan'])->paginate(10);

        return view('detailTemplatesurvei.index', [
            'detail_template_survei' => $detail_template_survei,
            'search' => $request->search,
            'tsu_id' => $request->tsu_id,
            'pty_id' => $request->pty_id,
        ]);
    }

    public function create()
    {
        $template_survei = TemplateSurvei::whereIn('tsu_status', [0, 1])->get();
        $pertanyaan = Pertanyaan::all();

        return view('detailTemplatesurvei.create', compact('template_survei', 'pertanyaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tsu_id' => 'required|exists:bpm_mstemplatesurvei,tsu_id',
            'pty_id' => 'required|exists:bpm_mspertanyaan,pty_id',
        ], [
            'tsu_id.required' => 'Template survei wajib dipilih.',
            'tsu_id.exists' => 'Template survei tidak valid.',
            'pty_id.required' => 'Pertanyaan wajib dipilih.',
            'pty_id.exists' => 'Pertanyaan tidak valid.',
        ]);

        DetailTemplateSurvei::create([
            'tsu_id' => $request->tsu_id,
            'pty_id' => $request->pty_id,
        ]);

        return redirect()->route('detailTemplatesurvei.index')
            ->with('success', 'Detail Template Survei berhasil dibuat.');
    }

    public function edit($id)
    {
        $detail = DetailTemplateSurvei::findOrFail($id);
        $template_survei = TemplateSurvei::whereIn('tsu_status', [0, 1])->get();
        $pertanyaan = Pertanyaan::all();

        return view('detailTemplatesurvei.edit', compact('detail', 'template_survei', 'pertanyaan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tsu_id' => 'required|exists:bpm_mstemplatesurvei,tsu_id',
            'pty_id' => 'required|exists:bpm_mspertanyaan,pty_id',
        ], [
            'tsu_id.required' => 'Template survei wajib dipilih.',
            'tsu_id.exists' => 'Template survei tidak valid.',
            'pty_id.required' => 'Pertanyaan wajib dipilih.',
            'pty_id.exists' => 'Pertanyaan tidak valid.',
        ]);

        $detail = DetailTemplateSurvei::findOrFail($id);
        $detail->update([
            'tsu_id' => $request->tsu_id,
            'pty_id' => $request->pty_id,
        ]);

        return redirect()->route('detailTemplatesurvei.index')
            ->with('success', 'Detail Template Survei berhasil diperbarui.');
    }

    public function show($id)
    {
        $detail = DetailTemplateSurvei::with(['templateSurvei', 'pertanyaan'])->findOrFail($id);
        return view('detailTemplatesurvei.show', compact('detail'));
    }

    public function destroy($id)
    {
        $detail = DetailTemplateSurvei::findOrFail($id);
        $detail->delete();

        return redirect()->route('detailTemplatesurvei.index')
            ->with('success', 'Detail Template Survei berhasil dihapus.');
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'tsu_id' => 'required|exists:bpm_mstemplatesurvei,tsu_id',
            'pty_ids' => 'required|array',
            'pty_ids.*' => 'exists:bpm_mspertanyaan,pty_id',
        ]);

        foreach ($request->pty_ids as $pty_id) {
            DetailTemplateSurvei::create([
                'tsu_id' => $request->tsu_id,
                'pty_id' => $pty_id,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Template Survei berhasil ditambahkan.',
        ]);
    }
}