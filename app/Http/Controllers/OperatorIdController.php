<?php

namespace App\Http\Controllers;

use App\Models\API\Role;
use App\Models\InventoryMap;
use App\Models\DeoUser;
use App\Models\Zonestock; 
use App\Models\Districts;
use App\Models\Divisions;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;

class OperatorIdController extends Controller
{

    public function index(){
        $roles = Role::whereIn('name', ['zone','district', 'deo'])->pluck('id');
        $zoneUsers = User::whereIn('role_id', $roles)->with(['getDeoUser.zone'])->get();
        return view('operatorId.index', compact('zoneUsers'));
    }
    
    public function editUser($id){
        $userData = User::where('id', $id)->first();
        $zoneData = [];
        $zone_id = '';
        $getDistrict = [];
        if($userData['role'] == 'zone'){
            $zone_id = $userData['zone_id'];
            $zoneData = Zone::all();
        }else if($userData['role'] == 'district'){
            $user_id = $userData['id'];
            $zoneData = Zone::all();
            $userGetData = DeoUser::where('user_id', $user_id)->first();
            $zone_id = $userGetData['zone_id'];
            $divisions = Divisions::where('zone_id', $zone_id)->get();
            $getDistrict = [];
            foreach($divisions as $division){
                $districts = Districts::where('division_id', $division['id'])->get();
                foreach($districts as $district){
                    $getDistrict[] = $district;
                }
            }
            
        }else if($userData['role'] == 'deo'){
            $user_id = $userData['id'];
            $zoneData = Zone::all();
            $userGetData = DeoUser::where('user_id', $user_id)->first();
            $zone_id = $userGetData['zone_id'];
            $divisions = Divisions::where('zone_id', $zone_id)->get();
            $getDistrict = [];
            foreach($divisions as $division){
                $districts = Districts::where('division_id', $division['id'])->get();
                foreach($districts as $district){
                    $getDistrict[] = $district;
                }
            }
            
        }
        return view('operatorId.userEdit', compact('userData','zoneData', 'zone_id', 'getDistrict'));
    }

    public function userDelete($id) {
        $event = User::findOrFail($id);
        $event->delete();
        InventoryMap::where('assign_user_id', $id)->delete();
        InventoryMap::where('user_id', $id)->delete();
        DeoUser::where('user_id', $id)->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
