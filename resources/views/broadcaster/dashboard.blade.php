@extends('broadcaster.layout.header')
@section('content')
<style>
footer.position-relative {
    position: absolute !important;
    bottom: 0;
    width: 100%;
}

.livestream {
    align-items: center;
    justify-content: center;
    height: calc(100vh - 500px);
    gap: 50px;
}

.livestream a {
    border: 2px solid #30201e;
    border-radius: 7px;
    font-size: 23px !important;
    padding: 28px 24px !important;
    background: #ea7327;
    color: #fff !important;
    box-shadow: 1px 3px 7px rgb(0 0 0 / 31%);
    max-width: 383px;
    text-align: center;
    min-width: 375px;
}

header .navbar li.nav-item.active a.nav-link {
    color: #ffffff !important;
}

/* nav {
    height: calc(100vh - 300px);
} */
</style>
<div class="container pt-4">
    <h1>Broadcaster Dashboard</h1>
    <p>Welcome to your dashboard!</p>

    <div class="d-flex livestream">
        <a class="nav-link" href="{{ route('addBroadcaster') }}" style="font-size: 15px;">RealTime Streaming</a>
        {{-- <a class="nav-link" href="{{ route('listChannels') }}" style="font-size: 15px;">Ultra Low Latency Streaming</a> --}}
    </div>
</div>
</div>
</div>
@endsection