<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'avedan_id',
        'mobile_number' ,
        'otp' ,
        'expire_at' ,
        'created_at',
        'updated_at',
    ];
    protected $table = 'otp_verification';
}
