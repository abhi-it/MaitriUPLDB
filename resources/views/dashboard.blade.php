@extends('master')
@section('content')
@php
$show = false;
@endphp

@if ($sessionYear == date('Y'))
@php
$show = false;
@endphp
@endif

<style>
.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, .125);
    border-radius: 0.25rem;
}

.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}
</style>
<div class="container main-div">
    <h3 class="text-center fw-bold m-4 current_session"> <span data-hi="मैत्री विवरण" data-en="Maitri Details"></span>
        {{ $sessionYear . '-' . substr($sessionYear + 1, -2) }}</h3>
    <div class="row">
        <div class="col-sm-3 mt-md-5 mb-md-5 mt-3 mb-3">
            <div class="card text-center">
                <div class="card-header">
                    <span data-hi="नये आवेदन मैत्री" data-en="New Applications Maitri"></span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $newApplication }}</h5>
                    <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                    @if (auth()->user()->user_type == 'Director')
                    <a href="{{ url('avedan-districtwise') }}/{{ $sessionYear }}" class="btn btn-primary">View</a>
                    {{-- <a href="#" class="btn btn-primary">View</a> --}}
                    @else
                    <a href="{{ url('avedan') }}/{{ $sessionYear }}" class="btn btn-primary">View</a>
                    {{-- <a href="#" class="btn btn-primary">View</a> --}}
                    @endif
                </div>
            </div>
        </div>

        <div class="col-sm-3 mt-md-5 mb-md-5 mt-3 mb-3">
            <div class="card text-center">
                <div class="card-header">
                    <span data-hi=" स्वीकृत आवेदन" data-en="Approved Applications"></span>
                </div>
                <div class="card-body">
                    <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->


                    @if ($show)
                    <h5 class="card-title">0</h5>
                    <a href="#" class="btn btn-primary">View</a>
                    @else
                    <h5 class="card-title">{{ $approvedApplication }}</h5>
                    <a href="{{ url('approved-avedan') }}/{{ $sessionYear }}" class="btn btn-primary">View</a>
                    @endif

                </div>
            </div>
        </div>

        <div class="col-sm-3 mt-md-5 mb-md-5 mt-3 mb-3">
            <div class="card text-center">
                <div class="card-header">
                    <span data-hi="अस्वीकार आवेदन" data-en="Rejected Applications"></span>
                </div>
                <div class="card-body">
                    <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->

                    @if ($show)
                    <h5 class="card-title">0</h5>
                    <a href="#" class="btn btn-primary">View</a>
                    @else
                    <h5 class="card-title">{{ $rejectedApplication }}</h5>
                    <a href="{{ url('rejected-avedan') }}/{{ $sessionYear }}" class="btn btn-primary">View</a>
                    @endif

                </div>
            </div>
        </div>

        <div class="col-sm-3 mt-md-5 mb-md-5 mt-3 mb-3">
            <div class="card text-center">
                <div class="card-header">
                    <span data-hi="चयनित सामान्य/अन्य पिछड़ा वर्ग अभ्यर्थी"
                        data-en="Selected General/OBC Candidates"></span>
                </div>
                <div class="card-body">
                    <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->

                    @if ($show)
                    <h5 class="card-title">0</h5>
                    <a href="#" class="btn btn-primary">View</a>
                    @else
                    <h5 class="card-title">{{ $generalList }}</h5>
                    <a href="{{ url('general-list') }}/{{ $sessionYear }}" class="btn btn-primary">View</a>
                    @endif

                </div>
            </div>
        </div>

        <div class="col-sm-3 mt-md-5 mb-md-5 mt-3 mb-3">
            <div class="card text-center">
                <div class="card-header">
                    <span data-hi="चयनित अनुसूचित जाति अभ्यर्थी" data-en="Selected SC Candidates"></span>
                </div>
                <div class="card-body">
                    <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->


                    @if ($show)
                    <h5 class="card-title">0</h5>
                    <a href="#" class="btn btn-primary">View</a>
                    @else
                    <h5 class="card-title">{{ $SClist }}</h5>
                    <a href="{{ url('sc-list') }}/{{ $sessionYear }}" class="btn btn-primary">View</a>
                    @endif

                </div>
            </div>
        </div>

        <div class="col-sm-3 mt-md-5 mb-md-5 mt-3 mb-3">
            <div class="card text-center">
                <div class="card-header">
                    <span data-hi="चयनित अनुसूचित जनजाति अभ्यर्थी" data-en="Selected ST Candidates"></span>
                </div>
                <div class="card-body">

                    <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->

                    @if ($show)
                    <h5 class="card-title">0</h5>
                    <a href="#" class="btn btn-primary">View</a>
                    @else
                    <h5 class="card-title">{{ $STlist }}</h5>
                    <a href="{{ url('st-list') }}/{{ $sessionYear }}" class="btn btn-primary">View</a>
                    @endif

                </div>
            </div>
        </div>


        <div class="col-sm-3 mt-md-5 mb-md-5 mt-3 mb-3">
            <div class="card text-center">
                <div class="card-header">
                    <span data-hi="प्रतीक्षा सूची" data-en="Waiting list"></span>
                </div>
                <div class="card-body">
                    <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->

                    @if ($show)
                    <h5 class="card-title">0</h5>
                    <a href="#" class="btn btn-primary">View</a>
                    @else
                    <h5 class="card-title">{{ $waitingList }}</h5>
                    <a href="{{ url('waiting-list') }}/{{ $sessionYear }}/1" class="btn btn-primary">View</a>
                    @endif

                </div>
            </div>
        </div>
        <div class="col-sm-3 mt-md-5 mb-md-5 mt-3 mb-3">
            <div class="card text-center">
                <div class="card-header">
                    <span data-hi="सत्र मैत्री रिकॉर्ड्स सूची" data-en="Session Maitri Records List"></span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalsession }}</h5>
                    <a href="{{ url('totalsessionlist') }}" class="btn btn-primary">View</a>
                </div>
            </div>
        </div>


        @foreach ($avedanYears as $avedanYear)
        <div class="col-sm-3 mt-md-5 mb-md-5 mt-3 mb-3">
            <div class="card text-center">
                <div class="card-header"> <span data-hi="सत्र " data-en="Session "></span>
                    {{ $avedanYear . '-' . substr($avedanYear + 1, -2) }}</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $avedanYear . '-' . substr($avedanYear + 1, -2) }}</h5>
                    <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                    <a href="{{ url('/dashboard') }}/{{ $avedanYear }}" class="btn btn-primary">View</a>
                </div>
            </div>
        </div>
        @endforeach



        {{-- @include('map') --}}
    </div>


    @endsection