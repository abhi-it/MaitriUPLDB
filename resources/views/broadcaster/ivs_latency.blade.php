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

  <section class="container" style="display: none;">
    <label for="ingest-endpoint">Ingest Endpoint</label>
    <input type="text" id="ingest-endpoint" value="{{ $ingest_endpoint ?? '' }}" readonly />
  </section>

  <section class="container" style="display: none;">
    <label for="stream-key">Stream Key</label>
    <input type="text" id="stream-key" value="{{ $stream_key }}" />
  </section>

  <!-- Broadcast buttons -->
  <section class="container">
    <button class="button rounded-30 camera-control" id="start" disabled onclick="startBroadcast()">Start
      Broadcast</button>
    <button class="button rounded-30 stop-control" id="stop" disabled onclick="stopBroadcast()">Stop Broadcast</button>
  </section>

  <section class="container">
    <!-- Joining Link (For Broadcaster) -->
    <label for="broadcaster-link">Joining Link</label>
    <div style="display: flex; gap: 10px; align-items: center;">
        <input type="text" id="broadcaster-link" value="{{ $fullUrl ?? '' }}" readonly style="flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        <button onclick="copyToClipboard('broadcaster-link')" style="padding: 8px 12px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Copy
        </button>
    </div>

    <!-- Participant Link (Readonly + Copy) -->
    <label for="participant-link">Participant Link</label>
    <div style="display: flex; gap: 10px; align-items: center;">
        <input type="text" id="participant-link" value="{{ $participantUrl ?? '' }}" readonly style="flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        <button onclick="copyToClipboard('participant-link')" style="padding: 8px 12px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Copy
        </button>
    </div>

    <!-- Rejoin Button (Hidden Initially) -->
    <button id="rejoin-btn" onclick="rejoinStream()" style="display: none; margin-top: 15px; padding: 10px; background-color: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer;">
        Rejoin Broadcast
    </button>
</section>

  <hr />

  <!-- Data table -->
  <section class="container">
    <table id="data">
      <tbody></tbody>
    </table>
  </section>

  <script>
    // Possible configurations
    const channelConfigs = [
      ["Basic: Landscape", window.IVSBroadcastClient.BASIC_LANDSCAPE],
      ["Basic: Portrait", window.IVSBroadcastClient.BASIC_PORTRAIT],
      ["Standard: Landscape", window.IVSBroadcastClient.STANDARD_LANDSCAPE],
      ["Standard: Portrait", window.IVSBroadcastClient.STANDARD_PORTRAIT]
    ];

    // Set initial config for our broadcast
    const config = {
      ingestEndpoint: "https://g.webrtc.live-video.net:4443",
      streamConfig: window.IVSBroadcastClient.BASIC_LANDSCAPE,
      logLevel: window.IVSBroadcastClient.LOG_LEVEL.DEBUG
    };

    // Error helpers
    function clearError() {
      const errorEl = document.getElementById("error");
      errorEl.innerHTML = "";
    }

    function setError(message) {
      if (Array.isArray(message)) {
        message = message.join("<br/>");
      }
      const errorEl = document.getElementById("error");
      errorEl.innerHTML = message;
    }

    function getSupportedProperty(object, key) {
      if (key in object) {
        return object[key];
      }

      return "Unsupported";
    }

    // Get available audio/video inputs
    async function initializeDeviceSelect() {
      const videoSelectEl = document.getElementById("video-devices");

      videoSelectEl.disabled = false;
      const { videoDevices, audioDevices } = await getDevices();
      videoDevices.forEach((device, index) => {
        videoSelectEl.options[index] = new Option(device.label, device.deviceId);
      });

      const audioSelectEl = document.getElementById("audio-devices");

      audioSelectEl.disabled = false;
      audioSelectEl.options[0] = new Option("None", "None");
      audioDevices.forEach((device, index) => {
        audioSelectEl.options[index + 1] = new Option(
          device.label,
          device.deviceId
        );
      });
    }

    async function getCamera(deviceId, maxWidth, maxHeight) {
      let media;
      const videoConstraints = {
        deviceId: deviceId ? { exact: deviceId } : null,
        width: {
          max: maxWidth
        },
        height: {
          max: maxHeight
        }
      };
      try {
        // Let's try with max width and height constraints
        media = await navigator.mediaDevices.getUserMedia({
          video: videoConstraints,
          audio: true
        });
      } catch (e) {
        // and fallback to unconstrained result
        delete videoConstraints.width;
        delete videoConstraints.height;
        media = await navigator.mediaDevices.getUserMedia({
          video: videoConstraints
        });
      }
      return media;
    }

    // Handle video device retrieval
    async function handleVideoDeviceSelect() {
      const id = "camera";
      const videoSelectEl = document.getElementById("video-devices");
      const { videoDevices: devices } = await getDevices();
      if (window.client.getVideoInputDevice(id)) {
        window.client.removeVideoInputDevice(id);
      }

      // Get the option's video
      const selectedDevice = devices.find(
        (device) => device.deviceId === videoSelectEl.value
      );
      const deviceId = selectedDevice ? selectedDevice.deviceId : null;
      const { width, height } = config.streamConfig.maxResolution;
      const cameraStream = await getCamera(deviceId, width, height);

      // Add the camera to the top
      await window.client.addVideoInputDevice(cameraStream, id, {
        index: 0
      });
    }

    // Handle audio/video device enumeration
    async function getDevices() {
      const devices = await navigator.mediaDevices.enumerateDevices();
      const videoDevices = devices.filter((d) => d.kind === "videoinput");
      if (!videoDevices.length) {
        setError("No video devices found.");
      }
      const audioDevices = devices.filter((d) => d.kind === "audioinput");
      if (!audioDevices.length) {
        setError("No audio devices found.");
      }

      return { videoDevices, audioDevices };
    }

    // Handle audio device retrieval
    async function handleAudioDeviceSelect() {
      const id = "microphone";
      const audioSelectEl = document.getElementById("audio-devices");
      const { audioDevices: devices } = await getDevices();
      if (window.client.getAudioInputDevice(id)) {
        window.client.removeAudioInputDevice(id);
      }
      if (audioSelectEl.value.toLowerCase() === "none") return;
      const selectedDevice = devices.find(
        (device) => device.deviceId === audioSelectEl.value
      );
      // Unlike video, for audio we default to "None" instead of the first device
      if (selectedDevice) {
        const microphoneStream = await navigator.mediaDevices.getUserMedia({
          audio: {
            deviceId: selectedDevice.deviceId
          }
        });
        await window.client.addAudioInputDevice(microphoneStream, id);
      }
    }

    // Setup the stream configuration options
    async function initializeStreamConfigSelect() {
      const streamConfigSelectEl = document.getElementById("stream-config");
      streamConfigSelectEl.disabled = false;

      channelConfigs.forEach(([configName], index) => {
        streamConfigSelectEl.options[index] = new Option(configName, index);
      });
    }

    // Handle setting the stream config
    async function handleStreamConfigSelect() {
      const streamConfigSelectEl = document.getElementById("stream-config");
      const selectedConfig = streamConfigSelectEl.value;
      config.streamConfig = channelConfigs[selectedConfig][1];

      await createClient();
    }

    /**
     * Validates the form's input elements. Returns empty array if
     * valid else the list of errors.
     */
    function validate() {
      const streamKey = document.getElementById("stream-key").value;
      const ingestUrl = document.getElementById("ingest-endpoint").value;
      const errors = [];

      if (!ingestUrl) {
        errors.push("Please provide an ingest endpoint");
      }

      if (!streamKey) {
        errors.push("Please provide a stream key");
      }

      return errors;
    }

    async function handleIngestEndpointChange(e) {
      handleValidationErrors(validate());

      try {
        client.config.ingestEndpoint = e.target.value;
      } catch {
        handleValidationErrors(["Incorrect Ingest Url"]);
      }
    }

    function handleStreamKeyChange(e) {
      handleValidationErrors(validate());
    }

    function handleValidationErrors(errors, doNotDisplay) {
      const start = document.getElementById("start");
      const stop = document.getElementById("stop");

      clearError();
      if (errors && errors.length) {
        // Display errors
        if (!doNotDisplay) {
          setError(errors);
        }

        // Disable start and stop buttons
        start.disabled = true;
        stop.disabled = true;
        return;
      }

      start.disabled = false;
    }

    // Start the broadcast
    async function startBroadcast() {
      const streamKeyEl = document.getElementById("stream-key");
      const endpointEl = document.getElementById("ingest-endpoint");
      const start = document.getElementById("start");

      try {
        start.disabled = true;
        await window.client.startBroadcast(streamKeyEl.value, endpointEl.value);
      } catch (err) {
        start.disabled = false;
        setError(err.toString());
      }
    }

    // Stop the broadcast
    async function stopBroadcast() {
      try {
        await window.client.stopBroadcast();
      } catch (err) {
        setError(err.toString());
      }
    }

    // Handle the enabling/disabling of buttons
    function onActiveStateChange(active) {
      const start = document.getElementById("start");
      const stop = document.getElementById("stop");
      const streamConfigSelectEl = document.getElementById("stream-config");
      const inputEl = document.getElementById("stream-key");
      inputEl.disabled = active;
      start.disabled = active;
      stop.disabled = !active;
      streamConfigSelectEl.disabled = active;
    }

    // Helper to create an instance of the AmazonIVSBroadcastClient
    async function createClient() {
      if (window.client) {
        window.client.delete();
      }

      window.client = window.IVSBroadcastClient.create(config);

      window.client.on(
        window.IVSBroadcastClient.BroadcastClientEvents.ACTIVE_STATE_CHANGE,
        (active) => {
          onActiveStateChange(active);
        }
      );

      const previewEl = document.getElementById("preview");
      window.client.attachPreview(previewEl);

      await handleVideoDeviceSelect();
      await handleAudioDeviceSelect();
    }

    // Initialization function
    async function init() {
      try {
        const initBtn = document.getElementById("init");
        const videoSelectEl = document.getElementById("video-devices");
        const audioSelectEl = document.getElementById("audio-devices");
        const streamConfigSelectEl = document.getElementById("stream-config");
        const ingestEndpointInputEl = document.getElementById("ingest-endpoint");
        const streamKeyInputEl = document.getElementById("stream-key");

        await initializeStreamConfigSelect();

        videoSelectEl.addEventListener("change", handleVideoDeviceSelect, true);
        audioSelectEl.addEventListener("change", handleAudioDeviceSelect, true);
        streamConfigSelectEl.addEventListener(
          "change",
          handleStreamConfigSelect,
          true
        );
        ingestEndpointInputEl.addEventListener(
          "input",
          handleIngestEndpointChange,
          true
        );
        streamKeyInputEl.addEventListener("input", handleStreamKeyChange, true);

        // Get initial values from the text fields.  Changes to these will re-create the client.
        const selectedConfig = streamConfigSelectEl.value;
        config.streamConfig = channelConfigs[selectedConfig][1];
        config.ingestEndpoint = ingestEndpointInputEl.value;

        await createClient();

        await initializeDeviceSelect();

        handleValidationErrors(validate(), true);
      } catch (err) {
        setError(err.message);
      }
    }

    init();

</script>

<script>
    function copyToClipboard(elementId) {
        var inputField = document.getElementById(elementId);
        inputField.select();
        inputField.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(inputField.value).then(() => {
            alert("Link copied!");
        }).catch(err => {
            console.error("Copy failed: ", err);
        });
    }

    function checkStreamStatus() {
        setInterval(() => {
            var isDisconnected = Math.random() < 0.2; 
            if (isDisconnected) {
                document.getElementById("rejoin-btn").style.display = "block";
            }
        }, 5000);
    }

    function rejoinStream() {
        location.reload(); 
    }

    checkStreamStatus(); 
</script>


<script>
    function copyToClipboard() {
        var inputField = document.getElementById("ingest-endpoint");
        inputField.select();
        inputField.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(inputField.value).then(() => {
            alert("Link copied to clipboard!");
        }).catch(err => {
            console.error("Failed to copy: ", err);
        });
    }
</script>
</body>

</html>