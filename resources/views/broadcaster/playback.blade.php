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
    <script>
        if (IVSPlayer.isPlayerSupported) {
            const player = IVSPlayer.create();
            player.attachHTMLVideoElement(document.getElementById("ivs-player"));
            player.load( "{{ $playbackUrl }}" );
            player.play();
        } else {
            alert("IVS Player is not supported in this browser.");
        }
    </script>
</body>
</html>