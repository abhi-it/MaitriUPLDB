<?php

namespace App\Exports;
ini_set('max_execution_time', 0);
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
class DemandRequestExport implements FromCollection, WithHeadings
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
            'जन्म तिथि',
            'लिंग',
            'प्रशिक्षण केंद्र का नाम',
            'भारत पशुधन आईडी',
            'व्हाट्सएप मोबाइल नंबर',
            'ज़िला',
            'विकास खण्ड',
            'पोस्ट ऑफिस',
            'तहसील',
            'एआई सेंटर ',
            'आपके भारत पशुधन आईडी पर कितने गांव मैप किए गए हैं',
            'तरल नाइट्रोजन',
            'प्रजाति वीर्य',
            'वीर्य प्रकार',
            'नस्ल',
            'बुल आई.डी.',
            'शीत क्वांटिटी',
            'ग्लव्स',
            'बीमा पुस्तिका', 
            'कितने पशु टैग की आवश्यकता है?',
            'खनिज मिश्रण',
            'कृमिनाशक',
            'गर्भावस्था फ़ीड',
            'बछड़ा स्टार्टर',
            'कोई अन्य वस्तु',
            'कोई सुझाव?',
            'कोई शिकायत?',
      ];
    }
}
