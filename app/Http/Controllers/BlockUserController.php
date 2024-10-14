<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use File;
use App\Models\InventoryMap;
use App\Models\Zonestock;
use App\Models\Cliniclocation;
use App\Models\Divisions;
use App\Models\DeoUser;
use App\Models\Districts;
use App\Models\Block;
use App\Models\API\Role;
use App\Models\Zone;
use App\Models\API\Servicerequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use DB;

class BlockUserController extends Controller{

    public function blockInventory(){  
        return view('blockuser.index');
    }

    public function blockStockSaveData(Request $request){
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
            $block_id = $request->block_id;
            $select_aicenter = $request->select_aicenter;
            // $type = ( $division_id != '' ) ? 'Division' : '';
            if($select_aicenter != ''){
                $result = DeoUser::where(['zone_id' => $zone_id, 'division_id' => $division_id, 'district_id' => $district_id, 'block_id' => $block_id, 'aicenters_id' => $select_aicenter])->first();
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

    public function showBlockStockData(){
        $user_id = Auth::user()->id;
        $inventoryIds = InventoryMap::where('assign_user_id', $user_id)->get();
        $blockStock = [];
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
                    $blockStock[] = $result;
                }
            }
        }

        return view('blockstock.block-stock-record', compact('blockStock'));
    }

    public function blockStockDetails(){
        $user_id = Auth::user()->id;
        $inventoryIds = InventoryMap::where('user_id', $user_id)->first();
        $blockStock = Zonestock::where('id', $inventoryIds['inventory_id'])->get();
        return view('blockstock.blockdetails', compact('blockStock'));
    }

    public function blockStockForm(){
        $user_id = Auth::user()->id;
        $getData = DeoUser::where('user_id', $user_id)->first();
        $zone_id = $getData['zone_id'];
        $division_id = $getData['division_id'];
        $district_id = $getData['district_id'];
        $block_id = $getData['block_id'];
        $blockData = DeoUser::where(['zone_id' => $zone_id, 'division_id' => $division_id, 'district_id' => $district_id, 'block_id' => $block_id])->where('aicenters_id', '>', 0)->get();
        
        $ai_centerName = [];
        foreach($blockData as $block){
            $aiCenterId = $block['aicenters_id'];
            $aiCenterName = Cliniclocation::where('id', $block['aicenters_id'])->first();

            $ai_centerName[] = [
                'id' => $aiCenterName['id'],
                'name_hindi' => $aiCenterName['name'],
                'name_eng' => $aiCenterName['name_eng'],
            ];
        }
        return view('blockstock.block-stock-form', compact('ai_centerName', 'zone_id', 'division_id', 'district_id', 'block_id'));
    }

    public function createDeoUser(){
        $user_id = Auth::user()->id;
        $data = DeoUser::where('user_id', $user_id)->first();
        $zone_id = $data['zone_id'];
        $division_id = $data['division_id'];
        $district_id = $data['district_id'];
        $block_id = $data['block_id'];
        $blocks =  Block::where('id', $data['block_id'])->get();
        session()->forget('form_step1');

        return view('blockuser.createDeoUser', compact('blocks', 'zone_id', 'division_id', 'district_id'));
    }

    public function storeDeoUserData(Request $request){
        $validator = \Validator::make($request->all(), [
            'zone' => 'required|integer',
            'division' => 'required|integer',
            'district' => 'required|integer',
            'block' => 'required|integer',
            'aicenters' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validatedData = $validator->validated();
        session(['form_step1' => $validatedData]);
        return response()->json(['status' => 200]);
    }

    public function deoStoreDataStep2(){
        if (!session()->has('form_step1') || empty(session('form_step1'))) {
            return redirect()->route('create-deo-user-form');
        }
        return view('blockuser.blockUserStep2');
    }

    public function deoUserDataStore(Request $request){
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

        foreach($form_step1['aicenters'] as $aiCenterId){
            $deoUser = DeoUser::create([
                'user_id'       => $user->id,
                'zone_id'       => $form_step1['zone'],
                'division_id'   => $form_step1['division'],
                'district_id' => $form_step1['district'],
                'block_id' => $form_step1['block'],
                'aicenters_id' => $aiCenterId,
            ]);
        }
        
        session()->forget('form_step1');
        return response()->json(['status' => 200]);
    }
}