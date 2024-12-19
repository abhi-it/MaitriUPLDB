<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Latestaicenter extends Model
{
    use HasFactory;
    protected $fillable = [
        'zone_id',
        'division_id',
        'district_id',
        'mandal_name',
        'mandal_eng',
        'janpad_name',
        'janpad_eng',
        'tehsil',	
        'tehsil_eng',	
        'block',
        'block_eng',
        'aicenter',
        'aicenter_eng',
    ];

    protected $table = 'aicenter_latest';
}
