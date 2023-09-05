<?php
namespace App\Http\Controllers;

use App\Models\Avedan;
use Illuminate\Http\Request;
use File;
use Carbon\Carbon;
use App\Models\Districts;
use App\Models\Avedantemps;
use Illuminate\Support\Facades\DB;
use App\Models\Rejectcomment;
use App\Models\User;
use App\Models\Setting;

class AvedanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		/*-----------Start Check Start Avedan----------------------*/
		
		date_default_timezone_set("Asia/Kolkata");
		$result = Setting::find(2);
		$start_date = \Carbon\Carbon::parse($result->start_date)->format('Y-m-d');
		$end_date = \Carbon\Carbon::parse($result->end_date)->format('Y-m-d');
		$current_date = \Carbon\Carbon::parse(now())->format('Y-m-d h:i:s'); ;
		$expireTime = date('Y-m-d h:i:s', strtotime($end_date. ' + 18 hours')); 
		$expireDateTime = strtotime($expireTime);
		$currentDateTime = strtotime($current_date);
		
        $avedanStart = 1;
		// if($currentDateTime<=$expireDateTime)
		// {
			
		// }else{
			
		// 	return redirect('/avedan-karein');
		// }
		
		/*-----------End Check Start Avedan----------------------*/
		
		
		if(\Session::has('applicationNumber'))
		{
			$applicationNumber = \Session::get('applicationNumber');
			$result = Avedantemps::where('applicationNumber', '=', $applicationNumber)->first();
			//echo '<pre>';print_r($result);exit;
		}else{
			
			$result = new Avedantemps();
		}
		
		if(empty($result))
		{
			$result = new Avedantemps();
		}

		//echo '<pre>';print_r($result);exit;
		
		$setting = Setting::find(1);
		$ageCalcultedFrom = \Carbon\Carbon::parse($setting->start_date)->format('d/m/Y');
		//echo '<pre>';print_r($setting->start_date);exit;
		$districts = Districts::where('status', '=', 1)->orderBy('name_eng', 'ASC')->get();
        return view('avedan', compact('districts', 'result', 'ageCalcultedFrom'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	 
	 public function getTempData(Request $request)
	 {
        /*--- Start Generate Application Number-------------------*/
		$id = Avedan::max('id');
		$autoID = $id + 1;
		$length = 5-strlen($autoID);
		$zeros = '';
		for($i=1; $i<=$length;$i++ )
		{
			$zeros = $zeros . '0';
		}
		$applicationNumber = 'AVN' . $zeros . $autoID . date('dmY');
		//echo $applicationNumber;exit;
		/*--- End Generate Application Number-------------------*/
		 
	   $permanent_address_proof =  '';
	   $training_certificate =  '';
	   $id_upload =  '';
	   $caste_certificate =  '';
	   $applicant_photo =  '';
	   $signature =  '';
	   $high_marksheet =  '';
	   $high_certificate =  '';
	   $inter_marksheet =  '';
	   $inter_certificate =  '';
	   $graduation_marksheet =  '';
	   $graduation_certificate =  '';
	   $postgraduation_marksheet =  '';
	   $postgraduation_certificate =  '';
	   $health_certificate =  '';
        
	   
	   /*--------------------Start Calculation for High School---------------*/
	   $high_percentage = $request->get('high_percentage');
	   $high_school_calculation = round(($high_percentage*5)/10);
	   /*--------------------End Calculation for High School-----------------*/
	   
	   /*--------------------Start Calculation for Inter---------------*/
	   $inter_percentage = $request->get('inter_percentage');
	   $inter_calculation = round(($inter_percentage*3)/10);
	   /*--------------------End Calculation for Inter-----------------*/
	   
	   /*--------------------Start Calculation for certification (Getting month and Days)-------------*/
	   $training_certificate_period_in_month = $request->get('training_certificate_period_in_month');
	   $training_certificate_period_in_days = $request->get('training_certificate_period_in_days');
	   
	   $training_certificate_period_in_month = ($training_certificate_period_in_month)?$training_certificate_period_in_month:0;
	   $training_certificate_period_in_days = ($training_certificate_period_in_days)?$training_certificate_period_in_days:0;
	   
	   $total_number_of_training_days = ($training_certificate_period_in_month*30) + $training_certificate_period_in_days;
	   
	   if($total_number_of_training_days>=1 && $total_number_of_training_days<=30){ //upto 1 month
		   
		   $gettingAnk = 4;
		   
	   } else if($total_number_of_training_days>30 && $total_number_of_training_days<=60){ // 1-2 months
		   
		   $gettingAnk = 8;
		   
	   } else if($total_number_of_training_days>60 && $total_number_of_training_days<=90){ // 2-3 months
		   
		   $gettingAnk = 12;
		   
	   } else if($total_number_of_training_days>90 && $total_number_of_training_days<=120){ // 3-4 months
		   
		   $gettingAnk = 16;
		   
	   } else if($total_number_of_training_days>120){ // more than 4 months
		   
		   $gettingAnk = 20;
		   
	   }else{
		   
		   $gettingAnk = 0;
	   }
	   /*--------------------End Calculation for certification (Getting month and Days)-------------*/
	   
	   
	   /*--------------Getting TOtal Numbers-------------------------*/
	   $topper_number = $high_school_calculation + $inter_calculation + $gettingAnk;
	   
	   if($request->get('dob')!='')
	   {
		$dob = date('Y-m-d', strtotime($request->get('dob')));
	   }else{
		   
		   $dob = date('Y-m-d');
	   }
	   
		Avedantemps::updateOrCreate([
		'applicationNumber'   => $applicationNumber,
		],[
			'applicationNumber' => $applicationNumber,
			't_and_c' => $request->get('tc'),
            'applicant_name' => $request->get('applicant_name'),
            'fname' => $request->get('fname'),
            'mother' => $request->get('mother'),
            'dob' => $dob,
            'mobile' => $request->get('mobile'),
			'gender' => $request->get('gender'),
			'address_type' => $request->get('address_type'),
			'post_office' => $request->get('post_office'),
			'pincode' => $request->get('pincode'),
            'category' => $request->get('category'),
            'permanent_address' => $request->get('permanent_address'),
            'permanent_address_proof' => $permanent_address_proof,
            'gram_panchayat_name' => $request->get('gram_panchayat_name'),
            'vikas_khand' => $request->get('vikas_khand'),
            'district_id' => $request->get('janpad'),
            'letter_address' => $request->get('letter_address'),
            'email' => $request->get('email'),
            'applicant_photo' => $applicant_photo,
            'signature' => $signature,
            'high_board_name' => $request->get('high_board_name'),
            'high_passing_year' => $request->get('high_passing_year'),
            'high_marks' => $request->get('high_marks'),
            'high_total_marks' => $request->get('high_total_marks'),
            'high_percentage' => $request->get('high_percentage'),
            'inter_board_name' => $request->get('inter_board_name'),
            'inter_passing_year' => $request->get('inter_passing_year'),
            'inter_marks' => $request->get('inter_marks'),
            'inter_total_marks' => $request->get('inter_total_marks'),
            'inter_percentage' => $request->get('inter_percentage'),
            'yojna_name_for_training' => $request->get('yojna_name_for_training'),
            'AIkit' => $request->get('AIkit'),
            'declaration' => $request->get('declaration'),
            'training_certificate' => $training_certificate,
            'id_upload' => $id_upload,
            'caste_certificate' => $caste_certificate,
            'nationality' => $request->get('nationality'),
            'high_marksheet' => $high_marksheet,
            'high_certificate' => $high_certificate,
            'inter_marksheet' => $inter_marksheet,
            'inter_certificate' => $inter_certificate,
            'high_school_calculation' => $high_school_calculation,
            'inter_calculation' => $inter_calculation,
            'certificate_calculation' => $gettingAnk,
            'topper_number' => $topper_number,
            'training_certificate_period_in_month' => $training_certificate_period_in_month,
            'training_certificate_period_in_days' => $training_certificate_period_in_days,
            'graduation_board_name' => $request->get('graduation_board_name'),
            'graduation_passing_year' => $request->get('graduation_passing_year'),
            'graduation_marks' => $request->get('graduation_marks'),
            'graduation_total_marks' => $request->get('graduation_total_marks'),
            'graduation_percentage' => $request->get('graduation_percentage'),
            'postgraduation_board_name' => $request->get('postgraduation_board_name'),
            'postgraduation_passing_year' => $request->get('postgraduation_passing_year'),
            'postgraduation_marks' => $request->get('postgraduation_marks'),
            'postgraduation_total_marks' => $request->get('postgraduation_total_marks'),
            'postgraduation_percentage' => $request->get('postgraduation_percentage'),
            'graduation_marksheet' => $graduation_marksheet,
            'graduation_certificate' => $graduation_certificate,
            'postgraduation_marksheet' => $postgraduation_marksheet,
            'postgraduation_certificate' => $postgraduation_certificate,
            'health_certificate' => $health_certificate,
            'training_adopted' => $request->get('training_adopted'),
            
			]);

		
		\Session::put('applicationNumber', $applicationNumber);
		echo $applicationNumber;
        //echo '<pre>';print_r($data);exit;
	 }
	 
    public function store(Request $request)
    {
		
		/*-------Start Validation here----------------------------*/
        
        $request->validate([
            'applicant_name' => 'required',
            'fname' => 'required',
            'mother' => 'required',
            'dob' => 'required',
            'mobile' => 'required',
			'gender' => 'required',
			'address_type' => 'required',
			'post_office' => 'required',
			'pincode' => 'required',
            'category' => 'required',
            'permanent_address' => 'required',
            'permanent_address_proof' => 'mimes:png,jpg,jpeg,PNG,JPG,JPEG|max:100000',
            'gram_panchayat_name' => 'required',
            'vikas_khand' => 'required',
            'janpad' => 'required',
            'letter_address' => 'required',
            //'email' => 'required',
            'applicant_photo' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG|max:20000',
            'signature' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG|max:20000',
            'high_board_name' => 'required',
            'high_passing_year' => 'required',
            'high_marks' => 'required',
            'high_total_marks' => 'required',
            //'high_percentage' => 'required',
            'high_marksheet' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG|max:100000',
            //'high_certificate' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG|max:100000',
            //'inter_board_name' => 'required',
            //'inter_passing_year' => 'required',
            //'inter_marks' => 'required',
            //'inter_total_marks' => 'required',
            //'inter_percentage' => 'required',
            //'inter_marksheet' => 'required',
            //'inter_certificate' => 'required',
            'training_adopted' => 'required',
            //'training_certificate' => 'required',
            //'training_certificate_period_in_month' => 'required',
            //'training_certificate_period_in_days' => 'required',
            //'yojna_name_for_training' => 'required',
            //'AIkit' => 'required',
            //'id_upload' => 'required|mimes:png,jpg,jpeg,PNG,JPG,JPEG|max:100000',
            //'caste_certificate' => 'required',
            //'health_certificate' => 'required',
            'nationality' => 'required',
            'graduation_marksheet' => 'mimes:png,jpg,jpeg,PNG,JPG,JPEG|max:100000',
            'graduation_certificate' => 'mimes:png,jpg,jpeg,PNG,JPG,JPEG|max:100000',
            'postgraduation_marksheet' => 'mimes:png,jpg,jpeg,PNG,JPG,JPEG|max:100000',
            'postgraduation_certificate' => 'mimes:png,jpg,jpeg,PNG,JPG,JPEG|max:100000',

            ], [
                'applicant_name.required' => 'आवेदक का नाम डालिये',
                'fname.required' => 'पिता / पति का नाम डालिये',
                'mother.required' => 'माता का नाम डालिये',
                'gender.required' => 'लिंग सेलेक्ट कीजिए',
                'dob.required' => 'जन्म तिथि डालिये',
                'mobile.required' => 'मोबाइल नंबर डालिये',
                'category.required' => 'श्रेणी सेलेक्ट कीजिए',
                'permanent_address.required' => 'स्थायी पता डालिये',
                'address_type.required' => 'स्थायी पते के प्रमाण-पत्र का प्रकार सेलेक्ट कीजिए',
                'gram_panchayat_name.required' => 'ग्राम पंचायत का नाम डालिये',
                'vikas_khand.required' => 'विकास खण्ड डालिये',
                'janpad.required' => 'जनपद सेलेक्ट कीजिए',
                'letter_address.required' => 'पत्र - व्यवहार का पता डालिये',
                'post_office.required' => 'पोस्ट ऑफिस डालिये',
                'pincode.required' => 'पिनकोड डालिये',
                'applicant_photo.required' => 'आवेदक की फोटो अपलोड कीजिए',
                'signature.required' => 'आवेदक का हस्ताक्षर अपलोड कीजिए',
                'high_board_name.required' => 'बोर्ड का नाम डालिये',
                'high_passing_year.required' => 'उत्तीर्ण वर्ष डालिये',
                'high_marks.required' => 'प्राप्तांक डालिये',
                'high_total_marks.required' => 'पूर्णांक डालिये',
                'high_marksheet.required' => 'हाई स्कूल अंकतालिका अपलोड करें',
                'high_certificate.required' => 'हाई स्कूल प्रमाण-पत्र अपलोड करें',
                'training_adopted.required' => 'यदि पूर्व में प्राइवेट कृत्रिम गर्भाधान कार्यकर्त्ता के सम्बन्ध मै प्रशिक्षण प्राप्त किया है तो योजनान्तर्गत जारी प्रमाण-पत्र चुनें',
                //'id_upload.required' => 'जाति प्रमाण अपलोड कीजिए',
                'nationality.required' => 'राष्ट्रीयता चुनें',
            ]);
        
		/*-------End Validation here----------------------------*/
		
        /*--- Start Generate Application Number-------------------*/
		$id = Avedan::max('id');
		$autoID = $id + 1;
		$length = 5-strlen($autoID);
		$zeros = '';
		for($i=1; $i<=$length;$i++ )
		{
			$zeros = $zeros . '0';
		}
		$applicationNumber = 'AVN' . $zeros . $autoID . date('dmY');
		//echo $applicationNumber;exit;
		/*--- End Generate Application Number-------------------*/
		
		
		$current_time = \Carbon\Carbon::now()->timestamp;
		
		$timeStamp = $autoID . '_' . $current_time;
		
		
		
		
		
		$permanent_address_proof =  '';
        if($request->hasfile('permanent_address_proof'))
         {
			$permanent_address_proof = 'address_proof'.$timeStamp.'.'.$request->file('permanent_address_proof')->extension();
			$request->file('permanent_address_proof')->move(public_path('upload_documents'), $permanent_address_proof);
	   }
	   
	   $training_certificate =  '';
        if($request->hasfile('training_certificate'))
         {
			$training_certificate = 'training_certificate'.$timeStamp.'.'.$request->file('training_certificate')->extension();
			$request->file('training_certificate')->move(public_path('upload_documents'), $training_certificate);
	   }
	   
	   $id_upload =  '';
        if($request->hasfile('id_upload'))
         {
			$id_upload = 'id_upload'.$timeStamp.'.'.$request->file('id_upload')->extension();
			$request->file('id_upload')->move(public_path('upload_documents'), $id_upload);
	   }
	   
	   $caste_certificate =  '';
        if($request->hasfile('caste_certificate'))
         {
			$caste_certificate = 'caste_certificate'.$timeStamp.'.'.$request->file('caste_certificate')->extension();
			$request->file('caste_certificate')->move(public_path('upload_documents'), $caste_certificate);
	   }
	   
	   $applicant_photo =  '';
        if($request->hasfile('applicant_photo'))
         {
			$applicant_photo = 'applicant_photo'.$timeStamp.'.'.$request->file('applicant_photo')->extension();
			$request->file('applicant_photo')->move(public_path('upload_documents'), $applicant_photo);
	   }
	   
	   $signature =  '';
        if($request->hasfile('signature'))
         {
			$signature = 'signature'.$timeStamp.'.'.$request->file('signature')->extension();
			$request->file('signature')->move(public_path('upload_documents'), $signature);
	   }
	   
	   $high_marksheet =  '';
        if($request->hasfile('high_marksheet'))
         {
			$high_marksheet = 'high_marksheet'.$timeStamp.'.'.$request->file('high_marksheet')->extension();
			$request->file('high_marksheet')->move(public_path('upload_documents'), $high_marksheet);
	   }
	   
	   $high_certificate =  '';
        if($request->hasfile('high_certificate'))
         {
			$high_certificate = 'high_certificate'.$timeStamp.'.'.$request->file('high_certificate')->extension();
			$request->file('high_certificate')->move(public_path('upload_documents'), $high_certificate);
	   }
	   
	   $inter_marksheet =  '';
        if($request->hasfile('inter_marksheet'))
         {
			$inter_marksheet = 'inter_marksheet'.$timeStamp.'.'.$request->file('inter_marksheet')->extension();
			$request->file('inter_marksheet')->move(public_path('upload_documents'), $inter_marksheet);
	   }
	   
	   $inter_certificate =  '';
        if($request->hasfile('inter_certificate'))
         {
			$inter_certificate = 'inter_certificate'.$timeStamp.'.'.$request->file('inter_certificate')->extension();
			$request->file('inter_certificate')->move(public_path('upload_documents'), $inter_certificate);
	   }
	   
	   $graduation_marksheet =  '';
        if($request->hasfile('graduation_marksheet'))
         {
			$graduation_marksheet = 'graduation_marksheet'.$timeStamp.'.'.$request->file('graduation_marksheet')->extension();
			$request->file('graduation_marksheet')->move(public_path('upload_documents'), $graduation_marksheet);
	   }
	   
	   $graduation_certificate =  '';
        if($request->hasfile('graduation_certificate'))
         {
			$graduation_certificate = 'graduation_certificate'.$timeStamp.'.'.$request->file('graduation_certificate')->extension();
			$request->file('graduation_certificate')->move(public_path('upload_documents'), $inter_certificate);
	   }
	   
	   
	   $postgraduation_marksheet =  '';
        if($request->hasfile('postgraduation_marksheet'))
         {
			$postgraduation_marksheet = 'postgraduation_marksheet'.$timeStamp.'.'.$request->file('postgraduation_marksheet')->extension();
			$request->file('postgraduation_marksheet')->move(public_path('upload_documents'), $postgraduation_marksheet);
	   }
	   
	   $postgraduation_certificate =  '';
        if($request->hasfile('postgraduation_certificate'))
         {
			$postgraduation_certificate = 'postgraduation_certificate'.$timeStamp.'.'.$request->file('postgraduation_certificate')->extension();
			$request->file('postgraduation_certificate')->move(public_path('upload_documents'), $postgraduation_certificate);
	   }

	   $health_certificate =  '';
        if($request->hasfile('health_certificate'))
         {
			$health_certificate = 'health_certificate'.$timeStamp.'.'.$request->file('health_certificate')->extension();
			$request->file('health_certificate')->move(public_path('upload_documents'), $health_certificate);
	   }
	   
	   /*--------------------Start Calculation for High School---------------*/
	   $high_percentage = $request->get('high_percentage');
	   $high_school_calculation = round(($high_percentage*5)/10);
	   /*--------------------End Calculation for High School-----------------*/
	   
	   /*--------------------Start Calculation for Inter---------------*/
	   $inter_percentage = $request->get('inter_percentage');
	   $inter_calculation = round(($inter_percentage*3)/10);
	   /*--------------------End Calculation for Inter-----------------*/
	   
	   /*--------------------Start Calculation for certification (Getting month and Days)-------------*/
	   $training_certificate_period_in_month = $request->get('training_certificate_period_in_month');
	   $training_certificate_period_in_days = $request->get('training_certificate_period_in_days');
	   
	   $training_certificate_period_in_month = ($training_certificate_period_in_month)?$training_certificate_period_in_month:0;
	   $training_certificate_period_in_days = ($training_certificate_period_in_days)?$training_certificate_period_in_days:0;
	   
	   $total_number_of_training_days = ($training_certificate_period_in_month*30) + $training_certificate_period_in_days;
	   
	   if($total_number_of_training_days>=1 && $total_number_of_training_days<=30){ //upto 1 month
		   
		   $gettingAnk = 4;
		   
	   } else if($total_number_of_training_days>30 && $total_number_of_training_days<=60){ // 1-2 months
		   
		   $gettingAnk = 8;
		   
	   } else if($total_number_of_training_days>60 && $total_number_of_training_days<=90){ // 2-3 months
		   
		   $gettingAnk = 12;
		   
	   } else if($total_number_of_training_days>90 && $total_number_of_training_days<=120){ // 3-4 months
		   
		   $gettingAnk = 16;
		   
	   } else if($total_number_of_training_days>120){ // more than 4 months
		   
		   $gettingAnk = 20;
		   
	   }else{
		   
		   $gettingAnk = 0;
	   }
	   /*--------------------End Calculation for certification (Getting month and Days)-------------*/
	   
	   
	   /*--------------Getting Total Numbers-------------------------*/
	   $topper_number = $high_school_calculation + $inter_calculation + $gettingAnk;
	   
	   
	   /*-------------Start check AI किट--------------*/
        if($request->get('AIkit')=='हाँ')
        {
			$is_approved = 2;
		}else
		{
			$is_approved = 0;
		}
		
		
        /*-------------Start check AI किट--------------*/
		
        $data = new Avedan([
            'applicationNumber' => $applicationNumber,
            'applicant_name' => $request->get('applicant_name'),
            'fname' => $request->get('fname'),
            'mother' => $request->get('mother'),
            'dob' => date('Y-m-d', strtotime($request->get('dob'))),
            'mobile' => $request->get('mobile'),
			'gender' => $request->get('gender'),
			'address_type' => $request->get('address_type'),
			'post_office' => $request->get('post_office'),
			'pincode' => $request->get('pincode'),
            'category' => $request->get('category'),
            'permanent_address' => $request->get('permanent_address'),
            'permanent_address_proof' => $permanent_address_proof,
            'gram_panchayat_name' => $request->get('gram_panchayat_name'),
            'vikas_khand' => $request->get('vikas_khand'),
            'district_id' => $request->get('janpad'),
            'letter_address' => $request->get('letter_address'),
            'email' => $request->get('email'),
            'applicant_photo' => $applicant_photo,
            'signature' => $signature,
            'high_board_name' => $request->get('high_board_name'),
            'high_passing_year' => $request->get('high_passing_year'),
            'high_marks' => $request->get('high_marks'),
            'high_total_marks' => $request->get('high_total_marks'),
            'high_percentage' => $request->get('high_percentage'),
            'inter_board_name' => $request->get('inter_board_name'),
            'inter_passing_year' => $request->get('inter_passing_year'),
            'inter_marks' => $request->get('inter_marks'),
            'inter_total_marks' => $request->get('inter_total_marks'),
            'inter_percentage' => $request->get('inter_percentage'),
            'yojna_name_for_training' => $request->get('yojna_name_for_training'),
            'AIkit' => $request->get('AIkit'),
            'declaration' => $request->get('declaration'),
            'training_certificate' => $training_certificate,
            'id_upload' => $id_upload,
            'caste_certificate' => $caste_certificate,
            'nationality' => $request->get('nationality'),
            'high_marksheet' => $high_marksheet,
            'high_certificate' => $high_certificate,
            'inter_marksheet' => $inter_marksheet,
            'inter_certificate' => $inter_certificate,
            'high_school_calculation' => $high_school_calculation,
            'inter_calculation' => $inter_calculation,
            'certificate_calculation' => $gettingAnk,
            'topper_number' => $topper_number,
            'training_certificate_period_in_month' => $training_certificate_period_in_month,
            'training_certificate_period_in_days' => $training_certificate_period_in_days,
            'graduation_board_name' => $request->get('graduation_board_name'),
            'graduation_passing_year' => $request->get('graduation_passing_year'),
            'graduation_marks' => $request->get('graduation_marks'),
            'graduation_total_marks' => $request->get('graduation_total_marks'),
            'graduation_percentage' => $request->get('graduation_percentage'),
            'postgraduation_board_name' => $request->get('postgraduation_board_name'),
            'postgraduation_passing_year' => $request->get('postgraduation_passing_year'),
            'postgraduation_marks' => $request->get('postgraduation_marks'),
            'postgraduation_total_marks' => $request->get('postgraduation_total_marks'),
            'postgraduation_percentage' => $request->get('postgraduation_percentage'),
            'graduation_marksheet' => $graduation_marksheet,
            'graduation_certificate' => $graduation_certificate,
            'postgraduation_marksheet' => $postgraduation_marksheet,
            'postgraduation_certificate' => $postgraduation_certificate,
            'health_certificate' => $health_certificate,
            'is_approved' => $is_approved,
            'training_adopted' => $request->get('training_adopted'),
        ]);
        $data->save();
        
        //echo '<pre>';print_r($data);exit;
        
        /*-------------Start check AI किट Yes then application will be rejected--------------*/
        
        if($request->get('AIkit')=='हाँ')
        {
			$user = User::where('district_id', '=', $request->get('janpad'))->first();
			$comments = new Rejectcomment([
				'application_id' => $data->id,
				'comments' => 'प्रशिक्षणोपरांत ए. आई.  किट तथा  बायोलोजिकल कन्टेनर प्राप्त किये गये है, अतः आपका आवेदन निरस्त कर दिया गया है |',
				'user_id' => $user->id,
			]);
			$comments->save();
		}
        /*-------------End check AI किट Yes then application will be rejected--------------*/
        
        \Session::put('districtID', $request->get('janpad'));
        $heading = 'आवेदन पंजीकरण की पुष्टि';
        $confirmationMesage1 = 'आपका आवेदन पंजीकरण सफलतापूर्वक सुरक्षित कर लिया गया है।';
        $confirmationMesage2 = 'आपकी आवेदन संख्या <span class="med_appli_num font-weight-bold text-success" style="color:green;">'.$applicationNumber.'</span> है, भविष्य के संदर्भों के लिए इस आवेदन संख्या का उपयोग करें।';
        \Session::put('heading', $heading);
        \Session::put('confirmationMesage1', $confirmationMesage1);
        \Session::put('confirmationMesage2', $confirmationMesage2);
		
		$applicationNumberTemp = \Session::get('applicationNumber');
		\Session::put('application_id', $data->id);
		DB::table('avedantemps')
		->where('applicationNumber', $applicationNumberTemp)
		->delete();
		\Session::put('applicationNumber', '');
		return redirect('/success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Avedan  $avedan
     * @return \Illuminate\Http\Response
     */
    public function show(Avedan $avedan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Avedan  $avedan
     * @return \Illuminate\Http\Response
     */
    public function edit(Avedan $avedan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Avedan  $avedan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Avedan $avedan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Avedan  $avedan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Avedan $avedan)
    {
        //
    }
}
