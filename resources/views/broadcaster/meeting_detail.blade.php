@extends('broadcaster.layout.header')
@section('content')

    <div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center fw-bold m-4">Meeting Details</h3>
        <table id="myTable202" class="table table-striped  table-responsive table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>ID</th>
                    <th>Participant's Joining Link</th>
                    <th>Start Live Streaming</th>
                </tr>
            </thead>
            <tbody >
               
            @if(!empty($data))
                @php $i = 1; @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $data[0]['channel_name'] }}</td>
                   {{-- <td>{{ $data[0]['playback_url'] }}</td>--}}
                   <td>
                        <a href="{{ route('ivs_playback', ['url' => $data[0]['playback_url']]) }}" target="_blank">
                            {{ route('ivs_playback', ['url' => $data[0]['playback_url']]) }}
                        </a>
                    </td>

                    <td>
                        <form method="GET" action="{{ route('ivs_latency') }}">
                            <input type="hidden" name="stream_key" value="{{ $data[0]['stream_key'] }}">
                            <input type="hidden" name="ingest_endpoint" value="{{ $data[0]['ingest_endpoint'] }}">
                            <input type="hidden" name="playbackUrl" value="{{ $data[0]['playback_url'] }}">
                            <button type="submit" class="btn btn-primary">Stream</button>
                        </form>
                    </td>
                </tr>
                @php $i++; @endphp
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

