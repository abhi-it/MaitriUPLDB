<?php

namespace App\Http\Controllers;

use App\Models\API\Role;
use App\Models\User;
use App\Models\Zone;
use App\Models\InventoryMap; 
use App\Models\RemainingStock;
use App\Models\DeoUser;
use App\Models\Districts;
use Illuminate\Http\Request;
use App\Models\Zonestock;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index(){
        $zones = Zone::all();
        $user_id = Auth::user()->id;
        $adminInventory = RemainingStock::where('user_id', $user_id)->get();
        return view('inventory.zone-stock-form', compact('zones', 'adminInventory','user_id'));
    }

    public function checkStockLimit(){
        $user_id = $_REQUEST['user_id'];
        $type = $_REQUEST['type'];
        $value = $_REQUEST['value'];
        $remainingStock = RemainingStock::where('user_id', $user_id)->first();

        if ($value !== null && $remainingStock && $type == 'demand_section') {
            $msg = ($remainingStock['demand_section'] >= $value) ? '' : 'Your number is high Out of range';
            echo json_encode(['demand' => $msg]);
            return;
        }

        if ($value !== null && $remainingStock && $type == 'banner') {
            $msg = ($remainingStock['banner'] >= $value) ? '' : 'Your number is high Out of range';
            echo json_encode(['banner' => $msg]);
            return;
        }

        if ($value !== null && $remainingStock && $type == 'dangler') {
            $msg = ($remainingStock['dangler'] >= $value) ? '' : 'Your number is high Out of range';
            echo json_encode(['dangler' => $msg]);
            return;
        }
        
        if ($value !== null && $remainingStock && $type == 'standee') {
            $msg = ($remainingStock['standee'] >= $value) ? '' : 'Your number is high Out of range';
            echo json_encode(['standee' => $msg]);
            return;
        }

        if ($value !== null && $remainingStock && $type == 'pamphlet') {
            $msg = ($remainingStock['pamphlet'] >= $value) ? '' : 'Your number is high Out of range';
            echo json_encode(['pamphlet' => $msg]);
            return;
        }

        if ($value !== null && $remainingStock && $type == 'ai_kit') {
            $msg = ($remainingStock['ai_kit'] >= $value) ? '' : 'Your number is high Out of range';
            echo json_encode(['ai_kit' => $msg]);
            return;
        }

        if ($value !== null && $remainingStock && $type == 'container') {
            $msg = ($remainingStock['container'] >= $value) ? '' : 'Your number is high Out of range';
            echo json_encode(['container' => $msg]);
            return;
        }
        

    }


    public function zoneStoreData(Request $request){
        
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
            
            $zone_id = $request->select_zone;
            if($zone_id != ''){
                $result = User::where(['zone_id' => $zone_id])->first(); 
                $deoTableId = DeoUser::where(['user_id' => $result['id']])->first();
                $user_id = $result['id'];
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
                'supply_date'     => $request->selectDate_supply,
                'semen'                 => $request->semen,
                'semen_type'            => $request->semen_type,
                'banner'                => $request->banner,
                'dangler'               => $request->dangler,
                'standee'               => $request->standee,
                'pamphlet'              => $request->pamphlet,
                'ai_kit'                => $request->ai_kit,
                'bull_ids'              => $bullIds,
                'container_capacity'    => $request->container_capacity,
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
                'zone_id' => $zone_id,
                'inventory_id' => $inventory->id,
                'deo_id' => $deoTableId['id']
            ]);

            return redirect()->back()->with('success','Stock data submitted successfully!');
        }
    }

}
