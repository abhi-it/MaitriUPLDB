<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animalinformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'milk_day',
        'animal_type',
        'breeds',
        'cattale_no',
    ];

    protected $table = 'user_animal_information';
}