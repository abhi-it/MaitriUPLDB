<?php

namespace App\Http\Controllers;

use Excel;
use Illuminate\Http\Request;
use App\Models\Maitri;
use App\Models\Janpad;
use App\Imports\ImportMaitri;
use App\Models\HospitalInstitute;
use App\Models\Divisions;
use App\Models\Block;
use App\Models\Districts;
use App\Models\Cliniclocation;
use App\Helpers\TranslateTextHelper;
use App\Exports\MaitriListExport;
use App\Exports\AIcenterExport;
use App\Exports\AIAllCenterExport;
use App\Exports\LocationExport;
use DB;

class MaitriController extends Controller
{
    public function maitri_home() {
        $count=Maitri::count();
        return view('maitri.home',compact('count'));
    }

    public function maitri_form() {
        return view('maitri.maitri-form');
    }

    public function maitri_import() {
        return view('maitri.maitri-import');
    }

   public function maitri_map() {
        $dist       =  Maitri::all()->unique('mandal_name')->toArray();
        $aicenter   = Cliniclocation::all()->unique('mandal_name')->toArray();//HospitalInstitute::all()->unique('address')->toArray(); 
        $division   = Divisions::all()->unique('name_hindi')->toArray();
        $placeid    =Janpad::select('place_id') 
        ->distinct('name')    
        ->get()                
        ->pluck('place_id');   
        $agency     = DB::table('livestock_agencies')->where(['type'=>'lc_agency'])->count();
        $station    = DB::table('livestock_agencies')->where(['type'=>'semen_station'])->count();
        $ivf        = DB::table('livestock_agencies')->where(['type'=>'ett_ivf'])->count();
        $bull       = DB::table('livestock_agencies')->where(['type'=>'bull_mother'])->count();
        $maitricount = Maitri::get();
        $aicount      = Cliniclocation::get();
        $countDistrict =  Districts::get();

        $disticcount =  DB::table('district_map_data')
                    ->join('districts', 'district_map_data.district_hi', '=', 'districts.name_hindi')
                    ->select('district_map_data.*', 'districts.*')
                    ->get();
 
        $pdlab       =  DB::table('pregnancy_diagnosis_laboratory')->orderBy('id','ASC')->get(); 
        $cvblocks    =  DB::table('cryo_vessel_blocks')->orderBy('id','ASC')->get();
       
        return view('maitri.maitri-map',[
            'data'      =>  $dist,
            'aicenter'  =>  $aicenter,
            'division'  =>  $division,
            'placeid'   =>  $placeid,
            'maitricount'=> $maitricount,
            'aicount'   =>  $aicount,
            'disticcount'=> $disticcount,
            'countDistrict' => $countDistrict,
            'agency'    =>  $agency,
            'station'   =>  $station,
            'ivf'       =>  $ivf,
            'bull'      =>  $bull,
            'pdlab'     =>  $pdlab,
            'cvblocks'  =>  $cvblocks,
        ]);
    }

    public function addUpdateMaitri(Request $request){
        
        $maitri=new Maitri();
        $maitri->mandal_name=$request->mandal_name;
        $maitri->janpad_name=$request->janpad_name;
        $maitri->maitri_name=$request->maitri_name;
        $maitri->maitri_mobile_no=$request->maitri_mobile_no;
        $maitri->gram_panchayat=$request->gram_panchayat;
        $maitri->post_office=$request->post_office;
        $maitri->block=$request->block;
        $maitri->tehsil=$request->tehsil;
        $maitri->adhaar_card=$request->adhaar_card;
        $maitri->father_name=$request->father_name;
        $maitri->father_mobile_no=$request->father_mobile_no;
        $maitri->certificate_no=$request->certificate_no;
        $maitri->center_name=$request->center_name;
        $maitri->pass_date=$request->pass_date;
        $maitri->expiry_date=$request->expiry_date;
        $maitri->any_bharat_id=$request->any_bharat_id;
        $maitri->equipment_received=$request->equipment_received;
        $maitri->any_bharat_id=$request->any_bharat_id;
        $maitri->equipment_received=$request->equipment_received;
        $maitri->longitude=str_replace('-','.',$request->longitude);
        $maitri->latitude=str_replace('-','.',$request->latitude);
        $maitri->save();        
        return redirect('maitri-form')->with('success', 'Data Added successfully!');


    }
    
    public function importMaitries(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Get the uploaded file
        $file = $request->file('file');
        
        Excel::import(new ImportMaitri, $request->file('file')->store('files'));
        return redirect('maitri-import')->with('success', 'File Imported successfully!');
    }

    public function getJanpadUnique(Request $request){
        $location           = $request->id;
        $data['maitri']     = Maitri::where('mandal_name', 'like', "%{$location}%")->get();
        $data['janapad']    = Janpad::where(['name'=>$location])->first();

        $divisionData       = Divisions::where(['name_hindi' => $location])->first();
        $data['result'] =   DB::table('districts')
                ->select(
                    'districts.id',
                    'districts.name_hindi',
                    'districts.division_id',
                    'maitries.janpad_name',
                    DB::raw('COUNT(maitries.janpad_name) AS count')
                )
                ->leftJoin('maitries', function($join) use ($location) {
                    $join->on('districts.name_hindi', '=', 'maitries.janpad_name')
                        ->where('maitries.mandal_name', 'like', '%' . $location . '%');
                })
                ->where('districts.division_id', $divisionData['id'])
                ->groupBy('districts.id', 'districts.name_hindi', 'districts.division_id', 'maitries.janpad_name')
                ->get();

        // $data['results']    = Maitri::select('janpad_name', DB::raw('count(*) as count'))
        // ->where('mandal_name', 'like', "%{$location}%")
        // ->groupBy('janpad_name')
        // ->get();



        return \Response::json(['status'=>'success','message'=>'Get all janpad successfully!','data'=>$data],200);
    }

    public function allMaitriesData(Request $request){
        $data               = [];
        $janpad             = $request->id;
        $data['code']       = Janpad::where(['name'=>$janpad])->first();
        $data['maitri']     = Maitri::where('janpad_name', 'like', "%{$janpad}%")->get();
        return $data;
    }
    public function maitriListing(Request $request){
        $dist  =  Maitri::all()->unique('mandal_name')->toArray();
        $query = Maitri::orderBy('id', 'DESC');
        if (!empty($request->input('id'))) {
            $query->where(function ($q) use ($request) {

                $q->where('mandal_name', 'like',  $request->input('id'));
            });
        }
        $data = $query->orderBy('id', 'DESC')->paginate(50);
        $items = $data->appends(request()->except('page'));
        
        return view('maitri.maitri-listing',['data'=>$data,'dist'=>$dist,'items'=>$items]);

    }

    public function exportMaitri(Request $request){
        $query    = Maitri::orderBy('id', 'DESC');
        $janpad   = $request->id;
        if($request->id){
            $data     = $query->select( 'mandal_name','janpad_name','maitri_name','maitri_mobile_no','gram_panchayat','post_office','block','tehsil','adhaar_card','father_name','father_mobile_no','certificate_no','center_name','pass_date','any_bharat_id','equipment_received','longitude','latitude',)->where('janpad_name', 'like', "%{$janpad}%")->get();
        }else{
            $data     = $query->select( 'mandal_name','janpad_name','maitri_name','maitri_mobile_no','gram_panchayat','post_office','block','tehsil','adhaar_card','father_name','father_mobile_no','certificate_no','center_name','pass_date','any_bharat_id','equipment_received','longitude','latitude',)->get();
        }
        return \Excel::download(new MaitriListExport($data), 'maitri-list.xlsx');
    }

    public function fetchRecord($id){
        $record = Maitri::find($id);
        return response()->json($record);
    }

    public function updateRecord(Request $request){
        $latitude   = $request['latitude'];
        $longitude  = $request['longitude'];
        $record     = Maitri::find($request->id);
        $record->update($request->only([
            'latitude', 'longitude'
        ]));
        return response()->json(['success' => 'Record updated successfully']);
    }


    public function getAllAICenters(Request $request){
        $data               = [];

        if($request->district != ''){
            $districts       = Districts::where(['id' => $request->district])->first();
            $data['code']       = Districts::where(['id' => $request->district])->first();
            $divisions          = Divisions::where(['id' => $districts['division_id']])->first();

            $districtName       = $districts['name_hindi'];
            $divisionName       = $divisions['name_hindi'];
            $query = DB::table('clinic_location')
                            ->where('mandal_name', 'LIKE', '%'.$divisionName.'%')
                            ->where('janpad_name', 'LIKE', '%'.$districtName.'%')
                            ->get();
            $data['aicenter'] = $query;
            return $data;
        }

        $id                 = $request->id;
        $data['code']       = Janpad::where(['name'=>$id])->first();
        $data['maitri']     = Cliniclocation::where('mandal_name', 'like', "%{$id}%")->get();
        $division           = Divisions::where('name_hindi', 'like', "%{$id}%")->first();
        $data['district']     = Districts::where('division_id',$division['id'])->get();
       
        return $data;
    }
   
    public function getAllDistrictData(Request $request){
        $data               = [];
        $name               = $request->id;
        $divId              = Divisions::where(['name_hindi'=>$name])->first();
        $data['code']       = Janpad::where(['name'=>$name])->first();
        $data['maitri']     = Districts::where(['division_id'=>$divId['id']])->get();
        return  $data  ;
    }

    public function exportAICenters(Request $request){
        $query    = HospitalInstitute::orderBy('id', 'DESC');
        $address  = $request->ai_id;
        $data     = $query->select('type','name', 'mobile','address','lattitute','longitute')->where('address', 'like', "%{$address}%")->get();
        return \Excel::download(new AIcenterExport($data), 'AICenter-list.xlsx');
    }

    public function exportAllAIcenters(Request $request){

        $query    = Cliniclocation::orderBy('id', 'DESC');
        $data     = $query->select('mandal_name','janpad_name', 'block','type', 'name', 'lattitute', 'longitute')->get();
        return \Excel::download(new AIAllCenterExport($data), 'AllAiCenter-list.xlsx');
    }
    

    public function exportLocations(Request $request){
        $query      = Districts::orderBy('id', 'DESC');
        $name       = $request->lo_id;
        $divId      = Divisions::where(['name_hindi'=>$name])->first();
        $id         = $divId['id'];
        $data       = $query->select('name_hindi','general_target','sc_target','st_target','status','latt','long')->where('division_id', 'like', "%{$id}%")->get();
        return \Excel::download(new LocationExport($data), 'district-list.xlsx');
    }

    public function getallLiveStockData(Request $request){
        $data  =  DB::table('livestock_agencies')->where(['type'=>$request->id])->get();
        return $data;
      
    }
}