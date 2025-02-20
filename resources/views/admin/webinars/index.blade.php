@extends('broadcaster.layout.header')

@section('content')

<style>
.link-box {
    display: flex;
    align-items: center;
    background: #f1f3f4;
    padding: 6px;
    border-radius: 8px;
    border: 1px solid #d1d1d1;
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
}

.link-box input {
    border: none;
    background: transparent;
    width: 100%;
    font-size: 16px;
    outline: none;
    cursor: default;

}

.copy-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 18px;
    margin-left: 10px;
}

.copy-btn:hover {
    color: #007bff;
}

.copy-message {
    position: absolute;
    top: 75px;
    left: 84%;
    transform: translateX(-50%);
    background: #4caf50;
    color: white;
    padding: 2px 5px;
    border-radius: 5px;
    font-size: 14px;
    display: none;
    animation: fadeOut 0.2s ease-in-out 1.5s forwards;
}
</style>
<div class="container">
    <h3 class="text-center mt-3">Webinars</h3>

    <a href="{{ route('stage.create') }}" class="btn btn-primary">Create New Webinar</a>

    <span class="copy-message" id="copy-message">Link copied!</span>
    <table border="1" class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Webinar Title</th>
                <th>Webinar Description</th>
                <th>Scheduled At</th>
                <th>Share Like</th>
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
                <td>{{ $webinar['title'] }}</td>
                <td>{{ $webinar['description'] ?? 'N\A' }}</td>
                <td>{{ $webinar['scheduled_at'] ?? 'N\A' }}</td>
                <td>
                    <div class="link-box">
                        <input type="text" disabled id="participant-link" class="participant-link"
                            value="{{ route('join_webinar', ['token' => $webinar['stage_arn']]) }}" readonly>
                        <button class="copy-btn"
                            data-url="{{ route('join_webinar', ['token' => $webinar['stage_arn']]) }}">
                            📋
                        </button>
                    </div>
                </td>
                <td>
                    @php
                    date_default_timezone_set('Asia/Kolkata');
                    $currentTimestamp = time();
                    $scheduledTimestamp = $webinar['scheduled_at'] ? strtotime($webinar['scheduled_at']) : null;
                    @endphp

                    @if($scheduledTimestamp && $scheduledTimestamp > $currentTimestamp)
                    <a href="{{ route('stage.create', ['id' => $webinar['id'] ]) }}"
                        class="btn btn-primary btn-sm">{{ $webinar['scheduled_at'] ? 'Re-Scheduled' : 'Scheduled' }}</a>
                    @else
                    <span>N/A</span>
                    @endif
                </td>

                <td>{{ $webinar['created_at'] ?? '' }}</td>
                <td>
                    @if($scheduledTimestamp && $scheduledTimestamp > $currentTimestamp)
                    <a href="{{ url('') }}/ivs/broadcaster/?stgArn={{ $webinar['stage_arn'] }}" class="btn btn-primary"
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

<script src="/js/sweetalert-upldb.js"></script>
<script src="/js/jquery-min-upldb.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- <script>
$(document).ready(function() {
    $('.copy-btn').click(function() {
        var inputField = $('.participant-link'); // Corrected selector
        var inputValue = inputField.val(); // Get input value

        if (inputValue) {
            navigator.clipboard.writeText(inputValue).then(() => {
                $('.copy-message').fadeIn(300).delay(1000).fadeOut(300);
            }).catch(err => {
                console.error("Copy failed: ", err);
            });
        } else {
            console.error("Input field is empty or not found.");
        }
    });
});
</script> -->

<script>
$(document).ready(function() {
    jQuery('.copy-btn').click(function() {
        var copyUrl = $(this).data('url');
        if (copyUrl) {
            navigator.clipboard.writeText(copyUrl).then(() => {
                $('.copy-message').fadeIn(300).delay(1000).fadeOut(300);
            }).catch(err => {
                console.error("Copy failed: ", err);
            });
        } else {
            console.error("Input field is empty or not found.");
        }
    })
});
</script>

@endsection