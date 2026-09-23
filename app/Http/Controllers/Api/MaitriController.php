<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Maitri\MaitriDashboardResource;
use App\Http\Resources\Api\Maitri\ServiceRequestResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Maitri;
use App\Models\Divisions;
use App\Models\Districts;
use App\MODELS\FarmerFeedback;
use App\Models\API\Role;
use App\Models\FarmerHighYielingAnimal;
use App\Models\API\Servicerequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\FormatResponseTrait;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class MaitriController extends Controller
{
    use FormatResponseTrait;

    public function getMaitriDetails(){
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }
        $mairtiData =  User::where(['id'=>$user->id])->first();
        $district = Districts::where('id', 'LIKE', '%' . $mairtiData['district_id'] . '%')->first();
        $mairtiData['districtName'] = $district['name_hindi'];
        if($mairtiData){
            $data = [
                'userData' => $mairtiData,
            ];
            return $this->successResponse('Get Profile Successfully',200, $data);
        }else{
            return $this->errorResponse('Profile Not get', 403);
        }
    }

    public function updateMaitriDetails(Request $request){

        $request->validate([
            'first_name'      => 'required|string|max:255',
            'MobileNumber'    => 'required',
            'district_id'     => 'nullable|string',
            'division_id'     => 'nullable|integer',
            'gram_panchayat'  => 'nullable|string|max:255',
            'post_office'     => 'nullable|string|max:255',
            'block'           => 'nullable|string|max:255',
            'tehsil'          => 'nullable|string|max:255',
            'gender'          => 'required|string',
        ]);
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }

        $mairtiUser = User::findOrFail($user->id);
        $district = Districts::where('name_hindi', 'LIKE', '%' . $request->district_id . '%')
                               ->orWhere('id', $request->district_id)->first();

        if($mairtiUser){
            $mairtiUser->name           = $request->first_name;
            $mairtiUser->FirstName      = $request->first_name;
            $mairtiUser->MobileNumber   = $request->MobileNumber;
            $mairtiUser->gender         = $request->gender;
            $mairtiUser->district_id    = $district ? $district->id : null;
            $mairtiUser->division_id    = $request->division_id;
            $mairtiUser->gram_panchayat = $request->gram_panchayat;
            $mairtiUser->post_office    = $request->post_office;
            $mairtiUser->pincode        = $request->pincode;
            $mairtiUser->block          = $request->block;
            $mairtiUser->tehsil         = $request->tehsil;
            $mairtiUser->save();

            return $this->successResponse('Profile Updated successfully', 200, $mairtiUser);
        }else{
            return $this->errorResponse('Profile not Updated', 400);
        }
    }

    public function monthly_progress_report(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated',
                ], 401);
            }

            $month = $request->month;
            $year  = $request->year;
            $perPage = $request->input('per_page', 10);
            $page = $request->input('page', $request->page);
            $query = Servicerequest::with(['user','maitri'])->orderBy('id', 'desc');

            if($month && $year) {
                $query->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month);
            }

            $data = $query->paginate($perPage, ['*'], 'page', $page);
            $items = $data->items();

            if (empty($items)) {
                return $this->successResponse('No Data Found', 200);
            }else{
                return $this->successResponse('Monthly Progress Report displayed successfully',200,$items, $data);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function service_request(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated',
                ], 401);
            }

            $perPage = $request->input('per_page', 10);
            $page = $request->input('page', $request->page);
            $query = Servicerequest::with('user')->where(['maitri_id' => $user->id])->orderBy('id', 'desc');

            $data = $query->paginate($perPage, ['*'], 'page', $page);
            $items = $data->items();

            if (empty($items)) {
                return $this->successResponse('No Service Request Found', 200);
            }else{
                return $this->successResponse('Service Request displayed successfully',200,$items, $data);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function update_service_status(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }

        $request_id = $request->service_request_id;
        $status = $request->status; //0-Accept, 1-New, 2-Waiting, 3-Decline

        $data = Servicerequest::where('id', $request_id)->first();
        if ($data) {
            $data->status = $status;
            $data->save();

            return $this->successResponse('Service Request Status Updated Successfully.', 200, $data);
        } else {
            return $this->errorResponse('Status updation failed', 404);
        }
    }

    public function service_category_list(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }

        $categories = [
            ['value' => 'sexed_semen_calf_born_elite_calf', 'label' => 'Sexed semen calf born - Elite Calf'],
            ['value' => '10_liter_day_desi_cow_elite_ndigenous_cow', 'label' => '10 liter/day desi cow - Elite Indigenous Cow'],
        ];

        return $this->successResponse('Service categories displayed successfully.',200, $categories);
    }

    public function add_animal_service_request(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }

        $animal_file = $request->animal_file;

        if($animal_file){
            $id = DB::table('maitri_animal_service')->insertGetID([
                    'user_id'     => $user->id,
                    'categories'  => $request->category,
                    'animal_file' => $animal_file,
            ]);

            $data =  DB::table('maitri_animal_service')->where('id', $id)->first();

            return $this->successResponse('Animal Service request saved successfully.',200, $data);
        }else{
            return $this->errorResponse('Animal image required', 404);
        }
    }

    /**
     * GET maitri dashboard (service requests for logged-in maitri).
     */
    public function dashboard(Request $request)
    {
        try {
            $maitri = auth()->user();
            if (!$maitri instanceof Maitri) {
                return $this->errorResponse('Maitri not authenticated', 401);
            }

            // $perPage = (int) $request->input('per_page', 10);
            // $query = Servicerequest::with(['user'])
            //     ->where('maitri_id', $maitri->id)
            //     ->orderBy('id', 'desc');

            // $data = $query->paginate($perPage);

            // $resource = new MaitriDashboardResource([
            //     'maitri'           => $maitri,
            //     'service_requests' => $data->items(),
            // ]);

            $data = Servicerequest::where('maitri_id', $maitri->id)->count();

            return $this->successResponse(
                'Maitri dashboard fetched successfully',
                200,
                ['service_requests' => $data]
            );

            // return $this->successResponse('Maitri dashboard fetched successfully', 200, [
            //     'maitri' => $maitri,
            //     'service_requests' => $data->items(),
            // ], $data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * POST maitri dashboard animal service upload (matches web maitri-dashdata).
     */
    public function maitriDashData(Request $request)
    {
        try {
            $maitri = auth()->user();
            if (!$maitri instanceof Maitri) {
                return $this->errorResponse('Maitri not authenticated', 401);
            }

            $validator = Validator::make($request->all(), [
                'categories' => ['required', 'string', 'max:255'],
                'animal_file' => ['required', 'file', 'mimes:gif,jpeg,jpg,png,svg', 'max:2048'],
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(ucfirst($validator->errors()->first()), 422);
            }

            $file = $request->file('animal_file');
            $fileName = 'file_' . time() . '.' . $file->extension();
            $destinationPath = public_path('assets/animals/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $fileName);

            $id = DB::table('maitri_animal_service')->insertGetId([
                'user_id' => $maitri->id,
                'categories' => $request->categories,
                'animal_file' => $fileName,
                'created_at' => now(),
            ]);

            $row = DB::table('maitri_animal_service')->where('id', $id)->first();
            if ($row) {
                $row->file_url = asset('assets/animals/' . $row->animal_file);
            }

            return $this->successResponse('Request submitted successfully', 200, $row);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * GET service request list for maitri (matches web request-list).
     */
    // public function requestList(Request $request)
    // {
    //     try {
    //         $maitri = auth()->user();
    //         if (!$maitri instanceof Maitri) {
    //             return $this->errorResponse('Maitri not authenticated', 401);
    //         }

    //         $perPage = (int) $request->input('per_page', 10);
    //         $status = $request->input('status');

    //         $query = Servicerequest::with(['user'])
    //             ->where('maitri_id', $maitri->id)
    //             ->orderBy('id', 'desc');

    //         if ($request->filled('status')) {
    //             $query->where('status', $status);
    //         }

    //         $data = $query->paginate($perPage);

    //         return $this->successResponse('Service request list fetched successfully', 200, $data->items(), $data);
    //     } catch (\Exception $e) {
    //         return $this->errorResponse($e->getMessage(), 500);
    //     }
    // }
    public function requestList(Request $request) {
        try {
            $maitri = auth()->user();
            if (!$maitri instanceof Maitri) {
                return $this->errorResponse('Maitri not authenticated', 401);
            }
            $perPage = (int) $request->input('per_page', 10);
            $query = Servicerequest::with(['user'])->where('maitri_id', $maitri->id)->orderBy('id', 'desc');

            $data = $query->paginate($perPage);
            return $this->successResponse("Service request list fetched successfully",200,ServiceRequestResource::collection($data),$data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
    /**
     * POST update service request status (matches web updateServiceRequest).
     * Body: id, status (or val like web)
     * Status: 0-Accept, 1-New, 2-Waiting, 3-Decline
     */
    public function updateServiceRequestStatus(Request $request)
    {
        try {
            $maitri = auth()->user();
            if (!$maitri instanceof Maitri) {
                return $this->errorResponse('Maitri not authenticated', 401);
            }

            $validator = Validator::make($request->all(), [
                'id' => ['required'],
                'status' => ['required_without:val', 'nullable', 'in:0,1,2,3'],
                'val' => ['required_without:status', 'nullable', 'in:0,1,2,3'],
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(ucfirst($validator->errors()->first()), 422);
            }

            $status = $request->filled('status') ? $request->status : $request->val;

            $serviceRequest = Servicerequest::where('maitri_id', $maitri->id)
                ->where('id', $request->id)
                ->first();

            if (!$serviceRequest) {
                return $this->errorResponse('Service request not found', 404);
            }

            $serviceRequest->status = $status;
            $serviceRequest->save();
            $serviceRequest->load('user');

            return $this->successResponse('Updated status successfully', 200, $serviceRequest);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * GET maitri profile details (matches web maitri-details).
     */
    public function maitriProfileDetails(Request $request)
    {
        try {
            $authUser = auth()->user();
            if (!$authUser instanceof Maitri) {
                return $this->errorResponse('Maitri not authenticated', 401);
            }

            $maitri = Maitri::where('id', $authUser->id)->first();
            $district = $maitri && $maitri->district_id
                ? Districts::find($maitri->district_id)
                : null;

            $divisions = Divisions::get(['id', 'name_hindi', 'name_eng']);
            $districts = Districts::when($maitri && $maitri->division_id, function ($query) use ($maitri) {
                return $query->where('division_id', $maitri->division_id);
            })->get(['id', 'division_id', 'name_hindi', 'name_eng']);

            return $this->successResponse('Maitri details fetched successfully', 200, [
                'maitri' => $maitri,
                'district_name' => $district->name_hindi ?? null,
                'divisions' => $divisions,
                'districts' => $districts,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * POST update maitri profile (partial update, first error only).
     * Matches web update-maitri-details.
     */
    public function updateMaitriProfile(Request $request)
    {
        try {
            $authUser = auth()->user();
            if (!$authUser instanceof Maitri) {
                return $this->errorResponse('Maitri not authenticated', 401);
            }

            $maitri = Maitri::findOrFail($authUser->id);

            $validator = Validator::make($request->all(), [
                'first_name' => 'sometimes|nullable|string|max:255',
                'maitri_name' => 'sometimes|nullable|string|max:255',
                'MobileNumber' => 'sometimes|nullable|string|max:15',
                'maitri_mobile_no' => 'sometimes|nullable|string|max:15',
                'email' => 'sometimes|nullable|email|unique:maitries,email,' . $maitri->id,
                'password' => 'sometimes|nullable|string|min:8|confirmed',
                'gender' => 'sometimes|nullable|string',
                'district_id' => 'sometimes|nullable',
                'division_id' => 'sometimes|nullable',
                'gram_panchayat' => 'sometimes|nullable|string|max:255',
                'post_office' => 'sometimes|nullable|string|max:255',
                'block' => 'sometimes|nullable|string|max:255',
                'tehsil' => 'sometimes|nullable|string|max:255',
                'pincode' => 'sometimes|nullable|string|max:6',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(ucfirst($validator->errors()->first()), 422);
            }

            if ($request->filled('first_name') || $request->filled('maitri_name')) {
                $maitri->maitri_name = $request->filled('first_name')
                    ? $request->first_name
                    : $request->maitri_name;
            }

            if ($request->filled('MobileNumber') || $request->filled('maitri_mobile_no')) {
                $maitri->maitri_mobile_no = $request->filled('MobileNumber')
                    ? $request->MobileNumber
                    : $request->maitri_mobile_no;
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
                if (is_numeric($request->district_id)) {
                    $district = Districts::find($request->district_id);
                } else {
                    $district = Districts::where('name_hindi', 'LIKE', '%' . $request->district_id . '%')->first();
                }
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
}
