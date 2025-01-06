<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'kry_id';
    protected $table = "mskaryawan";

    protected $fillable = [
        "ksr_username",
        "ksr_status",
        "kry_password",
        "kry_nama_lengkap",
        "kry_email",
        "kry_role",
        "kry_status_kary",
        "kry_created_by",
        "kry_modif_by",
        "kry_modif_date"
    ];
}
