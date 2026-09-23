<?php

namespace App\Http\Resources\Api\Maitri;

use Illuminate\Http\Resources\Json\JsonResource;

class DemandRequestResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id'                        => $this->id,
            'maitrie_id'                => $this->maitrie_id,
            'name'                      => $this->name,
            'date_of_birth'             => $this->date_of_birth,
            'gender'                    => $this->gender,
            'training_center_id'        => $this->training_center_id,
            'training_center_name_en'   => $this->whenLoaded('Institute', fn() => $this->Institute?->name_en),
            'training_center_name_hi'   => $this->whenLoaded('Institute', fn() => $this->Institute?->name),
            'bharat_pashudhan_id'       => $this->bharat_pashudhan_id,
            'smart_mobile_no'           => $this->smart_mobile_no,

            'district_id'               => $this->district,
            'district_name'             => $this->whenLoaded('districtName', fn() => $this->districtName?->name_hindi),

            'mandal'                    => $this->mandal,
            'tehsil'                    => $this->tehsil,
            'block'                     => $this->block,
            'vikas_khand'               => $this->vikas_khand,
            'vh_ai_center'              => $this->vh_ai_center,
            'pincode'                   => $this->pincode,
            'post_office'               => $this->post_office,
            'villages_coevring'         => $this->villages_coevring,
            'demand_section'            => $this->demand_section,

            // Arrays on output for convenience
            'semen'                     => $this->csvToArray($this->semen),
            'breed'                     => $this->csvToArray($this->breed),
            'bull_id'                   => $this->csvToArray($this->bull_id),
            'Sheath'                    => $this->csvToArray($this->Sheath),
            'semen_type'                => $this->csvToArray($this->semen_type),
            'semen_source'              => $this->csvToArray($this->semen_source),

            'gloves'                    => $this->gloves,
            'animal_tag'                => $this->animal_tag,
            'mineral_mixture'           => $this->mineral_mixture,
            'dewormer'                  => $this->dewormer,
            'insurance_booklet'         => $this->insurance_booklet,
            'pregnancy_feed'            => $this->pregnancy_feed,
            'calf_starter'              => $this->calf_starter,
            'any_other_item'            => $this->any_other_item,
            'any_suggestion'            => $this->any_suggestion,
            'any_complaint'             => $this->any_complaint,
            'training_year'             => $this->training_year,
            'month'                     => $this->month,
            'question'                  => $this->question,
            'registered_cow_calves'     => $this->registered_cow_calves,
            'registered_buffalo_calves' => $this->registered_buffalo_calves,
            'registered_sexed_calves'   => $this->registered_sexed_calves,
            'registered_farmers'        => $this->registered_farmers,

            'created_at'                => $this->created_at?->toDateTimeString(),
            'updated_at'                => $this->updated_at?->toDateTimeString(),
        ];
    }

    private function csvToArray($value): array
    {
        if (!$value) {
            return [];
        }
        return array_values(array_filter(array_map('trim', explode(',', $value)), fn($v) => $v !== ''));
    }
}
