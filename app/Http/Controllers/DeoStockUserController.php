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


class DeoStockUserController extends Controller
{
    public function deoInventory(){
        return view('deostock.index');
    }

    public function searchMaitriData(Request $request){
        $user_id = Auth::user()->id;
        $aiCentername   = $request->id;
        $district       = $request->district;
        $division       = $request->division;

        // $getMaitris     = Aicentermapping::where('status',0)
        //                     ->where('mandal_name', 'LIKE', '%'.$division.'%')
        //                     ->where('janpad_name', 'LIKE', '%'.$district.'%')
        //                     ->where('center_name', 'LIKE', $aiCentername)->get();
        $remainingStock = RemainingStock::where('user_id', $user_id)->first();
        $getMaitrisData     = Aicentermapping::where('aiCenter_id', $aiCentername)->get();
        $getMaitris = [];
        foreach($getMaitrisData as $data){
            $maitri_id  = $data['maitri_id'];
            $maitridata = Manganurodhdata::where('status', 0)->where('id', $maitri_id)->first();
            $getMaitris[] = $maitridata;
        }         
                    
        if($getMaitris){
            return response()->json(['type' => 'maitri', 'success' => $getMaitris, 'remainingStock' => $remainingStock]);
        }else{
            return response()->json(['type' => 'nomaitri',]);
        }
        
    }

    public function deoStockForm(){
        $user_id = Auth::user()->id;
        $getDatas = DeoUser::where('user_id', $user_id)->first();

        $districtName = Districts::where('id', $getDatas['district_id'])->first();
        $divisionName = Divisions::where('id', $getDatas['division_id'])->first();

        // $getAiCenter = Manganurodhdata::select('center_name')->where('janpad_name', 'LIKE', '%'.$districtName['name_hindi'].'%')
        //                 ->groupBy(['center_name'])
        //                 ->get();
        $getAiCenter = Latestaicenter::where('division_id', $divisionName['id'])
                    ->where('district_id', $districtName['id'])
                    ->get();
    
        // $getAiCenter = Cliniclocation::where('mandal_name', 'LIKE', '%'.$divisionName['name_hindi'].'%')
        //                 ->where('janpad_name', 'LIKE', '%'.$districtName['name_hindi'].'%')->get();
       
        $district_id =  $getDatas['district_id'];                             
        $division_id =  $getDatas['division_id']; 
        $names = [
            'district' => $districtName['name_hindi'],
            'division' => $divisionName['name_hindi'],
        ];

        $ai_centerName = [];
        foreach($getAiCenter as $aiCenter){
          
            $ai_centerName[] = [
                'id' => $aiCenter['id'],
                'center_name' => $aiCenter['aicenter'],
            ];
        }
        $deoStock = RemainingStock::where('user_id', $user_id)->get();
        return view('deostock.deo-stock-form', compact('ai_centerName', 'deoStock', 'division_id', 'district_id', 'names'));
    }

    public function deoStockDetaikls(){
        $user_id = Auth::user()->id;
        $deoUser = DeoUser::where('user_id', $user_id)->first();
        if($deoUser){
            $division_id = $deoUser['division_id'];
            $district_id = $deoUser['district_id'];
            $getAiCenters = Latestaicenter::where('division_id', $division_id)
                        ->where('district_id', $district_id)
                        ->get();
                        
            
            $deoStock = InventoryMap::with('zoneStockDetails')->where('user_id', $user_id)->get();
            $inventoryData = [];
            // $deoStock = [];
            // foreach ($getAiCenters as $aiCenter) {
            //     $aiCenterUserId = $aiCenter['id'];
            //     $inventoryIds = InventoryMap::where('user_id', $aiCenterUserId)->first();
            //     $deoStockData = RemainingStock::where('user_id', $aiCenterUserId)->first();
            //     if ($inventoryIds ) {
            //         $inventoryData[] = $inventoryIds;
            //     }
            //     if ($deoStockData ) {
            //         $deoStock[] = $deoStockData;
            //     }
            // }
        }else{
            $deoStock = [];
            $inventoryData = [];
        }
        return view('deostock.deodetails', compact('deoStock', 'inventoryData'));
    }

    // public function deoStockRecord(){
    //     $user_id = Auth::user()->id;
    //     $inventoryIds = InventoryMap::where('assign_user_id', $user_id)->get();
    //     $deoStock = [];
    //     foreach($inventoryIds as $inventory){
    //         $division_User_id = $inventory['user_id'];
    //         $inventory_id = $inventory['inventory_id'];
    //         $results = DB::table('inventory_map_user')
    //                     ->join('zone_stock_details', 'inventory_map_user.inventory_id', '=', 'zone_stock_details.id')
    //                     ->join('deo_users', 'deo_users.id', '=', 'inventory_map_user.deo_id')
    //                     ->join('maitries', 'maitries.id', '=', 'inventory_map_user.maitri_id')
    //                     ->select('zone_stock_details.*', 'deo_users.*', 'maitries.*')
    //                     ->where(['inventory_map_user.assign_user_id' => $user_id])
    //                     ->get();

    //         foreach($results as $result){
    //             $maitri_id = $result->id;
    //             $userData = Maitri::where('id', $maitri_id)->first();
    //             if ($userData) {
    //                 $result->user_name = $userData['maitri_name'];
    //                 $result->maitri_mobile_no = $userData['maitri_mobile_no'];
    //                 $deoStock[] = $result;
    //             }
    //         }
    //     }

    //     return view('deostock.deo-stock-record', compact('deoStock'));
    // }

    public function deoStockRecord(Request $request){
        $user = Auth::user();
        $inventoryIds = InventoryMap::where('assign_user_id', $user->id)->pluck('assign_user_id');
        $query = DB::table('inventory_map_user')
                ->join('zone_stock_details', 'inventory_map_user.inventory_id', '=', 'zone_stock_details.id')
                ->join('deo_users', 'deo_users.id', '=', 'inventory_map_user.deo_id')
                ->join('maitries', 'maitries.id', '=', 'inventory_map_user.maitri_id')
                ->select('zone_stock_details.*', 'deo_users.*', 'maitries.*')
                ->whereIn('inventory_map_user.assign_user_id', $inventoryIds);
    
        
        // if ($request->filled('aicenter')) {
        //     $query->where('inventory_map_user.aicenter', 'LIKE', "%{$request->aicenter}%");
        // }
        if ($request->filled('select_maitri')) {
            $query->where('maitries.id', 'LIKE', "%{$request->select_maitri}%");
        }
        if ($request->filled('bull_id')) {
            $query->where('zone_stock_details.bull_ids', 'LIKE', "%{$request->bull_id}%");
        }
        if ($request->filled('breed')) {
            $query->where('zone_stock_details.breed', 'LIKE', "%{$request->breed}%");
        }
        if ($request->filled('semen')) {
            $query->where('zone_stock_details.semen', 'LIKE', "%{$request->semen}%");
        }
        if ($request->filled('semen_type')) {
            $query->where('zone_stock_details.semen_type','LIKE', "%{$request->semen_type}%");
        }
    
        $deoStock = $query->get();
        // echo '<pre>';print_r($deoStock);exit;
        $getData = User::where('id', $user->id)->first();
        $aiCenters = Latestaicenter::where('division_id', $getData['division_id'])
                    ->where('district_id', $getData['district_id'])
                    ->get();
        return view('deostock.deo-stock-record', compact('deoStock','aiCenters', 'getData'));
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
            
            $aicenter_id = $request->select_aicenter;
            $assign_user_id = Auth::user()->id;
            if($aicenter_id != ''){
                $result = DeoUser::where(['user_id' => $assign_user_id])->first();
                $deoTableId = $result['id'];
            }

            $breedType = [];
            $semens = $request->semen;
            $breeds = $request->breed;
            if($semens > 0){
                foreach($semens as $key => $semen){
                    
                    if( $semen == 'catle'){
                        if($breeds[$key] == 'swadeshi'){
                            $breedType = $request->breedType1;
                        }else if($breeds[$key] == 'hybrids-crossbred'){
                            $breedType = $request->breedType2;
                        }else if($breeds[$key] == 'videshi'){
                            $breedType = $request->breedType3;
                        }

                    }else if($semen == 'buffalo'){
                        $breedType = $request->breedType4;
                    }else if($semen == 'goat'){
                        $breedType = $request->breedType5;
                    }
                }
            }
            $inventory  = new Zonestock([
                'demand_section'        => $request->demand_section,
                // 'breed'                 => $request->breed,
                // 'breed_type'            => $breedType,
                // 'semen'                 => $request->semen,
                // 'semen_straws'          => $request->semen_straws,
                // 'semen_type'            => $request->semen_type,
                // 'bull_ids'              => $bullIds,
                'semen'                 => implode(',', $request->semen),
                'breed'                 => implode(',', $request->breed),
                'breed_type'            => implode(',', $breedType),
                'semen_type'            => implode(',', $request->semen_type),
                'semen_straws'          => implode(',', $request->semen_straws),
                'bull_ids'              => implode(',', $request->bull_id),
                'banner'                => $request->banner,
                'dangler'               => $request->dangler,
                'standee'               => $request->standee,
                'pamphlet'              => $request->pamphlet,
                'ai_kit'                => $request->ai_kit,
                'container_capacity'    =>$request->container_capacity,
                'container'             => $request->container,
                'scheme'                => $request->scheme,
            ]);

            $inventory->save();
            $assign_user_id = Auth::user()->id;
            InventoryMap::create([
                'assign_user_id' => $assign_user_id,
                'user_id' => $aicenter_id,
                'inventory_id' => $inventory->id,
                'deo_id' => $deoTableId,
                'maitri_id' => $request->select_maitri
            ]);
            return redirect()->back()->with('success','Stock data submitted successfully!');
        }
    }
    
}