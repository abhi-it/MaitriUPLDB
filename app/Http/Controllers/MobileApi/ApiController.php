<?php

namespace App\Http\Controllers\MobileApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use TokenInvalidException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\API\Servicerequest;
use App\Traits\FormatResponseTrait;
use DB;

class ApiController extends Controller
{
    use FormatResponseTrait;
    public function farmerLogin(Request $request){
        try {
            $request->validate([
                'mobileNumber' => 'required',
            ]);
            $farmer = User::where('MobileNumber', $request->mobileNumber)->first();
            if ($farmer) {
                $otp = rand(10000, 99999);
                $farmer->otp_login = $otp;
                $number = $request->mobileNumber;
            
                if($otp){
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
                    $farmer->save();
                    return $this->successResponse('OTP generated successfully',200, $otp);
                }
            } else {
                return $this->errorResponse('Email not correct',404);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422);
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
            $farmer = User::where('MobileNumber', $request->mobileNumber)->where('otp_login', $request->otp)->first();
            if ($farmer) {
                $token = JWTAuth::fromUser($farmer);
                $data = [
                    'token'     => $token,
                    'user'      => $farmer,
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

    public function getServiceFrom(Request $request){
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated',
                ], 401);
            }
        
            $request->validate([
                'services'      => 'required|string',
                'maitri_id'         => 'required|string',
                'request_message'   => 'required|string',
            ]);
            $data = [
                'user_id'           => $user->id,
                'service_name'      => $request->services,
                'maitri_id'         => $request->maitri_id,
                'request_message'   => $request->request_message,
                'status'            => 1,
            ];
            $request  = new Servicerequest($data);
            $request->save();
            return $this->successResponse('Service request received successfully',200, $data);
        
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function getServiceRequest(Request $request){
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated',
                ], 401);
            }

            $perPage = $request->input('per_page', 10);
            $page = $request->input('page', $request->page);
            $query = Servicerequest::with(['user', 'maitri'])
                ->where('user_id', $user->id)
                ->orderBy('id', 'desc');
            $data = $query->paginate($perPage, ['*'], 'page', $page);
            $items = $data->items();

            if (empty($items)) {
                return $this->successResponse('No Service Request Found', 200);
            }else{
                return $this->successResponse('Service requests fetched successfully',200,$items, $data);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function addUpdateAnimalDetails(Request $request){
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated',
                ], 401);
            }
            $request->validate([
                'type' => 'required',
                'file' => 'required',
            ]);
        
          
            if($request->hasfile('file')){
                $name  = 'file'.$request->file('file')->extension();
                $request->file('file')->move(public_path('animals'), $name);
                DB::table('farmer_high_yielding_animal')->insert([
                        'user_id'   =>  $user->id,
                        'type'      =>  $request->type,
                        'file'      =>  $name,
                        'details'   =>  $request->details,
                ]);
            }
            return $this->successResponse('Request Submitted successfully!',200);
   
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

    }

    public function highYieldingAnimal(Request $request){
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated',
                ], 401);
            }
            $data   = DB::table('farmer_high_yielding_animal')->where('user_id', $user->id)->get();
            return $this->successResponse('Service request Data',200, $data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
        
    }

    // Maitri Data
    public function getAllServiceRequest(Request $request){
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated',
                ], 401);
            }
            $data    =  Servicerequest::where(['maitri_id' => $user->id])->get();
            if($data){
                return $this->successResponse('Service request Data',200, $data);
            }else{
                return $this->successResponse('No Service Request',200, []);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

    }

    public function monthlyProgressReport(Request $request){
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated',
                ], 401);
            }
            $data   =  Servicerequest::with('user','maitri')->where(['maitri_id' => $user->id])->get();
            if($data){
                return $this->successResponse('Service Monthly Report Data',200, $data);
            }else{
                return $this->successResponse('Service Monthly Report Data',200, []);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function logout() {
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