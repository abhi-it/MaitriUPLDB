<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Divisions;
use App\Models\Districts;
use App\Models\API\Role;
use App\Models\Usermeta;
use App\Models\HospitalInstitute;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Traininglist;
use App\Models\Cliniclocation;
use DB;

class UsersController extends Controller{

    public function index(){
        $districts  = Districts::get();
        $divisions  = Divisions::get();
        return view('farmer-register',['districts'=>$districts,'divisions'=>$divisions]);
    }

    public function farmerRegister(Request $request){
        // dd($request->all());
         $validator = Validator::make($request->all(),[
            'first_name'  => ['bail', 'required', 'string', 'max:255'],
            'last_name'  => ['bail', 'required', 'string', 'max:255'],
            'email'    => ['bail', 'required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['bail', 'required', 'string', 'min:8'],
            'MobileNumber' => [ 'required'],
        ]);
        if($validator->fails()){
            $errors = $validator->errors();
            foreach($errors->all() as $key => $value){
                 return redirect()->back()->with('error',ucfirst($value));
            }
        }else{
            if($request->MobileNumber){
                $user  = new User([
                    'name'      => $request->first_name,
                    'FirstName' => $request->first_name,
                    'LastName'  => $request->last_name,
                    'email'     => $request->email,
                    'MobileNumber'=> $request->MobileNumber,
                    'password'   => Hash::make($request->password),
                    'district_id'=> $request->district_id,
                    'division_id'=> $request->division_id,
                    'role_id'   => '4',
                    'breeds'    => $request->breeds,
                    'cattale_no'=> implode(',',$request->cattale_no),
                    'gram_panchayat'=> $request->gram_panchayat,
                    'post_office'=> $request->post_office,
                    'block'=> $request->block,
                    'tehsil'=> $request->tehsil,
                    'role'      => 'Farmer',
                    'user_type' => 'Farmer',
                ]);
                $user->save();
            }
            return redirect('/farmer-register')->with('success','Registration successfully!');
        }
    }

    public function getAllDistrict(Request $request){
        $id         = $request->id;
        $districts  = Districts::where(['division_id' => $id])->get();
        return $districts;
    }

    public function maitriform(){
        $districts  = Districts::get();
        $divisions  = Divisions::get();
        $aicenter   = HospitalInstitute::where(['type'=>'संस्था'])->get();
        return view('maitri-register',[
            'districts'=>$districts,
            'divisions'=>$divisions,
            'aicenter'=>$aicenter]);
    }


    public function maitriRegister(Request $request){
         $validator = Validator::make($request->all(),[
            'first_name'  => ['bail', 'required', 'string', 'max:255'],
            'last_name'  => ['bail', 'required', 'string', 'max:255'],
            'email'    => ['bail', 'required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['bail', 'required', 'string', 'min:8'],
            'MobileNumber' => [ 'required'],
            'bharat_id' => [ 'required'],
        ]);
        if($validator->fails()){
            $errors = $validator->errors();
            foreach($errors->all() as $key => $value){
                 return redirect()->back()->with('error',ucfirst($value));
            }
        }else{
            if($request->bharat_id){
                $user  = new User([
                    'name'      => $request->first_name,
                    'FirstName' => $request->first_name,
                    'LastName'  => $request->last_name,
                    'email'     => $request->email,
                    'MobileNumber'=> $request->MobileNumber,
                    'password'   => Hash::make($request->password),
                    'district_id'=> $request->district_id,
                    'division_id'=> $request->division_id,
                    'role_id'   => '3',
                    'role'      => 'Maitri',
                    'user_type' => 'Maitri',
                ]);
                $user->save();
                if($user){
                    $subuser = new Usermeta([
                        'user_id'      => $user->id,
                        'gram_panchayat'=> $request->gram_panchayat,
                        'post_office'=> $request->post_office,
                        'block'=> $request->block,
                        'tehsil'=> $request->tehsil,
                        'village'=> $request->village,
                        'bharat_id' => $request->bharat_id,
                        'traing_center' => $request->traing_center,
                        'ai_center'=>$request->ai_center,
                    ]);
                    $subuser->save();
                }
            }
            return redirect('/maitri-register')->with('success','Registration successfully!');
        }
    }
    public function getAllVillage(Request $request){
        $id         = $request->id;
        $dis_id     = $request->dis_id;
        $data['village']    = DB::table('gram_panchayat')->where(['block_id' => $id])->get();
        $data['tehsil']    = DB::table('tehsil')->where(['dis_id' => $dis_id])->get();
        return $data;
    }

    public function getAllBlockById(Request $request){
        $id       = $request->id;
        $block    = DB::table('blocks')->where(['dis_id' => $id])->get();
        return $block;
    }

    public function getAllVillageById(Request $request){
        $id        = $request->id;
        $dis_id     = $request->dis_id;
        $data['village']    = DB::table('village')->where(['gram_panchayat_id' => $id])->get();
        $data['postoffice']  = DB::table('post_office')->where(['dis_id' => $dis_id ])->get();
        return $data;
    }

    public function refresherTraining(){
        $ai = Cliniclocation::where(['type'=>'AI'])->get();
        $vh = Cliniclocation::where(['type'=>'VH'])->get();
        return view('training-form',['ai'=>$ai,'vh'=>$vh]);
    }

    public function addRefreshTraining(Request $request){

        $validator = Validator::make($request->all(),[
            'from_date'  => [ 'required', 'string'],
            'to_date'  => [ 'required', 'string'],
            'days'    => [ 'required', 'string', ],
            'bharat_pshudhan_id' => [ 'required', 'string',],
            'institute' => [ 'required'],
            'district' => [ 'required'],
            'ai_center' => [ 'required'],
        ]);
        if($validator->fails()){
            $errors = $validator->errors();
            foreach($errors->all() as $key => $value){
                 return redirect()->back()->with('error',ucfirst($value));
            }
        }else{

            $user  = new Traininglist([
                'from_date' => $request->from_date,
                'to_date'   => $request->to_date,
                'days'  => $request->days,
                'months'     => $request->months,
                'institute'=> $request->institute,
                'district'=> $request->district,
                'ai_center'=> $request->ai_center,
                'hospital'    => $request->hospital,
                'ai'=> $request->ai,
                'pd'=> $request->pd,
                'calving'=> $request->calving,
                'bharat_pshudhan_id'=> $request->bharat_pshudhan_id,
            ]);
            $user->save();
            return redirect()->back()->with('success','Refresher training request submitted successfully!');

        }

    }
}
