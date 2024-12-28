<?php

namespace App\Exports;
ini_set('max_execution_time', 0);
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
class FarmarListExport implements FromCollection, WithHeadings
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
            'नाम',
            'मोबाइल नंबर',
            'जिला',
            'तहसील',
            'ब्लॉक',
            'पोस्ट ऑफ़िस',
            'नस्ल',
            'कैटेल संख्या',
            'दूध/प्रतिदिन/प्रति पशु',
      ];
    }
}
