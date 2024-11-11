<?php

namespace App\Imports;
use DB;
use App\Models\CVOOfficers;
use App\Models\Institute;
use App\Models\Tehsil;
use App\Models\Blockslist;
use App\Models\DistrictMapData;
use App\Models\Hospitals;
use App\Models\AIcenters;
use App\Models\Maitri;
use App\Models\Cliniclocation;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Helpers\TranslateTextHelper;
class ImportOfficers implements ToModel
{
    public function model(array $row) {
        set_time_limit(300);
    
        if ($row[0]) {
            $mandal_name = $row[0];
            $janpad_name = $row[1];
            $type = $row[3];
            $aiCenterNameHindi = $row[2];
            $aiCenterNameEng = $row[4];
    
            // Determine AI Center Name
            $aiCenter = $aiCenterNameHindi ? $aiCenterNameHindi : $this->engtohindi($aiCenterNameEng);
    
            // Convert names to Hindi
            $mandal_name_hindi = $this->engtohindi($mandal_name);
            $janpad_name_hindi = $this->engtohindi($janpad_name);
    
            // Start a transaction to handle both insert and update operations
            \DB::transaction(function () use ($mandal_name_hindi, $janpad_name_hindi, $type, $aiCenter, $row) {
                // Check if the Cliniclocation already exists
                $checkdata = Cliniclocation::where([
                    'mandal_name' => $mandal_name_hindi,
                    'janpad_name' => $janpad_name_hindi,
                    'name' => $aiCenter
                ])->first();
    
                // Data to be saved or updated
                $data = [
                    'name'      => $aiCenter,
                    'name_eng'  => $this->hinditoenglish($aiCenter),
                    'type'      => ($type) ? $type : '',
                    'lattitute' => str_replace('-', '.', $row[5]),
                    'longitute' => str_replace('-', '.', $row[6]),
                ];
    
                if ($checkdata) {
                    // Update if record exists
                    $checkdata->update($data);
                } else {
                    // Insert new record if not found
                    $maitri = new Cliniclocation();
                    $maitri->mandal_name = $mandal_name_hindi;
                    $maitri->janpad_name = $janpad_name_hindi;
                    $maitri->type = $type;
                    $maitri->fill($data);
                    $maitri->save();
                }
            }, 3); // Retry up to 3 times in case of deadlock
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