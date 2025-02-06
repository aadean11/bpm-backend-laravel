<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survei extends Model
{
    use HasFactory;

    protected $table = 'bpm_trsurvei';
    protected $primaryKey = 'trs_id';
    public $timestamps = false;

    protected $fillable = [
        'tsu_id',
        'kry_id',
        'trs_status',
        'trs_created_by',
        'trs_created_date',
        'trs_modif_by',
        'trs_modif_date',
    ];

    protected $casts = [
        'trs_created_date' => 'datetime',
        'trs_modif_date' => 'datetime',
    ];

    // Relation to TemplateSurvei
    public function templateSurvei()
    {
        return $this->belongsTo(TemplateSurvei::class, 'tsu_id', 'tsu_id');
    }

    // Relation to Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'kry_id', 'kry_id');
    }

    // Detail Survei relation
    public function surveyDetails()
    {
        return $this->hasMany(DetailSurvei::class, 'trs_id');
    }


}
