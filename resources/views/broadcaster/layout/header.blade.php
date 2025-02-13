<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="csrf-token">
    <title> राष्ट्रीय गोकुल मिशन</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('assets') }}/favicon.ico">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" />
    <!-- <link href="{{ asset('') }}css/custom.css" rel="stylesheet" type="text/css"> -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{ asset('js/jquery-3.6.min.js') }}"></script>
    <script src="{{ asset('js/font-size.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bgcolor.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/account.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/additional-methods.min.js?ver=1.0') }}" type="text/javascript"></script>
    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('AIzaSyABHXJPN6L8-6nqf4uUekwdoQBPeHLYe60') }}&callback=initMap">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.5.1/axios.min.js"
        integrity="sha512-emSwuKiMyYedRwflbZB2ghzX8Cw8fmNVgZ6yQNNXXagFzFOaQmbvQ1vmDkddHjm5AITcBIZfC7k4ShQSjgPAmQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </nav>

    <!--Data Table---->

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

    <!-- New Export Data CDN Start -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.3.3/css/buttons.dataTables.min.css" />
    <!-- New Export Data CDN Start -->

    <link href="{{ asset('') }}css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="{{ asset('') }}js/jquery.dataTables.min.js" type="text/javascript"></script>

    <link href="{{ asset('') }}css/jquery-ui.css" rel="stylesheet" type="text/css">
    <script src="{{ asset('') }}js/jquery-ui.js" type="text/javascript"></script>
    <style>
    /* ---f--- */
    .footer_parent {
        background-color: #f93;
        color: #000;
        padding-top: 7rem;
        margin-top: 9rem
    }

    .footer_top_footer__u_0LC {
        background: #a6dafa;
        color: #000;
        width: 80%;
        padding: 1rem 2rem;
        border-radius: 1rem;
        box-shadow: 2px 2px 5px 0 #2b2b2b;
        margin: -220px auto 0;
    }

    @media (max-width: 768px) {
        .footer_top_footer__u_0LC {
            padding: 1rem !important;
            width: 90% !important;
        }

        .footer_top_footer__u_0LC P {
            text-align: left;
        }
    }

    .footer_footer__O h3 {
        border-bottom: 2px solid #e47302;
        padding-bottom: 5px
    }

    .footer_footer__O a {
        text-decoration: none;
        color: #fff !important;
    }

    .footer_footer__O ul li:not(:last-child) {
        border-bottom: 1px solid #ffffff42
    }

    .footer_rightContent {
        background-color: #e47302;
        color: #fff;
    }

    .footer_rightContent span {
        padding: .15rem .5rem;
        font-size: 1.2rem;
        letter-spacing: 3px;
        background: #000;
    }

    .footer_footer__O a:hover {
        text-decoration: none;
        color: #fff !important;
    }

    .footer--list li a {
        color: #fff !important;
    }

    .footer--list li:before {
        border-right: 2px solid #fff !important;
        border-bottom: 2px solid #fff !important;
    }

    .footer--heading {
        color: #fff !important;
    }

    #error_b02bbc85a30c7c9a99711a8a93df17b315b95524 {
        display: none !important;
    }

    .footer-counter a {
        pointer-events: none;
    }

    .dropdown-toggle {
        white-space: normal;
    }

    header .navbar li.nav-item.active a.nav-link {
        color: #292b2c !important
    }
    </style>

</head>

<body class="pb-0">
    <header>
        <div class="top-bar py-2">
            <div class="container">
                <div class="text-end top-bar-content">
                    <span class="d-flex flex-wrap gap-2 justify-content-end align-items-center">
                        @if (Route::has('login'))
                        <span>
                            @auth
                            <a href="{{ route('broadcast-logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <span>Logout</span>
                                &nbsp;</a>
                            <form id="logout-form" action="{{ route('broadcast-logout') }}" method="POST"
                                class="d-none">
                                @csrf
                            </form>
                            @else

                            @endauth
                        </span>
                        @endif
                </div>
            </div>
        </div>
        <div class="logo-header">
            <div class="container py-3">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-9 col-md-12 col-12">
                        <div
                            class="d-flex flex-wrap align-items-center gap-2 justify-content-md-between justify-content-center">
                            <div class="d-flex align-items-center gap-2 flex-column flex-md-row">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="text-center">
                                        <a href="{{ url('/') }}"> <img src="{{ asset('assets/images/logo.png') }}"
                                                height="100" /></a>
                                    </div>
                                    <span class="middle-line">|</span>
                                    <div class="text-center">
                                        <a href="{{ url('/') }}">
                                            <img src="{{ asset('assets/images/upldb-logo.png')}}" height="100" />
                                        </a>
                                    </div>
                                </div>
                                <div class="text-md-left text-center">
                                    <h1 class="mb-2 fw-bold">
                                        <span>Rashtriya Gokul Mission</span>
                                    </h1>
                                    <h6>
                                        <span>Online Application for Swarojgari Maitri (Multipurpose AI Technician in
                                            Rural India)</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-xl m-0 p-0">
            <div class="container-fluid justify-content-end">
                <button class="navbar-toggler my-1 bg-white py-1 px-2" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
                    aria-label="Toggle navigation">
                    <i class="ri-menu-3-line"></i>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasDarkNavbar"
                    aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-center flex-grow-1">
                            @if (Route::has('login'))
                            @auth
                            @if (auth()->user()->user_type == 'Broadcaster')
                            <li class="nav-item {{ request()->is('broadcaster-dashboard') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('/broadcaster-dashboard') }}">
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            @endif
                            @endauth
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </nav>




    </header>

    <div>
        @yield('content')
    </div>
    <!-- <footer> -->
    @if (Route::has('login'))
    @auth
    @else

    @endauth
    @endif

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
                        <a href="#"><img src="https://upldb.vercel.app/assets/images/site/pashudhan_app1.png"
                                width="120px" alt=""></a>
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
                                <span data-hi="आवेदन की स्थिति जानिए"
                                    data-en="Know the status of your application"></span>
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
</body>

</html>