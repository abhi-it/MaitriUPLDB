<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaitriPortal extends Model
{
    use HasFactory;

    protected $table = 'maitri_portals'; // Specify the table name

    // Define the relationship with MaitriDistrictLatLong model
    public function districtLatLong()
    {
        return $this->belongsTo(MaitriDistrictsLatLong::class, 'maitri_districts_lat_long_id');
    }
}
