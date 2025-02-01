<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateDetail extends Model
{
    use HasFactory;

    protected $table = 'bpm_mstemplatesurveidetail';

    protected $primaryKey = 'tsd_id';

    public $timestamps = false;

    protected $fillable = [
        'tsu_id',
        'tsd_pertanyaan',
        'tsd_isheader',
        'tsd_jenis',
        'tsd_status',
        'tsd_created_by',
        'tsd_created_date',
        'tsd_modif_by',
        'tsd_modif_date',
    ];

    /**
     * Get the TemplateSurvei associated with this TemplateDetail.
     */
    public function kriteria()
    {
        return $this->belongsTo(KriteriaSurvei::class, 'ksr_id'); // Sesuaikan dengan nama FK
    }

    // Relasi ke SkalaPenilaian
    public function skala()
    {
        return $this->belongsTo(SkalaPenilaian::class, 'skp_id'); // Sesuaikan dengan nama FK
    }

    public function getKriteriaNamaAttribute()
{
    return $this->kriteria ? $this->kriteria->ksr_nama : 'Tidak Ada';
}

public function getSkalaNamaAttribute()
{
    return $this->skala ? $this->skala->skl_nama : 'Tidak Ada';
}

public function templatesurvey()
{
    return $this->belongsTo(TemplateSurvei::class, 'tsu_id');
}
}
