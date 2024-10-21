<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Avedan;
use App\Models\Rejectcomment;
use App\Models\Verificationcomment;
use App\Models\Districts;
use App\Models\Institute;
use App\Models\User;
use App\Exports\AvedanExport;
use App\Exports\ExportAvedan;
use App\Models\MaitriDistrictLatLong;
use App\Models\MaitriDistrictsLatLong;
use App\Models\MaitriPortal;
use App\Models\UpLdbCenter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Banks;
use App\Models\MaitriSessionRecord;

class DashboardController extends Controller
{
    public $sessionYear;
    public function __construct(Request $request)
    {
        ini_set('memory_limit', '1G');
        $this->middleware('auth');

        $rules = [
            'year' => 'nullable|numeric|digits:4',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Validation failed, handle the error (e.g., return an error response)
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $this->sessionYear =  optional(\App\Models\Avedan::latest()->first())->created_at->format('Y');
        // if($request->year){
        //     dd("Hello");
        // }
    }

    public function export()
    {
        return \Excel::download(new AvedanExport, 'avedansNafees.xlsx');
    }

    public function index(Request $request, $year = null)
    {
        $this->sessionYear = $year ? $year : $this->sessionYear;
        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;

        if ($user_type == 'Director' or $user_type == 'Admin') { //Director OR SuperAdmin


            if ($this->sessionYear == date('Y')) {
                $newApplication = Avedan::where('is_approved', '=', 0)->whereYear('created_at', $this->sessionYear)->count();
            } else {
                $newApplication = Avedan::where('is_approved', '=', 0)->whereYear('created_at', $this->sessionYear)->count();
            }

            $approvedApplication = Avedan::where('is_approved', '=', 1)->whereYear('created_at', $this->sessionYear)->count();
            $rejectedApplication = Avedan::where('is_approved', '=', 2)->whereYear('created_at', $this->sessionYear)->count();
            $waitingList = Avedan::where('is_approved', '=', 3)->whereYear('created_at', $this->sessionYear)->count();
            $generalList = Avedan::whereIn('category', ["जनरल", "ओ बी सी"])->where('is_approved', '=', 4)->whereYear('created_at', $this->sessionYear)->count();
            $SClist = Avedan::whereIn('category', ["एस सी"])->where('is_approved', '=', 4)->whereYear('created_at', $this->sessionYear)->count();
            $STlist = Avedan::whereIn('category', ["एस टी"])->where('is_approved', '=', 4)->whereYear('created_at', $this->sessionYear)->count();
            // dd($STlist);
        } else if ($user_type == 'User') { //User

            $results = Avedan::orderBy('id', 'DESC')->whereYear('created_at', $this->sessionYear)->get();
        } else { //CVO login:: get all records against district

            $newApplication = Avedan::where('is_approved', '=', 0)->where('district_id', '=', $districtID)->whereYear('created_at', $this->sessionYear)->count();
            $approvedApplication = Avedan::where('is_approved', '=', 1)->where('district_id', '=', $districtID)->whereYear('created_at', $this->sessionYear)->count();
            $rejectedApplication = Avedan::where('is_approved', '=', 2)->where('district_id', '=', $districtID)->whereYear('created_at', $this->sessionYear)->count();
            $waitingList = Avedan::where('is_approved', '=', 3)->where('district_id', '=', $districtID)->whereYear('created_at', $this->sessionYear)->count();
            $generalList = Avedan::whereIn('category', ["जनरल", "ओ बी सी"])->where('is_approved', '=', 4)->where('district_id', '=', $districtID)->whereYear('created_at', $this->sessionYear)->count();
            $SClist = Avedan::whereIn('category', ["एस सी"])->where('is_approved', '=', 4)->where('district_id', '=', $districtID)->whereYear('created_at', $this->sessionYear)->count();
            $STlist = Avedan::whereIn('category', ["एस टी"])->where('is_approved', '=', 4)->where('district_id', '=', $districtID)->whereYear('created_at', $this->sessionYear)->count();
        }

        //echo '<pre>';print_r($newApplication);exit;


        if (auth()->user()->user_type == 'User') { //User

            $template = 'user.dashboard';
        } else {

            $template = 'dashboard';
        }
        /*----------------Start for Institute User dashboard data-----------------------------*/

        if (count($_GET) >= 1) {
            $query = Avedan::join('allocations', 'allocations.application_id', '=', 'avedans.id');

            if ($request->input('category') != '') {
                $query->where(function ($q) use ($request) {
                    $q->where('allocations.category', '=', $request->input('category'));
                });
            }

            if ($request->input('join_status') != '') {
                $query->where(function ($q) use ($request) {
                    $q->where('avedans.join_status', '=', $request->input('join_status'));
                });
            }

            $results = $query->get(['avedans.*', 'allocations.application_id']);
        } else {

            $results = Avedan::join('allocations', 'allocations.application_id', '=', 'avedans.id')
                ->where('allocations.institute_user_id', '=', $user->id)
                ->get(['avedans.*', 'allocations.application_id']);
        }

        // $maitriDistricts = MaitriDistrictLatLong::with('maitriPortal')->get();
        // $upldbCenters = UpLdbCenter::all();

        $sessionYear = $this->sessionYear; 
        if (!$sessionYear || !is_numeric($sessionYear)) {
            throw new \Exception('Session year is not set or invalid');
        }

        $avedanYears = Avedan::selectRaw('YEAR(created_at) as year')
                ->distinct()
                // ->whereRaw('YEAR(created_at) != ?', [$sessionYear])
                ->pluck('year')
                ->toArray();

        $sessionYear = $this->sessionYear;
        $setting = DB::table('settings')->get();
        $lastDate = $setting[1]->end_date;
        $totalsession = MaitriSessionRecord::count();


        // $approvedApplication = 0;
        // $rejectedApplication = 0;
        // $generalList = 0;
        // $SClist = 0;
        // $STlist = 0;
        // $waitingList = 0;


        /*----------------End for Institute User dashboard data-----------------------------*/

        return view($template, compact('results', 'newApplication', 'approvedApplication', 'rejectedApplication', 'generalList', 'SClist', 'STlist', 'waitingList', 'avedanYears', 'sessionYear', 'lastDate','totalsession'));
    }


    public function allocationListForInstitute()
    {

        $districts = Districts::where('status', '=', 1)->orderBy('name_eng', 'ASC')->get();
        $institute = Institute::orderBy('id', 'desc')->get();
        $results = array();

        if (count($_GET) >= 1) {

            $results = Avedan::join('allocations', 'allocations.application_id', '=', 'avedans.id')
                ->where('allocations.district_id', '=', @$_GET['district_id'])
                ->where('allocations.category', '=', @$_GET['category'])
                ->where('allocations.institute_id', '=', @$_GET['institute_id'])
                ->whereYear('created_at', $this->sessionYear)
                ->get(['avedans.*', 'allocations.application_id']);
        }

        //echo '<pre>';print_r($results);exit;


        return view('institute.allocationList', compact('districts', 'institute', 'results'));
    }


    /*-----Start Display only New Applications--------------*/
    public function avedan(Request $request, $year = null, $export = null)
    {
        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;
        //echo '<pre>';print_r($user);exit;

        if ($user_type == 'Director') { //Director
            $query = Avedan::where('is_approved', '=', 0)->with('district')->orderBy('id', 'DESC');
        } else if ($user_type == 'Admin') { //Super Admin
            $query = Avedan::where('is_approved', '=', 0)->with('district')->orderBy('id', 'DESC');
        } else { //CVO
            $query = Avedan::where('is_approved', '=', 0)->with('district')->where('district_id', '=', $districtID)->orderBy('id', 'DESC');
        }


        if (!empty($request->input('applicationNumber'))) {
            $query->where(function ($q) use ($request) {

                $q->where('applicationNumber', '=', $request->input('applicationNumber'));
            });
        }

        if (!empty($request->input('mobile'))) {
            $query->where(function ($q) use ($request) {

                $q->where('mobile', '=', $request->input('mobile'));
            });
        }
        if (!empty($request->input('district_id'))) {
            $query->where(function ($q) use ($request) {

                $q->where('district_id', '=', $request->input('district_id'));
            });
        }

        $districts = Districts::where('status', '=', 1)->orderBy('name_eng', 'ASC')->get();

        $heading = 'नये आवेदन मैत्री';
        $statusButtonApprovedRejectedShow = 0;

        if ($export !== null) {
            $datas = $query->whereYear('created_at', $this->sessionYear)->with('district')->get();

            $data = $datas->map(function ($item) {
                $high_percentage = $item->high_percentage;
                $high_school_calculation = round(($high_percentage*8)/10);
                $inter_percentage = $item->inter_percentage;
                $inter_calculation = round(($inter_percentage*2)/10);
                $topper_number = $high_school_calculation + $inter_calculation;
                return [
                    'applicationNumber' => $item->applicationNumber,
                    'applicant_name' => $item->applicant_name,
                    'fname' => $item->fname,
                    'mother' => $item->mother,
                    'gender' => $item->gender,
                    'mobile' => $item->mobile,
                    'email' => $item->email,
                    'category' => $item->category,
                    'districts' => $item->district->name_hindi,
                    'tehsil' => $item->tehsil,
                    'post_office' => $item->post_office,
                    'gram_panchayat_name' => $item->gram_panchayat_name,
                    'vikas_khand' => $item->vikas_khand,
                    'letter_address' => $item->letter_address,
                    'high_marks' => $item->high_marks,
                    'high_total_marks' => $item->high_total_marks,
                    'high_percentage' => $item->high_percentage,
                    'inter_marks' => $item->inter_marks,
                    'inter_total_marks' => $item->inter_total_marks,
                    'inter_percentage' => $item->inter_percentage,
                    'topper_number' => $topper_number,
                ];
            });
            // $data = $query->select('applicationNumber', 'applicant_name', 'fname', 'mother', 'gender', 'mobile', 'email', 'category','tehsil','post_office','gram_panchayat_name','vikas_khand','letter_address','high_marks','high_total_marks','high_percentage', 'inter_marks','inter_total_marks', 'inter_percentage','topper_number')->whereYear('created_at', $this->sessionYear)->get();

            return \Excel::download(new ExportAvedan($data), 'avedan.xlsx');
        } else {
            $results = $query->whereYear('created_at', $this->sessionYear)->paginate(50);
            return view('viewAvedan', compact('results', 'heading', 'statusButtonApprovedRejectedShow', 'districts'))->with('route', 'avedan')->with('year', $this->sessionYear);
        }
    }
    /*-----End Display only New Applications--------------*/



    /*-----Start Display only New Applications DistrictWise for Director--------------*/
    public function avedanDistrictwise(Request $request, $year = null)
    {
        $this->sessionYear = $year ? $year : $this->sessionYear;
        $filter = [];


        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;
        //echo '<pre>';print_r($user);exit;

        if ($user_type == 'Director') { //Director Only til now

            if (($this->sessionYear == date('Y'))) {
                $query = Avedan::query();
            } else {

                $query = Avedan::where('is_approved', '=', 0);
            }
        } else { //CVO
            $results = array();
        }

        $heading = 'नये आवेदन मैत्री जनपद वार ';
        $statusButtonApprovedRejectedShow = 0;


        if (!empty($request->input('vikas_khand'))) {
            $filter['vikas_khand'] = $request->input('vikas_khand');
            $query->where(function ($q) use ($request) {
                $q->where('vikas_khand', '=', $request->input('vikas_khand'));
            });
        }

        if (!empty($request->input('district_id'))) {
            $filter['district_id'] = $request->input('district_id');
            $query->where(function ($q) use ($request) {

                $q->where('district_id', '=', $request->input('district_id'));
            });
        }

        if (!empty($request->input('category'))) {
            $filter['category'] = $request->input('category');
            $query->where(function ($q) use ($request) {

                $q->where('category', '=', $request->input('category'));
            });
        }



        //echo '<pre>';print_r($results);exit;

        $districts = Districts::where('status', '=', 1)->orderBy('name_eng', 'ASC')->get();
        $sessionYear = $this->sessionYear;
        if (!empty($request->input('export'))) {
            $datas = $query->with('district')->whereYear('avedans.created_at', $this->sessionYear)
                    ->orderBy('avedans.category', 'DESC')
                    ->get();

            $data = $datas->map(function ($item) {
                $high_percentage    = $item->high_percentage;
                $high_school_calculation = round(($high_percentage*8)/10);
                $inter_percentage   = $item->inter_percentage;
                $inter_calculation  = round(($inter_percentage*2)/10);
                $topper_number      = $high_school_calculation + $inter_calculation;
                return [
                    'applicationNumber' => $item->applicationNumber,
                    'applicant_name' => $item->applicant_name,
                    'fname' => $item->fname,
                    'mother' => $item->mother,
                    'gender' => $item->gender,
                    'mobile' => $item->mobile,
                    'email' => $item->email,
                    'category' => $item->category,
                    'districts' => $item->district->name_hindi,
                    'tehsil' => $item->tehsil,
                    'post_office' => $item->post_office,
                    'gram_panchayat_name' => $item->gram_panchayat_name,
                    'vikas_khand' => $item->vikas_khand,
                    'letter_address' => $item->letter_address,
                    'high_marks' => $item->high_marks,
                    'high_total_marks' => $item->high_total_marks,
                    'high_percentage' => $item->high_percentage,
                    'inter_marks' => $item->inter_marks,
                    'inter_total_marks' => $item->inter_total_marks,
                    'inter_percentage' => $item->inter_percentage,
                    'topper_number' => $topper_number,
                ];
            });
             
            return \Excel::download(new ExportAvedan($data), 'districtwise-avedan.xlsx');
        } else {
            $results = $query->whereYear('created_at', $this->sessionYear)->orderBy('category', 'DESC')->paginate(50);
            //echo '<pre>';print_r($results);exit;
            return view('viewAvedanDistrictwise', compact('results', 'heading', 'statusButtonApprovedRejectedShow', 'districts',  'sessionYear', 'filter'))->with('year', $this->sessionYear);
        }
    }
    /*-----End Display only New Applications--------------*/



    /*-----Start Display only for Director and Super Admin--------------*/

    public function totalAvedan(Request $request, $year = null, $export = null)
    {
        $query = Avedan::orderBy('id', 'DESC');

        if (!empty($request->input('applicationNumber'))) {
            $query->where(function ($q) use ($request) {

                $q->where('applicationNumber', '=', $request->input('applicationNumber'));
            });
        }

        if (!empty($request->input('mobile'))) {
            $query->where(function ($q) use ($request) {

                $q->where('mobile', '=', $request->input('mobile'));
            });
        }
        if (!empty($request->input('district_id'))) {
            $query->where(function ($q) use ($request) {

                $q->where('district_id', '=', $request->input('district_id'));
            });
        }

        $districts = Districts::where('status', '=', 1)->orderBy('name_eng', 'ASC')->get();

        $heading = 'कुल आवेदन';
        $statusButtonApprovedRejectedShow = 0;

        if ($export !== null) {
            $datas = $query->with('district')->whereYear('created_at', $this->sessionYear)->get();
            $data = $datas->map(function ($item) {
                $high_percentage    = $item->high_percentage;
                $high_school_calculation = round(($high_percentage*8)/10);
                $inter_percentage   = $item->inter_percentage;
                $inter_calculation  = round(($inter_percentage*2)/10);
                $topper_number      = $high_school_calculation + $inter_calculation;
                return [
                    'applicationNumber' => $item->applicationNumber,
                    'applicant_name' => $item->applicant_name,
                    'fname' => $item->fname,
                    'mother' => $item->mother,
                    'gender' => $item->gender,
                    'mobile' => $item->mobile,
                    'email' => $item->email,
                    'category' => $item->category,
                    'districts' => $item->district->name_hindi,
                    'tehsil' => $item->tehsil,
                    'post_office' => $item->post_office,
                    'gram_panchayat_name' => $item->gram_panchayat_name,
                    'vikas_khand' => $item->vikas_khand,
                    'letter_address' => $item->letter_address,
                    'high_marks' => $item->high_marks,
                    'high_total_marks' => $item->high_total_marks,
                    'high_percentage' => $item->high_percentage,
                    'inter_marks' => $item->inter_marks,
                    'inter_total_marks' => $item->inter_total_marks,
                    'inter_percentage' => $item->inter_percentage,
                    'topper_number' => $topper_number,
                ];
            });

            return \Excel::download(new ExportAvedan($data), 'total-avedan.xlsx');
        } else {
            $results = $query->whereYear('created_at', $this->sessionYear)->paginate(50);
            return view('viewAvedan', compact('results', 'heading', 'statusButtonApprovedRejectedShow', 'districts'))->with('route', 'totalAvedan')->with('year', $this->sessionYear);
        }
    }
    /*-----End Display only for Director and Super Admin--------------*/

    public function meritList(Request $request, $category, $export = null)
    {


        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;

        if ($category == 1) {
            //die('2222222222222');
            $heading = 'सामान्य वर्ग मेरिट सूची (स्क्रीनिंग)';
            $query = Avedan::where('is_approved', '=', 0)
                ->whereIn('category', ["जनरल"])
                ->where('district_id', '=', $districtID);
        } else if ($category == 2) {
            //die('2222222222222');
            $heading = 'अन्य पिछड़ा वर्ग मेरिट सूची (स्क्रीनिंग)';
            $query = Avedan::where('is_approved', '=', 0)
                ->whereIn('category', [ "ओ बी सी"])
                ->where('district_id', '=', $districtID);
        }   else if ($category == 3) {

            $heading = 'अनुसूचित जाति मेरिट सूची (स्क्रीनिंग)';
            $query = Avedan::where('is_approved', '=', 0)
                ->whereIn('category', ["एस सी"])
                ->where('district_id', '=', $districtID);
        } else {

            $heading = 'अनुसूचित जनजाति मेरिट सूची (स्क्रीनिंग)';
            $query = Avedan::where('is_approved', '=', 0)
                ->whereIn('category', ["एस टी"])
                ->where('district_id', '=', $districtID);
        }

        if (!empty($request->input('applicationNumber'))) {
            $query->where(function ($q) use ($request) {

                $q->where('applicationNumber', '=', $request->input('applicationNumber'));
            });
        }

        if (!empty($request->input('mobile'))) {
            $query->where(function ($q) use ($request) {

                $q->where('mobile', '=', $request->input('mobile'));
            });
        }




        $statusButtonApprovedRejectedShow = 1;

        if ($export !== null) {
            $datas = $query->whereYear('created_at', $this->sessionYear)->orderBy('topper_number', 'DESC')->get();
            $data = $datas->map(function ($item) {
                $high_percentage    = $item->high_percentage;
                $high_school_calculation = round(($high_percentage*8)/10);
                $inter_percentage   = $item->inter_percentage;
                $inter_calculation  = round(($inter_percentage*2)/10);
                $topper_number      = $high_school_calculation + $inter_calculation;

                return [
                    'applicationNumber' => $item->applicationNumber,
                    'applicant_name' => $item->applicant_name,
                    'fname' => $item->fname,
                    'mother' => $item->mother,
                    'gender' => $item->gender,
                    'mobile' => $item->mobile,
                    'email' => $item->email,
                    'category' => $item->category,
                    'districts' => $item->district->name_hindi,
                    'tehsil' => $item->tehsil,
                    'post_office' => $item->post_office,
                    'gram_panchayat_name' => $item->gram_panchayat_name,
                    'vikas_khand' => $item->vikas_khand,
                    'letter_address' => $item->letter_address,
                    'high_marks' => $item->high_marks,
                    'high_total_marks' => $item->high_total_marks,
                    'high_percentage' => $item->high_percentage,
                    'inter_marks' => $item->inter_marks,
                    'inter_total_marks' => $item->inter_total_marks,
                    'inter_percentage' => $item->inter_percentage,
                    'topper_number' => $topper_number,
                ];
            });
            return \Excel::download(new ExportAvedan($data), 'merit-list.xlsx');
        } else {
            $results = $query->whereYear('created_at', $this->sessionYear)->orderBy('topper_number', 'DESC')->paginate(50);
            return view('viewAvedanMeritList', compact('results', 'heading', 'statusButtonApprovedRejectedShow'))->with('exportCategory', $category);
        }
    }


    public function approvedAvedan(Request $request, $year = null)
    {
        $this->sessionYear = $year ? $year : $this->sessionYear;
        $filter = [];
        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;


        if ($user_type == 'Director') { //Director

            $query = Avedan::where('is_approved', '=', 1);
        } else if ($user_type == 'Admin') { //Super Admin

            $query = Avedan::where('is_approved', '=', 1);
        } else { //CVO

            $query = Avedan::where('is_approved', '=', 1)->where('district_id', '=', $districtID);
        }


        if (!empty($request->input('applicationNumber'))) {
            $query->where(function ($q) use ($request) {

                $q->where('applicationNumber', '=', $request->input('applicationNumber'));
            });
        }

        if (!empty($request->input('mobile'))) {
            $query->where(function ($q) use ($request) {

                $q->where('mobile', '=', $request->input('mobile'));
            });
        }

        if (!empty($request->input('district_id'))) {
            $query->where(function ($q) use ($request) {

                $q->where('district_id', '=', $request->input('district_id'));
            });
        }

        $districts = Districts::where('status', '=', 1)->orderBy('name_eng', 'ASC')->get();


        $heading = 'स्वीकार आवेदन';

        if (!empty($request->input('export'))) {
           
            $datas = $query->with('district')->join('districts', 'avedans.district_id', '=', 'districts.id') // Perform the join
                ->whereYear('avedans.created_at', $this->sessionYear)
                ->orderBy('avedans.category', 'DESC')
                ->get();

            $data = $datas->map(function ($item) {
                $high_percentage    = $item->high_percentage;
                $high_school_calculation = round(($high_percentage*8)/10);
                $inter_percentage   = $item->inter_percentage;
                $inter_calculation  = round(($inter_percentage*2)/10);
                $topper_number      = $high_school_calculation + $inter_calculation;

                return [
                    'applicationNumber' => $item->applicationNumber,
                    'applicant_name' => $item->applicant_name,
                    'fname' => $item->fname,
                    'mother' => $item->mother,
                    'gender' => $item->gender,
                    'mobile' => $item->mobile,
                    'email' => $item->email,
                    'category' => $item->category,
                    'districts' => $item->district->name_hindi,
                    'tehsil' => $item->tehsil,
                    'post_office' => $item->post_office,
                    'gram_panchayat_name' => $item->gram_panchayat_name,
                    'vikas_khand' => $item->vikas_khand,
                    'letter_address' => $item->letter_address,
                    'high_marks' => $item->high_marks,
                    'high_total_marks' => $item->high_total_marks,
                    'high_percentage' => $item->high_percentage,
                    'inter_marks' => $item->inter_marks,
                    'inter_total_marks' => $item->inter_total_marks,
                    'inter_percentage' => $item->inter_percentage,
                    'topper_number' => $topper_number,
                ];
            });

            return \Excel::download(new ExportAvedan($data), 'approved-avedan.xlsx');
        } else {
            $results = $query->whereYear('created_at', $this->sessionYear)->orderBy('id', 'DESC')->paginate(50);
            //echo '<pre>';print_r($results);exit;
            return view('viewAvedan', compact('results', 'heading', 'districts'))->with('route', 'approvedAvedan')->with('year', $this->sessionYear);
        }
    }

    public function rejectedAvedan(Request $request, $year = null)
    {

        $this->sessionYear = $year ? $year : $this->sessionYear;
        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;
        //echo '<pre>';print_r($user);exit;

        if ($user_type == 'Director') { //Director

            $query = Avedan::where('is_approved', '=', 2)->orderBy('id', 'DESC');
        } else if ($user_type == 'Admin') { //Super Admin

            $query = Avedan::where('is_approved', '=', 2)->orderBy('id', 'DESC');
        } else { //CVO

            $query = Avedan::where('is_approved', '=', 2)->where('district_id', '=', $districtID)->orderBy('id', 'DESC');
        }

        if (!empty($request->input('applicationNumber'))) {
            $query->where(function ($q) use ($request) {

                $q->where('applicationNumber', '=', $request->input('applicationNumber'));
            });
        }

        if (!empty($request->input('mobile'))) {
            $query->where(function ($q) use ($request) {

                $q->where('mobile', '=', $request->input('mobile'));
            });
        }


        $heading = 'अस्वीकार आवेदन';

        if (!empty($request->input('export'))) {
            $data = $query->select('applicationNumber', 'applicant_name', 'fname', 'mother', 'gender', 'mobile', 'email', 'high_percentage', 'inter_percentage', 'category', 'letter_address')->whereYear('created_at', $this->sessionYear)->get();
            return \Excel::download(new ExportAvedan($data), 'rejected-avedan.xlsx');
        } else {
            $results = $query->whereYear('created_at', $this->sessionYear)->paginate(50);
            return view('viewRejectedAvedan', compact('results', 'heading'))->with('year', $this->sessionYear);
        }
    }

    public function allList(Request $request, $year = null) // General + OBC +SC_ST List will display here for status 4 (FInal Selected list after documents verify)
    {

        $this->sessionYear = $year ? $year : $this->sessionYear;
        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;


        $query = Avedan::orderBy('id', 'DESC');
        if (!empty($request->input('search'))) {
            $query->where(function ($q) use ($request) {

                $q->where('applicationNumber', '=', $request->input('search'));
            });
        }

        if ($user_type == 'Director') { //Director

            $query = Avedan::where('is_approved', '=', 4)
                // ->whereIn('category', ["जनरल", "ओ बी सी"])
                ->orderBy('topper_number', 'DESC');
        } else if ($user_type == 'Admin') { //Super Admin

            $query = Avedan::where('is_approved', '=', 4)
                // ->whereIn('category', ["जनरल", "ओ बी सी"])
                ->orderBy('topper_number', 'DESC');
        } else { //CVO

            $query = Avedan::where('is_approved', '=', 4)
                // ->whereIn('category', ["जनरल", "ओ बी सी"])
                ->where('district_id', '=', $districtID)
                ->orderBy('topper_number', 'DESC');
        }

        if (!empty($request->input('applicationNumber'))) {
            $query->where(function ($q) use ($request) {

                $q->where('applicationNumber', '=', $request->input('applicationNumber'));
            });
        }

        if (!empty($request->input('mobile'))) {
            $query->where(function ($q) use ($request) {

                $q->where('mobile', '=', $request->input('mobile'));
            });
        }

        if (!empty($request->input('district_id'))) {
            $query->where(function ($q) use ($request) {

                $q->where('district_id', '=', $request->input('district_id'));
            });
        }

        $districts = Districts::where('status', '=', 1)->orderBy('name_eng', 'ASC')->get();


        $heading = 'सभी वर्गो के चयनित अभ्यर्थियों की सूची';

        if (!empty($request->input('export'))) {
            // $data = $query->select('applicationNumber', 'applicant_name', 'fname', 'mother', 'gender', 'mobile', 'email', 'high_percentage', 'inter_percentage', 'category', 'letter_address')->whereYear('created_at', $this->sessionYear)->get();
            $datas = $query->with('district')->join('districts', 'avedans.district_id', '=', 'districts.id') // Perform the join
                ->whereYear('avedans.created_at', $this->sessionYear)
                ->orderBy('avedans.category', 'DESC')
                ->get();

            $data = $datas->map(function ($item) {
                $high_percentage    = $item->high_percentage;
                $high_school_calculation = round(($high_percentage*8)/10);
                $inter_percentage   = $item->inter_percentage;
                $inter_calculation  = round(($inter_percentage*2)/10);
                $topper_number      = $high_school_calculation + $inter_calculation;

                return [
                    'applicationNumber' => $item->applicationNumber,
                    'applicant_name' => $item->applicant_name,
                    'fname' => $item->fname,
                    'mother' => $item->mother,
                    'gender' => $item->gender,
                    'mobile' => $item->mobile,
                    'email' => $item->email,
                    'category' => $item->category,
                    'districts' => $item->district->name_hindi,
                    'tehsil' => $item->tehsil,
                    'post_office' => $item->post_office,
                    'gram_panchayat_name' => $item->gram_panchayat_name,
                    'vikas_khand' => $item->vikas_khand,
                    'letter_address' => $item->letter_address,
                    'high_marks' => $item->high_marks,
                    'high_total_marks' => $item->high_total_marks,
                    'high_percentage' => $item->high_percentage,
                    'inter_marks' => $item->inter_marks,
                    'inter_total_marks' => $item->inter_total_marks,
                    'inter_percentage' => $item->inter_percentage,
                    'topper_number' => $topper_number,
                ];
            });
            return \Excel::download(new ExportAvedan($data), 'general-list.xlsx');
        } else {
            $results = $query->whereYear('created_at', $this->sessionYear)->paginate(50);
            return view('viewAvedan', compact('results', 'heading', "districts"))->with('route', 'allList')->with('year', $this->sessionYear);
        }
    }
    public function generalList(Request $request, $year = null) // General + OBC List will display here for status 4 (FInal Selected list after documents verify)
    {
        $this->sessionYear = $year ? $year : $this->sessionYear;
        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;


        $query = Avedan::orderBy('id', 'DESC');
        if (!empty($request->input('search'))) {
            $query->where(function ($q) use ($request) {

                $q->where('applicationNumber', '=', $request->input('search'));
            });
        }

        if ($user_type == 'Director') { //Director

            $query = Avedan::where('is_approved', '=', 4)
                ->whereIn('category', ["जनरल"])
                ->orderBy('topper_number', 'DESC');
        } else if ($user_type == 'Admin') { //Super Admin

            $query = Avedan::where('is_approved', '=', 4)
                ->whereIn('category', ["जनरल"])
                ->orderBy('topper_number', 'DESC');
        } else { //CVO

            $query = Avedan::where('is_approved', '=', 4)
                ->whereIn('category', ["जनरल"])
                ->where('district_id', '=', $districtID)
                ->orderBy('topper_number', 'DESC');
        }

        if (!empty($request->input('applicationNumber'))) {
            $query->where(function ($q) use ($request) {

                $q->where('applicationNumber', '=', $request->input('applicationNumber'));
            });
        }

        if (!empty($request->input('mobile'))) {
            $query->where(function ($q) use ($request) {

                $q->where('mobile', '=', $request->input('mobile'));
            });
        }

        if (!empty($request->input('district_id'))) {
            $query->where(function ($q) use ($request) {

                $q->where('district_id', '=', $request->input('district_id'));
            });
        }

        $districts = Districts::where('status', '=', 1)->orderBy('name_eng', 'ASC')->get();


        $heading = 'सामान्य वर्ग चयनित अभ्यर्थियों की सूची';

        if (!empty($request->input('export'))) {
            // $data = $query->select('applicationNumber', 'applicant_name', 'fname', 'mother', 'gender', 'mobile', 'email', 'high_percentage', 'inter_percentage', 'category', 'letter_address')->whereYear('created_at', $this->sessionYear)->get();
            $datas = $query->with('district')->join('districts', 'avedans.district_id', '=', 'districts.id') // Perform the join
                ->whereYear('avedans.created_at', $this->sessionYear)
                ->orderBy('avedans.category', 'DESC')
                ->get();
            $data = $datas->map(function ($item) {
                $high_percentage    = $item->high_percentage;
                $high_school_calculation = round(($high_percentage*8)/10);
                $inter_percentage   = $item->inter_percentage;
                $inter_calculation  = round(($inter_percentage*2)/10);
                $topper_number      = $high_school_calculation + $inter_calculation;

                return [
                    'applicationNumber' => $item->applicationNumber,
                    'applicant_name' => $item->applicant_name,
                    'fname' => $item->fname,
                    'mother' => $item->mother,
                    'gender' => $item->gender,
                    'mobile' => $item->mobile,
                    'email' => $item->email,
                    'category' => $item->category,
                    'districts' => $item->district->name_hindi,
                    'tehsil' => $item->tehsil,
                    'post_office' => $item->post_office,
                    'gram_panchayat_name' => $item->gram_panchayat_name,
                    'vikas_khand' => $item->vikas_khand,
                    'letter_address' => $item->letter_address,
                    'high_marks' => $item->high_marks,
                    'high_total_marks' => $item->high_total_marks,
                    'high_percentage' => $item->high_percentage,
                    'inter_marks' => $item->inter_marks,
                    'inter_total_marks' => $item->inter_total_marks,
                    'inter_percentage' => $item->inter_percentage,
                    'topper_number' => $topper_number,
                ];
            });
            return \Excel::download(new ExportAvedan($data), 'general-list.xlsx');
        } else {
            $results = $query->whereYear('created_at', $this->sessionYear)->paginate(50);
            return view('viewAvedan', compact('results', 'heading', 'districts'))->with('route', 'generalList')->with('year', $this->sessionYear);
        }
    }


    public function obcList(Request $request, $year = null) // General + OBC List will display here for status 4 (FInal Selected list after documents verify)
    {
        $this->sessionYear = $year ? $year : $this->sessionYear;
        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;


        $query = Avedan::orderBy('id', 'DESC');
        if (!empty($request->input('search'))) {
            $query->where(function ($q) use ($request) {

                $q->where('applicationNumber', '=', $request->input('search'));
            });
        }

        if ($user_type == 'Director') { //Director

            $query = Avedan::where('is_approved', '=', 4)
                ->whereIn('category', ["ओ बी सी"])
               // ->whereIn('category', ["जनरल", "ओ बी सी"])
                ->orderBy('topper_number', 'DESC');
        } else if ($user_type == 'Admin') { //Super Admin

            $query = Avedan::where('is_approved', '=', 4)
            ->whereIn('category', ["ओ बी सी"])
              //  ->whereIn('category', ["जनरल", "ओ बी सी"])
                ->orderBy('topper_number', 'DESC');
        } else { //CVO

            $query = Avedan::where('is_approved', '=', 4)
                ->whereIn('category', ["ओ बी सी"])
               // ->whereIn('category', ["जनरल", "ओ बी सी"])
                ->where('district_id', '=', $districtID)
                ->orderBy('topper_number', 'DESC');
        }

        if (!empty($request->input('applicationNumber'))) {
            $query->where(function ($q) use ($request) {

                $q->where('applicationNumber', '=', $request->input('applicationNumber'));
            });
        }

        if (!empty($request->input('mobile'))) {
            $query->where(function ($q) use ($request) {

                $q->where('mobile', '=', $request->input('mobile'));
            });
        }

        if (!empty($request->input('district_id'))) {
            $query->where(function ($q) use ($request) {

                $q->where('district_id', '=', $request->input('district_id'));
            });
        }

        $districts = Districts::where('status', '=', 1)->orderBy('name_eng', 'ASC')->get();


        $heading = 'अन्य पिछड़ा वर्ग चयनित अभ्यर्थियों की सूची';

        if (!empty($request->input('export'))) {
            // $data = $query->select('applicationNumber', 'applicant_name', 'fname', 'mother', 'gender', 'mobile', 'email', 'high_percentage', 'inter_percentage', 'category', 'letter_address')->whereYear('created_at', $this->sessionYear)->get();
            $datas = $query->with('district')->join('districts', 'avedans.district_id', '=', 'districts.id') // Perform the join
                ->whereYear('avedans.created_at', $this->sessionYear)
                ->orderBy('avedans.category', 'DESC')
                ->get();
            $data = $datas->map(function ($item) {
                $high_percentage    = $item->high_percentage;
                $high_school_calculation = round(($high_percentage*8)/10);
                $inter_percentage   = $item->inter_percentage;
                $inter_calculation  = round(($inter_percentage*2)/10);
                $topper_number      = $high_school_calculation + $inter_calculation;

                return [
                    'applicationNumber' => $item->applicationNumber,
                    'applicant_name' => $item->applicant_name,
                    'fname' => $item->fname,
                    'mother' => $item->mother,
                    'gender' => $item->gender,
                    'mobile' => $item->mobile,
                    'email' => $item->email,
                    'category' => $item->category,
                    'districts' => $item->district->name_hindi,
                    'tehsil' => $item->tehsil,
                    'post_office' => $item->post_office,
                    'gram_panchayat_name' => $item->gram_panchayat_name,
                    'vikas_khand' => $item->vikas_khand,
                    'letter_address' => $item->letter_address,
                    'high_marks' => $item->high_marks,
                    'high_total_marks' => $item->high_total_marks,
                    'high_percentage' => $item->high_percentage,
                    'inter_marks' => $item->inter_marks,
                    'inter_total_marks' => $item->inter_total_marks,
                    'inter_percentage' => $item->inter_percentage,
                    'topper_number' => $topper_number,
                ];
            });
            return \Excel::download(new ExportAvedan($data), 'general-list.xlsx');
        } else {
            $results = $query->whereYear('created_at', $this->sessionYear)->paginate(50);
            return view('viewAvedan', compact('results', 'heading', 'districts'))->with('route', 'obcList')->with('year', $this->sessionYear);
        }
    }



    public function scList(Request $request, $year = null, $export = null) // SC  List will display here
    {
        $this->sessionYear = $year ? $year : $this->sessionYear;
        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;

        $query = Avedan::orderBy('id', 'DESC');
        if (!empty($request->input('search'))) {
            $query->where(function ($q) use ($request) {

                $q->where('applicationNumber', '=', $request->input('search'));
            });
        }

        if ($user_type == 'Director') { //Director
            $query = Avedan::where('is_approved', '=', 4)
                ->whereIn('category', ["एस सी"])
                ->orderBy('topper_number', 'DESC');
        } else if ($user_type == 'Admin') { //Super Admin


            $query = Avedan::where('is_approved', '=', 4)
                ->whereIn('category', ["एस सी"])
                ->orderBy('topper_number', 'DESC');
        } else { //CVO
            $query = Avedan::where('is_approved', '=', 4)
                ->whereIn('category', ["एस सी"])
                ->where('district_id', '=', $districtID)
                ->orderBy('topper_number', 'DESC');
        }

        if (!empty($request->input('applicationNumber'))) {
            $query->where(function ($q) use ($request) {

                $q->where('applicationNumber', '=', $request->input('applicationNumber'));
            });
        }

        if (!empty($request->input('mobile'))) {
            $query->where(function ($q) use ($request) {

                $q->where('mobile', '=', $request->input('mobile'));
            });
        }

        if (!empty($request->input('district_id'))) {
            $query->where(function ($q) use ($request) {

                $q->where('district_id', '=', $request->input('district_id'));
            });
        }

        $districts = Districts::where('status', '=', 1)->orderBy('name_eng', 'ASC')->get();


        $heading = 'चयनित अनुसूचित जाति चयनित अभ्यर्थियों की सूची';

        if (!empty($request->input('export'))) {
            // $data = $query->select('applicationNumber', 'applicant_name', 'fname', 'mother', 'gender', 'mobile', 'email', 'high_percentage', 'inter_percentage', 'category', 'letter_address')->whereYear('created_at', $this->sessionYear)->get();
            $datas = $query->join('districts', 'avedans.district_id', '=', 'districts.id') // Perform the join
                ->whereYear('avedans.created_at', $this->sessionYear)
                ->orderBy('avedans.category', 'DESC')
                ->get();

            $data = $datas->map(function ($item) {
                $high_percentage    = $item->high_percentage;
                $high_school_calculation = round(($high_percentage*8)/10);
                $inter_percentage   = $item->inter_percentage;
                $inter_calculation  = round(($inter_percentage*2)/10);
                $topper_number      = $high_school_calculation + $inter_calculation;

                return [
                    'applicationNumber' => $item->applicationNumber,
                    'applicant_name' => $item->applicant_name,
                    'fname' => $item->fname,
                    'mother' => $item->mother,
                    'gender' => $item->gender,
                    'mobile' => $item->mobile,
                    'email' => $item->email,
                    'category' => $item->category,
                    'districts' => $item->district->name_hindi,
                    'tehsil' => $item->tehsil,
                    'post_office' => $item->post_office,
                    'gram_panchayat_name' => $item->gram_panchayat_name,
                    'vikas_khand' => $item->vikas_khand,
                    'letter_address' => $item->letter_address,
                    'high_marks' => $item->high_marks,
                    'high_total_marks' => $item->high_total_marks,
                    'high_percentage' => $item->high_percentage,
                    'inter_marks' => $item->inter_marks,
                    'inter_total_marks' => $item->inter_total_marks,
                    'inter_percentage' => $item->inter_percentage,
                    'topper_number' => $topper_number,
                ];
            });
            return \Excel::download(new ExportAvedan($data), 'sc-list.xlsx');
        } else {
            $results = $query->whereYear('created_at', $this->sessionYear)->paginate(50);
            return view('viewAvedan', compact('results', 'heading', 'districts'))->with('route', 'scList')->with('year', $this->sessionYear);
        }
    }


    public function stList(Request $request, $year = null) // ST List will display here
    {
        $this->sessionYear = $year ? $year : $this->sessionYear;
        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;

        $query = Avedan::orderBy('id', 'DESC');
        if (!empty($request->input('search'))) {
            $query->where(function ($q) use ($request) {

                $q->where('applicationNumber', '=', $request->input('search'));
            });
        }

        if ($user_type == 'Director') { //Director
            $query = Avedan::where('is_approved', '=', 4)
                ->whereIn('category', ["एस टी"])
                ->orderBy('topper_number', 'DESC');
        } else if ($user_type == 'Admin') { //Super Admin

            $query = Avedan::where('is_approved', '=', 4)
                ->whereIn('category', ["एस टी"])
                ->orderBy('topper_number', 'DESC');
        } else { //CVO
            $query = Avedan::where('is_approved', '=', 4)
                ->whereIn('category', ["एस टी"])
                ->where('district_id', '=', $districtID)
                ->orderBy('topper_number', 'DESC');
        }

        if (!empty($request->input('applicationNumber'))) {
            $query->where(function ($q) use ($request) {

                $q->where('applicationNumber', '=', $request->input('applicationNumber'));
            });
        }

        if (!empty($request->input('mobile'))) {
            $query->where(function ($q) use ($request) {

                $q->where('mobile', '=', $request->input('mobile'));
            });
        }

        if (!empty($request->input('district_id'))) {
            $query->where(function ($q) use ($request) {

                $q->where('district_id', '=', $request->input('district_id'));
            });
        }

        $districts = Districts::where('status', '=', 1)->orderBy('name_eng', 'ASC')->get();


        $heading = 'चयनित अनुसूचित जनजाति चयनित अभ्यर्थियों की सूची';

        if (!empty($request->input('export'))) {
            // $data = $query->select('applicationNumber', 'applicant_name', 'fname', 'mother', 'gender', 'mobile', 'email', 'high_percentage', 'inter_percentage', 'category', 'letter_address')->whereYear('created_at', $this->sessionYear)->get();
            $datas = $query->with('district')->join('districts', 'avedans.district_id', '=', 'districts.id') // Perform the join
                ->whereYear('avedans.created_at', $this->sessionYear)
                ->orderBy('avedans.category', 'DESC')
                ->get();
            $data = $datas->map(function ($item) {
                $high_percentage    = $item->high_percentage;
                $high_school_calculation = round(($high_percentage*8)/10);
                $inter_percentage   = $item->inter_percentage;
                $inter_calculation  = round(($inter_percentage*2)/10);
                $topper_number      = $high_school_calculation + $inter_calculation;

                return [
                    'applicationNumber' => $item->applicationNumber,
                    'applicant_name' => $item->applicant_name,
                    'fname' => $item->fname,
                    'mother' => $item->mother,
                    'gender' => $item->gender,
                    'mobile' => $item->mobile,
                    'email' => $item->email,
                    'category' => $item->category,
                    'districts' => $item->district->name_hindi,
                    'tehsil' => $item->tehsil,
                    'post_office' => $item->post_office,
                    'gram_panchayat_name' => $item->gram_panchayat_name,
                    'vikas_khand' => $item->vikas_khand,
                    'letter_address' => $item->letter_address,
                    'high_marks' => $item->high_marks,
                    'high_total_marks' => $item->high_total_marks,
                    'high_percentage' => $item->high_percentage,
                    'inter_marks' => $item->inter_marks,
                    'inter_total_marks' => $item->inter_total_marks,
                    'inter_percentage' => $item->inter_percentage,
                    'topper_number' => $topper_number,
                ];
            });
            return \Excel::download(new ExportAvedan($data), 'st-list.xlsx');
        } else {
            $results = $query->whereYear('created_at', $this->sessionYear)->paginate(50);
            return view('viewAvedan', compact('results', 'heading', 'districts'))->with('route', 'stList')->with('year', $this->sessionYear);
        }
    }


    public function waitingList($id, $export = null) // SC + ST List will display here
    {
        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;

        if ($id == 1) { //General + OBC Waiting List

            $results = Avedan::where('is_approved', '=', 3)
                ->whereIn('category', ["जनरल"])
                ->where('district_id', '=', $districtID)
                ->whereYear('created_at', $this->sessionYear)
                ->orderBy('topper_number', 'DESC')
                ->get();

            $heading = 'सामान्य वर्ग अभ्यर्थियों की प्रतीक्षा सूची';
        } else if ($id == 2) { //General + OBC Waiting List

            $results = Avedan::where('is_approved', '=', 3)
                ->whereIn('category', ["ओ बी सी"])
                ->where('district_id', '=', $districtID)
                ->whereYear('created_at', $this->sessionYear)
                ->orderBy('topper_number', 'DESC')
                ->get();

            $heading = 'अन्य पिछड़ा वर्ग अभ्यर्थियों की प्रतीक्षा सूची';
        } 
        
        
        else if ($id == 3) { //SC Waiting List

            $results = Avedan::where('is_approved', '=', 3)
                ->whereIn('category', ["एस सी"])
                ->where('district_id', '=', $districtID)
                ->whereYear('created_at', $this->sessionYear)
                ->orderBy('topper_number', 'DESC')
                ->get();

            $heading = 'अनुसूचित जाति अभ्यर्थियों की प्रतीक्षा सूची';
        } else { //ST Waiting List

            $results = Avedan::where('is_approved', '=', 3)->with('district')
                ->whereIn('category', ["एस टी"])
                ->where('district_id', '=', $districtID)
                ->whereYear('created_at', $this->sessionYear)
                ->orderBy('topper_number', 'DESC')
                ->get();

            $heading = 'अनुसूचित जनजाति अभ्यर्थियों की प्रतीक्षा सूची';
        }

        if ($export !== null) {
            $data = $results->map(function ($item) {
                $high_percentage    = $item->high_percentage;
                $high_school_calculation = round(($high_percentage*8)/10);
                $inter_percentage   = $item->inter_percentage;
                $inter_calculation  = round(($inter_percentage*2)/10);
                $topper_number      = $high_school_calculation + $inter_calculation;

                return [
                    'applicationNumber' => $item->applicationNumber,
                    'applicant_name' => $item->applicant_name,
                    'fname' => $item->fname,
                    'mother' => $item->mother,
                    'gender' => $item->gender,
                    'mobile' => $item->mobile,
                    'email' => $item->email,
                    'category' => $item->category,
                    'districts' => $item->district->name_hindi,
                    'tehsil' => $item->tehsil,
                    'post_office' => $item->post_office,
                    'gram_panchayat_name' => $item->gram_panchayat_name,
                    'vikas_khand' => $item->vikas_khand,
                    'letter_address' => $item->letter_address,
                    'high_marks' => $item->high_marks,
                    'high_total_marks' => $item->high_total_marks,
                    'high_percentage' => $item->high_percentage,
                    'inter_marks' => $item->inter_marks,
                    'inter_total_marks' => $item->inter_total_marks,
                    'inter_percentage' => $item->inter_percentage,
                    'topper_number' => $topper_number,
                ];
            });
            return \Excel::download(new ExportAvedan($data), 'waiting-list.xlsx');
        } else {
            return view('viewAvedanWaiting', compact('results', 'heading'))->with('exportId', $id);
        }
    }

    public function avedanFullDetails($id)
    {
        $result = Avedan::find($id);
        $this->sessionYear = $result->created_at->year;


        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = $result->district_id;

        $result = Avedan::find($id);

        $target = Districts::find($districtID);


        $totalSelectedCandidates = 0;
        $targetCandidates = 0;
        /*------Start Getting total General and OBC selected candidates-----------------*/
        if ($result->category == 'जनरल' or $result->category == 'ओ बी सी') {

            $selectedCandidates = Avedan::where('is_approved', '=', 1)
                ->whereIn('category', ["जनरल", "ओ बी सी"])
                ->where('district_id', '=', $districtID)
                ->whereYear('created_at', $this->sessionYear)
                ->get();
            $totalSelectedCandidates = $selectedCandidates->count();
            $targetCandidates = ($target)?$target->general_target:'';
        }
        /*------End Getting total General and OBC selected candidates-----------------*/

        /*------Start Getting total SC and ST selected candidates-----------------*/ else if ($result->category == 'एस सी' or $result->category == 'एस टी') {

            $selectedCandidates = Avedan::where('is_approved', '=', 1)
                ->whereNotIn('category', ["एस सी", "एस टी"])
                ->where('district_id', '=', $districtID)
                ->whereYear('created_at', $this->sessionYear)
                ->get();
            $totalSelectedCandidates = $selectedCandidates->count();
            $targetCandidates = ($target)?$target->sc_st_target:'';
        }
        // dd($totalSelectedCandidates,$targetCandidates);
        /*------End Getting total SC and ST selected candidates-----------------*/

        //echo 'targetCandidates=' . $targetCandidates . ' and selected candidates=' . $totalSelectedCandidates;exit;

        // if ($totalSelectedCandidates < $targetCandidates) {

            $waitingButtonShow = false;
        // } else {

        //     $waitingButtonShow = true;
        // }
        
        //echo '<pre>';print_r($result);exit;
        return view('viewAvedanDetails', compact('result', 'waitingButtonShow'));
    }

    public function waitingAvedanFullDetails($id)
    {
        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;

        $result = Avedan::find($id);

        $target = Districts::find($districtID);

        $totalSelectedCandidates = 0;
        $targetCandidates = 0;
        /*------Start Getting total General and OBC selected candidates-----------------*/
        if ($result->category == 'जनरल' or $result->category == 'ओ बी सी') {

            $selectedCandidates = Avedan::where('is_approved', '=', 1)
                ->whereIn('category', ["जनरल", "ओ बी सी"])
                ->where('district_id', '=', $districtID)
                ->get();
            $totalSelectedCandidates = $selectedCandidates->count();
            $targetCandidates = ($target)?$target->general_target:'';
        }
        /*------End Getting total General and OBC selected candidates-----------------*/

        /*------Start Getting total SC and ST selected candidates-----------------*/ else if ($result->category == 'एस सी' or $result->category == 'एस टी') {

            $selectedCandidates = Avedan::where('is_approved', '=', 1)
                ->whereNotIn('category', ["एस सी", "एस टी"])
                ->where('district_id', '=', $districtID)
                ->get();
            $totalSelectedCandidates = $selectedCandidates->count();
            $targetCandidates = ($target)?$target->sc_st_target:'';
        }
       
        /*------End Getting total SC and ST selected candidates-----------------*/

        //echo 'targetCandidates=' . $targetCandidates . ' and selected candidates=' . $totalSelectedCandidates;exit;

        // if ($totalSelectedCandidates < $targetCandidates) {

            $waitingButtonShow = false;
        // } else {

        //     $waitingButtonShow = true;
        // }

        //echo $waitingButtonShow;exit;

        //echo '<pre>';print_r($result);exit;
        return view('viewWaitingAvedanDetails', compact('result', 'waitingButtonShow'));
    }



    // public function meritAvedanDetails($id)
    // {
    // 	$user = auth()->user();
    // 	$user_type = $user->user_type;
    // 	$districtID = auth()->user()->district_id;

    // 	$result = Avedan::find($id);
    // 	$target = Districts::find($districtID);

    // 	$totalSelectedCandidates = 0;
    // 	$targetCandidates = 0;



    // 	/*------Start Getting total General and OBC selected candidates-----------------*/
    // 	if ($result->category == 'जनरल' or $result->category == 'ओ बी सी') {

    // 		$selectedCandidates = Avedan::where('is_approved', '=', 1)
    // 			->whereIn('category', ["जनरल", "ओ बी सी"])
    // 			->where('district_id', '=', $districtID)
    // 			->get();
    // 		$totalSelectedCandidates = $selectedCandidates->count();
    // 		$targetCandidates = $target->general_target;
    // 	}
    // 	/*------End Getting total General and OBC selected candidates-----------------*/

    // 	/*------Start Getting total SC selected candidates-----------------*/ else if ($result->category == 'एस सी') {

    // 		$selectedCandidates = Avedan::where('is_approved', '=', 1)
    // 			->whereIn('category', ["एस सी"])
    // 			->where('district_id', '=', $districtID)
    // 			->get();
    // 		$totalSelectedCandidates = $selectedCandidates->count();
    // 		$targetCandidates = $target->sc_target;
    // 	}
    // 	/*------End Getting total SC selected candidates-----------------*/

    // 	/*------Start Getting total ST selected candidates-----------------*/ else if ($result->category == 'एस टी') {

    // 		$selectedCandidates = Avedan::where('is_approved', '=', 1)
    // 			->whereIn('category', ["एस टी"])
    // 			->where('district_id', '=', $districtID)
    // 			->get();
    // 		$totalSelectedCandidates = $selectedCandidates->count();
    // 		$targetCandidates = $target->st_target;
    // 	}
    // 	/*------End Getting total ST selected candidates-----------------*/



    // 	//echo 'targetCandidates=' . $targetCandidates . ' and selected candidates=' . $totalSelectedCandidates;exit;

    // 	if ($totalSelectedCandidates >= $targetCandidates) {

    // 		$waitingButtonShow = false;
    // 	} else {

    // 		$waitingButtonShow = true;
    // 	}

    // 	//echo $waitingButtonShow;exit;

    // 	return view('meritListDetails', compact('result', 'waitingButtonShow'));
    // }

    public function meritAvedanDetails($id)
    {
        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;

        $result = Avedan::find($id);
        $target = Districts::find($districtID);

        $totalSelectedCandidates = 0;
        $targetCandidates = 0;


        /*------Start Getting total General and OBC selected candidates-----------------*/
        if ($result->category == 'जनरल' or $result->category == 'ओ बी सी') {

            $selectedCandidates = Avedan::where('is_approved', '=', 1)
                ->whereIn('category', ["जनरल", "ओ बी सी"])
                ->where('district_id', '=', $districtID)
                ->whereYear('created_at', $this->sessionYear)
                ->get();
            $totalSelectedCandidates = $selectedCandidates->count();
            $targetCandidates = ($target)? $target->general_target:'';
        }
        /*------End Getting total General and OBC selected candidates-----------------*/

        /*------Start Getting total SC selected candidates-----------------*/ else if ($result->category == 'एस सी') {

            $selectedCandidates = Avedan::where('is_approved', '=', 1)
                ->whereIn('category', ["एस सी"])
                ->where('district_id', '=', $districtID)
                ->whereYear('created_at', $this->sessionYear)
                ->get();
            $totalSelectedCandidates = $selectedCandidates->count();
            $targetCandidates = ($target)? $target->sc_target:''; 
        }
        /*------End Getting total SC selected candidates-----------------*/

        /*------Start Getting total ST selected candidates-----------------*/ else if ($result->category == 'एस टी') {

            $selectedCandidates = Avedan::where('is_approved', '=', 1)
                ->whereIn('category', ["एस टी"])
                ->where('district_id', '=', $districtID)
                ->whereYear('created_at', $this->sessionYear)
                ->get();
            $totalSelectedCandidates = $selectedCandidates->count();
            $targetCandidates = ($target)? $target->st_target:''; 
        }
        /*------End Getting total ST selected candidates-----------------*/



        //echo 'targetCandidates=' . $targetCandidates . ' and selected candidates=' . $totalSelectedCandidates;exit;

        // if ($totalSelectedCandidates < $targetCandidates) {

            $waitingButtonShow = false;
        // } else {

        //     $waitingButtonShow = true;
        // }

        //echo $waitingButtonShow;exit;

        return view('meritListDetails', compact('result', 'waitingButtonShow'));
    }

    public function downloadFiles(Request $request, $fileName)
    {
        $path = public_path() . '/upload_documents/' . $fileName;
        return response()->download($path, $fileName);
    }

    public function avedanStatus(Request $request, $id, $status)
    {

        $result = Avedan::find($id);
        $comment  =  Rejectcomment::where(['application_id'=>$id])->delete();
        $result->is_approved = $status;
        $result->save();
        return redirect('/merit-Avedan-details/' . $id)->with('success', 'status updated successfully!');
    }

    public function rejectApplication(Request $request)
    {

        if(auth()->user()->user_type == 'District Officer'){
            return redirect()->back()->with('success', 'status not updated!');
        }


        $application_id = $request->get('application_id');
        $result = Avedan::find($request->get('application_id'));
        //echo '<pre>';print_r($result);exit;
        $result->is_approved = 2;
        $result->save();

        $comments = new Rejectcomment([
            'application_id' => $request->get('application_id'),
            'comments' => $request->get('comments'),
            'user_id' => auth()->user()->id,
        ]);
        $comments->save();
        return redirect('/view-Avedan-details/' . $application_id)->with('success', 'status updated successfully!');
    }

    public function uploadDocuments($export = null, $year = null)
    {
        $this->sessionYear = $year ? $year : $this->sessionYear;
        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;

        if ($user_type == 'District Officer') { //CVO only

            $results = Avedan::where('is_approved', '=', 1)->with('district')
                ->where('district_id', '=', $districtID)
                ->whereYear('created_at', $this->sessionYear)
                //->whereNotIn('id', DB::table('verificationcomments')->pluck('application_id'))
                ->orderBy('topper_number', 'DESC')
                ->get();
        } else {

            return redirect('/dashboard')->with('success', 'YOU ARE NOT ALLOWED TO ACCESS THIS PAGE!');
        }

        $heading = 'अपलोड स्वास्थ प्रमाण पत्र';

        if ($export !== null) {
            $data = $results->map(function ($item) {
                $high_percentage    = $item->high_percentage;
                $high_school_calculation = round(($high_percentage*8)/10);
                $inter_percentage   = $item->inter_percentage;
                $inter_calculation  = round(($inter_percentage*2)/10);
                $topper_number      = $high_school_calculation + $inter_calculation;

                    return [
                        'applicationNumber' => $item->applicationNumber,
                        'applicant_name' => $item->applicant_name,
                        'fname' => $item->fname,
                        'mother' => $item->mother,
                        'gender' => $item->gender,
                        'mobile' => $item->mobile,
                        'email' => $item->email,
                        'category' => $item->category,
                        'districts' => $item->district->name_hindi,
                        'tehsil' => $item->tehsil,
                        'post_office' => $item->post_office,
                        'gram_panchayat_name' => $item->gram_panchayat_name,
                        'vikas_khand' => $item->vikas_khand,
                        'letter_address' => $item->letter_address,
                        'high_marks' => $item->high_marks,
                        'high_total_marks' => $item->high_total_marks,
                        'high_percentage' => $item->high_percentage,
                        'inter_marks' => $item->inter_marks,
                        'inter_total_marks' => $item->inter_total_marks,
                        'inter_percentage' => $item->inter_percentage,
                        'topper_number' => $topper_number,
                    ];
                });
            return \Excel::download(new ExportAvedan($data), 'upload-documents-list.xlsx');
        } else {
            return view('uploadDocuments', compact('results', 'heading'))->with('routeName', 'uploadDocuments');
        }
    }

    public function editUploadAvedan($id)
    {
        $result = Avedan::find($id);
        if (empty($result)) {
            return redirect('/avedan/')->with('success', 'अनअथॉरिज़ एक्शन');
        }
        $districts = Districts::where('status', '=', 1)->orderBy('name_eng', 'ASC')->get();
        return view('avedanEditUploadDocuments', compact('districts', 'result'));
    }

    public function avedanUpdatedDocuments(Request $request, $id)
    {

        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;

        $result = Avedan::find($id);
        $target = Districts::find($districtID);

        // switch ($result->category) {
        //     case 'जनरल':
        //         $selectedCandidates = Avedan::where('is_approved', '=', 4)
        //             // ->whereIn('category', ["जनरल"]) 
        //             ->where('district_id', '=', $districtID)
        //             ->whereYear('created_at', $this->sessionYear)
        //             ->get();
        //         $totalSelectedCandidates = $selectedCandidates->count();
        //         $targetCandidates = $target->general_target;
        //         break;
        //     case 'ओ बी सी':
        //         $selectedCandidates = Avedan::where('is_approved', '=', 4)
        //             // ->whereIn('category', [ "ओ बी सी"]) 
        //             ->where('district_id', '=', $districtID)
        //             ->whereYear('created_at', $this->sessionYear)
        //             ->get();
        //         $totalSelectedCandidates = $selectedCandidates->count();
        //         $targetCandidates = $target->general_target;
        //         break;
        //     case 'एस सी':
        //         $selectedCandidates = Avedan::where('is_approved', '=', 4)
        //             // ->whereIn('category', ["एस सी"])  
        //             ->where('district_id', '=', $districtID)
        //             ->whereYear('created_at', $this->sessionYear)
        //             ->get();
        //         $totalSelectedCandidates = $selectedCandidates->count();
        //         $targetCandidates = $target->sc_target;
        //         break;
        //     case 'एस टी':
        //         $selectedCandidates = Avedan::where('is_approved', '=', 4)
        //             // ->whereIn('category', ["एस टी"])  
        //             ->where('district_id', '=', $districtID)
        //             ->whereYear('created_at', $this->sessionYear)
        //             ->get();
        //         $totalSelectedCandidates = $selectedCandidates->count();
        //         $targetCandidates = $target->st_target;
        //         break;

        //     default:
        //         # code...
        //         break;
        // }
        switch ($result->category) {
            case 'जनरल':
                $selectedCandidates = Avedan::where('is_approved', '=', 4)
                    ->where('district_id', '=', $districtID)
                    ->whereYear('created_at', $this->sessionYear)
                    ->get();
                $totalSelectedCandidates = $selectedCandidates->count();
                $targetCandidates = $target->general_target + $target->obc_target + $target->sc_target +$target->st_target;
                break;
            case 'ओ बी सी':
                $selectedCandidates = Avedan::where('is_approved', '=', 4)
                    ->where('district_id', '=', $districtID)
                    ->whereYear('created_at', $this->sessionYear)
                    ->get();
                $totalSelectedCandidates = $selectedCandidates->count();
                $targetCandidates = $target->general_target + $target->obc_target +  $target->sc_target +$target->st_target;
                break;
            case 'एस सी':
                $selectedCandidates = Avedan::where('is_approved', '=', 4)
                    ->where('district_id', '=', $districtID)
                    ->whereYear('created_at', $this->sessionYear)
                    ->get();
                $totalSelectedCandidates = $selectedCandidates->count();
                $targetCandidates = $target->general_target + $target->obc_target +  $target->sc_target +$target->st_target;
                break;
            case 'एस टी':
                $selectedCandidates = Avedan::where('is_approved', '=', 4)
                    ->where('district_id', '=', $districtID)
                    ->whereYear('created_at', $this->sessionYear)
                    ->get();
                $totalSelectedCandidates = $selectedCandidates->count();
                $targetCandidates = $target->general_target + $target->obc_target + $target->sc_target +$target->st_target;
                break;

            default:
                # code...
                break;
        }
     
        if ($totalSelectedCandidates >= $targetCandidates) {

            return back()->withErrors(['status' => 'सीटें पहले ही भर चुकी हैं']);
        }
        $autoID = $id;


        $autoID = $id;
        $data =  $result;

        $health_certificate =  '';
        if ($request->hasfile('health_certificate')) {
            $health_certificate = 'health_certificate' . $autoID . '.' . $request->file('health_certificate')->extension();
            $request->file('health_certificate')->move(public_path('upload_documents'), $health_certificate);
        }


        $data->health_certificate = $health_certificate;
        $data->is_approved = 4; // application will show in चयनित अभ्यर्थियों की सूची

        $data->save();
        $comments = 'आपका आवेदन चयन कर लिया गया है';
        $comments = new Rejectcomment([
            'application_id' => $data['id'],
            'comments' => $comments,
            'user_id' => auth()->user()->id,
        ]);
        $comments->save();

        /*---------Start Sending mail-------------------
        $data = json_decode(json_encode($data), true);
		$data['heading'] = 'चयनित';
		$data['bodyMessage'] = "".$data['applicant_name']." जी<br><br>आपका चयन कर लिया गया है| आपकी  आवेदन संख्या '<b>".$data['applicationNumber']."</b>' है|";

		$user['email'] = $data['email'];
		$user['subject'] = 'चयनितME';

		Mail::Send('mailTemplate', $data, function($message) use ($user){

			$message->to($user['email']);
			$message->subject($user['subject']);
		});
        /*---------End Sending mail-------------------
        die('send');*/
        return redirect('/upload-documents')->with('success', 'Health Certifficate updloaded successfully!');
    }

    public function editAvedan($id)
    {
        $banks      =  Banks::get();
        $result = Avedan::find($id);
        if (empty($result)) {
            return redirect('/avedan/')->with('success', 'अनअथॉरिज़ एक्शन');
        }
        $districts = Districts::where('status', '=', 1)->orderBy('name_eng', 'ASC')->get();
        return view('avedanEdit', compact('districts', 'result','banks'));
    }

    public function avedanUpdated(Request $request, $id)
    {
        $autoID = $id;
        $data = Avedan::find($id);



        $permanent_address_proof =  '';
        if ($request->hasfile('permanent_address_proof')) {
            @unlink(public_path('upload_documents') . '/' . $data->permanent_address_proof);
            $permanent_address_proof = 'address_proof' . $autoID . '.' . $request->file('permanent_address_proof')->extension();
            $request->file('permanent_address_proof')->move(public_path('upload_documents'), $permanent_address_proof);
        }

        $training_certificate =  '';
        if ($request->hasfile('training_certificate')) {
            @unlink(public_path('upload_documents') . '/' . $data->training_certificate);
            $training_certificate = 'training_certificate' . $autoID . '.' . $request->file('training_certificate')->extension();
            $request->file('training_certificate')->move(public_path('upload_documents'), $training_certificate);
        }

        $id_upload =  '';
        if ($request->hasfile('id_upload')) {
            @unlink(public_path('upload_documents') . '/' . $data->id_upload);
            $id_upload = 'id_upload' . $autoID . '.' . $request->file('id_upload')->extension();
            $request->file('id_upload')->move(public_path('upload_documents'), $id_upload);
        }

        $caste_certificate =  '';
        if ($request->hasfile('caste_certificate')) {
            @unlink(public_path('upload_documents') . '/' . $data->caste_certificate);
            $caste_certificate = 'caste_certificate' . $autoID . '.' . $request->file('caste_certificate')->extension();
            $request->file('caste_certificate')->move(public_path('upload_documents'), $caste_certificate);
        }

        $applicant_photo =  '';
        if ($request->hasfile('applicant_photo')) {
            //echo '<pre>';print_r($_FILES);exit;
            @unlink(public_path('upload_documents') . '/' . $data->applicant_photo);
            $applicant_photo = 'applicant_photo' . $autoID . '.' . $request->file('applicant_photo')->extension();
            $request->file('applicant_photo')->move(public_path('upload_documents'), $applicant_photo);
        }

        $signature =  '';
        if ($request->hasfile('signature')) {
            @unlink(public_path('upload_documents') . '/' . $data->signature);
            $signature = 'signature' . $autoID . '.' . $request->file('signature')->extension();
            $request->file('signature')->move(public_path('upload_documents'), $signature);
        }

        $high_marksheet =  '';
        if ($request->hasfile('high_marksheet')) {
            @unlink(public_path('upload_documents') . '/' . $data->high_marksheet);
            $high_marksheet = 'high_marksheet' . $autoID . '.' . $request->file('high_marksheet')->extension();
            $request->file('high_marksheet')->move(public_path('upload_documents'), $high_marksheet);
        }

        $high_certificate =  '';
        if ($request->hasfile('high_certificate')) {
            @unlink(public_path('upload_documents') . '/' . $data->high_certificate);
            $high_certificate = 'high_certificate' . $autoID . '.' . $request->file('high_certificate')->extension();
            $request->file('high_certificate')->move(public_path('upload_documents'), $high_certificate);
        }

        $inter_marksheet =  '';
        if ($request->hasfile('inter_marksheet')) {
            @unlink(public_path('upload_documents') . '/' . $data->inter_marksheet);
            $inter_marksheet = 'inter_marksheet' . $autoID . '.' . $request->file('inter_marksheet')->extension();
            $request->file('inter_marksheet')->move(public_path('upload_documents'), $inter_marksheet);
        }

        $inter_certificate =  '';
        if ($request->hasfile('inter_certificate')) {
            @unlink(public_path('upload_documents') . '/' . $data->inter_certificate);
            $inter_certificate = 'inter_certificate' . $autoID . '.' . $request->file('inter_certificate')->extension();
            $request->file('inter_certificate')->move(public_path('upload_documents'), $inter_certificate);
        }

        /*--------------------Start Calculation for High School---------------*/
        $high_percentage = $request->get('high_percentage');
        $high_school_calculation = round(($high_percentage * 8) / 10);
        /*--------------------End Calculation for High School-----------------*/

        /*--------------------Start Calculation for Inter---------------*/
        $inter_percentage = $request->get('inter_percentage');
        $inter_calculation = round(($inter_percentage * 2) / 10);
        /*--------------------End Calculation for Inter-----------------*/

        /*--------------------Start Calculation for certification (Getting month and Days)-------------*/
        $training_certificate_period_in_month = $request->get('training_certificate_period_in_month');
        $training_certificate_period_in_days = $request->get('training_certificate_period_in_days');

        $training_certificate_period_in_month = ($training_certificate_period_in_month) ? $training_certificate_period_in_month : 0;
        $training_certificate_period_in_days = ($training_certificate_period_in_days) ? $training_certificate_period_in_days : 0;

        $total_number_of_training_days = ($training_certificate_period_in_month * 30) + $training_certificate_period_in_days;

        if ($total_number_of_training_days >= 1 && $total_number_of_training_days <= 30) { //upto 1 month

            $gettingAnk = 4;
        } else if ($total_number_of_training_days > 30 && $total_number_of_training_days <= 60) { // 1-2 months

            $gettingAnk = 8;
        } else if ($total_number_of_training_days > 60 && $total_number_of_training_days <= 90) { // 2-3 months

            $gettingAnk = 12;
        } else if ($total_number_of_training_days > 90 && $total_number_of_training_days <= 120) { // 3-4 months

            $gettingAnk = 16;
        } else if ($total_number_of_training_days > 120) { // more than 4 months

            $gettingAnk = 20;
        } else {

            $gettingAnk = 0;
        }
        /*--------------------End Calculation for certification (Getting month and Days)-------------*/


        /*--------------Getting Total Numbers-----------------------------------------*/
        $topper_number = $high_school_calculation + $inter_calculation + $gettingAnk;


        $data->applicant_name = $request->get('applicant_name');
        $data->fname = $request->get('fname');
        $data->dob = \Carbon\Carbon::parse($request->get('dob'))->format('Y-m-d');
        $data->mobile = $request->get('mobile');
        $data->is_approved = 0;
        $data->category = $request->get('category');
        $data->permanent_address = $request->get('permanent_address');
        if ($permanent_address_proof != '') {

            $data->permanent_address_proof = $permanent_address_proof;
        }
        $data->gram_panchayat_name = $request->get('gram_panchayat_name');
        // $data->niyay_panchayat_name = $request->get('niyay_panchayat_name');
        $data->vikas_khand = $request->get('vikas_khand');
        $data->district_id = $request->get('janpad');
        $data->letter_address = $request->get('letter_address');
        $data->email = $request->get('email');
        if ($applicant_photo != '') {

            $data->applicant_photo = $applicant_photo;
        }

        if ($signature != '') {

            $data->signature = $signature;
        }
        $data->high_board_name = $request->get('high_board_name');
        $data->high_passing_year = $request->get('high_passing_year');
        $data->high_marks = $request->get('high_marks');
        $data->high_total_marks = $request->get('high_total_marks');
        $data->high_percentage = $request->get('high_percentage');
        $data->inter_board_name = $request->get('inter_board_name');
        $data->inter_passing_year = $request->get('inter_passing_year');
        $data->inter_marks = $request->get('inter_marks');
        $data->inter_total_marks = $request->get('inter_total_marks');
        $data->inter_percentage = $request->get('inter_percentage');

        if ($training_certificate != '') {

            $data->training_certificate = $training_certificate;
        }

        if ($id_upload != '') {

            $data->id_upload = $id_upload;
        }

        if ($caste_certificate != '') {

            $data->caste_certificate = $caste_certificate;
        }
        $data->nationality = $request->get('nationality');

        if ($high_marksheet != '') {

            $data->high_marksheet = $high_marksheet;
        }

        if ($high_certificate != '') {

            $data->high_certificate = $high_certificate;
        }

        if ($inter_marksheet != '') {

            $data->inter_marksheet = $inter_marksheet;
        }

        if ($inter_certificate != '') {

            $data->inter_certificate = $inter_certificate;
        }

        $data->high_school_calculation = $high_school_calculation;
        $data->inter_calculation = $inter_calculation;
        $data->certificate_calculation = $gettingAnk;
        $data->topper_number = $topper_number;
        $data->training_certificate_period_in_month = $training_certificate_period_in_month;
        $data->training_certificate_period_in_days = $training_certificate_period_in_days;
        $data->is_approved = $request->get('is_approved');

        $data->save();
        //echo '<pre>';print_r($data);exit;

        return redirect('/edit-avedan/' . $id)->with('success', 'Application updated successfully!');
    }

    public function candidateNotJoined($year = null, $export = null)
    {

        $this->sessionYear = $year ? $year : $this->sessionYear;

        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;

        //echo '<pre>';print_r($user);exit;
        $query = Avedan::join('allocations', 'allocations.application_id', '=', 'avedans.id')
            ->join('institutes', 'institutes.id', '=', 'allocations.institute_id');

        if ($user_type == 'District Officer') { //CVO


            $query->where('avedans.district_id', '=', $districtID)
                ->where('avedans.join_status', '=', 0);
        } else {

            $query->where('avedans.join_status', '=', 0);
        }


        //echo '<pre>';print_r($results);exit;
        $heading = 'अभ्यार्थी जिन्होंने संस्थान को अभी तक जॉइन नहीं किया है';

        if ($export !== null) {
            $datas = $query->with('district')->orderBy('avedans.id', 'DESC')->get();
            $data = $datas->map(function ($item) {
                $high_percentage    = $item->high_percentage;
                $high_school_calculation = round(($high_percentage*8)/10);
                $inter_percentage   = $item->inter_percentage;
                $inter_calculation  = round(($inter_percentage*2)/10);
                $topper_number      = $high_school_calculation + $inter_calculation;

                return [
                    'applicationNumber' => $item->applicationNumber,
                    'applicant_name' => $item->applicant_name,
                    'fname' => $item->fname,
                    'mother' => $item->mother,
                    'gender' => $item->gender,
                    'mobile' => $item->mobile,
                    'email' => $item->email,
                    'category' => $item->category,
                    'districts' => $item->district->name_hindi,
                    'tehsil' => $item->tehsil,
                    'post_office' => $item->post_office,
                    'gram_panchayat_name' => $item->gram_panchayat_name,
                    'vikas_khand' => $item->vikas_khand,
                    'letter_address' => $item->letter_address,
                    'high_marks' => $item->high_marks,
                    'high_total_marks' => $item->high_total_marks,
                    'high_percentage' => $item->high_percentage,
                    'inter_marks' => $item->inter_marks,
                    'inter_total_marks' => $item->inter_total_marks,
                    'inter_percentage' => $item->inter_percentage,
                    'topper_number' => $topper_number,
                ];
            });
            return \Excel::download(new ExportAvedan($data), 'candidate-not-joined-list.xlsx');
        } else {
            $results = $query->whereYear('avedans.created_at', $this->sessionYear)->orderBy('id', 'DESC')->get(['avedans.*', 'allocations.application_id', 'institutes.name AS Intitute_name']);
            return view('candidateNotJoined', compact('results', 'heading'))->with('routeName', 'candidateNotJoined');
        }
    }

    public function documentVerification($year = null, $export = null)
    {
        $user = auth()->user();
        $user_type = $user->user_type;
        $districtID = auth()->user()->district_id;
        $this->sessionYear = $year ? $year : $this->sessionYear;

        if ($user_type == 'District Officer') { //CVO only

            $results = Avedan::where('is_approved', '=', 1)->with('district')
                ->where('district_id', '=', $districtID)
                ->whereNotIn('id', DB::table('verificationcomments')->pluck('application_id'))
                ->whereYear('created_at', $this->sessionYear)
                ->orderBy('topper_number', 'DESC')
                ->get();
        } else {

            return redirect('/dashboard')->with('success', 'YOU ARE NOT ALLOWED TO ACCESS THIS PAGE!');
        }

        $heading = 'डॉक्युमेंट वेरिफिकेशन के लिए अभ्यर्थियों की सूची';

        if ($export !== null) {
            $data = $results->map(function ($item) {
                $high_percentage    = $item->high_percentage;
                $high_school_calculation = round(($high_percentage*8)/10);
                $inter_percentage   = $item->inter_percentage;
                $inter_calculation  = round(($inter_percentage*2)/10);
                $topper_number      = $high_school_calculation + $inter_calculation;

                    return [
                        'applicationNumber' => $item->applicationNumber,
                        'applicant_name' => $item->applicant_name,
                        'fname' => $item->fname,
                        'mother' => $item->mother,
                        'gender' => $item->gender,
                        'mobile' => $item->mobile,
                        'email' => $item->email,
                        'category' => $item->category,
                        'districts' => $item->district->name_hindi,
                        'tehsil' => $item->tehsil,
                        'post_office' => $item->post_office,
                        'gram_panchayat_name' => $item->gram_panchayat_name,
                        'vikas_khand' => $item->vikas_khand,
                        'letter_address' => $item->letter_address,
                        'high_marks' => $item->high_marks,
                        'high_total_marks' => $item->high_total_marks,
                        'high_percentage' => $item->high_percentage,
                        'inter_marks' => $item->inter_marks,
                        'inter_total_marks' => $item->inter_total_marks,
                        'inter_percentage' => $item->inter_percentage,
                        'topper_number' => $topper_number,
                    ];
                });
            return \Excel::download(new ExportAvedan($data), 'document-verification.xlsx');
        } else {
            return view('verification', compact('results', 'heading'))->with('routeName', 'documentVerification');
        }
    }

    public function saveDocumnetVerification(Request $request)
    {
        $comments = "डॉक्यूमेंट वेरिफिकेशन के लिए सभी ज़रूरी डॉक्युमेंट के साथ आपको " . $_POST['date'] . " को " . $_POST['hour'] . ":" . $_POST['minute'] . " " . $_POST['ampm'] . " पर आना है |";

        $time = "" . $_POST['hour'] . ":" . $_POST['minute'] . " " . $_POST['ampm'] . "";


        for ($i = 0; $i < count($_POST['application_id']); $i++) {
            DB::table('verificationcomments')->insert([
                'application_id' => $_POST['application_id'][$i],
                'comments' => $comments,
                'date' => \Carbon\Carbon::parse($request->get('date'))->format('Y-m-d'),
                'time' => $time,
                'time' => $time,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),

            ]);
        }

        return redirect('/document-verification')->with('success', 'Date schedule send & save successfully!');
    }

    public function getVikaskhand(Request $request)
    {
        $this->sessionYear = ($request->sessionYear)?$request->sessionYear: date('Y');
        $vikasKhand = Avedan::where('district_id', $request->districtId)->distinct()->pluck('vikas_khand');
        return response()->json(["data" => $vikasKhand]);
    }


    public function totalsessionlist(Request $request){
        $results =  MaitriSessionRecord::orderBy('id','DESC')->paginate(50);
        return view('session-records', compact('results'));
    }
}
