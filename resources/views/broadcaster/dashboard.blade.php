@extends('broadcaster.layout.header')
@section('content')

<div class="container">
    <h1>Broadcaster Dashboard</h1>
    <p>Welcome to your dashboard!</p>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('stageList') }}" style="font-size: 15px;">Stages</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('listChannels') }}" style="font-size: 15px;">Channels</a>
            </li>
        </ul>
    </nav>
        </div>
    </div>
</div>
@endsection