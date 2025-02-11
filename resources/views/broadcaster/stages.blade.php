@extends('broadcaster.layout.header')
@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('stageList') }}" style="font-size: 15px;">Stages</a>
        </li>
        <!-- <li class="nav-item">
                <a class="nav-link" href="{{ route('view-details') }}" style="font-size: 15px;">Broadcasters</a>
            </li> -->
    </ul>
</nav>
<div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center fw-bold m-4">Stage List</h3>
    <table id="myTable202" class="table table-striped  table-responsive table-bordered">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Stage ARN</th>
                <th>Join Stage Link</th>
                <th>Active Session ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if(count($stages) > 0)
            @php $i = 1 @endphp
            @foreach($stages as $val)
            <tr>

                <td>{{ $i }}</td>
                <td>{{ $val['name'] }}</td>
                <td>{{ $val['arn'] }}</td>
                <td>
                    <a
                        href="/join-webinar?stageArn={{ $val['arn'] }}">{{ url('/') }}/join-webinar?stageArn={{ $val['arn'] }}</a>

                </td>
                </a>
                <td>{{ $val['activeSessionId'] }}</td>
                <td>
                    <form method="GET" action="{{ route('broadcasterList') }}">
                        @csrf
                        <input type="hidden" name="stageArn" value="{{ $val['arn'] }}">
                        <button type="submit" class="dropdown-item btn btn-primary">Broadcasters List</button>
                    </form>
                </td>
            </tr>
            @php $i++ @endphp
            @endforeach
            @else
            <tr>
                <td colspan="5" style="color:red;">No record found..</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

@endsection