@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%; min-height:380px;">
    <!--First row Start -->
	 
 <h1 style="margin-top:10px;text-align: center;">अधिकारी</h1>
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
@if($errors)
	@foreach ($errors->all() as $error)
	<div class="alert alert-danger">{{ $error }}</div>
	@endforeach
@endif
	<div class="container main-div" style="margin-top:25px">
        <div class="row">
            <div class="col-sm-3">
                <div class="card text-center">
                    <div class="card-header">कुल अधिकारी</div>
             		<div class="card-body" style="padding:10px">
                        <h5 class="card-title"><a href="{{route('getallofficers')}}" class="btn btn-primary"> View {{$count}} </a></h5>                        
                    </div>
                </div>
            </div>
			<div class="col-sm-3">
                <div class="card text-center">
                    <div class="card-header">अधिकारी इम्पोर्ट करें</div>
                    <div class="card-body" style="padding:10px">
                      <a href="{{ url('officers-import')}}" class="btn btn-primary">View</a>                
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
 @endsection 
