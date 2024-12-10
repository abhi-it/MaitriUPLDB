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
        <h2><span data-hi="मैत्री/एआई केंद्र डेटा संपादित करें" data-en="Edit Maitri/AI Center data"></span></h2>

        <form action="{{ route('update-mairti-aicenter-data') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="maitri_id" value="{{ $editData['id'] }}"/>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="title"><span data-hi="मंडल का नाम" data-en="Mandal Name"></span></label>
                        <input type="text" name="mandal_name"  class="form-control" value="{{ $editData['mandal_name'] }}"/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="title"><span data-hi="जनपद का नाम" data-en="Janpad Name"></span></label>
                        <input type="text" name="janpad_name" class="form-control" value="{{ $editData['janpad_name'] }}"/>
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
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="title"><span data-hi="ब्लॉक का नाम" data-en="Block"></span></label>
                        <input type="text" name="block" class="form-control" value="{{ $editData['block'] }}"/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="title"><span data-hi="तहसील" data-en="Tehsil"></span></label>
                        <input type="text" name="tehsil" class="form-control" value="{{ $editData['tehsil'] }}"/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="title"><span data-hi="मोबाइल नंबर" data-en="Mobile Number"></span></label>
                        <input type="text" name="maitri_mobile_no" class="form-control" value="{{ $editData['maitri_mobile_no'] }}"/>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-6">
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
                        <label for="title"><span data-hi="Longitude" data-en="Longitude"></span></label>
                        <input type="text" name="longitude" class="form-control" value="{{ $editData['longitude'] }}"/>
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