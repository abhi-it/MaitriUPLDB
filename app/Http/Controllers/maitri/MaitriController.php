<?php

namespace App\Http\Controllers\maitri;

use Illuminate\Http\Request;
use App\Models\User;
use File;
use App\Models\Divisions;
use App\Models\Districts;
use App\Models\API\Role;
use App\Models\API\Servicerequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Animalbreeding;
use DB;

class MaitriController extends Controller{

    public function index(){
        $user_id = Auth::user()->id;
        $data    =  Servicerequest::where(['maitri_id'=>$user_id])->get();
        return view('web.maitri.dashboard',[
            'data'=>$data,
        ]);
    }

    public function animalBreeding(){
        $user_id = Auth::user()->id;
        $breedingData = Animalbreeding::where('user_id', $user_id)->first();
        $districts  = Districts::get();
        $divisions  = Divisions::get();
        return view('web.maitri.animalbreeding',compact('user_id', 'districts','divisions', 'breedingData'));
    }

    public function maitri_details(){
        $id = Auth::user()->id;
        $districts  = Districts::get();
        $divisions  = Divisions::get();
        $data    =  User::where(['id'=>$id])->first();
        return view('web.maitri.maitriProfile',compact('data','id','districts','divisions'));
    }

    public function checkMaitriDetails(){
        $id = Auth::user()->id;
        $mairtiData =  User::where(['id'=>$id])->first();
        $district = Districts::where('id', 'LIKE', '%' . $mairtiData['district_id'] . '%')->first();
        return response()->json([
            'userData' => $mairtiData,
            'districtName' => $district['name_hindi'],
        ]);
    }

    public function checkBreedingDetails(){
        $id = Auth::user()->id;
        $mairtiData =  Animalbreeding::where(['user_id'=>$id])->first();
        $district = Districts::where('id', 'LIKE', '%' . $mairtiData['district_id'] . '%')->first();
        return response()->json([
            'userData' => $mairtiData,
            'districtName' => $district['name_hindi'],
        ]);
    }

    public function updateMaitriDateils(Request $request){
        $request->validate([
            'first_name'      => 'required|string|max:255',
            'MobileNumber'    => 'required|string|max:15',
            'AlternateMobile' => 'required|string|max:15',
            'district_id'     => 'required|string',
            'division_id'     => 'nullable|integer',
            'gram_panchayat'  => 'nullable|string|max:255',
            'post_office'     => 'nullable|string|max:255',
            'block'           => 'nullable|string|max:255',
            'tehsil'          => 'nullable|string|max:255',
            'gender'          => 'required|string',
        ]);
        $user_id = $request->user_id;
        $mairtiUser = User::findOrFail($user_id);
        $district = Districts::where('name_hindi', 'LIKE', '%' . $request->district_id . '%')
                               ->orWhere('id', $request->district_id)->first();
 
        $mairtiUser->name           = $request->first_name;
        $mairtiUser->FirstName      = $request->first_name;
        $mairtiUser->MobileNumber   = $request->MobileNumber;
        $mairtiUser->gender         = $request->gender;
        $mairtiUser->district_id    = $district ? $district->id : null;
        $mairtiUser->division_id    = $request->division_id;
        $mairtiUser->gram_panchayat = $request->gram_panchayat;
        $mairtiUser->post_office    = $request->post_office;
        $mairtiUser->pincode        = $request->pincode;
        $mairtiUser->block          = $request->block;
        $mairtiUser->tehsil         = $request->tehsil;
        $mairtiUser->AlternateMobile         = $request->AlternateMobile;
        $mairtiUser->save();
        return redirect('/maitri-details')->with('success', 'प्रोफ़ाइल सफलतापूर्वक अपडेट हो गई!');
    }

    public function getAllServiceRequest(Request $request){
        $user_id = Auth::user()->id;
        $data    =  Servicerequest::where(['maitri_id'=>$user_id])->get();
        return view('web.maitri.service-list',[
            'data'=>$data,
        ]);

    }

    public function maitriDashbaordData(Request $request){
        $user  =  Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'categories'  => ['bail', 'required', 'string', 'max:255'],
            'animal_file'  => [ 'required'],
        ]);
        if($validator->fails()){
            $errors = $validator->errors();
            foreach($errors->all() as $key => $value){
                 return redirect()->back()->with('error',ucfirst($value));
            }
        }else{
            
            if($request->hasfile('animal_file')){
                $file = $request->animal_file;
                $image_ext = array('gif','jpeg', 'jpg', 'png', 'svg',);
                if ($file) {
                    $file = $request->file('animal_file');
                    if ($file) {
                        $fileName = 'file_' . time() . '.' . $file->extension();
                    
                        $destinationPath = public_path('assets/animals/');
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0777, true); 
                        }
                    
                        $file->move($destinationPath, $fileName);
                    
                        $data = [
                            'file'    => $fileName,
                            'file_path' => asset('assets/animals/' . $fileName),
                        ];
                        DB::table('maitri_animal_service')->insert([
                                'user_id'       =>  $user,
                                'categories'    =>  $request->categories,
                                'animal_file'   =>  $fileName,
                                'created_at'    =>  date('Y-m-d h:m:s'),
                        ]);
                        return redirect('maitri-dashboard')->with('success','Request Submitted successfully!');
                    }
                }
            }
            
       }

    }

    public function updateServiceRequest(Request $request){
        $data   = '';
        $userid = Auth::user()->id;
        $id     = $request->id;
        $status = $request->val;
        $checkdata = Servicerequest::where(['maitri_id'=>$userid,'id'=>$id])->first();
        if($checkdata){
            $data   = Servicerequest::where(['maitri_id'=>$userid,'id'=>$id])->update([
                'status'=>$status,
            ]);
        }
        return \Response::json(['status'=>'success','message'=>'Updated status successfully!','data'=>$data],200);
    }

    public function monthlyProgressReport(Request $request){
        $data   =  Servicerequest::with('user','maitri')->get();
        return view('web.maitri.monthly-report',['data'=>$data]);
    }

    public function filteredMonthlyReport(Request $request){
        $month = $request->month;
        $year  = $request->year;
        $data  = Servicerequest::with('user','maitri')->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', $month)
        ->get();
        return view('web.maitri.monthly-report',['data'=>$data]);
    }

}