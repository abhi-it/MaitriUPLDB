@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
<h3 style="margin-top:10px;text-align: center;">संस्थान आवंटन सूची
<!--div class=" pull-right">
			<a href="javascript:history.back();" class="btn btn-info">Back</a>
		</div-->
</h3>
@if(session()->get('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}
  </div>
@endif
			<form method="get" action="{{ url('allocation-list') }}" id="viewAllocationList">
	@csrf
			<div class="row">


				<div class="form-group col-md-3">
				  <label for="inputEmail4">संस्थान का नाम </label>
					<select class="form-control" name="institute_id" id="institute_id">
						<option value="">सेलेक्ट संस्थान</option>
						@foreach($institute as $row)
							<option value="{{$row->id}}" {{ $row->id==@$_GET['institute_id'] ? 'selected' : '' }}>{{$row->name}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col-md-3">
				  <label for="inputEmail4">सेलेक्ट जनपद </label>
					<select class="form-control" name="district_id">
						<option value="">सेलेक्ट जनपद</option>
						@foreach($districts as $row)
							<option value="{{$row->id}}" {{ $row->id==@$_GET['district_id'] ? 'selected' : '' }}>{{$row->name_hindi}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col-md-3">
				<label for="inputEmail4">कैटेगरी</label>
				  <select class="form-control" name="category">
					  <option value="">सेलेक्ट</option>
					  <option value="1" {{ @$_GET['category']==1 ? 'selected' : '' }}>सामान्य / अन्य  पिछड़ा वर्ग</option>
					  <option value="2" {{ @$_GET['category']==2 ? 'selected' : '' }}>अनुसूचित जाति</option>
					  <option value="3" {{ @$_GET['category']==3 ? 'selected' : '' }}>अनुसूचित जनजाति</option>
				  </select>
				</div>

				<div class="form-group col-md-3 mt-2">
				<button type="submit" class="btn btn-primary" style="margin-top: 25px;width:100px;">देंखे</button>
                @if (isset($routeName))
                <a class="btn btn-secondary btn-export" href="{{ route($routeName,[true]) }}" style="margin-top: 25px;">Export</a>
                @endif
				</div>

		  </div>
		</form>

		<table class="table">
    <thead>
        <tr>
            <th>क्रं  सं </th>
            <th>आवेदन  नंबर</th>
            <th>आवेदक का नाम</th>
            <th>अभ्यार्थी का स्वत: मूल्यांकन अंक</th>
            <th>दिनांक</th>
            <th>देखें</th>
            <th>स्टेटस</th>
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
            <td><a href="javascript:void(0)" onClick="viewCalculation({{$row->id}});">{{$row->topper_number}}</a></td>
            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y')}}</td>
            <td>
				<a href="{{url('view-Avedan-details')}}/{{$row->id}}" >विवरण देखें</a>
				@if(auth()->user()->user_type=='Admin' AND (Request::segment(1)=='avedan' OR Request::segment(1)=='total-avedan'))
				 | <a href="{{url('edit-avedan')}}/{{$row->id}}" >एडिट</a>
				@endif
			</td>
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
        @else
        <tr><td colspan="7" style="color:red;">कोई आवेदन नहीं है</td></tr>
		@endif

    </tbody>
</table>
</div>
@endsection
