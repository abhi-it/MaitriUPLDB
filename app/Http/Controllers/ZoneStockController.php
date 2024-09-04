<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CVOOfficers;
use Excel;
use App\Models\Zonestock;
use Illuminate\Support\Facades\Validator;

class ZoneStockController extends Controller{

    public function index(){
        $count  =  Zonestock::count();
        return view('zone-stock-form',compact('count'));
    }

    public function zoneStoreData(Request $request){
        // dd($request->all());
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
            $request  = new Zonestock([
                'demand_section'=> $request->demand_section,
                'semen'       => $request->semen,
                'semen_type'  => $request->semen_type,
                'banner'      => $request->banner,
                'dangler'     => $request->dangler,
                'standee'     => $request->standee,
                'pamphlet'    => $request->pamphlet,
                'ai_kit'      => $request->ai_kit,
                'container'   => $request->container,
                'scheme'      => $request->scheme,
            ]);
            $request->save();
            return redirect()->back()->with('success','Stock data submitted successfully!');
        }
    }


}