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
        // $user_id = Auth::user()->id;
        $district = Districts::where('name_hindi', 'LIKE', '%' . $request->district_id . '%')
                            ->orWhere('id', $request->district_id)
                            ->first();
    
        $animalBreeding = Animalbreeding::where('user_id', $request->user_id)->first();
    
        $data = [
            'user_id'                               => $request->user_id,
            'transaction_type'                      => $request->transaction_type ?? '',
            'transaction_date'                      => $request->transaction_date ?? '',
            'owner_state'                           => $request->owner_state ?? '',
            'division_id'                           => $request->division_id ?? '',
            'district_id'                           => $district->id ?? '',
            'tehsil'                                => $request->tehsil ?? '',
            'vikas_khand'                           => $request->block ?? '',
            'ower_village'                          => $request->ower_village ?? '',
            'project'                               => $request->project ?? '',
            'animal_id'                             => $request->animal_id ?? '',
            'dam_id'                                => $request->dam_id ?? '',
            'sire_id'                               => $request->sire_id ?? '',
            'animal_dob'                            => $request->animal_dob ?? '',
            'semen_type'                            => $request->semen_type ?? '',
            'bull_id'                               => $request->bull_id ?? '',
            'batch_no'                              => $request->batch_no ?? '',
            'lactation_number'                      => $request->lactation_number ?? '',
            'ai_id'                                 => $request->ai_id ?? '',
            'ai_date'                               => $request->ai_date ?? '',
            'ai_data_entry_date'                    => $request->ai_data_entry_date ?? '',
            'ai_status'                             => $request->ai_status ?? '',
            'actual_ai_heat_no'                     => $request->actual_ai_heat_no ?? '',
            'ai_type'                               => $request->ai_type ?? '',
            'heat_start_date'                       => $request->heat_start_date ?? '',
            'amount_cervical'                       => $request->amount_cervical ?? '',
            'ai_center'                             => $request->ai_center ?? '',
            'doka'                                  => $request->doka ?? '',
            'standing_mounted'                      => $request->standing_mounted ?? '',
            'mounting_attempt'                      => $request->mounting_attempt ?? '',
            'vocalization'                          => $request->vocalization ?? '',
            'mictruition'                           => $request->mictruition ?? '',
            'swollen_vulva'                         => $request->swollen_vulva ?? '',
            'pd_date'                               => $request->pd_date ?? '',
            'pd_data_entry_date'                    => $request->pd_data_entry_date ?? '',
            'pd_id'                                 => $request->pd_id ?? '',
            'pd_month'                              => $request->pd_month ?? '',
            'pd_bull_id'                            => $request->pd_bull_id ?? '',
            'pd_transaction_status'                 => $request->pd_transaction_status ?? '',
            'calving_date'                          => $request->calving_date ?? '',
            'calving_data_entry_date'               => $request->calving_data_entry_date ?? '',
            'calving_id'                            => $request->calving_id ?? '',
            'calf_bull_id'                          => $request->calf_bull_id ?? '',
            'no_of_alves'                           => $request->no_of_alves ?? '',
            'calving_ease'                          => $request->calving_ease ?? '',
            'calving_transaction_status'            => $request->calving_transaction_status ?? '',
            'tag_id'                                => $request->tag_id ?? '',
            'species'                               => $request->species ?? '',
            'owner_name'                            => $request->owner_name ?? '',
            'owner_gender'                          => $request->owner_gender ?? '',
            'owner_mobile_no'                       => $request->owner_mobile_no ?? '',
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