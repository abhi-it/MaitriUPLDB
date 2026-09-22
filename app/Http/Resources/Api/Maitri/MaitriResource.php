<?php

namespace App\Http\Resources\Api\Maitri;

use Illuminate\Http\Resources\Json\JsonResource;

class MaitriResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                     => $this->id,
            'zone_id'                => $this->zone_id,
            'division_id'            => $this->division_id,
            'district_id'            => $this->district_id,
            'mandal_name'            => $this->mandal_name,
            'janpad_name'            => $this->janpad_name,
            'maitri_name'            => $this->maitri_name,
            'maitri_mobile_no'       => $this->maitri_mobile_no,
            'email'                  => $this->email,
            'gram_panchayat'         => $this->gram_panchayat,
            'post_office'            => $this->post_office,
            'block'                  => $this->block,
            'tehsil'                 => $this->tehsil,
            'adhaar_card'            => $this->adhaar_card,
            'father_name'            => $this->father_name,
            'father_mobile_no'       => $this->father_mobile_no,
            'certificate_no'         => $this->certificate_no,
            'center_name'            => $this->center_name,
            'pass_date'              => $this->pass_date,
            'expiry_date'            => $this->expiry_date,
            'any_bharat_id'          => $this->any_bharat_id,
            'equipment_received'     => $this->equipment_received,
            'longitude'              => $this->longitude,
            'latitude'               => $this->latitude,
            'status'                 => $this->status,
            'newMaitri'              => $this->newMaitri,
            'role'                   => $this->role,
            'role_id'                => $this->role_id,
            'gender'                 => $this->gender,
            'pincode'                => $this->pincode,
            'avedan_id'              => $this->avedan_id,
            'refresher_training'     => $this->refresher_training,
            'refresher_training_at'  => $this->refresher_training_at,
            'needs_refresher_training' => $this->needsRefresherTraining(),
            'pass_out_year'          => $this->getPassOutYear(),
            'created_at'             => $this->created_at,
            'updated_at'             => $this->updated_at,
        ];
    }
}
