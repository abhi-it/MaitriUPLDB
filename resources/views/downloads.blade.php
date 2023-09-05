@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 388px;">

         <h1 style="margin-top:10px;text-align: center;margin-bottom:20px;">दस्तावेज़ डाउनलोड करें </h1>
<div class="row">
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
						<td style="width:05%"><center><a href="{{url('downloadFile', 'Shapath-patra.pdf')}}"><img src="{{ asset('')}}images/dnl.gif" style="width:30px;height:30px;    margin-top: -8px;"></a></center></td>
						</tr>
					</table>
			</div>
</div>

</div>

 @endsection 
