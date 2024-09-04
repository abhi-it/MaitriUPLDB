<?php

namespace App\Exports;

ini_set('max_execution_time', 0);
use App\Models\Districts;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
class LocationExport implements FromCollection, WithHeadings
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
            'General Target',
            'SC Target',
            'ST Target',
            'Status',
            'देशांतर',
            'अक्षांश',
      ];
    }
}
