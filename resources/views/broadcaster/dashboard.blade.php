@extends('broadcaster.layout.header')
@section('content')

<div class="container">
    <h1>Broadcaster Dashboard</h1>
    <p>Welcome to your dashboard!</p>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('addBroadcaster') }}" style="font-size: 15px;">RealTime Streaming</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('listChannels') }}" style="font-size: 15px;">Ultra Low Latency Streaming</a>
            </li>
        </ul>
    </nav>
        </div>
    </div>
</div>
@endsection