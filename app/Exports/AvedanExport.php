<?php

namespace App\Exports;

use App\Models\Avedan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class AvedanExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function collection()
    {
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
        'nationality',
        )->paginate(20);
        //return Test::select('name', 'mobile', 'email')->get();
        //return Test::get(['name', 'mobile', 'email']);
        //return Avedan::all(['applicationNumber', 'applicant_name', 'gender']);
        //return Test::all();
    }
    
    public function headings(): array
    {
        return [
		'applicationNumber',
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
        'राष्ट्रीयता',
        
				]; // Specify headings
        //return array_keys($this->collection()->first()->toArray()); //Get All Col Headings
    }
    
    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:AK1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FF0000');
              
                 $event->sheet->getDelegate()->freezePane('A2');  
            },

        ];
    }
}
