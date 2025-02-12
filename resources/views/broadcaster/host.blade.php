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
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" /> -->
    <style>
    html{
        margin: 0px;
    }    
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
        / top: 50%; /
        text-align: center;
    }

    .relative {
        position: relative;
    }

    .text-center {
        text-align: center;
    }
    button#mic-control svg {
        position: relative;
        top: 3px;
        margin-right: 6px;
    }
    button#camera-control svg{
        position: relative;
        top: 3px;
        margin-right: 6px;
    }
    button#camera-control {
        background: #ea7427;
        border: 1px solid #000;
    }
    button#mic-control{
        border: 1px solid #000;
    }
    div#local-controls button {
        margin: 0;
        border-radius: 100px;
    }
    button#join-button svg, button#leave-button svg{
        position: relative;
        top: 3px;
        margin-right: 6px;    
    }
    </style>
</head>

<body>

    <div class="container-fluid custom_frame">
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
                <button class="button" style="margin: auto;" id="join-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-video-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M0 5a2 2 0 0 1 2-2h7.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 4.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 13H2a2 2 0 0 1-2-2z"/>
                </svg>
                Join Stage</button>
                <button class="button" style="margin: auto;" id="leave-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                </svg>
                Leave Stage</button>
            </div>
        </div>

        <div class="row local-container">
            <div class="w-100 relative">
                <div class="column" id="local-media"></div>
                <!-- <div class="col-md-12 flex"> -->
                <div class="static-controls hidden" id="local-controls">
                    <button class="button" id="mic-control">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mic-mute-fill" viewBox="0 0 16 16">
                    <path d="M13 8c0 .564-.094 1.107-.266 1.613l-.814-.814A4 4 0 0 0 12 8V7a.5.5 0 0 1 1 0zm-5 4c.818 0 1.578-.245 2.212-.667l.718.719a5 5 0 0 1-2.43.923V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 1 0v1a4 4 0 0 0 4 4m3-9v4.879L5.158 2.037A3.001 3.001 0 0 1 11 3"/>
                    <path d="M9.486 10.607 5 6.12V8a3 3 0 0 0 4.486 2.607m-7.84-9.253 12 12 .708-.708-12-12z"/>
                    </svg>  
                    Mute Mic</button>
                    <button class="button" id="camera-control">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-video-off-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10.961 12.365a2 2 0 0 0 .522-1.103l3.11 1.382A1 1 0 0 0 16 11.731V4.269a1 1 0 0 0-1.406-.913l-3.111 1.382A2 2 0 0 0 9.5 3H4.272zm-10.114-9A2 2 0 0 0 0 5v6a2 2 0 0 0 2 2h5.728zm9.746 11.925-10-14 .814-.58 10 14z"/>
                    </svg>
                    </svg>    
                    Mute Camera</button>
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