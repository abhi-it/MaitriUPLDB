<?php

namespace App\Http\Resources\Api\Farmer;

use Illuminate\Http\Resources\Json\JsonResource;

class FarmerServiceRequestResource extends JsonResource
{
    public function toArray($request)
    {
        $lang = $request->header('lang');
        return [
            'id'              => $this->id,
            'user_id'         => $this->user_id,
            'service_name'    => $this->service_name,
            'formatted_service_name'  => $this->getFormattedServiceName($this->service_name,$lang),
            'maitri_id'       => $this->maitri_id,
            'request_message' => $this->request_message,
            'status'          => $this->status,
            'formatted_status' => getServiceStatusLabel($this->status, $lang),
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
            'maitri'            => $this->whenLoaded('maitri', function () {
                return [
                    'id' => $this->maitri->id,
                    'maitri_name' => $this->maitri->maitri_name,
                    'maitri_mobile_no' => $this->maitri->maitri_mobile_no, 
                    'email' => $this->maitri->email, 
                    'district_id' => $this->maitri->district_id, 
                    'block' => $this->maitri->block, 
                    'tehsil' => $this->maitri->tehsil, 
                    'center_name' => $this->maitri->center_name 
                ];
            }),
        ];
    }

    protected function getFormattedServiceName($serviceName,$lang)
    {
        return getServiceLabel($serviceName, $lang);
    }
}
