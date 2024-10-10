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

class ZoneDashBoardController extends Controller{

    public function dashboard(){
        $user_id = Auth::user()->id;
        return view('zones.dashboard');
    }

    public function zoneInventory(){    

        $roles = Role::whereIn('name', ['deo', 'district-deo'])->pluck('id');
        $deoUsers = User::whereIn('role_id', $roles)
        ->with([
            'getDeoUser.zone',
            'getDeoUser.division',
            'getDeoUser.district',
            'getDeoUser.block',
            'getDeoUser.aicenter'
        ])->get();

    
        return view('zones.zoneInventory', compact('deoUsers'));
    }

    public function createDivisionUser(){
        $user_id = Auth::user()->id;
        $zone_id = DeoUser::where('user_id', $user_id)->get();
        $zones =    Zone::where('id', $zone_id[0]['zone_id'])->get();
        session()->forget('form_step1');
        return view('zones.createDivisionUser', compact('zones'));
    }

    public function divisionStoreData(Request $request){
        $validator = \Validator::make($request->all(), [
            'zone' => 'required|integer',
            'division' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validatedData = $validator->validated();
        session(['form_step1' => $validatedData]);
        return response()->json(['status' => 200]);
    }

    public function divisionUserStep2(){
        if (!session()->has('form_step1') || empty(session('form_step1'))) {
            return redirect()->route('create-division-user');
        }
        return view('zones.divisionUserStep2');
    }

    public function storeDivisionData(Request $request){
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

        $role = Role::where('name', 'division')->first();
        $role_id = $role ? $role->id : null;

        $user = User::create([
            'name'        => $validatedData['username'],
            'FirstName'   => $validatedData['username'],
            'LastName'    => $validatedData['username'],
            'email'       => $validatedData['email'],
            'password'    => Hash::make($validatedData['password']),
            'division_id' => $form_step1['division'],
            'role_id'     => $role_id,
            'role'        => 'division',
            'user_type'   => 'Division',
        ]);

        $deoUser = DeoUser::create([
            'user_id'       => $user->id,
            'zone_id'       => $form_step1['zone'],
            'division_id'   => $form_step1['division'],
        ]);
        session()->forget('form_step1');
        return response()->json(['status' => 200]);
    }
}