<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traininglist extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_date',
        'to_date',
        'days',	
        'months',
        'institute',
        'district'	,
        'ai_center'	,
        'hospital',
        'ai',
        'pd',
        'calving',
        'bharat_pshudhan_id',
    ];

    protected $table = 'refresh_training_from';
}
