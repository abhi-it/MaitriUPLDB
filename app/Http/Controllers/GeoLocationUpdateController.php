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

    public function index(){
        $allMaitri = Maitri::paginate(50);
        return view('updategeolocation.index', compact('allMaitri'));
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
