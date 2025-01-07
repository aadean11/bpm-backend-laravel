<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkalaPenilaian extends Model
{
    use HasFactory;

    protected $table = 'bpm_msskalapenilaian';
    protected $primaryKey = 'skp_id';
    public $timestamps = false;

    protected $fillable = [
        'skp_skala',
        'skp_deskripsi',
        'skp_tipe',
        'skp_status',
        'skp_created_by',
        'skp_created_date',
        'skp_modif_by',
        'skp_modif_date',
    ];

    // Format untuk kolom tanggal jika diperlukan
    protected $casts = [
        'skp_created_date' => 'datetime',
        'skp_modif_date' => 'datetime',
    ];

    // Relasi balik ke Pertanyaan
    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class, 'skala_id');
    }
}

