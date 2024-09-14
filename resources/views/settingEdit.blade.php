@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
<h3 class="text-center fw-bold m-4">सेटिंग्स</h3>
<form method="post" action="{{ route('setting.update', $data->id) }}">
            @method('PATCH') 
            @csrf
			<div class="row">
				
				<div class="form-group col-md-12">
				 <div class="row">
				 <label for="inputEmail4" class="col-md-4 col-form-label text-md-right">सेटिंग्स का नाम </label>
				  <div class="col-md-6">
				  <input readonly type="text" class="form-control" value="{{$data->name}}">
				  </div>
				 </div>
				</div>
				
				<div class="form-group col-md-12">
				<div class="row">
				  <label for="inputEmail4" class="col-md-4 col-form-label text-md-right">@if($data->id!=1)प्रारम्भ तिथि @else  तिथि से @endif</label>
				  <div class="col-md-6">
				  <input type="text" class="form-control" name="start_date" id="start_date" placeholder="@if($data->id!=1)प्रारम्भ तिथि @else  तिथि से @endif" readonly value="{{\Carbon\Carbon::parse($data->start_date)->format('d-m-Y')}}">
				  </div>
				</div>
				</div>
				@if($data->id!=1)
				<div class="form-group col-md-12">
				<div class="row">
				  <label for="inputEmail4" class="col-md-4 col-form-label text-md-right">अंतिम तिथि  </label>
				  <div class="col-md-6">
				  <input type="text" class="form-control" name="end_date" id="end_date" placeholder="अंतिम तिथि" readonly value="{{\Carbon\Carbon::parse($data->end_date)->format('d-m-Y')}}">
				  </div>
				</div>
				</div>
				@endif

				<div class="row">
			    <div class="form-group col-md-8 offset-md-4">
                <button type="submit" class="submit buttonWizard btn btn-primary  ml-2">Submit</button>
			   


            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;" id="loader"> </span>
            
        </div>
		</div>		
		  </div>
		</form>
</div>
@endsection 
