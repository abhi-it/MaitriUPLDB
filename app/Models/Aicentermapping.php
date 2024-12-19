<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aicentermapping extends Model
{
    use HasFactory;
    protected $fillable = [
        'aiCenter_id',
        'janpad_name',
        'maitri_id',
    ];

    protected $table = 'ai_center_maitri_mapping';
}
