<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSurvei extends Model
{
    use HasFactory;
    
    protected $table = 'bpm_dttrsurvei';
     protected $primaryKey = 'dtt_id';
    public $timestamps = false; // atau true, sesuaikan

    protected $fillable = [
        'trs_id',
        'pty_id',
        'skp_id',
        'dtt_nilai',
        'dtt_created_by',
        'dtt_created_date',
        'dtt_modif_by',
        'dtt_modif_date'
    ];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pty_id');
    }

    public function skala()
    {
        return $this->belongsTo(SkalaPenilaian::class, 'skp_id');
    }
}
