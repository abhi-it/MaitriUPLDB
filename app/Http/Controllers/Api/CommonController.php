<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ServiceHelper;
use App\Http\Controllers\Controller;
use App\Models\Districts;
use App\Models\Divisions;
use App\Models\Institute;
use App\Models\Manganurodhdata;
use App\Traits\V2\FormatResponseTraitV2;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    use FormatResponseTraitV2;

    public function getMandal(Request $request) {
        $getMandal  = Divisions::get();
        return $this->successResponse('Get all mandal successfully!',200,$getMandal);
    }

    public function getDistrict(Request $request)
    {
        $mandal_name = $request->mandal_name;
        if($mandal_name) {
            $mandalId = Divisions::where('name_hindi', 'LIKE', $mandal_name)->first();
            if($mandalId['id']) {
                $getAllDistrict = Districts::select('id','name_hindi as janpad_name')->where('division_id', $mandalId['id'])->get();
            } else {
                $getAllDistrict = Districts::select('id','name_hindi as janpad_name')->get();
            }
        } else {
            $getAllDistrict = Districts::select('id','name_hindi as janpad_name')->get();
        }
        return $this->successResponse('Get all district successfully!',200,$getAllDistrict);
    }

    public function getTehsilAll(Request $request){
        $mandal_name = $request->mandal_name;
        $janpad_name = $request->janpad_name;
        $getTeshil =  Manganurodhdata::select('tehsil')
                        ->where('mandal_name', 'LIKE', $mandal_name)
                        ->where('janpad_name', 'LIKE', $janpad_name)
                        ->where('status', 0)
                        ->groupBy('tehsil')
                        ->get();
        return $this->successResponse('Get all tehsil successfully!',200,$getTeshil);
    }

    public function getBlockAll(Request $request){
        $tehsil = $request->tehsil;
        $mandal_name = $request->mandal_name;
        $janpad_name = $request->janpad_name;
        $getBlock =  Manganurodhdata::select('block')
                        ->where('mandal_name', 'LIKE', $mandal_name)
                        ->where('janpad_name', 'LIKE', $janpad_name)
                        ->where('tehsil', 'LIKE', $tehsil)
                        ->where('status', 0)
                        ->groupBy('block')
                        ->get();
        return $this->successResponse('Get all blocks successfully!',200,$getBlock);
    }

    public function getAiCenterAll(Request $request){
        $block = $request->block;
        $tehsil = $request->tehsil;
        $mandal = $request->mandal;
        $janpad = $request->janpad;
        $getAIcenter =  Manganurodhdata::select('center_name')
                        ->where('mandal_name', 'LIKE', $mandal)
                        ->where('janpad_name', 'LIKE', $janpad)
                        ->where('tehsil', 'LIKE', $tehsil)
                        ->where('block', 'LIKE', $block)
                        ->where('status', 0)
                        ->groupBy('center_name')
                        ->get();
        return $this->successResponse('Get all ai center successfully!', 200, $getAIcenter);
    }

    public function getInsitute(Request $request){ 
        $institute  = Institute::select('id','name','name_en')->get();
        return $this->successResponse('Get institute list successfully!', 200, $institute);
    }

    public function getSemenData(Request $request){
        return $this->successResponse('Get semen data successfully!', 200, [
            'species_semen'  => ServiceHelper::getSpeciesSemenOptions(),
            'semen_type'     => ServiceHelper::getSemenTypeOptions(),
            'semen_source'   => ServiceHelper::getSemenSourceOptions(),
            'complaints'     => ServiceHelper::getAnyComplaintOptions(),
            'service_status' => ServiceHelper::getStatusOptions(),
        ]);
    }

    public function getAboutUs()
    {
        return $this->successResponse('About Us data fetched successfully!', 200, ["about_us" => ServiceHelper::getAboutUsContent()]);
    }

    public function getTermsAndConditions()
    {
        return $this->successResponse('Terms and Conditions fetched successfully!', 200, [
            'terms_and_conditions' => ServiceHelper::getTermsAndConditions(),
        ]);
    }
}
