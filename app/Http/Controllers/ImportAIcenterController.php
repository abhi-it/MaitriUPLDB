<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CVOOfficers;
use Excel;
use App\Imports\ImportAicenter;
use App\Helpers\TranslateTextHelper;
use App\Exports\CVOListExport;
use App\Models\Maitri;
use App\Models\Districts;
use App\Models\Divisions;
use App\Models\Cliniclocation;
use App\Models\NewAiceter;
use App\Models\Manganurodhdata;
use DB;

class ImportAIcenterController extends Controller{

    public function index(){
        $count=CVOOfficers::count();
        return view('officer.home',compact('count'));
    }

    public function aicenterImportForm() {
        return view('aicenter.import');
    }
    
    function detectLanguage($text) {
        if (preg_match('/[\x{0900}-\x{097F}]/u', $text)) {
            return "Hindi";
        }
    
        if (preg_match('/[a-zA-Z]/', $text)) {
            return "English";
        }
    
        return "Unknown language";
    }

    function engtohindi($val){
        TranslateTextHelper::setSource('en')->setTarget('hi');
        if($val!=null){
            $translatedText = TranslateTextHelper::translate($val);
        }else{
            $translatedText ='';
        }
        return $translatedText; 
    }

    function hinditoenglish($val){
        TranslateTextHelper::setSource('hi')->setTarget('en');
        if($val!=null){
            $translatedText = TranslateTextHelper::translate($val);
        }else{
            $translatedText ='';
        }
        return $translatedText; 
    }


    public function importAiCenter(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        $file = $request->file('file');
        
        Excel::import(new ImportAicenter, $request->file('file')->store('files'));
        return redirect('import-aicenter')->with('success', 'File Imported successfully!');
    }
}