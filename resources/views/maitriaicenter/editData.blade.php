@extends('master')
@section('content')

<style>
.errorclass {
    font-size: 8px;
    color: red;
}
</style>
<div class="container main-div py-5" style="background-color:white;">

    <div class="container">
        <h2><span data-hi="मांग अनुरोध और सूची संपादित करें" data-en="Edit Demand Request & Inventory"></span></h2>

        <form action="{{ route('update-mairti-aicenter-data') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="maitri_id" value="{{ $editData['id'] }}"/>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="title"><span data-hi="मंडल का नाम" data-en="Mandal Name"></span></label>
                        <!-- <select name="mandal_name" class="form-control" readonly>
                            <option value="" data-hi="मंडल चुनें" data-en="Select Mandal"></option>
                            @foreach($divisions as $division)
                                <option value="{{ $division['name_hindi'] }}" data-hi="{{ $division['name_hindi'] }}"
                                data-en="{{ $division['name_eng'] }}" @if($editData['mandal_name'] == $division['name_hindi']) selected @endif></option>
                            @endforeach
                        </select> -->
                        <input type="text" readonly name="mandal_name"  class="form-control" value="{{ $editData['mandal_name'] }}"/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="title"><span data-hi="जनपद का नाम" data-en="Janpad Name"></span></label>
                        <!-- <select name="janpad_name" class="form-control" readonly>
                            <option value="" data-hi="जिला चुनें" data-en="Select District"></option>
                            @foreach($districts as $district)
                                <option value="{{ $district['name_hindi'] }}" data-hi="{{ $district['name_hindi'] }}"
                                data-en="{{ $district['name_eng'] }}" @if($editData['janpad_name'] == $district['name_hindi']) selected @endif></option>
                            @endforeach
                        </select> -->
                        <input type="text" readonly name="janpad_name" class="form-control" value="{{ $editData['janpad_name'] }}"/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="title"><span data-hi="मैत्री नाम" data-en="Maitri Name"></span></label>
                        <input type="text" name="maitri_name" class="form-control" value="{{ $editData['maitri_name'] }}"/>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="title"><span data-hi="ब्लॉक का नाम" data-en="Block"></span></label>
                        <input type="text" name="block" class="form-control" value="{{ $editData['block'] }}"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="title"><span data-hi="तहसील" data-en="Tehsil"></span></label>
                        <input type="text" name="tehsil" class="form-control" value="{{ $editData['tehsil'] }}"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="title"><span data-hi="मोबाइल नंबर" data-en="Mobile Number"></span></label>
                        <input type="text" name="maitri_mobile_no" class="form-control" value="{{ $editData['maitri_mobile_no'] }}"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="title"><span data-hi="भारत पशुधन आईडी" data-en="Bharat Pashudhan Id"></span></label>
                        <input type="text" name="bharat_pasudhan_id" class="form-control"/>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="title"><span data-hi="एआई सेंटर" data-en="AI Center"></span></label>
                        <input type="text" name="center_name" class="form-control" value="{{ $editData['center_name'] }}"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="title"><span data-hi="अक्षांश" data-en="Latitude"></span></label>
                        <input type="text" name="latitude" class="form-control" value="{{ $editData['latitude'] }}"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="title"><span data-hi="देशान्तर" data-en="Longitude"></span></label>
                        <input type="text" name="longitude" class="form-control" value="{{ $editData['longitude'] }}"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="title"><span data-hi="स्थिति" data-en="Status"></span></label>
                        <select name="status" class="form-control">
                            <option value="" data-hi="स्थिति चुनें" data-en="Select Status"></option>
                            <option value="0" @if($editData['status'] == 0) selected @endif>Active</option>
                            <option value="1" @if($editData['status'] == 1) selected @endif>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{ asset('assets/js/checkRemaninngStock.js') }}"></script>
    
    
</div>
<script>


</script>

@endsection