<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maitri;
use App\Models\Janpad;
use App\Models\Districts;
use App\Models\Divisions;
use App\Models\Institute;
use App\Helpers\TranslateTextHelper;
use App\Models\DemandRequest;
use App\Exports\DemandRequestExport;
use Illuminate\Support\Facades\Validator;


class DemandRequestController extends Controller{

    public function index(Request $request){
        $district   = Divisions::get();
        $institute  = Institute::get();
        return view('demand-request',['district'=>$district,'institute'=>$institute]);
    }

    public function getAllrequestedBlocks(Request $request){
        $location          = $request->id;
        $blocks            = Districts::where(['id'=>$location])->distinct('name_hindi')->pluck('name_hindi')->toArray();
        return \Response::json(['status'=>'success','message'=>'Get all blocks successfully!','data'=>$blocks],200);
    }

    public function hierarchyChart(){
		return view('hierarchyChart');
	}

    public function cattleBuffalo(){
        return view('cattleBuffaloPage');
    }

    public function addDemandRequests(Request $request){
        $validator = Validator::make($request->all(),[
            'name'  => [ 'required'],
            'date_of_birth' => [ 'required'],
            'gender' => [ 'required'],
            'bharat_pashudhan_id' => [ 'required'],
        ]);
        if($validator->fails()){
            $errors = $validator->errors();
            foreach($errors->all() as $key => $value){
                 return redirect()->back()->with('error',ucfirst($value));
            }
        }else{
            $request  = new DemandRequest([
                'name'      => $request->name,
                'date_of_birth' => $request->date_of_birth,
                'gender'  => $request->gender,
                'training_center_id'     => $request->training_center_id,
                'bharat_pashudhan_id'     => $request->bharat_pashudhan_id,
                'smart_mobile_no'     => $request->smart_mobile_no,
                'district'     => $request->mandal,
                'mandal'     => $request->district,
                'block'     => $request->block,
                'vh_ai_center'     => $request->vh_ai_center,
                'pincode'     => $request->pincode,
                'villages_coevring'     => $request->villages_coevring,
                'demand_section'     => $request->demand_section,
                'semen'     => $request->semen,
                'breed'     => $request->breed,
                'bull_id'     => $request->bull_id,
                'Sheath'     => $request->Sheath,
                'gloves'     => $request->gloves,
                'animal_tag'     => $request->animal_tag,
                'mineral_mixture'     => $request->mineral_mixture,
                'dewormer'     => $request->dewormer,
                'insurance_booklet'     => $request->insurance_booklet,
                'pregnancy_feed'     => $request->pregnancy_feed,
                'calf_starter'     => $request->calf_starter,
                'any_other_item'     => $request->any_other_item,
                'any_suggestion'     => $request->any_suggestion,
                'any_complaint'     => $request->any_complaint,
                'vikas_khand'     => $request->vikas_khand,
                'post_office'     => $request->post_office,
                'tehsil'     => $request->tehsil,
                'semen_type'     => $request->semen_type,
                'training_year'=>$request->training_year,
                'month'=>$request->month,
                'question'=>$request->question,
                'semen_source'=>$request->semen_source,
                'registered_cow_calves'=>$request->registered_cow_calves,
                'registered_buffalo_calves'=>$request->registered_buffalo_calves,
                'registered_sexed_calves'=>$request->registered_sexed_calves,
                'registered_farmers'=>$request->registered_farmers,
            ]);
            $request->save();
            return redirect()->back()->with('success','Your request submitted successfully!');
        }
    }

    public function demandRequestsListing(Request $request){
        $district   = Districts::get();
        $query = DemandRequest::orderBy('id', 'DESC');
        if (!empty($request->input('id'))) {
            $query->where(function ($q) use ($request) {
                $q->where(['district'=>$request->input('id')]);
            });
        }
        $data  = $query->orderBy('id', 'DESC')->paginate(50);
        $items = $data->appends(request()->except('page'));
        return view('demand-request-listing',['data'=>$data,'district'=>$district,'items'=>$items]);
    }

    public function deleteDemandRequests(Request $request){
        $data  =  DemandRequest::where(['id'=>$request->id])->delete();
        return \Response::json(['status'=>'success','message'=>'Selected row delete successfully!','data'=>$data],200);
    }

    public function exportDemandRequest(Request $request){
        $query    = DemandRequest::orderBy('id', 'DESC');
        $id       = $request->dis_id;
        if($request->dis_id){
            $datas     = $query->with('district')->where(['district'=> $id])->get();
        }else{
            $datas    = $query->with('district')->get();
        }
        $data = $datas->map(function ($item) {
            return [
                'name' => $item->name,
                'date_of_birth' => $item->date_of_birth,
                'gender' => $item->gender,
                'training_center_id' => $item->training_center_id,
                'bharat_pashudhan_id' => $item->bharat_pashudhan_id,
                'smart_mobile_no' => $item->smart_mobile_no,
                'district' => '',//($item->district)?$item->district->name_hindi:'N/A',
                'vikas_khand' => $item->vikas_khand,
                'post_office' => $item->post_office,
                'tehsil' => $item->tehsil,
                'vh_ai_center' => $item->vh_ai_center,
                'villages_coevring' => $item->villages_coevring,
                'demand_section' => $item->demand_section,
                'semen' => $item->semen,
                'semen_type' => $item->semen_type,
                'breed' => $item->breed,
                'bull_id' => $item->bull_id,
                'Sheath' => $item->Sheath,
                'gloves' => $item->gloves,
                'insurance_booklet' => $item->insurance_booklet, 
                'animal_tag' => $item->animal_tag,
                'mineral_mixture' => $item->mineral_mixture,
                'dewormer' => $item->dewormer,
                'pregnancy_feed' => $item->pregnancy_feed,
                'calf_starter' => $item->calf_starter,
                'any_other_item' => $item->any_other_item,
                'any_suggestion' => $item->any_suggestion,
                'any_complaint' => $item->any_complaint,
            ];
        });
        return \Excel::download(new DemandRequestExport($data), 'request-list.xlsx');
    }

    public function viewRequestDetails(Request $request){
        $data = DemandRequest::with('district')->where(['id'=>$request->id])->first();
        return view('viewDemandRequest',['data'=>$data]);

    }

}