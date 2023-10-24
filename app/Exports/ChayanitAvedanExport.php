<?php

namespace App\Exports;
ini_set('max_execution_time', 0);
//ini_set("memory_limit", "-1");
use App\Models\Avedan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class ChayanitAvedanExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
   protected $id;
   protected $districtID;

 function __construct($id, $districtID) {
        $this->id = $id;
        $this->districtID = $districtID;
 } 
    public function collection()
    {
		if($this->id==1){
		$heading = 'चयनित सामान्य व अन्य पिछड़ा वर्ग अभ्यर्थियों की सूची';
		        return Avedan::select(
        'applicationNumber',
        'applicant_name',
        'fname',
        DB::raw('DATE_FORMAT(dob, "%d-%m-%Y") as dob'),
		'category',
		'gender',
		'post_office',
		'pincode',
		'address_type',
        'mobile',
        'permanent_address',
        'permanent_address_proof',
        'gram_panchayat_name',
        'vikas_khand',
        'letter_address',
        'email',
        'high_board_name',
        'high_passing_year',
        'high_marks',
        'high_total_marks',
        'high_percentage',
        'inter_board_name',
        'inter_passing_year',
        'inter_marks',
        'inter_total_marks',
        'inter_percentage',
        'graduation_board_name',
        'graduation_passing_year',
        'graduation_marks',
        'graduation_total_marks',
        'graduation_percentage',
        'postgraduation_board_name',
        'postgraduation_passing_year',
        'postgraduation_marks',
        'postgraduation_total_marks',
        'postgraduation_percentage',
        'training_adopted',
        
        'yojna_name_for_training',
        'AIkit',
        'nationality',
        )->where ('is_approved', '=', 4)
        ->whereIn('category', ["जनरल", "ओ बी सी"])
        ->where ('district_id', '=', $this->districtID)
        ->orderBy('topper_number', 'DESC')
        ->get();
		}else if($this->id==2){
			
			$heading = 'चयनित अनुसूचित जाति अभ्यर्थियों की सूची';
			        return Avedan::select(
        'applicationNumber',
        'applicant_name',
        'fname',
        DB::raw('DATE_FORMAT(dob, "%d-%m-%Y") as dob'),
		'category',
		'gender',
		'post_office',
		'pincode',
		'address_type',
        'mobile',
        'permanent_address',
        'permanent_address_proof',
        'gram_panchayat_name',
        'vikas_khand',
        'letter_address',
        'email',
        'high_board_name',
        'high_passing_year',
        'high_marks',
        'high_total_marks',
        'high_percentage',
        'inter_board_name',
        'inter_passing_year',
        'inter_marks',
        'inter_total_marks',
        'inter_percentage',
        'graduation_board_name',
        'graduation_passing_year',
        'graduation_marks',
        'graduation_total_marks',
        'graduation_percentage',
        'postgraduation_board_name',
        'postgraduation_passing_year',
        'postgraduation_marks',
        'postgraduation_total_marks',
        'postgraduation_percentage',
        'training_adopted',
        
        'yojna_name_for_training',
        'AIkit',
        'nationality',
        )->where ('is_approved', '=', 4)
        ->whereIn('category', ["एस सी"])
        ->where ('district_id', '=', $this->districtID)
        ->orderBy('topper_number', 'DESC')
        ->get();
		}else if($this->id==3){
			
		$heading = 'चयनित अनुसूचित जनजाति अभ्यर्थियों की सूची';
	    return Avedan::select(
        'applicationNumber',
        'applicant_name',
        'fname',
        DB::raw('DATE_FORMAT(dob, "%d-%m-%Y") as dob'),
		'category',
		'gender',
		'post_office',
		'pincode',
		'address_type',
        'mobile',
        'permanent_address',
        'permanent_address_proof',
        'gram_panchayat_name',
        'vikas_khand',
        'letter_address',
        'email',
        'high_board_name',
        'high_passing_year',
        'high_marks',
        'high_total_marks',
        'high_percentage',
        'inter_board_name',
        'inter_passing_year',
        'inter_marks',
        'inter_total_marks',
        'inter_percentage',
        'graduation_board_name',
        'graduation_passing_year',
        'graduation_marks',
        'graduation_total_marks',
        'graduation_percentage',
        'postgraduation_board_name',
        'postgraduation_passing_year',
        'postgraduation_marks',
        'postgraduation_total_marks',
        'postgraduation_percentage',
        'training_adopted',
        
        'yojna_name_for_training',
        'AIkit',
        'nationality',
        )->where ('is_approved', '=', 4)
        ->whereIn('category', ["एस टी"])
        ->where ('district_id', '=', $this->districtID)
        ->orderBy('topper_number', 'DESC')
        ->get();

		}else {
			
		$heading = 'सभी चयनित अभ्यर्थियों की सूची';
	    return Avedan::select(
        'applicationNumber',
        'applicant_name',
        'fname',
        DB::raw('DATE_FORMAT(dob, "%d-%m-%Y") as dob'),
		'category',
		'gender',
		'post_office',
		'pincode',
		'address_type',
        'mobile',
        'permanent_address',
        'permanent_address_proof',
        'gram_panchayat_name',
        'vikas_khand',
        'letter_address',
        'email',
        'high_board_name',
        'high_passing_year',
        'high_marks',
        'high_total_marks',
        'high_percentage',
        'inter_board_name',
        'inter_passing_year',
        'inter_marks',
        'inter_total_marks',
        'inter_percentage',
        'graduation_board_name',
        'graduation_passing_year',
        'graduation_marks',
        'graduation_total_marks',
        'graduation_percentage',
        'postgraduation_board_name',
        'postgraduation_passing_year',
        'postgraduation_marks',
        'postgraduation_total_marks',
        'postgraduation_percentage',
        'training_adopted',
        
        'yojna_name_for_training',
        'AIkit',
        'nationality',
        )->where ('is_approved', '=', 4)
        ->where ('district_id', '=', $this->districtID)
        ->orderBy('topper_number', 'DESC')
        ->get();
		}
		

    }
    
    public function headings(): array
    {
        return [
		'आवेदन नंबर',
		'आवेदक का नाम',
        'पिता / पति का नाम',
        'जन्म तिथि',
		'श्रेणी',
		'लिंग',
		'पोस्ट ऑफिस',
		'पिनकोड',
		'स्थायी पता का प्रमाण का प्रकार',
        'दूरभाष / मोबाइल नंबर',
        'स्थायी पता',
        'स्थायी पता का प्रमाण - पत्र',
        'ग्राम पंचायत का नाम',
        'विकास खण्ड',
        'पत्र - व्यवहार का पता',
        'ई - मेल',
        'हाई स्कूल बोर्ड का नाम',
        'हाई स्कूल उत्तीर्ण वर्ष',
        'हाई स्कूल प्राप्तांक',
        'हाई स्कूल पूर्णांक',
        'हाई स्कूल प्रतिशत',
        'इण्टर बोर्ड का नाम',
        'इण्टर उत्तीर्ण वर्ष',
        'इण्टर प्राप्तांक',
        'इण्टर पूर्णांक',
        'इण्टर प्रतिशत',
        'स्नातक बोर्ड का नाम',
        'स्नातक उत्तीर्ण वर्ष',
        'स्नातक प्राप्तांक',
        'स्नातक पूर्णांक',
        'स्नातक प्रतिशत',
        'परास्नातक बोर्ड का नाम',
        'परास्नातक उत्तीर्ण वर्ष',
        'परास्नातक प्राप्तांक',
        'परास्नातक पूर्णांक',
        'परास्नातक प्रतिशत',
        'यदि पूर्व में  प्राइवेट कृत्रिम गर्भाधान कार्यकर्त्ता के सम्बन्ध मै प्रशिक्षण प्राप्त किया है तो योजनान्तर्गत जारी प्रमाण-पत्र',
        'योजना का नाम जिसके अंतर्गत प्रशिक्षण प्राप्त किया गया',
        'प्रशिक्षणोपरांत ए. आई.  किट तथा  बायोलोजिकल कन्टेनर प्राप्त किये गये है',
        'राष्ट्रीयता',

		]; // Specify headings
        //return array_keys($this->collection()->first()->toArray()); //Get All Col Headings
    }
    
    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:AN1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FF0000');
              
                 $event->sheet->getDelegate()->freezePane('A2');  
            },

        ];
    }
}
