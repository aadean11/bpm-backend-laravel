<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KriteriaSurvei extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'ksr_id';
    protected $table = "bpm_mskriteriasurvei";

    protected $fillable = [
        "ksr_nama",       
        "ksr_status",     
        "ksr_created_by", 
        "ksr_created_date", 
        "ksr_modif_by",   
        "ksr_modif_date"  
    ];
}
