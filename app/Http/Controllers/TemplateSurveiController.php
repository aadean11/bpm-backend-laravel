<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemplateSurvei;
use App\Models\Pertanyaan;
use App\Models\DetailTemplateSurvei;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;

class TemplateSurveiController extends Controller
{
    public function index(Request $request)
    {
        $query = TemplateSurvei::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tsu_modif_date', 'LIKE', "%{$search}%")
                    ->orWhere('tsu_created_by', 'LIKE', "%{$search}%")
                    ->orWhere('tsu_nama', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan modifikasi tanggal
        if ($request->filled('tsu_modif_date')) {
            $query->where('tsu_modif_date', 'LIKE', "%{$request->tsu_modif_date}%");
        }

        // Status filter untuk hanya menampilkan status 0 dan 1
        if ($request->filled('tsu_status')) {
            $query->where('tsu_status', $request->tsu_status);
        } else {
            // By default, hanya tampilkan status 0 (Draft) dan 1 (Final)
            $query->whereIn('tsu_status', [1, 0]);
        }

        $template_survei = $query->paginate(10);

        return view('templatesurvei.index', [
            'template_survei' => $template_survei,
            'search' => $request->search,
            'tsu_modif_date' => $request->tsu_modif_date,
            'tsu_status' => $request->tsu_status,
        ]);
    }

    public function create()
    {
     
        $pertanyaan = Pertanyaan::all();

        return view('TemplateSurvei.create',compact('pertanyaan'));
        // return view('TemplateSurvei.create', [
            
        //     'pertanyaan' => $pertanyaan
        // ]);
    }
   public function save(Request $request)
{
    try {
        // Validasi input
    //    $request->validate([
    //         'tsu_nama' => 'required|string|max:255',
    //         'pertanyaan_list' => 'required|array', // Pastikan array diterima
    //         'pertanyaan_list.*' => 'integer', // Pastikan setiap elemen adalah angka (ID pertanyaan)
    //     ]);

        $pertanyaan_list = array_map('intval', explode(',', $request->input('pertanyaan_list')[0] ?? ''));

        // Simpan ke tabel bpm_mstemplatesurvei
        $templateId = DB::table('bpm_mstemplatesurvei')->insertGetId([
            'tsu_nama' => $request->input('tsu_nama'),
            'tsu_status' => 0,
            'tsu_created_by' => 'retno.widiastuti',
            'tsu_created_date' => now(),
        ]);

        // Simpan ke tabel bpm_dttemplatepertanyaan
       $dataToInsert = [];
    foreach ($pertanyaan_list as $pty_id) {
    $dataToInsert[] = [
        'tsu_id' => $templateId,
        'pty_id' => $pty_id,
    ];
}
        DB::table('bpm_dttemplatepertanyaan')->insert($dataToInsert);

        return redirect()->route('TemplateSurvei.index')->with('success', 'Template Survei berhasil dibuat.');
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function edit($id)
{
    // Ambil semua pertanyaan
    $pertanyaan = Pertanyaan::all();

    // Cari template survei berdasarkan ID
    $templateSurvei = TemplateSurvei::findOrFail($id);

    // Ambil pertanyaan yang sudah dipilih untuk template ini
    $selectedPertanyaan = $templateSurvei->detailTemplateSurvei()->pluck('pty_id')->toArray();

    return view('TemplateSurvei.edit', compact('templateSurvei', 'pertanyaan', 'selectedPertanyaan'));
}

public function update(Request $request, $id)
{
    DB::beginTransaction();
    try {
        // Cari template survei berdasarkan ID
        $template = TemplateSurvei::findOrFail($id);

        // Update nama template survei
        $template->update([
            'tsu_nama' => $request->tsu_nama,
        ]);

        // Cek apakah ada pertanyaan yang dipilih sebelum melakukan sinkronisasi
        if ($request->has('pty_id') && is_array($request->pty_id)) {
            if (method_exists($template, 'pertanyaan')) {
                $template->pertanyaan()->sync($request->pty_id);
            }
        }

        DB::commit();
        return redirect()->route('TemplateSurvei.index')->with('success', 'Template Survei berhasil diperbarui.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
    }
}

    public function final($id)
    {
        $loggedInUsername = Session::get('karyawan.nama_lengkap');
    
        $templateSurvei = TemplateSurvei::find($id);
        if (!$templateSurvei) {
            return redirect()->route('TemplateSurvei.index')->with('error', 'Template Survei tidak ditemukan.');
        }
    
        $templateSurvei->update([
            'tsu_status' => 1, // Final
            'tsu_modif_by' =>  $loggedInUsername,
            'tsu_modif_date' => now(),
        ]);
    
        return redirect()->route('TemplateSurvei.index')->with('success', 'Template Survei berhasil difinalisasi.');
    }

    public function detail($id)
{
    try {
        // Mengambil template survei berdasarkan ID
        $templateSurvei = DB::table('bpm_mstemplatesurvei')
            ->where('tsu_id', $id)
            ->first();

        if (!$templateSurvei) {
            return redirect()->route('TemplateSurvei.index')->with('error', 'Template Survei tidak ditemukan.');
        }

        // Mengambil pertanyaan terkait dengan template survei
        $pertanyaan = DB::table('bpm_dttemplatepertanyaan')
            ->join('bpm_mspertanyaan', 'bpm_dttemplatepertanyaan.pty_id', '=', 'bpm_mspertanyaan.pty_id')
            ->where('tsu_id', $id)
            ->get();

        // Mengirimkan data ke view
        return view('TemplateSurvei.detail', compact('templateSurvei', 'pertanyaan'));
    } catch (\Exception $e) {
        \Log::error("Error di detail(): " . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function delete($id)
    {
        $loggedInUsername = Session::get('karyawan.nama_lengkap');
        
        $templateSurvei = TemplateSurvei::find($id);
        if (!$templateSurvei) {
            return redirect()->route('TemplateSurvei.index')->with('error', 'Template Survei tidak ditemukan.');
        }

        $templateSurvei->update([
            'tsu_status' => 2, // Tidak Aktif
            'tsu_modif_by' => $loggedInUsername,
            'tsu_modif_date' => now()
        ]);

        return redirect()->route('TemplateSurvei.index')->with('success', 'Template Survei berhasil dinonaktifkan.');
    }

    public function saveTemplate(Request $request)
    {
        $validatedData = $request->validate([
            'tsu_nama' => 'required',
            
            'pty_id' => 'required',
        ]);

        $template = TemplateSurvei::create($validatedData);

        return response()->json([
            'success' => true,
            'template' => $template,
        ]);
    }
}