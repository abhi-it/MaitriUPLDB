<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Maitri\DemandRequestResource;
use App\Models\DemandRequest;
use App\Models\Districts;
use App\Models\Maitri;
use App\Traits\FormatResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DemandRequestController extends Controller
{
    use FormatResponseTrait;

    public function addDemandRequest(Request $request)
    {
        try {
            $maitri = auth()->user();
            if (!$maitri instanceof Maitri) {
                return $this->errorResponse('Maitri not authenticated', 401);
            }

            $alreadyExists = DemandRequest::where('maitrie_id', $maitri->id)->exists();
            if ($alreadyExists) {
                return $this->errorResponse('You have already added a demand request', 422);
            }

            $validator = Validator::make($request->all(), [
                'name'                      => 'required|string|max:255',
                'date_of_birth'             => 'required|date',
                'gender'                    => 'required|in:male,female,other',
                'bharat_pashudhan_id'       => 'required|string|max:255',
                'training_center_id'        => 'nullable',
                'smart_mobile_no'           => 'nullable|string|max:15',
                'district'                  => 'nullable',
                'mandal'                    => 'nullable',
                'tehsil'                    => 'nullable|string|max:255',
                'block'                     => 'nullable|string|max:255',
                'vikas_khand'               => 'nullable|string|max:255',
                'vh_ai_center'              => 'nullable|string|max:255',
                'pincode'                   => 'nullable|string|max:6',
                'villages_coevring'         => 'nullable|string',
                'demand_section'            => 'nullable|string',
                'semen'                     => 'nullable|array',
                'breed'                     => 'nullable|array',
                'bull_id'                   => 'nullable|array',
                'Sheath'                    => 'nullable|array',
                'semen_type'                => 'nullable|array',
                'semen_source'              => 'nullable|array',
                'gloves'                    => 'nullable',
                'animal_tag'                => 'nullable',
                'mineral_mixture'           => 'nullable',
                'dewormer'                  => 'nullable',
                'insurance_booklet'         => 'nullable',
                'pregnancy_feed'            => 'nullable',
                'calf_starter'              => 'nullable',
                'any_other_item'            => 'nullable|string',
                'any_suggestion'            => 'nullable|string',
                'any_complaint'             => 'nullable|string',
                'post_office'               => 'nullable|string|max:255',
                'training_year'             => 'nullable',
                'month'                     => 'nullable',
                'question'                  => 'nullable|string',
                'registered_cow_calves'     => 'nullable|integer',
                'registered_buffalo_calves' => 'nullable|integer',
                'registered_sexed_calves'   => 'nullable|integer',
                'registered_farmers'        => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(ucfirst($validator->errors()->first()), 422);
            }

            $districtId  = null;
            $janpadName  = null;
            if ($request->filled('district')) {
                $district = is_numeric($request->district)
                    ? Districts::find($request->district)
                    : Districts::where('name_hindi', 'LIKE', '%' . $request->district . '%')->first();

                if ($district) {
                    $districtId = $district->id;
                    $janpadName = $district->name_hindi;
                }
            }

            $demandRequest = new DemandRequest();
            $demandRequest->maitrie_id              = $maitri->id;
            $demandRequest->name                    = $request->name;
            $demandRequest->date_of_birth           = $request->date_of_birth;
            $demandRequest->gender                  = $request->gender;
            $demandRequest->training_center_id      = $request->training_center_id;
            $demandRequest->bharat_pashudhan_id     = $request->bharat_pashudhan_id;
            $demandRequest->smart_mobile_no         = $request->smart_mobile_no;
            $demandRequest->district                = $districtId;
            $demandRequest->mandal                  = $request->mandal ?? $janpadName;
            $demandRequest->tehsil                  = $request->tehsil;
            $demandRequest->block                   = $request->block;
            $demandRequest->vikas_khand             = $request->vikas_khand;
            $demandRequest->vh_ai_center            = $request->vh_ai_center;
            $demandRequest->pincode                 = $request->pincode;
            $demandRequest->villages_coevring       = $request->villages_coevring;
            $demandRequest->demand_section          = $request->demand_section;
            $demandRequest->semen                   = $this->toCsv($request->semen);
            $demandRequest->breed                   = $this->toCsv($request->breed);
            $demandRequest->bull_id                 = $this->toCsv($request->bull_id);
            $demandRequest->Sheath                  = $this->toCsv($request->Sheath);
            $demandRequest->semen_type              = $this->toCsv($request->semen_type);
            $demandRequest->semen_source            = $this->toCsv($request->semen_source);
            $demandRequest->gloves                  = $request->gloves;
            $demandRequest->animal_tag              = $request->animal_tag;
            $demandRequest->mineral_mixture         = $request->mineral_mixture;
            $demandRequest->dewormer                = $request->dewormer;
            $demandRequest->insurance_booklet       = $request->insurance_booklet;
            $demandRequest->pregnancy_feed          = $request->pregnancy_feed;
            $demandRequest->calf_starter            = $request->calf_starter;
            $demandRequest->any_other_item          = $request->any_other_item;
            $demandRequest->any_suggestion          = $request->any_suggestion;
            $demandRequest->any_complaint           = $request->any_complaint;
            $demandRequest->post_office             = $request->post_office;
            $demandRequest->training_year           = $request->training_year;
            $demandRequest->month                   = $request->month;
            $demandRequest->question                = $request->question;
            $demandRequest->registered_cow_calves   = $request->registered_cow_calves;
            $demandRequest->registered_buffalo_calves = $request->registered_buffalo_calves;
            $demandRequest->registered_sexed_calves = $request->registered_sexed_calves;
            $demandRequest->registered_farmers      = $request->registered_farmers;
            $demandRequest->save();

            return $this->successResponse(
                'Demand request submitted successfully',
                200,
                new DemandRequestResource($demandRequest)
            );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function getDemandRequest(Request $request)
    {
        try {
            $maitri = auth()->user();
            if (!$maitri instanceof Maitri) {
                return $this->errorResponse('Maitri not authenticated', 401);
            }

            $demandRequest = DemandRequest::with('districtName','Institute')
                ->where('maitrie_id', $maitri->id)
                ->latest('id')
                ->first();

            if (!$demandRequest) {
                return $this->successResponse('No demand request found', 200);
            }

            return $this->successResponse(
                'Demand request fetched successfully',
                200,
                new DemandRequestResource($demandRequest)
            );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    private function toCsv($value): ?string
    {
        if (is_array($value)) {
            return implode(',', array_filter($value, fn($v) => $v !== null && $v !== ''));
        }
        return $value !== null && $value !== '' ? (string) $value : null;
    }
}