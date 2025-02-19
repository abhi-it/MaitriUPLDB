@extends('broadcaster.layout.header')

@section('content')

<div class="container">
    <h3 class="text-center mt-3">Webinar's</h3>

    <a href="{{ route('stage.create') }}" class="btn btn-primary">Create New Webinar</a>

    <table border="1" class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Webinar Title</th>
                <th>Webinar Description</th>
                <th>Scheduled At</th>
                <th>Re-Schedule</th>
                <th>Created Date</th>
                <th>Start Webinar</th>
            </tr>
        </thead>
        <tbody>
            @if(count($stages) > 0)
            @php $i=1 @endphp
            @foreach($stages as $webinar)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $webinar->title }}</td>
                <td>{{ $webinar->description ?? '' }}</td>
                <td>{{ $webinar->scheduled_at ?? '' }}</td>
                <!-- <td>{{ $webinar->stage_arn ?? '' }}</td> -->
                <td>
                    @if($webinar->id)
                    <a href="{{ route('stage.create', ['id' => $webinar->id]) }}"
                        class="btn btn-primary btn-sm">Re-Schedule</a>
                    @else
                    <span>Not Available</span>
                    @endif
                </td>
                <td>{{ $webinar->created_at ?? '' }}</td>
                <td>
                    @if($webinar->stage_arn)
                    <a href="{{ url('') }}/ivs/broadcaster/?stgArn={{ $webinar->stage_arn }}" class="btn btn-primary"
                        target="_blank">Start</a>
                    @else
                    <span>Not Started</span>
                    @endif
                </td>
            </tr>
            @php $i++ @endphp
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="6">No Webinar Found...</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

@endsection