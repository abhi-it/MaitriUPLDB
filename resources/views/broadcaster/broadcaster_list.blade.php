@extends('broadcaster.layout.header')
@section('content')
<div x-data="" class="container main-div" style="background-color:white; height: 100%;">
    <div x-data="" class="container main-div" style="background-color:white; height: 100%;">
        <div class="d-flex justify-content-between align-items-center m-4">
            <h3 class="text-center fw-bold">Broadcasters List</h3>
            <a href="{{ route('addBroadcaster', ['stageArn' => $stageArn]) }}" method="GET" class="btn btn-primary">Add
                Broadcaster</a>
        </div>
    </div>
    <table id="myTable202" class="table table-striped  table-responsive table-bordered">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Participant ID</th>
                <th>State</th>
                <th>First Join Time</th>
                <th>Published</th>
                <th>Recording State</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if(count($allData)>0)
            @php $i = 1 @endphp
            @foreach($allData as $data)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $data['participantId'] }}</td>
                <td>{{ $data['state'] }}</td>
                <td>{{ $data['firstJoinTime'] }}</td>
                <td>{{ $data['published'] }}</td>
                <td>{{ $data['recordingState'] }}</td>
                <td>
                    <a href="{{ route('start_webinar', ['stageArn' => $stageArn]) }}" class="btn btn-primary">Start
                        Streaming</a>

                </td>
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
    $(this).parent().html(shortToken + ' <a href="javascript:void(0);" class="show-more" data-token="' + $(this)
        .parent().text() + '">Show More</a>');
});
</script>


@endsection