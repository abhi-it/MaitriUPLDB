<?php

namespace App\Http\Controllers;

use App\Models\AIcenters;
use App\Models\API\Role;
use App\Models\Block;
use App\Models\Blockslist;
use App\Models\Cliniclocation;
use App\Models\InventoryMap;
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
        $inventoryIds = InventoryMap::where('user_id', $user_id)->get();
        
        $zoneStock = [];
        foreach($inventoryIds as $inventoryId){
            $zoneStock = Zonestock::where('id', $inventoryId['inventory_id'])->get();
        }
        if($zoneStock){
            return view('zonedetails.zonedetails', compact('zoneStock'));
        }else{
            return view('zonedetails.zonedetails', compact('zoneStock'));
        }
    }

    public function zoneDivisionStockForm(){ 
        $user_id = Auth::user()->id;
        $getDatas = InventoryMap::where('user_id', $user_id)->get();
        $zone_id = '';
        foreach($getDatas as $getData){
            $zone_id = $getData['zone_id'];
        }
        
        $divisions = DeoUser::where('zone_id', $zone_id)
                    ->where('division_id', '>', 0)
                    ->where('district_id', 0)
                    ->where('block_id', 0)
                    ->where('aicenters_id', 0)
                    ->get();

        $divisionName = '';
        foreach($divisions as $division){
            $divisionName = Divisions::where('id', $division['division_id'])->get();
        }
        return view('zonedetails.zone-division-stock-form', compact('divisionName','zone_id'));
    }

    public function zoneShowStockRecord(){
        $user_id = Auth::user()->id;
        $inventoryIds = InventoryMap::where('assign_user_id', $user_id)->get();
        DB::enableQueryLog();
        $zoneStock = [];
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
                $divisonData = Divisions::where('id', $division_id)->get();
                $userData = User::where('id', $user_id)->get();
                if ($divisonData) {
                    
                    $result->user_name = $userData[0]['FirstName'] . ' ' . $userData[0]['LastName'];
                    $result->division_name_eng = $divisonData[0]['name_eng'];
                    $result->division_name_hindi = $divisonData[0]['name_hindi'];
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

            $zone_id = $request->zone_id;
            $division_id = $request->select_division;
            $type = ( $division_id != '' ) ? 'Division' : '';
            if($type != ''){

                $result = DeoUser::where(['zone_id' => $zone_id, 'division_id' => $division_id, 'district_id' => 0, 'block_id' => 0, 'aicenters_id' => 0])->get();
                $deoTableId = $result[0]['id'];
                $user_id = $result[0]['user_id'];
            }
         
            $bullIds = implode(',',$request->bull_ids);
            $inventory  = new Zonestock([
                'demand_section'        => $request->demand_section,
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

            InventoryMap::create([
                'user_id' => $user_id,
                'inventory_id' => $inventory->id,
                'deo_id' => $deoTableId
            ]);

            return redirect()->back()->with('success','Stock data submitted successfully!');
        }
    }


}
