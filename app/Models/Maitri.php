<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
class Maitri extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'maitries';
    protected $fillable = [
        'zone_id',
        'division_id',
        'district_id',
        'mandal_name',
        'janpad_name',
        'maitri_name',
        'maitri_mobile_no',
        'gram_panchayat',
        'post_office',
        'block',
        'tehsil',
        'adhaar_card',
        'father_name',
        'father_mobile_no',
        'certificate_no',
        'center_name',
        'pass_date',
        'expiry_date',
        'any_bharat_id',
        'equipment_received',
        'longitude',
        'latitude',
        'status',
        'newMaitri',
        'role_id',
        'role',
        'email',
        'password',
        'gender',
        'pincode',
        'avedan_id',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
