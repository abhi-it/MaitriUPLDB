<?php

namespace App\Http\Controllers;

use App\Models\API\Role;
use App\Models\User;
use App\Models\Zone;
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
                $getUserId = User::where('user_type', $type)->get();
                $user_id = $getUserId[0]['id'];
                $role_id = $getUserId[0]['role_id'];
                
                $results = User::join('deo_users', 'deo_users.user_id', '=', 'users.id')
                            ->where('users.role', $type)
                            ->where('users.role_id', $role_id)
                            ->select('users.*', 'deo_users.*') // Select specific columns if needed
                            ->get();
                
            }

            // exit;

            $bullIds = implode(',',$request->bull_ids);
            $request  = new Zonestock([
                'demand_section'=> $request->demand_section,
                'semen'       => $request->semen,
                'semen_type'  => $request->semen_type,
                'banner'      => $request->banner,
                'dangler'     => $request->dangler,
                'standee'     => $request->standee,
                'pamphlet'    => $request->pamphlet,
                'ai_kit'      => $request->ai_kit,
                'bull_ids'    => $bullIds,
                'container_capacity' =>$request->container_capacity,
                'container'   => $request->container,
                'scheme'      => $request->scheme,
            ]);
            $request->save();
            return redirect()->back()->with('success','Stock data submitted successfully!');
        }
    }

}
