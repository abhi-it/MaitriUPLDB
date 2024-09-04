<?php

namespace App\Exports;

ini_set('max_execution_time', 0);
//ini_set("memory_limit", "-1");
use App\Models\Maitri;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
use App\Models\Districts;
class MaitriListExport implements FromCollection, WithHeadings
{
     /**
    * @return \Illuminate\Support\Collection
    */
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }
 
    public function collection()
    {
        return $this->data;
      
    }

    public function headings(): array
    {
        return [
            'मंडल का नाम',
            'जनपद का नाम',
            'मैत्री का नाम',
            'मैत्री का मोबाइल नंबर',
            'ग्राम पंचायत',
            'पोस्ट ऑफिस',
            'ब्लॉक',
            'तहसील',
            'आधार कार्ड',
            'पिता का नाम',
            'पिता का मोबाइल नंबर',
            'प्रमाणपत्र संख्या',
            'केंद्र का नाम',
            'पास की तिथि',
            'कोई भी भारत आईडी',
            'प्राप्त उपकरण',
            'देशांतर',
            'अक्षांश',
      ];
    }
}
