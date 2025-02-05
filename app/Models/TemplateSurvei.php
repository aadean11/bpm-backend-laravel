<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateSurvei extends Model
{
    use HasFactory;

    protected $table = 'bpm_mstemplatesurvei';
    protected $primaryKey = 'tsu_id';
    public $timestamps = false;

    protected $fillable = [
        'tsu_nama',
        'tsu_status',
        'pty_id',
        'tsu_created_by',
        'tsu_created_date',
        'tsu_modif_by',
        'tsu_modif_date',
    ];

    /**
     * Relasi dengan KriteriaSurvei
     */
    public function kriteriaSurvei()
    {
        return $this->belongsTo(KriteriaSurvei::class, 'ksr_id');
    }

    /**
     * Relasi dengan Pertanyaan
     */
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pty_id');
    }

    /**
     * Relasi dengan SkalaPenilaian
     */
    public function skalaPenilaian()
    {
        return $this->belongsTo(SkalaPenilaian::class, 'skp_id');
    }
}
