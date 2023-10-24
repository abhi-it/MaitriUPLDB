<?php

namespace App\Exports;

use App\Models\Avedan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class ExportAvedan implements FromCollection, WithHeadings
{
    private $data;

    public function __construct($data) {
        $this->data = $data;
        // dd($this->data);
    }
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        return $this->data;
        // return Avedan::select(
        // 'applicationNumber',
        // 'applicant_name',
        // 'fname',
        // 'mother',
		// 'gender',
        // 'mobile',
		// 'email',
        // 'high_percentage',
        // 'inter_percentage',
		// 'category',
		// 'letter_address',
        // DB::raw('DATE_FORMAT(dob, "%d-%m-%Y") as dob'),
		// 'post_office',
		// 'pincode',
		// 'address_type',
        // 'permanent_address',
        // 'permanent_address_proof',
        // 'gram_panchayat_name',
        // 'vikas_khand',
        // 'letter_address',
        // 'email',
        // 'high_board_name',
        // 'high_passing_year',
        // 'high_marks',
        // 'high_total_marks',
        // 'inter_board_name',
        // 'inter_passing_year',
        // 'inter_marks',
        // 'inter_total_marks',
        // 'graduation_board_name',
        // 'graduation_passing_year',
        // 'graduation_marks',
        // 'graduation_total_marks',
        // 'graduation_percentage',
        // 'postgraduation_board_name',
        // 'postgraduation_passing_year',
        // 'postgraduation_marks',
        // 'postgraduation_total_marks',
        // 'postgraduation_percentage',
        // 'nationality',
        // )->where('is_approved', $this->isApproved)->get();
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
        'माता का नाम',
		'लिंग',
        'दूरभाष / मोबाइल नंबर',
        'ई - मेल',
        'हाई स्कूल प्रतिशत',
        'इण्टर प्रतिशत',
		'श्रेणी',
        'स्थायी पता',
        // 'जन्म तिथि',
		// 'पोस्ट ऑफिस',
		// 'पिनकोड',
		// 'स्थायी पता का प्रमाण का प्रकार',
        // 'स्थायी पता का प्रमाण - पत्र',
        // 'ग्राम पंचायत का नाम',
        // 'विकास खण्ड',
        // 'पत्र - व्यवहार का पता',
        // 'हाई स्कूल बोर्ड का नाम',
        // 'हाई स्कूल उत्तीर्ण वर्ष',
        // 'हाई स्कूल प्राप्तांक',
        // 'हाई स्कूल पूर्णांक',
        // 'इण्टर बोर्ड का नाम',
        // 'इण्टर उत्तीर्ण वर्ष',
        // 'इण्टर प्राप्तांक',
        // 'इण्टर पूर्णांक',
        // 'स्नातक बोर्ड का नाम',
        // 'स्नातक उत्तीर्ण वर्ष',
        // 'स्नातक प्राप्तांक',
        // 'स्नातक पूर्णांक',
        // 'स्नातक प्रतिशत',
        // 'परास्नातक बोर्ड का नाम',
        // 'परास्नातक उत्तीर्ण वर्ष',
        // 'परास्नातक प्राप्तांक',
        // 'परास्नातक पूर्णांक',
        // 'परास्नातक प्रतिशत',
        // 'राष्ट्रीयता',

				]; // Specify headings
        //return array_keys($this->collection()->first()->toArray()); //Get All Col Headings
    }

    // public function registerEvents(): array
    // {
    //     return [

    //         AfterSheet::class => function (AfterSheet $event) {

    //             $event->sheet->getDelegate()->getStyle('A1:AK1')
    //                 ->getFill()
    //                 ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    //                 ->getStartColor()
    //                 ->setARGB('FF0000');

    //              $event->sheet->getDelegate()->freezePane('A2');
    //         },

    //     ];
    // }
}
