@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;">
    <!--First row Start -->
	 
	<h3 class="text-center fw-bold m-4">क्रियाशील प्राईवेट कृत्रिम गर्भाधान कार्यकर्ता/पशुमित्र/मैत्री का विवरण अपलोड करें</h3>
@if(session()->get('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}  
  </div>
@endif

        <div class="row" style="min-height:350px;">
			
			<div class="form-group col-md-12" style="padding-bottom: 25px;">
			<label for="inputEmail4" style="font-size: 20px;font-weight: bold;">
				<a href="{{url('downloadFile/Format for AI Workers.xlsx')}}">
					<span style="font-size:20px;margin-right: 30px;">क्रियाशील प्राईवेट कृत्रिम गर्भाधान कार्यकर्ता का विवरण का फॉर्मेट डाउनलोड करने के लिए यहाँ  पर क्लिक करें </span>
				</a> <br>  
				<span class="text-danger">नोट : कृपया इसी फॉर्मेट में हिंदी का मंगल (यूनिकोड) फॉन्ट का प्रयोग करते हुए एक्सेल में डाटा फीड करें और उसके बाद एक्सेल को अपलोड करें अन्यथा एरर आ जाएगी और डाटा सही से अपलोड नहीं होगा |</span></label>
		</div>
        
        <form action="{{ route('uploadExcelPost') }}" method="post" enctype="multipart/form-data" id="myForm">
        {{ csrf_field() }}
        
        <div class="form-group col-md-12">
			<label for="inputEmail4">क्रियाशील प्राईवेट कृत्रिम गर्भाधान कार्यकर्ता का विवरण अपलोड करें </label> <span class="text-danger">*</span>
			<input type="file" class="form-control" name="import_file" required />
			<span class="text-danger">नोट : कृपया xlx या  xlsx फाइल एक्सटेंशन ही अपलोड करें</span>
		</div>
		
		<div class="form-group col-md-6">
			<button class="btn btn-primary">अपलोड एक्सेल फाइल</button>
		</div>
        
        
        
		</form>
        
        </div>
     
        

</div>
<script>
$(document).ready(function() {      
    
    $('#myForm').submit( function(){
	    $(".btn").attr("disabled", true);
	    $(".btn").html("Please wait..");
	});
})
</script>
 @endsection 
