<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailDtt extends Model
{
    // Nama tabel
    protected $table = 'bpm_dttemplatesurvei';

    // Primary Key
    protected $primaryKey = 'dtb_id';

    // Apakah menggunakan timestamp bawaan Laravel (created_at dan updated_at)?
    public $timestamps = false;

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'dtt_id',
        'pty_id',
        'skp_id',
        'pty_pertanyaan',
        'dtb_created_by',
        'dtb_created_date',
        'dtb_modif_by',
        'dtb_modif_date',
    ];

    // Relasi ke tabel lain (jika ada)
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pty_id', 'pty_id');
    }

    public function dts()
    {
        return $this->belongsTo(DaftarSurvei::class, 'dtt_id', 'dtt_id');
    }

    public function sekala()
    {
        return $this->belongsTo(SkalaPenilaian::class, 'skp_id', 'skp_id');
    }
}
