<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\API\Servicerequest;
use App\Models\FarmerUser;
use App\Models\Maitri;
use App\Models\Districts;
use Illuminate\Http\Request;

class AdminServiceRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = Servicerequest::with(['user', 'maitri', 'feedback'])
            ->orderBy('id', 'desc');

        if ($request->filled('district_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('district_id', $request->district_id);
            });
        }

        if ($request->filled('maitri_id')) {
            $query->where('maitri_id', $request->maitri_id);
        }

        if ($request->filled('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->filled('feedback') && $request->feedback !== '') {
            if ($request->feedback == 'yes') {
                $query->whereHas('feedback');
            } elseif ($request->feedback == 'no') {
                $query->whereDoesntHave('feedback');
            }
        }

        if ($request->filled('service_name') && $request->service_name !== '') {
            $query->where('service_name', $request->service_name);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('MobileNumber', 'like', "%{$search}%")
                  ->orWhere('FirstName', 'like', "%{$search}%");
            });
        }

        $results = $query->paginate(20)->appends($request->query());

        $districts = Districts::select('id', 'name_hindi', 'name_eng')->orderBy('name_hindi')->get();
        $maitries  = Maitri::select('id', 'maitri_name', 'maitri_mobile_no')->where('status',0)->orderBy('id','desc')->get();

        $services = [
            'health_medical_checkip'  => 'स्वास्थ्य/चिकित्सा जांच',
            'animal_insurance'        => 'पशु बीमा',
            'vaccination'             => 'टीकाकरण',
            'pregnancy_diagnosis'     => 'गर्भावस्था निदान',
            'artificial_insemination' => 'कृत्रिम गर्भाधान',
            'livestock_insurance'     => 'पशुधन बीमा',
            'calving'                 => 'बछड़ा जनन',
            'frozen_semen_ai'         => 'फ्रोज़न सीमेन कृत्रिम गर्भाधान',
            'sex_semen_ai'         => 'सेक्स सॉर्टेड सीमेन कृत्रिम गर्भाधान',
            'ivf_embryo'         => 'आई.वी.एफ. भ्रूण',
        ];

        // Status list
        $statuses = [
            0 => 'स्वीकार',
            1 => 'नया',
            2 => 'इंतज़ार',
            3 => 'अस्वीकार',
        ];

        return view('admin.service-request.service-request-list', compact(
            'results', 'districts', 'maitries', 'services', 'statuses'
        ));
    }
}