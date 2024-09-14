@extends('master')
@section('content')
<style>
	.scanned_file{
		text-align: left;
		/* width: 50%; */
		/* margin: auto !important; */
		font-size: 16px;
    	font-weight: 700;
		background: #efefef;
		padding: 20px;
		border-radius: 6px;
		margin-top: 10px;
	}
</style>
<div class="container main-div py-5">
     <h3 class="text-center fw-bold m-4">
		<span  data-hi="दस्तावेज़ डाउनलोड करें " data-en="Download Documents." ></span>	
	</h3>
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
		<div class="form-group col-md-12">
			<table class="table table-striped table-responsive table-bordered">
				<tr>
					<th style="font-size:15px"><span data-hi="क्रं सं" data-en="S. No."></span>  </th>
					<th style="font-size:15px"><span data-hi="दस्तावेज़ का शीर्षक" data-en="Title of Documents"></span></th>
					<th style="font-size:15px"> <span data-hi="डाउनलोड" data-en="Download"></span>  </th>
				</tr>
				<tr>
					<td>01</td>
					<td> <span data-hi="शपथ - पत्र" data-en="Affidavit"></span>  </td>
					<td style="width:05%">
						<center>
						<a href="{{url('downloadFile', 'Shapath Patra 2024-25.pdf')}}" target="_blank">
							<img src="{{ asset('')}}images/dnl.gif" style="width:30px;height:30px;    margin-top: -8px;">
						</a>
						</center>
					</td>
				</tr>
				<tr>
					<td>02</td>
					<td> <span data-hi="नियम शर्त शपथ पत्र" data-en="Terms and Conditions Affidavit"></span>  </td>
					<td style="width:05%">
						<center>
						<a href="{{url('downloadFile', 'niyam_sharte_file.pdf')}}" target="_blank">
							<img src="{{ asset('')}}images/dnl.gif" style="width:30px;height:30px;    margin-top: -8px;">
						</a>
						</center>
					</td>
				</tr>
			</table>
		</div>
	</div>

</div>

 @endsection 
