<?php

namespace App\Exports;

ini_set('max_execution_time', 0);
use App\Models\HospitalInstitute;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
class AIcenterExport implements FromCollection, WithHeadings
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
            'केंद्र / संस्थान',
            'केंद्र का नाम',
            'मोबाइल नंबर',
            'पता',
            'देशांतर',
            'अक्षांश',
      ];
    }
}
