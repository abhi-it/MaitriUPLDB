<?php

namespace App\Http\Resources\Api\Maitri;

use Illuminate\Http\Resources\Json\JsonResource;

class FarmerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'CompanyEnterpriseName' => $this->CompanyEnterpriseName,
            'FirstName'             => $this->FirstName,
            'LastName'              => $this->LastName,
            'MobileNumber'          => $this->MobileNumber,
            'name'                  => $this->name,
            'gender'                => $this->gender,
            'pincode'               => $this->pincode,
            'district_id'           => $this->district_id,
            'division_id'           => $this->division_id,
            'zone_id'               => $this->zone_id,
            'email'                 => $this->email,
            'role'                  => $this->role,
            'role_id'               => $this->role_id,
            'user_type'             => $this->user_type,
            'email_verified_at'     => $this->email_verified_at,
            'cattale_no'            => $this->cattale_no,
            'animal_type'           => $this->animal_type,
            'breeds'                => $this->breeds,
            'bharat_id'             => $this->bharat_id,
            'gram_panchayat'        => $this->gram_panchayat,
            'post_office'           => $this->post_office,
            'block'                 => $this->block,
            'tehsil'                => $this->tehsil,
            'milk_day'              => $this->milk_day,
            'ai_center'             => $this->ai_center,
            'otp_login'             => $this->otp_login,
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
        ];
    }
}
