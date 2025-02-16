<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTemplatePertanyaan extends Model
{
    use HasFactory;
    
    protected $table = 'bpm_dttemplatepertanyaan';
    protected $primaryKey = 'dtp_id';
    public $timestamps = false;
    
    protected $fillable = [
        'tsu_id',
        'pty_id',
        'dtp_created_by',
        'dtp_created_date',
        'dtp_modif_by',
        'dtp_modif_date',
    ];
    
    protected $casts = [
        'dtp_created_date' => 'datetime',
        'dtp_modif_date' => 'datetime',
    ];
    
    // Relation to TemplateSurvei
    public function templateSurvei()
    {
        return $this->belongsTo(TemplateSurvei::class, 'tsu_id', 'tsu_id');
    }
    
    // Relation to Pertanyaan
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pty_id', 'pty_id');
    }
}