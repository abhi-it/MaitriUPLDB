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

.link-box {
    display: flex;
    align-items: center;
    background: #f1f3f4;
    padding: 12px;
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

@keyframes fadeOut {
    to {
        opacity: 0;
    }
}
</style>


<div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:600px;">
    <h3 class="text-center fw-bold m-4">Broadcaster Details</h3>
    @if(count($data)>0)
    <div class="card card-str">
        {{--<p>Id : <span>{{ $data['participantToken']['participantId'] }}</span></p>
        <p>Participant's Joining Link :</p>
        <p>
            <span class="d-block"><a
                    href="/join-webinar?stageArn={{ $stageArn }}">{{ url('/') }}/join-webinar?stageArn={{ $stageArn }}</a></span>
        </p>--}}

        <p>Share Your Broadcasting Link</p>
        <p>Copy this link and share it with the people.</p>
        <div class="copy-container">
            <span class="copy-message" id="copy-message">Link copied!</span>

            <div class="link-box">
                <input type="text" disabled id="participant-link"
                    value="{{ route('join_webinar', ['token' => $stageArn]) }}" readonly>
                <button class="copy-btn" disabled onclick="copyToClipboard()">
                    📋
                </button>
            </div>
        </div>
        <!-- <p class="text-center mt-3">Do't have go live credits </p> -->

        <!-- <form method="GET" class="text-right" target="_black"
            action="{{ route('start_webinar', ['stageArn' => $data['participantToken']['token']]) }}">
            @csrf
            <input type="hidden" name="stageArn" value="{{ $stageArn }}">
            <input type="hidden" name="token" value="{{ $data['participantToken']['token'] }}">
            <button type="submit" class="btn btn-primary">Start Live Streaming</button>
        </form> -->

        <form id="startWebinarForm" class="text-right">
            @csrf
            <input type="hidden" id="stageArn" name="stageArn" value="{{ $stageArn }}">
            <input type="hidden" id="token" name="token" value="{{ $data['participantToken']['token'] }}">
            <button type="submit" id="startWebinarBtn" class="btn btn-primary">Start Live Streaming</button>
        </form>

    </div>
    @else
    <p>No record found..</p>
    @endif
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $("#startWebinarForm").on("submit", function(e) {
        e.preventDefault();

        var baseUrl = window.location.origin;
        var routePath = "/start-webinar";
        var stageArn = $("#stageArn").val();
        var token = $("#token").val();
        var csrfToken = encodeURIComponent("{{ csrf_token() }}"); // Laravel CSRF token

        var checkLiveMode = 'off';

        var requestUrl =
            `${baseUrl}${routePath}?_token=${csrfToken}&stageArn=${stageArn}&token=${token}`;

        if (checkLiveMode == 'off') {
            Swal.fire({
                icon: "warning",
                title: "Live Streaming Unavailable",
                text: "Don't have go live credits",
                confirmButtonText: "OK"
            });
            return false;
        } else {
            window.open(requestUrl, '_blank');
        }

        // var formData = {
        //     stageArn: $("#stageArn").val(),
        //     token: $("#token").val(),
        //     _token: "{{ csrf_token() }}"
        // };

        // $.ajax({
        //     url: "{{ route('start_webinar') }}",
        //     type: "GET",
        //     data: formData,
        //     success: function(response) {
        //         window.location.href = "start-webinar";
        //         // alert("Webinar started successfully!");
        //         // console.log(response);
        //         // $("#startWebinarBtn").prop("disabled",true); 
        //     },
        //     error: function(xhr, status, error) {
        //         alert("Error starting webinar: " + xhr.responseText);
        //         console.error(error);
        //     }
        // });
    });
});
</script>

<script>
function copyToClipboard() {
    var inputField = document.getElementById("participant-link");
    var message = document.getElementById("copy-message");
    // inputField.select();
    // inputField.setSelectionRange(0, 99999); // For mobile devices
    navigator.clipboard.writeText(inputField.value).then(() => {
        message.style.display = "block";
        setTimeout(() => {
            message.style.display = "none";
        }, 1000);
    }).catch(err => {
        console.error("Copy failed: ", err);
    });
}
</script>

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