<?php

namespace App\Imports;
use App\Models\CVOOfficers;
use App\Models\Institute;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Helpers\TranslateTextHelper;
class ImportOfficers implements ToModel
{
    public function model(array $row)
    {
        $checkdata = '';
        set_time_limit(300);
        if (isset($row[4])){
            $checkdata =  CVOOfficers::where(['mobile_no'=>$row[4]])->first();
        }
        if(empty($checkdata)){
            if(is_numeric($row[0])){
                // echo "<pre>"; print_r($this->engtohindi($row[1])); echo "</pre>"; exit;
                $importBy_user_id = Auth::user()->id;
                $officer=new CVOOfficers();
                $officer->mandal_name='औरैया';
                $officer->janpad_name=$this->changeText($row[1]);
                $officer->login_id='';//$row[6];
                $officer->officer_name=$this->changeText($row[2]);
                $officer->designation=$this->changeText($row[3]);
                $officer->animal_care_center=$this->changeText($row[4]);
                $officer->mobile_no='';//$row[4];
                $officer->longitute =isset($row[5])?str_replace('-','.',$row[5]):'';
                $officer->lattitute =isset($row[6])?str_replace('-','.',$row[6]):'';
                $officer->save(); 
            }
         }
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
            CURLOPT_URL => 'https://hindi-font-converter.vercel.app/api/unicode-krutidev',
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
}


// https://github.com/ErParmod/hindi-font-converter