@extends('master')
@section('content')

<div class="container">
    <div class="row mt-5">
        <h3>Search Results for: "{{ $query }}"</h3>
    </div>

    @if($results->isEmpty())
        <p>No matching routes found.</p>
    @else
        @foreach($results as $result)
            <h5>{{ $result['title'] }}</h5>
            <p>
                {{ $result['excerpt'] }}
                <a href="{{ $result['link'] }}">Read More</a>
            </p>
        @endforeach
    @endif
</div>

@endsection