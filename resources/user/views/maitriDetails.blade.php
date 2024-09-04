@extends('master')
@section('content')
@php
use App\Models\Districts;
@endphp
<div class="container main-div" style="background-color:white; height: 100%;">
    <!--First row Start -->
	 
 <h4 style="margin-top:10px;text-align: center;">{{$heading}}
		<div class=" pull-right">
			<a href="javascript:history.back()" class="btn btn-info">Back</a>
		</div>
 </h4>
@if(session()->get('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}  
  </div>
@endif
<style>
.form-control-span {
    display: inline;
    width: 100%;
    font-size: 12px;
    line-height: 1.25;
    color: #060ded;
    background-color: #fff;
    background-image: none;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    /*border: 1px solid rgba(0,0,0,.15);*/
    border-radius: 0.25rem;
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
}
</style>


			<div class="row" style="margin-top:20px;">
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">तहसील </label> : {{$result->tehseel}}
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">विकास खण्ड </label> : {{$result->vikas_khand}}
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">पशुचिकित्सालय  का नाम </label> : {{$result->animal_hospitals}}
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">ग्राम पंचायत </label> : {{$result->gram_panchayat}}
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">मैत्री का कार्यक्षेत्र </label> : {{$result->maitri_workfield}}
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4"> प्राइवेट कृत्रिम गर्भाधान कार्यकर्ता/पशुमित्र/मैत्री का नाम </label> : {{$result->maitri_name}}
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">पिता का नाम </label> : {{$result->father}}
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">पता </label> : {{$result->address}}
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">मोबाईल नं0 </label> : {{$result->mobile}}
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">किस योजनान्तर्गत प्रशिक्षण प्राप्त किया यू पी एल डी बी  / डास्प /बायफ /पशुपालन विभाग /अन्य </label> : {{$result->training_name}}
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">संस्था का नाम जहाँ से प्रशिक्षण प्राप्त किया गया </label> : {{$result->institute}}
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">प्रशिक्षण अविध(दिन में) </label> : {{$result->training_period}}
				</div>

			</div>
		
  
        

</div>

 @endsection 
