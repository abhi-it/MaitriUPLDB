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
use App\Services\InventoryDistributionService;


class ZoneStockDetailsController extends Controller
{
    public function zoneStockDetails(){
        $user = Auth::user();
        $zoneStocks = Zonestock::where(['location' => 'zone', 'zone_id' => $user->zone_id])->get();
        //echo "<pre>"; print_r($zoneStocks->toArray()); exit;
        return view('zonedetails.zonedetails', compact('zoneStocks'));
    }

    public function zoneDivisionStockForm(){
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $zone_id = $user['zone_id'];

        $divisionIds = Divisions::where('zone_id', $zone_id)->get();

        $districtName = [];
        foreach($divisionIds as $divisionId){
            $districts = Districts::where('division_id', $divisionId->id)->get();
            foreach($districts as $district){
                $districtName[] = $district;
            }
        }

        // Get raw stock
        $zoneStocks = Zonestock::where(['location' => 'zone', 'zone_id' => $user->zone_id])->get();
        $districtStocks = Zonestock::where(['location' => 'district', 'zone_id' => $user->zone_id])->get();
        // Aggregated stocks
        $InventoryDistributionService = new InventoryDistributionService();
        $finalAdminStocks = $InventoryDistributionService->aggregateStocks($zoneStocks);
        $finalZoneStocks  = $InventoryDistributionService->aggregateStocks($districtStocks);

        //Remaining stock after zone distribution
        $finalStocks = $InventoryDistributionService->subtractStocks($finalAdminStocks, $finalZoneStocks);

        // Debug if needed
        //echo "<pre>"; print_r($finalStocks->toArray()); exit;

        return view('zonedetails.zone-division-stock-form', compact('districtName','zone_id', 'finalStocks', 'user_id'));
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

    public function zoneShowStockRecord(Request $request){
        $user = Auth::user();
        $zone_id = $user['zone_id'];
        
        $zoneDistributedRecord = Zonestock::with('district')->where(['zone_id' =>$zone_id,'location' => 'district'])->get();
        //echo '<pre>';print_r($zoneDistributedRecord);exit;
        return view('zonedetails.zone-stock-record', compact('zoneDistributedRecord'));
    }


    public function saveZoneDivisionStockForm(Request $request){
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
        $district_id            = $request->select_district;
        $supply_date            = $request->supply_date;

        if ($liquid_nitrogen_qty) {
            $inventoryData = [
                'user_id'     => $user_id,
                'zone_id'     => $zone_id,
                'district_id' => $district_id,
                'location'    => 'district',
                'supply_date' => $supply_date,
                'item_type'   => 'liquid_nitrogen',
                'item'        => 'Liquid Nitrogen',
                'quantity'    => $liquid_nitrogen_qty,
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
                    'location'    => 'district',
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
                'location'    => 'district',
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
                'location'    => 'district',
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
                'location'    => 'district',
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
                'location'    => 'district',
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
                'location'    => 'district',
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
                    'location'    => 'district',
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


    
    public function zoneSimenStockForm(){
        //echo '<pre>';print_r($zoneDistributedRecord);exit;
        return view('zonedetails.zone-simen-stock-form');
    }

    public function zoneSimenStockSaveData(Request $request){
        $user = Auth::user();

        $semens       = $request->semen; //[]
        $breedType    = $request->breedType; //[]
        $breed        = $request->breed; //[]
        $semen_type   = $request->semen_type; //[]
        $bull_id      = $request->bull_id; //[]
        $semen_straws = $request->semen_straws; //[] quantity

        if($semens){
            foreach($semens as $key => $semen){
                $inventoryData = [
                    'user_id'        => $user->id,
                    'location'       => 'zone',
                    'zone_id'        => $user->zone_id,
                    'distributor'    => $request->distributor,
                    'item_type'      => 'species_semen',
                    'item'           => 'Species Semen',
                    'species_semen'  => $semen,
                    'breed_type'     => $breedType[$key],
                    'breed'          => $breed[$key],
                    'semen_type'     => $semen_type[$key],
                    'bull_id'        => $bull_id[$key],
                    'quantity'       => $semen_straws[$key],
                    'supply_date'    => date('Y-m-d')
                ];
        
                $inventory  = new Zonestock($inventoryData);
                $inventory->save();
            }
        }
        
        return redirect()->back()->with('success','Stock data submitted successfully!');
    }


}