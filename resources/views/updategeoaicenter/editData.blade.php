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
        <h2><span data-hi="एआई केंद्र डेटा संपादित करें" data-en="Edit AI Center data"></span></h2>

        <form action="{{ route('update-aicenter-data') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="aicenter_id" value="{{ $getaicenter['id'] }}"/>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="title"><span data-hi="मंडल का नाम" data-en="Mandal Name"></span></label>
                      
                        <input type="text" readonly name="mandal_name"  class="form-control" value="{{ $getaicenter['mandal_name'] }}"/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="title"><span data-hi="जनपद का नाम" data-en="Janpad Name"></span></label>
                        <input type="text" readonly name="janpad_name" class="form-control" value="{{ $getaicenter['janpad_name'] }}"/>
                    </div>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="title"><span data-hi="एआई सेंटर" data-en="AI Center"></span></label>
                        <input type="text" name="center_name" class="form-control" value="{{ $getaicenter['name'] }}"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="title"><span data-hi="अक्षांश" data-en="Latitude"></span></label>
                        <input type="text" name="latitude" class="form-control" value="{{ $getaicenter['lattitute'] }}"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="title"><span data-hi="देशान्तर" data-en="Longitude"></span></label>
                        <input type="text" name="longitude" class="form-control" value="{{ $getaicenter['longitute'] }}"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="title"><span data-hi="स्थिति" data-en="Status"></span></label>
                        <select name="status" class="form-control">
                            <option value="" data-hi="स्थिति चुनें" data-en="Select Status"></option>
                            <option value="0" @if($getaicenter['status'] == 0) selected @endif>Active</option>
                            <option value="1" @if($getaicenter['status'] == 1) selected @endif>Inactive</option>
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