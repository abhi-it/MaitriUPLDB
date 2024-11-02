<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliniclocation extends Model
{
    use HasFactory;
    protected $table = 'clinic_location';

    protected $fillable = [
        'mandal_name',
        'janpad_name',
        'block',
        'type',
        'name',
        'name_eng',
        'lattitute',
        'longitute',
    ];
}
