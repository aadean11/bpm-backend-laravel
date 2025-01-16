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
    public function templateSurvei()
    {
        return $this->belongsTo(TemplateSurvei::class, 'tsu_id');
    }
}
