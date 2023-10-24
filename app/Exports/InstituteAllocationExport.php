<?php

namespace App\Exports;

ini_set('max_execution_time', 0);
//ini_set("memory_limit", "-1");
use App\Models\Avedan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
use App\Models\Districts;
use App\Models\Institute;

class InstituteAllocationExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize	
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $institute_id;
    protected $district_id;
    protected $category;
    protected $totalMaitri;

	function __construct($institute_id, $district_id, $category) {
        
        $this->institute_id = $institute_id;
        $this->district_id = $district_id;
        $this->category = $category;
	} 
 
    public function collection()
    {
		
		$query = Avedan::join('allocations', 'allocations.application_id', '=', 'avedans.id');
		
			if($this->category!='')
			{
				
				if(!empty($this->category)){
					$query->where(function ($q) {
						
						$q->where('allocations.category', '=', $this->category);
						//echo $request->input('category');exit;
					});
				}
			}
			
			if($this->district_id!='')
			{
				
				if(!empty($this->district_id)){
					$query->where(function ($q) {

						$q->where('allocations.district_id', '=', $this->district_id);
					});
				}
			}
			
			if($this->institute_id!='')
			{
				
				if(!empty($this->institute_id)){
					$query->where(function ($q) {

						$q->where('allocations.institute_id', '=', $this->institute_id);
					});
				}
			}
			
			$result = $query->get(
			[
		'avedans.applicationNumber',
        'avedans.applicant_name',
        'fname',
        DB::raw('DATE_FORMAT(avedans.dob, "%d-%m-%Y") as dob'),
		'avedans.category',
		'avedans.gender',
		'avedans.post_office',
		'avedans.pincode',
		'avedans.address_type',
        'avedans.mobile',
        'avedans.permanent_address',
        'avedans.permanent_address_proof',
        'avedans.gram_panchayat_name',
        'avedans.vikas_khand',
        'avedans.letter_address',
        'avedans.email',
        'avedans.high_board_name',
        'avedans.high_passing_year',
        'avedans.high_marks',
        'avedans.high_total_marks',
        'avedans.high_percentage',
        'avedans.inter_board_name',
        'avedans.inter_passing_year',
        'avedans.inter_marks',
        'avedans.inter_total_marks',
        'avedans.inter_percentage',
        'avedans.graduation_board_name',
        'avedans.graduation_passing_year',
        'avedans.graduation_marks',
        'avedans.graduation_total_marks',
        'avedans.graduation_percentage',
        'avedans.postgraduation_board_name',
        'avedans.postgraduation_passing_year',
        'avedans.postgraduation_marks',
        'avedans.postgraduation_total_marks',
        'avedans.postgraduation_percentage',
        'avedans.training_adopted',
        
        'avedans.yojna_name_for_training',
        'avedans.AIkit',
        'avedans.nationality',
			]);       
	    return $result;
    }
    
    public function headings(): array
    {
		
		$district = Districts::find($this->district_id);
		$institute = Institute::find($this->institute_id);

        return [
			
			[
				'संस्थान का नाम : '.$institute->name.''
			],
			[
				'जनपद : '.$district->name_hindi.''
			],
			[
				'संस्थान आवंटन सूची'
			],
			[
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
			]
		];
    }
    
    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                    $event->sheet->getDelegate()->mergeCells('A1:I1');
                    $event->sheet->getDelegate()->mergeCells('A2:I2');
                    $event->sheet->getDelegate()->mergeCells('A3:I3');
                    
                    
                    $event->sheet->getDelegate()->getStyle('A1:M1')->getFont()->setSize(16);
                    $event->sheet->getDelegate()->getStyle('A2:M2')->getFont()->setSize(16);
                    $event->sheet->getDelegate()->getStyle('A3:M3')->getFont()->setSize(14);
					$event->sheet->getDelegate()->freezePane('A5');
					$event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(40);
					$event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(40);
					$event->sheet->getDelegate()->getRowDimension('3')->setRowHeight(20);
				
					 $event->sheet->getDelegate()->getStyle('A1:E1')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                                
                                
                                $event->sheet->getDelegate()->getStyle('A3:I3')
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                                
                                
					$event->sheet->getDelegate()->getStyle('A4:I3')->getAlignment()->setWrapText(true); 
            },

        ];
    }
}
