<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CVOOfficers;
use Excel;
use App\Imports\ImportAicenter;
use App\Helpers\TranslateTextHelper;
use App\Exports\CVOListExport;

class ImportAIcenterController extends Controller{

    public function index(){
        $count=CVOOfficers::count();
        return view('officer.home',compact('count'));
    }

    public function aicenterImportForm(){
        return view('aicenter.import');
    }

    public function importAiCenter(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        $file = $request->file('file');
        
        Excel::import(new ImportAicenter, $request->file('file')->store('files'));
        return redirect('officers-import')->with('success', 'File Imported successfully!');
    }
}