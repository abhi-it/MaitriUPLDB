@extends('master')
@section('content')
<div class="container main-div py-5" style="background-color:white;">
    <!--First row Start -->
	 
	<h3 class="text-center fw-bold m-4">
	<span data-hi="आवेदन की स्थिति जानिए" data-en="Know the status of the application"></span>	
 </h3>
@if(session()->get('success'))
  <div class="alert alert-danger">
      {{ session()->get('success') }}  
  </div>
@endif
@if ($errors->any())
  <div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
		  <li>{{ $error }}</li>
		@endforeach
	</ul>
  </div><br />
@endif

        <!------Summary Page Start---------------->
		<form method="post" action="{{ url('view-application-status') }}" id="applicationStatus" class="form-comman">
		@csrf

		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<label for="inputEmail4">
						<span data-hi="आवेदन संख्या" data-en="Application Number"></span>	
					</label>
					<input type="text" class="form-control" name="applicationNumber" id="applicationNumber" data-placeholder-hi="आवेदन संख्या"
					data-placeholder-en="Application Number">
				</div>
				
				

				<div class="col-md-3">
					<label for="inputEmail4">
						<span data-hi="मोबाइल नंबर" data-en="Mobile Number"></span>	
					</label>
				  <input type="text" maxlength="10" class="form-control" name="mobile" id="mobile" data-placeholder-hi="मोबाइल नंबर" data-placeholder-en="Mobile Number">

				</div>
				<div class="col-md-1 fw-semibold my-auto text-center">
					<span data-hi="अथवा" data-en="OR"></span>
				  
				</div>
				<div class="col-md-3">
					<label for="inputEmail4">
					<span data-hi="जन्म तिथि" data-en="Date of Birth"></span>	
					</label>
				  <input type="text" class="form-control"  name="dob" id="dob" data-placeholder-hi="जन्म तिथि" data-placeholder-en="Date of Birth" readonly>
				</div>
			</div>
			<div class="row text-center">		
				<div class="form-group col-md-12 mt-4">
					<button type="submit" class="btn btn-primary communicationAddress2">
						<span data-hi="सबमिट" data-en="Submit"></span>
					</button>
					<span class="spinner-border spinner-border-sm loader saveLoader" role="status" aria-hidden="true" style="display:none;"></span>
					<span class="saveCommunicationAddress"></span>
				</div>
			</div>

		</div>
		
        <!------Summary Page End---------------->
     
        
<script>
$(document).ready(function() {
 /*----------------Comments form validate Start----------------*/
 
 
 $.validator.addMethod("atLeastOne", function(value, element) {
    	
		var mobile 	= $("#mobile").val();
		var dob 	= $("#dob").val();
		
		if(mobile=='' && dob=='')
		{
			return false;
		}else {
			
			return true;
		}
		
        
      
    }, "Please Enter Mobile Number or Date of Birth");
 
 $('#applicationStatus').validate({     
	 	rules: {
			    "applicationNumber": {
					required: true,
			    },
			    
			    "dob": {
					atLeastOne: true,
			    },
        },
        submitHandler: function (form) {
		
		$('.communicationAddress1').hide();
		$('.communicationAddress2').hide();
		$('.saveLoader').show();
		$('.saveCommunicationAddress').html('Please Wait, Searching..');
		form.submit();
		},		
   });
 /*----------------Comments form validate End----------------*/
});

</script>
</div>

 @endsection 
