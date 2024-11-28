<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisions extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_eng',
        'name_hindi',
        'zone_id',
        'latt',
        'long',
        'place_id',
    ];
}
