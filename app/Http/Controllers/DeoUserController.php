<?php

namespace App\Http\Controllers;

use App\Models\AIcenters;
use App\Models\API\Role;
use App\Models\Block;
use App\Models\Blockslist;
use App\Models\Cliniclocation;
use App\Models\DeoUser;
use App\Models\Districts;
use App\Models\Divisions;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class DeoUserController extends Controller
{
    public function create() {
        $zones = Zone::all();
        session()->forget('form_step1');

        return view('deo_users.createStep1', compact('zones'));
    }

    public function getAllZoneDistrict(Request $request){
        $zone_id = $request->zone_id;
        $divisionIds = Divisions::where('zone_id', $zone_id)->get();
        $district = [];
        foreach($divisionIds as $divisionId){
            $districtNames = Districts::where('division_id', $divisionId->id)->get();
            foreach($districtNames as $districtName){
                $district[] = $districtName;
            }
        }
        return response()->json(['district' => $district]);
    }

    public function getAllZoneAICenter(Request $request){
        $district_id = $request->district_id;
        $districtDatas = Block::where('dis_id', $district_id)->get();
        $aiCenter = [];
        foreach($districtDatas as $district){
            $blockName = $district['block_hindi'];
            $getAiCenters = Cliniclocation::where('block', $blockName)->get();
            foreach($getAiCenters as $getAiCenter){
                if($getAiCenter['name'] != '' && $getAiCenter['name_eng'] != ''){
                    $aiCenter[] = $getAiCenter;
                }
            }
        }
        return response()->json(['aicenter' => $aiCenter]);
    }

    public function districtsDeoCreate(){
        $zones = Zone::all();
        session()->forget('form_step1');
        return view('deo_users.createDistrictDeo', compact('zones'));
    }

    public function getDivisions(Request $request)
    {
        $divisions = Divisions::where('zone_id', $request->zone_id)->get();
        return response()->json(['divisions' => $divisions]);
    }

    public function getAicenter(Request $request)
    {
        $aicenter = Cliniclocation::where('block', $request->blockname)->get();
        return response()->json(['aicenter' => $aicenter]);
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
            'district' => 'required|integer',
            // 'aicenters' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        session(['form_step1' => $validatedData]);

        return response()->json(['status' => 200]);
    }

    public function createDisctrictStep2(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'zone' => 'required|integer',
            'district' => 'required'
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


    public function createDistrictStep2(Request $request)
    {
        if (!session()->has('form_step1') || empty(session('form_step1'))) {
            return redirect()->route('district-deo-user-step1');
        }
        return view('deo_users.createDistrictStep2');
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

        $getDistrictData = Districts::where('id', $form_step1['district'])->first();
        $division_id = $getDistrictData['division_id'];

        $user = User::create([
            'name'        => $validatedData['username'],
            'FirstName'   => $validatedData['username'],
            'LastName'    => $validatedData['username'],
            'email'       => $validatedData['email'],
            'password'    => Hash::make($validatedData['password']),
            'district_id' => $form_step1['district'],
            'division_id' => $division_id,
            'role_id'     => $role_id,
            'role'        => 'deo',
            'user_type'   => 'DEO',
        ]);

        // foreach($form_step1['aicenters'] as $aicenterId){
            // $getBlockName = Cliniclocation::where('id', $aicenterId)->first();
            // $block_id = Block::where('block_hindi', $getBlockName['block'])->first();
            $deoUser = DeoUser::create([
                'user_id' => $user->id,
                'zone_id' => $form_step1['zone'],
                'division_id' => $division_id,
                'district_id' => $form_step1['district'],
                // 'block_id' => $block_id['id'],
                // 'aicenters_id' => $aicenterId
            ]);

        // }
        session()->forget('form_step1');

        return response()->json(['status' => 200]);

    }

    public function createDistrictStoreStep2(Request $request){

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

        $role = Role::where('name', 'district')->first();
        $role_id = $role ? $role->id : null;

        $getDistrictData = Districts::where('id', $form_step1['district'])->first();
        $division_id = $getDistrictData['division_id'];
       
        $user = User::create([
            'name'        => $validatedData['username'],
            'FirstName'   => $validatedData['username'],
            'LastName'    => $validatedData['username'],
            'email'       => $validatedData['email'],
            'password'    => Hash::make($validatedData['password']),
            'division_id' => $division_id,
            'district_id' => $form_step1['district'],
            'role_id'     => $role_id,
            'role'        => 'district',
            'user_type'   => 'District',
        ]);

        $deoUser = DeoUser::create([
            'user_id' => $user->id,
            'zone_id' => $form_step1['zone'],
            'division_id' => $division_id,
            'district_id' => $form_step1['district'],
        ]);
        session()->forget('form_step1');
        return response()->json(['status' => 200]);

    }
}
