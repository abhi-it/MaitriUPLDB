<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Amazon IVS Real-Time Streaming</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

    <script src="https://web-broadcast.live-video.net/1.20.0/amazon-ivs-web-broadcast.js"></script>
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" /> -->
    <style>
    html {
        margin: 0px;
    }

    #local-media video {
        max-height: 700px;
        width: 100%;
        object-fit: cover;
    }

    #local-media {
        padding: 0;
        max-width: 99%;
        margin: 0px auto;
        display: block;
    }

    #local-media video {
        max-height: calc(100vh - 165px);
        width: 100%;
        object-fit: cover;
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
        / top: 50%;/ text-align: center;
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

    button#camera-control svg {
        position: relative;
        top: 3px;
        margin-right: 6px;
    }

    button#camera-control {
        background: #ea7427;
        border: 1px solid #000;
    }

    button#mic-control {
        border: 1px solid #000;
    }

    div#local-controls button {
        margin: 0;
        border-radius: 100px;
    }

    button#join-button svg,
    button#leave-button svg {
        position: relative;
        top: 3px;
        margin-right: 6px;
    }

    .link-box {
        display: flex;
        align-items: center;
        background: #f1f3f4;
        border-radius: 8px;
        border: 1px solid #d1d1d1;
        width: 100%;
        /* max-width: 50%; */
        max-height: 38px;
    }

    .link-box input {
        border: none;
        background: transparent;
        width: 100%;
        font-size: 16px;
        outline: none;
        cursor: default;
        margin-bottom: 0px;
        max-height: 38px;
    }

    .copy-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 18px;
        margin-left: 10px;
        padding: 0;
        margin-right: 9px;
        margin-top: 7px;
    }

    .copy-btn:hover {
        color: #007bff;
    }


    .copy-message {
        position: absolute;
        top: 30px;
        left: 55%;
        transform: translateX(-50%);
        background: #4caf50;
        color: white;
        padding: 2px 5px;
        border-radius: 5px;
        font-size: 14px;
        display: none;
        animation: fadeOut 0.2s ease-in-out 1.5s forwards;
    }

    .video_wrap P {
        position: absolute;
        right: 62px;
        top: 19px;
        color: #ffffff;
        font-weight: 600;
        font-size: 14px;
    }

    @keyframes fadeOut {
        to {
            opacity: 0;
        }
    }

    button#leave-button {
        width: 100%;
        background: #cd3c3c;
        border: 1px solid #cd3c3c;
    }

    .video_wrap P:before {
        content: "";
        display: block;
        width: 5px;
        height: 5px;
        background: #F44336;
        border-radius: 100%;
        position: absolute;
        left: -15px;
        top: 50%;
        transform: translate(0%, -50%);
    }

    button#join-button {
        width: 100%;
    }

    button.copy-btn:hover {
        background: transparent;
    }

    .video_wrap {
        position: relative;
    }

    #error-msg {
        display: none;
    }
    </style>
</head>

<body>

    <div class="container-fluid custom_frame">
        <ul id="participant-list"></ul>
        <div class="row">
            <div class="column">
                <label for="video-devices">कैमरा चुनें</label>
                <select disabled id="video-devices">
                    <option selected disabled>विकल्प चुनें</option>
                </select>
            </div>
            <div class="column">
                <label for="audio-devices">माइक्रोफ़ोन चुनें</label>
                <select disabled id="audio-devices">
                    <option selected disabled>विकल्प चुनें</option>
                </select>
            </div>

            <div class="column">
                <label for="token">अपना प्रसारण लिंक साझा करें</label>

                <div class="copy-container">
                    <span class="copy-message" id="copy-message">लिंक कॉपी किया गया!</span>
                    <div class="link-box">
                        <input type="text" id="participant-link" value="{{ $fullUrl }}" readonly>
                        <button class="copy-btn" onclick="copyToClipboard()"> 📋 </button>
                    </div>
                </div>
            </div>

            <div class="column" style="display:none;">
                <label for="token">Participant Token</label>
                <input type="text" id="token" name="token" value={{$token}} />
            </div>

            <div class="column" style="display: flex; margin-top: 1.5rem">
                <button class="button" style="margin: auto;" id="join-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-camera-video-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M0 5a2 2 0 0 1 2-2h7.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 4.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 13H2a2 2 0 0 1-2-2z" />
                    </svg>
                    प्रसारण प्रारंभ करें</button>

                <button class="button" style="margin: auto;" id="leave-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                        <path fill-rule="evenodd"
                            d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                    </svg>
                    प्रसारण बंद करो</button>
            </div>
        </div>

        <p class="text-center" id="error-msg">इंटरनेट कनेक्शन टूट गया. पुनः कनेक्ट करने का प्रयास किया जा रहा है...</p>

        <div class="row local-container">
            <div class="w-100 relative">
                <div class="video_wrap">
                    <div id="partcipantCount">
                        <p>लाइव प्रतिभागी: <span id="participant-count">0</span></p>
                    </div>
                    <div class="column" id="local-media"></div>
                </div>

                <!-- <div class="col-md-12 flex"> -->
                <div class="static-controls hidden" id="local-controls">
                    <button class="button" id="mic-control">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-mic-mute-fill" viewBox="0 0 16 16">
                            <path
                                d="M13 8c0 .564-.094 1.107-.266 1.613l-.814-.814A4 4 0 0 0 12 8V7a.5.5 0 0 1 1 0zm-5 4c.818 0 1.578-.245 2.212-.667l.718.719a5 5 0 0 1-2.43.923V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 1 0v1a4 4 0 0 0 4 4m3-9v4.879L5.158 2.037A3.001 3.001 0 0 1 11 3" />
                            <path d="M9.486 10.607 5 6.12V8a3 3 0 0 0 4.486 2.607m-7.84-9.253 12 12 .708-.708-12-12z" />
                        </svg>
                        माइक म्यूट करें</button>
                    <button class="button" id="camera-control">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-camera-video-off-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M10.961 12.365a2 2 0 0 0 .522-1.103l3.11 1.382A1 1 0 0 0 16 11.731V4.269a1 1 0 0 0-1.406-.913l-3.111 1.382A2 2 0 0 0 9.5 3H4.272zm-10.114-9A2 2 0 0 0 0 5v6a2 2 0 0 0 2 2h5.728zm9.746 11.925-10-14 .814-.58 10 14z" />
                        </svg>
                        कैमरा बंद करें</button>
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
    <script src="/js/stages-simple.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function() {
        var stageArn = "{{ $stageArn }}";

        function fetchParticipantCount() {
            $.ajax({
                url: "{{ route('ivs.participants') }}",
                method: "GET",
                data: {
                    stageArn: stageArn
                },
                success: function(response) {
                    if (response.count !== undefined) {
                        var adjustedCount = Math.max(response.count - 1, 0);
                        $("#participant-count").text(adjustedCount);
                    }
                },
                error: function(error) {
                    console.error("Error:", error);
                }
            });
        }

        setInterval(fetchParticipantCount, 5000);
        fetchParticipantCount();
    });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("partcipantCount").style.display = "none";

        const joinButton = document.getElementById("join-button");
        joinButton.addEventListener("click", function() {
            document.getElementById("partcipantCount").style.display = "block";
        });
    });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const localMediaContainer = document.getElementById("local-media");
        const joinButton = document.getElementById("join-button");
        const leaveButton = document.getElementById("leave-button");
        const localControls = document.getElementById("local-controls");
        const micControl = document.getElementById("mic-control");
        const cameraControl = document.getElementById("camera-control");

        let localStream = null;
        let micEnabled = false;
        let cameraEnabled = true;

        if (!localMediaContainer) {
            console.error("local-media container not found!");
            return;
        }

        // Start camera when page loads
        startCamera();

        function startCamera() {
            navigator.mediaDevices
                .getUserMedia({
                    video: true,
                    audio: true
                })
                .then((stream) => {
                    localStream = stream;

                    const videoElement = document.createElement("video");
                    videoElement.srcObject = stream;
                    videoElement.autoplay = true;
                    videoElement.playsInline = true;
                    videoElement.style.width = "100%";

                    localMediaContainer.innerHTML = "";
                    localMediaContainer.appendChild(videoElement);
                })
                .catch((error) => {
                    console.error("Error accessing camera:", error);
                });
        }

        function stopCamera() {
            if (localStream) {
                localStream.getTracks().forEach(track => track.stop()); // Stop all tracks
                localMediaContainer.innerHTML = ""; // Indicate camera is off <p>Camera Stopped</p>
                localStream = null;
            }
        }

        window.addEventListener("offline", () => {
            var errorMsg = document.getElementById("error-msg");
            console.log("Host internet connection lost!");
            errorMsg.style.display = "block";
            // stopCamera();
        });

        // Detect internet connection restore
        window.addEventListener("online", () => {
            var errorMsg = document.getElementById("error-msg");
            errorMsg.style.display = "none";
            // startCamera();
        });


        function showControls() {
            localControls.classList.remove("hidden");
        }

        function hideControls() {
            localControls.classList.add("hidden");
        }

        micControl.addEventListener("click", function() {
            if (localStream) {
                localStream.getAudioTracks().forEach(track => {
                    track.enabled = !track.enabled;
                    micEnabled = track.enabled;
                    micControl.innerHTML = micEnabled ? "माइक म्यूट करें" : "माइक अनम्यूट करें";
                });
            }
        });

        cameraControl.addEventListener("click", function() {
            if (localStream) {
                localStream.getVideoTracks().forEach(track => {
                    track.enabled = !track.enabled;
                    cameraEnabled = track.enabled;
                    cameraControl.innerHTML = cameraEnabled ? "कैमरा बंद करें" :
                        "कैमरा चालू करें";
                });
            }
        });

        joinButton.addEventListener("click", function() {
            stopCamera();
            joinButton.style.display = "none"; // Hide the join button
            leaveButton.style.display = "block"; // Show the leave button
            showControls(); // Show Mic & Camera Controls
        });

        leaveButton.addEventListener("click", function() {
            startCamera();
            joinButton.style.display = "block"; // Show the join button
            leaveButton.style.display = "none"; // Hide the leave button
            hideControls(); // Hide Mic & Camera Controls
        });

        leaveButton.style.display = "none";
        localControls.classList.add("hidden");
    });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const joinButton = document.getElementById("join-button");
        const leaveButton = document.getElementById("leave-button");

        leaveButton.style.display = "none";

        joinButton.addEventListener("click", function() {
            startBroadcast();
            joinButton.style.display = "none";
            leaveButton.style.display = "block";
        });

        leaveButton.addEventListener("click", function() {
            stopBroadcast();
            leaveButton.style.display = "none";
            joinButton.style.display = "block";
        });

        function startBroadcast() {
            console.log("Broadcast started");
        }

        function stopBroadcast() {
            console.log("Broadcast stopped");
        }
    });
    </script>

    <script>
    function copyToClipboard() {
        let inputField = document.getElementById("participant-link");
        navigator.clipboard.writeText(inputField.value).then(() => {
            let copyMessage = document.getElementById("copy-message");
            copyMessage.style.display = "block"; // Show message

            // Hide message after 5 seconds
            setTimeout(() => {
                copyMessage.style.display = "none";
            }, 5000);
        }).catch(err => {
            console.error("Copy failed: ", err);
        });
    }

    // Attach event listener AFTER the function is defined
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("copy-btn").addEventListener("click", copyToClipboard);
    });
    </script>

</body>

</html>