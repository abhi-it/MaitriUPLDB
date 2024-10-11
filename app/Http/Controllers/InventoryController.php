<?php

namespace App\Http\Controllers;

use App\Models\API\Role;
use App\Models\User;
use App\Models\Zone;
use App\Models\InventoryMap;
use App\Models\DeoUser;
use App\Models\Districts;
use Illuminate\Http\Request;
use App\Models\Zonestock;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public function index()
    {
        $zones = Zone::all();
        return view('inventory.zone-stock-form', compact('zones'));
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
            $type = ( $zone_id != '' ) ? 'Zone' : '';
            if($type != ''){

                $results = DeoUser::where(['zone_id' => $zone_id, 'division_id' => '', 'district_id' => '', 'block_id' => '', 'aicenters_id' => ''])->get();                


                foreach($results as $result){

                    $deoTableId = $result['id'];
                    $user_id = $result['user_id'];

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
                        'zone_id' => $zone_id,
                        'inventory_id' => $inventory->id,
                        'deo_id' => $deoTableId
                    ]);

                }
            }
          
            return redirect()->back()->with('success','Stock data submitted successfully!');
        }
    }

}
