@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
<h3 class="text-center fw-bold m-4">संस्थान आवंटन सूची
<!--div class=" pull-right">
			<a href="javascript:history.back();" class="btn btn-info">Back</a>
		</div-->
</h3>
@if(session()->get('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}  
  </div>
@endif
			<form method="get" action="{{ url('dashboard') }}" id="viewAllocationList">
	@csrf
			<div class="row">

				<div class="form-group col-md-3">
				<label for="inputEmail4">कैटेगरी</label>
				  <select class="form-control" name="category">
					  <option value="">सेलेक्ट</option>
					  <option value="1" {{ @$_GET['category']==1 ? 'selected' : '' }}>जनरल/ओ बी सी</option>
					  <option value="2" {{ @$_GET['category']==2 ? 'selected' : '' }}>एस सी/एस टी</option>
				  </select>
				</div>
				
				<div class="form-group col-md-3">
				<label for="inputEmail4">जॉइन स्टेटस</label>
				  <select class="form-control" name="join_status">
					  <option value="" {{ @$_GET['join_status']=='' ? 'selected' : '' }}>सेलेक्ट</option>
					  <option value="1" {{ @$_GET['join_status']=='1' ? 'selected' : '' }}>जॉइन कर लिया है</option>
					  <option value="0" {{ @$_GET['join_status']=='0' ? 'selected' : '' }}>जॉइन नहीं किया है</option>
				  </select>
				</div>
				
				<div class="form-group col-md-3">
				<button type="submit" class="btn btn-primary" style="margin-top: 25px;width:100px;">फ़िल्टर करें</button>
				</div>
				
		  </div>
		</form>
		
		<table class="table">
    <thead>
        <tr>
            <th>क्रं  सं </th>
            <th>आवेदन  नंबर</th>
            <th>आवेदक का नाम</th>
            <th>कैटेगरी</th>
            <th>अभ्यार्थी का स्वत: मूल्यांकन अंक</th>
            <th>दिनांक</th>
            <th>देखें</th>
            <th>चेंज स्टेटस</th>
        </tr>
    </thead>
    <tbody>
		<?php $i=1;?>
		@if(count($results))
		@foreach($results as $row)
        <tr>
			<td>{{$i++}}.</td>
            <td>{{$row->applicationNumber}}</td>
            <td>{{$row->applicant_name}}</td>
            <td>{{$row->category}}</td>
            <td>{{$row->topper_number}}</td>
            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y')}}</td>
            <td>
				<a href="{{url('view-Avedan-details')}}/{{$row->id}}" >विवरण देखें</a>
				@if(auth()->user()->user_type=='Admin' AND (Request::segment(1)=='avedan' OR Request::segment(1)=='total-avedan'))
				 | <a href="{{url('edit-avedan')}}/{{$row->id}}" >एडिट</a>
				@endif
			</td>
            <td id="responseID{{$row->id}}">
			@if($row->join_status==0)
				<a href="javascript:void(0)" onClick="changeStatus({{$row->id}},1);" class="btn btn-danger">जॉइन नहीं किया</a>
			@else
				<a href="javascript:void(0)" onClick="changeStatus({{$row->id}},0);" class="btn btn-success">जॉइन कर लिया</a>
			@endif
			</td>
        </tr>
        @endforeach
        @else
        <tr><td colspan="7" style="color:red;">कोई आवेदन नहीं है</td></tr>
		@endif
		
    </tbody>
</table>

</div>
@endsection 
