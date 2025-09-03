<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lakshya extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_eng','division_id','name_hindi','stamp_duty_in_percenatge', 'latt','long','year','general_target','obc_target',
        'sc_target','st_target','status'
    ];

    protected $table = 'lakshya';

    public function maitriDetails()
    {
        return $this->hasMany(MaitriDetail::class, 'district_id');
    }
}
