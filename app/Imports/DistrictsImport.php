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
        $division = Divisions::where('name_eng', $row['division'])
                        ->orWhere('name_hindi', $row['division'])
                        ->first();
                        
        $exists = Districts::where(function ($query) use ($row) {
                            $query->where('name_eng', $row['name_eng'])
                                ->orWhere('name_hindi', $row['name_hindi']);
                        })
                        ->where('year', $row['year'])
                        ->exists();

        if ($exists) {
            return null; 
        }

        return new Districts([
            'name_eng'       => $row['name_eng'],
            'name_hindi'     => $row['name_hindi'],
            'division_id'    => $division ? $division->id : null, 
            'general_target' => $row['general_target'] ?? 0,
            'obc_target'     => $row['obc_target'] ?? 0,
            'sc_target'      => $row['sc_target'] ?? 0,
            'st_target'      => $row['st_target'] ?? 0,
            'status'         => $row['status'] ?? 1,
            'latt'           => $row['latt'] ?? null,
            'long'           => $row['long'] ?? null,
            'year'           => $row['year'] ?? null,
        ]);
    }
}
