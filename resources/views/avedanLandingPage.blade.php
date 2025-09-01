@extends('master')
@section('content')
<style>
:root {
--brand-bg: #0b3d91; /* Deep blue */
--brand-accent: #fdd835; /* Amber */
--brand-text: #ffffff;
--glow: #ea7328; /* Neon green */
}


/* body { margin: 0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji"; } */


/* === Marquee Bar === */
.marquee-bar {
position: relative;
width: 100%;
background: linear-gradient(90deg, #a6dafa, #a6dafa 65%);
color: var(--brand-text);
overflow: hidden;
border-bottom: 2px solid rgba(255,255,255,.2);
}


.marquee-track {
display: inline-flex;
align-items: center;
gap: 2rem;
white-space: nowrap;
padding: .6rem 1rem;
/* Scrolling animation */
animation: marquee-scroll 22s linear infinite;
}


@keyframes marquee-scroll {
from { transform: translateX(0); }
to { transform: translateX(-50%); }
}


.pill {
display: inline-flex;
align-items: center;
gap: .5rem;
background: rgba(255,255,255,.08);
border: 1px solid rgba(255,255,255,.15);
padding: .35rem .8rem;
border-radius: 999px;
font-weight: 600;
letter-spacing: .2px;
color: #000;
}


.dot { width: .5rem; height: .5rem; border-radius: 50%; background: var(--glow); box-shadow: 0 0 0 .15rem rgba(253,216,53,.25); }


.countdown { font-variant-numeric: tabular-nums; }


/* Duplicate the track content to create an infinite loop illusion */
.marquee-content { display: inline-flex; align-items: center; gap: 2rem; padding-right: 2rem; }


/* === Applicants Glowsign === */
.glow-wrap { width: 100%; display: flex; justify-content: center; background: #ffffffff; padding: 14px 10px; }


.glow-sign {
display: inline-flex;
align-items: baseline;
gap: .6rem;
font-weight: 800;
text-transform: uppercase;
letter-spacing: .8px;
color: var(--glow);
text-shadow:
0 0 6px var(--glow),
0 0 12px var(--glow),
0 0 20px rgb(234 115 40 / 60%), 
0 0 36px rgb(234 115 40 / 41%);
animation: glow-pulse 2.2s ease-in-out infinite;
}


</style>

@php
     $deadline = \Carbon\Carbon::parse($result->end_date)->endOfDay()->format('Y-m-d\TH:i:sP');  
@endphp
<!-- Maquee Code Start -->
<div id="maitri-marquee" class="marquee-bar" aria-live="polite" data-deadline="{{ $deadline }}" data-applicants="{{ $totalAvedan }}">
   <div class="marquee-track">
      <div class="marquee-content">
         <span class="pill">
            <span class="dot" ></span> 
            <span aria-hidden="true" data-hi="आवेदन बंद होने वाले हैं:" data-en="Applications Closing In:"></span>
            <span class="countdown" id="countdown-a"></span>
         </span>
         <span class="pill" data-hi="अपना अवेदान आज ही यहां जमा करें maitriupldb.in" data-en="Submit your Avedan today at maitriupldb.in"></span>
         <span class="pill" data-hi="आखिरी दिन तक इंतजार मत करे!" data-en="Don’t wait till the last day!"></span>
      </div>
      <div class="marquee-content" aria-hidden="true">
         <span class="pill">
            <span class="dot" ></span> 
            <span aria-hidden="true" data-hi="आवेदन बंद होने वाले हैं:" data-en="Applications Closing In:"></span>
            <span class="countdown" id="countdown-b"></span>
         </span>
         <span class="pill" data-hi="अपना अवेदान आज ही यहां जमा करें maitriupldb.in" data-en="Submit your Avedan today at maitriupldb.in"></span>
         <span class="pill" data-hi="आखिरी दिन तक इंतजार मत करे!" data-en="Don’t wait till the last day!"></span>
      </div>
   </div>
</div>


<div class="glow-wrap">
   <div class="glow-sign" role="status" aria-live="polite">
      <span class="label" data-hi="आवेदकों की संख्या" data-en="Number of Applicants:"> </span>
      <span class="glow-number" id="applicants-count">0</span>
   </div>
</div>
<!-- Maquee Code End -->
<div class="container main-div py-5" >
    <!--First row Start -->
    <h3 class="text-center fw-bold m-4">
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
            : </label>   {{\Carbon\Carbon::parse($result->start_date)->format('d/m/Y')}}
        </div>
        <div class="col-12 col-md-12">
           <label for="inputPassword4" style="font-weight:bold;">
           <span data-hi="आवेदन करने की अंतिम तिथि" data-en="Last date for application">
            : </label> {{\Carbon\Carbon::parse($result->end_date)->format('d/m/Y')}}
        </div>
        
        <div class="col-12 col-md-12"><!--{{url('application-form')}}-->
           <label for="inputPassword4" style="font-weight:bold;">
			   @if($avedanStart)
			   <a class="nav-link" href="{{url('application-form')}}">
               <h3><span data-hi="आवेदन करने के लिए यहाँ क्लिक करें" data-en="Click here to apply"></h3>
            </a>
			   @else
						@if($messsage !='')
						<h3 style="color:red; 222" data-hi="आवेदन जमा करने की समय सीमा समाप्त हो गई है" data-en="{{$messsage}}"></h3>
						@else
                     <h3 style="color:red; 1111" >
                     <span data-hi="आवेदन" data-en="Application">   
                     {{\Carbon\Carbon::parse($result->start_date)->format('d/m/Y')}}
                     <span data-hi="से प्रारम्भ होंगे |"  data-en="will start from.">   
                     </h3>
						@endif
				@endif
			   
			   </label>
        </div>
    </div>
  </div> 
        
        
        <!------Summary Page End---------------->
     
        

</div>

<script>
(function () {
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
function setApplicants(n) {
const num = Number(n) || 0;
countEl.textContent = num.toLocaleString('en-IN');
}
if (countEl) setApplicants(applicantsInitial);


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
