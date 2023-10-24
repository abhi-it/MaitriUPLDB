<?php

namespace App\Exports;

ini_set('max_execution_time', 0);
//ini_set("memory_limit", "-1");
use App\Models\Maitridetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
use App\Models\Districts;

class MaitriExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize	
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $district_id;
    protected $totalMaitri;

	function __construct($id) {
        
        $this->district_id = $id;
	} 
 
    public function collection()
    {
        $result = Maitridetail::select(
        'tehseel',
        'vikas_khand',
		'animal_hospitals',
		'gram_panchayat',
		'maitri_workfield',
		'maitri_name',
		'father',
        'address',
        'mobile',
        'training_name',
        'institute',
        'training_period',
        )->where ('district_id', '=', $this->district_id)
        ->orderBy('id', 'DESC')
        ->get();        
	    return $result;
    }
    
    public function headings(): array
    {
		
		$district = Districts::find($this->district_id);
		$totalMaitri = Maitridetail::where ('district_id', '=', $this->district_id)->count();

        return [
			
			[
				'क्रियाशील प्राइवेट कृत्रिम गर्भाधान कार्यकर्ता/पशुमित्र/मैत्री का विवरण ( कुल मैत्री : '.$totalMaitri.' )'
			],
			[
				'जनपद : '.$district->name_hindi.''
			],
			[
				'क्रियाशील प्राईवेट कृत्रिम गर्भाधान कार्यकर्ता सम्बन्धी विवरण'
			],
			[
			'तहसील',
			'विकास खण्ड',
			'पशुचिकित्सालय  का नाम ',
			'ग्राम पंचायत का नाम (जहाँ का निवासी हो)',
			'कार्यक्षेत्र',
			'प्राइवेट कृत्रिम गर्भाधान कार्यकर्ता/पशुमित्र/मैत्री का नाम',
			'पिता का नाम',
			'पता',
			'मोबाईल नं0',
			'किस योजनान्तर्गत प्रशिक्षण प्राप्त किया यू पी एल डी बी  / डास्प /बायफ /पशुपालन विभाग /अन्य',
			'संस्था का नाम जहाँ से प्रशिक्षण प्राप्त किया गया',
			'प्रशिक्षण अविध(दिन में)',
			]
		];
    }
    
    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                    $event->sheet->getDelegate()->mergeCells('A1:E1');
                    $event->sheet->getDelegate()->mergeCells('A2:E2');
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
