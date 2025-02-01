<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPertanyaan extends Model
{
    use HasFactory;

    protected $table = 'bpm_dtpertanyaan'; // Tabel yang digunakan
    protected $primaryKey = 'dtl_id'; // Primary key

    public $timestamps = false;

    protected $fillable = [
        'pty_id', 'kry_id', 'dtl_jawaban', 'dtl_status', 
        'dtl_created_by', 'dtl_created_date', 'dtl_modif_by', 'dtl_modif_date'
    ];
}
