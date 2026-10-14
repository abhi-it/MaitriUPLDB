<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\FarmerUser;
use App\Models\Maitri;
use App\Models\Animalinformation;
use App\Models\API\Servicerequest;
use App\Models\Districts;
use App\Traits\V2\FormatResponseTraitV2;
use Tymon\JWTAuth\Exceptions\JWTException;
class AuthControllerV2 extends Controller
{
    use FormatResponseTraitV2;

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
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 'VALIDATION_ERROR', 422, $validator->errors());
            }

            if (is_numeric($request->district_id)) {
                $district = Districts::find($request->district_id);
            } else {
                $district = Districts::where('name_hindi', 'LIKE', '%' . $request->district_id . '%')->first();
            }

            if (!$district) {
                return $this->errorResponse('Please select a valid district.', "VALIDATION_ERROR", 422);
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
                'role'           => 'Farmer',
                'user_type'      => 'Farmer',
            ]);
            $user->save();

            Auth::shouldUse('farmer_api');
            $token = JWTAuth::fromUser($user);
            $user->load(['district', 'getAnimalInformation']);

            return $this->successResponse('Farmer registered successfully', 200, [
                'token'      => $token,
                'token_type' => 'bearer',
                'user'       => $user,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function maitriLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(ucfirst($validator->errors()->first()), 'VALIDATION_ERROR', 422);
            }

            $maitri = Maitri::where('email', $request->email)->first();

            if (!$maitri || empty($maitri->password) || !Hash::check($request->password, $maitri->password)) {
                return $this->errorResponse('Invalid email or password', 'INVALID_CREDENTIALS', 401);
            }

            $token = Auth::guard('maitri_api')->claims(['guard' => 'maitri_api'])->fromUser($maitri);

            $isFilled = !empty($maitri->maitri_name)
                && !empty($maitri->gender)
                && !empty($maitri->maitri_mobile_no)
                && !empty($maitri->district_id)
                && !empty($maitri->block)
                && !empty($maitri->tehsil);

            $maitri['profileDone'] = $isFilled ? 'completed' : 'not_completed';

            return $this->successResponse('Maitri login successful', 200, [
                'token' => $token,
                'token_type' => 'bearer',
                'user' => $maitri,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function farmerLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(ucfirst($validator->errors()->first()),'VALIDATION_ERROR', 422);
            }

            $farmer = FarmerUser::where('email', $request->email)->first();

            if (!$farmer || !Hash::check($request->password, $farmer->password)) {
                return $this->errorResponse('Invalid email or password', 'INVALID_CREDENTIALS', 401);
            }

            $token = Auth::guard('farmer_api')->claims(['guard' => 'farmer_api'])->fromUser($farmer);

            $isFilled = !empty($farmer->name)
                && !empty($farmer->gender)
                && !empty($farmer->pincode)
                && !empty($farmer->MobileNumber)
                && !empty($farmer->post_office)
                && !empty($farmer->block)
                && !empty($farmer->tehsil);

            $checkAnimal = Animalinformation::where('user_id', $farmer->id)->count();
            $farmer->load(['district', 'getAnimalInformation']);
            $farmer['profileDone'] = $isFilled ? 'completed' : 'not_completed';
            $farmer['checkAnimal'] = $checkAnimal > 0 ? 'completed' : 'not_completed';

            return $this->successResponse('Farmer login successful', 200, [
                'token' => $token,
                'token_type' => 'bearer',
                'user' => $farmer,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function dashboard(Request $request) {
        try {
            $guard = $request->attributes->get('auth_guard');
            $user  = auth()->user();
            if (! $user) {
                return $this->errorResponse('Unauthenticated', 'UNAUTHENTICATED', 401);
            }

            if ($guard === 'farmer_api') {
                if (! $user instanceof FarmerUser) {
                    return $this->errorResponse('Farmer not authenticated', 'UNAUTHENTICATED', 401);
                }

                $serviceRequestsCount = Servicerequest::where('user_id', $user->id)->orderBy('id', 'desc')->count();

                return $this->successResponse(
                    'Farmer dashboard fetched successfully',
                    200,
                    [
                        'service_requests' => $serviceRequestsCount,
                    ]
                );
            }

            if ($guard === 'maitri_api') {
                if (! $user instanceof Maitri) {
                    return $this->errorResponse('Maitri not authenticated','UNAUTHENTICATED', 401);
                }
                $serviceRequestsCount = Servicerequest::where('maitri_id', $user->id)->count();
                return $this->successResponse('Maitri dashboard fetched successfully',200,['service_requests' => $serviceRequestsCount,]);
            }
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return $this->errorResponse('User not authenticated','UNAUTHENTICATED', 401);
            }

            $validator = Validator::make($request->all(), [
                'current_password' => 'required|string',
                'new_password'     => 'required|string|min:8|confirmed',
            ]);

            if($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(),422,$validator->errors());
            }

            $allowed = ($user->role === 'Farmer' && (int) $user->role_id === 4) || ($user->role === 'Maitri' && (int) $user->role_id === 3);

            if (!$allowed) {
                return $this->errorResponse('User role not permitted', 'FORBIDEN', 403);
            }

            if (!Hash::check($request->input('current_password'), $user->password)) {
                return $this->errorResponse('Your current password does not match with our record.', 'DATA_NOT_FOUND', 404);
            }

            if (Hash::check($request->input('new_password'), $user->password)) {
                return $this->errorResponse('New password cannot be same as your current password.', 'DATA_NOT_FOUND', 404);
            }

            $user->password = Hash::make($request->input('new_password'));
            $user->save();

            return $this->successResponse('Password changed successfully!', 200, null);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return $this->successResponse('Successfully logged out.', 200);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->errorResponse('The token is invalid.', 'INVALID_TOKEN', 403);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->errorResponse('The token has already expired.', 'EXPIRED_TOKEN', 403);
        } catch (JWTException $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 403);
        }
    }
}
