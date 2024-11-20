<?php

namespace App\Imports;
use DB;
use App\Models\CVOOfficers;
use App\Models\Institute;
use App\Models\Tehsil;
use App\Models\Blockslist;
use App\Models\DistrictMapData;
use App\Models\Districts;
use App\Models\Divisions;
use App\Models\Hospitals; 
use App\Models\NewAiceter;
use App\Models\AIcenters;
use App\Models\Maitri;
use App\Models\Cliniclocation;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Helpers\TranslateTextHelper;

class ImportAicenter implements ToModel
{
    public function model(array $row) {
        set_time_limit(300);
    
        if ($row[0]) {
         
            $district_eng       = $this->detectLanguage($row[0]) === 'English' ? $row[0] : $this->hinditoenglish($row[0]);
            $district_hindi     = $this->detectLanguage($row[0]) === 'English' ? $this->engtohindi($row[0]) : $row[0];
            $tehsil_eng         = $this->detectLanguage($row[1]) === 'English' ? $row[1] : $this->hinditoenglish($row[1]);
            $tehsil_hindi       = $this->detectLanguage($row[1]) === 'English' ? $this->engtohindi($row[1]) : $row[1];
            $block_eng          = $this->detectLanguage($row[2]) === 'English' ? $row[2] : $this->hinditoenglish($row[2]);
            $block_hindi        = $this->detectLanguage($row[2]) === 'English' ? $this->engtohindi($row[2]) : $row[2];
            $aicenter_eng       = $this->detectLanguage($row[3]) === 'English' ? $row[3] : $this->hinditoenglish($row[3]);
            $aicenter_hindi     = $this->detectLanguage($row[3]) === 'English' ? $this->engtohindi($row[3]) : $row[3];

            $associated_maitri_name     = $row[4];
            $bharat_pashudhan_id        = $row[5];
            $maitri_mobilen_no          = $row[6];
            $latitude                   = $row[7];
            $longitude                  = $row[8];

            if($latitude != '' && $longitude != '' && $aicenter_eng != '' && $aicenter_hindi != ''){
                $getDistrict    = Districts::where('name_eng', 'LIKE', '%'.$district_eng.'%')->first();
                if($getDistrict){
                    $district_id    = $getDistrict['id'];
                    $division_id    = $getDistrict['division_id'];
                    $getDivision    = Divisions::where('id', $division_id)->first();
                    $zone_id        = $getDivision['zone_id'];
            
                    // $checkData = NewAiceter::where([
                    //     'district_eng'                      => $district_eng,
                    //     'district_hindi'                    => $district_hindi,
                    //     'tehsil_eng'                        => $tehsil_eng,
                    //     'tehsil_hindi'                      => $tehsil_hindi,
                    //     'block_eng'                         => $block_eng,
                    //     'block_hindi'                       => $block_hindi,
                    //     'ai_center_eng'                     => $aicenter_eng,
                    //     'ai_center_hindi'                   => $aicenter_hindi,
                    // ])->first();

                    // if ($checkData) {
                    //     $checkData->update([
                    //         'latitude'  => $latitude,
                    //         'longitude' => $longitude,
                    //     ]);
                    // } else {
                        NewAiceter::create([
                            'zone_id'                           => $zone_id,
                            'division_id'                       => $division_id,
                            'district_id'                       => $district_id,
                            'district_eng'                      => $district_eng,
                            'district_hindi'                    => $district_hindi,
                            'tehsil_eng'                        => $tehsil_eng,
                            'tehsil_hindi'                      => $tehsil_hindi,
                            'block_eng'                         => $block_eng,
                            'block_hindi'                       => $block_hindi,
                            'ai_center_eng'                     => $aicenter_eng,
                            'ai_center_hindi'                   => $aicenter_hindi,
                            'maitri_associated_aiCenter'        => $associated_maitri_name,
                            'bharat_pashudhan_id'               => $bharat_pashudhan_id,
                            'maitri_mobile_no'                  => $maitri_mobilen_no,
                            'latitude'                          => $latitude,
                            'longitude'                         => $longitude,
                        ]);
                    // }
                }
            }
        }
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
    

    function changeText($val){
        $arr=array(
            'text'      => $val,
            'format'    => 'json',
            'to_font'   => 'mangal'
        );
        
        if($val!=null){
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://localhost:4000/api/unicode-krutidev',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>json_encode($arr),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $response=json_decode($response,true);
          
            if(isset($response['data'])){
                return $response['data']['output_text'];
            } else {
                return '';
            }
        } else {
            return '';
        }
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
}


// https://github.com/ErParmod/hindi-font-converter