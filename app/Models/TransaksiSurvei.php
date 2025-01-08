<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiSurvei extends Model
{
    use HasFactory;

    protected $table = 'bpm_trtransaksisurvei';

    protected $primaryKey = 'trs_id';

    public $timestamps = false;

    protected $fillable = [
        'tsu_id',
        'trs_responden',
        'trs_tanggal',
        'trs_status',
        'trs_created_by',
        'trs_created_date',
        'trs_modif_by',
        'trs_modif_date',
    ];

    /**
     * Get the KSR associated with this TemplateSurvei.
     */
    public function tsu()
    {
        return $this->belongsTo(TemplateSurvei::class, 'tsu_id');
    }

    /**
     * Get the SKP associated with this TemplateSurvei.
     */
    public function skp()
    {
        return $this->belongsTo(SkalaPenilaian::class, 'skp_id');
    }
}
