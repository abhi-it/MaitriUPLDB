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


class DeoUserController extends Controller
{
    public function create()
    {
        $zones = Zone::all();
        session()->forget('form_step1');

        return view('deo_users.createStep1', compact('zones'));
    }

    public function getDivisions(Request $request)
    {
        $divisions = ModelsDivisions::where('zone_id', $request->zone_id)->get();
        return response()->json(['divisions' => $divisions]);
    }

    public function getDistricts(Request $request)
    {
        $districts = Districts::where('division_id', $request->division_id)->get();
        return response()->json(['districts' => $districts]);
    }

    public function getBlocks(Request $request)
    {
        $blocks = Block::where('dis_id', $request->district_id)->get();
        return response()->json(['blocks' => $blocks]);
    }

    public function createStep1(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'zone' => 'required|integer',
            'division' => 'required|integer',
            'district' => 'required|integer',
            'block' => 'required|integer',
            'aicenters' => 'required|array',
            'aicenters.*' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        session(['form_step1' => $validatedData]);

        return response()->json(['status' => 200]);
    }

    public function createStep2(Request $request)
    {
        if (!session()->has('form_step1') || empty(session('form_step1'))) {
            return redirect()->route('deo-user-step1');
        }

        return view('deo_users.createStep2');
    }

    public function createStoreStep2(Request $request)
    {

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

        $role = Role::where('name', 'deo')->first();
        $role_id = $role ? $role->id : null;


        $user = User::create([
            'name'        => $validatedData['username'],
            'FirstName'   => $validatedData['username'],
            'LastName'    => $validatedData['username'],
            'email'       => $validatedData['email'],
            'password'    => Hash::make($validatedData['password']),
            'district_id' => $form_step1['district'],
            'division_id' => $form_step1['division'],
            'role_id'     => $role_id,
            'role'        => 'DEO',
            'user_type'   => 'DEO',
        ]);

        $deoUser = DeoUser::create([
            'user_id' => $user->id,
            'zone_id' => $form_step1['zone'],
            'division_id' => $form_step1['division'],
            'district_id' => $form_step1['district'],
            'block_id' => $form_step1['block'],
            'aicenters_id' => json_encode($form_step1['aicenters']),
        ]);

        session()->forget('form_step1');

        return response()->json(['status' => 200]);

    }
}
