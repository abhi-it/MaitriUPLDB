<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Farmer\FarmerHighYielingAnimalResource;
use App\Http\Resources\Api\Farmer\FarmerServiceRequestResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FarmerUser;
use App\Models\Divisions;
use App\Models\Districts;
use App\Models\FarmerFeedback;
use App\Models\Animalinformation;
use App\Models\API\Role;
use App\Models\FarmerHighYielingAnimal;
use App\Models\API\Servicerequest;
use App\Models\Maitri;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\FormatResponseTrait;
use Illuminate\Support\Facades\DB;
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
        try {
            $user = JWTAuth::user();

            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated',
                ], 401);
            }

            $userData = FarmerUser::where('id', $user->id)->first();

            if (!$userData) {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }

            $isFilled =
                !empty($userData->name) &&
                !empty($userData->gender) &&
                !empty($userData->pincode) &&
                !empty($userData->MobileNumber) &&
                !empty($userData->post_office) &&
                !empty($userData->block) &&
                !empty($userData->tehsil);

            $checkProfile = $isFilled ? 'completed' : 'not_completed';

            $checkAnimal = Animalinformation::where('user_id', $user->id)->exists();

            $status = $checkAnimal ? 'completed' : 'not_completed';

            $user['profileDone'] = $checkProfile;
            $user['checkAnimal'] = $status;

            return $this->successResponse(
                'Get User Profile Successfully',
                200,
                $user
            );

        } catch (\Exception $e) {

            return $this->errorResponse(
                $e->getMessage(),
                500
            );
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

        return $this->successResponse('Services displayed successfully.',200, $services);
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

                $id = DB::table('farmer_high_yielding_animal')->insertGetID([
                        'user_id' =>  $user->id,
                        'type'    =>  $request->type,
                        'file'    =>  $fileName,
                        'details' =>  $request->details,
                ]);

                $data =  FarmerHighYielingAnimal::where('id', $id)->first();

                if($data){
                    return $this->successResponse('Animal Data saved successfully',200, $data);
                } else {
                    return $this->errorResponse('Error in saving data', 404);
                }

            } else {
                return $this->errorResponse('Uploaded file is not valid', 404);
            }
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
                'pincode' => 'nullable|string',
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

            if ($request->filled('pincode')) {
                $updateData['pincode'] = $request->pincode;
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

    /**
     * Farmer dashboard API (service requests list).
     */
    public function dashboard(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 401);
            }

            $perPage = (int) $request->input('per_page', 10);
            $query = Servicerequest::with(['maitri'])
                ->where('user_id', $user->id)
                ->orderBy('id', 'desc');

            $data = $query->paginate($perPage);
            $farmer = FarmerUser::with(['district', 'getAnimalInformation'])->find($user->id);

            return $this->successResponse('Farmer dashboard fetched successfully', 200, [
                'farmer' => $farmer,
                'service_requests' => $data->items(),
            ], $data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * GET service-request form data (maitri list by farmer district).
     */
    public function serviceRequestFormData(Request $request)
    {
        try {
            $farmer = auth()->user();
            if (!$farmer instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 401);
            }

            $missingLocation = [];
            if (empty($farmer->district_id)) {
                $missingLocation[] = 'ज़िला';
            }
            if (empty($farmer->tehsil)) {
                $missingLocation[] = 'तहसील';
            }
            if (empty($farmer->block)) {
                $missingLocation[] = 'विकास खण्ड';
            }

            $maitries = collect();
            if (!empty($farmer->district_id)) {
                $maitries = Maitri::where(function ($q) {
                        $q->where('status', 0)->orWhereNull('status');
                    })
                    ->where('district_id', $farmer->district_id)
                    ->orderByRaw("CASE WHEN block = ? THEN 0 ELSE 1 END", [$farmer->block ?? ''])
                    ->orderBy('block', 'asc')
                    ->orderBy('maitri_name', 'asc')
                    ->get([
                        'id',
                        'maitri_name',
                        'maitri_mobile_no',
                        'email',
                        'district_id',
                        'block',
                        'tehsil',
                        'center_name',
                    ]);
            }

            return $this->successResponse('Service requests data fetched successfully', 200, [
                'missing_location' => $missingLocation,
                'services' => getServiceList(),
                'maitries' => $maitries,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function serviceRequestList(Request $request) {
        try {
            $user = auth()->user();
            if (!$user instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 401);
            }

            $perPage = (int) $request->input('per_page', 10);
            $data = Servicerequest::with(['maitri'])->where('user_id', $user->id)->orderBy('id', 'desc')->paginate($perPage);
            
            return $this->successResponse("Farmer service request list",200,FarmerServiceRequestResource::collection($data),$data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * POST create farmer service request (with maitri_id).
     */
    public function submitServiceRequest(Request $request)
    {
        try {
            $farmer = auth()->user();
            if (!$farmer instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 401);
            }

            $validator = Validator::make($request->all(), [
                'services' => ['required'],
                'maitri_id' => ['required', 'exists:maitries,id'],
                'request_message' => ['required', 'max:1500'],
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation failed', 422, $validator->errors());
            }

            if (empty($farmer->district_id)) {
                return $this->errorResponse('Please update your district in profile before submitting a service request.', 422);
            }

            $serviceRequest = new Servicerequest([
                'user_id'         => $farmer->id,
                'service_name'    => $request->services,
                'maitri_id'       => $request->maitri_id,
                'request_message' => $request->request_message,
                'status'          => 1,
            ]);
            $serviceRequest->save();
            $serviceRequest->load('maitri');

            return $this->successResponse('Service request submitted successfully', 200, $serviceRequest);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * GET farmer profile details (farmer-details).
     */
    public function farmerDetails(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 401);
            }

            $farmer = FarmerUser::with(['district', 'getAnimalInformation'])
                ->where('id', $user->id)
                ->first();

            $divisions = Divisions::get(['id', 'name_hindi']);
            $districts = Districts::when($farmer && $farmer->division_id, function ($query) use ($farmer) {
                return $query->where('division_id', $farmer->division_id);
            })->get(['id', 'division_id', 'name_hindi', 'name_eng']);

            return $this->successResponse('Farmer details fetched successfully', 200, [
                'farmer' => $farmer,
                'divisions' => $divisions,
                'districts' => $districts,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * POST update farmer details — partial update (only sent fields are updated).
     */
    public function updateFarmerDetails(Request $request)
    {
        try {
            $authUser = auth()->user();
            if (!$authUser instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 401);
            }

            $user = FarmerUser::findOrFail($authUser->id);

            if ($request->exists('email') && !$request->filled('email')) {
                $request->merge(['email' => null]);
            }

            $validator = Validator::make($request->all(), [
                'first_name'     => 'sometimes|nullable|string|max:255',
                'last_name'      => 'sometimes|nullable|string|max:255',
                'MobileNumber'   => 'sometimes|nullable|string|max:15|unique:farmer_users,MobileNumber,' . $user->id,
                'email'          => 'sometimes|nullable|email|unique:farmer_users,email,' . $user->id,
                'password'       => 'sometimes|nullable|string|min:8|confirmed',
                'district_id'    => 'sometimes|nullable',
                'division_id'    => 'sometimes|nullable',
                'animal_type'    => 'sometimes|nullable|array',
                'breeds'         => 'sometimes|nullable|array',
                'cattale_no'     => 'sometimes|nullable|array',
                'milk_day'       => 'sometimes|nullable|array',
                'animal_id'      => 'sometimes|nullable|array',
                'removeAnimal'   => 'sometimes|nullable|array',
                'gram_panchayat' => 'sometimes|nullable|string|max:255',
                'post_office'    => 'sometimes|nullable|string|max:255',
                'block'          => 'sometimes|nullable|string|max:255',
                'tehsil'         => 'sometimes|nullable|string|max:255',
                'pincode'        => 'sometimes|nullable|string|max:6',
                'gender'         => 'sometimes|nullable|string',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(ucfirst($validator->errors()->first()), 422);
            }

            if ($request->filled('first_name')) {
                $user->name = $request->first_name;
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

            if ($request->filled('division_id')) {
                $user->division_id = $request->division_id;
            }

            if ($request->filled('district_id')) {
                if (is_numeric($request->district_id)) {
                    $district = Districts::find($request->district_id);
                } else {
                    $district = Districts::where('name_hindi', 'LIKE', '%' . $request->district_id . '%')->first();
                }
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

            if ($request->has('animal_type') && is_array($request->animal_type) && count($request->animal_type)) {
                $user->animal_type = $request->animal_type[0] ?? $user->animal_type;
                $user->breeds      = $request->breeds[0] ?? $user->breeds;
                $user->cattale_no  = $request->cattale_no[0] ?? $user->cattale_no;
                $user->milk_day    = $request->milk_day[0] ?? $user->milk_day;
            }

            $user->save();

            if ($request->has('removeAnimal') && is_array($request->removeAnimal)) {
                Animalinformation::whereIn('id', $request->removeAnimal)
                    ->where('user_id', $user->id)
                    ->delete();
            }

            if ($request->has('animal_type') && is_array($request->animal_type)) {
                foreach ($request->animal_type as $index => $animalType) {
                    if (empty($animalType)) {
                        continue;
                    }

                    $animalId = $request->animal_id[$index] ?? null;
                    $payload = [
                        'animal_type' => $animalType,
                        'breeds'      => $request->breeds[$index] ?? null,
                        'cattale_no'  => $request->cattale_no[$index] ?? null,
                        'milk_day'    => $request->milk_day[$index] ?? null,
                    ];

                    if (!empty($animalId)) {
                        Animalinformation::where('id', $animalId)
                            ->where('user_id', $user->id)
                            ->update($payload);
                    } else {
                        Animalinformation::create(array_merge($payload, [
                            'user_id' => $user->id,
                        ]));
                    }
                }
            }

            $user->load(['district', 'getAnimalInformation']);

            return $this->successResponse('Farmer profile updated successfully', 200, $user);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function getMaitriList() {
        try {
            $farmer = auth()->user();

            $maitries = collect();
            if (!empty($farmer->district_id)) {
                $maitries = Maitri::where(function ($q) {
                        $q->where('status', 0)->orWhereNull('status');
                    })
                    ->where('district_id', $farmer->district_id)
                    ->orderByRaw("CASE WHEN block = ? THEN 0 ELSE 1 END", [$farmer->block ?? ''])
                    ->orderBy('block', 'asc')
                    ->orderBy('maitri_name', 'asc')
                    ->get([
                        'id',
                        'maitri_name',
                        'maitri_mobile_no',
                        'email',
                        'district_id',
                        'block',
                        'tehsil',
                        'center_name',
                    ]);
            }

            return $this->successResponse('Get Maitri list successfully', 200, $maitries);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * GET high-yielding-animal list (matches web high-yielding-animal).
     */
    public function highYieldingAnimalList(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 401);
            }

            $perPage = (int) $request->input('per_page', 10);
            $data = FarmerHighYielingAnimal::where('user_id', $user->id)->orderBy('id', 'desc')->paginate($perPage);
            
            return $this->successResponse("High yielding animal list fetched successfully",200,FarmerHighYielingAnimalResource::collection($data),$data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * GET add form metadata (matches web add-yielding-animal).
     */
    public function getYieldingAnimalForm(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 401);
            }

            return $this->successResponse('Get High yielding animal form data successfully', 200,
                getYeildingAnimal(),
            );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * POST add high yielding animal (matches web addUpdateAnimalDetails).
     */
    public function addUpdateAnimalDetails(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 401);
            }

            $validator = Validator::make($request->all(), [
                'type' => ['required', 'in:buffalo,cow,goat,horse'],
                'file' => ['required', 'file', 'mimes:gif,jpeg,jpg,png,svg', 'max:2048'],
                'details' => ['nullable', 'string'],
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(ucfirst($validator->errors()->first()), 422);
            }

            $file = $request->file('file');
            $fileName = 'file_' . time() . '.' . $file->extension();
            $destinationPath = public_path('assets/animals/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $fileName);

            $data = new FarmerHighYielingAnimal();
            $data->user_id = $user->id;
            $data->type = $request->type;
            $data->file = $fileName;
            $data->details = $request->details;
            if($data->save()) {
                $data->file_url = asset('assets/animals/' . $data->file);
            }

            return $this->successResponse('High yielding animal saved successfully', 200, $data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


}
