@extends('master')
@section('content')
<div class="container main-div py-5" style="background-color:white; height:380px;">
    <!--First row Start -->
	 
 <h1 style="margin-top:10px;text-align: center;">आवेदन की स्थिति जानिए</h1>
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
					<label for="inputEmail4">आवेदन संख्या</label>
					<input type="text" class="form-control" name="applicationNumber" id="applicationNumber" placeholder="आवेदन संख्या">
				</div>
				
				

				<div class="col-md-3">
					<label for="inputEmail4">मोबाइल नंबर</label>
				  <input type="text" maxlength="10" class="form-control" name="mobile" id="mobile" placeholder="मोबाइल नंबर">

				</div>
				<div class="col-md-1 fw-semibold my-auto text-center">
				  अथवा
				</div>
				<div class="col-md-3">
					<label for="inputEmail4">जन्म तिथि</label>
				  <input type="text" class="form-control"  name="dob" id="dob" placeholder="जन्म तिथि" readonly>
				</div>
			</div>
			<div class="row text-center">		
				<div class="form-group col-md-12 mt-4">
					<button type="submit" class="btn btn-primary communicationAddress2">सबमिट</button>
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
