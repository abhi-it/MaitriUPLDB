<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewAiceter extends Model
{
    use HasFactory;
    protected $fillable = [
        'zone_id',
        'division_id',
        'district_id',	
        'district_eng',
        'district_hindi',
        'tehsil_eng',
        'tehsil_hindi',
        'block_eng',
        'block_hindi',
        'ai_center_eng'	,
        'ai_center_hindi'	,
        'maitri_associated_aiCenter'	,
        'bharat_pashudhan_id',
        'maitri_mobile_no',
        'latitude',
        'longitude'
    ];

    protected $table = 'new_mapped_aicenter';
}
