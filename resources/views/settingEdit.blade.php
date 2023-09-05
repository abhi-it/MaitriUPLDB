@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
<h3 style="margin-top:10px;text-align: center;">सेटिंग्स</h3>
<form method="post" action="{{ route('setting.update', $data->id) }}">
            @method('PATCH') 
            @csrf
			<div class="row">
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">सेटिंग्स का नाम </label>
				  <input readonly type="text" class="form-control" value="{{$data->name}}">
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">@if($data->id!=1)प्रारम्भ तिथि @else  तिथि से @endif</label>
				  <input type="text" class="form-control" name="start_date" id="start_date" placeholder="@if($data->id!=1)प्रारम्भ तिथि @else  तिथि से @endif" readonly value="{{\Carbon\Carbon::parse($data->start_date)->format('d-m-Y')}}">
				</div>
				@if($data->id!=1)
				<div class="form-group col-md-12">
				  <label for="inputEmail4">अंतिम तिथि  </label>
				  <input type="text" class="form-control" name="end_date" id="end_date" placeholder="अंतिम तिथि" readonly value="{{\Carbon\Carbon::parse($data->end_date)->format('d-m-Y')}}">
				</div>
				@endif
			<div class="form-group col-md-12" style="overflow:auto;margin-bottom:20px;">
                <button type="submit" class="submit">Submit</button>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;" id="loader"> </span>
            
        </div>
				
		  </div>
		</form>
</div>
@endsection 
