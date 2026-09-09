<?php

namespace App\Http\Controllers\farmer;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Divisions;
use App\Models\FarmerUser;
use App\Models\Animalinformation;
use App\Models\Districts;
use App\Models\API\Role;
use App\Models\API\Servicerequest;
use App\Models\Maitri;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use DB;

class FarmerController extends Controller{

    public function index(){
        $districts  = Districts::get();
        $divisions  = Divisions::get();
        $user       = Auth::user()->id;
        $data       = Servicerequest::where(['user_id'=>$user])->get();
        return view('web.farmer.dashbaord',['data'=>$data], compact('districts','divisions'));
    }

    public function farmer_details()
    {
        $id = Auth::id();
        $divisions = Divisions::get();
        $data = FarmerUser::with(['district', 'getAnimalInformation'])->where('id', $id)->first();
        $districts = Districts::when($data && $data->division_id, function ($query) use ($data) {
            return $query->where('division_id', $data->division_id);
        })->get();

        return view('web.farmer.update-form', compact('data', 'id', 'districts', 'divisions'));
    }

    public function updateFarmerDateils(Request $request)
    {
        $user = FarmerUser::findOrFail(Auth::id());

        if ($request->exists('email') && !$request->filled('email')) {
            $request->merge(['email' => null]);
        }

        $validator = Validator::make($request->all(), [
            'first_name'      => 'required|string|max:255',
            'MobileNumber'    => 'required|string|max:15|unique:farmer_users,MobileNumber,' . $user->id,
            'email'           => 'nullable|email|unique:farmer_users,email,' . $user->id,
            'password'        => 'nullable|string|min:8|confirmed',
            'district_id'     => 'required',
            'division_id'     => 'required',
            'animal_type'     => 'nullable|array',
            'breeds'          => 'nullable|array',
            'cattale_no'      => 'nullable|array',
            'milk_day'        => 'nullable|array',
            'gram_panchayat'  => 'nullable|string|max:255',
            'post_office'     => 'nullable|string|max:255',
            'block'           => 'nullable|string|max:255',
            'tehsil'          => 'nullable|string|max:255',
            'pincode'         => 'nullable|string|max:6',
            'gender'          => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', ucfirst($validator->errors()->first()));
        }

        if (is_numeric($request->district_id)) {
            $district = Districts::find($request->district_id);
        } else {
            $district = Districts::where('name_hindi', 'LIKE', '%' . $request->district_id . '%')->first();
        }

        $user->name           = $request->first_name;
        $user->FirstName      = $request->first_name;
        $user->MobileNumber   = $request->MobileNumber;
        $user->gender         = $request->gender;
        if ($request->has('last_name')) {
            $user->LastName = $request->last_name;
        }
        if ($request->exists('email')) {
            $user->email = $request->filled('email') ? $request->email : null;
        }
        $user->district_id    = $district ? $district->id : $user->district_id;
        $user->division_id    = $request->division_id;
        $user->gram_panchayat = $request->gram_panchayat;
        $user->post_office    = $request->post_office;
        $user->pincode        = $request->pincode;
        $user->block          = $request->block;
        $user->tehsil         = $request->tehsil;

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

        if ($request->has('removeAnimal')) {
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

        return redirect()->route('farmer-details')->with('success', 'प्रोफ़ाइल सफलतापूर्वक अपडेट हो गई!');
    }


    public function getServiceFrom(){
        $farmer = Auth::user();
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
                ->get();
        }

        return view('web.farmer.service-form', [
            'maitries' => $maitries,
            'farmer' => $farmer,
            'missingLocation' => $missingLocation,
        ]);
    }

    public function checkUserDetails() {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
        }
        $user_id = Auth::id();
        $district = Districts::find($user->district_id);
        $farmerData = FarmerUser::with('getAnimalInformation')->where('id', $user_id)->first();
        $isFilled = !empty($user->name) && !empty($user->gender) && !empty($user->pincode) && !empty($user->MobileNumber) && !empty($user->post_office) && !empty($user->block) && !empty($user->tehsil);

        return response()->json([
            'status' => $isFilled ? 'filled' : 'not_filled',
            'userData' => $farmerData,
            'districtName' => $district->name_hindi ?? '',
            'animalInfo' => $farmerData,
        ]);
    }

    public function addFarmerRequests(Request $request){
        $validator = Validator::make($request->all(),[
                'services' => ['required'],
                'maitri_id' => ['required', 'exists:maitries,id'],
                'request_message' => ['required', 'max:1500'],
            ],
            [
                'services.required'        => 'कृपया सेवा चुनें।',
                'maitri_id.required'       => 'कृपया मैत्री चुनें।',
                'maitri_id.exists'         => 'चयनित मैत्री मान्य नहीं है।',
                'request_message.required' => 'कृपया संदेश लिखें।',
                'request_message.max'      => 'संदेश अधिकतम 250 शब्दों तक ही हो सकता है।',
            ]
        );
        if($validator->fails()){
            return redirect()->back()->withInput()->with('error', ucfirst($validator->errors()->first()));
        }

        $serviceRequest = new Servicerequest([
            'user_id'          => Auth::id(),
            'service_name'     => $request->services,
            'maitri_id'        => $request->maitri_id,
            'request_message'  => $request->request_message,
            'status'           => 1,
        ]);
        $serviceRequest->save();
        return redirect()->back()->with('success','आपका अनुरोध सफलतापूर्वक सबमिट किया गया!');
    }

    public function getAllServiceRequest(Request $request){
        $user_id = Auth::user()->id;
        $data    =  Servicerequest::with('user','maitri')->where(['user_id'=>$user_id])->get();
        return view('web.farmer.services-list',['data'=>$data]);
    }

    public function deleteRequest(Request $request){
       $data = Servicerequest::where(['id'=>$request->id])->delete();
       return response()->json(["message"=>'User deleted successfully!',"status"=>'Success',"data"=>$data],200);

    }
    public function farmerDashRequest(Request $request){
        $user  =  Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'insurance'  => ['bail', 'required', 'string', 'max:255'],
            'feedback'  => [ 'required'],
        ]);
        if($validator->fails()){
            $errors = $validator->errors();
            foreach($errors->all() as $key => $value){
                 return redirect()->back()->with('error',ucfirst($value));
            }
        }else{
                DB::table('farmer_feedback')->insert([
                        'user_id'     =>  $user,
                        'insurance'   =>  $request->insurance,
                        'feedback'    =>  $request->feedback,
                        'created_at'  =>   date('Y-m-d h:m:s'),
                ]);
            return redirect()->back()->with('success','अनुरोध सफलतापूर्वक प्रस्तुत किया गया!');
       }
    }

    public function highYieldingAnimal(Request $request){
        $user  =  Auth::user()->id;
        $data   = DB::table('farmer_high_yielding_animal')->where('user_id', $user)->get();
        return view('web.farmer.yielding-animal-form',['data'=>$data]);

    }
    public function addAnimaldetailsform(Request $request){
        return view('web.farmer.add-yielding-animal-form');
    }

    public function addUpdateAnimalDetails(Request $request){
        $user  =  Auth::user()->id;
        $validator = Validator::make($request->all(),[
            'type'  => [ 'required'],
            'file' => ['required', 'file', 'max:2048'],
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            foreach($errors->all() as $key => $value){
                 return redirect()->back()->with('error',ucfirst($value));
            }
        }else{
            if($request->hasfile('file')){
                // $name  = 'file'.$request->file('file')->extension();
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


                        // $request->file('file')->move(public_path('animals'), $name);
                        DB::table('farmer_high_yielding_animal')->insert([
                                'user_id'   =>  $user,
                                'type'      =>  $request->type,
                                'file'      =>  $fileName,
                                'details'   =>  $request->details,
                        ]);
                    }
                }
            }
            return redirect('high-yielding-animal')->with('success','अनुरोध सफलतापूर्वक प्रस्तुत किया गया!');
       }

    }
}
