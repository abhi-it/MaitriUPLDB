<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use File;
use App\Models\Latestaicenter;
use App\Models\Manganurodhdata;
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
use App\Helpers\TranslateTextHelper; 
use DB;
use App\Services\InventoryDistributionService;

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
        $user = Auth::user();
        //echo "<pre>"; print_r($user); exit;
        $user_id = Auth::user()->id;
        // get zone from division id
        $division = Divisions::where('id', $user['division_id'])->first();
        $zone_id = $division->zone_id;
        $district_id = $user->district_id;
        
        $districtStocks = Zonestock::where(['location' => 'district', 'zone_id' => $zone_id, 'district_id' => $district_id])->get();
        //echo "<pre>"; print_r($districtStocks->toArray()); exit;
        
        return view('districtstock.districtdetails', compact('districtStocks'));
    }

    public function districtStockForm(){
        $user = Auth::user();
        $user_id = Auth::user()->id;
        //echo "<pre>"; print_r($user); exit;
        $division_id = $user['division_id'];
        $district_id = $user['district_id'];

        $division = Divisions::where('id', $division_id)->first();
        $zone_id = $division['zone_id'];
        
        $aiCenters = Latestaicenter::where('division_id', $division_id)
        ->where('district_id', $district_id)
        ->get();

        // Get raw stock
        $districtStocks = Zonestock::where(['location' => 'district', 'zone_id' => $zone_id, 'district_id' => $district_id])->get();
        $aiCenterStocks = Zonestock::where(['location' => 'ai_center', 'zone_id' => $zone_id, 'district_id' => $district_id])->get();

        // Aggregated stocks
        $InventoryDistributionService = new InventoryDistributionService();
        $finalAdminStocks = $InventoryDistributionService->aggregateStocks($districtStocks);
        $finalZoneStocks  = $InventoryDistributionService->aggregateStocks($aiCenterStocks);

        //Remaining stock after zone distribution
        $finalStocks = $InventoryDistributionService->subtractStocks($finalAdminStocks, $finalZoneStocks);
        //echo "<pre>"; print_r($finalStocks->toArray()); exit;

        return view('districtstock.district-stock-form', compact('aiCenters', 'zone_id', 'user_id', 'division_id', 'district_id', 'finalStocks'));
    }

    public function districtSaveStockData(Request $request){
        //echo '<pre>';print_r($request->all()); exit;
        $user_id = Auth::user()->id;

        $liquid_nitrogen_qty    = $request->liquid_nitrogen;
        $semens                 = $request->semen; //[]
        $breedType              = $request->breedType; //[]
        $breed                  = $request->breed; //[]
        $semen_type             = $request->semen_type; //[]
        $bull_id                = $request->bull_id; //[]
        $semen_straws           = $request->semen_straws; //[] quantity

        $banner_qty             = $request->banner;
        $dangler_qty            = $request->dangler;
        $standee_qty            = $request->standee;
        $pamphlet_qty           = $request->pamphlet;
        $ai_kit_qty             = $request->ai_kit;

        $container_capacity     = $request->container_capacity; //[]
        $container_qty          = $request->container_qty; //[]

        $zone_id                = $request->zone_id;
        $district_id            = $request->district_id;
        $ai_center_id           = $request->select_aiCenter;
        $supply_date            = $request->supply_date;

        if ($liquid_nitrogen_qty) {
            $inventoryData = [
                'user_id'      => $user_id,
                'zone_id'      => $zone_id,
                'district_id'  => $district_id,
                'ai_center_id' => $ai_center_id,
                'location'     => 'ai_center',
                'supply_date'  => $supply_date,
                'item_type'    => 'liquid_nitrogen',
                'item'         => 'Liquid Nitrogen',
                'quantity'     => $liquid_nitrogen_qty,
            ];
            $inventory  = new Zonestock($inventoryData);
            $inventory->save();
        }

        if($semens){
            foreach($semens as $key => $semen){
                $inventoryData = [
                    'user_id'     => $user_id,
                    'zone_id'     => $zone_id,
                    'district_id' => $district_id,
                    'ai_center_id' => $ai_center_id,
                    'location'     => 'ai_center',
                    'supply_date' => $supply_date,

                    'item_type'              => 'species_semen',
                    'item'                   => 'Species Semen',
                    'species_semen'          => $semen,
                    'breed_type'             => $breedType[$key],
                    'breed'                  => $breed[$key],
                    'semen_type'             => $semen_type[$key],
                    'bull_id'                => $bull_id[$key],
                    'quantity'               => $semen_straws[$key],
                ];
        
                $inventory  = new Zonestock($inventoryData);
                $inventory->save();
            }
        }

        if ($banner_qty) {
            $inventoryData = [
                'user_id'     => $user_id,
                'zone_id'     => $zone_id,
                'district_id' => $district_id,
                'ai_center_id' => $ai_center_id,
                'location'     => 'ai_center',
                'supply_date' => $supply_date,

                'item_type'   => 'banner',
                'item'        => 'Banner',
                'quantity'    => $banner_qty,
            ];

            $inventory  = new Zonestock($inventoryData);
            $inventory->save();
        }

        if ($dangler_qty) {
            $inventoryData = [
                'user_id'     => $user_id,
                'zone_id'     => $zone_id,
                'district_id' => $district_id,
                'ai_center_id' => $ai_center_id,
                'location'     => 'ai_center',
                'supply_date' => $supply_date,

                'item_type'   => 'dangler_chart',
                'item'        => 'Dangler Chart',
                'quantity'    => $dangler_qty,
            ];
            $inventory  = new Zonestock($inventoryData);
            $inventory->save();
        }

        if ($standee_qty) {
            $inventoryData = [
                'user_id'     => $user_id,
                'zone_id'     => $zone_id,
                'district_id' => $district_id,
                'ai_center_id' => $ai_center_id,
                'location'     => 'ai_center',
                'supply_date' => $supply_date,

                'item_type'   => 'standee',
                'item'        => 'Standee',
                'quantity'    => $standee_qty,
            ];
            $inventory  = new Zonestock($inventoryData);
            $inventory->save();
        }

        if ($pamphlet_qty) {
            $inventoryData = [
                'user_id'     => $user_id,
                'zone_id'     => $zone_id,
                'district_id' => $district_id,
                'ai_center_id' => $ai_center_id,
                'location'     => 'ai_center',
                'supply_date' => $supply_date,

                'item_type'   => 'pamphlet',
                'item'        => 'Pamphlet',
                'quantity'    => $pamphlet_qty,
            ];
            $inventory  = new Zonestock($inventoryData);
            $inventory->save();
        }

        if ($ai_kit_qty) {
            $inventoryData = [
                'user_id'     => $user_id,
                'zone_id'     => $zone_id,
                'district_id' => $district_id,
                'ai_center_id' => $ai_center_id,
                'location'     => 'ai_center',
                'supply_date' => $supply_date,

                'item_type'   => 'ai_kit',
                'item'        => 'AI Kit',
                'quantity'    => $ai_kit_qty,
            ];
            $inventory  = new Zonestock($inventoryData);
            $inventory->save();
        }

        if($container_capacity){
            foreach($container_capacity as $key => $capacity){
                $inventoryData = [
                    'user_id'     => $user_id,
                    'zone_id'     => $zone_id,
                    'district_id' => $district_id,
                    'ai_center_id' => $ai_center_id,
                    'location'     => 'ai_center',
                    'supply_date' => $supply_date,

                    'item_type'           => 'container',
                    'item'                => 'Container',
                    'container_capacity'  => $capacity,
                    'quantity'            => $container_qty[$key],
                ];
        
                $inventory  = new Zonestock($inventoryData);
                $inventory->save();
            }
        }

        return redirect()->back()->with('success','Stock data submitted successfully!');
    }

    public function districtShowRecord(Request $request){
        $user = Auth::user();
        // get zone from division id
        $division = Divisions::where('id', $user['division_id'])->first();
        $zone_id = $division->zone_id;
        $district_id = $user->district_id;
        
        $distDistributedRecord = Zonestock::with('aiCenter')->where(['location' => 'ai_center', 'zone_id' => $zone_id, 'district_id' => $district_id])->get();
        //echo '<pre>';print_r($distDistributedRecord);exit;
        
        return view('districtstock.district-stock-record', compact('distDistributedRecord'));
    }

    function engtohindi($val){
        TranslateTextHelper::setSource('en')->setTarget('hi');
        if($val!=null){
            $translatedText = TranslateTextHelper::translate($val);
        }else{
            $translatedText ='';
        }
        return $translatedText; 
    }

    function hinditoenglish($val){
        TranslateTextHelper::setSource('hi')->setTarget('en');
        if($val!=null){
            $translatedText = TranslateTextHelper::translate($val);
        }else{
            $translatedText ='';
        }
        return $translatedText; 
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