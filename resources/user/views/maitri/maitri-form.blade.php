@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%; min-height:380px;">
    <!--First row Start -->
	 
 <h1 style="margin-top:10px;text-align: center;" class="m-4">सिंगल मैत्री जोड़ें</h1>
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
	<form method="POST" action="{{ route('addUpdateMaitri') }}" id="loginForm" name="loginForm" enctype="multipart/form-data">
                        @csrf
                        <!-- <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">मंडल का नाम </label>

                            <div class="col-md-6">
                                <input name="file" id="file" type="file" class="form-control"  autofocus>
                            </div>
                        </div> -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">मंडल का नाम </label>

                            <div class="col-md-6">
                                <input name="mandal_name" id="mandal_name" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">जनपद का नाम </label>

                            <div class="col-md-6">
                                <input name="janpad_name" id="janpad_name" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">अभ्यर्थी  का नाम </label>

                            <div class="col-md-6">
                                <input name="maitri_name" id="maitri_name" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">अभ्यर्थी का मोबाइल नंबर </label>

                            <div class="col-md-6">
                                <input name="maitri_mobile_no" id="maitri_mobile_no" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">ग्राम पंचायत </label>

                            <div class="col-md-6">
                                <input name="gram_panchayat" id="gram_panchayat" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">पोस्ट ऑफिस  </label>

                            <div class="col-md-6">
                                <input name="post_office" id="post_office" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">ब्लॉक  </label>

                            <div class="col-md-6">
                                <input name="block" id="block" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">तहसील </label>

                            <div class="col-md-6">
                                <input name="tehsil" id="tehsil" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">आधार कार्ड संख्या </label>

                            <div class="col-md-6">
                                <input name="adhaar_card" id="adhaar_card" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">पिता का नाम </label>

                            <div class="col-md-6">
                                <input name="father_name" id="father_name" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">पिता का मोबाइल नंबर </label>

                            <div class="col-md-6">
                                <input name="father_mobile_no" id="father_mobile_no" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">प्रमाणपत्र संख्या</label>

                            <div class="col-md-6">
                                <input name="certificate_no" id="certificate_no" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">प्रशिक्षण केंद्र का नाम जहाँ से मैत्री ने प्रशिक्षण प्राप्त किया </label>

                            <div class="col-md-6">
                                <input name="center_name" id="center_name" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">सत्र एवं दिनांक  </label>

                            <div class="col-md-6">
                                <input name="pass_date" id="pass_date" type="text" class="form-control"  autofocus>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">प्रशिक्षण अवधि (कब से कब तक) </label>

                            <div class="col-md-6">
                                <input name="expiry_date" id="expiry_date" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">प्रशिक्षण से पूर्व इनाफ भारत पशुधन की आई डी लिखे </label>

                            <div class="col-md-6">
                                <input name="any_bharat_id" id="any_bharat_id" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">उपकरण प्राप्त है या नहीं </label>

                            <div class="col-md-6">
                                <input name="equipment_received" id="equipment_received" type="text" class="form-control"  autofocus>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">देशान्तर</label>

                            <div class="col-md-6">
                                <input name="longitude" id="longitude" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">अक्षांश</label>

                            <div class="col-md-6">
                                <input name="latitude" id="latitude" type="text" class="form-control"  autofocus>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4 mb-5">
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
