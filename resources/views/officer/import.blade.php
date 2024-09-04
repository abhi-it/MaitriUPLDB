@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%; min-height:380px;">
    <!--First row Start -->
	 
 <h1 style="margin-top:10px;text-align: center;">इम्पोर्ट अधिकारी</h1>
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
	<form method="POST" action="{{ route('importofficers') }}" id="loginForm" name="loginForm" enctype="multipart/form-data" style="margin-top:50px">
                        @csrf
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">फ़ाइल का नाम </label>

                            <div class="col-md-6">
                                <input name="file" id="file" type="file" class="form-control"  autofocus>
                            </div>
                        </div>
                         <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="btn">सबमिट</button>
                            </div>
                        </div>
                    </form>
<!--First row Closed-->
</div>
<script>	
$(document).ready(function () {

 var $validator = $('#loginForm').validate({

   highlight: function(element) {
    $(element).parent().addClass('has-error');
  },
  unhighlight: function(element) {
    $(element).parent().removeClass('has-error');
  },
		
		doNotHideMessage: true,
		errorElement: 'span',
		errorClass: 'error',
            
	 	rules: {
			    "current-password": {
					required: true,
			    },
			    "new-password": {
					required: true,
					minlength: 8,
			    },
			    "new-password-confirm": {
					required: true,
					minlength: 8,
					equalTo : "#new-password"
			    },
			    
        },
        submitHandler: function (form) {
			$(".btn").attr("disabled", true);
			$(".btn").html("Please wait..");
			form.submit();
		},		
   });


});
</script>
 @endsection 
