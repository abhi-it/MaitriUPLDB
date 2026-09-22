<?php

namespace App\Http\Resources\Api\Maitri;

use Illuminate\Http\Resources\Json\JsonResource;

class MaitriDashboardResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'maitri'           => new MaitriResource($this['maitri']),
            'service_requests' => ServiceRequestResource::collection($this['service_requests']),
        ];
    }
}
