<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use File;
use App\Models\InventoryMap;
use App\Models\Zonestock;
use App\Models\Block;
use App\Models\Divisions;
use App\Models\Cliniclocation;
use App\Models\DeoUser;
use App\Models\Districts;
use App\Models\API\Role;
use App\Models\Zone;
use App\Models\API\Servicerequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\RemainingStock;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use DB;

class DistrictUserController extends Controller{

    public function districtInventory(){  
        return view('districtuser.index');
    }

    public function createBlocktUser(){
        $user_id = Auth::user()->id;
        $data = User::where('id', $user_id)->first();
        $division_id = $data['division_id'];
        $district_id = $data['district_id'];

        $deoUser = DeoUser::where(['division_id' => $division_id, 'district_id' => $district_id ])->first();
        $zone_id = $deoUser['zone_id'];

        $getBlock = DeoUser::where(['zone_id' => $zone_id, 'division_id' => $division_id, 'district_id' => $district_id])->where('block_id', '>', 0)->first();
        
        $districts =  Districts::where('id', $district_id)->get();
        session()->forget('form_step1');

        return view('districtuser.createBlockUser', compact('districts', 'zone_id', 'division_id'));
    }

    public function districtStockDetails(){
        $user_id = Auth::user()->id;
        $inventoryIds = InventoryMap::where('user_id', $user_id)->first();
        // $divisionStock = Zonestock::where('id', $inventoryIds['inventory_id'])->get();
        $divisionStock = RemainingStock::where('user_id', $user_id)->get();
        return view('districtstock.districtdetails', compact('divisionStock'));
    }

    public function districtShowRecord(){
        $user_id = Auth::user()->id;
        $inventoryIds = InventoryMap::where('assign_user_id', $user_id)->get();
        $districtStock = [];
        foreach($inventoryIds as $inventory){
            $division_User_id = $inventory['user_id'];
            $inventory_id = $inventory['inventory_id'];
            $results = DB::table('inventory_map_user')
                        ->join('zone_stock_details', 'inventory_map_user.inventory_id', '=', 'zone_stock_details.id')
                        ->join('deo_users', 'deo_users.id', '=', 'inventory_map_user.deo_id')
                        ->select('zone_stock_details.*', 'deo_users.*')
                        ->where('inventory_map_user.user_id', $division_User_id)
                        ->get();

            foreach($results as $result){
                $division_id = $result->division_id;
                $user_id = $result->user_id;
                $divisonData = Divisions::where('id', $division_id)->first();
                $userData = User::where('id', $user_id)->first();
                if ($divisonData) {
                    $result->user_name = $userData['FirstName'] . ' ' . $userData['LastName'];
                    $result->division_name_eng = $divisonData['name_eng'];
                    $result->division_name_hindi = $divisonData['name_hindi'];
                    $districtStock[] = $result;
                }
            }
        }

        return view('districtstock.district-stock-record', compact('districtStock'));
    }

    public function districtStockForm(){
        $user_id = Auth::user()->id;
        $getData = User::where('id', $user_id)->first();
        $division_id = $getData['division_id'];
        $district_id = $getData['district_id'];
        $deoUser = DeoUser::where(['division_id' => $division_id, 'district_id' => $district_id ])->first();
        $zone_id = $deoUser['zone_id'];
        
        $districtName = Districts::where('id', $district_id)->first();
        $zoneName = Zone::where('id', $zone_id)->first();
        
        
        $aiCenters = ClinicLocation::where('mandal_name', 'LIKE', $zoneName['name_hindi'])
                        ->where('janpad_name', 'LIKE', $districtName['name_hindi'] )
                        ->get();
        
        $districtInventory = RemainingStock::where('user_id', $user_id)->get();
        return view('districtstock.district-stock-form', compact('aiCenters', 'zone_id', 'user_id', 'division_id', 'district_id', 'districtInventory'));
    }

    public function aiCenterGet(Request $request){
        $user_id = Auth::user()->id;
        $getData = User::where('id', $user_id)->first();
        $division_id = $getData['division_id'];
        $district_id = $getData['district_id'];
        $deoUser = DeoUser::where(['division_id' => $division_id, 'district_id' => $district_id ])->first();
        $zone_id = $deoUser['zone_id'];
        
        $districtName = Districts::where('id', $district_id)->first();
        $zoneName = Zone::where('id', $zone_id)->first();
        
        
        $aiCenters = ClinicLocation::where('mandal_name', 'LIKE', $zoneName['name_hindi'])
                        ->where('janpad_name', 'LIKE', $districtName['name_hindi'] )
                        ->get();

        return response()->json(['aicenter' => $aiCenters]);
    }

    public function districtSaveStockData(Request $request){
        $validator = Validator::make($request->all(),[
            'demand_section'  => [ 'required'],
            'semen' => [ 'required'],
            'semen_type' => [ 'required'],
        ]);
        if($validator->fails()){
            $errors = $validator->errors();
            foreach($errors->all() as $key => $value){
                 return redirect()->back()->with('error',ucfirst($value));
            }
        }else{
            
            $zone_id = $request->zone_id;
            $division_id = $request->division_id;
            $district_id = $request->district_id;
            $district_id = $request->district_id;
            $block_id = $request->block_id;
            $select_aiCenter = $request->select_aiCenter;
            // $type = ( $division_id != '' ) ? 'Division' : '';
            if($select_aiCenter != ''){
                $result = DeoUser::where(['zone_id' => $zone_id, 'division_id' => $division_id, 'district_id' => $district_id, 'block_id' => $block_id, 'aicenters_id' => $select_aiCenter])->first();
                $deoTableId = $result['id'];
                $user_id = $result['user_id'];
            }
         
            $bullIds = implode(',',$request->bull_ids);

            $breedType = null;
            if( $request->semen == 'catle'){
                switch ($request->breed) {
                    case 'swadeshi':
                        $request->validate([
                            'breedType1' => 'required|string',
                        ]);
                        $breedType = $request->breedType1;
                        break;

                    case 'hybrids-crossbred':
                        $request->validate([
                            'breedType2' => 'required|string',
                        ]);
                        $breedType = $request->breedType2;
                        break;

                    case 'videshi':
                        $request->validate([
                            'breedType3' => 'required|string',
                        ]);
                        $breedType = $request->breedType3;
                        break;

                    default:
                        return back()->withErrors(['breed' => 'Invalid breed selection.']);
                }
            }else if($request->semen == 'buffalo'){
                $breedType = $request->breedType4;
            }else if($request->semen == 'goat'){
                $breedType = $request->breedType5;
            }
            
            $inventory  = new Zonestock([
                'demand_section'        => $request->demand_section,
                'breed'                 => $request->breed,
                'breed_type'            => $breedType,
                'semen'                 => $request->semen,
                'semen_type'            => $request->semen_type,
                'banner'                => $request->banner,
                'dangler'               => $request->dangler,
                'standee'               => $request->standee,
                'pamphlet'              => $request->pamphlet,
                'ai_kit'                => $request->ai_kit,
                'bull_ids'              => $bullIds,
                'container_capacity'    =>$request->container_capacity,
                'container'             => $request->container,
                'scheme'                => $request->scheme,
            ]);

            $inventory->save();
            $assign_user_id = Auth::user()->id;

            $remainingStock = RemainingStock::where('user_id', $assign_user_id)->first();
            if ($remainingStock) {
                $remainingStock->demand_section = intval($remainingStock->demand_section) - intval($request->demand_section);
                $remainingStock->banner = intval($remainingStock->banner) - intval($request->banner);
                $remainingStock->dangler = intval($remainingStock->dangler) - intval($request->dangler);
                $remainingStock->standee = intval($remainingStock->standee) - intval($request->standee);
                $remainingStock->pamphlet = intval($remainingStock->pamphlet) - intval($request->pamphlet);
                $remainingStock->ai_kit = intval($remainingStock->ai_kit) - intval($request->ai_kit);
                $remainingStock->container = intval($remainingStock->container) - intval($request->container);
                $remainingStock->save();
            }

            $data = [
                'user_id'            => $user_id,
                'demand_section'     => $request->demand_section,
                'breed'              => $request->breed,
                'breed_type'         => $breedType,
                'semen'              => $request->semen,
                'semen_type'         => $request->semen_type,
                'banner'             => $request->banner,
                'dangler'            => $request->dangler,
                'standee'            => $request->standee,
                'pamphlet'           => $request->pamphlet,
                'ai_kit'             => $request->ai_kit,
                'bull_ids'           => $bullIds,
                'container_capacity' => $request->container_capacity,
                'container'          => $request->container,
                'scheme'             => $request->scheme,
            ];
            RemainingStock::create($data);


            InventoryMap::create([
                'assign_user_id' => $assign_user_id,
                'user_id' => $user_id,
                'inventory_id' => $inventory->id,
                'deo_id' => $deoTableId
            ]);

            return redirect()->back()->with('success','Stock data submitted successfully!');
        }
    }

    public function storeDistrictData(Request $request){
        $validator = \Validator::make($request->all(), [
            'zone' => 'required|integer',
            'division' => 'required|integer',
            'district' => 'required|integer',
            'aicenters' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validatedData = $validator->validated();
        session(['form_step1' => $validatedData]);
        return response()->json(['status' => 200]);
    }

    public function districtStoreStep2(){
        if (!session()->has('form_step1') || empty(session('form_step1'))) {
            return redirect()->route('create-block-user-form');
        }
        return view('districtuser.districtStepForm2');
    }

    public function userDataDistrictStore(Request $request){
        $validator = \Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $form_step1 = session('form_step1');

        $role = Role::where('name', 'deo')->first();
        $role_id = $role ? $role->id : null;

        $user = User::create([
            'name'        => $validatedData['username'],
            'FirstName'   => $validatedData['username'],
            'LastName'    => $validatedData['username'],
            'email'       => $validatedData['email'],
            'password'    => Hash::make($validatedData['password']),
            'division_id' => $form_step1['division'],
            'district_id' => $form_step1['district'],
            'role_id'     => $role_id,
            'role'        => 'deo',
            'user_type'   => 'Deo',
        ]);

        // $deoUser = DeoUser::create([
        //     'user_id'       => $user->id,
        //     'zone_id'       => $form_step1['zone'],
        //     'division_id'   => $form_step1['division'],
        //     'district_id' => $form_step1['district'],
        //     'block_id' => $form_step1['block'],
        //     'block_id' => $form_step1['block'],
        // ]);

        foreach($form_step1['aicenters'] as $aiCenterId){
            $deoUser = DeoUser::create([
                'user_id'       => $user->id,
                'zone_id'       => $form_step1['zone'],
                'division_id'   => $form_step1['division'],
                'district_id' => $form_step1['district'],
                // 'block_id' => $form_step1['block'],
                'aicenters_id' => $aiCenterId,
            ]);
        }

        session()->forget('form_step1');
        return response()->json(['status' => 200]);
    }
}