@extends('broadcaster.layout.header')
@section('content')
    <div x-data="" class="container main-div" style="background-color:white; height: 100%;">
    <div x-data="" class="container main-div" style="background-color:white; height: 100%;">
    {{--<div class="d-flex justify-content-between align-items-center m-4">
        <h3 class="text-center fw-bold">Channels List</h3>
        <a href="{{ route('addChannel') }}" class="btn btn-primary">Add Channel</a>
    </div>--}}
</div>
        <table id="myTable202" class="table table-striped  table-responsive table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Playback URL</th>
                    <th>Start Live Streaming</th>
                    {{--<th>Channel ARN</th>                
                    <th>Ingest Endpoint</th>--}}
                </tr>
            </thead>
            <tbody >
            @if(count($channels)>0)
            @foreach($channels as $data)
                @php $i = 1 @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $data['channel_name'] }}</td>
                    <td>
                        <a href="{{ route('ivs_playback', ['url' => $data['playback_url']]) }}" target="_blank">
                            {{ route('ivs_playback', ['url' => $data['playback_url']]) }}
                        </a>
                    </td>

                    {{-- <td>
                        <!-- <a href="{{ route('ivs_playback', ['playback_url' => $data['playback_url']]) }}" class="btn btn-primary">Plackback URL</a> -->
                        <form method="POST" action="{{ route('ivs.playback') }}">
                            @csrf
                            <input type="hidden" name="playback_url" value="{{ $data['playback_url'] }}">
                            <button type="submit" class="btn btn-primary">Plackback</button>
                        </form>

                    </td>--}}
                    <td>
                        <form method="GET" action="{{ route('ivs_latency') }}">
                            <input type="hidden" name="stream_key" value="{{ $data['stream_key'] }}">
                            <input type="hidden" name="ingest_endpoint" value="{{ $data['ingest_endpoint'] }}">
                            <button type="submit" class="btn btn-primary">Stream</button>
                        </form>
                    </td>

                    {{--<td>{{ $data['channel_arn'] }}</td>
                    <td>{{ $data['stream_key'] }}</td> 
                    <td>{{ $data['ingest_endpoint'] }}</td>--}}
                </tr>
                @php $i++ @endphp
            @endforeach
            @else
                <tr>
                    <td colspan="6" style="color:red;">No record found..</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on("click", ".show-more", function() {
        let fullToken = $(this).data("token");
        $(this).parent().html(fullToken + ' <a href="javascript:void(0);" class="show-less">Show Less</a>');
    });

    $(document).on("click", ".show-less", function() {
        let shortToken = $(this).parent().text().substring(0, 30) + '...';
        $(this).parent().html(shortToken + ' <a href="javascript:void(0);" class="show-more" data-token="' + $(this).parent().text() + '">Show More</a>');
    });
</script>


@endsection

