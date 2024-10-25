@extends('master')
@section('content')

<?php 
$events = App\Models\EventModal::orderBy('id', 'desc')->get();
?>
<style>
    .event-details .event-details_cards .gangatiri {
        width: 23.5%;
    }

    .event-details .event-details_cards .gangatiri .count-number {
        position: absolute;
        font-size: 1.4rem;
        font-weight: 600;
        background-color: #f93;
        left: 1rem;
        top: 1rem;
        border-radius: 50%;
        width: 35px;
        color: #fff;
        text-align: center;
        height: 35px;
    }

    .event-details .event-details_cards .gangatiri img {
        border-radius: .5rem;
    }

    .event-details h3 {
        color: orange;
        margin-bottom: 1rem;
    }

    .event-details h2 {
        color: #555;
    }
</style>

<div class="container main-div" style="background-color:white;">
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
    @if(session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
    @endif
    <section class=" m-5 pb-5 event-details">
        <h2 class="text-center">
        <span data-hi="नवीनतम समाचार और घटनाएँ" data-en="LATEST NEWS AND EVENTS">  </span>
       </h2>


       
       @foreach($events as $event)
            <div class="my-lg-5 my-md-4 my-3">
                <h3 class="text-center">
                    <span data-hi="{{ $event->title_hind }}" data-en="{{ $event->title }}">  </span>
                </h3>
                <div>
                    <div class="event-details_cards d-flex  align-items-center flex-wrap gap-4 ">
                        @php $i = 1 @endphp
                        @foreach(json_decode($event->images, true) as $image)
                            <div class="position-relative gangatiri">
                                <span class="count-number">{{ $i }}</span>
                                <img src="{{ asset($image) }}" alt="" class="img-fluid">
                            </div>
                            @php $i++ @endphp
                        @endforeach
                    </div>
                </div>
            </div>
            
        @endforeach
    </section>





</div>
@endsection