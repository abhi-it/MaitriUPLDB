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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if(count($stages) > 0)
            @php $i=1 @endphp
            @foreach($stages as $webinar)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $webinar->title }}</td>
                <td>{{ $webinar->description ?? 'N\A' }}</td>
                <td>{{ $webinar->scheduled_at ?? 'N\A' }}</td>
                <!-- <td>{{ $webinar->stage_arn ?? '' }}</td> -->
                <td>
                    @php
                    date_default_timezone_set('Asia/Kolkata');
                    $currentTimestamp = time();
                    $scheduledTimestamp = $webinar->scheduled_at ? strtotime($webinar->scheduled_at) : null;
                    @endphp

                    @if($scheduledTimestamp && $scheduledTimestamp > $currentTimestamp)
                    <a href="{{ route('stage.create', ['id' => $webinar->id]) }}"
                        class="btn btn-primary btn-sm">{{ $webinar->scheduled_at ? 'Re-Scheduled' : 'Scheduled' }}</a>
                    @else
                    <span>N/A</span>
                    @endif
                </td>

                <td>{{ $webinar->created_at ?? '' }}</td>
                <td>
                    @if($scheduledTimestamp && $scheduledTimestamp > $currentTimestamp)
                    <a href="{{ url('') }}/ivs/broadcaster/?stgArn={{ $webinar->stage_arn }}" class="btn btn-primary"
                        target="_blank">Start Webinar</a>
                    @else
                    <button type="button" class="btn btn-success">Webinar Done</button>
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