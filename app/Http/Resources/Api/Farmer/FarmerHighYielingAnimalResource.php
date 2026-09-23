<?php

namespace App\Http\Resources\Api\Farmer;

use Illuminate\Http\Resources\Json\JsonResource;

class FarmerHighYielingAnimalResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'type'       => $this->type,
            'label_type' => getYeildingAnimal($this->type),
            'file'       => $this->file,
            'file_url'   => $this->file ? asset('assets/animals/' . $this->file) : null,
            'details'    => $this->details,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
