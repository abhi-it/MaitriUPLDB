<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animalbreeding;
use App\Models\Districts;
use Illuminate\Support\Facades\Auth;

class AnimalBreedingController extends Controller
{
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $district = Districts::where('name_hindi', 'LIKE', '%' . $request->district_id . '%')
                            ->orWhere('id', $request->district_id)
                            ->first();

        // Check if a record with the given user_id exists
        $animalBreeding = Animalbreeding::where('user_id', $request->user_id)->first();

        $data = [
            'user_id' => $user_id,
            'transaction_type' => $request->transaction_type ?: null,
            'transaction_date' => $request->transaction_date ?: null,
            'owner_state' => $request->owner_state ?: null,
            'division_id' => $request->division_id ?: null,
            'district_id' => $district->id ?? null,
            'tehsil' => $request->tehsil ?: null,
            'vikas_khand' => $request->vikas_khand ?: null,
            'ower_village' => $request->ower_village ?: null,
            'project' => $request->project ?: null,
            'animal_id' => $request->animal_id ?: null,
            'dam_id' => $request->dam_id ?: null,  // Ensure NULL instead of ''
            'sire_id' => $request->sire_id ?: null, // Ensure NULL instead of ''
            'animal_dob' => $request->animal_dob ?: null,
            'semen_type' => $request->semen_type ?: null,
            'bull_id' => $request->bull_id ?: null,
            'batch_no' => $request->batch_no ?: null,
            'lactation_number' => $request->lactation_number ?: null,
            'ai_id' => $request->ai_id ?: null,
            'ai_date' => $request->ai_date ?: null,
            'ai_data_entry_date' => $request->ai_data_entry_date ?: null,
            'ai_status' => $request->ai_status ?: null,
            'tag_id' => $request->tag_id ?: null,
            'species' => $request->species ?: null,
            'owner_name' => $request->owner_name ?: null,
            'owner_gender' => $request->owner_gender ?: null,
            'owner_mobile_no' => $request->owner_mobile_no ?: null,
        ];

        if ($animalBreeding) {
            $animalBreeding->update($data);
            return redirect()->back()->with('success', 'Animal breeding data updated successfully');
        } else {
            Animalbreeding::create($data);
            return redirect()->back()->with('success', 'Animal breeding data saved successfully');
        }
    }

}