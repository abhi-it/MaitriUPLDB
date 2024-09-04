<?php

namespace App\Imports;
use App\Models\Maitri;

use Maatwebsite\Excel\Concerns\ToModel;

class ImportMaitri implements ToModel
{
    public function model(array $row)
    {
        // dd($row);
        // // Define how to create a model from the Excel row data
        // return new YourModel([
        //     'column1' => $row[0],
        //     'column2' => $row[1],
        //     // Add more columns as needed
        // ]);
        
        if(is_numeric($row[0])){
        // echo "<pre>"; print_r($row); echo "</pre>";

        $maitri=new Maitri();
        $maitri->mandal_name=$row[1];
        $maitri->janpad_name=$row[2];
        $maitri->maitri_name=$row[3];
        $maitri->maitri_mobile_no=$row[4];
        $maitri->gram_panchayat=$row[5];
        $maitri->post_office=$row[6];
        $maitri->block=$row[7];
        $maitri->tehsil=$row[8];
        $maitri->adhaar_card=$row[9];
        $maitri->father_name=$row[10];
        $maitri->father_mobile_no=$row[11];
        $maitri->certificate_no=$row[12];
        $maitri->center_name=$row[13];
        $maitri->pass_date=$row[14];
        $maitri->expiry_date=$row[15];
        $maitri->any_bharat_id=$row[16];
        $maitri->equipment_received=$row[17];
        $maitri->longitude=str_replace('-','.',$row[18]);
        $maitri->latitude=str_replace('-','.',$row[19]);
        
        $maitri->save(); 
        }
    }
}
