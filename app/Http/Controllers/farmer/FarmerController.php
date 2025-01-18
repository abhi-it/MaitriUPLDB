<?php

namespace App\Http\Controllers\farmer;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Divisions;
use App\Models\Districts;
use App\Models\API\Role;
use App\Models\API\Servicerequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use DB;

class FarmerController extends Controller{

    public function index(){
        $districts  = Districts::get();
        $divisions  = Divisions::get();
        $user       = Auth::user()->id;
        $data       = Servicerequest::where(['user_id'=>$user])->get();
       return view('web.farmer.dashbaord',['data'=>$data], compact('districts','divisions'));
    }

    public function updateFarmerDateils(Request $request){
        $request->validate([
            'first_name'      => 'required|string|max:255',
            'MobileNumber'    => 'required|string|max:15',
            'district_id'     => 'required|string',
            'division_id'     => 'nullable|integer',
            'animal_type'     => 'nullable|array',
            'breeds'          => 'nullable|array',
            'cattale_no'      => 'nullable|array',
            'gram_panchayat'  => 'nullable|string|max:255',
            'post_office'     => 'nullable|string|max:255',
            'block'           => 'nullable|string|max:255',
            'tehsil'          => 'nullable|string|max:255',
        ]);
        $user_id = $request->user_id;
        $user = User::findOrFail($user_id);
        $district = Districts::where('name_hindi', 'LIKE', '%' . $request->district_id . '%')->first();

        $user->name           = $request->first_name;
        $user->FirstName      = $request->first_name;
        $user->MobileNumber   = $request->MobileNumber;
        $user->gender         = $request->gender;
        $user->district_id    = $district ? $district->id : null;
        $user->division_id    = $request->division_id;
        $user->animal_type    = $request->animal_type ? implode(',', $request->animal_type) : null;
        $user->breeds         = $request->breeds ? implode(',', $request->breeds) : null;
        $user->cattale_no     = $request->cattale_no ? implode(',', $request->cattale_no) : null;
        $user->gram_panchayat = $request->gram_panchayat;
        $user->post_office    = $request->post_office;
        $user->pincode        = $request->pincode;
        $user->block          = $request->block;
        $user->tehsil         = $request->tehsil;
        $user->milk_day       = $request->milk_day ? implode(',', $request->milk_day) : null;
        $user->save();
        return redirect('/farmer-dashboard')->with('success', 'Profile updated successfully!');
    }


    public function getServiceFrom(){
        $dis_id         = Auth::user()->district_id;
        $maitries       = User::where(['district_id'=>$dis_id,'role_id'=>3])->get();
       return view('web.farmer.service-form',['maitries'=>$maitries]);
    }

    public function checkUserDetails() {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
        }
        $district = Districts::where('id', 'LIKE', '%' . $user['district_id'] . '%')->first();
        $isFilled = !empty($user->profile) &&!empty($user->name) && !empty($user->email) && !empty($user->gender) && !empty($user->pincode) && !empty($user->MobileNumber) && !empty($user->cattale_no) && !empty($user->animal_type) && !empty($user->breeds) && !empty($user->post_office) && !empty($user->block) && !empty($user->tehsil)  && !empty($user->milk_day);
        
        $animalTypes = explode(',', $user->animal_type);
        $breeds = explode(',', $user->breeds);
        $cattaleNos = explode(',', $user->cattale_no);
        $milkDays = explode(',', $user->milk_day);

        return response()->json([
            'status' => $isFilled ? 'filled' : 'not_filled',
            'userData' => $user,
            'districtName' => $district['name_hindi'],
            'animal_type' => $animalTypes,
            'breeds' => $breeds,
            'cattale_no' => $cattaleNos,
            'milk_day' => $milkDays
        ]);
    }

    public function addFarmerRequests(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id'  => [ 'required'],
            'maitri_id' => [ 'required'],
        ]);
        if($validator->fails()){
            $errors = $validator->errors();
            foreach($errors->all() as $key => $value){
                 return redirect()->back()->with('error',ucfirst($value));
            }
        }else{
            $request  = new Servicerequest([
                'user_id'      => $request->user_id,
                'service_name' => $request->services,
                'maitri_id'  => $request->maitri_id,
                'request_message'     => $request->request_message,
                'status' => 1,
            ]);
            $request->save();
            return redirect()->back()->with('success','Your request submitted successfully!');
        }
    }

    public function getAllServiceRequest(Request $request){
        $user_id = Auth::user()->id;
        $data    =  Servicerequest::with('user','maitri')->where(['user_id'=>$user_id])->get();
        return view('web.farmer.services-list',['data'=>$data]);
    }

    public function deleteRequest(Request $request){
       $data = Servicerequest::where(['id'=>$request->id])->delete();
       return response()->json(["message"=>'User deleted successfully!',"status"=>'Success',"data"=>$data],200);

    }
    public function farmerDashRequest(Request $request){
        $user  =  Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'insurance'  => ['bail', 'required', 'string', 'max:255'],
            'feedback'  => [ 'required'],
        ]);
        if($validator->fails()){
            $errors = $validator->errors();
            foreach($errors->all() as $key => $value){
                 return redirect()->back()->with('error',ucfirst($value));
            }
        }else{
                DB::table('farmer_feedback')->insert([
                        'user_id'     =>  $user,
                        'insurance'   =>  $request->insurance,
                        'feedback'    =>  $request->feedback,
                        'created_at'  =>   date('Y-m-d h:m:s'),
                ]);
            return redirect()->back()->with('success','Request Submitted successfully!');
       }
    }

    public function highYieldingAnimal(Request $request){
        $user  =  Auth::user()->id;
        $data   = DB::table('farmer_high_yielding_animal')->where('user_id', $user)->get();
        return view('web.farmer.yielding-animal-form',['data'=>$data]);
        
    }
    public function addAnimaldetailsform(Request $request){
        return view('web.farmer.add-yielding-animal-form');
    }

    public function addUpdateAnimalDetails(Request $request){
        $user  =  Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'type'  => [ 'required'],
            'file'  => [ 'required'],
        ]);
       
        if($validator->fails()){
            $errors = $validator->errors();
            foreach($errors->all() as $key => $value){
                 return redirect()->back()->with('error',ucfirst($value));
            }
        }else{
            if($request->hasfile('file')){
                $name  = 'file'.$request->file('file')->extension();
                $request->file('file')->move(public_path('animals'), $name);
                DB::table('farmer_high_yielding_animal')->insert([
                        'user_id'   =>  $user,
                        'type'      =>  $request->type,
                        'file'      =>  $name,
                        'details'   =>  $request->details,
                ]);
            }
            return redirect('high-yielding-animal')->with('success','Request Submitted successfully!');
       }

    }
}