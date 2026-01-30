<?php

namespace App\Http\Controllers;

use App\Models\AIcenters;
use App\Models\API\Role;
use App\Models\Block;
use App\Models\Maitri;
use App\Models\Blockslist;
use App\Models\Cliniclocation;
use App\Models\Aicentermapping;
use App\Models\Latestaicenter;
use App\Models\Manganurodhdata;
use App\Models\DeoUser;
use App\Models\Districts;
use App\Models\Divisions;
use App\Models\RequestData;
use App\Models\RemainingStock;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\InventoryMap;
use App\Models\Zonestock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Services\InventoryDistributionService;


class DeoStockUserController extends Controller
{
    public function deoInventory(){
        return view('deostock.index');
    }

    public function deoStockDetaikls(){
        $user = Auth::user();
        //echo "<pre>"; print_r($user); exit;
        $user_id = Auth::user()->id;
        $deoUser = DeoUser::where('user_id', $user_id)->first();

        $zone_id = $deoUser['zone_id'];
        $district_id = $deoUser['district_id'];
        
        $aiStocks = Zonestock::where(['location' => 'ai_center', 'zone_id' => $zone_id, 'district_id' => $district_id])->get();
        // echo "<pre>"; print_r($aiStocks->toArray()); exit;

        return view('deostock.deodetails', compact('aiStocks'));
    }

    public function deoStockForm(){
        $user_id = Auth::user()->id;
        $deoUser = DeoUser::where('user_id', $user_id)->first();
        $division_id = $deoUser['division_id'];
        $district_id = $deoUser['district_id'];
        $zone_id     = $deoUser['zone_id'];
        
        $getAiCenter = Latestaicenter::where('division_id', $division_id)
                    ->where('district_id', $district_id)
                    ->get();
    
        $ai_centers = [];
        foreach($getAiCenter as $aiCenter){
          
            $ai_centers[] = [
                'id' => $aiCenter['id'],
                'center_name' => $aiCenter['aicenter'],
            ];
        }
        
        // Get raw stock
        $aiCenterStocks = Zonestock::where(['location' => 'ai_center', 'zone_id' => $zone_id, 'district_id' => $district_id])->get();
        $maitriStocks = Zonestock::where(['location' => 'maitri', 'zone_id' => $zone_id, 'district_id' => $district_id])->get();

        // Aggregated stocks
        $InventoryDistributionService = new InventoryDistributionService();
        $finalAdminStocks = $InventoryDistributionService->aggregateStocks($aiCenterStocks);
        $finalZoneStocks  = $InventoryDistributionService->aggregateStocks($maitriStocks);

        //Remaining stock after zone distribution
        $finalStocks = $InventoryDistributionService->subtractStocks($finalAdminStocks, $finalZoneStocks);
        //echo "<pre>"; print_r($finalStocks->toArray()); exit;

        return view('deostock.deo-stock-form', compact('ai_centers', 'finalStocks', 'zone_id', 'division_id', 'district_id'));
    }

    public function searchMaitriData(Request $request){
        $user_id = Auth::user()->id;
        $aiCenter_id   = $request->id;
        $district       = $request->district;
        $division       = $request->division;

        $getMaitrisData     = Aicentermapping::where('aiCenter_id', $aiCenter_id)->get();

        $getMaitris = [];
        foreach($getMaitrisData as $data){
            $maitri_id  = $data['maitri_id'];
            $maitridata = Manganurodhdata::where('status', 0)->where('id', $maitri_id)->first();
            $getMaitris[] = $maitridata;
        }
        
        //echo '<pre>'; print_r($getMaitris); exit;
           
        if($getMaitris){
            return response()->json(['type' => 'maitri', 'res' => $getMaitris]);
        }else{
            return response()->json(['type' => 'nomaitri',]);
        }
        
    }

    public function deoStockRecord(Request $request){
        $user_id = Auth::user()->id;
        $deoUser = DeoUser::where('user_id', $user_id)->first();
        $district_id = $deoUser['district_id'];
        $zone_id     = $deoUser['zone_id'];
        
        $aiCenterDistributedRecord = Zonestock::with('maitri')->where(['location' => 'maitri', 'zone_id' => $zone_id, 'district_id' => $district_id])->get();
        //echo '<pre>';print_r($aiCenterDistributedRecord); exit;
        
        return view('deostock.deo-stock-record', compact('aiCenterDistributedRecord'));
    }

    public function deoRequestDataForm(){
        $user_id = Auth::user()->id;
        $getData = DeoUser::where('user_id', $user_id)->first();
        $block_id = $getData['block_id'];
        $blockName = Block::where('id', $block_id)->first();
        return view('deostock.deo-request-form', compact('blockName'));
    }

    public function deoRequestRecord(){
        $user_id = Auth::user()->id;
        $requestDatas= RequestData::where('request_user_id', $user_id)->get();
        $getRecordData = [];
        foreach($requestDatas as $requestData){
            $inventoryData = Zonestock::where('id', $requestData['inventory_id'])->first();
            $blockName = Block::where('id', $requestData['request_id'])->first();
            $userData = User::where('id', $user_id)->first();
            $inventoryData->user_name = $userData['FirstName'];
            $inventoryData->block_name = $blockName['block_name'];
            $inventoryData->block_hindi = $blockName['block_hindi'];
            $inventoryData->status = ($requestData['status'] == 0) ? 'Pending' : 'Approved';

            $getRecordData[] = $inventoryData;
        }
        return view('deostock.deo-request-record', compact('getRecordData'));
    }

    public function deoRequestSaveData(Request $request){
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

            $select_block = $request->select_block;
            $user_id = Auth::user()->id;

            RequestData::create([
                'request_user_id'   => $user_id,
                'request_id'        => $select_block,
                'inventory_id'      => $inventory->id,
                'status'            => 0
            ]);
            return redirect()->back()->with('success','Stock data submitted successfully!');
        }
    }

    public function deoSaveStockData(Request $request){
        // echo '<pre>';print_r($request->all()); exit;
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
        $ai_center_id           = $request->select_aicenter;
        $maitri_id              = $request->select_maitri;
        $supply_date            = $request->supply_date;

        if ($liquid_nitrogen_qty) {
            $inventoryData = [
                'user_id'      => $user_id,
                'zone_id'      => $zone_id,
                'district_id'  => $district_id,
                'ai_center_id' => $ai_center_id,
                'maitri_id'    => $maitri_id,
                'location'     => 'maitri',
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
                    'maitri_id' => $maitri_id,
                    'location'     => 'maitri',
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
                'maitri_id' => $maitri_id,
                'location'     => 'maitri',
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
                'maitri_id' => $maitri_id,
                'location'     => 'maitri',
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
                'maitri_id' => $maitri_id,
                'location'     => 'maitri',
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
                'maitri_id' => $maitri_id,
                'location'     => 'maitri',
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
                'maitri_id' => $maitri_id,
                'location'     => 'maitri',
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
                    'maitri_id' => $maitri_id,
                    'location'     => 'maitri',
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
    
}