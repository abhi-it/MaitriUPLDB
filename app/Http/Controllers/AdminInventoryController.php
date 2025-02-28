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
use App\Models\EventModal;  
use App\Models\Manganurodhdata;
use App\Models\DailyDashboard;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Zonestock; 
use App\Models\RemainingStock; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Exports\FarmarListExport;
use DB;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\API\Servicerequest;

class AdminInventoryController extends Controller
{
    public function getFarmerRequest(Request $request){
        $district = Districts::get();
        $query = Servicerequest::with(['user', 'maitri', 'user.district']) ->orderBy('id', 'desc');; 
        if (!empty($request->input('district_id'))) {
            $districtId = $request->input('district_id');
            $query->whereHas('user', function ($q) use ($districtId) {
                $q->where('district_id', '=', $districtId);
            });
        }
        $data = $query->paginate(10);

        $getMaitri = User::where('role', 'Maitri')->get();
        return view('farmardata.farmer-request-list', [
            'data' => $data,
            'district' => $district,
            'getMaitri' => $getMaitri
        ]);
    }
    

    public function farmarsData(Request $request){
        $districts = Districts::get();
        $farmarUserQuery = User::where('role', 'LIKE', 'Farmer')
                            ->join('districts', 'users.district_id', '=', 'districts.id')
                            ->orderBy('users.id', 'desc');
        
        if ($request->has('district_id') && !empty($request->input('district_id'))) {
            $districtId = $request->input('district_id');
            $farmarUserQuery->where('users.district_id', $districtId);
        }

        if ($request->has('mobile') && !empty($request->input('mobile'))) {
            $mobile = $request->input('mobile');
            $farmarUserQuery->where('users.MobileNumber', $mobile);
        }
    
        $farmarUser = $farmarUserQuery->paginate(30);
        return view('farmardata.index', compact('farmarUser', 'districts'));
    }

    public function farmerDeleteRequest(Request $request){
        $data = Servicerequest::where(['id'=>$request->id])->delete();
        return response()->json(["message"=>'Request deleted successfully!',"status"=>'Success',"data"=>$data],200);
    }

    public function updateStatus(Request $request){
        $row = Servicerequest::find($request->id);
        if ($row) {
            $row->status = $request->status;
            $row->maitri_id = $request->assign_maitri ?? $row->maitri_id;
            $row->save();
            return response()->json(['success' => 'Status updated successfully.']);
        }
        return response()->json(['error' => 'Record not found.'], 404);
    }


    public function exportFarmarList(Request $request){
        $query = User::where('role', 'LIKE', 'Farmer')
                ->join('districts', 'users.district_id', '=', 'districts.id')
                ->orderBy('users.id', 'desc');
               
        if($request->has('dis_id') && !empty($request->input('dis_id'))){
            $districtId = $request->input('dis_id');
            $datas = $query->where('users.district_id', $districtId);
        }

        if ($request->has('mobile') && !empty($request->input('mobile'))) {
            $mobile = $request->input('mobile');
            $datas = $query->where('users.MobileNumber', $mobile);
        }

        $datas    = $query->get();
        // echo '<pre>';print_r($datas);exit;

        $data = $datas->map(function ($item) {
            return [
                'name'                  => $item->name,
                'MobileNumber'            => $item->MobileNumber,
                'district_id'              => $item->name_hindi,
                'tehsil'                => $item->tehsil,
                'block'                 => $item->block,
                'gram_panchayat'        => $item->gram_panchayat,
                'breeds'                 => $item->mobile_no,
                'cattale_no'           => $item->cattale_no,
                'milk_day'              => $item->milk_day,
            ];
        });
        return \Excel::download(new FarmarListExport($data), 'farmar-list.xlsx');
    }

    public function adminStockForm(){
        return view('adminstockform.admin-stock-form');
    }

    public function inactiveMaitriAicenterData(Request $request){
        $districts = Districts::all();
        $tehsilData =[];
        $blockData =[];
        $aiCenterData =[];
        $query = Manganurodhdata::query();
       
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
        
        $manganurodhdata = $query->where('status', 1)->paginate(50)->appends([
            'district_id'   => $request->input('district_id'),
            'tehsil'        => $request->input('tehsil'),
            'block'         => $request->input('block'),
            'aicenter'      => $request->input('aicenter'),
        ]);
        return view('maitriaicenter.inactiveAicenterMaitri', compact('manganurodhdata', 'districts', 'tehsilData', 'blockData', 'aiCenterData'));
    }
    
    public function createMaitriAicenter(){
        $districts = Districts::all();
        $divisions = Divisions::all(); 
        return view('maitriaicenter.createMaitriAicenter', compact('districts', 'divisions'));
    }

    public function createMaitriAicenterData(Request $request){

        $getData = Divisions::where('name_hindi', 'LIKE', '%'.$request->mandal_name.'%')->first();
        $getDis = Districts::where('name_hindi', 'LIKE', '%'.$request->janpad_name.'%')->first();

        $checkData = Manganurodhdata::where('mandal_name', 'LIKE', '%'.$request->mandal_name.'%')
                                    ->where('janpad_name', 'LIKE', '%'.$request->janpad_name.'%')
                                    ->where('center_name', 'LIKE', '%'.$request->center_name.'%')
                                    ->first();
        if($checkData){
            return redirect('view-update-maitri-aicenter')->with('success', 'Record already exists');
        }else{

            $data = Manganurodhdata::create([
                'zone_id'           => $getData->zone_id,
                'division_id'       => $getData->id,
                'district_id'       => $getDis->id,
                'mandal_name'       => $request->mandal_name,
                'janpad_name'       => $request->janpad_name,
                'maitri_name'       => $request->maitri_name,
                'block'             => $request->block,
                'tehsil'            => $request->tehsil,
                'maitri_mobile_no'  => $request->maitri_mobile_no,
                'any_bharat_id'     => $request->bharat_pasudhan_id,
                'center_name'       => $request->center_name,
                'latitude'          => $request->latitude,
                'longitude'         => $request->longitude,
                'status'            => $request->status
            ]);
            if($data){
                return redirect('view-update-maitri-aicenter')->with('success', 'Record Created Successfully');
            }else{
                return redirect('view-update-maitri-aicenter')->with('success', 'Record Not Created');
            }
        }
    }

    public function viewMaitriData(Request $request)
    {
        $districts = Districts::all();
        $tehsilData =[];
        $blockData =[];
        $aiCenterData =[];
        $query = Manganurodhdata::query();
       
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
        
        $manganurodhdata = $query->whereNotNull('maitri_name')->orderByDesc('id')->paginate(50)->appends([
            'district_id' => $request->input('district_id'),
            'tehsil' => $request->input('tehsil'),
            'block' => $request->input('block'),
            'aicenter' => $request->input('aicenter'),
        ]);
        return view('maitriaicenter.index', compact('manganurodhdata', 'districts', 'tehsilData', 'blockData', 'aiCenterData'));
    }
    
    public function generatePDF($id)  {
        $maitriData = Manganurodhdata::where('id', $id)->first();
        $data = [
            'name' => $maitriData['maitri_name'],
        ];
        $html = view('certificate.template', $data)->render();
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream('certificate.pdf', ['Attachment' => true]);
    }

    public function editMaitriAicenter($id){
        $districts = Districts::all();
        $divisions = Divisions::all();
        $editData = Manganurodhdata::find($id);
        return view('maitriaicenter.editData', compact('editData', 'districts', 'divisions'));
    }

    public function updateMaitriData(Request $request){
        $validatedData = $request->validate([
            'maitri_id' => 'required',
        ]);
        $updateGeo = Manganurodhdata::findOrFail($validatedData['maitri_id']);
        $updateGeo->update([
            'mandal_name'       => $request->mandal_name,
            'janpad_name'       => $request->janpad_name,
            'maitri_name'       => $request->maitri_name,
            'block'             => $request->block,
            'tehsil'            => $request->tehsil,
            'maitri_mobile_no'  => $request->maitri_mobile_no,
            'any_bharat_id'     => $request->bharat_pasudhan_id,
            'center_name'       => $request->center_name,
            'latitude'          => $request->latitude,
            'longitude'         => $request->longitude,
            'status'            => $request->status
        ]);
        $redirectUrl = '/view-update-maitri-aicenter?' . http_build_query([
            'district_id' => $request->janpad_name,
            'tehsil'      => $request->tehsil,
            'block'       => $request->block,
            'aicenter'    => $request->center_name,
        ]);
    
        return redirect($redirectUrl)->with('success', 'Data Updated Successfully');
    }

    public function eventAndNews(){
        $events = EventModal::orderBy('id', 'desc')->get();
        return view('adminstockform.eventnews', compact('events'));
    }

    public function destroy($id) {
        $event = EventModal::findOrFail($id);
        $event->delete();
        return redirect()->back()->with('success', 'Event deleted successfully!');
    }

    public function createOrEdit($id = null) {
        $event = $id ? EventModal::findOrFail($id) : null;
        return view('adminstockform.createEventNews', compact('event'));
    }

    public function storeOrUpdate(Request $request, $id = null) {
        $event = $id ? EventModal::findOrFail($id) : new EventModal;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_hindi' => 'required|string|max:255',
            'description' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $directory = 'uploads/events';
        $front_images = $request->file('front_images');
        if($front_images){
            $front_filename = time() . '_' . $front_images->getClientOriginalName();
            $front_images->move(public_path($directory), $front_filename);
            $frontImages = $directory . '/' . $front_filename;
        }else{
            $frontImages = $event['front_image'];
        }
        
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path($directory), $filename);
                $images[] = $directory . '/' . $filename;
            }

            if($event['images']){
                $getImages = $event['images'];
                $OldImages = json_decode($getImages);
                $images = array_merge($OldImages, $images);
            }
        }else{
            $getImages = $event['images'];
            $images = json_decode($getImages);
        }
       
        $event->title = $validated['title'];
        $event->title_hindi = $validated['title_hindi'];
        $event->description = $validated['description'];
        $event->images = json_encode($images);
        $event->front_image = $frontImages;
        $event->save();

        return redirect()->back()->with('success', $id ? 'Event updated successfully!' : 'Event created successfully!');
    }

    public function adminDailyDashboard(){
        $dailyDashboard = DailyDashboard::all();
        return view('adminstockform.admin-daily-dashboard', compact('dailyDashboard'));
    }

    public function saveDaliDashboard(Request $request){
        if ($request->id) {
            // Find the record and update it
            $dashboard = DailyDashboard::find($request->id);
            $dashboard->update($request->all());
            return redirect()->back()->with('success','Daily Dashboard Updated!');
        } else {
            DailyDashboard::create([
                'heading_of_ai'             => $request->heading_of_ai,
                'num_of_ai'                 => $request->num_of_ai,
                'heading_of_pd'             => $request->heading_of_pd,
                'num_of_pd'                 => $request->num_of_pd,
                'heading_of_calving'        => $request->heading_of_calving,
                'num_of_calving'            => $request->num_of_calving,
                'heading_of_insurance'      => $request->heading_of_insurance,
                'number_of_insurance'       => $request->number_of_insurance,
            ]);
            return redirect()->back()->with('success','Daily Dashboard Added!');
        }
    }

    public function adminStockRecord(Request $request){
        $user_id = Auth::user()->id;
        $inventoryIds = InventoryMap::where(['assign_user_id' => $user_id, 'user_id' => $user_id])->get();
        // $adminInventory = RemainingStock::where('user_id', $user_id)->get();

        $adminInventory = [];
        foreach($inventoryIds as $inventoryId){
           $getData = Zonestock::where('id', $inventoryId['inventory_id'])->first();
           $adminInventory[] = $getData;
        }
        return view('adminstockform.admin-stock-record', compact('adminInventory'));
    }


    // public function adminStockRecord(Request $request){
    //     $user = Auth::user();
    //     $allowedRoles = ['Superadmin', 'DFS', 'Zone', 'District', 'DEO'];
    //     $users = User::whereIn('role', $allowedRoles)->pluck('id');

    //     if ($users) {
    //         $inventoryQuery = InventoryMap::whereIn('assign_user_id', $users);
            
    //         if ($request->filled('role')) {
    //             $selectedRoleUsers = User::where('role', $request->role)->pluck('id');
    //             $inventoryQuery->whereIn('assign_user_id', $selectedRoleUsers);
    //         }
    //         $inventoryIds = $inventoryQuery->pluck('inventory_id');
    //     } 

    //     $query = Zonestock::whereIn('id', $inventoryIds);
        
    //     if ($request->filled('bull_id')) {
    //         $query->where('bull_ids', 'LIKE', "%{$request->bull_id}%");
    //     }
    //     if ($request->filled('breed')) {
    //         $query->where('breed', 'LIKE', "%{$request->breed}%");
    //     }
    //     if ($request->filled('semen')) {
    //         $query->where('semen', 'LIKE', "%{$request->semen}%");
    //     }
    //     if ($request->filled('semen_type')) {
    //         $query->where('semen_type', $request->semen_type);
    //     }
    
    //     $adminInventory = $query->get();
        
    //     return view('adminstockform.admin-stock-record', compact('adminInventory'));
    // }
    
    

    public function checkZoneUser(Request $request){
        if($request->user_id != '' && $request->zdd_id != '' && $request->type == 'zone'){
            $zone_id = $request->zdd_id;
            $checkUser = User::where('zone_id', $zone_id)->first();
            if($checkUser == ''){
                return response()->json(['type' => 'zone', 'errormsg' => 'Please Create Zone User ID First']);
            }else{
                return response()->json(['type' => 'zone', 'errormsg' => '']);
            }
        }else if($request->user_id != '' && $request->zdd_id != '' && $request->type == 'district'){
            $user_id = $request->user_id;
            $district_id = $request->zdd_id;
            $checkUser = DeoUser::where(['zone_id' => $user_id, 'district_id' => $district_id ])->first();
            if($checkUser == ''){
                return response()->json(['type' => 'district', 'errormsg' => 'Please Create District User ID First']);
            }else{
                return response()->json(['type' => 'district', 'errormsg' => '']);
            }
        }else if($request->user_id != '' && $request->zdd_id != '' && $request->type == 'ai_center'){
            $user_id = $request->user_id;
            $aiCenter_id = $request->zdd_id;
            $checkUser = DeoUser::where(['zone_id' => $user_id, 'aicenters_id' => $aiCenter_id ])->first();
            if($checkUser == ''){
                return response()->json(['type' => 'aiCenter', 'errormsg' => 'Please Create DEO User ID & Assign AI Center']);
            }else{
                return response()->json(['type' => 'aiCenter', 'errormsg' => '']);
            }
        } 
        
    }

    // public function adminDkistributedRecord(){
    //     $user_id = Auth::user()->id;
    //     $inventoryIds = InventoryMap::where('assign_user_id', $user_id)->get();

    //     $zoneStock = [];
    //     foreach($inventoryIds as $inventory){
    //         $district_User_id = $inventory['user_id'];
    //         $inventory_id = $inventory['inventory_id'];
    //         $results = DB::table('inventory_map_user')
    //                     ->join('zone_stock_details', 'inventory_map_user.inventory_id', '=', 'zone_stock_details.id')
    //                     ->join('deo_users', 'deo_users.id', '=', 'inventory_map_user.deo_id')
    //                     ->join('users', 'users.id', '=', 'inventory_map_user.user_id')
    //                     ->join('zones', 'zones.id', '=', 'inventory_map_user.zone_id')
    //                     ->select('zone_stock_details.*', 'deo_users.*', 'users.*', 'zones.*')
    //                     ->where(['inventory_map_user.user_id' => $district_User_id, 'inventory_map_user.assign_user_id' => $user_id])
    //                     ->get();

    //         $zoneStock[] = $results;
    //     }

        

    //     return view('adminstockform.admin-distributed-record', compact('zoneStock'));
    // }

    public function adminDkistributedRecord(Request $request){
        $user = Auth::user();
        $zones = Zone::all();
        if($user->role == 'DFS'){
            $inventoryIds = InventoryMap::where('assign_user_id', $user->id)->pluck('assign_user_id');
            $query = DB::table('inventory_map_user')
                    ->join('zone_stock_details', 'zone_stock_details.id', '=', 'inventory_map_user.inventory_id')
                    ->join('deo_users', 'deo_users.id', '=', 'inventory_map_user.deo_id')
                    ->join('users', 'users.id', '=', 'inventory_map_user.user_id')
                    ->join('zones', 'zones.id', '=', 'inventory_map_user.zone_id')
                    ->select('zone_stock_details.*', 'deo_users.*', 'users.*', 'zones.*')
                    ->whereIn('inventory_map_user.assign_user_id', $inventoryIds);
        }else{
            $allowedRoles = ['DFS', 'zone', 'district', 'deo'];
            $users = User::whereIn('role', $allowedRoles)->pluck('id');
           
            if ($users) {
                $inventoryQuery = InventoryMap::whereIn('assign_user_id', $users);
                if ($request->filled('role')) {
                    $selectedRoleUsers = User::where('role', $request->role)->pluck('id');
                    $inventoryQuery->whereIn('assign_user_id', $selectedRoleUsers);
                }
                $inventoryIds = $inventoryQuery->pluck('assign_user_id');
            }
            $query = DB::table('inventory_map_user')
                ->leftJoin('zone_stock_details', 'inventory_map_user.inventory_id', '=', 'zone_stock_details.id')
                ->leftJoin('deo_users', 'deo_users.id', '=', 'inventory_map_user.deo_id')
                ->leftJoin('users', 'users.id', '=', 'inventory_map_user.user_id')
                ->leftJoin('zones', 'zones.id', '=', 'inventory_map_user.zone_id')
                ->leftJoin('districts', 'districts.id', '=', 'users.district_id')
                ->leftJoin('aicenter_latest as ai1', 'ai1.id', '=', 'inventory_map_user.user_id')
                ->leftJoin('aicenter_latest', 'aicenter_latest.id', '=', 'inventory_map_user.aicenter_id')
                ->select('aicenter_latest.*','ai1.*','zone_stock_details.*', 'deo_users.*', 'users.*', 'zones.*','districts.*')
                ->whereIn('inventory_map_user.assign_user_id', $inventoryIds);
                
            // $query = DB::table('inventory_map_user')
            //         ->leftJoin('zone_stock_details', 'inventory_map_user.inventory_id', '=', 'zone_stock_details.id')
            //         ->leftJoin('deo_users', 'deo_users.id', '=', 'inventory_map_user.deo_id')
            //         ->leftJoin('aicenter_latest as ai1', 'ai1.id', '=', 'inventory_map_user.user_id') // First aicenter_latest join
            //         ->leftJoin('users', 'users.id', '=', 'inventory_map_user.user_id')
            //         ->leftJoin('zones', 'zones.id', '=', 'inventory_map_user.zone_id')
            //         ->leftJoin('districts', 'districts.id', '=', 'users.district_id')
            //         // ->leftJoin('users as u2', 'u2.district_id', '=', 'ai1.district_id')
            //         ->select( 'zone_stock_details.*', 'deo_users.*', 'users.*', 'zones.*', 'districts.*', 'ai1.*')
            //         ->whereIn('inventory_map_user.assign_user_id', $inventoryIds);

        }
            
        if ($request->filled('zone')) {
            $query->where('inventory_map_user.zone_id', 'LIKE', "%{$request->zone}%");
        }
        if ($request->filled('bull_id')) {
            $query->where('zone_stock_details.bull_ids', 'LIKE', "%{$request->bull_id}%");
        }
        if ($request->filled('breed')) {
            $query->where('zone_stock_details.breed', 'LIKE', "%{$request->breed}%");
        }
        if ($request->filled('semen')) {
            $query->where('zone_stock_details.semen', 'LIKE', "%{$request->semen}%");
        }
        if ($request->filled('semen_type')) {
            $query->where('zone_stock_details.semen_type','LIKE', "%{$request->semen_type}%");
        }
    
        $zoneStock = $query->get();
        // echo '<pre>';print_r($zoneStock);exit;
        return view('adminstockform.admin-distributed-record', compact('zoneStock','zones'));
    }

    public function adminStockDataSave(Request $request){
           
        $breedType = [];
        $semens = $request->semen;
        $breeds = $request->breed;
        if($semens > 0){
            foreach($semens as $key => $semen){
                
                if( $semen == 'catle'){
                    if($breeds[$key] == 'swadeshi'){
                        $breedType = $request->breedType1;
                    }else if($breeds[$key] == 'hybrids-crossbred'){
                        $breedType = $request->breedType2;
                    }else if($breeds[$key] == 'videshi'){
                        $breedType = $request->breedType3;
                    }

                }else if($semen == 'buffalo'){
                    $breedType = $request->breedType4;
                }else if($semen == 'goat'){
                    $breedType = $request->breedType5;
                }
            }
        }

        $inventoryData = [
            'demand_section'        => $request->demand_section,
            'dsf_station'           => $request->dsf_station,
            // 'semen'              => $request->semen,
            // 'breed'              => $request->breed,
            // 'breed_type'         => $breedType,
            // 'semen_straws'        => $request->semen_straws,
            // 'semen_type'         => $request->semen_type,
            // 'bull_ids'           => $bullIds,

            'semen'                 => implode(',', $request->semen),
            'breed'                 => implode(',', $request->breed),
            'breed_type'            => implode(',', $breedType),
            'semen_type'            => implode(',', $request->semen_type),
            'semen_straws'          => implode(',', $request->semen_straws),
            'bull_ids'              => implode(',', $request->bull_id),
            'banner'                => $request->banner,
            'dangler'               => $request->dangler,
            'standee'               => $request->standee,
            'pamphlet'              => $request->pamphlet,
            'ai_kit'                => $request->ai_kit,
            'container_capacity'    => $request->container_capacity,
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
                'dsf_station'        => $request->dsf_station,
                // 'breed'              => $request->breed,
                // 'breed_type'         => $breedType,
                // 'semen'              => $request->semen,
                // 'semen_straws'        => $request->semen_straws,
                // 'semen_type'         => $request->semen_type,
                // 'bull_ids'           => $bullIds,

                'semen'                 => implode(',', $request->semen),
                'breed'                 => implode(',', $request->breed),
                'breed_type'            => implode(',', $breedType),
                'semen_type'            => implode(',', $request->semen_type),
                'semen_straws'          => implode(',', $request->semen_straws),
                'bull_ids'              => implode(',', $request->bull_id),
                'banner'                => $request->banner,
                'dangler'               => $request->dangler,
                'standee'               => $request->standee,
                'pamphlet'              => $request->pamphlet,
                'ai_kit'                => $request->ai_kit,
                'container_capacity'    => $request->container_capacity,
                'container'             => $request->container,
                'scheme'                => $request->scheme,
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