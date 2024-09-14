@extends('master')
@section('content')
<div class="container main-div py-5" >
    <!--First row Start -->
	 
 <h1 style="margin-top:10px;text-align: center;">आवेदन - पत्र</h1>
@if(session()->get('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}  
  </div>
@endif

        <!------Summary Page Start---------------->
        
        
        <div class="col-12 p-4 text-center">
    <div class="row">
        <div class="col-12 col-md-12">
           <label for="inputPassword4" style="font-weight:bold;">आवेदन करने की प्रारंभ तिथि : </label>   {{\Carbon\Carbon::parse($result->start_date)->format('d/m/Y')}}
        </div>
        <div class="col-12 col-md-12">
           <label for="inputPassword4" style="font-weight:bold;">आवेदन करने की अंतिम तिथि : </label> {{\Carbon\Carbon::parse($result->end_date)->format('d/m/Y')}}
        </div>
        
        <div class="col-12 col-md-12"><!--{{url('application-form')}}-->
           <label for="inputPassword4" style="font-weight:bold;">
			   @if($avedanStart)
			   <a class="nav-link" href="{{url('application-form')}}"><h3>आवेदन करने के लिए यहाँ क्लिक करें</h3></a>
			   @else
						@if($messsage!='')
						<h3 style="color:red;">{{$messsage}}</h3>
						@else
						<h3 style="color:red;">आवेदन {{\Carbon\Carbon::parse($result->start_date)->format('d/m/Y')}} से प्रारम्भ होंगे</h3>
						@endif
				@endif
			   
			   </label>
        </div>
    </div>
  </div> 
        
        
        <!------Summary Page End---------------->
     
        

</div>

 @endsection 
