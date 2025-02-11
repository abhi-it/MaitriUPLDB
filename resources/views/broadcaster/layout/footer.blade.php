<footer class="position-relative">
    @if (Route::has('login'))
    @auth
    @else
    <div class="footer_parent">
        <div class="row g-3 footer_top_footer__u_0LC">
            <div class="col-lg-4">
                <h5><i class="fa fa-map-marker"></i>
                    <span data-hi="हेड ऑफिस" data-en="Head Office"></span>
                </h5>
                <p>
                    <span data-hi="गोकरन नाथ रोड, बादशाहबाग, लखनऊ 226007"
                        data-en="Gokaran Nath Road, Badshahbagh, Lucknow 226007"></span>
                </p>
                <h5><i class="fa fa-envelope"></i>
                    <span data-hi="ईमेल करें" data-en="Email Us"></span>
                </h5>
                <p class="mb-0">
                    <span data-hi="मैत्री सेल" data-en=" MAITRI Cell"></span>
                    - upldbte@gmail.com
                </p>
                <p class="mb-0">
                    <span data-hi="शिकायत सेल" data-en="Grievance Cell"></span>
                    - upldbmaitri@gmail.com
                </p>
                <p class="mb-0">
                    <span data-hi="बीमा" data-en="Insurance"></span>
                    - pashubeemaupldb@gmail.com
                </p>
                <p class="mb-0">
                    <span data-hi="सेक्स्ड सीमेन" data-en="Sexed Semen"></span>
                    - upldbss@gmail.com
                </p>
            </div>
            <div class="col-lg-4">
                <h5><i class="fa fa-phone"></i>
                    <span data-hi="कॉल करें" data-en="Call Us"></span>
                </h5>
                <p class="mb-0">
                    <span data-hi="लैंडलाइन नंबर" data-en="Landline Number"></span>
                    - +91-522-2977709
                </p>
                <p class="mb-0">
                    <span data-hi="बीमा" data-en="Insurance"></span>
                    - +91 - 9335116448
                </p>
                <p class="mb-0">
                    <span data-hi="मैत्री" data-en="MAITRI"></span>
                    - +91 - 9125904205
                </p>
                <p class="mb-0 mt-2 fw-semibold">
                    <span data-hi="उत्तर प्रदेश पशुधन विकास बोर्ड"
                        data-en="Uttar Pradesh Livestock Development Board"></span>
                </p>
            </div>
            <div class="col-lg-4">
                <div class="d-flex flex-column justiry-content-center align-items-center w-100">
                    <h5>
                        <span data-hi="ऐप डाउनलोड करें" data-en="Download App"></span>
                    </h5>
                    <a href="#"><img src="https://upldb.vercel.app/assets/images/site/pashudhan_app1.png" width="120px"
                            alt=""></a>
                </div>
            </div>
        </div>
        <div class="row align-items-top gap-5 px-2 mx-0 pt-4 pb-3 footer_footer__O">
            <div class="col-lg-3 align-items-top text-center">
                <img src="https://maitriupldb.in/assets/images/upldb-logo.png" alt="" width="150">
                <span style="line-height:25px;display:block" class="mb-0 mt-3 text-white">
                    <span data-hi="उन्नत संतति हेतु संकल्पबद्ध" data-en="Committed to a better future"></span>

                </span>
                <div class="social-links d-flex justify-content-center gap-3 mt-lg-3  mt-md-4 mt-3 ">

                    <a href="https://x.com/i/flow/login?redirect_after_login=%2Fupldblko" target="_blank">
                        <span> <i class="ri-twitter-x-line ri-lg"></i></span>
                    </a>
                    <a target="_blank"
                        href="https://www.facebook.com/people/Uttar-Pradesh-Livestock-Development-Board/61554910544850/">
                        <span> <i class="ri-facebook-circle-line ri-lg"></i></span>
                    </a>

                    <a href="https://www.linkedin.com/company/uttar-pradesh-livestock-development-board"
                        target="_blank">
                        <span><i class="ri-linkedin-line ri-lg"></i></span>
                    </a>
                    <a href="https://www.youtube.com/@uplivestockdevelopmentboard" target="_blank">
                        <span><i class="ri-youtube-line ri-lg"></i> </span>
                    </a>

                    </a>
                </div>
            </div>
            <div class="col-lg-2">
                <h5 class="footer--heading">
                    <span data-hi="महत्वपूर्ण लिंक" data-en="Important Links"></span>
                </h5>
                <ul class="footer--list">
                    <li>
                        <a href="{{ url('/') }}" key="HOME">
                            <span data-hi="मुख्य पृष्ठ" data-en="Main Page"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('avedan-karein') }}">
                            <span data-hi="आवेदन" data-en="Applications"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('lakshya') }}">
                            <span data-hi="स्वरोजगारी मैत्री (पशु मित्र) की संख्या"
                                data-en="Number of Swarozgari Maitri (Animal Friends)"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('application-status') }}">
                            <span data-hi="आवेदन की स्थिति जानिए" data-en="Know the status of your application"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('downloads') }}">
                            <span data-hi="डाउनलोड" data-en="Download"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('demandRequests') }}">
                            <span data-hi="मांग अनुरोध" data-en="Demand Requests"></span>
                        </a>
                    </li>
                </ul>



            </div>
            <div class="col-lg-2">
                <h5 class="footer--heading">
                    <span data-hi="त्वरित लिंक" data-en="Quick Links"></span>
                </h5>
                <ul class="footer--list">
                    <!-- <li>
                        <a href="{{ url('maitri-register') }}">
                            <span data-hi="मैत्री (पशु मित्र) पंजीकरण" data-en="Maitri Registration"></span>
                    </a>
                    </li> -->
                    <li>
                        <a href="{{ url('farmer-register') }}">
                            <span data-hi="पशुपालक पंजीकरण" data-en="Livestock Registration"></span>
                        </a>
                    </li>

                </ul>
            </div>
            <div class="col-lg-2">
                <h5 class="footer--heading">
                    <span data-hi="संपर्क करें" data-en="Contact Us"></span>
                </h5>
                <ul class="list-unstyled">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3559.08297384528!2d80.935781475438!3d26.86910477667314!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399bfd9c9604bea9%3A0x88634ee93200bb69!2sVETERINARY%20POLYCLINIC%20BADSHAH%20BAGH%2C%20LUCKNOW!5e0!3m2!1sen!2sin!4v1705036303907!5m2!1sen!2sin"
                        width="100%" height="200"></iframe>
                </ul>
            </div>
        </div>
    </div>
    @endauth
    @endif
    <div class="copy-right py-2 text-center copyright-text footer-counter">
        <a href='https://www.free-counters.org/'>www.free-Counter.org</a>
        <script type='text/javascript'
            src='https://www.freevisitorcounters.com/auth.php?id=b02bbc85a30c7c9a99711a8a93df17b315b95524'></script>
        <script type="text/javascript" src="https://www.freevisitorcounters.com/en/home/counter/1223947/t/5">
        </script>

        <p class="text-center m-0"><?php echo date('Y'); ?>-<?php echo date('Y', strtotime('+1 year')); ?> ©
            <span data-hi="राष्ट्रीय गोकुल मिशन सर्वाधिकार सुरक्षित"
                data-en="Rashtriya Gokul Mission All rights reserved"></span>
        </p>
    </div>
</footer>
<button class="common_top_scroll__cuiN4 top-btn">
    <i class="fa fa-arrow-up" aria-hidden="true"></i>
</button>

<script>
let topBtn = document.querySelector(".top-btn");

topBtn.onclick = () => window.scrollTo({
    top: 0,
    behavior: "smooth"
});

window.onscroll = () => topBtn.style.opacity = window.scrollY > 500 ? 1 : 0;

var defaultlang = "hi";
var ls = localStorage.getItem("selectedProject");
if (ls) {
    $(".switchlang").val(ls).change();
    switchLang(ls);
} else {
    switchLang(defaultlang);
}

function switchLang(lang) {
    document.body.classList.remove("trans_english");
    if (lang === 'en') {
        document.body.classList.add("trans_english");
    }
    $("[data-" + lang + "]").text(function(i, e) {
        return $(this).data(lang);
    });

    $("select").each(function() {
        $(this).find("option").each(function() {
            var value = $(this).data(lang);
            if (value !== undefined) {
                $(this).text(value);
            }
        });
    });
    $("[data-placeholder-" + lang + "]").each(function() {
        var placeholder = $(this).data("placeholder-" + lang);
        if (placeholder !== undefined) {
            $(this).attr("placeholder", placeholder);
        }
    });
}
// function switchLang(lang){
//     document.body.classList.remove("trans_english");
//     if(lang=='en'){
//         document.body.classList.add("trans_english");
//     }
//     $("[data-" + lang + "]").text(function(i, e) {

//         return $(this).data(lang);
//     });
// }
$('.switchlang').change(function() {
    var lang = $(".switchlang option:selected").val();
    localStorage.setItem("selectedProject", lang);
    switchLang(lang)
});

function loadlang() {
    var lng = document.getElementById("langselector").value;
    var cnt = document.getElementById("contents");
    switch (lng) {
        case "en":
            cnt.src = "https://jsfiddle.net/q2nw8o35/";
            break;
        case "hi":
            cnt.src = "https://jsfiddle.net/jmn8c9tj/";
            break;
    }
}
</script>
<div class="modal fade" id="myModel" tabindex="-1" role="dialog" aria-labelledby="myModel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <span data-hi="अभ्यर्थी का स्वत: मूल्यांकन" data-en="Self-Evaluation of the Candidate"></span>
                </h5>
                <button type="button" class="close " onclick="closemodal()" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="responseID">
                    <div class="spinner-border"></div>
                </span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closemodal()"
                    data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@stack('body-scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
var url = "{{ route('changeLang') }}";
$(".changeLang").change(function() {
    window.location.href = url + "?lang=" + $(this).val();
});
</script>

<script src="/js/helpers.js"></script>
<script src="/js/media-devices.js"></script>
<script src="/js/stages-simpel.js"></script>
</body>

</html>