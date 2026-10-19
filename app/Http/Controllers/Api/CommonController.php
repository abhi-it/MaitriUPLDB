<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ServiceHelper;
use App\Http\Controllers\Controller;
use App\Models\Districts;
use App\Models\Divisions;
use App\Models\Institute;
use App\Models\Manganurodhdata;
use App\Traits\V2\FormatResponseTraitV2;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    use FormatResponseTraitV2;

    public function getMandal(Request $request) {
        $getMandal  = Divisions::get();
        return $this->successResponse('Get all mandal successfully!',200,$getMandal);
    }

    public function getDistrict(Request $request)
    {
        $mandal_name = $request->mandal_name;
        if($mandal_name) {
            $mandalId = Divisions::where('name_hindi', 'LIKE', $mandal_name)->first();
            if($mandalId['id']) {
                $getAllDistrict = Districts::select('id','name_hindi as janpad_name')->where('division_id', $mandalId['id'])->get();
            } else {
                $getAllDistrict = Districts::select('id','name_hindi as janpad_name')->get();
            }
        } else {
            $getAllDistrict = Districts::select('id','name_hindi as janpad_name')->get();
        }
        return $this->successResponse('Get all district successfully!',200,$getAllDistrict);
    }

    public function getTehsilAll(Request $request){
        $mandal_name = $request->mandal_name;
        $janpad_name = $request->janpad_name;
        $getTeshil =  Manganurodhdata::select('tehsil')
                        ->where('mandal_name', 'LIKE', $mandal_name)
                        ->where('janpad_name', 'LIKE', $janpad_name)
                        ->where('status', 0)
                        ->groupBy('tehsil')
                        ->get();
        return $this->successResponse('Get all tehsil successfully!',200,$getTeshil);
    }

    public function getBlockAll(Request $request){
        $tehsil = $request->tehsil;
        $mandal_name = $request->mandal_name;
        $janpad_name = $request->janpad_name;
        $getBlock =  Manganurodhdata::select('block')
                        ->where('mandal_name', 'LIKE', $mandal_name)
                        ->where('janpad_name', 'LIKE', $janpad_name)
                        ->where('tehsil', 'LIKE', $tehsil)
                        ->where('status', 0)
                        ->groupBy('block')
                        ->get();
        return $this->successResponse('Get all blocks successfully!',200,$getBlock);
    }

    public function getAiCenterAll(Request $request){
        $block = $request->block;
        $tehsil = $request->tehsil;
        $mandal = $request->mandal;
        $janpad = $request->janpad;
        $getAIcenter =  Manganurodhdata::select('center_name')
                        ->where('mandal_name', 'LIKE', $mandal)
                        ->where('janpad_name', 'LIKE', $janpad)
                        ->where('tehsil', 'LIKE', $tehsil)
                        ->where('block', 'LIKE', $block)
                        ->where('status', 0)
                        ->groupBy('center_name')
                        ->get();
        return $this->successResponse('Get all ai center successfully!', 200, $getAIcenter);
    }

    public function getInsitute(Request $request){ 
        $institute  = Institute::select('id','name','name_en')->get();
        return $this->successResponse('Get institute list successfully!', 200, $institute);
    }

    public function getSemenData(Request $request){
        return $this->successResponse('Get semen data successfully!', 200, [
            'species_semen'  => ServiceHelper::getSpeciesSemenOptions(),
            'semen_type'     => ServiceHelper::getSemenTypeOptions(),
            'semen_source'   => ServiceHelper::getSemenSourceOptions(),
            'complaints'     => ServiceHelper::getAnyComplaintOptions(),
            'service_status' => ServiceHelper::getStatusOptions(),
        ]);
    }

    public function getAboutUs()
    {
        return $this->successResponse('About Us data fetched successfully!', 200, ["about_us" => ServiceHelper::getAboutUsContent()]);
    }

    public function getTermsAndConditions()
    {
        return $this->successResponse('Terms and Conditions fetched successfully!', 200, [
            'terms_and_conditions' => ServiceHelper::getTermsAndConditions(),
        ]);
    }

    public function tutorials(){
        $data = [
            'livestock' => [
                [
                    'title' => 'Breedable Indigenous Cattle',
                    'number' => '5,870,793',
                ],
                [
                    'title' => 'Breedable Exotic and Crossbred Cattle',
                    'number' => '3,065,354',
                ],
                [
                    'title' => 'Total Cattle',
                    'number' => '8,936,147',
                ],
                [
                    'title' => 'Breedable Buffalo',
                    'number' => '15,311,970',
                ],
                [
                    'title' => 'Total Breedable Bovine Population',
                    'number' => '24,248,117',
                ],

            ],
            'edgeFarming'   => [
                [
                    'image'         => 'https://maitriupldb.in/assets/images/bull-1.jpg',
                    'title'         => 'राष्ट्रीय गोजातीय प्रजनन परियोजना',
                    'discription'   => 'राज्य के सभी प्रजनन योग्य मवेशियों को कृत्रिम गर्भाधान कार्यक्रम के माध्यम से कवर करने के इरादे से, जमे हुए सीमेन का उपयोग करते हुए, भारत सरकार राष्ट्रीय गोजातीय प्रजनन परियोजना को प्रायोजित कर रही है।'
                ],
                [
                    'image'         => 'https://maitriupldb.in/assets/images/goat.jpg',
                    'title'         => 'बकरी प्रजनन केंद्र',
                    'discription'   => 'उत्तर प्रदेश में बकरियों की आबादी का बड़ा हिस्सा जमुनापारी नस्ल का है और यह राज्य की कृषि-जलवायु परिस्थितियों के अनुकूल है। विविधीकरण कार्यक्रम के एक भाग के रूप में, बोर्ड...'
                ],
                [
                    'image'         => 'https://maitriupldb.in/assets/images/foodder.jpg',
                    'title'         => 'NATIONAL PROJECT FOR BOVINE BREEDING',
                    'discription'   => 'आर्थिक रूप से किफायती डेयरी फार्मिंग में उचित आहार के महत्व पर अधिक जोर देने की आवश्यकता नहीं है। बोर्ड ने शुरू से ही चारा विकास को सबसे महत्वपूर्ण गतिविधियों में से एक के रूप में लिया था।'
                ],
                [
                    'image'         => 'https://maitriupldb.in/assets/images/frozensemen.jpg',
                    'title'         => 'हिमीकृत सीमेन प्रबंधन',
                    'discription'   => 'राज्य ने गाय प्रजनन के लिए इनपुट प्रदान करने के लिए तीन स्तरीय कृत्रिम गर्भाधान (ए.आई.) प्रबंधन प्रणाली विकसित की है, जिसमें बैल स्टेशन, क्षेत्रीय सीमेन बैंक (आरएसबी) और कृत्रिम गर्भाधान केंद्र शामिल हैं।'
                ],
                [
                    'image'         => 'https://maitriupldb.in/assets/images/cow.jpg',
                    'title'         => 'सायर चयन कार्यक्रम',
                    'discription'   => 'अगली पीढ़ी के लिए सबसे उपयुक्त सांडों की पहचान करने के लिए, यूपीएलडीबी ने क्षेत्र संतान-परीक्षण कार्यक्रम शुरू किया, जिसमें दो बुनियादी कार्य शामिल थे।'
                ],
                [
                    'image'         => 'https://maitriupldb.in/assets/images/embryo.jpg',
                    'title'         => 'भ्रूण स्थानांतरण कार्यक्रम',
                    'discription'   => 'बेहतर नस्ल के सांडों के उत्पादन के लिए मल्टीपल ओवुलेशन एम्ब्रियो ट्रांसफर (एमओईटी) की शुरुआत की गई। इस तकनीक के तहत, बेहतरीन गायों की आनुवंशिक गुणवत्ता का उपयोग अगली पीढ़ी के सांडों के उत्पादन के लिए किया जाता है।'
                ]
            ],
            'cattleBuffalo' => [
                'cattle' => [
                    [
                        'title' => 'स्वदेशी',
                        'image' => 'https://maitriupldb.in/cattleBuffalo/1.avif'
                    ],
                    [
                        'title' => 'गंगातिरी',
                        'image' => 'https://maitriupldb.in/cattleBuffalo/2.avif'
                    ],
                    [
                        'title' => 'गिर',
                        'image' => 'https://maitriupldb.in/cattleBuffalo/3.avif'
                    ],
                    [
                        'title' => 'थारपारकर',
                        'image' => 'https://maitriupldb.in/cattleBuffalo/4.avif'
                    ],
                    [
                        'title' => 'केनकाथा',
                        'image' => 'https://maitriupldb.in/cattleBuffalo/5.avif'
                    ],
                    [
                        'title' => 'केरीगढ़',
                        'image' => 'https://maitriupldb.in/cattleBuffalo/6.avif'
                    ],
                    [
                        'title' => 'मेवाती',
                        'image' => 'https://maitriupldb.in/cattleBuffalo/7.avif'
                    ],
                    [
                        'title' => 'पोंवार',
                        'image' => 'https://maitriupldb.in/cattleBuffalo/8.avif'
                    ],

                ],
                'buffalo' => [
                    [
                        'title' => 'भदावारी',
                        'image' => 'https://maitriupldb.in/cattleBuffalo/b1.avif'
                    ],
                    [
                        'title' => 'मुर्राह',
                        'image' => 'https://maitriupldb.in/cattleBuffalo/b2.avif'
                    ],
                ]


            ]
        ];
        return $this->successResponse('get Tutorials',200, $data);
    }
}
