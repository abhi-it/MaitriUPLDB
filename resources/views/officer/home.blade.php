@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%; min-height:380px;">
    <!--First row Start -->

    <h3 class="text-center fw-bold m-4">अधिकारी</h3>
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
            <div class="col-sm-3 mt-3 mb-3 mt-md-5 mt-md-5">
                <div class="card text-center">
                    <div class="card-header"><span data-hi="कुल अधिकारी" data-en="Total Officers"></span></div>
                    <div class="card-body" style="padding:10px">
                        <h5 class="card-title"><a href="{{route('getallofficers')}}" class="btn btn-primary"> View
                                {{$count}} </a></h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mt-3 mb-3 mt-md-5 mt-md-5">
                <div class="card text-center">
                    <div class="card-header"><span data-hi="अधिकारी इम्पोर्ट करें" data-en="Import officials"></span>
                    </div>
                    <div class="card-body" style="padding:10px">
                        <a href="{{ url('officers-import')}}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
            @if(auth()->user()->user_type == 'Admin' || auth()->user()->user_type == 'Director')
            <div class="col-sm-3 mt-3 mb-3 mt-md-5 mt-md-5">
                <div class="card text-center">
                    <div class="card-header"><span data-hi="आयातित डेटा" data-en="Imported Data By CVO"></span></div>
                    <div class="card-body" style="padding:10px">
                        <a href="{{ url('view-imported-data-by')}}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection