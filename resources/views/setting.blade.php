@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
<h3 style="margin-top:10px;text-align: center;">सेटिंग्स</h3>
@if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div>
  @endif
<table class="table">
    <thead>
        <tr>
            <th>सेटिंग्स का नाम</th>
            <th>प्रारम्भ तिथि</th>
            <th>अंतिम तिथि</th>
            <th>एक्शन</th>
        </tr>
    </thead>
    <tbody>
		@if($results->count())
		@foreach($results as $row)
        <tr>
            <td>{{$row->name}}</td>
            <td>{{ \Carbon\Carbon::parse($row->start_date)->format('d/m/Y')}}</td>
            <td>
				@if($row->end_date!='')
				{{ \Carbon\Carbon::parse($row->end_date)->format('d/m/Y')}}
				@else
				N/A
				@endif
				</td>
				<td><a href="{{ route('setting.edit',$row->id)}}" >एडिट</a></td>
        </tr>
        @endforeach
		@endif
    </tbody>
</table>
</div>
@endsection 
