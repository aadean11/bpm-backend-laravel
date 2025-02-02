<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBankPertanyaan extends Model
{
    protected $table = 'bpm_dtbankpertanyaan'; // Nama tabel di database
    protected $primaryKey = 'dtl_id';
    
    public $timestamps = false; // Karena sudah ada created_date & modified_date di database
    
    protected $fillable = [
        'pty_id',
        'kry_id',
        'dtl_status',
        'dtl_created_by',
        'dtl_created_date',
        'dtl_modif_by',
        'dtl_modif_date',
    ];

    // Relasi ke Pertanyaan
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pty_id', 'pty_id');
    }

    // Relasi ke Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'kry_id', 'kry_id');
    }
}
