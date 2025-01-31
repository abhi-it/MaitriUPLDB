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
use App\Models\FarmerUser;
use App\Models\API\Servicerequest;
use App\Traits\FormatResponseTrait;

class AuthController extends Controller
{
    use FormatResponseTrait;

    public function login(Request $request){
        try {
            $request->validate([
                'mobileNumber' => 'required',
            ]);
            $maitri = User::where('MobileNumber', $request->mobileNumber)->first();
            $farmer = FarmerUser::where('MobileNumber', $request->mobileNumber)->first();
            if ($farmer) {
                $otp = rand(10000, 99999);
                $farmer->otp_login = $otp;
                $number = $request->mobileNumber;
            
                if($otp){
                    $this->sendMobileMessage($number, $otp);
                    $farmer->save();
                    return $this->successResponse('OTP generated successfully',200, $otp);
                }
            } else if($maitri) {
                $otp = rand(10000, 99999);
                $maitri->otp_login = $otp;
                $number = $request->mobileNumber;
            
                if($otp){
                    $this->sendMobileMessage($number, $otp);
                    $maitri->save();
                    return $this->successResponse('OTP generated successfully',200, $otp);
                }
            } else {
                $farmerRegister  = new FarmerUser([
                    'MobileNumber'   => $request->mobileNumber,
                    'role_id'        => '4',
                    'role'           => 'Farmer',
                    'user_type'      => 'Farmer',
                ]);
                $registerFarmer = $farmerRegister->save();
                if($registerFarmer){
                    $number = $request->mobileNumber;
                    $userId = $farmerRegister->id;
                    $farmerData = FarmerUser::where('id', $userId)->first();
                    if($farmerData){
                        $otp = rand(10000, 99999);
                        $farmerData->otp_login = $otp;
                        $this->sendMobileMessage($number, $otp);
                        $farmerData->save();
                        return $this->successResponse('Farmer Register OTP send successfully',200, $otp);
                    }
                }else{
                    return $this->errorResponse('Number  not correct',200);
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function otpVerify(Request $request){
        try {
        
            $request->validate([
                'mobileNumber' => 'required',
                'otp' => 'required|numeric|digits:5',
            ]);
            $farmer = FarmerUser::where('MobileNumber', $request->mobileNumber)->where('otp_login', $request->otp)->first();
            $mairti = User::where('MobileNumber', $request->mobileNumber)->where('otp_login', $request->otp)->first();
            if ($farmer) {
                $token = JWTAuth::fromUser($farmer);
                $isFilled = !empty($farmer->name) && !empty($farmer->email) && !empty($farmer->gender) && !empty($farmer->pincode) && !empty($farmer->MobileNumber) && !empty($farmer->post_office) && !empty($farmer->block) && !empty($farmer->tehsil);
                $check_profile = $isFilled ? 'completed' : 'not_completed';
                $farmer['profileDone'] = $check_profile;
                $data = [
                    'token'     => $token,
                    'user'      => $farmer,
                ];
                return $this->successResponse('OTP verified successfully',200, $data);
            } else if($mairti){
                $token = JWTAuth::fromUser($mairti);
                $isFilled = !empty($mairti->name) && !empty($mairti->email) && !empty($mairti->gender) && !empty($mairti->pincode) && !empty($mairti->MobileNumber) && !empty($mairti->post_office) && !empty($mairti->block) && !empty($mairti->tehsil);
                $check_profile = $isFilled ? 'completed' : 'not_completed';
                $mairti['profileDone'] = $check_profile;
                $data = [
                    'token'     => $token,
                    'user'      => $mairti,
                ];
                return $this->successResponse('OTP verified successfully',200, $data);
            } else {
                return $this->errorResponse('Invalid OTP', 400);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
    
    public function sendMobileMessage($number, $otp){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://otpmsg.in//api/mt/SendSMS?apikey=b7f2ac82d29a4417b324b6ad1bddcbf9&senderid=UPLDBL&channel=Trans&DCS=0&flashsms=0&number='.$number.'&text=OTP%20for%20Login%20in%20Maitri%20app%20'.$otp.'%20If%20not%20requested%20by%20you%2C%20please%20contact%20your%20request%20maitriupldb.in%20UPLDB&route=18',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return;
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return $this->successResponse('Successfully logged out.', 200);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->errorResponse('The token is invalid.', 403);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->errorResponse('The token has already expired.', 403);
        } catch (JWTException $e) {
            return $this->errorResponse($e->getMessage(), 403);
        }
    }
}