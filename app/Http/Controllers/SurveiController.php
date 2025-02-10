<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survei;
use App\Models\TemplateSurvei;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Session;

class SurveiController extends Controller
{
    public function index(Request $request)
    {
        $query = Survei::query()->with(['templateSurvei', 'karyawan']);
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('karyawan', function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%");
            })->orWhereHas('templateSurvei', function($q) use ($search) {
                $q->where('tsu_nama', 'LIKE', "%{$search}%");
            });
        }
        
        // Template filter
        if ($request->filled('tsu_id')) {
            $query->where('tsu_id', $request->tsu_id);
        }
        
        // Status filter
        if ($request->filled('trs_status')) {
            $query->where('trs_status', $request->trs_status);
        } else {
            $query->where('trs_status', 1);
        }
        
        // Get template options for dropdown
        $template_options = TemplateSurvei::select('tsu_id', 'tsu_nama')
            ->where('tsu_status', 1)
            ->get();
        
        $survei_list = $query->paginate(10);
        
        return view('Survei.index', compact(
            'survei_list',
            'template_options'
        ))->with([
            'search' => $request->search,
            'tsu_id' => $request->tsu_id,
            'trs_status' => $request->trs_status
        ]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'tsu_id' => 'required|exists:bpm_mstemplatesurvei,tsu_id',
            'kry_id' => 'required|exists:mskaryawan,kry_id',
        ]);
        
        $loggedInUsername = Session::get('karyawan.nama_lengkap');

        Survei::create([
            'tsu_id' => $request->input('tsu_id'),
            'kry_id' => $request->input('kry_id'),
            'trs_status' => 1,
            'trs_created_by' => $loggedInUsername,
            'trs_created_date' => now(),
        ]);

        return redirect()->route('Survei.index')
            ->with('success', 'Survey assigned successfully');
    }

    public function edit($id)
    {
        $survei = Survei::with(['templateSurvei', 'karyawan'])->find($id);
        if (!$survei) {
            return redirect()->route('Survei.index')
                ->with('error', 'Survey not found');
        }

        $template_options = TemplateSurvei::where('tsu_status', 1)->get();
        $karyawan_list = Karyawan::where('kry_status_kary', 1)->get();

        return view('Survei.edit', compact('survei', 'template_options', 'karyawan_list'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tsu_id' => 'required|exists:bpm_mstemplatesurvei,tsu_id',
            'kry_id' => 'required|exists:mskaryawan,kry_id',
        ]);

        $loggedInUsername = Session::get('karyawan.nama_lengkap');
        
        if (!$loggedInUsername) {
            return redirect()->route('login')
                ->with('alert', 'Session has expired. Please login again.');
        }

        $survei = Survei::find($id);
        if (!$survei) {
            return redirect()->route('Survei.index')
                ->with('error', 'Survey not found');
        }

        $survei->update([
            'tsu_id' => $request->input('tsu_id'),
            'kry_id' => $request->input('kry_id'),
            'trs_modif_by' => $loggedInUsername,
            'trs_modif_date' => now()
        ]);

        return redirect()->route('Survei.index')
            ->with('success', 'Survey updated successfully');
    }

    public function detail($id)
{
    $survei = Survei::with(['templateSurvei', 'karyawan', 'surveyDetails.pertanyaan'])->find($id);
    
    if (!$survei) {
        return redirect()->route('Survei.index')
            ->with('error', 'Survey tidak ditemukan.');
    }
    
    return view('Survei.detail', compact('survei'));
}

    public function toggleStatus($id)
    {
        $survei = Survei::find($id);
        if (!$survei) {
            return response()->json(['success' => false], 404);
        }

        $survei->update([
            'trs_status' => !$survei->trs_status,
            'trs_modif_by' => Session::get('karyawan.nama_lengkap'),
            'trs_modif_date' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function add()
    {
        $template_options = TemplateSurvei::where('tsu_status', 1)->get();
        $karyawan_list = Karyawan::where('kry_status_kary', 1)->get();
        
        return view('Survei.add', compact('template_options', 'karyawan_list'));
    }
}