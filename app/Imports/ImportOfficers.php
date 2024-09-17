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
      
        if (is_numeric($row[0])){
            $name   =    $this->changeText($row[5]);
            // $type   =    explode(' ',$name);
            $block  =     $this->changeText($row[1]);
            $checkdata = Cliniclocation::where(['name'=>$name ,'type'=>'VH'])->first();
            if(empty($checkdata)){
                $maitri=new Cliniclocation();
                $maitri->mandal_name    =    'गोरखपुर' ;//$this->engtohindi($row[2]);
                $maitri->janpad_name    =    'देवरिया';//$this->engtohindi($row[1]);
                $maitri->type           =    'VH';//$type[0];
                $maitri->block          =    $block;
                $maitri->name           =    $name;
                $maitri->name_eng       =    $this->hinditoenglish($name);
                $maitri->longitute      =    str_replace('-','.',$row[8]);
                $maitri->lattitute      =    str_replace('-','.',$row[7]);
                $maitri->save(); 
            }else{
                Cliniclocation::where(['name'=>$name ,'type'=>'VH'])->update([
                    'name'              =>   $name,
                    'name_eng'          =>   $this->hinditoenglish($name),
                    'longitute'         =>   str_replace('-','.',$row[8]),
                    'lattitute'         =>   str_replace('-','.',$row[7]),
                ]);
            }
        }

    // if (is_numeric($row[0])) {
        
    //     $tehsil = isset($row[2]) && trim($row[2]) !== '' ? $this->changeText($row[2]) : $lasttehsil;
    //     $tehsil_eng = isset($row[2]) && trim($row[2]) !== '' ? $row[2] : $this->hinditoenglish($tehsil); 

        
    //     $dis = isset($row[1]) && trim($row[1]) !== '' ? $this->engtohindi($row[1]) : $dis_id;
    //     $dis_id = $dis;

        
    //     if (!Tehsil::where(['name_hindi' => $tehsil, 'distric' => $dis])->exists()) {
    //         $tehsilModel = new Tehsil();
    //         $tehsilModel->distric = $dis;
    //         $tehsilModel->name_hindi = $tehsil;
    //         $tehsilModel->name_eng = $tehsil_eng;
    //         $tehsilModel->save();
    //     }

        
    //     $block = isset($row[3]) && trim($row[3]) !== '' ? $this->engtohindi($row[3]) : $last_block;
    //     $block_eng = isset($row[3]) && trim($row[3]) !== '' ? $row[3] : $this->hinditoenglish($block); // Use last known value if empty
    //     $last_block = $block;

        
    //     if (!Blockslist::where(['name_hindi' => $block, 'distric' => $dis])->exists()) {
    //         $blockModel = new Blockslist();
    //         $blockModel->distric = $dis;
    //         $blockModel->name_hindi = $block;
    //         $blockModel->name_eng = $block_eng;
    //         $blockModel->save();
    //     }

       
        
    //     $hos = $this->engtohindi($row[4]);
    //     $hos_eng =$row[4];// $this->hinditoenglish($row[4]);
    //     if (!Hospitals::where(['name_hindi' => $hos, 'distric' => $dis, 'tehsil' => $tehsil, 'block' => $block])->exists()) {
    //         $hospitalModel = new Hospitals();
    //         $hospitalModel->distric = $dis;
    //         $hospitalModel->tehsil = $tehsil;
    //         $hospitalModel->block = $block;
    //         $hospitalModel->name_hindi = $hos;
    //         $hospitalModel->name_eng = $hos_eng;
    //         $hospitalModel->save();
    //     }

        
    //     $AI = $this->engtohindi($row[5]);
    //     $AI_eng = $row[5];//$this->hinditoenglish($AI);//
    //     if (!AIcenters::where(['name_hindi' => $AI, 'distric' => $dis, 'tehsil' => $tehsil, 'block' => $block])->exists()) {
    //         $aiModel = new AIcenters();
    //         $aiModel->distric = $dis;
    //         $aiModel->tehsil = $tehsil;
    //         $aiModel->block = $block;
    //         $aiModel->name_hindi = $AI;
    //         $aiModel->name_eng = $AI_eng;
    //         $aiModel->save();
    //     }
    // }
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