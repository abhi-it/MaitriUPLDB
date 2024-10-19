<?php

namespace App\Http\Controllers;

use App\Models\AIcenters;
use App\Models\API\Role;
use App\Models\Block;
use App\Models\Blockslist;
use App\Models\Cliniclocation;
use App\Models\InventoryMap;
use App\Models\RemainingStock;
use App\Models\DeoUser;
use App\Models\Districts;
use App\Models\Divisions;
use App\Models\User;
use App\Models\Zone;
use App\Models\Zonestock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ZoneStockDetailsController extends Controller
{
    public function zoneStockDetails(){
        $user_id = Auth::user()->id;
        $inventoryIds = InventoryMap::where('user_id', $user_id)->first();
        // $zoneStock = Zonestock::where('id', $inventoryIds['inventory_id'])->get();
        $zoneStock = RemainingStock::where('user_id', $user_id)->get();
        return view('zonedetails.zonedetails', compact('zoneStock'));
  
    }

    public function zoneDivisionStockForm(){
        $user_id = Auth::user()->id;
        $getData = User::where('id', $user_id)->first();
        $zone_id = $getData['zone_id'];
        $divisionIds = Divisions::where('zone_id', $getData['zone_id'])->get();

        $districtName = [];
        foreach($divisionIds as $divisionId){
            $districts = Districts::where('division_id', $divisionId->id)->get();
            foreach($districts as $district){
                $districtName[] = $district;
            }
        }


        $zoneInventory = RemainingStock::where('user_id', $user_id)->get();
        return view('zonedetails.zone-division-stock-form', compact('districtName','zone_id', 'zoneInventory', 'user_id'));
    }

    public function getZoneDistrict(Request $request){
        $zone_id = $request->zone_id;
        $divisionIds = Divisions::where('zone_id', $zone_id)->get();

        $district = [];
        foreach($divisionIds as $divisionId){
            $districtNames = Districts::where('division_id', $divisionId->id)->get();
            foreach($districtNames as $districtName){
                $district[] = $districtName;
            }
            
        }
     
        return response()->json(['district' => $district]);
    }


    public function zoneShowStockRecord(){
        $user_id = Auth::user()->id;
        $inventoryIds = InventoryMap::where('assign_user_id', $user_id)->get();
        DB::enableQueryLog();
        $zoneStock = [];
        foreach($inventoryIds as $inventory){
            $district_User_id = $inventory['user_id'];
            $inventory_id = $inventory['inventory_id'];


            $results = DB::table('inventory_map_user')
                        ->join('zone_stock_details', 'inventory_map_user.inventory_id', '=', 'zone_stock_details.id')
                        ->join('deo_users', 'deo_users.id', '=', 'inventory_map_user.deo_id')
                        ->select('zone_stock_details.*', 'deo_users.*')
                        ->where(['inventory_map_user.user_id' => $district_User_id, 'inventory_map_user.assign_user_id' => $user_id])
                        ->get();

            foreach($results as $result){
                $district_id = $result->district_id;
                $user_id = $result->user_id;
                $districtData = Districts::where('id', $district_id)->first();
                $userData = User::where('id', $user_id)->first();
                if ($districtData) {
                    $result->user_name = $userData['FirstName'];
                    $result->division_name_eng = $districtData['name_eng'];
                    $result->division_name_hindi = $districtData['name_hindi'];
                    $zoneStock[] = $result;
                }
            }
        }

        return view('zonedetails.zone-stock-record', compact('zoneStock'));
    }

    public function saveZoneDivisionStockForm(Request $request){
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
            $assign_user_id = Auth::user()->id;
            $zone_id = $request->zone_id;
            $select_district = $request->select_district;
            $division = Districts::where('id', $select_district)->first();
            $division_id = $division['division_id'];
            
         
            if($select_district != ''){
                $result = DeoUser::where(['zone_id' => $zone_id, 'division_id' => $division_id, 'district_id' => $select_district])->first();
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
                'breed'                 => $request->breed,
                'breed_type'            => $breedType,
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


}
