<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maitri extends Model
{
    use HasFactory;
    protected $table = 'maitries';
    protected $fillable = [
        'zone_id',
        'division_id',
        'district_id',
        'mandal_name',
        'janpad_name',
        'maitri_name',
        'maitri_mobile_no',
        'gram_panchayat',
        'post_office',
        'block',
        'tehsil',
        'adhaar_card',
        'father_name',
        'father_mobile_no',
        'certificate_no',
        'center_name',
        'pass_date',
        'expiry_date',
        'any_bharat_id',
        'equipment_received',
        'longitude',
        'latitude',
    ];
}
