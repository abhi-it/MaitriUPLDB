<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css" />
    <title>IVS Real-Time Streaming</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://web-broadcast.live-video.net/1.20.0/amazon-ivs-web-broadcast.js"></script>

    <style>
    html,
    body {}

    .participant-container {
        position: relative;
        margin: auto;
        width: 100%;
    }

    .participant-container span {
        position: absolute;
        display: inline-block;
        top: 0;
        right: 0;
        color: #fff;
        font-size: 200%;
        background: rgba(0, 0, 0, 0.5);
        font-size: 1.2rem;
    }

    .participant-container video {
        width: 100%;
        max-height: 700px;
    }

    .columns {
        text-align: center;
        justify-content: center;
        width: 100%;
        display: flex;
        align-items: center;
        gap: 20px;
        position: absolute;
        bottom: 30px;
        z-index: 9;
    }

    .custom_frame {
        border-radius: 7px;
        padding: 23px 32px;
        padding-bottom: 17px;
        background: rgb(234 115 39 / 8%);

    }

    .video-container {
        max-width: 95%;
        margin: 0 auto;

        position: relative;
    }

    .text-center {
        text-align: center;
    }

    hr {
        margin: 2rem 0;
    }

    #remote-media video {
        width: 100%;
        display: block;
        border: 2px solid #000;
        border-radius: 8px;
        max-height: calc(100vh - 97px);
        object-fit: cover;
    }

    #leave-button {
        background: #ff2323;
        border: 1px solid #ff2323;
    }

    #join-button {
        background: #8803fc;
        border: 1px solid #8803fc;
    }

    .column button {

        width: 100%;
    }

    button#mic-control {
        background: #ea7327;
        border: 1px solid #ea7327;
        display: none;
    }

    .container-box {
        height: calc(100vh - 60px);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .card-item {
        background: transparent;
        width: 100%;
        max-width: 910px;
        margin: 0 auto;

    }

    .local-container {
        flex: 1 1 0%;
    }

    .card-item h3 {
        font-size: 32px;
        color: black;
        font-weight: 600;
        margin: 0;
    }

    center {
        margin-top: 30px;
    }

    .flex-full {

        width: 100%;
    }

    .button i {
        font-size: 14px;
    }

    .button {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border-radius: 30px;
    }

    .relative {
        position: relative;
    }

    #loader {
        display: none;
    }

    .spinner-border {
        margin-top: 5px;
        margin-left: 10px;
    }
    </style>
</head>

<body>
    <div class="container-fluid custom_frame">
        <div class="container-box ">
            <div class="card-item">
                <h3 class="text-center">राष्ट्रीय गोकुल मिशन वेबिनार - लाइव स्ट्रीम</h3>
                <p class="text-center mt-3 fs-5" id="hide-msg">सीधे वेबिनार में शामिल होने के लिए नीचे दिए गए बटन पर
                    क्लिक
                    करें!</p>
                <center>
                    <button class="button" id="join-button">
                        वेबिनार में शामिल हों
                        <div class="spinner-border" id="loader" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </button>
                </center>
                <p class="text-center mt-3 fs-5" id="error-msg">कोई सक्रिय प्रसारण नहीं मिला। कृपया वेबिनार शुरू होने की
                    प्रतीक्षा करें या बाद में पुनः प्रयास करें।</p>

                <div class="row"></div>
                <div id="broadcast-status" style="display: none; color: red; font-weight: bold;">
                    Broadcast has not started yet.
                </div>
            </div>

            <!-- Local Participant -->
            <!-- <div class="local-container" >
            <div id="local-media"></div></div> -->
            <!-- Remote Participants -->
            <div class="flex-full video-container relative">
                <div class="columns" id="mute_leave_btn">
                    <label for="token" style="display: none;">Token</label>
                    <input type="text" id="token" name="token" value="{{$token}}" style="display: none;" />
                    <!-- <button class="button" id="join-button">Join</button> -->
                    <button class="button" style="display:none;" id="leave-button">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                        वेबिनार छोड़ें
                    </button>
                    <button class="button" style="display:none;" id="mic-control"><i class="fa fa-volume-up"></i> आवाज़
                        बंद करें</button>
                </div>

                <div id="remote-media"></div>
            </div>
        </div>
    </div>

    <script src="/js/subscriber.js"></script>
    <script src="/js/media-devices.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#leave-button').click(function() {
            $('#remote-media').empty();
        })
    });
    </script>

    <script>
    document.getElementById("join-button").addEventListener("click", function() {
        this.style.display = "none"; // Hide Join button
        setTimeout(() => {
            document.getElementById("mic-control").style.display = "inline-block";
            document.getElementById("leave-button").style.display = "inline-block";
        }, 5000); // Delay for 5 seconds
    });

    document.getElementById("leave-button").style.display = "none";
    document.getElementById("mic-control").style.display = "none";

    document.getElementById("leave-button").addEventListener("click", function() {
        this.style.display = "none"; // Hide Leave button
        document.getElementById("mic-control").style.display = "none";
        document.getElementById("join-button").style.display = "inline-block";
    });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {

        const participantCountSpan = document.getElementById("participant-count");
        const joinButton = document.getElementById("join-button");
        const stageArn = "{{ $stageArn }}";


        async function fetchLiveParticipants() {
            try {
                const response = await fetch(`/ivs/live-participants?stageArn=${stageArn}`);
                const data = await response.json();

                if (data.count !== undefined) {
                    participantCountSpan.innerText = data.count;
                }
            } catch (error) {
                console.error("Error fetching participant count:", error);
            }
        }

    });
    </script>

</body>

</html>