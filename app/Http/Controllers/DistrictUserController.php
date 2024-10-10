<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use File;
use App\Models\Divisions;
use App\Models\DeoUser;
use App\Models\Districts;
use App\Models\API\Role;
use App\Models\Zone;
use App\Models\API\Servicerequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use DB;

class DistrictUserController extends Controller{

    public function districtInventory(){  
        return view('districtuser.index');
    }

    public function createBlocktUser(){
        $user_id = Auth::user()->id;
        $data = DeoUser::where('user_id', $user_id)->get();
        $zone_id = $data[0]['zone_id'];
        $division_id = $data[0]['division_id'];
        $districts =  Districts::where('id', $data[0]['district_id'])->get();
        session()->forget('form_step1');

        return view('districtuser.createBlockUser', compact('districts', 'zone_id', 'division_id'));
    }

    public function storeDistrictData(Request $request){
        $validator = \Validator::make($request->all(), [
            'zone' => 'required|integer',
            'division' => 'required|integer',
            'district' => 'required|integer',
            'block' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validatedData = $validator->validated();
        session(['form_step1' => $validatedData]);
        return response()->json(['status' => 200]);
    }

    public function districtStoreStep2(){
        if (!session()->has('form_step1') || empty(session('form_step1'))) {
            return redirect()->route('create-block-user-form');
        }
        return view('districtuser.districtStepForm2');
    }

    public function userDataDistrictStore(Request $request){
        $validator = \Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $form_step1 = session('form_step1');

        $role = Role::where('name', 'block')->first();
        $role_id = $role ? $role->id : null;

        $user = User::create([
            'name'        => $validatedData['username'],
            'FirstName'   => $validatedData['username'],
            'LastName'    => $validatedData['username'],
            'email'       => $validatedData['email'],
            'password'    => Hash::make($validatedData['password']),
            'division_id' => $form_step1['division'],
            'district_id' => $form_step1['district'],
            'role_id'     => $role_id,
            'role'        => 'block',
            'user_type'   => 'Block',
        ]);

        $deoUser = DeoUser::create([
            'user_id'       => $user->id,
            'zone_id'       => $form_step1['zone'],
            'division_id'   => $form_step1['division'],
            'district_id' => $form_step1['district'],
            'block_id' => $form_step1['block'],
        ]);
        session()->forget('form_step1');
        return response()->json(['status' => 200]);
    }
}