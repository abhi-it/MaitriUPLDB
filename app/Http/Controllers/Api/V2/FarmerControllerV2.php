<?php

namespace App\Http\Controllers\Api\V2;

use App\Helpers\ServiceHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Farmer\FarmerHighYielingAnimalResource;
use App\Http\Resources\Api\Farmer\FarmerServiceRequestResource;
use Illuminate\Http\Request;
use App\Models\FarmerUser;
use App\Models\Divisions;
use App\Models\Districts;
use App\Models\FarmerHighYielingAnimal;
use App\Models\API\Servicerequest;
use App\Models\Maitri;
use App\Traits\V2\FormatResponseTraitV2;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceRequestFeedback;

class FarmerControllerV2 extends Controller
{
    use FormatResponseTraitV2;

    public function serviceRequestFormData(Request $request)
    {
        try {
            $farmer = auth()->user();
            if (!$farmer instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 'UNAUTHENTICATED', 401);
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
                'services' => ServiceHelper::getServiceList(),
                'maitries' => $maitries,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function serviceRequestList(Request $request) {
        try {
            $user = auth()->user();
            if (!$user instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 'UNAUTHENTICATED', 401);
            }

            $perPage = (int) $request->input('per_page', 10);
            $data = Servicerequest::with(['maitri'])->where('user_id', $user->id)->orderBy('id', 'desc')->paginate($perPage);
            
            return $this->successResponse("Farmer service request list",200,FarmerServiceRequestResource::collection($data),$data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function submitServiceRequest(Request $request)
    {
        try {
            $farmer = auth()->user();
            if (!$farmer instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 'UNAUTHENTICATED', 401);
            }

            $validator = Validator::make($request->all(), [
                'services' => ['required'],
                'maitri_id' => ['required', 'exists:maitries,id'],
                'request_message' => ['required', 'max:1500'],
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 'VALIDATION_ERROR', 422, $validator->errors());
            }

            if (empty($farmer->district_id)) {
                return $this->errorResponse('Please update your district in profile before submitting a service request.', 'VALIDATION_ERROR', 422);
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
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function farmerDetails(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 'UNAUTHENTICATED', 401);
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
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function updateFarmerDetails(Request $request)
    {
        try {
            $authUser = auth()->user();
            if (!$authUser instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 'INVALID_CREDENTIALS', 401);
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
                return $this->errorResponse(ucfirst($validator->errors()->first()), 'VALIDATION_ERROR', 422);
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

            $user->load(['district', 'getAnimalInformation']);

            return $this->successResponse('Farmer profile updated successfully', 200, $user);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function getMaitriList(Request $request) {
        try {
            $farmer = auth()->user();
            $districtID  = $request->district_id ?? $farmer->district_id;

            $maitries = collect();
            if (!empty($districtID)) {
                $maitries = Maitri::where(function ($q) {
                        $q->where('status', 0)->orWhereNull('status');
                    })
                    ->where('district_id', $districtID)
                    ->orderByRaw("CASE WHEN block = ? THEN 0 ELSE 1 END", [$farmer->block ?? ''])
                    ->orderBy('block', 'asc')
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
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }
    
    // public function getMaitriList()
    // {
    //     try {
    //         $farmer = auth()->user();

    //         if (empty($farmer->district_id)) {
    //             return $this->successResponse(
    //                 'Please update your district to view the Maitri list',
    //                 200,
    //                 []
    //             );
    //         }

    //         $maitries = Maitri::where(function ($q) {
    //                 $q->where('status', 0)
    //                 ->orWhereNull('status');
    //             })
    //             ->where('district_id', $farmer->district_id)

    //             ->orderByRaw(
    //                 "CASE WHEN block = ? THEN 0 ELSE 1 END",
    //                 [$farmer->block ?? '']
    //             )
    //             ->orderBy('block', 'asc')
    //             ->orderBy('maitri_name', 'asc')

    //             ->get([
    //                 'id',
    //                 'maitri_name',
    //                 'maitri_mobile_no',
    //                 'email',
    //                 'district_id',
    //                 'block',
    //                 'tehsil',
    //                 'center_name',
    //             ]);

    //         return $this->successResponse(
    //             $maitries->isNotEmpty()
    //                 ? 'Get Maitri list successfully'
    //                 : 'No Maitri available in this district',
    //             200,
    //             $maitries
    //         );

    //     } catch (\Exception $e) {
    //         return $this->errorResponse(
    //             $e->getMessage(),
    //             'INTERNAL_SERVER_ERROR',
    //             500
    //         );
    //     }
    // }


    public function highYieldingAnimalList(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 'UNAUTHENTICATED', 401);
            }

            $perPage = (int) $request->input('per_page', 10);
            $data = FarmerHighYielingAnimal::where('user_id', $user->id)->orderBy('id', 'desc')->paginate($perPage);
            
            return $this->successResponse("High yielding animal list fetched successfully",200,FarmerHighYielingAnimalResource::collection($data),$data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function getYieldingAnimalForm(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 'UNAUTHENTICATED', 401);
            }

            return $this->successResponse('Get High yielding animal form data successfully', 200,
                ServiceHelper::getYeildingAnimal(),
            );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function addUpdateAnimalDetails(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 'UNAUTHENTICATED', 401);
            }

            $validator = Validator::make($request->all(), [
                'type' => ['required', 'in:buffalo,cow,goat,horse'],
                'file' => ['required', 'file', 'mimes:gif,jpeg,jpg,png,svg', 'max:2048'],
                'details' => ['nullable', 'string'],
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(ucfirst($validator->errors()->first()), 'VALIDATION_ERROR', 422);
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
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function addAnimal(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'animal_type' => ['required', 'array', 'min:1'],
                'breeds'      => ['required', 'array', 'min:1'],
                'cattale_no'  => ['required', 'array', 'min:1'],
                'milk_day'    => ['required', 'array', 'min:1'],
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 422, $validator->errors());
            }

            $duplicateError = $this->checkDuplicateAnimals(
                $request->animal_type,
                $request->breeds
            );
            if ($duplicateError) {
                return $this->errorResponse($duplicateError, 'ALREADY_EXIST', 422);
            }

            $counts = [
                count($request->animal_type),
                count($request->breeds),
                count($request->cattale_no),
                count($request->milk_day),
            ];
            if (count(array_unique($counts)) > 1) {
                return $this->errorResponse(
                    'animal_type, breeds, cattale_no, and milk_day arrays must have equal length.', 'NOT_MATCHED',
                    422
                );
            }

            $user = Auth::guard('farmer_api')->user();
            if (!$user) {
                return $this->errorResponse('Unauthenticated farmer.', 'UNAUTHENTICATED', 401);
            }

            $existing = DB::table('user_animal_information')
                ->where('user_id', $user->id)
                ->get()
                ->map(function ($row) {
                    return strtolower(trim($row->animal_type)) . '|' . strtolower(trim($row->breeds));
                })
                ->toArray();

            foreach ($request->animal_type as $index => $animalType) {
                $breed = $request->breeds[$index] ?? null;
                if (empty($animalType) || empty($breed)) continue;

                $key = strtolower(trim($animalType)) . '|' . strtolower(trim($breed));
                if (in_array($key, $existing)) {
                    return $this->errorResponse(
                        "Animal type '{$animalType}' with breed '{$breed}' already exists for this farmer.", 'ALREADY_EXIST',
                        422
                    );
                }
            }

            $this->insertAnimalInformation($user->id, $request);

            $user->load(['district', 'getAnimalInformation']);

            return $this->successResponse('Animals added successfully', 200, $user->getAnimalInformation);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    private function checkDuplicateAnimals(array $animalTypes, array $breeds): ?string
    {
        $combinations = [];

        foreach ($animalTypes as $index => $animalType) {
            $breed = $breeds[$index] ?? null;

            if (empty($animalType) || empty($breed)) {
                continue;
            }

            $key = strtolower(trim($animalType)) . '|' . strtolower(trim($breed));

            if (in_array($key, $combinations)) {
                return "Duplicate entry: Animal type '{$animalType}' with breed '{$breed}' is added more than once.";
            }

            $combinations[] = $key;
        }

        return null;
    }


    private function insertAnimalInformation(int $userId, Request $request): void
    {
        $rows = [];

        foreach ($request->milk_day as $index => $milkDay) {
            $animalType = $request->animal_type[$index] ?? null;
            if (empty($animalType)) {
                continue;
            }

            $rows[] = [
                'user_id'     => $userId,
                'milk_day'    => $milkDay,
                'animal_type' => $animalType,
                'breeds'      => $request->breeds[$index] ?? null,
                'cattale_no'  => $request->cattale_no[$index] ?? null,
            ];
        }

        if (!empty($rows)) {
            DB::table('user_animal_information')->insert($rows);
        }
    }

    public function getAllAnimal(Request $request)
    {
        try {
            $user = Auth::guard('farmer_api')->user();
            if (!$user) {
                return $this->errorResponse('Unauthenticated farmer.', 'UNAUTHENTICATED', 401);
            }

            $animals = DB::table('user_animal_information')
                ->where('user_id', $user->id)
                ->orderBy('id', 'desc')
                ->get();

            return $this->successResponse('Animals fetched successfully', 200, $animals);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function updateAnimal(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id'          => ['required', 'integer', 'exists:user_animal_information,id'],
                'animal_type' => ['required', 'string', 'max:255'],
                'breeds'      => ['required', 'string', 'max:255'],
                'cattale_no'  => ['required'],
                'milk_day'    => ['required'],
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 'VALIDATION_ERROR', 422, $validator->errors());
            }

            $user = Auth::guard('farmer_api')->user();
            if (!$user) {
                return $this->errorResponse('Unauthenticated farmer.', 'UNAUTHENTICATED', 401);
            }

            $animal = DB::table('user_animal_information')
                ->where('id', $request->id)
                ->where('user_id', $user->id)
                ->first();

            if (!$animal) {
                return $this->errorResponse('Animal not found or does not belong to you.', 'DATA_NOT_FOUND', 404);
            }

            $duplicateKey = strtolower(trim($request->animal_type)) . '|' . strtolower(trim($request->breeds));

            $existing = DB::table('user_animal_information')
                ->where('user_id', $user->id)
                ->where('id', '!=', $request->id)
                ->get()
                ->map(function ($row) {
                    return strtolower(trim($row->animal_type)) . '|' . strtolower(trim($row->breeds));
                })
                ->toArray();

            if (in_array($duplicateKey, $existing)) {
                return $this->errorResponse(
                    "Duplicate entry: Animal type '{$request->animal_type}' with breed '{$request->breeds}' already exists for this farmer.", 'ALREADY_EXIST',
                    422
                );
            }

            DB::table('user_animal_information')
                ->where('id', $request->id)
                ->where('user_id', $user->id)
                ->update([
                    'animal_type' => $request->animal_type,
                    'breeds'      => $request->breeds,
                    'cattale_no'  => $request->cattale_no,
                    'milk_day'    => $request->milk_day,
                    'updated_at'  => now(),
                ]);

            $updated = DB::table('user_animal_information')->where('id', $request->id)->first();

            return $this->successResponse('Animal updated successfully', 200, $updated);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function deleteAnimal(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => ['required', 'integer', 'exists:user_animal_information,id'],
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 'VALIDATION_ERROR', 422, $validator->errors());
            }

            $user = Auth::guard('farmer_api')->user();
            if (!$user) {
                return $this->errorResponse('Unauthenticated farmer.', 'UNAUTHENTICATED', 401);
            }

            $animal = DB::table('user_animal_information')
                ->where('id', $request->id)
                ->where('user_id', $user->id)
                ->first();

            if (!$animal) {
                return $this->errorResponse('Animal not found or does not belong to you.', 'DATA_NOT_FOUND', 404);
            }

            DB::table('user_animal_information')
                ->where('id', $request->id)
                ->where('user_id', $user->id)
                ->delete();

            return $this->successResponse('Animal deleted successfully', 200, null);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function submitServiceRequestFeedback(Request $request)
    {
        try {
            $farmer = auth()->user();
            if (!$farmer instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 'UNAUTHENTICATED', 401);
            }

            $validator = Validator::make($request->all(), [
                'service_id'  => ['required', 'exists:services_request,id'],
                'rating'      => ['required', 'integer', 'min:1', 'max:5'],
                'description' => ['nullable', 'string', 'max:1500'],
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(
                    ucfirst($validator->errors()->first()),
                    'VALIDATION_ERROR',
                    422,
                    $validator->errors()
                );
            }

            $serviceRequest = Servicerequest::where('id', $request->service_id)->where('user_id', $farmer->id)->first();

            if (!$serviceRequest) {
                return $this->errorResponse('Service request not found', 'DATA_NOT_FOUND', 404);
            }

            if ($serviceRequest->status != 0) {
                return $this->errorResponse(
                    'Feedback can only be submitted for accepted service requests.',
                    'VALIDATION_ERROR',
                    422
                );
            }

            if ($serviceRequest->feedback()->exists()) {
                return $this->errorResponse(
                    'Feedback already submitted for this service request.',
                    'VALIDATION_ERROR',
                    422
                );
            }

            $feedback = ServiceRequestFeedback::create([
                'service_request_id' => $serviceRequest->id,
                'farmer_id'          => $farmer->id,
                'maitri_id'          => $serviceRequest->maitri_id,
                'rating'             => $request->rating,
                'description'        => $request->description,
            ]);

            // $feedback->load(['maitri', 'serviceRequest']);

            return $this->successResponse('Feedback submitted successfully', 200, $feedback);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }
    
    public function getFarmerFeedbacks(Request $request)
    {
        try {
            $farmer = auth()->user();
            if (!$farmer instanceof FarmerUser) {
                return $this->errorResponse('Farmer not authenticated', 'UNAUTHENTICATED', 401);
            }

            $query = ServiceRequestFeedback::with([
                    'serviceRequest:id,service_name,status,maitri_id,user_id,created_at',
                    'maitri:id,maitri_name,maitri_mobile_no',
                ])->where('farmer_id', $farmer->id);

            if ($request->filled('service_id')) {
                $query->where('service_request_id', $request->service_id);
            }

            if ($request->filled('rating')) {
                $query->where('rating', $request->rating);
            }

            $perPage = $request->input('per_page', 10);
            $feedbacks = $query->orderByDesc('created_at')->paginate($perPage);

            return $this->successResponse('Feedbacks fetched successfully', 200, $feedbacks->items(), $feedbacks);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }
}
