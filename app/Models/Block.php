<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;
    protected $fillable = [
        'dis_id',
        'block_name',
        'block_hindi',
        'village_name',    
    ];

    protected $table = 'blocks';
}
