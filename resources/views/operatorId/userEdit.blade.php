@extends('master')
@section('content')

<style>
.errorclass {
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

    <div class="container">
        <h2><span data-hi="यूजर को संपादित करो" data-en="Edit User"></span></h2>

        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="title"><span data-hi="नाम" data-en="Name"></span></label>
                        <input type="text" name="title" class="form-control" value="{{ $userData['FirstName'] }}"
                            required/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="title"><span data-hi="उपयोगकर्ता नाम" data-en="User Name"></span></label>
                        <input type="text" name="title" class="form-control" value="{{ $userData['name'] }}"
                            required/>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="title"><span data-hi="ईमेल" data-en="Email"></span></label>
                        <input type="email" name="title" class="form-control" value="{{ $userData['email'] }}"
                            required/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="title"><span data-hi="पासवर्ड" data-en="Password"></span></label>
                        <input type="password" name="title" class="form-control" value=""
                            required/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="title"><span data-hi="क्षेत्र चुनें" data-en="Select Zone"></span></label>
                        <select name="select_zone" id="select_zone" class="form-control">
                            <option value="" data-hi="क्षेत्र चुनें" data-en="Select Zone"></option>
                            @foreach($zoneData as $zone)
                                <option value="{{ $zone['id'] }}" {{ $zone['id'] == $zone_id ? 'selected' : '' }} data-hi="{{ $zone['name_hi'] }}" data-en="{{ $zone['name_en'] }}"></option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if($userData['role'] == 'district')
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="title"><span data-hi="जिला चुनें" data-en="Select District"></span></label>
                        <select name="select_district" id="select_zone" class="form-control">
                            <option value="" data-hi="जिला चुनें" data-en="Select District"></option>
                            @foreach($getDistrict as $district)
                                <option value="{{ $district['id'] }}" {{ $district['id'] == $userData['district_id'] ? 'selected' : '' }} data-hi="{{ $district['name_hindi'] }}" data-en="{{ $district['name_eng'] }}"></option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif
                @if($userData['role'] == 'deo')
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="title"><span data-hi="एआई केंद्र का चयन करें" data-en="Select Ai Center"></span></label>
                        <select name="select_aiCenter" id="select_zone" class="form-control">
                            <option value="" data-hi="एआई केंद्र का चयन करें" data-en="Select Ai Center"></option>
                            @foreach($zoneData as $zone)
                                <option value="{{ $zone['id'] }}" {{ $zone['id'] == $zone_id ? 'selected' : '' }} data-hi="{{ $zone['name_hi'] }}" data-en="{{ $zone['name_en'] }}"></option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{ asset('assets/js/checkRemaninngStock.js') }}"></script>
    
    
</div>
<script>


</script>

@endsection