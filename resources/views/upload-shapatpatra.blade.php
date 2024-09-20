@extends('master')
@section('content')
<style>
	.scanned_file{
		text-align: left;
		width: 100%;
		margin: auto !important;
		font-size: 16px;
    	font-weight: 700;
	}
</style>
<div class="container main-div" style="background-color:white;">
<h3 class="text-center fw-bold m-4">
			
		 <span data-hi="दस्तावेज़ डाउनलोड करें" data-en="Please download the document."></span>
		 </h1>
		<div class="row">
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
			<div class="fs-6  m-3">
				<span><b>Step 1</b>:- <span data-hi="कृपया एक्सेल शीट डाउनलोड करें।" data-en="Please download the Excel sheet."></span> </br>
			</div>
			<div class="form-group col-md-12">
				<table class="table table-bordered">
					<tr style="background-color:#d3d3d3;">
						<th > <span data-hi="क्रं सं" data-en="S.No."></span>  </th>
						<th ><span data-hi="दस्तावेज़ का शीर्षक" data-en="Document Title"></span> </th>
						<th ><span data-hi="डाउनलोड" data-en="Download"></span></th>
					</tr>
					<tr>
						<td>01</td>
						<td><span data-hi="मैत्री विवरण प्ररूप"  data-en="Maitri Statement Format"></span></td>
						<td style="width:05%"><center><a href="{{url('downloadFile', 'maitriprarup.xlsx')}}"><img src="{{ asset('')}}images/dnl.gif" style="width:30px;height:30px;    margin-top: -8px;"></a></center></td>
					</tr>
				</table>
			</div>
			<div class="fs-6  m-3">
				<span><b>Step 2</b>:-  <span data-hi="कृपया डाउनलोड की गई एक्सेल शीट भरें और इसे समिति से हस्ताक्षरित करवाएं।" data-en="Please fill up the downloaded Excel sheet and get it signed by Committee."></span> </br>
				<span><b>Step 3</b>:- <span data-hi="कृपया निम्नलिखित विकल्प का उपयोग करके स्कैन और हस्ताक्षरित पीडीएफ अपलोड करें।" data-en="Please upload the scanned and signed PDF by using the following option."></span> </br>
			</div>
			<div class="scanned_file m-4">
			<form action="{{route('uploadScannedFile')}}" method="post" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="form-group col-md-6">
						<label for="inputEmail4">
							<span data-hi="स्कैन और हस्ताक्षरित पीडीएफ अपलोड करें।" data-en="Upload the scanned and signed PDF"></span> 
						</label> 
							<input name="scanned_file" required id="scanned_file" type="file" class="form-control" autofocus="off" accept="application/pdf">
					</div>
					<div class="form-group col-md-6">
						<label for="inputEmail4">
							<span data-hi="लक्ष्य के प्रति अधिक मैत्री की मांग" data-en="Seeking more maitri towards the target"></span> 
						</label> 
							<input name="maitri_target_file" id="maitri_target_file" type="file" class="form-control" autofocus="off" accept="application/pdf">
					</div>
					<div class="form-group col-md-12 text-center">
						<button type="submit" class="btn btn-primary" id="btn">
						<span data-hi="सबमिट" data-en="Submit"></span>	
						</button>
					</div>
				</div>
			</form>
			</div>
		</div>

</div>

 @endsection 
