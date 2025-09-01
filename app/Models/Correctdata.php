<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correctdata extends Model
{
    use HasFactory;
    protected $table = 'correct_data';
    protected $fillable = [
        'zone_id',
        'division_id',
        'district_id',
        'mandal_name',
        'janpad_name', 
        'block', 
        'tehsil', 
    ];
}
