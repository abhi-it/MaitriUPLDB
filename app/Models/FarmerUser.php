<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\User;

class FarmerUser extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'farmer_users';
    protected $fillable = [
        'name','email', 
        'password','user_type','role','gender','pincode','gram_panchayat','post_office','block','tehsil','milk_day','animal_type','otp_login',
        'role_id','FirstName','LastName','MobileNumber','district_id','division_id','zone_id','bharat_id','breeds','cattale_no'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function district()
    {
        return $this->belongsTo(Districts::class, 'district_id', 'id');
    }

    public function getDeoUser()
    {
        return $this->hasOne(DeoUser::class, 'user_id');
    }

    public function getAnimalInformation()
    {
        return $this->hasMany(Animalinformation::class, 'user_id');
    }
    
}