<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Content;
use App\Models\Divisions;
use App\Models\Districts;
use App\Models\Avedan;
use App\Models\Rejectcomment;
use File;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use App\Models\SemanrRquests;
use Carbon\Carbon;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{
		return view('home');
	}

	public function aboutUs()
	{
		return view('aboutUs');
	}

	public function yogyata()
	{
		return view('yogyata');
	}

	public function lakshya()
	{
		$divisions = Divisions::orderBy('name_eng', 'ASC')->get();
		return view('lakshya', compact('divisions'));
	}

	public function yojna()
	{
		$result = Content::find(1);
		return view('contents', compact('result'));
	}

	public function termCondition()
	{
		$result = Content::find(2);
		return view('contents', compact('result'));
	}


	//previous
	// public function avedanKarein()
	// {
	// 	date_default_timezone_set("Asia/Kolkata");
	// 	$result = Setting::find(2);
	// 	$start_date = \Carbon\Carbon::parse($result->start_date)->format('Y-m-d');
	// 	$end_date = \Carbon\Carbon::parse($result->end_date)->format('Y-m-d');
	// 	$current_date = \Carbon\Carbon::parse(now())->format('Y-m-d h:i:s');;
	// 	$expireTime = date('Y-m-d h:i:s', strtotime($end_date . ' + 42 hours'));
	// 	$expireDateTime = strtotime($expireTime);
	// 	$currentDateTime = strtotime($current_date);

	// 	if ($currentDateTime <= $expireDateTime) {
	// 		$avedanStart = 1;
	// 		$messsage =  '';
	// 	} else {

	// 		$avedanStart = 0;
	// 		$result = Setting::find(2);
	// 		$messsage =  'Submition of Application has been expired..';
	// 	}
	// 	return view('avedanLandingPage', compact('result', 'avedanStart', 'messsage'));
	// }

	// new jam
	public function avedanKarein()
	{
		date_default_timezone_set("Asia/Kolkata");
		$result = Setting::find(2);
		$start_date = \Carbon\Carbon::parse($result->start_date, 'Asia/Kolkata')->format('Y-m-d');
		$end_date = \Carbon\Carbon::parse($result->end_date, 'Asia/Kolkata')->format('Y-m-d');
		$current_date = \Carbon\Carbon::parse(now())->format('Y-m-d h:i:s');;
		$expireTime = \Carbon\Carbon::createFromFormat('Y-m-d', $result->end_date, 'Asia/Kolkata')->setTime(23, 59, 59);
		$currentDateTime = \Carbon\Carbon::parse(now('Asia/Kolkata'))->format('Y-m-d h:i:s');

		if ($expireTime->gte($currentDateTime)) {
			$avedanStart = 1;
			$messsage =  '';
		} else {
			$avedanStart = 0;
			$result = Setting::find(2);
			$messsage =  'Submition of Application has been expired..';
		}
		return view('avedanLandingPage', compact('result', 'avedanStart', 'messsage'));
	}

	public function applicationStatus()
	{
		return view('applicationStatus');
	}

	public function viewApplicationStatus(Request $request)
	{



		$rulesList = ["applicationNumber" => "required"];

		if ($request->mobile == '' && $request->dob == '') {
			$rulesList["mobile"] = "required";
		}

		$messages = array(
			'applicationNumber.required' => 'आवेदन संख्या डालिये.',
			'mobile.required' => 'मोबाइल नंबर  या जन्म तिथि डालिये.'
		);


		$validator = Validator::make($request->all(), $rulesList, $messages);
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator->errors());
		}

		$query = Avedan::where('applicationNumber', '=', $request->get('applicationNumber'));

		/**/
		if (!empty($request->input('mobile'))) {
			$query->where(function ($q) use ($request) {

				$q->where('mobile', '=', $request->get('mobile'));
			});
		} else if (!empty($request->input('dob'))) {
			$query->where(function ($q) use ($request) {

				$dob = \Carbon\Carbon::parse($request->get('dob'))->format('Y-m-d');

				$q->where('dob', '=', $dob);
			});
		}

		$result = $query->first();
		//echo '<pre>';print_r($result);exit;

		if (empty($result)) {
			return redirect('/application-status/')->with('success', 'आवेदन संख्या हमारे डेटाबेस में मौजूद नहीं है , कृपया सही आवेदन संख्या डालें |');
		}

		return view('viewApplicationStatus', compact('result'));
	}
	public function downloadFile(Request $request, $fileName)
	{
		$path = public_path() . '/images/' . $fileName;
		return response()->download($path, $fileName);
	}
	public function viewCalculation($id)
	{
		$results = Avedan::where('id', '=', $id)->first();
		//echo '<pre>';print_r($results);exit;
		$view = view("viewCalculation", compact('results'))->render();
		echo $view;
	}

	public function changeStatus($id, $join_status)
	{
		$affected = DB::table('avedans')
			->where('id', $id)
			->update(['join_status' => $join_status]);

		if ($join_status == 1) {

			echo '<a href="javascript:void(0)" onClick="changeStatus(' . $id . ',0);" class="btn btn-success">जॉइन कर लिया</a>';
		} else {

			echo '<a href="javascript:void(0)" onClick="changeStatus(' . $id . ',1);" class="btn btn-danger">जॉइन नहीं किया</a>';
		}
	}

	public function downloads()
	{
		return view('downloads');
	}

	public function addSemanForm(){
        $districts=Divisions::orderBy('name_eng', 'ASC')->get();
		return view('addSemanForm',compact('districts'));
	}

	public function getBlocks(Request $request){
		$data=Districts::where(['division_id'=>$request->distirct_id,'status'=> 1])->orderBy('name_eng', 'ASC')->get()->toArray();
		return \Response::json(['message'=>'Block Data', 'data'=>$data],200);    
	}

	public function submitSemanForm(Request $request){
		$rulesList["former_name"] = "required";
		$rulesList["permanent_address"] = "required";
		$rulesList["distirct_id"] = "required";
		$rulesList["division_id"] = "required";
		$rulesList["pin_code"] = "required";		
		$rulesList["semens_strew"] = "required";
		$rulesList["ln2"] = "required";
		$rulesList["minieral_mixture"] = "required";
		$rulesList["pregnancy_feed"] = "required";
		$rulesList["calf_starter"] = "required";

		$messages = array(
			'former_name.required' => 'पूरा नाम डालिये.',
			'permanent_address.required' => 'स्थायी पता डालिये.',
			'distirct_id.required' => 'जिला का चयन अनिवार्य.',
			'division_id.required' => 'ब्लॉक का चयन अनिवार्य.',
			'pin_code.required' => 'पिन कोड डालिये.',
			'semens_strew.required' => 'वीर्य तिनके डालिये.',
			'ln2.required' => 'एल एन 2 डालिये.',
			'minieral_mixture.required' => 'खनिज मिश्रण डालिये.',
			'pregnancy_feed.required' => 'गर्भावस्था फ़ीड डालिये.',
			'calf_starter.required' => 'बछड़ा स्टार्टर डालिये.'			
		);


		$validator = Validator::make($request->all(), $rulesList, $messages);
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator->errors());
		}

		$semanForm=new SemanrRquests();
		$semanForm->former_name=$request->former_name;
		$semanForm->permanent_address=$request->permanent_address;
		$semanForm->distirct_id=$request->distirct_id;
		$semanForm->division_id=$request->division_id;
		$semanForm->pin_code=$request->pin_code;		
		$semanForm->semens_strew=$request->semens_strew;
		$semanForm->ln2=$request->ln2;
		$semanForm->minieral_mixture=$request->minieral_mixture;
		$semanForm->pregnancy_feed=$request->pregnancy_feed;
		$semanForm->calf_starter=$request->calf_starter;
		$semanForm->save();
		return redirect('/add-seman-form/')->with('success', 'अनुरोध सफलतापूर्वक सबमिट किया गया');
	}

	public function eventDetails(Request $request){
		$data  = '';
		return view('event-details',['data'=>$data]);
	}

	public function uploadScannedFile(Request $request){
		
		$validator = Validator::make($request->all(),[
            'scanned_file'  => "required|max:10000",
         
        ]);
        if($validator->fails()){
            $errors = $validator->errors();
            foreach($errors->all() as $key => $value){
                 return redirect()->back()->with('error',ucfirst($value));
            }
        }else{
			$current_time = \Carbon\Carbon::now()->timestamp;
			$scanned_file =  '';
			$maitri_target_file = '';
			if($request->hasfile('scanned_file')){
				$scanned_file = 'scanned_file'.$current_time.'.'.$request->file('scanned_file')->extension();
				$request->file('scanned_file')->move(public_path('scanned_files'), $scanned_file);
		   	}
			if($request->hasfile('maitri_target_file')){
				$maitri_target_file = 'maitri_target_file'.$current_time.'.'.$request->file('maitri_target_file')->extension();
				$request->file('maitri_target_file')->move(public_path('scanned_files'), $maitri_target_file);
		   	}
		  
            $request  = DB::table('scanned_file')->insert([
                'scanned_file'      => $scanned_file,
				'maitri_target_file'=> $maitri_target_file,
            ]);
            return redirect()->back()->with('success','Scanned pdf submitted successfully!');
        }
	}

	public function shapathPatraList(Request $request){
		$results = DB::table('scanned_file')->paginate(10);
		return view('download-files', compact('results'));
	}

	public function uplaodShapatpatra(Request $request){
		return view('upload-shapatpatra');

	}
}
