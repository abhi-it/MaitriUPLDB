@extends('broadcaster.layout.header')
@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('stageList') }}" style="font-size: 15px;">Stages</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="" style="font-size: 15px;">BroadCaster</a>
            </li> -->
        </ul>
    </nav>
    <div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center fw-bold m-4">Broadcaster Details</h3>
        <table id="myTable202" class="table table-striped  table-responsive table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>ID</th>
                    <th>capability</th>
                    <th>Expiration Time</th>
                    <th>Stage ARN Token</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody >
            @if(count($data)>0)
                @php $i = 1 @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $data['participantId'] }}</td>
                    <!-- <td>{{ $data['userId'] }}</td> -->
                    <td>{{ json_encode($data['capabilities']) }}</td> 
                    <td>{{ $data['expirationTime'] }}</td> 
                    <!-- <td>{{ $data['token'] }}</td> -->

                    <td>
                        <span class="short-token">
                            {{ substr($data['token'], 0, 60) }}... 
                            <a href="javascript:void(0);" class="show-more" data-token="{{ $data['token'] }}">Show More</a>
                        </span>
                    </td>

                    <td>
                        <form method="GET" action="{{ route('start_webinar', ['stageArn' => $data['token']]) }}">
                            @csrf
                            <input type="hidden" name="stageArn" value="{{ $data['token'] }}">
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
        $(this).parent().html(shortToken + ' <a href="javascript:void(0);" class="show-more" data-token="' + $(this).parent().text() + '">Show More</a>');
    });
</script>


@endsection

