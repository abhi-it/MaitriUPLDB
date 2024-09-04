@extends('master')
@section('content')
<div class="container main-div" >
<h3 class="text-center m-4 fw-bold">संस्थान सूची 
<div class="pull-right mb-4">
			<a href="{{ route('institute.create')}}" class="btn btn-info">नया संस्थान जोड़े</a>
		</div>
</h3>
<table id="instituteTable" class="table table-striped  table-responsive table-bordered">
    <thead>
        <tr>
            <th>नाम </th>
            <th>मोबाइल</th>
            <th>ईमेल </th>
            <th>पता</th>
            <th>दिनांक</th>
            <th>एक्शन</th>
            <th>स्टेटस</th>
        </tr>
    </thead>
    <tbody>
		@if($results->count())
		@foreach($results as $row)
        <tr>
            <td>{{$row->name}}</td>
            <td>{{$row->mobile}}</td>
            <td>{{$row->email}}</td>
			<td>{{$row->address}}</td>
            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y')}}</td>
            <td><a class="btn btn-primary btn-xs" href="{{ route('institute.edit',$row->id)}}"><i class="fa fa-pencil"></i></a>
			</td>
            <td>
			@if($row->status==0)
				<a href="javascript:void(0)" class="btn btn-danger">निष्क्रिय</a>
			@else
				<a href="javascript:void(0)" class="btn btn-success">सक्रिय</a>
			@endif
			</td>
        </tr>
        @endforeach
		@endif
    </tbody>
</table>
</div>
@endsection 
