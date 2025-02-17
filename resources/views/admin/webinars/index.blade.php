@extends('broadcaster.layout.header')

@section('content')

<div class="container">
    <h3 class="text-center mt-3">Stage List's</h3>

    <a href="{{ route('stage.create') }}" class="btn btn-primary">Create New Stage</a>

    <table border="1" class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Stage Title</th>
                <th>Stage Description</th>
                <th>Scheduled At</th>
                <th>Stage arn</th>
                <th>Schedule</th>
                <th>Join URL</th>
            </tr>
        </thead>
        <tbody>
            @if(count($stages) > 0)
            @foreach($stages as $stage)
            <tr>
                <td>{{ $stage->id }}</td>
                <td>{{ $stage->title }}</td>
                <td>{{ $stage->description ?? '' }}</td>
                <td>{{ $stage->scheduled_at ?? '' }}</td>
                <td>{{ $stage->stage_arn ?? '' }}</td>
                <td>
                    @if($stage->id)
                    <a href="{{ route('stage.create', ['id' => $stage->id]) }}" class="btn btn-primary">Schedule</a>
                    @else
                    <span>Not Available</span>
                    @endif
                </td>
                <td>
                    @if($stage->stage_arn)
                    <a href="{{ $stage->stage_arnarn }}" target="_blank">Join</a>
                    @else
                    <span>Not Started</span>
                    @endif
                </td>
            </tr>
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