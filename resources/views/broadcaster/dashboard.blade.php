@extends('broadcaster.layout.header')
@section('content')
<style>
ul.navbar-nav {
    display: flex;
    gap: 16px;
    height: 100%;
    align-items: center;
}

ul.navbar-nav li a {
    border: 2px solid #30201e;
    border-radius: 7px;
    font-size: 24px !important;
    padding: 28px 36px !important;
    background: #ea7327;
    color: #fff !important;
    box-shadow: 1px 3px 7px rgb(0 0 0 / 31%);
}

footer.position-relative {
    position: absolute !important;
    bottom: 0;
    width: 100%;
}

nav {
    height: calc(100vh - 300px);
}
</style>
<div class="container">
    <h1>Broadcaster Dashboard</h1>
    <p>Welcome to your dashboard!</p>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('stageList') }}" style="font-size: 15px;">RealTime Streaming</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('listChannels') }}" style="font-size: 15px;">Ultra Low Latency
                    Streaming</a>
            </li>
        </ul>
    </nav>
</div>
</div>
</div>
@endsection