<?php
namespace App\Http\Controllers;
use App\Models\KriteriaSurvei;
use App\Models\SkalaPenilaian;
use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PertanyaanExport;
use Maatwebsite\Excel\Facades\Excel;

class PertanyaanController extends Controller
{
        // Menampilkan daftar pertanyaan
    //     public function index()
    // {
    //     $search = request()->get('search', '');
    //     $pertanyaan = Pertanyaan::with(['kriteria', 'skala'])
    //         ->where('pty_status', 1)  // Menambahkan kondisi untuk status = 1
    //         ->when($search, function ($query, $search) {
    //             $query->where('pty_pertanyaan', 'LIKE', "%$search%");
    //         })
    //         ->paginate(10);

    //     return view('Pertanyaan.index', compact('pertanyaan', 'search'));
    // }

    public function index(Request $request)
    {
        $query = Pertanyaan::query();
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('pty_pertanyaan', 'LIKE', "%{$search}%")
                ->orWhere('pty_status', 'LIKE', "%{$search}%")
                ->orWhere('pty_created_by', 'LIKE', "%{$search}%")
                ->orWhere('pty_created_date', 'LIKE', "%{$search}%")
                ->orWhere('pty_isheader', 'LIKE', "%{$search}%")
                ->orWhere('pty_isgeneral', 'LIKE', "%{$search}%")
                ->orWhere('pty_modif_by', 'LIKE', "%{$search}%")
                ->orWhere('pty_modif_date', 'LIKE', "%{$search}%")
                ->orWhere('ksr_id', 'LIKE', "%{$search}%")
                ->orWhere('skp_id', 'LIKE', "%{$search}%")
                ->orWhere('pty_role_responden', 'LIKE', "%{$search}%");
            });
        }
        // Status filter
        if ($request->filled('pty_status')) {
            $query->where('pty_status', $request->pty_status);
        } else {
            // By default, only show active records
            $query->where('pty_status', 1);
        }
        
        // Order by Created Date
        if ($request->filled('pty_created_date_order')) {
            $query->orderBy('pty_created_date', $request->pty_created_date_order);
        } else {
            // Default to ascending order if not provided
            $query->orderBy('pty_created_date', 'asc');
        }
        
        // Paginate the results
        $pertanyaan = $query->paginate(10);
        
        return view('Pertanyaan.index', compact('pertanyaan'))->with([
            'search' => $request->search,
            'pty_status' => $request->pty_status,
            'pty_created_date_order' => $request->pty_created_date_order
        ]);
    }
    // Menampilkan form untuk membuat pertanyaan baru
    public function create()
    {
        $kriteria_survei = KriteriaSurvei::all();
        $skala_penilaian = SkalaPenilaian::all();
        return view('pertanyaan.create', compact('kriteria_survei', 'skala_penilaian'));
    }

    // Menyimpan data pertanyaan baru
    public function save(Request $request)
    {
        //   dd($request->all());
        // Validasi form
        $request->validate(rules: [
            
            'pty_pertanyaan' => 'required|string|max:255',
            'pty_isheader' => 'nullable|boolean',  // Checkbox validasi
            'pty_isgeneral' => 'required|boolean', // Radio button validasi
            'ksr_id' => $request->pty_isgeneral == 0 ? 'required|exists:bpm_mskriteriasurvei,ksr_id' : 'nullable',  
            'skp_id' => $request->pty_isgeneral == 0 ? 'required|exists:bpm_msskalapenilaian,skp_id' : 'nullable', 
        ]);
    
        // Membuat pertanyaan baru
        Pertanyaan::create([

            'pty_pertanyaan' => $request->pty_pertanyaan,
            'pty_isheader' => $request->has('pty_isheader') ? 1 : 0,  // Cek apakah checkbox dicentang
            'pty_isgeneral' => $request->pty_isgeneral,
            'pty_status' => 1,
            'pty_created_by' => auth()->user()->name ?? 'default_user',
            'pty_created_date' => now(),
            'pty_modif_by' => auth()->user()->name ?? 'default_user',
            'pty_modif_date' => now(),
            'ksr_id' => $request->pty_isgeneral == 0 ? $request->ksr_id : null, 
            'skp_id' => $request->pty_isgeneral == 0 ? $request->skp_id : null, 
        ]);
    
        return redirect()->route('Pertanyaan.index')->with('success', 'Pertanyaan berhasil dibuat.');
    }
    
    // Menampilkan form edit
    public function edit($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $kriteria_survei = KriteriaSurvei::all(); // Fetch all Kriteria Survei
        $skala_penilaian = SkalaPenilaian::all(); // Fetch all Skala Penilaian
    
        return view('Pertanyaan.edit', compact('pertanyaan', 'kriteria_survei', 'skala_penilaian'));
    }

    // Memperbarui data pertanyaan
    public function update(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->pty_isgeneral = $request->input('pty_isgeneral');  // Mengambil data radio button
        $pertanyaan->pty_pertanyaan = $request->input('pty_pertanyaan');
        $pertanyaan->ksr_id = $request->input('ksr_id');
        $pertanyaan->skp_id = $request->input('skp_id');
        $pertanyaan->pty_isheader = $request->input('pty_isheader', 0); // Menangani checkbox, default 0

        $pertanyaan->save();

        return redirect()->route('Pertanyaan.index')->with('success', 'Data berhasil diperbarui');
    }

    // Menghapus pertanyaan (soft delete)
    public function delete($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->update([
            'pty_status' => 0,
            'pty_modif_by' => auth()->user()->name ?? 'default_user',
            'pty_modif_date' => now(),
        ]);

        return redirect()->route('Pertanyaan.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }

        public function detail($id)
        {
        // Cari data Pertanyaan berdasarkan ID
        $pertanyaan = Pertanyaan::find($id);

        // Jika data tidak ditemukan, kembali ke halaman sebelumnya dengan pesan error
        if (!$pertanyaan) {
            return redirect()
                ->route('Pertanyaan.index')
                ->with('error', 'Pertanyaan tidak ditemukan.');
        }

        // Tampilkan view dengan data yang ditemukan
        return view('Pertanyaan.detail', compact('pertanyaan'));}

        // Method untuk ekspor data ke Excel
    public function exportExcel(Request $request)
    {
        $query = Pertanyaan::query();

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('pty_pertanyaan', 'LIKE', "%{$search}%");
        }

        // Filter berdasarkan status
        if ($request->filled('pty_status')) {
            $query->where('pty_status', $request->pty_status);
        }

        // Ambil data sesuai filter
        $pertanyaan = $query->where('pty_status', 1)->get();

        // Kirim data ke export class
        return Excel::download(new PertanyaanExport($pertanyaan), 'pertanyaan_survei.xlsx');
    }

     // Method untuk mengunduh template
    public function downloadTemplate()
    {
        $templateDokumen = 'Template_Kuesioner.xlsx'; // Nama file template
        $filePath = storage_path('app/public/templates/' . $templateDokumen); // Path file di dalam storage

        dd($filePath); // Debugging untuk memeriksa path

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }
    }

}
    

