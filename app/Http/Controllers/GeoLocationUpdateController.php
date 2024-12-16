<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use File;
use App\Models\Maitri;
use App\Models\Divisions;
use App\Models\Cliniclocation;
use App\Models\Districts;
use App\Models\API\Role;
use App\Models\Zone;
use App\Models\API\Servicerequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use DB;

class GeoLocationUpdateController extends Controller{


    public function inactiveMaitriGEO(Request $request){
        $districts = Districts::all();
        $tehsilData =[];
        $blockData =[];
        $aiCenterData =[];
        $query = Maitri::query();
       
        if (!empty($request->input('district_id'))) {
            $query->where('status', 1)->where('janpad_name', 'LIKE', '%' . $request->input('district_id') . '%');
            $groupByTehsil = clone $query;
            $tehsilData = $groupByTehsil->select('tehsil', \DB::raw('COUNT(*) as count'))
                                    ->groupBy('tehsil')
                                    ->get();
        }
       
        if (!empty($request->input('tehsil'))) {
            $query->where('status', 1)->where('tehsil', 'LIKE', $request->input('tehsil'));
            $groupByBlock = clone $query;
            $blockData = $groupByBlock->select('block', \DB::raw('COUNT(*) as count'))
                                    ->groupBy('block')
                                    ->get();
        }

        if (!empty($request->input('block'))) {
            $query->where('status', 1)->where('block', 'LIKE', $request->input('block'));
            $groupByAicenter = clone $query;
            $aiCenterData = $groupByAicenter->select('center_name', \DB::raw('COUNT(*) as count'))
                                    ->groupBy('center_name')
                                    ->get();
        }

        if (!empty($request->input('aicenter'))) {
            $query->where('status', 1)->where('center_name', 'LIKE', $request->input('aicenter'));
        }
        
        $allMaitri = $query->where('status', 1)->paginate(50)->appends([
            'district_id' => $request->input('district_id'),
            'tehsil' => $request->input('tehsil'),
            'block' => $request->input('block'),
            'aicenter' => $request->input('aicenter'),
        ]);
        return view('updategeolocation.inactiveMaitriGeo', compact('allMaitri', 'districts', 'tehsilData', 'blockData', 'aiCenterData'));                                                                             
    }

    public function index(Request $request){
        $districts = Districts::all();
        $tehsilData =[];
        $blockData =[];
        $aiCenterData =[];
        $query = Maitri::query();
       
        if (!empty($request->input('district_id'))) {
            $query->where('janpad_name', 'LIKE', '%' . $request->input('district_id') . '%');
            $groupByTehsil = clone $query;
            $tehsilData = $groupByTehsil->select('tehsil', \DB::raw('COUNT(*) as count'))
                                    ->groupBy('tehsil')
                                    ->get();
        }
       
        if (!empty($request->input('tehsil'))) {
            $query->where('tehsil', 'LIKE', $request->input('tehsil'));
            $groupByBlock = clone $query;
            $blockData = $groupByBlock->select('block', \DB::raw('COUNT(*) as count'))
                                    ->groupBy('block')
                                    ->get();
        }

        if (!empty($request->input('block'))) {
            $query->where('block', 'LIKE', $request->input('block'));
            $groupByAicenter = clone $query;
            $aiCenterData = $groupByAicenter->select('center_name', \DB::raw('COUNT(*) as count'))
                                    ->groupBy('center_name')
                                    ->get();
        }

        if (!empty($request->input('aicenter'))) {
            $query->where('center_name', 'LIKE', $request->input('aicenter'));
        }
        
        $allMaitri = $query->paginate(50)->appends([
            'district_id' => $request->input('district_id'),
            'tehsil' => $request->input('tehsil'),
            'block' => $request->input('block'),
            'aicenter' => $request->input('aicenter'),
        ]);
        return view('updategeolocation.index', compact('allMaitri', 'districts', 'tehsilData', 'blockData', 'aiCenterData'));
    }

    public function editGeoLocation($id){
        $getMaitri = Maitri::where('id', $id)->first();
        return view('updategeolocation.edit-geo-location', compact('getMaitri'));
    }

    public function updateGeoLocation(Request $request) {
        $validatedData = $request->validate([
            'maitri_id' => 'required|exists:maitries,id',
        ]);

        try {
            $updateGeo = Maitri::findOrFail($validatedData['maitri_id']);
            $updateGeo->update([
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,
                'status' => $request->status,
            ]);
            return redirect()->route('all-maitri-geo-location')->with('success', 'GEO Location Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update GEO Location: ' . $e->getMessage());
        }
    }

    // Update AI Center GEO Locations

    public function inactiveAiCneterGEO(Request $request){
        $districts = Districts::all();
        $aiCenterData =[];
        $query = Cliniclocation::query();
       
        if (!empty($request->input('district_id'))) {
            $query->where('status', 1)->where('janpad_name', 'LIKE', '%' . $request->input('district_id') . '%');
            $groupByTehsil = clone $query;
            $aiCenterData = $groupByTehsil->select('name', \DB::raw('COUNT(*) as count'))
                                    ->groupBy('name')
                                    ->get();
        }

        if (!empty($request->input('aicenter'))) {
            $query->where('status', 1)->where('name', 'LIKE', $request->input('aicenter'));
        }
        
        $allAicenter = $query->where('status', 1)->paginate(50)->appends([
            'district_id' => $request->input('district_id'),
            'aicenter' => $request->input('aicenter'),
        ]);
        return view('updategeoaicenter.inactiveAicenter', compact('allAicenter', 'districts', 'aiCenterData'));
    }

    public function aicenterindex(Request $request){
        $districts = Districts::all();
        $aiCenterData =[];
        $query = Cliniclocation::query();
       
        if (!empty($request->input('district_id'))) {
            $query->where('janpad_name', 'LIKE', '%' . $request->input('district_id') . '%');
            $groupByTehsil = clone $query;
            $aiCenterData = $groupByTehsil->select('name', \DB::raw('COUNT(*) as count'))
                                    ->groupBy('name')
                                    ->get();
        }

        if (!empty($request->input('aicenter'))) {
            $query->where('name', 'LIKE', $request->input('aicenter'));
        }
        
        $allAicenter = $query->paginate(50)->appends([
            'district_id' => $request->input('district_id'),
            'aicenter' => $request->input('aicenter'),
        ]);
        return view('updategeoaicenter.index', compact('allAicenter', 'districts', 'aiCenterData'));
    }

    public function editGeoAicenter($id){
        $getaicenter = Cliniclocation::where('id', $id)->first();
        return view('updategeoaicenter.editData', compact('getaicenter'));
    }

    public function updateAicenterLocation(Request $request) {
       
        if($request->aicenter_id){
            $updateGeo = Cliniclocation::findOrFail($request->aicenter_id);
            $updateGeo->update([
                'name'  => $request->center_name,
                'lattitute'  => $request->latitude,
                'longitute' => $request->longitude,
                'status' => $request->status,
            ]);
            $redirectUrl = '/all-aicenter-geo-location?' . http_build_query([
                'district_id' => $request->janpad_name,
                'aicenter'    => $request->name,
            ]);
            return redirect($redirectUrl)->with('success', 'Data Updated Successfully');
        }
    }
    
    
}