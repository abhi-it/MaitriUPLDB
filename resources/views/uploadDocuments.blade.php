@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
<h3 style="margin-top:10px;text-align: center;">{{$heading}}</h3>
@if(session()->get('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}  
  </div>
@endif
<table id="myTable" class="table">
    <thead>
        <tr>
            <th>आवेदन  नंबर</th>
            <th>आवेदक का नाम</th>
            <th>अभ्यर्थी का स्वत: मूल्यांकन अंक</th>
            <th>दिनांक</th>
            <th>एक्शन</th>
            <th>स्थिति</th>
        </tr>
    </thead>
    <tbody>
		@if($results->count())
		@foreach($results as $row)
        <tr>
            <td>{{$row->applicationNumber}}</td>
            <td>{{$row->applicant_name}}</td>
            <td><a href="javascript:void(0)" onClick="viewCalculation({{$row->id}});">{{$row->topper_number}}</a></td>
            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y')}}</td>
            <td><a href="{{url('editUploadAvedan')}}/{{$row->id}}" >अपलोड डॉक्युमेंट्स</a></td>
            <td>
			@if($row->is_approved==0)
				<a href="javascript:void(0)" class="btn btn-secondary">लंबित</a>
			@elseif($row->is_approved==1)
				<a href="javascript:void(0)" class="btn btn-success">स्वीकृत</a>
			@elseif($row->is_approved==3)
				<a href="javascript:void(0)" class="btn btn-info active">प्रतीक्षा सूची</a>
			@else
				<a href="javascript:void(0)" class="btn btn-danger">अस्वीकार</a>
			@endif
			</td>
        </tr>
        @endforeach
		@endif
    </tbody>
</table>
</div>
@endsection 
