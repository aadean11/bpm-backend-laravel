<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTemplateSurvei extends Model
{
    protected $table = 'bpm_dttemplatesurvei'; // Nama tabel di database
    protected $primaryKey = 'dts_id';
    
    public $timestamps = false; // Karena sudah ada created_date & modified_date di database
    
    protected $fillable = [
        'tsu_id',
        'pty_id',
    ];

    // Relasi ke Template Survei
    public function templateSurvei()
    {
        return $this->belongsTo(TemplateSurvei::class, 'tsu_id', 'tsu_id');
    }

    // Relasi ke Pertanyaan
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pty_id', 'pty_id');
    }
}
