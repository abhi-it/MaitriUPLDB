<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Divisions;
use App\Models\Districts;
use App\Models\FarmerFeedback;
use App\Models\Animalinformation;
use App\Models\API\Role;
use App\Models\FarmerHighYielingAnimal;
use App\Models\API\Servicerequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\FormatResponseTrait;
use DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class FarmerController extends Controller
{
    use FormatResponseTrait;


    public function allAnimalInfo(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }

        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', $request->page);
        $query = Animalinformation::where('user_id', $user->id)->orderBy('id', 'desc');
        $data = $query->paginate($perPage, ['*'], 'page', $page);
        $items = $data->items();

        if (empty($items)) {
            return $this->successResponse('No Animal Info Found', 200);
        }else{
            return $this->successResponse('Get All Animal Information',200,$items, $data);
        }
    }

    public function deleteAnimalInfo(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }
        $animal_id = $request->animal_id;
        $animal = Animalinformation::find($animal_id);
        
        if (!$animal) {
            return $this->errorResponse('Animal record not found', 404);
        }
        $animal->delete();
        return $this->successResponse('Animal record deleted successfully',200, $animal_id);
    }

    public function saveAnimalInfo(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }
        $data = $request->json()->all();

        $validator = Validator::make($data, [
            '*.user_id' => 'required|integer|exists:users,id',
            '*.animal_type' => 'required|string|in:cow,buffalo,goat',
            '*.breeds' => 'required|string',
            '*.cattale_no' => 'required|integer',
            '*.milk_day' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }
        $msg = '';
        foreach ($data as $animalData) {
            if($animalData['id'] == ''){
                Animalinformation::create([
                    'user_id'       => $animalData['user_id'],
                    'animal_type'   => $animalData['animal_type'],
                    'breeds'        => $animalData['breeds'],
                    'cattale_no'    => $animalData['cattale_no'],
                    'milk_day'      => $animalData['milk_day'],
                ]);
                $msg = "Animal information saved successfully";
                
            }else{
                $animal = Animalinformation::where('id', $animalData['id'])->first();
                if ($animal) {
                    $animal->update([
                        'animal_type'   => $animalData['animal_type'],
                        'breeds'        => $animalData['breeds'],
                        'cattale_no'    => $animalData['cattale_no'],
                        'milk_day'      => $animalData['milk_day'],
                    ]);
                }
                $msg = "Animal information updated successfully";
            }
        }

        return $this->successResponse($msg,200, $data);
    }

    public function maitri_list(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }
        $dis_id = Auth::user()->district_id;
        $maitries = User::where(['district_id' => $dis_id,'role_id' => 3])->get();
        if($maitries){
            return $this->successResponse('Maitri List diplayed succesfully.',200, $maitries);
        } else {
            return $this->errorResponse('Maitri not found', 404);
        }
    }

    public function getProfile(){
        $user = JWTAuth::user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }
        if ($user) {
            $isFilled = !empty($user->name) && !empty($user->email) && !empty($user->gender) && !empty($user->pincode) && !empty($user->MobileNumber) && !empty($user->cattale_no) && !empty($user->animal_type) && !empty($user->breeds) && !empty($user->post_office) && !empty($user->block) && !empty($user->tehsil)  && !empty($user->milk_day);
            $check_profile = $isFilled ? 'completed' : 'not_completed';
            $user['profileDone'] = $check_profile;
            return $this->successResponse('Get User Profile Successfully',200,$user);
        }else{
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function getServiceFrom(Request $request)
    {
        try {
            $user = auth()->user();
            // $userId = JWTAuth::user()->id;
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated',
                ], 401);
            }
        
            $request->validate([
                'services'      => 'required|string',
                'request_message'   => 'required|string',
            ]);
            $data = [
                'user_id'           => $user->id,
                'service_name'      => $request->services,
                // 'maitri_id'         => $request->maitri_id,
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

    public function getServiceRequest(Request $request)
    {
        try {
            // $user = auth()->user();
            $user = JWTAuth::user();
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


    public function serviceList(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }

        $services = [
            ['value' => 'frozen_semen_ai', 'label' => 'Frozen Semen AI'],
            ['value' => 'sex_semen_ai', 'label' => 'Sex Sorted Semen AI'],
            ['value' => 'ivf_embryo', 'label' => 'IVF Embryo'],
            ['value' => 'health_medical_checkip', 'label' => 'Helath/Medical Checkup'],
            ['value' => 'animal_insurance', 'label' => 'Animal Insurance'],
            ['value' => 'vaccination', 'label' => 'Vaccination'],
            ['value' => 'pregnancy_diagnosis', 'label' => 'Pregnancy Diagnosis'],
        ];

        return $this->successResponse('Services displayed successfully.',200, $animals);
    }

    public function highYieldingAnimal(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }

        $data = DB::table('farmer_high_yielding_animal')->where('user_id', $user->id)->get();
        if($data){
            return $this->successResponse('High Yielding Animal List successfully',200, $data);
        } else {
            return $this->errorResponse('High Yielding Animal List Empty', 404);
        }
    }

    public function animal_list(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }

        $animals = [
            ['value' => 'buffalo', 'label' => 'भैंस'],
            ['value' => 'cow', 'label' => 'गाय'],
            ['value' => 'goat', 'label' => 'बकरी'],
            ['value' => 'horse', 'label' => 'घोड़ा'],
        ];
        return $this->successResponse('Animal Types displayed successfully.',200, $animals);
    }

    public function add_animal(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }

        $id = DB::table('farmer_high_yielding_animal')->insertGetID([
                        'user_id' =>  $user->id,
                        'type'    =>  $request->type,
                        'file'    =>  $request->file,
                        'details' =>  $request->details,
                ]);

        $data =  FarmerHighYielingAnimal::where('id', $id)->first();

        if($data){
            return $this->successResponse('Animal Data saved successfully',200, $data);
        } else {
            return $this->errorResponse('Error in saving data', 404);
        }
    }

    public function delete_animal(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }

        $id = $request->id;
        $data = FarmerHighYielingAnimal::find($id);
        if($data){
            $data->delete();
            return $this->successResponse('Animal Data deleted successfully',200);
        }else {
            return $this->errorResponse('Animal data not found', 404);
        }
    }

    public function uploadImage(Request $request)
    {
        $file = $request->file;
        $image_ext = array('gif','jpeg', 'jpg', 'png', 'svg',);
        if ($file) {
            $file = $request->file('file');
            if ($file) {
                $fileName = 'file_' . time() . '.' . $file->extension();
            
                $destinationPath = public_path('assets/animals/');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true); 
                }
            
                $file->move($destinationPath, $fileName);
            
                $data = [
                    'file'    => $fileName,
                    'file_path' => asset('assets/animals/' . $fileName),
                ];
                return $this->successResponse('File uploaded successfully',200, $data);
            }
            else {
                return $this->errorResponse('Uploaded file is not valid', 404);
            }
        } else {
            return $this->errorResponse('No media file provided', 404);
        }
    }

    public function feedback(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }

        $id = DB::table('farmer_feedback')->insertGetID([
                'user_id'   =>  $user->id,
                'insurance' =>  $request->insurance, //yes, no
                'feedback'  =>  $request->feedback,
        ]);

        $feedback = FarmerFeedback::where('id', $id)->first();

        if($feedback){
            return $this->successResponse('Feedback saved successfully',200, $feedback);
        } else {
            return $this->errorResponse('Error in saving data', 404);
        }
    }

    public function getStatus(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }
        //0-Accept, 1-New, 2-Waiting, 3-Decline	
        $status = [
            ['id' => '0', 'name' => 'स्वीकार',],
            ['id' => '1', 'name' => 'नया'],
            ['id' => '2', 'name' => 'इंतज़ार'],
            ['id' => '3', 'name' => 'अस्वीकार'],
        ];

        return $this->successResponse('Status displayed successfully.',200, $status);
    }

    public function update_profile_old(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'nullable|string',
                'mobile' => 'nullable|int',
                'district_id' => 'nullable|int',
                'division_id' => 'nullable|int',
                'animal_type' => 'nullable|string',
                'breeds' =>'nullable|string',
                'cattale_no' => 'nullable|string',
                'gram_panchayat' => 'nullable|string',
                'post_office' => 'nullable|string',
                'block' => 'nullable|string',
                'tehsil' => 'nullable|string',
                'milk_day' => 'nullable|string',
                'gender' => 'nullable|string',
            ]);
    
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated',
                ], 401);
            }
    
            $user_id = $user->id;
            $userData = FarmerUser::find($user_id);
    
            if (!$userData) {
                return $this->errorResponse('User Not found', 404);
            }
    
            $userData->update([
                'name' => $request->first_name,
                'FirstName' => $request->first_name,
                'MobileNumber' => $request->mobile,
                'district_id' => $request->district_id,
                'division_id' => $request->division_id,
                'role_id' => '4', 
                'gram_panchayat' => $request->gram_panchayat,
                'post_office' => $request->post_office,
                'block' => $request->block,
                'tehsil' => $request->tehsil,
                'role' => 'Farmer', 
                'user_type' => 'Farmer',
                'gender' => $request->gender,
            ]);
    
            return $this->successResponse('User Profile Updated successfully', 200, $userData);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse("Validation failed", 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse("An error occurred", 500, $e->getMessage());
        }
    }

    public function update_profile(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'nullable|string',
                'mobile' => 'nullable|int',
                'district_id' => 'nullable|int',
                'division_id' => 'nullable|int',
                'animal_type' => 'nullable|string',
                'breeds' =>'nullable|string',
                'cattale_no' => 'nullable|string',
                'gram_panchayat' => 'nullable|string',
                'post_office' => 'nullable|string',
                'block' => 'nullable|string',
                'tehsil' => 'nullable|string',
                'milk_day' => 'nullable|string',
                'gender' => 'nullable|string',
            ]);

            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated',
                ], 401);
            }

            $user_id = $user->id;
            $userData = FarmerUser::find($user_id);

            if (!$userData) {
                return $this->errorResponse('User Not found', 404);
            }

            $updateData = [];

            if ($request->filled('first_name')) {
                $updateData['name'] = $request->first_name;
                $updateData['FirstName'] = $request->first_name;
            }
            if ($request->filled('mobile')) {
                $updateData['MobileNumber'] = $request->mobile;
            }
            if ($request->filled('district_id')) {
                $updateData['district_id'] = $request->district_id;
            }
            if ($request->filled('division_id')) {
                $updateData['division_id'] = $request->division_id;
            }
            if ($request->filled('gram_panchayat')) {
                $updateData['gram_panchayat'] = $request->gram_panchayat;
            }
            if ($request->filled('post_office')) {
                $updateData['post_office'] = $request->post_office;
            }
            if ($request->filled('block')) {
                $updateData['block'] = $request->block;
            }
            if ($request->filled('tehsil')) {
                $updateData['tehsil'] = $request->tehsil;
            }
            
            if ($request->filled('gender')) {
                $updateData['gender'] = $request->gender;
            }

            $updateData['role_id'] = '4';
            $updateData['role'] = 'Farmer';
            $updateData['user_type'] = 'Farmer';

            $userData->update($updateData);

            return $this->successResponse('User Profile Updated successfully', 200, $userData);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse("Validation failed", 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse("An error occurred", 500, $e->getMessage());
        }
    }

    
}