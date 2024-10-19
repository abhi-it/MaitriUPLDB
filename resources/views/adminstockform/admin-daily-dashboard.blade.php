@extends('master')
@section('content')

<style>
    .errorclass{
        font-size: 8px;
        color: red;
    }
</style>
<div class="container main-div py-5" style="background-color:white;">
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
    <h3 class="text-center fw-bold m-4">
        <span data-hi="दैनिक डैशबोर्ड" data-en="Daily Dashboard"></span>
    </h3>
    
    <form method="post" action="{{ route('save-daily-dashboard') }}" class="form-comman">
        @csrf
        <hr>
        @php
            $startYear = 2020; // Starting year
            $endYear = date('Y'); // Current year
            $selectedYear = 2026; // The selected start year (2026-2027)
        @endphp

        <div class="row">
            <div class="number_of_ai">
                <label for="inputEmail4"> 
                    <span data-hi="AI पूर्ण की गई संख्या" data-en="Number of AI"></span>
                </label> 
                <div class="row">
                    <div class="form-group col-md-6">
                        <select name="num_of_ai_year" id="num_of_ai_year" class="form-control" autofocus="">
                            <option value="" data-hi="वर्ष चुनें" data-en="select Year"></option>
                            @for ($year = $startYear; $year <= $endYear; $year++)
                                <option value="{{ $year }}-{{ $year + 1 }}" 
                                    {{ $year == $selectedYear ? 'selected' : '' }}>
                                    {{ $year }}-{{ $year + 1 }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="num_of_ai" class="form-control" data-placeholder-hi="AI की संख्या दर्ज करें" data-placeholder-en="Enter Number of AI" autofocus/>
                    </div>
                </div>
            </div>
            <div class="mt-3 number_of_pd">
                <label for="inputEmail4"> 
                    <span data-hi="पूर्ण किये गए पी.डी. की संख्या" data-en="Number of PD"></span>
                </label> 
                <div class="row">
                    <div class="form-group col-md-6">
                        <select name="num_of_pd_year" id="num_of_pd_year" class="form-control" autofocus="">
                            <option value="" data-hi="वर्ष चुनें" data-en="select Year"></option>
                            @for ($year = $startYear; $year <= $endYear; $year++)
                                <option value="{{ $year }}-{{ $year + 1 }}" 
                                    {{ $year == $selectedYear ? 'selected' : '' }}>
                                    {{ $year }}-{{ $year + 1 }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="num_of_pd" class="form-control" data-placeholder-hi="पीडी की संख्या दर्ज करें" data-placeholder-en="Number of PD" autofocus/>
                    </div>
                </div>
            </div>
            <div class="mt-3 number_of_Calving">
                <label for="inputEmail4"> 
                    <span data-hi="बछड़ों की संख्या" data-en="Number of Calving"></span>
                </label> 
                <div class="row">
                    <div class="form-group col-md-6">
                        <select name="num_of_calving_year" id="num_of_calving_year" class="form-control" autofocus="">
                            <option value="" data-hi="वर्ष चुनें" data-en="select Year"></option>
                            @for ($year = $startYear; $year <= $endYear; $year++)
                                <option value="{{ $year }}-{{ $year + 1 }}" 
                                    {{ $year == $selectedYear ? 'selected' : '' }}>
                                    {{ $year }}-{{ $year + 1 }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="num_of_calving" class="form-control" data-placeholder-hi="बछड़ों की संख्या दर्ज करें" data-placeholder-en="Enter Number of Calving" autofocus/>
                    </div>
                </div>
            </div>
            <div class="mt-3 number_of_insurance">
                <label for="inputEmail4"> 
                    <span data-hi="बीमा की संख्या" data-en="Number of Insurance"></span>
                </label> 
                <div class="row">
                    <div class="form-group col-md-6">
                        <select name="number_of_insurance_year" id="number_of_insurance_year" class="form-control" autofocus="">
                            <option value="" data-hi="वर्ष चुनें" data-en="select Year"></option>
                            @for ($year = $startYear; $year <= $endYear; $year++)
                                <option value="{{ $year }}-{{ $year + 1 }}" 
                                    {{ $year == $selectedYear ? 'selected' : '' }}>
                                    {{ $year }}-{{ $year + 1 }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="number_of_insurance" class="form-control" data-placeholder-hi="बीमा की संख्या दर्ज करें" data-placeholder-en="Enter Number of Insurance" autofocus/>
                    </div>
                </div>
            </div>
        </div>
        <!------Summary Page End---------------->
        <div class="row">
            <div class="mb-4 mt-4 text-center" >
                <button type="submit" class="btn btn-primary submit buttonWizard">
                    <span data-en="Submit" data-hi="सबमिट"></span>
                </button>
            </div>
        </div>
    </form>
    <h3 class="text-center fw-bold m-4">
        <span data-hi="दैनिक डैशबोर्ड रिकॉर्ड" data-en="Daily Dashboard Record"></span>
        </h3>
        <table class="table table-striped  table-responsive table-bordered">
        <thead>
            <tr>
                <th><span data-hi="AI पूर्ण की गई संख्या" data-en="Number of AI"></span></th>
                <th><span data-hi="वीर्य" data-en="Number of AI Year"></span></th>
                <th><span data-hi="वीर्य का प्रकार" data-en="Number of PD"></span></th>
                <th><span data-hi="बैनर" data-en="Number of PD Year"></span></th>
                <th> <span data-hi="कामचोर" data-en="Number of Calving"></span></th>
                <th><span data-hi="स्टैन्डी" data-en="Number of Calving Year"></span></th>
                <th><span data-hi="पुस्तिका" data-en="Number of Insurance"></span></th>
                <th> <span data-hi="एआई किट" data-en="Number of Insurance Year"></span> </th>
                <th> <span data-hi="अद्यतन" data-en="Update"></span> </th>
            </tr>
        </thead>
        <tbody>


        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{ asset('assets/js/checkRemaninngStock.js') }}"></script>

@endsection 