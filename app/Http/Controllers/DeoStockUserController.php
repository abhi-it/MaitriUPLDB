<?php

namespace App\Http\Controllers;

use App\Models\AIcenters;
use App\Models\API\Role;
use App\Models\Block;
use App\Models\Blockslist;
use App\Models\Cliniclocation;
use App\Models\DeoUser;
use App\Models\Districts;
use App\Models\Divisions;
use App\Models\RequestData;
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

    public function deoStockForm(){
        $user_id = Auth::user()->id;
        $getDatas = DeoUser::where('user_id', $user_id)->get();
      
        $ai_centerName = [];
        foreach($getDatas as $getData){
            $aiCenterId = $getData['aicenters_id'];
            $aiCenterName = Cliniclocation::where('id', $getData['aicenters_id'])->first();
            $ai_centerName[] = [
                'id' => $aiCenterName['id'],
                'name_hindi' => $aiCenterName['name'],
                'name_eng' => $aiCenterName['name_eng'],
                'zone_id' => $getData['zone_id'],
                'division_id' => $getData['division_id'],
                'district_id' => $getData['district_id'],
                'block_id' => $getData['block_id'],
            ];
        }
        return view('deostock.deo-stock-form', compact('ai_centerName'));
    }

    public function deoStockDetaikls(){
        $user_id = Auth::user()->id;
        $inventoryIds = InventoryMap::where('user_id', $user_id)->first();
        $deoStock = Zonestock::where('id', $inventoryIds['inventory_id'])->get();
        return view('deostock.deodetails', compact('deoStock'));
    }

    public function deoStockRecord(){
        $user_id = Auth::user()->id;
        $inventoryIds = InventoryMap::where('assign_user_id', $user_id)->get();
        $deoStock = [];
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
                    $deoStock[] = $result;
                }
            }
        }

        return view('deostock.deo-stock-record', compact('deoStock'));
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
            
            $select_aicenter = $request->select_aicenter;
            $assign_user_id = Auth::user()->id;
            if($select_aicenter != ''){
                $result = DeoUser::where(['user_id' => $assign_user_id, 'aicenters_id' => $select_aicenter])->first();
                $deoTableId = $result['id'];
                $user_id = $result['user_id'];
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
            $assign_user_id = Auth::user()->id;
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
