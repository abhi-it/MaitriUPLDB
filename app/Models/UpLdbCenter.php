<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpLdbCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'icon',
        'latitude',
        'longitude',
        'maitri_districts_lat_long_id',
    ];

    // Define the relationship with 'maitri_districts_lat_long' table
    public function maitriDistrict()
    {
        return $this->belongsTo(MaitriDistrictLatLong::class, 'maitri_districts_lat_long_id');
    }
}
