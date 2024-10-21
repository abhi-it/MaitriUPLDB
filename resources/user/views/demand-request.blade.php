@extends('master')
@section('content')
<div class="container main-div py-5" style="background-color:white; height: 100%; min-height:380px;">
    <!--First row Start -->
	 
 <h1 style="margin-top:10px;text-align: center;">डिमांड रिक्वेस्ट्स फॉर्म </h1>
@if (session('error'))
<div class="alert alert-danger">
	{{ session('error') }}
</div>
@endif
@if (session('success'))
<div class="alert alert-success">
	{{ session('success') }}
</div>
@endif
@if($errors)
	@foreach ($errors->all() as $error)
	<div class="alert alert-danger">{{ $error }}</div>
	@endforeach
@endif
	<form method="POST" action="{{ route('addDemandRequests') }}" id="loginForm" name="loginForm" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-right"> नाम </label>

            <div class="col-md-6">
                <input name="name" id="name" type="text" class="form-control"  autofocus="off">
            </div>
        </div>
        <div class="row mb-3">
            <label for="dateofbirth" class="col-md-4 col-form-label text-md-right">जन्म की तारीख </label>

            <div class="col-md-6">
                <input name="date_of_birth" id="date_of_birth" type="date" class="form-control"  autofocus>
            </div>
        </div>
        <div class="row mb-3">
            <label for="gender" class="col-md-4 col-form-label text-md-right">लिंग</label>

            <div class="col-md-6">
                <select name="gender" id="gender"  class="form-control"  autofocus>
                        <option value="">-select one-</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">प्रशिक्षण केंद्र आईडी </label>

            <div class="col-md-6">
                <input name="training_center_id" id="training_center_id" type="text" class="form-control"  autofocus>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">भारत पशुधन आईडी</label>

            <div class="col-md-6">
                <input name="bharat_pashudhan_id" id="bharat_pashudhan_id" type="text" class="form-control"  autofocus>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">स्मार्ट मोबाइल नंबर</label>

            <div class="col-md-6">
                <input name="smart_mobile_no" id="smart_mobile_no" type="text" class="form-control"  autofocus>
            </div>
        </div>

        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">ज़िला </label>
            <div class="col-md-6">
                <select name="district" id="district" class="form-control"  autofocus>
                    <option>-select one-</option>
                    @if(count($district)>0)
                    @foreach($district as $key=>$val)
                    <option value="{{$val->id}}">{{$val->name_hindi}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">ब्लॉक  </label>
            <div class="col-md-6">
                <select name="block" id="block" class="form-control"  autofocus>
                    
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">मंडल </label>
            <div class="col-md-6">
                <select name="district" id="district" class="form-control"  autofocus>
                    <option>-select one-</option>
                    @if(count($district)>0)
                    @foreach($district as $key=>$val)
                    <option value="{{$val->id}}">{{$val->name_hindi}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>



        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">वीएच/ एआई सेंटर</label>

            <div class="col-md-6">
                <select  name="vh_ai_center" id="vh_ai_center"  class="form-control"  autofocus>
                    <option>-select one-</option>
                    @if(count($institute)>0)
                    @foreach($institute as $val)
                    <option value="{{$val->id}}">{{$val->name}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">गांवों को कवर </label>

            <div class="col-md-6">
                <input name="villages_coevring" id="villages_coevring" type="text" class="form-control"  autofocus>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">मांग अनुभाग</label>
            <div class="col-md-6">
                <input name="demand_section" id="demand_section" type="text" class="form-control"  autofocus>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">सीमेन</label>

            <div class="col-md-6">
                <select name="semen" id="semen"  class="form-control"  autofocus>
                    <option>-select one-</option>
                    <option>गाय (Cattle)</option>
                    <option>भैंस (Buffalo)</option>
                    <option>बकरी (Goat)</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">नस्ल</label>

            <div class="col-md-6">
                <input name="breed" id="breed" type="text" class="form-control"  autofocus>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">बुल आई.डी.</label>

            <div class="col-md-6">
                <input name="bull_id" id="bull_id" type="text" class="form-control"  autofocus>
            </div>
        </div>                      
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">शीत</label>
            <div class="col-md-6">
                <input name="Sheath" id="Sheath" type="text" class="form-control"  autofocus>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">ग्लव्स </label>

            <div class="col-md-6">
                <input name="gloves" id="gloves" type="text" class="form-control"  autofocus>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">पशु टैग</label>

            <div class="col-md-6">
                <input name="animal_tag" id="animal_tag" type="text" class="form-control"  autofocus>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">खनिज मिश्रण</label>

            <div class="col-md-6">
                <input name="mineral_mixture" id="mineral_mixture" type="text" class="form-control"  autofocus>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">कृमिनाशक</label>

            <div class="col-md-6">
                <input name="dewormer" id="dewormer" type="text" class="form-control"  autofocus>
            </div>
        </div> 
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">बीमा पुस्तिका</label>

            <div class="col-md-6">
                <input name="insurance_booklet" id="insurance_booklet" type="text" class="form-control"  autofocus>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">गर्भावस्था फ़ीड</label>

            <div class="col-md-6">
                <input name="pregnancy_feed" id="pregnancy_feed" type="text" class="form-control"  autofocus>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">बछड़ा स्टार्टर</label>

            <div class="col-md-6">
                <input name="calf_starter" id="calf_starter" type="text" class="form-control"  autofocus>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">कोई अन्य वस्तु</label>

            <div class="col-md-6">
                <input name="any_other_item" id="any_other_item" type="text" class="form-control"  autofocus>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">कोई सुझाव?</label>

            <div class="col-md-6">
                <input name="any_suggestion" id="any_suggestion" type="text" class="form-control"  autofocus>
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">कोई शिकायत?</label>

            <div class="col-md-6">
                <input name="any_complaint" id="any_complaint" type="text" class="form-control"  autofocus>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary" id="btn">सबमिट</button>
            </div>
        </div>
    </form>
<!--First row Closed-->
</div>
<script>	
$('#district').change(function() {
    var val = $("#district option:selected").val();
    console.log('value',val)
    if (val) {
        $.ajax({
            type: "GET",
            url: "getAllrequestedBlocks",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "_token": "{{ csrf_token() }}",
                "id": val
            },
            cache: false,
            success: function(data) {
                $('#block').empty();
                if(data.data.length>0){
                    $('#block').append($("<option>-Select one-</option>"));
                    $.each(data.data, function(i, index) {
                        console.log(index, i);
                        $('#block').append($("<option value="+index+">"+index+"</option>"));
                    });
                }else{
                    $('#block').append($("<option>Data not found.</option>"));
                }
            }
        });
    }
});
</script>
 @endsection 
