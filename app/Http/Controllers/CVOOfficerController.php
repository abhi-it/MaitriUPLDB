<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CVOOfficers;
use Excel;
use App\Imports\ImportOfficers;
use App\Helpers\TranslateTextHelper;
use App\Exports\CVOListExport;

class CVOOfficerController extends Controller{

    public function index(){
        $count=CVOOfficers::count();
        return view('officer.home',compact('count'));
    }

    public function officerImportForm(){
        return view('officer.import');
    }

    public function importOfficers(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        $file = $request->file('file');
        
        Excel::import(new ImportOfficers, $request->file('file')->store('files'));
        return redirect('officers-import')->with('success', 'File Imported successfully!');
    }
    public function getAllOfficers(Request $request){
        $dist  =  CVOOfficers::all()->unique('mandal_name')->toArray();
        $query = CVOOfficers::orderBy('id', 'DESC');
        if (!empty($request->input('id'))) {
            $query->where(function ($q) use ($request) {

                $q->where('mandal_name', 'like',  $request->input('id'));
            });
        }
        $data = $query->orderBy('id', 'DESC')->paginate(50);
        $items = $data->appends(request()->except('page'));
        
        return view('officer.officers-listing',['data'=>$data,'dist'=>$dist,'items'=>$items]);
    }
    public function exportCVOList(Request $request){
        $query    = CVOOfficers::orderBy('id', 'DESC');
        $id       = $request->dis_id;
        if($request->dis_id){
            $datas     = $query->where('mandal_name', 'like', $id)->get();
        }else{
            $datas    = $query->get();
        }
        $data = $datas->map(function ($item) {
            return [
                'mandal_name' => $item->mandal_name,
                'janpad_name' => $item->janpad_name,
                'login_id' => $item->login_id,
                'officer_name' => $item->officer_name,
                'designation' => $item->designation,
                'animal_care_center' => $item->animal_care_center,
                'mobile_no' => $item->mobile_no,
                'adhar_no' => $item->adhar_no,
                'email' => $item->email,
                'longitute' => $item->longitute,
                'lattitute' => $item->lattitute,
            ];
        });
        return \Excel::download(new CVOListExport($data), 'officer-list.xlsx');

    }
    public function viewOfficersDetails(Request $request){
        $data = CVOOfficers::where(['id'=>$request->id])->first();
        return view('officer.viewOfficerDetails',['data'=>$data]);
    }


}