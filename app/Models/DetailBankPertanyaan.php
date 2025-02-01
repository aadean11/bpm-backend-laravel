<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBankPertanyaan extends Model
{
    use HasFactory;

    protected $table = 'bpm_dtlbankpertanyaan'; // Pastikan nama tabelnya benar

    protected $fillable = [
        'pty_id',
        'kry_id',
        'dtl_status',
        'dtl_created_by',
        'dtl_created_date',
        'dtl_modif_by',
        'dtl_modif_date',
    ];
}
