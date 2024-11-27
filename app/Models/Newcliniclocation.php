<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newcliniclocation extends Model
{
    use HasFactory;
    protected $table = 'clinic_location_new';

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
