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
use DB;

class MaitriController extends Controller{

    public function index(){
        $user_id = Auth::user()->id;
        $data    =  Servicerequest::where(['maitri_id'=>$user_id])->get();
        return view('web.maitri.dashboard',[
            'data'=>$data,
        ]);
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
                $name  = 'file'.$request->file('animal_file')->extension();
                $request->file('animal_file')->move(public_path('animals'), $name);
                DB::table('maitri_animal_service')->insert([
                        'user_id'       =>  $user,
                        'categories'    =>  $request->categories,
                        'animal_file'   =>  $name,
                        'created_at'    =>   date('Y-m-d h:m:s'),
                ]);
            }
            return redirect('maitri-dashboard')->with('success','Request Submitted successfully!');
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