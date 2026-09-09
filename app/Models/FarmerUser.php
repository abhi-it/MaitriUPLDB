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
        'CompanyEnterpriseName',
        'FirstName',
        'LastName',
        'MobileNumber',
        'name',
        'gender',
        'pincode',
        'district_id',
        'division_id',
        'zone_id',
        'email',
        'role',
        'role_id',
        'user_type',
        'email_verified_at',
        'password',
        'remember_token',
        'cattale_no',
        'animal_type',
        'breeds',
        'bharat_id',
        'gram_panchayat',
        'post_office',
        'block',
        'tehsil',
        'milk_day',
        'ai_center',
        'otp_login',
        'created_at',
        'updated_at'
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


}
