<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KriteriaSurvei;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use SweetAlert;

class KriteriaSurveiController extends Controller
{
    
    public function index(Request $request)
    {
        $query = KriteriaSurvei::query();
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ksr_nama', 'LIKE', "%{$search}%")
                ->orWhere('ksr_created_by', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter berdasarkan nama
        if ($request->filled('ksr_nama')) {
            $query->where('ksr_nama', 'LIKE', "%{$request->ksr_nama}%");
        }
        
        // Status filter
        if ($request->filled('ksr_status')) {
            $query->where('ksr_status', $request->ksr_status);
        } else {
            // By default, only show active records
            $query->where('ksr_status', 1);
        }
        
        $kriteria_survei = $query->paginate(10);
        
        return view('kriteriasurvei.index', [
            'kriteria_survei' => $kriteria_survei,
            'search' => $request->search,
            'ksr_nama' => $request->ksr_nama,
            'ksr_status' => $request->ksr_status,
        ]);
    }

    /**
     * Save
     * Menambahkan data Kriteria Survei baru
     */
    public function save(Request $request)
    {
        $request->validate([
            'ksr_nama' => 'required|string|max:50',
        ], [
            'ksr_nama.required' => 'Nama Kriteria Survei harus diisi.',
            'ksr_nama.max' => 'Nama Kriteria Survei tidak boleh lebih dari 50 karakter.',
        ]);

        $createdBy = Session::get('karyawan.username'); 

        KriteriaSurvei::create([
            'ksr_nama' => $request->input('ksr_nama'),
            'ksr_status' => 1,  // 1 = Aktif
            'ksr_created_by' => $createdBy,  // Gunakan nilai dari session
            'ksr_created_date' => now(),
        ]);

        return redirect()->route('KriteriaSurvei.index')->with('success', 'Kriteria Survei berhasil dibuat');
    }


    /**
     * Edit
     * Menampilkan data Kriteria Survei untuk diubah berdasarkan ID
     */
    public function edit(Request $request)
    {
        // Ambil ID dari inputan
        $id = $request->input('ksr_id'); 
    
        // Cari data berdasarkan ID
        $kriteria_survei = KriteriaSurvei::find($id);
        if (!$kriteria_survei) {
            return redirect()->route('KriteriaSurvei.index')->with('error', 'Kriteria Survei tidak ditemukan');
        }
    
        // Kirim data ke view
        return view('KriteriaSurvei.edit', compact('kriteria_survei'));
    }

    /**
     * Update
     * Mengupdate data Kriteria Survei berdasarkan ID
     */
    public function update(Request $request, $id)
    {
        $id = $request->input('ksr_id');
        $kriteria_survei = KriteriaSurvei::find($id);

        $modifBy = Session::get('karyawan.username'); 

        // Update data
        $kriteria_survei->ksr_nama = $request->input('ksr_nama');
        $kriteria_survei->ksr_modif_by = $modifBy;
        $kriteria_survei->ksr_modif_date = now();
        $kriteria_survei->save();

        return redirect()->route('KriteriaSurvei.index')->with('success', 'Kriteria berhasil diperbarui!');
    }


    /** 
     * Delete
     * Menghapus data Kriteria Survei berdasarkan ID
     */
    public function delete(Request $request, $id)
    {
        $kriteria_survei = KriteriaSurvei::find($id);

        if (!$kriteria_survei) {
            return redirect()->route('KriteriaSurvei.index')->with('error', 'Kriteria Survei tidak ditemukan');
        }

        $modifBy = Session::get('karyawan.username'); 

        // Update status menjadi nonaktif dan tambahkan informasi modifikasi
        $kriteria_survei->update([
            'ksr_status' => 0,
            'ksr_modif_by' => $modifBy,
            'ksr_modif_date' => now(),
        ]);

        return redirect()->route('KriteriaSurvei.index')->with('success', 'Kriteria Survei berhasil diperbarui');
    }


   
}
