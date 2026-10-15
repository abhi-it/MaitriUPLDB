<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Api\Maitri\ServiceRequestResource;
use App\Models\Maitri;
use App\Models\Divisions;
use App\Models\Districts;
use App\Models\API\Servicerequest;
use App\Traits\V2\FormatResponseTraitV2;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class MaitriControllerV2 extends Controller
{
    use FormatResponseTraitV2;

    public function maitriDashData(Request $request)
    {
        try {
            $maitri = auth()->user();
            if (!$maitri instanceof Maitri) {
                return $this->errorResponse('Maitri not authenticated', 'UNAUTHENTICATED', 401);
            }

            $validator = Validator::make($request->all(), [
                'categories' => ['required', 'string', 'max:255'],
                'animal_file' => ['required', 'file', 'mimes:gif,jpeg,jpg,png,svg', 'max:2048'],
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(ucfirst($validator->errors()->first()), 'VALIDATION_ERROR', 422);
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
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function requestList(Request $request) {
        try {
            $maitri = auth()->user();
            if (!$maitri instanceof Maitri) {
                return $this->errorResponse('Maitri not authenticated', 'UNAUTHENTICATED', 401);
            }
            $perPage = (int) $request->input('per_page', 10);
            $query = Servicerequest::with(['farmer'])->where('maitri_id', $maitri->id)->orderBy('id', 'desc');

            $data = $query->paginate($perPage);
            return $this->successResponse("Service request list fetched successfully",200,ServiceRequestResource::collection($data),$data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

     public function updateServiceRequestStatus(Request $request)
    {
        try {
            $maitri = auth()->user();
            if (!$maitri instanceof Maitri) {
                return $this->errorResponse('Maitri not authenticated', 'UNAUTHENTICATED', 401);
            }

            $validator = Validator::make($request->all(), [
                'id' => ['required'],
                'status' => ['required', 'in:0,1,2,3'],
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(ucfirst($validator->errors()->first()), 'VALIDATION_ERROR', 422,$validator->errors());
            }

            $status = $request->filled('status') ? $request->status : 1;

            $serviceRequest = Servicerequest::where('maitri_id', $maitri->id)->where('id', $request->id)->first();

            if (!$serviceRequest) {
                return $this->errorResponse('Service request not found', 'DATA_NOT_FOUND', 404);
            }

            $serviceRequest->status = $status;
            $serviceRequest->save();
            $serviceRequest->load('user');

            return $this->successResponse('Updated status successfully', 200, $serviceRequest);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function maitriProfileDetails(Request $request)
    {
        try {
            $authUser = auth()->user();
            if (!$authUser instanceof Maitri) {
                return $this->errorResponse('Maitri not authenticated', 'UNAUTHENTICATED', 401);
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
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }

    public function updateMaitriProfile(Request $request)
    {
        try {
            $authUser = auth()->user();
            if (!$authUser instanceof Maitri) {
                return $this->errorResponse('Maitri not authenticated', 'UNAUTHENTICATED', 401);
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
                return $this->errorResponse(ucfirst($validator->errors()->first()), 'VALIDATION_ERROR', 422);
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
            return $this->errorResponse($e->getMessage(), 'INTERNAL_SERVER_ERROR', 500);
        }
    }
}
