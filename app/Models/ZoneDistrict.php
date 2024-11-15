<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneDistrict extends Model
{
    use HasFactory;

    protected $table = 'zone_district';

    protected $fillable = [
        'zone_id',
        'district_id',
    ];
}



