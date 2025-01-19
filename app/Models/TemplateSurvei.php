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
        'tsu_created_by',
        'tsu_created_date',
        'tsu_modif_by',
        'tsu_modif_date',
        'ksr_id',
        'skp_id',
        'tsu_id',
    ];

    /**
     * Get the KSR associated with this TemplateSurvei.
     */
    public function ksr()
    {
        return $this->belongsTo(KriteriaSurvei::class, 'ksr_id');
    }

    /**
     * Get the SKP associated with this TemplateSurvei.
     */
    public function skp()
    {
        return $this->belongsTo(SkalaPenilaian::class, 'skp_id');
    }

    // TemplateSurvei.php
    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class, 'tsu_id');
    }

    // Pertanyaan.php
    public function templateSurvei()
    {
        return $this->belongsTo(TemplateSurvei::class, 'tsu_id');
    }

}
