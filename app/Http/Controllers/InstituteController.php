<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use Illuminate\Http\Request;
use File;
use Carbon\Carbon;
use App\Models\Districts;
use App\Models\Avedan;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportAvedan;

class InstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Institute::orderBy('id', 'desc')->get();
        //echo '<pre>';print_r($results);exit;
        return view('institute.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('institute.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
        ]);

        $data = new Institute([
            'name' => $request->get('name'),
			'mobile' => $request->get('mobile'),
			'email' => $request->get('email'),
			'address' => $request->get('address'),
        ]);
        $data->save();
        return redirect('/institute')->with('success', 'data saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function show(Institute $institute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function edit(Institute $institute)
    {
        $data = $institute;

        return view('institute.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Institute $institute)
    {
        $request->validate([
            'name'=>'required',
        ]);

		$institute->name =  $request->get('name');
		$institute->mobile =  $request->get('mobile');
		$institute->email =  $request->get('email');
		$institute->address =  $request->get('address');
		$institute->lattitute =  $request->get('lattitude');
		$institute->longitute =  $request->get('longitude');
        $institute->save();
        return redirect('/institute')->with('success', 'data updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Institute $institute)
    {
        //
    }

    public function allocation()
    {
		$districts = Districts::where('status', '=', 1)->orderBy('name_eng', 'ASC')->get();
		$results = Institute::orderBy('id', 'desc')->get();
        return view('institute.allocation', compact('districts', 'results'));
    }

    /*-----------Allocate Avedan for Institute-----------------------------*/

    public function getAvedanData()
    {

		if($_GET['category']==1){
		$heading = 'जनरल/ओ बी सी मेरिट सूची (स्क्रीनिंग)';
		$results = Avedan::where ('is_approved', '=', 4)
		->whereIn('category', ["जनरल", "ओ बी सी"])
		->where('district_id', '=', $_GET['district_id'])
		->orderBy('topper_number', 'DESC')
		->get();
		}else if($_GET['category']==2){

			$heading = 'एस. सी./एस. टी. मेरिट सूची (स्क्रीनिंग)';
			$results = Avedan::where ('is_approved', '=', 4)
			->whereIn('category', ["एस सी"])
			->where('district_id', '=', $_GET['district_id'])
			->orderBy('topper_number', 'DESC')
			->get();
		}else {

			$heading = 'एस. सी./एस. टी. मेरिट सूची (स्क्रीनिंग)';
			$results = Avedan::where ('is_approved', '=', 4)
			->whereIn('category', ["एस टी"])
			->where('district_id', '=', $_GET['district_id'])
			->orderBy('topper_number', 'DESC')
			->get();
		}

		/*----------Start getting already allocated candidates------------------------*/
		$data = Avedan::join('allocations', 'allocations.application_id', '=', 'avedans.id')
							   ->where('allocations.district_id', '=', @$_GET['district_id'])
							   ->where('allocations.category', '=', @$_GET['category'])
							   ->where('allocations.institute_id', '=', @$_GET['institute_id'])
							   ->get(['allocations.application_id']);
		/*----------End getting already allocated candidates------------------------*/


		$allocateData = array();

		foreach($data as $row){

			$allocateData[] = $row->application_id;
		}


		$view = view("institute.render",compact('results', 'allocateData'))->render();
		echo $view;

	}

	public function saveAllocation()
    {
		//echo '<pre>';print_r($_POST);exit;

		DB::table('allocations')
		->where('institute_id', $_POST['institute_id'])
		->where('district_id', $_POST['district_id'])
		->where('category', $_POST['category'])
		->delete();

		for($i=0; $i<count($_POST['application_id']); $i++)
		{
			DB::table('allocations')->insert([
			'application_id' => $_POST['application_id'][$i],
			'institute_id' => $_POST['institute_id'],
			'district_id' => $_POST['district_id'],
			'category' => $_POST['category'],
			'institute_user_id' => 1,

			]);
		}
		return redirect('/allocation-list')->with('success', 'Allocation added successfully!');


	}

	public function allocationList(Request $request, $export = null)
    {
		$districts = Districts::where('status', '=', 1)->orderBy('name_eng', 'ASC')->get();
		$institute = Institute::orderBy('id', 'desc')->get();

		$results = array();

		if(count($_GET)>=1)
		{
		    $query = Avedan::join('allocations', 'allocations.application_id', '=', 'avedans.id');

			if($request->input('category')!='')
			{

				if(!empty($request->input('category'))){
					$query->where(function ($q) use ($request) {

						$q->where('allocations.category', '=', $request->input('category'));
						//echo $request->input('category');exit;
					});
				}
			}

			if($request->input('district_id')!='')
			{

				if(!empty($request->input('district_id'))){
					$query->where(function ($q) use ($request) {

						$q->where('allocations.district_id', '=', $request->input('district_id'));
					});
				}
			}

			if($request->input('institute_id')!='')
			{

				if(!empty($request->input('institute_id'))){
					$query->where(function ($q) use ($request) {

						$q->where('allocations.institute_id', '=', $request->input('institute_id'));
					});
				}
			}

			// $results = $query->get(['avedans.*', 'allocations.application_id']);
		}

		//echo '<pre>';print_r($results);exit;

        if ($export !== null) {
            $data = collect();
            if(count($_GET)>=1) {
                $data = $query->select('applicationNumber','applicant_name','fname','mother','gender','mobile','email','high_percentage','inter_percentage','category','letter_address')->get();
            }
		    return \Excel::download(new ExportAvedan($data), 'allocation-list.xlsx');
        } else {
            if(count($_GET)>=1) {
                $results = $query->get(['avedans.*', 'allocations.application_id']);
            }
		    return view('institute.allocationList', compact('districts', 'institute', 'results'))->with('routeName', 'allocationList');
        }


        // return view('institute.allocationList', compact('districts', 'institute', 'results'));


	}


}