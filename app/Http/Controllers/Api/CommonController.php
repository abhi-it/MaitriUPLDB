<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Districts;
use App\Models\Divisions;
use App\Models\Institute;
use App\Models\Manganurodhdata;
use App\Traits\FormatResponseTrait;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    use FormatResponseTrait;

    public function getMandal(Request $request) {
        $getMandal  = Divisions::get();
        return $this->successResponse('Get all mandal successfully!',200,$getMandal);
    }

    public function getDistrict(Request $request)
    {
        $mandal_name = $request->mandal_name;
        $getAllDistrict =  Manganurodhdata::select('janpad_name')
                        ->where('mandal_name', 'LIKE', $mandal_name)
                        ->where('status', 0)
                        ->groupBy('janpad_name')
                        ->get();
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
            'species_semen' => getSpeciesSemen(),
            'semen_type' => getSemenType(),
            'semen_source' => getSemenSource(),
            'complaints' => getAnyComplaint(),
        ]);
    }
}
