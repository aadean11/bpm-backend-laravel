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
            $query->whereIn('tsu_status', [0, 1]);
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
        $request->validate([
            'tsu_nama' => 'required|string|max:255',
            'pty_id' => ['required', 'array', function ($attribute, $value, $fail) {
                if (!DB::table('bpm_mspertanyaan')->whereIn('pty_id', $value)->count() === count($value)) {
                    $fail('Satu atau lebih pertanyaan tidak valid.');
                }
            }],
        ], [
            'tsu_nama.required' => 'Nama template survei wajib diisi.',
            'tsu_nama.string' => 'Nama template survei harus berupa teks.',
            'tsu_nama.max' => 'Nama template survei tidak boleh lebih dari 255 karakter.',
            'pty_id.required' => 'Minimal satu pertanyaan harus dipilih.',
            'pty_id.array' => 'Format pertanyaan tidak valid.',
            'pty_id.*.integer' => 'ID pertanyaan harus berupa angka.',
        ]);

        // Debugging: Pastikan request berisi array
        if (!is_array($request->input('pty_id'))) {
            return redirect()->back()->withErrors(['pty_id' => 'Format pertanyaan tidak valid.']);
        }



        $templateId = DB::table('bpm_mstemplatesurvei')->insertGetId([
            'tsu_nama' => $request->input('tsu_nama'),
            'tsu_status' => 0, // Status default
            'tsu_created_by' => 'retno.widiastuti',
            'tsu_created_date' => now(),
        ]);

        foreach ($request->pty_id as $pty_id) {
            DB::table('bpm_dttemplatesurvei')->insert([
                'tsu_id' => $templateId,  // ID template survei yang baru dibuat
                'pty_id' => $pty_id, // Foreign key
            ]);
        }

        {
            $loggedInUsername = Session::get('karyawan.nama_lengkap');

            $request->validate([
                'tsu_nama' => 'required|string|max:255',
                'pty_id' => 'required|integer',
            ], [
                'tsu_nama.required' => 'Nama template survei wajib diisi.',
                'tsu_nama.string' => 'Nama template survei harus berupa teks.',
                'tsu_nama.max' => 'Nama template survei tidak boleh lebih dari 255 karakter.',
                'pty_id.required' => 'Pertanyaan harus dipilih.',
                'pty_id.integer' => 'ID pertanyaan harus berupa angka.',
            ]);

            TemplateSurvei::create([
                'tsu_nama' => $request->input('tsu_nama'),
                'tsu_status' => 0,  // 0 = Draf
                'pty_id' => $request->input('pty_id'),
                'tsu_created_by' => $loggedInUsername,
                'tsu_created_date' => now(),
            ]);

        return redirect()->route('TemplateSurvei.create')->with('success', 'Template Survei berhasil dibuat.');
        }
    }
    
    public function edit($id)
    {
        $pertanyaan = Pertanyaan::all();
        $templateSurvei = TemplateSurvei::find($id);

        if (!$templateSurvei) {
            return redirect()->route('TemplateSurvei.index')->with('error', 'Template Survei tidak ditemukan.');
        }

        // Get currently selected pertanyaan IDs
        $selectedPertanyaan = $templateSurvei->detailTemplateSurvei->pluck('pty_id')->toArray();

        return view('TemplateSurvei.edit', compact('templateSurvei', 'pertanyaan', 'selectedPertanyaan'));
    }

public function update(Request $request, $id)
{
    $request->validate([
        'tsu_nama' => 'required|string|max:255',
        'pty_id' => ['required', 'array', function ($attribute, $value, $fail) {
            if (!DB::table('bpm_mspertanyaan')->whereIn('pty_id', $value)->count() === count($value)) {
                $fail('Satu atau lebih pertanyaan tidak valid.');
            }
        }],
    ], [
        'tsu_nama.required' => 'Nama template survei wajib diisi.',
        'tsu_nama.string' => 'Nama template survei harus berupa teks.',
        'tsu_nama.max' => 'Nama template survei tidak boleh lebih dari 255 karakter.',
        'pty_id.required' => 'Minimal satu pertanyaan harus dipilih.',
        'pty_id.array' => 'Format pertanyaan tidak valid.',
    ]);

    // Debugging: Pastikan request berisi array
    if (!is_array($request->input('pty_id'))) {
        return redirect()->back()->withErrors(['pty_id' => 'Format pertanyaan tidak valid.']);
    }

        DB::beginTransaction();
        try {
            // Update template survei
            $template = TemplateSurvei::findOrFail($id);
            // Add your update logic here
    
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui template survei.']);
        }
    
        return redirect()->route('TemplateSurvei.index')->with('success', 'Template Survei berhasil diperbarui.');
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
        $templateSurvei = TemplateSurvei::find($id);
        if (!$templateSurvei) {
            return redirect()->route('TemplateSurvei.index')->with('error', 'Template Survei tidak ditemukan.');
        }

        return view('TemplateSurvei.detail', compact('templateSurvei'));
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