<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Live Stream</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.20.1/video-js.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.20.1/video.min.js"></script>
    <style>
        .video-section {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <video id="ivs-player" controls width="800"></video>

    <script src="https://player.live-video.net/1.22.0/amazon-ivs-player.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (IVSPlayer.isPlayerSupported) {
                const player = IVSPlayer.create();
                const videoElement = document.getElementById("ivs-player");

                <script>
                    var player = videojs('videoPlayer');
                    player.play();
    </script> -->
    <div class="video-section">
        <video id="video" controls autoplay></video>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
                    document.addEventListener("DOMContentLoaded", function () {
            var video = document.getElementById('video');
                    var videoSrc = "{{ $playbackUrl }}";

                    if (Hls.isSupported()) {
                var hls = new Hls();
                    hls.loadSource(videoSrc);
                    hls.attachMedia(video);
                    hls.on(Hls.Events.MANIFEST_PARSED, function () {
                        video.play();
                });
            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                        video.src = videoSrc;
                    video.addEventListener('loadedmetadata', function () {
                        video.play();
                });
            } else {
                        console.error("HLS is not supported in this browser.");
            }
        });
    </script>

</body>


</html>