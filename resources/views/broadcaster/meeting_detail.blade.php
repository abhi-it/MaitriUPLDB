@extends('broadcaster.layout.header')
@section('content')

<style>
    .card-str {
        padding: 30px;
        max-width: 600px;
        margin: 0 auto;
    }

    .card-str p span {
        color: #ea7327;
    }

    .card-str p {
        font-size: 18px;
    }
</style>

<div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:600px;">
    <h3 class="text-center fw-bold m-4">Meeting Details</h3>
    @if(!empty($data[0]))
    <div class="card card-str">
        <p>Id : <span>{{ $data[0]['channel_name'] }}</span></p>
        <p>Participant's Joining Link :</p>
        {{--<p>
            <span class="d-block" id="participant-link" ><a href="{{ route('ivs_playback', ['url' => $data[0]['playback_url']]) }}"
                    target="_blank">
                    {{ route('ivs_playback', ['url' => $data[0]['playback_url']]) }}
                </a></span>
        </p>--}}

        <p>
            <span class="d-block" id="participant-link">
                <a href="{{ route('ivs_playback', ['url' => $data[0]['playback_url']]) }}" target="_blank">
                    {{ route('ivs_playback', ['url' => $data[0]['playback_url']]) }}
                </a>
            </span>
            <button onclick="copyToClipboard()" style="background: none; border: none; cursor: pointer;">
                📋
            </button>
        </p>

        <form method="GET" class="text-right" target="_blank" action="{{ route('ivs_latency') }}">
            <input type="hidden" name="stream_key" value="{{ $data[0]['stream_key'] }}">
            <input type="hidden" name="ingest_endpoint" value="{{ $data[0]['ingest_endpoint'] }}">
            <button type="submit" class="btn btn-primary">Stream</button>
        </form>
    </div>
    @else
    <p>No record found..</p>
    @endif

    <table id="myTable202" class="table table-striped  table-responsive table-bordered d-none">
        <thead>
            <tr>
                <th>S.No</th>
                <th>ID</th>
                <th>Participant's Joining Link</th>
                <th>Start Live Streaming</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($data[0]))
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
    function copyToClipboard() {
        var link = document.getElementById("participant-link").innerText.trim();
        navigator.clipboard.writeText(link).then(() => {
            alert("Link copied to clipboard!");
        }).catch(err => {
            console.error("Failed to copy: ", err);
        });
    }
</script>

<script>
    $(document).on("click", ".show-more", function () {
        let fullToken = $(this).data("token");
        $(this).parent().html(fullToken + ' <a href="javascript:void(0);" class="show-less">Show Less</a>');
    });

    $(document).on("click", ".show-less", function () {
        let shortToken = $(this).parent().text().substring(0, 30) + '...';
        $(this).parent().html(shortToken + ' <a href="javascript:void(0);" class="show-more" data-token="' + $(this).parent().text() + '">Show More</a>');
    });
</script>


@endsection