<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MaitriDistrictLatLong extends Model {
    protected $table = "maitri_districts_lat_long";

    protected $fillable = ['district', 'latitude', 'longitude'];

    public function maitriPortal()
    {
        return $this->hasMany(MaitriPortal::class, 'maitri_districts_lat_long_id');
    }
}