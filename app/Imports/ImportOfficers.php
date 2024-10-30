<?php

namespace App\Imports;
use DB;
use App\Models\CVOOfficers;
use App\Models\Institute;
use App\Models\Tehsil;
use App\Models\Blockslist;
use App\Models\Hospitals;
use App\Models\AIcenters;
use App\Models\Maitri;
use App\Models\Cliniclocation;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Helpers\TranslateTextHelper;
class ImportOfficers implements ToModel
{
    public function model(array $row)
    {
        set_time_limit(300);
      
        if ($row[0]){
            $mandal_name = $row[0];
            $janpad_name = $row[1];
            $type = $row[3];
            $aiCenterNameHindi = $row[2];
            $aiCenterNameEng = $row[4];

            if($aiCenterNameHindi){
                $aiCenter = $this->changeText($aiCenterNameHindi);;
            }else{
                $aiCenter = $this->engtohindi($aiCenterNameEng);
            }
            

            // $name   =    $this->changeText($row[5]);
            $checkdata = Cliniclocation::where(['mandal_name'=>$mandal_name ,'janpad_name'=> $janpad_name, 'name' => $aiCenter])->first();
            if(empty($checkdata)){
                $maitri=new Cliniclocation();
                $maitri->mandal_name    =    $this->engtohindi($mandal_name);//$this->engtohindi($row[2]);
                $maitri->janpad_name    =    $this->engtohindi($janpad_name);//$this->engtohindi($row[1]);
                $maitri->type           =    $type;
                $maitri->name           =    $aiCenter;
                $maitri->name_eng       =    $this->hinditoenglish($aiCenter);
                $maitri->lattitute      =    str_replace('-','.',$row[5]);
                $maitri->longitute      =    str_replace('-','.',$row[6]);
                $maitri->save(); 
            }else{
                Cliniclocation::where(['mandal_name'=>$mandal_name ,'janpad_name'=> $janpad_name, 'name' => $aiCenter])->update([
                    'name'              =>   $aiCenter,
                    'name_eng'          =>   $this->hinditoenglish($aiCenter),
                    'lattitute'         =>   str_replace('-','.',$row[5]),
                    'longitute'         =>   str_replace('-','.',$row[6]),
                ]);
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