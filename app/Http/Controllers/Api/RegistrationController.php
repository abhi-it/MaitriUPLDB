<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use TokenInvalidException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Divisions;
use App\Models\FarmerUser;
use App\Models\Districts;
use App\Models\Tehsil;
use App\Models\Manganurodhdata;
use App\Models\API\Servicerequest;
use App\Traits\FormatResponseTrait;
use DB;

class RegistrationController extends Controller
{
    use FormatResponseTrait;

    public function mandal_list(Request $request)
    {
        try {
            $divisions  = Divisions::get();
            return $this->successResponse('Mandal List displayed successfully',200, $divisions);
        } 
        catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422);
        } 
    }

    public function district_list(Request $request)
    {
        try {
            $districts  = Districts::where('division_id', $request->division_id)->get();
            return $this->successResponse('District List displayed successfully',200, $districts);
        } 
        catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422);
        } 
    }

    public function tehsil_list(Request $request)
    {
        try {
            $janpad = $request->district_name;
            $getTeshil =  Manganurodhdata::select('tehsil')
                                        ->where('janpad_name', 'LIKE', $janpad)
                                        ->where('status', 0)
                                        ->groupBy('tehsil')
                                        ->get();
            $tehsil = [];
            foreach($getTeshil as $data){
                $tehsil[] = $data['tehsil'];
            }
        
            return $this->successResponse('Tehsil List displayed successfully',200, $tehsil);
        } 
        catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422);
        } 
    }

    public function getAllBlock(Request $request)
    {
        try {
            $tehsil = $request->tehsil;
            $getBlock =  Manganurodhdata::select('block')
                            ->where('tehsil', 'LIKE', $tehsil)
                            ->where('status', 0)
                            ->groupBy('block')
                            ->get();
                          
            $block = [];
            foreach($getBlock as $data){
                $block[] = $data['block'];
            }
            return $this->successResponse('Block List displayed successfully',200, $block);
        } 
        catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422);
        } 
    }

    
    public function animal_types(Request $request)
    {
        try {
            $animals = [
                ['value' => 'buffalo', 'label' => 'Buffalo'],
                ['value' => 'cow', 'label' => 'Cow'],
                ['value' => 'goat', 'label' => 'Goat'],
            ];

            return $this->successResponse('Get Animal Type is successfully',200, $animals);
        } 
        catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422);
        } 
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required',
                'mobile' => ['required', 'unique:farmer_users,MobileNumber'],
                'district_id' => 'required',
                'division_id' => 'required',
                'animal_type' => 'required',
                'breeds' => 'required',
                'cattale_no' => 'required',
                'gram_panchayat' => 'required',
                'post_office' => 'required',
                'block' => 'required',
                'tehsil' => 'required',
                'milk_day' => 'required',
            ]);
            $user  = new FarmerUser([
                'name'           => $request->first_name,
                'FirstName'      => $request->first_name,
                'MobileNumber'   => $request->mobile,
                'district_id'    => $request->district_id,
                'division_id'    => $request->division_id,
                'role_id'        => '4',
                'gram_panchayat' => $request->gram_panchayat,
                'post_office'    => $request->post_office,
                'block'          => $request->block,
                'tehsil'         => $request->tehsil,
                'role'           => 'Farmer',
                'user_type'      => 'Farmer',
            ]);
            $user->save();
            $uid = $user->id;
            $milk_days = $request->milk_day;
            $animal_types = $request->animal_type;
            $breeds = $request->breeds;
            $cattale_numbers = $request->cattale_no;
            
            foreach ($milk_days as $index => $milk_day) {
                DB::table('user_animal_information')->insert([
                    'user_id'      => $uid,
                    'milk_day'     => $milk_day,
                    'animal_type'  => $animal_types[$index] ?? null,
                    'breeds'       => $breeds[$index] ?? null,
                    'cattale_no'   => $cattale_numbers[$index] ?? null,
                ]);
            }
            return $this->successResponse('User Registered successfully',200, $user);
        } 
        catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse("Validation failed", 422, $e->errors());
        } 
    }

    /**
     * Farmer signup API (aligned with web farmerRegister).
     * Accepts email + password and returns JWT for farmer_api.
     */
    public function farmerSignup(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name'     => ['bail', 'required', 'string', 'max:255'],
                'last_name'      => ['nullable', 'string', 'max:255'],
                'MobileNumber'   => ['required', 'unique:farmer_users,MobileNumber'],
                'email'          => ['required', 'email', 'unique:farmer_users,email'],
                'password'       => ['required', 'string', 'min:8', 'confirmed'],
                'gender'         => ['required', 'string'],
                'division_id'    => ['required'],
                'district_id'    => ['required'],
                'tehsil'         => ['required', 'string', 'max:255'],
                'block'          => ['required', 'string', 'max:255'],
                'post_office'    => ['required', 'string', 'max:255'],
                'pincode'        => ['required', 'string', 'max:6'],
                'gram_panchayat' => ['required', 'string', 'max:255'],
                'animal_type'    => ['required', 'array'],
                'breeds'         => ['required', 'array'],
                'cattale_no'     => ['required', 'array'],
                'milk_day'       => ['required', 'array'],
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation failed', 422, $validator->errors());
            }

            if (is_numeric($request->district_id)) {
                $district = Districts::find($request->district_id);
            } else {
                $district = Districts::where('name_hindi', 'LIKE', '%' . $request->district_id . '%')->first();
            }

            if (!$district) {
                return $this->errorResponse('Please select a valid district.', 422);
            }

            $user = new FarmerUser([
                'name'           => $request->first_name,
                'FirstName'      => $request->first_name,
                'LastName'       => $request->last_name,
                'MobileNumber'   => $request->MobileNumber,
                'email'          => $request->email,
                'password'       => Hash::make($request->password),
                'gender'         => $request->gender,
                'district_id'    => $district->id,
                'division_id'    => $request->division_id,
                'role_id'        => '4',
                'gram_panchayat' => $request->gram_panchayat,
                'post_office'    => $request->post_office,
                'pincode'        => $request->pincode,
                'block'          => $request->block,
                'tehsil'         => $request->tehsil,
                'animal_type'    => $request->animal_type[0] ?? null,
                'breeds'         => $request->breeds[0] ?? null,
                'cattale_no'     => $request->cattale_no[0] ?? null,
                'milk_day'       => $request->milk_day[0] ?? null,
                'role'           => 'Farmer',
                'user_type'      => 'Farmer',
            ]);
            $user->save();

            foreach ($request->milk_day as $index => $milk_day) {
                if (empty($request->animal_type[$index] ?? null)) {
                    continue;
                }
                DB::table('user_animal_information')->insert([
                    'user_id'     => $user->id,
                    'milk_day'    => $milk_day,
                    'animal_type' => $request->animal_type[$index] ?? null,
                    'breeds'      => $request->breeds[$index] ?? null,
                    'cattale_no'  => $request->cattale_no[$index] ?? null,
                ]);
            }

            Auth::shouldUse('farmer_api');
            $token = JWTAuth::fromUser($user);
            $user->load(['district', 'getAnimalInformation']);

            return $this->successResponse('Farmer registered successfully', 200, [
                'token' => $token,
                'token_type' => 'bearer',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

}