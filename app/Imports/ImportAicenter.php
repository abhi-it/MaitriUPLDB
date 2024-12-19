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

class ImportAicenter implements ToModel
{
    

    public function model(array $row) {
        set_time_limit(300);
    
        if ($row[0]) {
            /*$maitries = Cliniclocation::all();
            foreach ($maitries as $data) {
                $division = $data['mandal_name'];
                $district = $data['janpad_name'];
                
                $getData = Divisions::where('name_hindi', 'LIKE', '%'.$division.'%')->first();
                $getDis = Districts::where('name_hindi', 'LIKE', '%'.$district.'%')->first();

                if ($getData && $getDis) {
                    $data->update([
                        'zone_id' => $getData->zone_id,
                        'division_id' => $getData->id,
                        'district_id' => $getDis->id,
                    ]);
                }
            }

            // $maitries = Latestaicenter::all();
            // foreach ($maitries as $data) {
                
            //     $division = $data['mandal_name'];
            //     $district = $data['janpad_name'];
            //     $getData = Divisions::where('name_hindi', 'LIKE', '%'.$division.'%')->first();
            //     $getDis = Districts::where('name_hindi', 'LIKE', '%'.$district.'%')->first();

            //     $tehsil     = $this->hinditoenglish($data['tehsil']);
            //     $block      = $this->hinditoenglish($data['block']);
            //     $aicenter   = $this->hinditoenglish($data['aicenter']);
                
            //     $data->update([
            //         'mandal_eng'    => $getData['name_eng'],
            //         'janpad_eng'    => $getDis['name_eng'],
            //         'tehsil_eng'    => $tehsil,
            //         'block_eng'     => $block,
            //         'aicenter_eng'  => $aicenter,
            //     ]);
            // }


            $district_eng       = $this->detectLanguage($row[0]) === 'English' ? $row[0] : $this->hinditoenglish($row[0]);
            $district_hindi     = $this->detectLanguage($row[0]) === 'English' ? $this->engtohindi($row[0]) : $row[0];
            $tehsil_eng         = $this->detectLanguage($row[1]) === 'English' ? $row[1] : $this->hinditoenglish($row[1]);
            $tehsil_hindi       = $this->detectLanguage($row[1]) === 'English' ? $this->engtohindi($row[1]) : $row[1];
            $block_eng          = $this->detectLanguage($row[2]) === 'English' ? $row[2] : $this->hinditoenglish($row[2]);
            $block_hindi        = $this->detectLanguage($row[2]) === 'English' ? $this->engtohindi($row[2]) : $row[2];
            $aicenter_eng       = $this->detectLanguage($row[3]) === 'English' ? $row[3] : $this->hinditoenglish($row[3]);
            $aicenter_hindi     = $this->detectLanguage($row[3]) === 'English' ? $this->engtohindi($row[3]) : $row[3];
            */

            // $district_name              = $row[0];
            // $tehsil_name                = $row[1];
            // $block_name                 = $row[2];
            // $aicenter_name              = $row[3];
            
            
            
            $tehsil_hindi       = $this->detectLanguage($row[1]) === 'English' ? $this->engtohindi($row[1]) : $row[1];
            $block_hindi        = $this->detectLanguage($row[2]) === 'English' ? $this->engtohindi($row[2]) : $row[2];
            $aicenter_hindi     = $this->detectLanguage($row[3]) === 'English' ? $this->engtohindi($row[3]) : $row[3];
            $maitri_name        = $row[5];
            $bharat_pashudhan_id        = $row[4];
            $maitri_mobile_no          = (string)$row[6];
            
            Manganurodhdata::create([
                'mandal_name'           => 'वाराणसी',
                'janpad_name'           => 'गाजीपुर',
                'block'                 => $block_hindi,
                'tehsil'                => $tehsil_hindi,
                'center_name'           => $aicenter_hindi,
                'maitri_name'           => $maitri_name,
                'maitri_mobile_no'      => $maitri_mobile_no,
                'any_bharat_id'         => $bharat_pashudhan_id,
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


// https://github.com/ErParmod/hindi-font-converter