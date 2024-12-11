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
    ];
}
