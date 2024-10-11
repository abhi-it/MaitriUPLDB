<?php

namespace App\Http\Controllers;

use App\Models\AIcenters;
use App\Models\API\Role;
use App\Models\Block;
use App\Models\Blockslist;
use App\Models\Cliniclocation;
use App\Models\DeoUser;
use App\Models\Districts;
use App\Models\Divisions as ModelsDivisions;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class CreateZoneController extends Controller
{
    public function index() {
        $zones = Zone::all();
        session()->forget('form_step1');
        return view('zones.index', compact('zones'));
    }

    public function zoneStoreData(Request $request){
        $validator = \Validator::make($request->all(), [
            'zone' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validatedData = $validator->validated();
        session(['form_step1' => $validatedData]);
        return response()->json(['status' => 200]);
    }

    public function zoneUserCreateForm(Request $request){
        if (!session()->has('form_step1') || empty(session('form_step1'))) {
            return redirect()->route('create-zone');
        }
        return view('zones.createUserZone');
    }

    public function zoneUserCreateData(Request $request){
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
        $role = Role::where('name', 'zone')->first();
        $role_id = $role ? $role->id : null;
        $user = User::create([
            'name'        => $validatedData['username'],
            'FirstName'   => $validatedData['username'],
            'LastName'    => $validatedData['username'],
            'email'       => $validatedData['email'],
            'password'    => Hash::make($validatedData['password']),
            'role_id'     => $role_id,
            'role'        => 'zone',
            'user_type'   => 'Zone',
        ]);
        $deoUser = DeoUser::create([
            'user_id' => $user->id,
            'zone_id' => $form_step1['zone'],
        ]);
        session()->forget('form_step1');
        return response()->json(['status' => 200]);
    }
}
