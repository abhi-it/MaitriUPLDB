<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usermeta extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id','bharat_id','breeds','cattale_no','gram_panchayat','post_office','block','tehsil','traing_center','ai_center'
    ];

    protected $table = 'user_meta';
}
