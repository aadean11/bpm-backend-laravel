<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'bpm_mspertanyaan';
    protected $primaryKey = 'pty_id';

    public $timestamps = false;

    protected $fillable = [
        'pty_pertanyaan',
        'pty_isheader',
        'pty_isgeneral',
        'pty_status',
        'pty_created_by',
        'pty_created_date',
        'pty_modif_by',
        'pty_modif_date',
        'ksr_id',
        'skp_id',
        'pty_role_responden',
    ];

    // Relasi ke KriteriaSurvei// Model Pertanyaan
        public function kriteriaSurvei()
        {
            return $this->belongsTo(KriteriaSurvei::class, 'ksr_id');
        }

        public function skalaPenilaian()
        {
            return $this->belongsTo(SkalaPenilaian::class, 'skp_id');  
        }

            public function getKriteriaNamaAttribute()
        {
            return $this->kriteria ? $this->kriteria->ksr_nama : 'Tidak Ada';
        }

        public function getSkalaNamaAttribute()
        {
            return $this->skala ? $this->skala->skl_nama : 'Tidak Ada';
        }

}
