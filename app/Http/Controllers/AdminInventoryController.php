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
use App\Models\InventoryMap;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Zonestock; 
use App\Models\RemainingStock; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;


class AdminInventoryController extends Controller
{
    public function adminStockForm(){
        return view('adminstockform.admin-stock-form');
    }

    public function adminStockRecord(){
        $user_id = Auth::user()->id;
        $adminInventory = RemainingStock::where('user_id', $user_id)->get();

        // $adminInventory = [];
        // foreach($inventoryIds as $inventoryId){
        //    $getData = Zonestock::where('id', $inventoryId['inventory_id'])->first();
        //    $adminInventory[] = $getData;
        // }
        return view('adminstockform.admin-stock-record', compact('adminInventory'));
    }


    public function adminStockDataSave(Request $request){
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

            $inventoryData = [
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
            ];
            $inventory  = new Zonestock($inventoryData);
            $inventory->save();

            $assign_user_id = Auth::user()->id;
            $user_id = Auth::user()->id;

            if ($user_id) {
                $data = [
                    'user_id'            => $user_id,
                    'demand_section'     => $request->demand_section,
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
                $remainingStock = RemainingStock::where('user_id', $user_id)->first();
                if ($remainingStock) {
                    $remainingStock->demand_section = intval($remainingStock->demand_section) + intval($data['demand_section']);
                    $remainingStock->banner = intval($remainingStock->banner) + intval($data['banner']);
                    $remainingStock->dangler = intval($remainingStock->dangler) + intval($data['dangler']);
                    $remainingStock->standee = intval($remainingStock->standee) + intval($data['standee']);
                    $remainingStock->pamphlet = intval($remainingStock->pamphlet) + intval($data['pamphlet']);
                    $remainingStock->ai_kit = intval($remainingStock->ai_kit) + intval($data['ai_kit']);
                    $remainingStock->container = intval($remainingStock->container) + intval($data['container']);
                    $remainingStock->save();
                } else {
                    $remainingStock = new RemainingStock(array_merge(['user_id' => $user_id], $data));
                    $remainingStock->save();
                }
            }

            InventoryMap::create([
                'assign_user_id' => $assign_user_id,
                'user_id' => $user_id,
                'inventory_id' => $inventory->id
            ]);
            return redirect()->back()->with('success','Stock data submitted successfully!');
        }
    }

    
}
