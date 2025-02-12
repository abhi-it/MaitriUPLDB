<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Broadcast To IVS</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css" />
  <script src="https://web-broadcast.live-video.net/1.20.0/amazon-ivs-web-broadcast.js"></script>

  <style>
    html,
    body {
      width: 100%;
    }

    #error {
      color: red;
    }

    table {
      display: table;
    }

    #preview {
      margin-bottom: 1.5rem;
      background: green;
      width: 100%;
      height: 300;
    }

    .title {
      font-size: 22px;
      color: #000;
      margin-top: 20px;
      font-weight: bold;
      letter-spacing: 0;
    }

    .button.rounded-30 {
      border-radius: 30px !important;
    }

    .camera-control {
      background: #ea7427;
      border: 1px solid #000;
    }

    .stop-control {
      background: #ff2323;
      border: 1px solid #000;
    }
  </style>
</head>

<body>
  <header class="container">
    <h1 class="title">Start Live Streaming</h1>
    <p>
    </p>
  </header>

  <hr />

  <section class="container">
    <h3 id="error"></h3>
  </section>

  <section class="container">
    <canvas id="preview"></canvas>
  </section>

  <section class="container">
    <label for="video-devices">Select Webcam</label>
    <select disabled id="video-devices">
      <option selected disabled>Choose Option</option>
    </select>

    <label for="audio-devices">Select Microphone</label>
    <select disabled id="audio-devices">
      <option selected disabled>Choose Option</option>
    </select>

    <label for="stream-config">Select Channel Config</label>
    <select disabled id="stream-config">
      <option selected disabled>Choose Option</option>
    </select>
  </section>

  <section class="container" style="display:none">
    <label for="ingest-endpoint">Ingest Endpoint</label>
    <input type="text" id="ingest-endpoint" value="{{ $ingest_endpoint }}" />
  </section>

  <section class="container" style="display:none">
    <label for="stream-key">Stream Key</label>
    <input type="text" id="stream-key" value="{{ $stream_key }}" />
  </section>

  <!-- Broadcast buttons -->
  <section class="container">
    <button class="button rounded-30 camera-control" id="start" disabled onclick="startBroadcast()">Start
      Broadcast</button>
    <button class="button rounded-30 stop-control" id="stop" disabled onclick="stopBroadcast()">Stop Broadcast</button>
  </section>

  <hr />

  <!-- Data table -->
  <section class="container">
    <table id="data">
      <tbody></tbody>
    </table>
  </section>
</body>

</html>