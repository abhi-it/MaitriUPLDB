@extends('master')
@section('content')
<div class="container main-div py-5" style="background-color:white;">
         <h1 style="margin-top:10px;text-align: center;margin-bottom:20px;">दस्तावेज़ डाउनलोड करें </h1>
<div class="row">
<div class="form-group col-md-12" style="font-size: 16px;">
	<p>1:- <span data-hi="कृपया डाउनलोड की गई एक्सेल शीट भरें और उसे सीवीओ/वीओ से हस्ताक्षरित करवाएं।" data-en="Please fill up the downloaded Excel sheet and get it signed by CVO / VO"></span> </p><br>
	<!-- <p>2:- <span data-hi="कृपया निम्नलिखित विकल्प का उपयोग करके स्कैन और हस्ताक्षरित पीडीएफ अपलोड करें।" data-en="Please upload the scanned and signed PDF by using the following option :"></span> </p><br>
	<p>a:- <span data-hi="कृपया डाउनलोड की गई एक्सेल शीट भरें और उसे सीवीओ/वीओ से हस्ताक्षरित करवाएं।" data-en="Please fill up the downloaded Excel sheet and get it signed by CVO / VO"></span> </p><br> -->
</div>
	<div class="form-group col-md-12">
			<table class="table table-bordered">
				<tr style="background-color:#d3d3d3;">
				<th style="font-size:15px">क्रं सं </th>
				<th style="font-size:15px">दस्तावेज़ का शीर्षक</th>
				<th style="font-size:15px">डाउनलोड</th>
				</tr>
				<tr>
				<tr>
				<td>01</td>
				<td>शपथ - पत्र </td>
				<td style="width:05%"><center><a href="{{url('downloadFile', 'Shapath Patra 2024-25.pdf')}}"><img src="{{ asset('')}}images/dnl.gif" style="width:30px;height:30px;    margin-top: -8px;"></a></center></td>
				</tr>
			</table>
	</div>
</div>

</div>

 @endsection 
