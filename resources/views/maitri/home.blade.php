@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%; min-height:380px;">
    <!--First row Start -->

    <h3 class="text-center fw-bold m-4">मैत्री (पशु मित्र)</h3>
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
                    <div class="card-header">कुल मैत्री (पशु मित्र)</div>
                    <div class="card-body" style="padding:10px">
                        <h5 class="card-title"> <a href="{{route('maitri-listing')}}" class="btn btn-primary">View
                                {{$count}}</a></h5>

                    </div>
                </div>
            </div>
            <div class="col-sm-3 mt-3 mb-3 mt-md-5 mt-md-5">
                <div class="card text-center">
                    <div class="card-header">मैत्री (पशु मित्र) फॉर्म</div>
                    <div class="card-body" style="padding:10px">
                        <a href="{{ url('maitri-form')}}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mt-3 mb-3 mt-md-5 mt-md-5">
                <div class="card text-center">
                    <div class="card-header">मैत्री(पशु मित्र) इम्पोर्ट करें</div>
                    <div class="card-body" style="padding:10px">
                        <a href="{{ url('maitri-import')}}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mt-3 mb-3 mt-md-5 mt-md-5">
                <div class="card text-center">
                    <div class="card-header">मानचित्र में देखें</div>
                    <div class="card-body" style="padding:10px">
                        <a href="{{ url('maitri-map')}}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection