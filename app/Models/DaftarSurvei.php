<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarSurvei extends Model
{
    use HasFactory;
    
    protected $table = 'bpm_dttrsurvei';
    protected $primaryKey = 'dtt_id';
    public $timestamps = false;
    
    protected $fillable = [
        'trs_id',          // ID Survei
        'pty_id',          // ID Pertanyaan
        'skp_id',          // ID Skala Penilaian
        'dtt_nilai',       // Nilai Jawaban
        'dtt_created_by',  // Pembuat Data
        'dtt_created_date',// Tanggal Dibuat
        'dtt_modif_by',    // User yang Memodifikasi
        'dtt_modif_date',  // Tanggal Modifikasi
    ];
    
    protected $casts = [
        'dtt_created_date' => 'datetime',
        'dtt_modif_date' => 'datetime',
    ];
    
    // Relasi ke tabel Survei
    public function survei()
    {
        return $this->belongsTo(Survei::class, 'trs_id', 'trs_id');
    }

    // Relasi ke tabel Pertanyaan
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pty_id', 'pty_id');
    }

    // Relasi ke tabel SkalaPenilaian
    public function skalaPenilaian()
    {
        return $this->belongsTo(SkalaPenilaian::class, 'skp_id', 'skp_id');
    }
}
