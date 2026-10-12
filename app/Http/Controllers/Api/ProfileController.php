<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Animalinformation;
use App\Models\Districts;
use App\Models\Divisions;
use App\Models\FarmerUser;
use App\Models\Maitri;
use App\Traits\FormatResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    use FormatResponseTrait;

    public function updateProfile(Request $request)
    {
        try {
            $authUser = auth()->user();

            if (!$authUser) {
                return $this->errorResponse('User not authenticated', 401);
            }

            if ($request->exists('email') && !$request->filled('email')) {
                $request->merge(['email' => null]);
            }

            if ($authUser instanceof FarmerUser) {
                $table     = 'farmer_users';
                $uniqueId  = $authUser->id;
                $emailRule = 'unique:farmer_users,email,' . $authUser->id;
                $mobileRule = 'unique:farmer_users,MobileNumber,' . $authUser->id;
            } elseif ($authUser instanceof Maitri) {
                $table     = 'maitries';
                $uniqueId  = $authUser->id;
                $emailRule = 'unique:maitries,email,' . $authUser->id;
                $mobileRule = null;
            } else {
                return $this->errorResponse('Unsupported user type', 403);
            }

            $rules = [
                // Common
                'email'          => 'sometimes|nullable|email|' . $emailRule,
                'password'       => 'sometimes|nullable|string|min:8|confirmed',
                'gender'         => 'sometimes|nullable|string',
                'division_id'    => 'sometimes|nullable',
                'district_id'    => 'sometimes|nullable',
                'gram_panchayat' => 'sometimes|nullable|string|max:255',
                'post_office'    => 'sometimes|nullable|string|max:255',
                'block'          => 'sometimes|nullable|string|max:255',
                'tehsil'         => 'sometimes|nullable|string|max:255',
                'bharat_id'      => 'sometimes|nullable|string|max:255',
                'pincode'        => 'sometimes|nullable|string|max:6',

                'first_name'     => 'required|string|max:255',
                'last_name'      => 'sometimes|nullable|string|max:255',
                'MobileNumber'   => $mobileRule
                            ? 'sometimes|nullable|digits:10|' . $mobileRule   // ✅ 10 digits + unique
                            : 'sometimes|nullable|digits:10',    
                // 'animal_type'    => 'sometimes|nullable|array',
                // 'breeds'         => 'sometimes|nullable|array',
                // 'cattale_no'     => 'sometimes|nullable|array',
                // 'milk_day'       => 'sometimes|nullable|array',
                // 'animal_id'      => 'sometimes|nullable|array',
                // 'removeAnimal'   => 'sometimes|nullable|array',

                // Maitri-specificv
                // 'maitri_name'      => 'sometimes|nullable|string|max:255',
                // 'maitri_mobile_no' => 'sometimes|nullable|string|max:15',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->errorResponse(ucfirst($validator->errors()->first()), 422);
            }

            if ($authUser instanceof FarmerUser) {
                return $this->updateFarmerDetails($request, $authUser);
            }

            return $this->updateMaitriDetails($request, $authUser);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function updateFarmerDetails(Request $request, $authUser = null)
    {
        try {
            $authUser = $authUser ?? auth()->user();

            if (!$authUser instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 401);
            }

            $user = FarmerUser::findOrFail($authUser->id);

            // Basic fields
            if ($request->filled('first_name')) {
                $user->name      = $request->first_name;
                $user->FirstName = $request->first_name;
            }

            if ($request->has('last_name')) {
                $user->LastName = $request->last_name;
            }

            if ($request->filled('MobileNumber')) {
                $user->MobileNumber = $request->MobileNumber;
            }

            if ($request->exists('email')) {
                $user->email = $request->filled('email') ? $request->email : null;
            }

            if ($request->filled('gender')) {
                $user->gender = $request->gender;
            }

            if ($request->filled('bharat_id')) {
                $user->bharat_id = $request->bharat_id;
            }

            if ($request->filled('division_id')) {
                $user->division_id = $request->division_id;
            }

            if ($request->filled('district_id')) {
                $district = $this->resolveDistrict($request->district_id);
                if ($district) {
                    $user->district_id = $district->id;
                }
            }

            if ($request->has('gram_panchayat')) {
                $user->gram_panchayat = $request->gram_panchayat;
            }
            if ($request->has('post_office')) {
                $user->post_office = $request->post_office;
            }
            if ($request->has('pincode')) {
                $user->pincode = $request->pincode;
            }
            if ($request->has('block')) {
                $user->block = $request->block;
            }
            if ($request->has('tehsil')) {
                $user->tehsil = $request->tehsil;
            }

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // $user->load(['district', 'getAnimalInformation']);

            return $this->successResponse('Farmer profile updated successfully', 200, $user);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function updateMaitriDetails(Request $request, $authUser = null)
    {
        try {
            $authUser = $authUser ?? auth()->user();

            if (!$authUser instanceof Maitri) {
                return $this->errorResponse('Maitri not authenticated', 401);
            }

            $maitri = Maitri::findOrFail($authUser->id);

            // Maitri-specific keys only
            if ($request->filled('first_name')) {
                $maitri->maitri_name = $request->first_name;
            }

            if ($request->filled('MobileNumber')) {
                $maitri->maitri_mobile_no = $request->MobileNumber;
            }

            if ($request->exists('email')) {
                $maitri->email = $request->filled('email') ? $request->email : null;
            }

            if ($request->filled('gender')) {
                $maitri->gender = $request->gender;
            }

            if ($request->filled('division_id')) {
                $division = Divisions::find($request->division_id);
                $maitri->division_id = $request->division_id;
                if ($division) {
                    $maitri->mandal_name = $division->name_hindi;
                }
            }

            if ($request->filled('district_id')) {
                $district = $this->resolveDistrict($request->district_id);
                if ($district) {
                    $maitri->district_id = $district->id;
                    $maitri->janpad_name = $district->name_hindi;
                }
            }

            if ($request->has('gram_panchayat')) {
                $maitri->gram_panchayat = $request->gram_panchayat;
            }
            if ($request->has('post_office')) {
                $maitri->post_office = $request->post_office;
            }
            if ($request->has('pincode')) {
                $maitri->pincode = $request->pincode;
            }
            if ($request->has('block')) {
                $maitri->block = $request->block;
            }
            if ($request->has('tehsil')) {
                $maitri->tehsil = $request->tehsil;
            }

            if ($request->filled('password')) {
                $maitri->password = Hash::make($request->password);
            }

            $maitri->save();

            return $this->successResponse('Maitri profile updated successfully', 200, $maitri);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    private function resolveDistrict($districtInput)
    {
        if (is_numeric($districtInput)) {
            return Districts::find($districtInput);
        }

        return Districts::where('name_hindi', 'LIKE', '%' . $districtInput . '%')->first();
    }
}