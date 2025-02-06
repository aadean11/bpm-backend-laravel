<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'mskaryawan'; // Nama tabel di database
    protected $primaryKey = 'kry_id';
    public $timestamps = false; 
    protected $fillable = [
        'kry_username',
        'kry_password',
        'kry_nama_lengkap',
        'kry_email',
        'kry_role',
        'kry_status_kary',
        'kry_created_by',
        'kry_created_date',
        'kry_modif_by',
        'kry_modif_date',
    ];

    protected $hidden = ['kry_password'];
}
