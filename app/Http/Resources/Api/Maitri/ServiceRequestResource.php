<?php

namespace App\Http\Resources\Api\Maitri;

use App\Http\Resources\Api\Maitri\FarmerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRequestResource extends JsonResource
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
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
            'user'            => $this->whenLoaded('user', function () {
                return [
                    'id'                   => $this->user->id,
                    'FirstName'            => $this->user->FirstName,
                    'LastName'             => $this->user->LastName,
                    'MobileNumber'         => $this->user->MobileNumber,
                    'name'                 => $this->user->name,
                    'gender'               => $this->user->gender,
                    'pincode'              => $this->user->pincode,
                    'email'                => $this->user->email
                ];
            }),
        ];
    }

    protected function getFormattedServiceName($serviceName,$lang)
    {
        return getServiceLabel($serviceName, $lang);
    }
}
