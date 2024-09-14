@extends('master')
@section('content')
<div class="container main-div py-5" >
    <!--First row Start -->
	 
    <h3 class="text-center fw-bold m-4">
   <span data-hi="आवेदन - पत्र" data-en="Application letter"></span>
 </h3>
@if(session()->get('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}  
  </div>
@endif

        <!------Summary Page Start---------------->
        
        
        <div class="col-12 p-4 text-center">
       <div class="row">
        <div class="col-12 col-md-12">
           <label for="inputPassword4" style="font-weight:bold;">
           <span data-hi="आवेदन करने की प्रारंभ तिथि" data-en="Start date for application">
            : </label>   {{\Carbon\Carbon::parse($result->start_date)->format('d/m/Y')}}
        </div>
        <div class="col-12 col-md-12">
           <label for="inputPassword4" style="font-weight:bold;">
           <span data-hi="आवेदन करने की अंतिम तिथि" data-en="Last date for application">
            : </label> {{\Carbon\Carbon::parse($result->end_date)->format('d/m/Y')}}
        </div>
        
        <div class="col-12 col-md-12"><!--{{url('application-form')}}-->
           <label for="inputPassword4" style="font-weight:bold;">
			   @if($avedanStart)
			   <a class="nav-link" href="{{url('application-form')}}">
               <h3><span data-hi="आवेदन करने के लिए यहाँ क्लिक करें" data-en="Click here to apply"></h3>
            </a>
			   @else
						@if($messsage!='')
						<h3 style="color:red;">{{$messsage}}</h3>
						@else
						<h3 style="color:red;">
                  <span data-hi="आवेदन" data-en="Application">   
                   {{\Carbon\Carbon::parse($result->start_date)->format('d/m/Y')}}
                   <span data-hi="से प्रारम्भ होंगे |"  data-en="will start from.">   
                  </h3>
						@endif
				@endif
			   
			   </label>
        </div>
    </div>
  </div> 
        
        
        <!------Summary Page End---------------->
     
        

</div>

 @endsection 
