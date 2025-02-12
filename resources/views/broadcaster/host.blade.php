<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Amazon IVS Real-Time Streaming Web Sample (HTML and JavaScript)</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

    <script src="https://web-broadcast.live-video.net/1.20.0/amazon-ivs-web-broadcast.js"></script>

    <style>
    #local-media video {
        max-height: 700px;
        width: 100%;
    }

    .flex {
        display: flex;
        justify-content: center;
        width: 100%;
        align-items: center;
    }

    .w-100 {
        width: 100%;
    }

    .static-controls {
        position: absolute;
        margin-left: auto;
        margin-right: auto;
        left: 0;
        right: 0;
        bottom: 45px;
        /* top: 50%; */
        text-align: center;
    }

    .relative {
        position: relative;
    }

    .text-center {
        text-align: center;
    }
    </style>
</head>

<body>

    <div class="container custom_frame">
        <div class="row">
            <div class="column">
                <label for="video-devices">Select Camera</label>
                <select disabled id="video-devices">
                    <option selected disabled>Choose Option</option>
                </select>
            </div>
            <div class="column">
                <label for="audio-devices">Select Microphone</label>
                <select disabled id="audio-devices">
                    <option selected disabled>Choose Option</option>
                </select>
            </div>


            <div class="column" style="display:none;">
                <label for="token">Participant Token</label>
                <input type="text" id="token" name="token" value={{$token}} />
            </div>

            <div class="column" style="display: flex; margin-top: 1.5rem">
                <button class="button" style="margin: auto; width: 100%" id="join-button">Join Stage</button>
            </div>
            <div class="column" style="display: flex; margin-top: 1.5rem">
                <button class="button" style="margin: auto; width: 100%" id="leave-button">Leave Stage</button>
            </div>
        </div>

        <div class="row local-container">
            <div class="w-100 relative">
                <div class="column" id="local-media"></div>
                <!-- <div class="col-md-12 flex"> -->
                <div class="static-controls hidden" id="local-controls">
                    <button class="button" id="mic-control">Mute Mic</button>
                    <button class="button" id="camera-control">Mute Camera</button>
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>
    <hr style="margin-top: 5rem" />

    <div class="row">
        <div id="remote-media"></div>
    </div>

    <script src="/js/helpers.js"></script>
    <script src="/js/media-devices.js"></script>
    <script src="/js/stages-simpel.js"></script>
</body>

</html>