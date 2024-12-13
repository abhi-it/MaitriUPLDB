<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use File;
use App\Models\Maitri;
use App\Models\Divisions;
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

    public function index(Request $request){
        // $allMaitri = Maitri::paginate(50);
        // return view('updategeolocation.index', compact('allMaitri'));
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
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        try {
            $updateGeo = Maitri::findOrFail($validatedData['maitri_id']);
            $updateGeo->update([
                'latitude'  => $validatedData['latitude'],
                'longitude' => $validatedData['longitude'],
            ]);
            return redirect()->route('all-maitri-geo-location')->with('success', 'GEO Location Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update GEO Location: ' . $e->getMessage());
        }
    }

}