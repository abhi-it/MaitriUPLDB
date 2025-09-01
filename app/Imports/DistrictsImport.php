<?php

namespace App\Imports;

use App\Models\Divisions;
use App\Models\Districts;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DistrictsImport implements ToModel, WithHeadingRow
{
   public function model(array $row)
    {
        if ($row[0] === 'S. NO.' || empty($row[1])) {
            return null;
        }

        $division = Divisions::where('name_eng', $row[1]) 
                            ->orWhere('name_hindi', $row[1])
                            ->first();

        $years = [
            '2022-2023' => $row[4] ?? 0, 
            '2023-2024' => $row[5] ?? 0, 
            '2024-2025' => $row[6] ?? 0, 
        ];

        $data = [];
        foreach ($years as $year => $target) {
             $target = is_numeric($target) ? (int) $target : 0;

            $data[] = new Districts([
                'name_eng'       => $row[3] ?? null,  
                'name_hindi'     => $row[3] ?? null,
                'division_id'    => $division?->id,
                'general_target' => $target,
                'obc_target'     => 0,
                'sc_target'      => 0,
                'st_target'      => 0,
                'status'         => 1,
                'latt'           => null,
                'long'           => null,
                'year'           => $year,
            ]);
        }

        return $data;
    }


}
