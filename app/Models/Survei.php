<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survei extends Model
{
    use HasFactory;

    protected $table = 'bpm_mssurvei';

    protected $primaryKey = 'sur_id';

    public $timestamps = false;

    protected $fillable = [
        'sur_nama',
        'tsu_id',
        'sur_created_by',
        'sur_created_date',
        'sur_modif_by',
        'sur_modif_date',
    ];

    public function templateSurvei()
    {
        return $this->belongsTo(TemplateSurvei::class, 'tsu_id');
    }
}
