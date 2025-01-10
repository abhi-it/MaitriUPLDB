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
        $isFilled = !empty($user->name) && !empty($user->email) && !empty($user->profile);
        return response()->json([
            'status' => $isFilled ? 'filled' : 'not_filled',
            'userData' => $user
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