@extends('master')
@section('content')
<style>
:root {
    --brand-bg: #0b3d91;
    /* Deep blue */
    --brand-accent: #fdd835;
    /* Amber */
    --brand-text: #ffffff;
    --glow: #ea7328;
    /* Neon green */
}


/* body { margin: 0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji"; } */


/* === Marquee Bar === */
.marquee-bar {
    position: relative;
    width: 100%;
    background: linear-gradient(90deg, #a6dafa, #a6dafa 65%);
    color: var(--brand-text);
    overflow: hidden;
    border-bottom: 2px solid rgba(255, 255, 255, .2);
}


.marquee-track {
    display: inline-flex;
    align-items: center;
    gap: 2rem;
    white-space: nowrap;
    padding: .6rem 1rem;
    /* Scrolling animation */
    /* animation: marquee-scroll 22s linear infinite; */
    animation: marquee-scroll 8s linear infinite;
}


@keyframes marquee-scroll {
    from {
        transform: translateX(0);
    }

    to {
        transform: translateX(-50%);
    }

    /* to { transform: translateX(-100%); } */
}


.pill {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: rgba(255, 255, 255, .08);
    border: 1px solid rgba(255, 255, 255, .15);
    padding: .35rem .8rem;
    border-radius: 999px;
    font-weight: 600;
    letter-spacing: .2px;
    color: #000;
}

.pill .img-container {
    width: 30px;
    height: 30px;
    display: block;
}

.pill img {
    width: 30px;
    scale: 1;
    animation: scales 1s linear infinite;
}

@keyframes scales {
    to {
        scale: 0.8
    }

    from {
        /* opacity: 1; */
        scale: 1
    }
}

.dot {
    width: .5rem;
    height: .5rem;
    border-radius: 50%;
    background: var(--glow);
    box-shadow: 0 0 0 .15rem rgba(253, 216, 53, .25);
}


.countdown {
    font-variant-numeric: tabular-nums;
}


/* Duplicate the track content to create an infinite loop illusion */
.marquee-content {
    display: inline-flex;
    align-items: center;
    gap: 2rem;
    padding-right: 2rem;
}


/* === Applicants Glowsign === */
.glow-wrap {
    width: 100%;
    display: flex;
    justify-content: center;
    background: #ffffffff;
    padding: 14px 10px;
}


.glow-sign {
    display: inline-flex;
    align-items: baseline;
    gap: .6rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .8px;
    color: var(--glow);
    text-shadow:
        0 0 0px var(--glow),
        0 0 1px var(--glow),
        0 0 20px rgb(234 115 40 / 60%),
        0 0 36px rgb(234 115 40 / 41%);
    animation: glow-pulse 2.2s ease-in-out infinite;
}

.main-div {
    position: relative;
}

.star-cards {
    clip-path: polygon(50% 0%, 71% 23%, 98% 35%, 84% 61%, 79% 91%, 50% 83%, 21% 91%, 16% 60%, 2% 35%, 29% 23%);
    background: #ea7327;
    height: 300px;
    width: 300px;
    padding: 5rem;
    text-align: center;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    color: #fff;
    font-size: 15px;
    animation: scales 1s linear infinite;
}

.star-cards.star-card-left {
    position: absolute;
    left: 0;
    animation: scales1 1s linear infinite;
}

@keyframes scales1 {
    100% {
        scale: 0.8;
    }

    0% {
        /* opacity: 1; */
        scale: 1;
    }
}

.star-cards.star-card-right {
    position: absolute;
    right: 0;
    animation: scales2 1s linear infinite;
}

@keyframes scales2 {
    0% {
        scale: 0.8;
    }

    100% {
        /* opacity: 1; */
        scale: 1;
    }
}

.star-card-center {
    display: flex;
    justify-content: center;
    align-items: center;
}

.star-card-center .title {
    font-size: 1.5rem;
    font-weight:600;
}

.star-card-center .subtitle {
    font-size: 1rem;
}

.box-card {
    height: 400px;
    width: 400px;
}


.glow-badge__pill {

    background-color: #18191f;
    color: #fff;
    /* box-shadow: 2px 2px 2px #00000080, 10px 1px 12px #00000080,
    2px 2px 10px #00000080, 2px 2px 3px #00000080, inset 2px 2px 10px #00000080,
    inset 2px 2px 10px #00000080, inset 2px 2px 10px #00000080,
    inset 2px 2px 10px #00000080; */
    border-radius: 29px;
    padding: 1px 8px;
    margin: 0 0px;
    animation: animate 3s linear infinite;
    text-shadow: 0 0 50px #0072ff, 0 0 100px #0072ff, 0 0 150px #0072ff,
        0 0 200px #0072ff;
    font-size: 11px;
}

.glow_badge__pill {
    animation-delay: 0.1s;
}

@keyframes animate {
    0% {
        background-color: #000000;
    }

    25% {
        background-color: #ff0000;
    }

    50% {
        background-color: #0400ff;
    }

    75% {
        background-color: #004d11;
    }

    100% {
        background-color: #57009eff;
    }
}

@media screen and (max-width: 768px) {
    .box-card {
        height: 250px;
        width: 250px;
    }

    .star-card-center .title {
         font-size: 14px;
         line-height: 1rem;
    }

    .star-card-center .subtitle {
        font-size: 12px;
    }

    .star-cards {
        height: 200px;
        width: 200px;
        padding: 3rem;
        font-size: 12px;
    }
    .main-div .maitri-content {
      padding-top: 200px;
    }
}
</style>

@php
$deadline = \Carbon\Carbon::parse($result->end_date)->endOfDay()->format('Y-m-d\TH:i:sP');
@endphp
<!-- Maquee Code Start -->
<div id="maitri-marquee" class="marquee-bar" aria-live="polite" data-deadline="{{ $deadline }}"
    data-applicants="{{ $totalAvedan }}">
    <div class="marquee-track">
        <div class="marquee-content">

            <span class="pill">
                <span class="dot"></span>
                <span aria-hidden="true" data-hi="मैत्री हेतु स्वयं अवेदन करे"
                    data-en="Apply yourself for Maitri"></span>
            </span>

            <!-- <span class="pill" >
            <span class="img-contaner">
            <img src="{{ asset('images/start_image.png') }}" alt="">
            </span>
            <span aria-hidden="true" data-hi="मैत्री आवेदन के लिए केवल:" data-en="Only for Maitri Application:"></span>
           
             <span class="img-contaner">
            <span data-hi="दिन शेष हैं" data-en="days left"></span>
            <img src="{{ asset('images/start_image.png') }}" alt="">
         </span> -->
            <span class="pill">
                <span class="dot"></span>
                <span aria-hidden="true" data-hi="मैत्री हेतु स्वयं आवेदन करे"
                    data-en="Apply yourself for Maitri"></span>
            </span>
        </div>
        <div class="marquee-content" aria-hidden="true">
            <span class="pill">
                <span class="dot"></span>
                <span aria-hidden="true" data-hi="मैत्री हेतु स्वयं आवेदन करे"
                    data-en="Apply yourself for Maitri"></span>
            </span>
            <span class="pill">
                <span class="dot"></span>
                <span aria-hidden="true" data-hi="मैत्री हेतु स्वयं आवेदन करे"
                    data-en="Apply yourself for Maitri"></span>
            </span>

            <!-- <span class="pill" >
            <span class="img-contaner">
            <img src="{{ asset('images/start_image.png') }}" alt="">
            </span>
            <span aria-hidden="true" data-hi="मैत्री आवेदन के लिए केवल:" data-en="Only for Maitri Application:"></span>
            
             <span class="img-contaner">
            <span data-hi="दिन शेष हैं" data-en="days left"></span>
            <img src="{{ asset('images/start_image.png') }}" alt="">
         </span>
         </span> -->
        </div>
    </div>
</div>


<!-- <div class="glow-wrap">
   <div class="glow-sign" role="status" aria-live="polite">
      <span class="label" data-hi="आवेदकों की संख्या" data-en="Number of Applicants:"> </span>
      <span class="glow-number" id="applicants-count">0</span>
   </div>
</div> -->
<div class="star-card-center">
    <div class="star-cards box-card">
        <!-- <span class="label" data-hi="आवेदकों की संख्या" data-en="Number of Applicants:"> </span>
      <span class="glow-number" id="applicants-count">0</span> -->
        <span data-hi="न्यूनतम शैक्षिक योग्यता" data-en="Minimum educational qualification" class="subtitle"></span>
        <span data-hi="इंटरमीडिएट उत्तीर्ण" data-en="Passed Intermediate" class="title"></span>
        <small data-hi="जीव विज्ञान अनिवार्य" data-en="Biology (Compulsory)"></small>

    </div>
</div>
<!-- Maquee Code End -->
<div class="container main-div py-md-5">
    <div class="star-cards star-card-left">
        <span data-hi="मैत्री आवेदन के लिए केवल:" data-en="For Maitri Application Only"></span>
        <span class="countdown" id="countdown-a"></span>
        <span data-hi="दिन शेष हैं" data-en="days left"></span>

    </div>
    <div class="star-cards star-card-right">
        <span data-hi="अब तक कुल आवेदन:" data-en="Total applications:"></span> <span class="glow-number"
            id="applicants-count">0</span>
    </div>
    <!--First row Start -->
    <div class="maitri-content">
      <h3 class="text-center fw-bold m-4 ">
         <span data-hi="आवेदन - पत्र" data-en="Application letter"></span>
      </h3>
      @if(session()->get('success'))
      <div class="alert alert-success">
         {{ session()->get('success') }}
      </div>
      @endif

      <!------Summary Page Start---------------->


      <div class="col-12 p-4 text-center">
         <div class="row">
               <div class="col-12 col-md-12">
                  <label for="inputPassword4" style="font-weight:bold;">
                     <span data-hi="आवेदन करने की प्रारंभ तिथि" data-en="Start date for application">
                           : </label> {{\Carbon\Carbon::parse($result->start_date)->format('d/m/Y')}}
               </div>
               <div class="col-12 col-md-12">
                  <span class="glow-badge p-0">
                     <span class="glow-badge__pill glowing" role="status" aria-label="New content" data-hi="अब"
                           data-en="Now"></span>
                  </span>
                  <label for="inputPassword4" style="font-weight:bold;">
                     <span data-hi="आवेदन करने की अंतिम तिथि" data-en="Last date for application">
                           : </label> {{\Carbon\Carbon::parse($result->end_date)->format('d/m/Y')}}
               </div>

               <div class="col-12 col-md-12">
                  <label for="inputPassword4" style="font-weight:bold;">

                     @if($avedanStart)
                        <a class="nav-link" href="{{ url('application-form') }}">
                            <h3>
                                <button class="btn btn-primary"><span data-hi="{{ $himesssage }}"
                                        data-en="{{ $messsage }}"></span></button>
                            </h3>
                        </a>
                     @else
                        <h3 style="color:red;">
                            <span data-hi="{{ $himesssage }}" data-en="{{ $messsage }}"></span>
                        </h3>
                     @endif
                  </label>
               </div>
         </div>
      </div>

   </div>
    <!------Summary Page End---------------->



</div>

<script>
(function() {
    const root = document.getElementById('maitri-marquee');
    const deadlineStr = root?.getAttribute('data-deadline');
    const applicantsInitial = root?.getAttribute('data-applicants');


    // --- Countdown logic ---
    const deadline = deadlineStr ? new Date(deadlineStr) : null;
    const outA = document.getElementById('countdown-a');
    const outB = document.getElementById('countdown-b');


    function formatDDHHMMSS(ms) {
        if (ms <= 0) return '00d : 00h : 00m : 00s';
        const sec = Math.floor(ms / 1000);
        const days = Math.floor(sec / 86400);
        const hours = Math.floor((sec % 86400) / 3600);
        const minutes = Math.floor((sec % 3600) / 60);
        const seconds = sec % 60;
        const pad = n => String(n).padStart(2, '0');
        return `${days}d : ${pad(hours)}h : ${pad(minutes)}m : ${pad(seconds)}s`;
    }


    function tick() {
        const now = new Date();
        const diff = deadline ? (deadline.getTime() - now.getTime()) : 0;
        const txt = formatDDHHMMSS(diff);
        if (outA) outA.textContent = txt;
        if (outB) outB.textContent = txt;
        if (diff <= 0) clearInterval(timer);
    }


    const timer = setInterval(tick, 1000);
    tick();


    // --- Applicants number (manual or programmatic) ---
    const countEl = document.getElementById('applicants-count');
    const countNew = document.getElementById('applicants-count-new');

    function setApplicants(n) {
        const num = Number(n) || 0;
        countEl.textContent = num.toLocaleString('en-IN');
        countNew.textContent = num.toLocaleString('en-IN');
    }
    if (countEl) setApplicants(applicantsInitial);
    if (countNew) setApplicants(applicantsInitial);


    // OPTIONAL: If you have a global number or endpoint, you can update dynamically.
    // Example 1: update via global JS value set elsewhere: window.MAITRI_APPLICANTS_COUNT
    if (typeof window.MAITRI_APPLICANTS_COUNT !== 'undefined') {
        setApplicants(window.MAITRI_APPLICANTS_COUNT);
    }


    // Example 2: fetch from an API endpoint that returns { count: 12345 }
    // Uncomment and set the correct URL:
    // fetch('/api/applicants-count')
    // .then(r => r.json())
    // .then(data => setApplicants(data.count))
    // .catch(() => {});
})();
</script>

@endsection