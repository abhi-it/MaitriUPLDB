<?php

namespace App\Exports;
ini_set('max_execution_time', 0);
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
class CVOListExport implements FromCollection, WithHeadings
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
            'लॉगिन आईडी',
            'अधिकारी का नाम',
            'पद का नाम',
            'पशु देखभाल केंद्र',
            'मोबाइल नंबर',
            'आधार नंबर',
            'ईमेल',
            'देशान्तर',
            'अक्षांश',
      ];
    }
}
