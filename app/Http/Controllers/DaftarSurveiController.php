<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DaftarSurvei;
use App\Models\Survei;
use App\Models\Pertanyaan;
use App\Models\SkalaPenilaian;
use Illuminate\Support\Facades\Session;

class DaftarSurveiController extends Controller
{
    public function index(Request $request)
    {
        $query = DaftarSurvei::query()
            ->with(['survei.karyawan', 'survei.templateSurvei', 'pertanyaan', 'skalaPenilaian']);
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('survei.karyawan', function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%");
            })->orWhereHas('survei.templateSurvei', function($q) use ($search) {
                $q->where('tsu_nama', 'LIKE', "%{$search}%");
            });
        }
        
        // Survey filter
        if ($request->filled('trs_id')) {
            $query->where('trs_id', $request->trs_id);
        }
        
        // Question filter
        if ($request->filled('pty_id')) {
            $query->where('pty_id', $request->pty_id);
        }
        
        $survei_list = Survei::with('templateSurvei')
            ->where('trs_status', 1)
            ->get();
        
        $pertanyaan_list = Pertanyaan::where('pty_status', 1)->get();
        
        $survei_details = $query->paginate(10);
        
        return view('DaftarSurvei.index', compact(
            'survei_details',
            'survei_list',
            'pertanyaan_list'
        ))->with([
            'search' => $request->search,
            'trs_id' => $request->trs_id,
            'pty_id' => $request->pty_id
        ]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'trs_id' => 'required|exists:bpm_trsurvei,trs_id',
            'pty_id' => 'required|exists:bpm_mspertanyaan,pty_id',
            'skp_id' => 'required|exists:bpm_msskalapenilaian,skp_id',
            'dtt_nilai' => 'required|integer'
        ]);
        
        $loggedInUsername = Session::get('karyawan.nama_lengkap');

        DaftarSurvei::create([
            'trs_id' => $request->input('trs_id'),
            'pty_id' => $request->input('pty_id'),
            'skp_id' => $request->input('skp_id'),
            'dtt_nilai' => $request->input('dtt_nilai'),
            'dtt_created_by' => $loggedInUsername,
            'dtt_created_date' => now(),
        ]);

        return redirect()->route('DaftarSurvei.index')
            ->with('success', 'Survey response saved successfully');
    }

    public function edit($id)
    {
        $survei_detail = DaftarSurvei::with(['survei', 'pertanyaan', 'skalaPenilaian'])->find($id);
        if (!$survei_detail) {
            return redirect()->route('DaftarSurvei.index')
                ->with('error', 'Survey response not found');
        }

        $survei_list = Survei::where('trs_status', 1)->get();
        $pertanyaan_list = Pertanyaan::where('pty_status', 1)->get();
        $skala_penilaian_list = SkalaPenilaian::where('skp_status', 1)->get();

        return view('DaftarSurvei.edit', compact(
            'survei_detail',
            'survei_list',
            'pertanyaan_list',
            'skala_penilaian_list'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'trs_id' => 'required|exists:bpm_trsurvei,trs_id',
            'pty_id' => 'required|exists:bpm_mspertanyaan,pty_id',
            'skp_id' => 'required|exists:bpm_msskalapenilaian,skp_id',
            'dtt_nilai' => 'required|integer'
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
            'trs_id' => $request->input('trs_id'),
            'pty_id' => $request->input('pty_id'),
            'skp_id' => $request->input('skp_id'),
            'dtt_nilai' => $request->input('dtt_nilai'),
            'dtt_modif_by' => $loggedInUsername,
            'dtt_modif_date' => now()
        ]);

        return redirect()->route('DaftarSurvei.index')
            ->with('success', 'Survey response updated successfully');
    }

    public function detail($id)
    {
        $survei_detail = DaftarSurvei::with([
            'survei.karyawan',
            'survei.templateSurvei',
            'pertanyaan',
            'skalaPenilaian'
        ])->find($id);
        
        if (!$survei_detail) {
            return redirect()->route('SurveiDetail.index')
                ->with('error', 'Survey response not found');
        }

        return view('SurveiDetail.detail', compact('survei_detail'));
    }

    public function add()
    {
        $survei_list = Survei::where('trs_status', 1)->get();
        $pertanyaan_list = Pertanyaan::where('pty_status', 1)->get();
        $skala_penilaian_list = SkalaPenilaian::where('skp_status', 1)->get();
        
        return view('DaftarSurvei.add', compact(
            'survei_list',
            'pertanyaan_list',
            'skala_penilaian_list'
        ));
    }
}