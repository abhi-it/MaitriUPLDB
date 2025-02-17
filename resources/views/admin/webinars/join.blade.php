@extends('broadcaster.layout.header')

@section('content')
<h2>Join Webinar: {{ $webinar->title }}</h2>

@if($webinar->meeting_id)
<a href="https://app.chime.aws/meetings/{{ $webinar->meeting_id }}" target="_blank">Join Now</a>
@else
<p>The webinar has not started yet.</p>
@endif
@endsection