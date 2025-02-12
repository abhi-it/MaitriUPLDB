<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AWS IVS Player</title>
    <script src="https://player.live-video.net/1.20.0/amazon-ivs-player.min.js"></script>
</head>
<body>
<video id="ivs-player" controls width="800"></video>

<script src="https://player.live-video.net/1.22.0/amazon-ivs-player.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (IVSPlayer.isPlayerSupported) {
            const player = IVSPlayer.create();
            const videoElement = document.getElementById("ivs-player");

            player.attachHTMLVideoElement(videoElement);
            player.load("{{ $playbackUrl }}");
            player.play();

            player.addEventListener(IVSPlayer.PlayerEventType.ERROR, (err) => {
                console.error("IVS Player Error:", err);
                alert("Playback error: " + err.message);
            });

        } else {
            alert("IVS Player is not supported in this browser.");
        }
    });
</script>

</body>
</html>