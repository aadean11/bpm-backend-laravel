<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankPertanyaanDetail extends Model
{
    // Set the table name
    protected $table = 'bpm_dtbankpertanyaan_detail';
    
    // Set the primary key
    protected $primaryKey = 'dtb_id';
    
    // Disable Laravel's timestamp columns since we're using custom ones
    public $timestamps = false;
    
    // Define which fields can be mass assigned
    protected $fillable = [
        'dtt_id',
        'trs_id',
        'skp_id',
        'dtb_created_by',
        'dtb_created_date',
        'dtb_modif_by',
        'dtb_modif_date'
    ];

    // Define custom date fields
    protected $dates = [
        'dtb_created_date',
        'dtb_modif_date'
    ];

    // Relationship with DaftarSurvei (assuming that's the model name for bpm_dttrsurvei)
    public function surveiDetail()
    {
        return $this->belongsTo(DaftarSurvei::class, 'dtt_id', 'dtt_id');
    }

    // Relationship with Survei
    public function survei()
    {
        return $this->belongsTo(Survei::class, 'trs_id', 'trs_id');
    }

    // Relationship with SkalaPenilaian
    public function skalaPenilaian()
    {
        return $this->belongsTo(SkalaPenilaian::class, 'skp_id', 'skp_id');
    }

    // Boot method to handle automatic date settings
    protected static function boot()
    {
        parent::boot();

        // Set created_date on creation
        static::creating(function ($model) {
            if (!$model->dtb_created_date) {
                $model->dtb_created_date = now();
            }
        });

        // Set modif_date on update
        static::updating(function ($model) {
            $model->dtb_modif_date = now();
        });
    }
}