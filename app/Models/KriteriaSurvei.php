<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KriteriaSurvei extends Model
{
    public $timestamps = false;
    protected $table = "bpm_mskriteriasurvei";
    protected $primaryKey = 'ksr_id'; // Primary key
    protected $fillable = [
        "ksr_nama",       
        "ksr_status",     
        "ksr_created_by", 
        "ksr_created_date", 
        "ksr_modif_by",   
        "ksr_modif_date"  
    ];

    // Relasi ke tabel Pertanyaan
    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class, 'ksr_id'); // Relasi dengan foreign key 'ksr_id'
    }
}
