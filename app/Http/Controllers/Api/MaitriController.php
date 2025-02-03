<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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
use DB;
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
}