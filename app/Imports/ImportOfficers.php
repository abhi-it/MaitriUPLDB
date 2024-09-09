<?php

namespace App\Imports;
use App\Models\CVOOfficers;
use App\Models\Institute;
use App\Models\Tehsil;
use App\Models\Blockslist;
use App\Models\Hospitals;
use App\Models\AIcenters;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Helpers\TranslateTextHelper;
class ImportOfficers implements ToModel
{
    public function model(array $row)
    {
        set_time_limit(300);

        $lasttehsil = '';
        $last_block = '';
        $dis_id = '';

    if (is_numeric($row[0])) {
        
        $tehsil = isset($row[2]) && trim($row[2]) !== '' ? $this->engtohindi($row[2]) : $lasttehsil;
        $tehsil_eng = isset($row[2]) && trim($row[2]) !== '' ? $row[2] : $this->hinditoenglish($tehsil); 

        
        $dis = isset($row[1]) && trim($row[1]) !== '' ? $this->engtohindi($row[1]) : $dis_id;
        $dis_id = $dis;

        
        if (!Tehsil::where(['name_hindi' => $tehsil, 'distric' => $dis])->exists()) {
            $tehsilModel = new Tehsil();
            $tehsilModel->distric = $dis;
            $tehsilModel->name_hindi = $tehsil;
            $tehsilModel->name_eng = $tehsil_eng;
            $tehsilModel->save();
        }

        
        $block = isset($row[3]) && trim($row[3]) !== '' ? $this->engtohindi($row[3]) : $last_block;
        $block_eng = isset($row[3]) && trim($row[3]) !== '' ? $row[3] : $this->hinditoenglish($block); // Use last known value if empty
        $last_block = $block;

        
        if (!Blockslist::where(['name_hindi' => $block, 'distric' => $dis])->exists()) {
            $blockModel = new Blockslist();
            $blockModel->distric = $dis;
            $blockModel->name_hindi = $block;
            $blockModel->name_eng = $block_eng;
            $blockModel->save();
        }

       
        
        $hos = $this->engtohindi($row[4]);
        $hos_eng =$row[4];// $this->hinditoenglish($row[4]);
        if (!Hospitals::where(['name_hindi' => $hos, 'distric' => $dis, 'tehsil' => $tehsil, 'block' => $block])->exists()) {
            $hospitalModel = new Hospitals();
            $hospitalModel->distric = $dis;
            $hospitalModel->tehsil = $tehsil;
            $hospitalModel->block = $block;
            $hospitalModel->name_hindi = $hos;
            $hospitalModel->name_eng = $hos_eng;
            $hospitalModel->save();
        }

        
        $AI = $this->engtohindi($row[5]);
        $AI_eng = $row[5];//$this->hinditoenglish($AI);//
        if (!AIcenters::where(['name_hindi' => $AI, 'distric' => $dis, 'tehsil' => $tehsil, 'block' => $block])->exists()) {
            $aiModel = new AIcenters();
            $aiModel->distric = $dis;
            $aiModel->tehsil = $tehsil;
            $aiModel->block = $block;
            $aiModel->name_hindi = $AI;
            $aiModel->name_eng = $AI_eng;
            $aiModel->save();
        }
    }


      


        // if (isset($row[4])){
        //     $checkdata =  CVOOfficers::where(['mobile_no'=>$row[4]])->first();
        // }
        // if(empty($checkdata)){
        //     if(is_numeric($row[0])){
        //         // echo "<pre>"; print_r($this->engtohindi($row[1])); echo "</pre>"; exit;
        //         $officer=new CVOOfficers();
        //         $officer->mandal_name='औरैया';
        //         $officer->janpad_name=$this->changeText($row[1]);
        //         $officer->login_id='';//$row[6];
        //         $officer->officer_name=$this->changeText($row[2]);
        //         $officer->designation=$this->changeText($row[3]);
        //         $officer->animal_care_center=$this->changeText($row[4]);
        //         $officer->mobile_no='';//$row[4];
        //         $officer->longitute =isset($row[5])?str_replace('-','.',$row[5]):'';
        //         $officer->lattitute =isset($row[6])?str_replace('-','.',$row[6]):'';
        //         $officer->save(); 
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