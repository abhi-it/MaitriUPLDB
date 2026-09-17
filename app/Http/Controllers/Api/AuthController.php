<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use TokenInvalidException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\FarmerUser;
use App\Models\API\Servicerequest;
use App\Traits\FormatResponseTrait;
use App\Models\Animalinformation;

class AuthController extends Controller
{
    use FormatResponseTrait;

    public function login(Request $request){
        try {
            $request->validate([
                'mobileNumber' => 'required',
            ]);
            $maitri = User::where('MobileNumber', $request->mobileNumber)->first();
            $farmer = FarmerUser::where('MobileNumber', $request->mobileNumber)->first();
            if ($farmer) {
                $otp = rand(10000, 99999);
                $farmer->otp_login = $otp;
                $number = $request->mobileNumber;

                if($otp){
                    $this->sendMobileMessage($number, $otp);
                    $farmer->save();
                    return $this->successResponse('OTP generated successfully',200, $otp);
                }
            } else if($maitri) {
                $otp = rand(10000, 99999);
                $maitri->otp_login = $otp;
                $number = $request->mobileNumber;

                if($otp){
                    $this->sendMobileMessage($number, $otp);
                    $maitri->save();
                    return $this->successResponse('OTP generated successfully',200, $otp);
                }
            } else {
                $farmerRegister  = new FarmerUser([
                    'MobileNumber'   => $request->mobileNumber,
                    'role_id'        => '4',
                    'role'           => 'Farmer',
                    'user_type'      => 'Farmer',
                ]);
                $registerFarmer = $farmerRegister->save();
                if($registerFarmer){
                    $number = $request->mobileNumber;
                    $userId = $farmerRegister->id;
                    $farmerData = FarmerUser::where('id', $userId)->first();
                    if($farmerData){
                        $otp = rand(10000, 99999);
                        $farmerData->otp_login = $otp;
                        $this->sendMobileMessage($number, $otp);
                        $farmerData->save();
                        return $this->successResponse('Farmer Register OTP send successfully',200, $otp);
                    }
                }else{
                    return $this->errorResponse('Number  not correct',200);
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function otpVerify(Request $request){
        try {

            $request->validate([
                'mobileNumber' => 'required',
                'otp' => 'required|numeric|digits:5',
            ]);
            $farmer = FarmerUser::where('MobileNumber', $request->mobileNumber)->where('otp_login', $request->otp)->first();
            $mairti = User::where('MobileNumber', $request->mobileNumber)->where('otp_login', $request->otp)->first();
            if ($farmer) {
                $token = JWTAuth::fromUser($farmer);
                $isFilled = !empty($farmer->name) && !empty($farmer->gender) && !empty($farmer->pincode) && !empty($farmer->MobileNumber) && !empty($farmer->post_office) && !empty($farmer->block) && !empty($farmer->tehsil);
                $check_profile = $isFilled ? 'completed' : 'not_completed';
                $checkAnimal = Animalinformation::where('user_id', $farmer->id)->get();
                $status = ($checkAnimal->count() > 0) ? 'completed' : 'not_completed';
                $farmer['checkAnimal'] = $status;
                $farmer['profileDone'] = $check_profile;
                $data = [
                    'token'     => $token,
                    'user'      => $farmer,
                ];
                return $this->successResponse('OTP verified successfully',200, $data);
            } else if($mairti){
                $token = JWTAuth::fromUser($mairti);
                $isFilled = !empty($mairti->name) && !empty($mairti->email) && !empty($mairti->gender) && !empty($mairti->pincode) && !empty($mairti->MobileNumber) && !empty($mairti->post_office) && !empty($mairti->block) && !empty($mairti->tehsil);
                $check_profile = $isFilled ? 'completed' : 'not_completed';
                $mairti['profileDone'] = $check_profile;
                $data = [
                    'token'     => $token,
                    'user'      => $mairti,
                ];
                return $this->successResponse('OTP verified successfully',200, $data);
            } else {
                return $this->errorResponse('Invalid OTP', 400);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function sendMobileMessage($number, $otp){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://otpmsg.in/api/mt/SendSMS?apikey=b7f2ac82d29a4417b324b6ad1bddcbf9&senderid=UPLDBL&channel=Trans&DCS=0&flashsms=1&number='.$number.'&text=OTP%20for%20Login%20in%20Maitri%20app%20'.$otp.'%20If%20not%20requested%20by%20you%2C%20please%20contact%20your%20request%20maitriupldb.in%20UPLDB&route=18',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /**
     * Farmer login with email + password (matches web maitriFarmerLogin for farmers).
     */
    public function farmerLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(ucfirst($validator->errors()->first()), 422);
            }

            $farmer = FarmerUser::where('email', $request->email)->first();

            if (!$farmer || !Hash::check($request->password, $farmer->password)) {
                return $this->errorResponse('Invalid email or password', 401);
            }

            Auth::shouldUse('farmer_api');
            $token = JWTAuth::fromUser($farmer);

            $isFilled = !empty($farmer->name)
                && !empty($farmer->gender)
                && !empty($farmer->pincode)
                && !empty($farmer->MobileNumber)
                && !empty($farmer->post_office)
                && !empty($farmer->block)
                && !empty($farmer->tehsil);

            $checkAnimal = Animalinformation::where('user_id', $farmer->id)->count();
            $farmer->load(['district', 'getAnimalInformation']);
            $farmer['profileDone'] = $isFilled ? 'completed' : 'not_completed';
            $farmer['checkAnimal'] = $checkAnimal > 0 ? 'completed' : 'not_completed';

            return $this->successResponse('Farmer login successful', 200, [
                'token' => $token,
                'token_type' => 'bearer',
                'user' => $farmer,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return $this->successResponse('Successfully logged out.', 200);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->errorResponse('The token is invalid.', 403);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->errorResponse('The token has already expired.', 403);
        } catch (JWTException $e) {
            return $this->errorResponse($e->getMessage(), 403);
        }
    }

    public function tutorials(){
        $data = [
            'livestock'     => [
                [
                    'title' => 'Exotic & Crossbred Cattle',
                    'number' => '6,122,628',
                ],
                [
                    'title' => 'Indigenous Cattle',
                    'number' => '12,897,013',
                ],
                [
                    'title' => 'Buffalo',
                    'number' => '33,016,785',
                ],
                [
                    'title' => 'Goat',
                    'number' => '14,480,025',
                ],
                [
                    'title' => 'Horse',
                    'number' => '104,000',
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
                    'discription'   => 'राज्य के सभी प्रजनन योग्य मवेशियों को कृत्रिम गर्भाधान कार्यक्रम के माध्यम से कवर करने के इरादे से, जमे हुए सीमेन का उपयोग करते हुए, भारत सरकार राष्ट्रीय गोजातीय प्रजनन परियोजना को प्रायोजित कर रही है।'
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
