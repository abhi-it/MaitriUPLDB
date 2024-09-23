@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%; min-height:380px;">
    <!--First row Start -->
	 
    <h3 class="text-center fw-bold m-4"><span data-hi="चेंज पासवर्ड " data-en="Change Password"></span></h3>
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
	<!-- <form method="POST" action="{{ route('changePasswordPost') }}" id="loginForm" name="loginForm"> -->
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right"><span data-hi="ईमेल" data-en="Email"></span></label>

                            <div class="col-md-6">
                                <input name="email" id="email" type="email" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><span data-hi="पासवर्ड" data-en="Password"></span></label>
                            <div class="col-md-6">
                                <input name="new-password" id="new-password" type="password" class="form-control">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><span data-hi="कन्फर्म पासवर्ड" data-en="Confirm Password"></span></label>
                            <div class="col-md-6">
                                <input name="new-password-confirm" id="new-password-confirm" type="password" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="btn">चेंज पासवर्ड</button>
                            </div>
                        </div>
                    <!-- </form> -->
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
			    "email": {
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
