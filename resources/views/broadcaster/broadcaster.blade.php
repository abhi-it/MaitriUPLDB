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
    <h3 class="text-center fw-bold m-4">Broadcaster Details</h3>
    @if(count($data)>0)
    <div class="card card-str">
        <p>Id : <span>{{ $data['participantToken']['participantId'] }}</span></p>
        <p>Participant's Joining Link :</p>
        <p>
            <span class="d-block"><a
                    href="/join-webinar?stageArn={{ $stageArn }}">{{ url('/') }}/join-webinar?stageArn={{ $stageArn }}</a></span>
        </p>
        <form method="GET" class="text-right" target="_black"
            action="{{ route('start_webinar', ['stageArn' => $data['participantToken']['token']]) }}">
            @csrf
            <input type="hidden" name="stream_key" value="{{ $data['stream_key'] }}">
            <input type="hidden" name="ingest_endpoint" value="{{ $data['ingest_endpoint'] }}">
            <input type="hidden" name="token" value="{{ $data['participantToken']['token'] }}">
            <button type="submit" class="btn btn-primary">Start Live Streaming</button>
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
                <!-- <th>Capability</th> -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

            @if(count($data)>0)

            @php $i = 1 @endphp
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $data['participantToken']['participantId'] }}</td>
                <td>
                    <a
                        href="/join-webinar?stageArn={{ $stageArn }}">{{ url('/') }}/join-webinar?stageArn={{ $stageArn }}</a>

                </td>
                {{--<td> {{  $data['participantToken']['capabilities'][0] }}</td>
                <td>
                    <span class="short-token">
                        {{ substr($data['token'], 0, 60) }}...
                        <a href="javascript:void(0);" class="show-more"
                            data-token="{{ $data['participantToken']['token'] }}">Show More</a>
                    </span>
                </td>--}}

                <td>
                    <form method="GET"
                        action="{{ route('start_webinar', ['stageArn' => $data['participantToken']['token']]) }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $data['participantToken']['token'] }}">
                        <button type="submit" class="btn btn-primary">Start</button>
                    </form>
                </td>
            </tr>
            @php $i++ @endphp
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
    $(this).parent().html(shortToken + ' <a href="javascript:void(0);" class="show-more" data-token="' + $(this)
        .parent().text() + '">Show More</a>');
});
</script>


@endsection