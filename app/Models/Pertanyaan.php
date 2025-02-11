<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'bpm_mspertanyaan';
    protected $primaryKey = 'pty_id';
    
    public $timestamps = false; // Karena sudah ada created_date & modified_date di database

    protected $fillable = [
        'pty_pertanyaan',
        'pty_status',
        'pty_created_by',
        'pty_created_date',
        'pty_modif_by',
        'pty_modif_date',
        'ksr_id',
        'skp_id',
    ];

    // Relasi ke Kriteria Survei
    public function kriteria()
    {
        return $this->belongsTo(KriteriaSurvei::class, 'ksr_id', 'ksr_id');
    }

    // Relasi ke Skala Penilaian
    public function skala()
    {
        return $this->belongsTo(SkalaPenilaian::class, 'skp_id', 'skp_id');
    }
    public function detailBankPertanyaan()
{
    return $this->hasMany(DetailBankPertanyaan::class, 'pty_id');
}

    
}
