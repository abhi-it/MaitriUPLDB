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
        'refresher_training',
        'refresher_training_at',
    ];

    protected $casts = [
        'refresher_training' => 'boolean',
        'refresher_training_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * True when pass-out is older than 3 years.
     * Supports formats like 2022-23, 2022, or Y-m-d dates.
     */
    public function needsRefresherTraining(): bool
    {
        $passYear = $this->getPassOutYear();
        if (!$passYear) {
            return false;
        }

        return (now()->year - $passYear) >= 3;
    }

    public function getPassOutYear(): ?int
    {
        $passDate = trim((string) $this->pass_date);
        if ($passDate === '') {
            return null;
        }

        if (preg_match('/^(\d{4})\s*[-–\/]\s*(\d{2}|\d{4})$/', $passDate, $matches)) {
            return (int) $matches[1];
        }

        if (preg_match('/^(\d{4})$/', $passDate, $matches)) {
            return (int) $matches[1];
        }

        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $passDate, $matches)) {
            return (int) $matches[1];
        }

        $timestamp = strtotime($passDate);
        if ($timestamp) {
            return (int) date('Y', $timestamp);
        }

        return null;
    }

}
