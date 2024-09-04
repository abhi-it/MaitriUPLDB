<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     // 'dis_id',
    //     // 'block_name',
    //     // 'village_name',    
    // ];

    protected $table = 'bankslist';
}
