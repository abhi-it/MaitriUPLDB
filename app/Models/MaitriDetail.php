<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MaitriDetail extends Model
{
    protected $table = 'maitridetails';

    // Define the relationship to the District model
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
