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
     * Get the karyawan (employee) associated with this template.
     */

    /**
     * Get the pertanyaan (question) associated with this template.
     */
    public function pertanyaan()
    {
       
        return $this->belongsTo(Pertanyaan::class, 'pty_id');
    }
    public function detailTemplateSurvei()
    {
    return $this->hasMany(DetailTemplateSurvei::class, 'tsu_id', 'tsu_id');
    }
}