<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_eng',
        'name_hindi',
        'stamp_duty_in_percenatge', 'latt','long'
    ];

    protected $table = 'districts';

    // Define the inverse relationship to MaitriDetail
    public function maitriDetails()
    {
        return $this->hasMany(MaitriDetail::class, 'district_id');
    }
}
