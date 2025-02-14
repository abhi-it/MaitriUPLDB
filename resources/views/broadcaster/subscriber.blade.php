<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css" />
    <title>IVS Real-Time Streaming - Basic Sample</title>
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
    </style>
</head>

<body>
    <div class="container-fluid custom_frame">
        <div class="container-box ">
            <div class="card-item">
                <h3 class="text-center">राष्ट्रीय गोकुल मिशन वेबिनार - लाइव स्ट्रीम</h3>

                <center> <button class="button" id="join-button">वेबिनार में शामिल हों</button> </center>

                <!-- Setup Controls -->
                <div class="row">


                </div>

            </div>
            <!-- Local Participant -->
            <!-- <div class="local-container" >
            <div id="local-media"></div>
        </div> -->
            <!-- Remote Participants -->
            <div class="flex-full video-container relative">
                <div class="columns">
                    <label for="token" style="display: none;">Token</label>
                    <input type="text" id="token" name="token" value={{$token}} style="display: none;" />
                    <!-- <button class="button" id="join-button">Join</button> -->
                    {{--<button class="button" style="display:none;" id="leave-button">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                        Leave</button>
                    <button class="button" id="mic-control">Mute</button>--}}

                    <button class="button" style="display:none;" id="leave-button">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                        वेबिनार छोड़ें
                    </button>
                    <button class="button" style="display:none;" id="mic-control"><i class="fa fa-microphone-slash"
                            aria-hidden="true"></i> आवाज़ बंद करना</button>
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
        document.getElementById("leave-button").style.display = "inline-block"; // Show Leave button
        document.getElementById("mic-control").style.display = "inline-block"; // Show Mute button
    });

    document.getElementById("leave-button").addEventListener("click", function() {
        this.style.display = "none"; // Hide Leave button
        document.getElementById("mic-control").style.display = "none"; // Hide Mute button
        document.getElementById("join-button").style.display = "inline-block"; // Show Join button again
    });
    </script>
</body>

</html>