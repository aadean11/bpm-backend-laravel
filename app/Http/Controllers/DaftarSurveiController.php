<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DaftarSurvei;
use App\Models\TemplateSurvei;
use App\Models\Pertanyaan;
use App\Models\SkalaPenilaian;
use Illuminate\Support\Facades\Session;

class DaftarSurveiController extends Controller
{
    public function index(Request $request)
    {
        $query = DaftarSurvei::query()
            ->with(['templateSurvei', 'pertanyaan', 'skalaPenilaian']);
        
        // Search filter (berdasarkan nama template)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->orWhereHas('templateSurvei', function($q) use ($search) {
                $q->where('tsu_nama', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter berdasarkan Template Survei
        if ($request->filled('tsu_id')) {
            $query->where('tsu_id', $request->tsu_id);
        }
        
        // Filter berdasarkan Pertanyaan
        if ($request->filled('pty_id')) {
            $query->where('pty_id', $request->pty_id);
        }
        
        // Dapatkan daftar template survei aktif
        $template_list = TemplateSurvei::where('tsu_status', 1)->get();
        // Dapatkan daftar pertanyaan aktif
        $pertanyaan_list = Pertanyaan::where('pty_status', 1)->get();
        
        $survei_details = $query->paginate(10);
        
        return view('DaftarSurvei.index', compact(
            'survei_details',
            'template_list',
            'pertanyaan_list'
        ))->with([
            'search' => $request->search,
            'tsu_id' => $request->tsu_id,
            'pty_id' => $request->pty_id
        ]);
    }

    public function save(Request $request)
    {
        $request->validate([
            // Gunakan tsu_id dan validasi terhadap tabel bpm_mstemplatesurvei
            'tsu_id'   => 'required|exists:bpm_mstemplatesurvei,tsu_id',
            'pty_id'   => 'required|exists:bpm_mspertanyaan,pty_id',
            'skp_id'   => 'required|exists:bpm_msskalapenilaian,skp_id',
            'dtt_nilai'=> 'required|integer'
        ]);
        
        $loggedInUsername = Session::get('karyawan.nama_lengkap');

        DaftarSurvei::create([
            'tsu_id'          => $request->input('tsu_id'),
            'pty_id'          => $request->input('pty_id'),
            'skp_id'          => $request->input('skp_id'),
            'dtt_nilai'       => $request->input('dtt_nilai'),
            'dtt_created_by'  => $loggedInUsername,
            'dtt_created_date'=> now(),
        ]);

        return redirect()->route('DaftarSurvei.index')
            ->with('success', 'Survey response saved successfully');
    }

    public function edit($id)
    {
        // Perhatikan: relasi diubah dari survei ke templateSurvei
        $survei_detail = DaftarSurvei::with(['templateSurvei', 'pertanyaan', 'skalaPenilaian'])->find($id);
        if (!$survei_detail) {
            return redirect()->route('DaftarSurvei.index')
                ->with('error', 'Survey response not found');
        }

        $template_list      = TemplateSurvei::where('tsu_status', 1)->get();
        $pertanyaan_list    = Pertanyaan::where('pty_status', 1)->get();
        $skala_penilaian_list = SkalaPenilaian::where('skp_status', 1)->get();

        return view('DaftarSurvei.edit', compact(
            'survei_detail',
            'template_list',
            'pertanyaan_list',
            'skala_penilaian_list'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tsu_id'   => 'required|exists:bpm_mstemplatesurvei,tsu_id',
            'pty_id'   => 'required|exists:bpm_mspertanyaan,pty_id',
            'skp_id'   => 'required|exists:bpm_msskalapenilaian,skp_id',
            'dtt_nilai'=> 'required|integer'
        ]);

        $loggedInUsername = Session::get('karyawan.nama_lengkap');
        
        if (!$loggedInUsername) {
            return redirect()->route('login')
                ->with('alert', 'Session has expired. Please login again.');
        }

        $survei_detail = DaftarSurvei::find($id);
        if (!$survei_detail) {
            return redirect()->route('DaftarSurvei.index')
                ->with('error', 'Survey response not found');
        }

        $survei_detail->update([
            'tsu_id'         => $request->input('tsu_id'),
            'pty_id'         => $request->input('pty_id'),
            'skp_id'         => $request->input('skp_id'),
            'dtt_nilai'      => $request->input('dtt_nilai'),
            'dtt_modif_by'   => $loggedInUsername,
            'dtt_modif_date' => now()
        ]);

        return redirect()->route('DaftarSurvei.index')
            ->with('success', 'Survey response updated successfully');
    }

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

    public function add()
    {
        $template_list      = TemplateSurvei::where('tsu_status', 1)->get();
        $pertanyaan_list    = Pertanyaan::where('pty_status', 1)->get();
        $skala_penilaian_list = SkalaPenilaian::where('skp_status', 1)->get();
        
        return view('DaftarSurvei.add', compact(
            'template_list',
            'pertanyaan_list',
            'skala_penilaian_list'
        ));
    }
}
