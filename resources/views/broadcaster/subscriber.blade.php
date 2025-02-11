<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css" />
  <title>IVS Real-Time Streaming - Basic Sample</title>
  <script src="https://web-broadcast.live-video.net/1.20.0/amazon-ivs-web-broadcast.js"></script>

  <style>
        html,
          body {
          }

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

          .columns{
            justify-content: space-between;
            width: 100%;
            display: flex;
            /* align-items: center; */
            gap: 20px;
          }
          .text-center{
            text-align:center;
          }
          hr{
            margin:2rem 0;
          }
  </style>
</head>

<body>
  <div class="container">
  <h1 class="text-center">IVS Real-Time Streaming</h1>
  <hr />
  <center> <button class="button" id="join-button">Join</button> </center>

  <!-- Setup Controls -->
  <div class="row">
    <div class="columns">
      <label for="token" style="display: none;">Token</label>
      <input type="text" id="token" name="token" value={{$stageArn}} style="display: none;" />
      <!-- <button class="button" id="join-button">Join</button> -->
      <button class="button" id="leave-button" style="display: none;">Leave</button>
      </div>

  </div>
  <hr />

  <!-- Local Participant -->
  <div class="local-container">
    <div id="local-media"></div>
  </div>

  <!-- Remote Participants -->
  <div>
    <div id="remote-media"></div>
  </div>
  </div>
  <script src="/js/subscriber.js"></script>
</body>

</html>