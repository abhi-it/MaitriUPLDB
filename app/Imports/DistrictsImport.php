<?php

namespace App\Imports;

use App\Models\Divisions;
use App\Models\Districts;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Helpers\TranslateTextHelper;

class DistrictsImport implements ToModel, WithHeadingRow
{

    //temporary function
    public function model(array $row)
    {
        $division = Divisions::where('name_eng', $row['division_name'] ?? $row['mandal_name'])
                            ->orWhere('name_hindi', $row['division_name'] ?? $row['mandal_name'])
                            ->first();

        $year = "2025-2026";

        $exists = Districts::where('name_eng', $row['district_en'])
                        ->where('year', $year)
                        ->exists();

        if ($exists) {
            return null;
        }

        return new Districts([
            'name_eng'       => $row['district_en'],
            'name_hindi'     => $row['district_hi'] ?? null,
            'division_id'    => $division ? $division->id : null,
            'general_target' => $row['general'] ?? 0,
            'obc_target'     => $row['obc'] ?? 0,
            'sc_target'      => $row['sc'] ?? 0,
            'st_target'      => $row['st'] ?? 0,
            'status'         => $row['status'] ?? 1,
            'latt'           => $row['latt'] ?? null,
            'long'           => $row['long'] ?? null,
            'year'           => $year,
        ]);
    }

   public function model_2(array $row)
    {
        if ($row[0] === 'S. NO.' || empty($row[1])) {
            return null;
        }

        $division = Divisions::where('name_eng', $row[1]) ->orWhere('name_hindi', $row[1])->first();

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
