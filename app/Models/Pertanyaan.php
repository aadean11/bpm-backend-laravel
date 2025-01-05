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
    use HasFactory;

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
        'pty_role_responden',
    ];
}
