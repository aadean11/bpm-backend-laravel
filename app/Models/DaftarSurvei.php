<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarSurvei extends Model
{
    use HasFactory;
    
    protected $table = 'bpm_dttrsurvei';
    protected $primaryKey = 'dtt_id';
    public $timestamps = false;
    
    protected $fillable = [
        'trs_id',
        'pty_id',
        'skp_id',
        'dtt_nilai',
        'dtt_created_by',
        'dtt_created_date',
        'dtt_modif_by',
        'dtt_modif_date',
    ];
    
    protected $casts = [
        'dtt_created_date' => 'datetime',
        'dtt_modif_date' => 'datetime',
    ];
    
    // Relation to Survei
    public function survei()
    {
        return $this->belongsTo(Survei::class, 'trs_id', 'trs_id');
    }
    
    // Relation to Pertanyaan
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pty_id', 'pty_id');
    }
    
    // Relation to SkalaPenilaian
    public function skalaPenilaian()
    {
        return $this->belongsTo(SkalaPenilaian::class, 'skp_id', 'skp_id');
    }
}