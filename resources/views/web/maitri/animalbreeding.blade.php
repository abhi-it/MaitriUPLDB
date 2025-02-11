@extends('submaster')
@section('content')

<style>
.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, .125);
    border-radius: 0.25rem;
}

.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}

.modal-dialog {
    max-width: 40% !important;
}

.openModal {
    display: none;
}

.contain-form {
    margin: auto;
    padding: 20px;
}
</style>
<div class="container main-div">
    <h3 class="text-center fw-bold m-4">पशु प्रजनन</h3>
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
    @if(session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
    @endif

    <div class="row">
        <div class="contain-form card">
            <form method="post" action="{{ route('save-animal-breeding') }}" class="form-comman">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user_id ?? '' }}">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="transaction_type">
                            <span>Transaction Type</span>
                        </label>
                        <select name="transaction_type" id="transaction_type" class="form-control">
                            <option value="">Select any one</option>
                            <option value="calving"
                                {{ isset($breedingData->transaction_type) && $breedingData->transaction_type == 'calving' ? 'selected' : '' }}>
                                Calving
                            </option>
                            <option value="pd"
                                {{ isset($breedingData->transaction_type) && $breedingData->transaction_type == 'pd' ? 'selected' : '' }}>
                                PD
                            </option>
                            <option value="ai"
                                {{ isset($breedingData->transaction_type) && $breedingData->transaction_type == 'ai' ? 'selected' : '' }}>
                                AI
                            </option>
                        </select>


                    </div>

                    <div class="form-group col-md-4">
                        <label for="transaction_date">
                            <span>Transaction Date</span>
                        </label>
                        <input type="date" class="form-control" id="transaction_date" name="transaction_date"
                            value="{{ $breedingData->transaction_date ?? '' }}" placeholder="Transaction Date"
                            autocomplete="off">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="owner_state">
                            <span>Owner State</span>
                        </label>
                        <input type="text" class="form-control" required id="owner_state" name="owner_state"
                            value="{{ isset($breedingData->owner_state) ?? '' }}" placeholder="Owner State"
                            autocomplete="off">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="division"> <span>Mandal</span></label>
                        <select name="division_id" id="district" required class="form-control">
                            <option value="">मंडल चुनें</option>
                            @foreach($divisions as $division)
                            <option value="{{ $division->id }}"
                                {{ isset($breedingData->division_id) && $breedingData->division_id == $division->id ? 'selected' : '' }}>
                                {{ $division->name_hindi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="mandal"> <span>District</span></label>
                        <select name="district_id" id="mandal" required class="form-control">

                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="tehsil"> <span>Teshil</span></label>
                        <select name="tehsil" id="tehsil" required class="form-control">
                            <option value=""></option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="vikas_khand"> <span>Block</span></label>
                        <select name="block" id="vikas_khand" required class="form-control">
                            <option value=""></option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="ower_village"> <span>Owner Village</span></label>
                        <input type="text" name="ower_village" id="ower_village"
                            value="{{ $breedingData->ower_village ?? '' }}" class="form-control"
                            placeholder="Owner Village">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="project"> <span>Project</span></label>
                        <input type="text" name="project" id="project" value="{{ $breedingData->project ?? '' }}"
                            class="form-control" placeholder="Project">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="animal_id"> <span>Animal ID</span></label>
                        <input type="number" name="animal_id" id="animal_id"
                            value="{{ $breedingData->animal_id ?? '' }}" class="form-control" placeholder="Animal ID">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="dam_id"> <span>Dam ID</span></label>
                        <input type="number" name="dam_id" id="dam_id" value="{{ $breedingData->dam_id ?? '' }}"
                            class="form-control" placeholder="Dam ID">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="sire_id"><span>Sire ID</span></label>
                        <input type="text" name="sire_id" id="sire_id" value="{{ $breedingData->sire_id ?? '' }}"
                            class="form-control" placeholder="Sire ID">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="animal_dob"><span>Animal DOB</span></label>
                        <input type="date" name="animal_dob" id="animal_dob"
                            value="{{ $breedingData->transaction_date ?? '' }}" class="form-control"
                            placeholder="Animal DOB">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="semen_type"> <span>Semen Type</span></label>
                        <select name="semen_type" id="semen_type" class="form-control">
                            <option value="">Select any one</option>
                            <option value="sex_sorted"
                                {{ isset($breedingData->semen_type) && $breedingData->semen_type == 'sex_sorted' ? 'selected' : '' }}>
                                Sex Sorted
                            </option>
                            <option value="conventional"
                                {{ isset($breedingData->semen_type) && $breedingData->semen_type == 'conventional' ? 'selected' : '' }}>
                                Conventional
                            </option>
                        </select>


                    </div>

                    <div class="form-group col-md-4">
                        <label for="bull_id"> <span>Bull ID</span></label>
                        <input type="text" name="bull_id" id="bull_id" value="{{ $breedingData->bull_id ?? '' }}"
                            class="form-control" placeholder="Bull ID">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="batch_no"> <span>Batch No</span></label>
                        <input type="text" name="batch_no" id="batch_no" value="{{ $breedingData->batch_no ?? '' }}"
                            class="form-control" placeholder="Batch No">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="lactation_number"> <span>Lactation Number</span></label>
                        <input type="number" name="lactation_number" id="lactation_number"
                            value="{{ $breedingData->lactation_number ?? '' }}" class="form-control"
                            placeholder="Lactation Number">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="ai_id"> <span>AI ID</span></label>
                        <input type="number" name="ai_id" id="ai_id" value="{{ $breedingData->ai_id ?? '' }}"
                            class="form-control" placeholder="AI ID">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="ai_date"> <span>AI Date</span></label>
                        <input type="date" name="ai_date" id="ai_date" value="{{ $breedingData->ai_date ?? '' }}"
                            class="form-control" placeholder="AI Date">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="ai_data_entry_date"> <span>AI Data Entry Date</span></label>
                        <input type="date" name="ai_data_entry_date" id="ai_data_entry_date"
                            value="{{ $breedingData->transaction_date ?? '' }}" class="form-control"
                            placeholder="AI Data Entry Date">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="ai_status"> <span>AI Status</span></label>
                        <select name="ai_status" id="ai_status" class="form-control">
                            <option value="">Select any one</option>
                            <option value="successful"
                                {{ isset($breedingData->ai_status) && $breedingData->ai_status == 'successful' ? 'selected' : '' }}>
                                Successful
                            </option>
                            <option value="unsuccessful"
                                {{ isset($breedingData->ai_status) && $breedingData->ai_status == 'unsuccessful' ? 'selected' : '' }}>
                                Unsuccessful
                            </option>
                        </select>


                    </div>

                    <div class="form-group col-md-4">
                        <label for="actual_ai_heat_no"> <span>Actual AI Heat No</span></label>
                        <input type="number" name="actual_ai_heat_no" id="actual_ai_heat_no"
                            value="{{ $breedingData->actual_ai_heat_no ?? '' }}" class="form-control"
                            placeholder="Actual AI Heat No">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="ai_type"> <span>AI Type</span></label>
                        <input type="text" name="ai_type" id="ai_type" value="{{ $breedingData->ai_type ?? '' }}"
                            class="form-control" placeholder="AI Type">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="heat_start_date"> <span>Heat Start Date</span></label>
                        <input type="date" name="heat_start_date" id="heat_start_date"
                            value="{{ $breedingData->heat_start_date ?? '' }}" class="form-control"
                            placeholder="Heat Start Date">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="amount_cervical"> <span>Amount Cervical Mucus Discharge</span></label>
                        <input type="text" name="amount_cervical" id="amount_cervical"
                            value="{{ $breedingData->amount_cervical ?? '' }}" class="form-control"
                            placeholder="Amount Cervical Mucus Discharge">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="ai_center"> <span>AI Centre</span></label>
                        <input type="text" name="ai_center" id="ai_center" value="{{ $breedingData->ai_center ?? '' }}"
                            class="form-control" placeholder="AI Centre">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="doka"><span>Doka</span></label>
                        <input type="text" name="doka" id="doka" value="{{ $breedingData->doka ?? '' }}"
                            class="form-control" placeholder="Doka">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="standing_mounted"> <span>Standing to be Mounted</span></label>
                        <input type="text" name="standing_mounted" id="standing_mounted"
                            value="{{ $breedingData->standing_mounted ?? '' }}" class="form-control"
                            placeholder="Standing to be Mounted">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="mounting_attempt"> <span>Mounting on Herd Mates or Attempt</span></label>
                        <input type="text" name="mounting_attempt" id="mounting_attempt"
                            value="{{ $breedingData->mounting_attempt ?? '' }}" class="form-control"
                            placeholder="Mounting on Herd Mates or Attempt">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="vocalization"> <span>Vocalization</span></label>
                        <input type="text" name="vocalization" id="vocalization"
                            value="{{ $breedingData->vocalization ?? '' }}" class="form-control"
                            placeholder="Vocalization">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="mictruition"> <span>Mictruition</span></label>
                        <input type="text" name="mictruition" id="mictruition"
                            value="{{ $breedingData->mictruition ?? '' }}" class="form-control"
                            placeholder="Mictruition">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="swollen_vulva"> <span>Swollen Vulva</span></label>
                        <input type="text" name="swollen_vulva" id="swollen_vulva"
                            value="{{ $breedingData->swollen_vulva ?? '' }}" class="form-control"
                            placeholder="Swollen Vulva">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="pd_date"> <span>PD Date</span></label>
                        <input type="date" name="pd_date" id="pd_date" value="{{ $breedingData->pd_date ?? '' }}"
                            class="form-control" placeholder="PD Date">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="pd_data_entry_date"><span>PD Data Entry Date</span></label>
                        <input type="date" name="pd_data_entry_date" id="pd_data_entry_date"
                            value="{{ $breedingData->pd_data_entry_date ?? '' }}" class="form-control"
                            placeholder="PD Data Entry Date">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="pd_id"> <span>PD ID</span></label>
                        <input type="number" name="pd_id" id="pd_id" value="{{ $breedingData->pd_id ?? '' }}"
                            class="form-control" placeholder="PD ID">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="pd_month"> <span>PD Month</span></label>
                        <input type="number" name="pd_month" id="pd_month" value="{{ $breedingData->pd_month ?? '' }}"
                            class="form-control" placeholder="PD Month">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="pd_bull_id"> <span>PD Bull ID</span></label>
                        <input type="number" name="pd_bull_id" id="pd_bull_id"
                            value="{{ $breedingData->pd_bull_id ?? '' }}" class="form-control" placeholder="PD Bull ID">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="pd_transaction_status"> <span>PD Transaction Status</span></label>
                        <input type="text" name="pd_transaction_status" id="pd_transaction_status"
                            value="{{ $breedingData->pd_transaction_status ?? '' }}" class="form-control"
                            placeholder="PD Transaction Status">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calving_date"> <span>Calving Date</span></label>
                        <input type="date" name="calving_date" id="calving_date"
                            value="{{ $breedingData->calving_date ?? '' }}" class="form-control"
                            placeholder="Calving Date">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calving_data_entry_date"> <span>Calving Data Entry Date</span></label>
                        <input type="date" name="calving_data_entry_date" id="calving_data_entry_date"
                            value="{{ $breedingData->calving_data_entry_date ?? '' }}" class="form-control"
                            placeholder="Calving Data Entry Date">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calving_id"> <span>Calving ID</span></label>
                        <input type="number" name="calving_id" id="calving_id"
                            value="{{ $breedingData->calving_id ?? '' }}" class="form-control" placeholder="Calving ID">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calf_bull_id"> <span>Calf Bull ID</span></label>
                        <input type="number" name="calf_bull_id" id="calf_bull_id"
                            value="{{ $breedingData->calf_bull_id ?? '' }}" class="form-control"
                            placeholder="Calf Bull ID">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="no_of_alves"> <span>No of Calves</span></label>
                        <input type="number" name="no_of_alves" id="pono_of_alvesst_office"
                            value="{{ $breedingData->no_of_alves ?? '' }}" class="form-control"
                            placeholder="No of Calves">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calving_ease"> <span>Calving Ease</span></label>
                        <input type="text" name="calving_ease" id="calving_ease"
                            value="{{ $breedingData->calving_ease ?? '' }}" class="form-control"
                            placeholder="Calving Ease">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calving_transaction_status"> <span>Calving Transaction Status</span></label>
                        <input type="text" name="calving_transaction_status" id="calving_transaction_status"
                            value="{{ $breedingData->calving_transaction_status ?? '' }}" class="form-control"
                            placeholder="Calving Transaction Status">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calf_1_tag_id"> <span>Calf 1 Tag ID</span></label>
                        <input type="text" name="calf_1_tag_id" id="calf_1_tag_id"
                            value="{{ $breedingData->calf_1_tag_id ?? '' }}" class="form-control"
                            placeholder="Calf 1 Tag ID">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calf_1_gender"> <span>Calf 1 Gender</span></label>
                        <input type="text" name="calf_1_gender" id="calf_1_gender"
                            value="{{ $breedingData->calf_1_gender ?? '' }}" class="form-control"
                            placeholder="Calf 1 Gender">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calf_1_status"> <span>Calf 1 Status</span></label>
                        <input type="text" name="calf_1_status" id="calf_1_status"
                            value="{{ $breedingData->calf_1_status ?? '' }}" class="form-control"
                            placeholder="Calf 1 Status">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calf_1_length"> <span>Calf 1 Length</span></label>
                        <input type="text" name="calf_1_length" id="calf_1_length"
                            value="{{ $breedingData->calf_1_length ?? '' }}" class="form-control"
                            placeholder="Calf 1 Length">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calf_1_girth"> <span>Calf 1 Girth</span></label>
                        <input type="text" name="calf_1_girth" id="calf_1_girth"
                            value="{{ $breedingData->calf_1_girth ?? '' }}" class="form-control"
                            placeholder="Calf 1 Girth">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calf_1_weight"> <span>Calf 1 Weight</span></label>
                        <input type="text" name="calf_1_weight" id="calf_1_weight"
                            value="{{ $breedingData->calf_1_weight ?? '' }}" class="form-control"
                            placeholder="Calf 1 Weight">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calf_1_genetic_defects"> <span>Calf 1 Genetic Defects</span></label>
                        <input type="text" name="calf_1_genetic_defects" id="calf_1_genetic_defects"
                            value="{{ $breedingData->calf_1_genetic_defects ?? '' }}" class="form-control"
                            placeholder="Calf 1 Genetic Defects">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calf_2_tag_id"> <span>Calf 2 Tag ID</span></label>
                        <input type="text" name="calf_2_tag_id" id="calf_2_tag_id"
                            value="{{ $breedingData->calf_2_tag_id ?? '' }}" class="form-control"
                            placeholder="Calf2 Tag ID">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calf_2_gender"> <span>Calf 2 Gender</span></label>
                        <input type="text" name="calf_2_gender" id="calf_2_gender"
                            value="{{ $breedingData->calf_2_gender ?? '' }}" class="form-control"
                            placeholder="Calf 2 Gender">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calf_2_status"> <span>Calf 2 Status</span></label>
                        <input type="text" name="calf_2_status" id="calf_2_status"
                            value="{{ $breedingData->calf_2_status ?? '' }}" class="form-control"
                            placeholder="Calf 2 Status">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calf_2_length"> <span>Calf 2 Length</span></label>
                        <input type="text" name="calf_2_length" id="calf_2_length"
                            value="{{ $breedingData->calf_2_length ?? '' }}" class="form-control"
                            placeholder="Calf 2 Length">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calf_2_girth"> <span>Calf 2 Girth</span></label>
                        <input type="text" name="calf_2_girth" id="calf_2_girth"
                            value="{{ $breedingData->calf_2_girth ?? '' }}" class="form-control"
                            placeholder="Calf 2 Girth">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calf_2_weight"> <span>Calf 2 Weight</span></label>
                        <input type="text" name="calf_2_weight" required id="calf_2_weight"
                            value="{{ $breedingData->calf_2_weight ?? '' }}" class="form-control"
                            placeholder="Calf 2 Weight">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="calf_2_genetic_defects"> <span>Calf 2 Genetic Defects</span></label>
                        <input type="text" name="calf_2_genetic_defects" id="calf_2_genetic_defects"
                            value="{{ $breedingData->calf_2_genetic_defects ?? '' }}" class="form-control"
                            placeholder="Calf 2 Genetic Defects">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="treated_for_milk"> <span>Treated for Milk Fever</span></label>
                        <input type="number" name="treated_for_milk" id="treated_for_milk"
                            value="{{ $breedingData->treated_for_milk ?? '' }}" class="form-control"
                            placeholder="Treated for Milk Fever">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="treated_for_ketosis"> <span>Treated for Ketosis</span></label>
                        <input type="number" name="treated_for_ketosis" id="treated_for_ketosis"
                            value="{{ $breedingData->treated_for_ketosis ?? '' }}" class="form-control"
                            placeholder="Treated for Ketosis">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="treated_for_downer_syndrome"> <span>Treated for Downer Syndrome</span></label>
                        <input type="number" name="treated_for_downer_syndrome" id="treated_for_downer_syndrome"
                            value="{{ $breedingData->treated_for_downer_syndrome ?? '' }}" class="form-control"
                            placeholder="Treated for Downer Syndrome">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="retention_of_placenta"> <span>Retention of Placenta</span></label>
                        <input type="text" name="retention_of_placenta" id="retention_of_placenta"
                            value="{{ $breedingData->retention_of_placenta ?? '' }}" class="form-control"
                            placeholder="Retention of Placenta">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="prolapse"> <span>Prolapse</span></label>
                        <input type="text" name="prolapse" id="prolapse" value="{{ $breedingData->prolapse ?? '' }}"
                            class="form-control" placeholder="Prolapse">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="colostrum_feeding"> <span>Colostrum Feeding</span></label>
                        <input type="text" name="colostrum_feeding" id="colostrum_feeding"
                            value="{{ $breedingData->colostrum_feeding ?? '' }}" class="form-control"
                            placeholder="Colostrum Feeding">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="cutting_of_naval_cord"> <span>Cutting of Naval Cord</span></label>
                        <input type="text" name="cutting_of_naval_cord" id="cutting_of_naval_cord"
                            value="{{ $breedingData->cutting_of_naval_cord ?? '' }}" class="form-control"
                            placeholder="Cutting of Naval Cord">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="metabolic_disease"> <span>Metabolic Disease</span></label>
                        <input type="text" name="metabolic_disease" id="metabolic_disease"
                            value="{{ $breedingData->metabolic_disease ?? '' }}" class="form-control"
                            placeholder="Metabolic Disease">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="colostrum_feeding_within"> <span>Colostrum Feeding Within Two Hours</span></label>
                        <input type="text" name="colostrum_feeding_within" id="colostrum_feeding_within"
                            value="{{ $breedingData->colostrum_feeding_within ?? '' }}" class="form-control"
                            placeholder="Colostrum Feeding Within Two Hours">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="tag_id"> <span>Tag ID</span></label>
                        <input type="text" name="tag_id" id="tag_id" value="{{ $breedingData->tag_id ?? '' }}"
                            class="form-control" placeholder="Tag ID">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="species"> <span>Species</span></label>
                        <select name="species" id="species" class="form-control">
                            <option value="">Select any one</option>
                            <option value="buffalo"
                                {{ isset($breedingData->species) && $breedingData->species == 'buffalo' ? 'selected' : '' }}>
                                Buffalo
                            </option>
                            <option value="cattle"
                                {{ isset($breedingData->species) && $breedingData->species == 'cattle' ? 'selected' : '' }}>
                                Cattle
                            </option>
                            <option value="goat"
                                {{ isset($breedingData->species) && $breedingData->species == 'goat' ? 'selected' : '' }}>
                                Goat
                            </option>
                        </select>


                    </div>

                    <div class="form-group col-md-4">
                        <label for="owner_name"> <span>Owner Name</span></label>
                        <input type="text" name="owner_name" id="owner_name"
                            value="{{ $breedingData->transaction_date ?? '' }}" class="form-control"
                            placeholder="Owner Name">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="owner_gender"> <span>Owner Gender</span></label>
                        <select name="owner_gender" id="owner_gender" class="form-control">
                            <option value="">Select any one</option>
                            <option value="male"
                                {{ isset($breedingData->owner_gender) && $breedingData->owner_gender == 'male' ? 'selected' : '' }}>
                                Male
                            </option>
                            <option value="female"
                                {{ isset($breedingData->owner_gender) && $breedingData->owner_gender == 'female' ? 'selected' : '' }}>
                                Female
                            </option>
                        </select>


                    </div>

                    <div class="form-group col-md-4">
                        <label for="owner_mobile_no"> <span>Owner Mobile No</span></label>
                        <input type="number" name="owner_mobile_no" id="owner_mobile_no"
                            value="{{ $breedingData->transaction_date ?? '' }}" class="form-control"
                            placeholder="Owner Mobile No">
                    </div>

                </div>

                <div class="row">
                    <div class="mb-4 mt-5 m-auto">
                        <button type="submit" class="btn btn-primary submit buttonWizard">
                            <span>सबमिट</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script>
$(document).ready(function() {

    var allData = {};



    $('#district').change(function() {
        $('#mandal').prop('disabled', false);
        $('#mandal').empty();
        $('#vikas_khand').prop('disabled', false);
        $('#vikas_khand').empty();
        $('#ai_center').prop('disabled', false);
        $('#ai_center').empty();
        $('#tehsil').prop('disabled', false);
        $('#tehsil').empty();

        var val = $("#district option:selected").val();
        var text = $("#district option:selected").text();
        if (val) {
            $.ajax({
                type: "GET",
                url: "get-all-district",
                data: {
                    "id": val,
                    "mandal": text,
                },
                cache: false,
                success: function(data) {
                    var getMandal = data.data;
                    if (getMandal && getMandal.length > 0) {
                        $('#mandal').append(`<option value="">जिला चुने</option>`);
                        getMandal.forEach(item => {
                            if (item.janpad_name && item.janpad_name.trim() !==
                                '') {
                                $('#mandal').append(
                                    `<option value="${item.janpad_name}">${item.janpad_name}</option>`
                                );
                            }
                        });
                    } else {
                        $('#mandal').append('<option value="">-Data not found.-</option>');
                    }
                }
            });
        }
    });

    $('#mandal').change(function() {
        $('#vikas_khand').prop('disabled', false);
        $('#vikas_khand').empty();
        $('#ai_center').prop('disabled', false);
        $('#ai_center').empty();
        $('#tehsil').prop('disabled', false);
        $('#tehsil').empty();

        var mandal = $("#district option:selected").text();
        var janpad = $("#mandal option:selected").val();
        $.ajax({
            type: "GET",
            url: "get-all-tehsil",
            data: {
                "mandal": mandal,
                "janpad": janpad,
            },
            cache: false,
            success: function(data) {
                var getTehsil = data.data;
                if (getTehsil && getTehsil.length > 0) {
                    $('#tehsil').append(`<option value="">तहसील चूने</option>`);
                    getTehsil.forEach(item => {
                        if (item.tehsil && item.tehsil.trim() !== '') {
                            $('#tehsil').append(
                                `<option value="${item.tehsil}">${item.tehsil}</option>`
                            );
                        }
                    });
                } else {
                    $('#tehsil').append('<option value="">-Data not found.-</option>');
                }
            }
        });
    });

    $('#tehsil').change(function() {
        $('#vikas_khand').prop('disabled', false);
        $('#vikas_khand').empty();
        $('#ai_center').prop('disabled', false);
        $('#ai_center').empty();
        var tehsil = $(this).val();
        var mandal = $("#district option:selected").text();
        var janpad = $("#mandal option:selected").val();
        $.ajax({
            type: "GET",
            url: "get-all-block",
            data: {
                "tehsil": tehsil,
                "mandal": mandal,
                "janpad": janpad,
            },
            cache: false,
            success: function(data) {
                var getBlock = data.data;
                if (getBlock && getBlock.length > 0) {
                    $('#vikas_khand').append(
                        `<option value="">विकास खंड चूने</option>`);
                    getBlock.forEach(item => {
                        if (item.block && item.block.trim() !== '') {
                            $('#vikas_khand').append(
                                `<option value="${item.block}">${item.block}</option>`
                            );
                        }
                    });
                } else {
                    $('#vikas_khand').append('<option value="">-Data not found.-</option>');
                }
            }
        });
    });

    $.ajax({
        url: "{{ route('check-breeding-details') }}",
        type: "GET",
        success: function(response) {


            var getUserData = response.userData;
            var district = response.districtName;

            if (getUserData.division_id) {
                $('#district').val(getUserData.division_id);
                $('#district').change();
                $('#district option[value="' + getUserData.division_id + '"]').click();
            }

            setTimeout(() => {
                if (district) {
                    $('#mandal').val(district);
                    $('#mandal').change();
                    $('#mandal option[value="' + district + '"]').click();
                }
            }, 1000);

            setTimeout(() => {
                if (getUserData.tehsil) {
                    $('#tehsil').val(getUserData.tehsil);
                    $('#tehsil').change();
                    $('#tehsil option[value="' + getUserData.tehsil + '"]').click();
                }
            }, 1300);

            setTimeout(() => {
                if (getUserData.vikas_khand) {
                    $('#vikas_khand').val(getUserData.vikas_khand);
                    $('#vikas_khand').change();
                    $('#vikas_khand option[value="' + getUserData.vikas_khand + '"]')
                        .click();
                }
            }, 1600);


        },
        error: function(xhr) {
            console.error("An error occurred:", xhr.responseJSON.message);
        }
    });

});
</script>