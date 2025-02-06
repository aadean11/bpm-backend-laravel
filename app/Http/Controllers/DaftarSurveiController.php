<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DaftarSurvei;
use App\Models\DetailSurvei;
use App\Models\TemplateSurvei;
use App\Models\Pertanyaan;
use App\Models\SkalaPenilaian;
use App\Models\Survei; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DaftarSurveiController extends Controller
{
    public function index(Request $request)
    {
        $query = Survei::query()->with(['templateSurvei']);
        // ... (filtering dan paging, sesuai kebutuhan)
        $survei_list = $query->paginate(10);

        return view('DaftarSurvei.index', compact('survei_list'))->with([
            'search' => $request->search,
            // filter lainnya
        ]);
    }

    public function jawab($id)
    {
        // Load survei beserta detail pertanyaannya (pastikan relasi sudah didefinisikan)
        $survei = Survei::with(['templateSurvei', 'surveyDetails.pertanyaan', 'surveyDetails.skalaPenilaian'])
                    ->findOrFail($id);
        // Tampilkan halaman isian jawaban
        return view('Survei.jawab', compact('survei'));
    }
    
    public function submitJawaban(Request $request, $id)
    {
        // Validasi: pastikan setiap pertanyaan memiliki jawaban
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|numeric', 
        ], [
            'answers.required' => 'Silakan isi jawaban untuk setiap pertanyaan.',
        ]);

        // Ambil data karyawan dari session
        $karyawanId = Session::get('karyawan.id'); // Sesuaikan dengan nama session yang digunakan
        $karyawanNama = Session::get('karyawan.nama_lengkap');

        // Pastikan session berisi data karyawan
        if (!$karyawanId || !$karyawanNama) {
            return redirect()->route('DaftarSurvei.index')->with('error', 'Session expired. Silakan login kembali.');
        }

        // Mulai transaksi
        DB::transaction(function() use ($request, $id, $karyawanId, $karyawanNama) {
            // Simpan data responden dengan data dari session
            $response = DetailSurvei::create([
                'trs_id'        => $id,
                'responden_id'  => $karyawanId, 
                'responden_nama'=> $karyawanNama, 
                'response_date' => now(),
            ]);

            // Simpan jawaban tiap pertanyaan
            foreach ($request->answers as $detailId => $jawaban) {
                DetailSurvei::create([
                    'response_id' => $response->id,
                    'dtt_id'      => $detailId, 
                    'jawaban'     => $jawaban,
                ]);
            }
        });

        return redirect()->route('DaftarSurvei.index')->with('success', 'Jawaban berhasil disimpan.');
    }




    // public function save(Request $request)
    // {
    //     $request->validate([
    //         // Gunakan tsu_id dan validasi terhadap tabel bpm_mstemplatesurvei
    //         'tsu_id'   => 'required|exists:bpm_mstemplatesurvei,tsu_id',
    //         'pty_id'   => 'required|exists:bpm_mspertanyaan,pty_id',
    //         'skp_id'   => 'required|exists:bpm_msskalapenilaian,skp_id',
    //         'dtt_nilai'=> 'required|integer'
    //     ]);
        
    //     $loggedInUsername = Session::get('karyawan.nama_lengkap');

    //     DaftarSurvei::create([
    //         'tsu_id'          => $request->input('tsu_id'),
    //         'pty_id'          => $request->input('pty_id'),
    //         'skp_id'          => $request->input('skp_id'),
    //         'dtt_nilai'       => $request->input('dtt_nilai'),
    //         'dtt_created_by'  => $loggedInUsername,
    //         'dtt_created_date'=> now(),
    //     ]);

    //     return redirect()->route('DaftarSurvei.index')
    //         ->with('success', 'Survey response saved successfully');
    // }

    // public function edit($id)
    // {
    //     // Perhatikan: relasi diubah dari survei ke templateSurvei
    //     $survei_detail = DaftarSurvei::with(['templateSurvei', 'pertanyaan', 'skalaPenilaian'])->find($id);
    //     if (!$survei_detail) {
    //         return redirect()->route('DaftarSurvei.index')
    //             ->with('error', 'Survey response not found');
    //     }

    //     $template_list      = TemplateSurvei::where('tsu_status', 1)->get();
    //     $pertanyaan_list    = Pertanyaan::where('pty_status', 1)->get();
    //     $skala_penilaian_list = SkalaPenilaian::where('skp_status', 1)->get();

    //     return view('DaftarSurvei.edit', compact(
    //         'survei_detail',
    //         'template_list',
    //         'pertanyaan_list',
    //         'skala_penilaian_list'
    //     ));
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'tsu_id'   => 'required|exists:bpm_mstemplatesurvei,tsu_id',
    //         'pty_id'   => 'required|exists:bpm_mspertanyaan,pty_id',
    //         'skp_id'   => 'required|exists:bpm_msskalapenilaian,skp_id',
    //         'dtt_nilai'=> 'required|integer'
    //     ]);

    //     $loggedInUsername = Session::get('karyawan.nama_lengkap');
        
    //     if (!$loggedInUsername) {
    //         return redirect()->route('login')
    //             ->with('alert', 'Session has expired. Please login again.');
    //     }

    //     $survei_detail = DaftarSurvei::find($id);
    //     if (!$survei_detail) {
    //         return redirect()->route('DaftarSurvei.index')
    //             ->with('error', 'Survey response not found');
    //     }

    //     $survei_detail->update([
    //         'tsu_id'         => $request->input('tsu_id'),
    //         'pty_id'         => $request->input('pty_id'),
    //         'skp_id'         => $request->input('skp_id'),
    //         'dtt_nilai'      => $request->input('dtt_nilai'),
    //         'dtt_modif_by'   => $loggedInUsername,
    //         'dtt_modif_date' => now()
    //     ]);

    //     return redirect()->route('DaftarSurvei.index')
    //         ->with('success', 'Survey response updated successfully');
    // }

    public function detail($id)
    {
        $survei_detail = DaftarSurvei::with([
            'templateSurvei',
            'pertanyaan',
            'skalaPenilaian'
        ])->find($id);
        
        if (!$survei_detail) {
            return redirect()->route('DaftarSurvei.index')
                ->with('error', 'Survey response not found');
        }

        return view('DaftarSurvei.detail', compact('survei_detail'));
    }

    // public function add()
    // {
    //     $template_list      = TemplateSurvei::where('tsu_status', 1)->get();
    //     $pertanyaan_list    = Pertanyaan::where('pty_status', 1)->get();
    //     $skala_penilaian_list = SkalaPenilaian::where('skp_status', 1)->get();
        
    //     return view('DaftarSurvei.add', compact(
    //         'template_list',
    //         'pertanyaan_list',
    //         'skala_penilaian_list'
    //     ));
    // }
}
