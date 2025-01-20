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
use App\Models\Newcliniclocation; 
use App\Models\Latestaicenter; 
use App\Models\Manganurodhdata;
use App\Models\NewAiceter;
use App\Models\AIcenters;
use App\Models\Maitri;
use App\Models\Cliniclocation;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Helpers\TranslateTextHelper;

class ImportMaitri implements ToModel
{
    public function model(array $row)
    {
        // if(is_numeric($row[0])){
        //     $maitri=new Maitri();
        //     $maitri->mandal_name=$row[1];
        //     $maitri->janpad_name=$row[2];
        //     $maitri->maitri_name=$row[3];
        //     $maitri->maitri_mobile_no=$row[4];
        //     $maitri->gram_panchayat=$row[5];
        //     $maitri->post_office=$row[6];
        //     $maitri->block=$row[7];
        //     $maitri->tehsil=$row[8];
        //     $maitri->adhaar_card=$row[9];
        //     $maitri->father_name=$row[10];
        //     $maitri->father_mobile_no=$row[11];
        //     $maitri->certificate_no=$row[12];
        //     $maitri->center_name=$row[13];
        //     $maitri->pass_date=$row[14];
        //     $maitri->expiry_date=$row[15];
        //     $maitri->any_bharat_id=$row[16];
        //     $maitri->equipment_received=$row[17];
        //     $maitri->longitude=str_replace('-','.',$row[18]);
        //     $maitri->latitude=str_replace('-','.',$row[19]);
        //     $maitri->save(); 
        // }

        if($row[0]){

            // echo '<pre>';print_r($row);exit;

            $janpad_name        = $row[0];
            $maitri_name        = $row[1];
            $maitri_no          = $row[2];
            $gram_panchayat     = $row[3];
            $post_office        = $row[4];
            $block              = $row[5];
            $tehsil             = $row[6];
            $adhar_no           = $row[7];
            $father_name        = $row[8];
            $father_mob_no      = $row[9];
            $certificate_no     = $row[10];
            $center_name        = $row[11];
            $pass_date          = $row[12];
            $expiry_date        = $row[13];
            $bharat_id          = $row[14];
            $latitude           = $row[17];
            $longitute          = $row[16];
            $mandal_name        = $row[18];
            
            Maitri::create([
                'mandal_name'       => $mandal_name,
                'janpad_name'       => $janpad_name,
                'maitri_name'       => $maitri_name,
                'maitri_mobile_no'  => $maitri_no,
                'gram_panchayat'    => $gram_panchayat,
                'post_office'       => $post_office,
                'block'             => $block,
                'tehsil'            => $tehsil,
                'adhaar_card'       => $adhar_no,
                'father_name'       => $father_name,
                'father_mobile_no'  => $father_mob_no,
                'certificate_no'    => $certificate_no,
                'center_name'       => $center_name,
                'pass_date'         => $pass_date,
                'expiry_date'       => $expiry_date,
                'any_bharat_id'     => $bharat_id,
                'latitude'          => $latitude,
                'longitude'         => $longitute,
            ]);
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