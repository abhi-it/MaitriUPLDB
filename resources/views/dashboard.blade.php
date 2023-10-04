@extends('master')
@section('content')
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

        <div class="row">
            <div class="col-sm-3">
                <div class="card text-center">
                    <div class="card-header">नये आवेदन</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $newApplication }}</h5>
                        <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                        @if (auth()->user()->user_type == 'Director')
                            <a href="{{ url('avedan-districtwise') }}/{{$sessionYear}}" class="btn btn-primary">View</a>
                        @else
                            <a href="{{ url('avedan') }}/{{$sessionYear}}" class="btn btn-primary">View</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-center">
                    <div class="card-header">स्वीकृत आवेदन</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $approvedApplication }}</h5>
                        <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                        <a href="{{ url('approved-avedan') }}/{{$sessionYear}}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-center">
                    <div class="card-header">अस्वीकार आवेदन</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $rejectedApplication }}</h5>
                        <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                        <a href="{{ url('rejected-avedan') }}/{{$sessionYear}}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-center">
                    <div class="card-header">चयनित सामान्य/अन्य पिछड़ा वर्ग अभ्यर्थी</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $generalList }}</h5>
                        <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                        <a href="{{ url('general-list') }}/{{$sessionYear}}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-center">
                    <div class="card-header">चयनित अनुसूचित जाति अभ्यर्थी</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $SClist }}</h5>
                        <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                        <a href="{{ url('sc-list') }}/{{$sessionYear}}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card text-center">
                    <div class="card-header">चयनित अनुसूचित जनजाति अभ्यर्थी</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $STlist }}</h5>
                        <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                        <a href="{{ url('st-list') }}/{{$sessionYear}}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>

            @if (auth()->user()->user_type == 'District Officer')
                <div class="col-sm-3">
                    <div class="card text-center">
                        <div class="card-header">प्रतीक्षा सूची</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $waitingList }}</h5>
                            <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                            <a href="{{ url('waiting-list') }}/1" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            @endif

            @foreach ($avedanYears as $avedanYear)
                <div class="col-sm-3">
                    <div class="card text-center">
                        <div class="card-header">Session</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $avedanYear . '-' . substr($avedanYear + 1, -2) }}</h5>
                            <!--p class="card-text">With supporting text below as a natural lead-in to additional content.</p-->
                            <a href="{{ url('/dashboard') }}/{{ $avedanYear }}" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            @endforeach



            @include('map')
        </div>
    @endsection
