<?php
$m20 = App\Models\Maitri::where('pass_date', 'LIKE', '%2020%')->count();
$m21 = App\Models\Maitri::where('pass_date', 'LIKE', '%2021%')->count();
$m22 = App\Models\Maitri::where('pass_date', 'LIKE', '%2022%')->count();
$m23 = App\Models\Maitri::where('pass_date', 'LIKE', '%2023%')->count();
$m24 = App\Models\Maitri::where('pass_date', 'LIKE', '%2024%')->count();
$latest = App\Models\Latestupdate::whereStatus(1)->get();
$dailyDashboard = App\Models\DailyDashboard::orderBy('id', 'desc')->first();

?>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


<style>
  .swiper-container {
    width: 100%;
    overflow: hidden;
    position: relative;
    height: 300px;
  }

  .swiper-container .swiper-pagination-bullet-active {
    background: #fff;
    width: 10px;
    height: 10px;
  }
  .logo-swiper-container {
    width: 100%;
    overflow: hidden;
    position: relative;
  }

  .page_sliderDiv {
    max-height: 300px;
    position: relative
  }

  .page_sliderDiv div {
    left: 0;
    right: 0;
    bottom: 0;
    margin: 0 auto 30px;
    width: 80%;
    background: #00000053;
    padding: 1rem;
    color: #fff;
  }

  .page_sliderDiv div a {
    text-decoration: none;
    background: var(--primary);
    color: var(--white) !important; 
    padding: 5px 20px;
  }
  .page_sliderDiv img{
    height: 400px;
    object-fit: cover;
  }
  

  .img-box-shadow img:first-child {
    box-shadow: 15px 15px 0 -3px #ff934d;
 }
 .img-box-shadow img:last-child {
    box-shadow: -15px -15px 0 -3px #ff934d;
}
  .img-box-shadow img {
      margin: 6px;
  }
  .home_sec-content{
    width: 94%;
    padding: 1rem 1.3rem;
    background-color: #00000087;
    bottom: 0;
  }
  .home_sec-content h6 {
    margin-bottom: 1rem;
    color: #fff;
  }
  .home_sec-content a {
    text-decoration: none;
    color: #e47302 !important;
    font-size: 1.1rem;
    padding: 5px 20px;
    border-radius: 5px;
    border: 2px solid #e47302 !important;
}
.home_sec-new{
  margin-right: auto !important;
  margin-left: auto !important;
}


/* ---f--- */
.footer_parent {
  background-color: #f93;
  color: #fff;
    padding-top: 7rem;
    margin-top: 9rem
}

.footer_top_footer__u_0LC {
    background: #a6dafa;
    color: var(--dark-color);
    width: 80%;
    padding: 1rem 2rem;
    border-radius: 1rem;
    box-shadow: 2px 2px 5px 0 #2b2b2b
}

.footer_footer__O h3 {
    border-bottom: 2px solid #e47302;
    padding-bottom: 5px
}

.footer_footer__O a {
    text-decoration: none;
    color:  #fff !important;
}

.footer_footer__O ul li:not(:last-child) {
    border-bottom: 1px solid #ffffff42
}

.footer_rightContent {
    background-color: #e47302;
    color:  #fff;
}

.footer_rightContent span {
    padding: .15rem .5rem;
    font-size: 1.2rem;
    letter-spacing: 3px;
    background:  #000;
}
.footer_footer__O a:hover{
    text-decoration: none;
    color: #fff !important;
}


</style>


@extends('master')
@section('content')
<section>
  <div class="container-fluid p-0">
    <div class="row m-0">
      <div class="col-lg-12 p-0">
        <div id="home-slider" class="carousel slide">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#home-slider" data-bs-slide-to="0" class="active" aria-current="true"
              aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#home-slider" data-bs-slide-to="1" aria-label="Slide 2"></button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img class="d-block w-100" src="{{ asset('assets/images/banner1.jpg')}}" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block w-100" src="{{ asset('assets/images/banner2.jpg')}}" alt="Second slide">
            </div>
            <!-- <div class="carousel-item">
                  <img class="d-block w-100" src="{{ asset('assets/images/banner3.jpg')}}" alt="Third slide">
                </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-4">
  <div class="container">
    <div class="row g-3">
      <div class="col-lg-6">
        <div class="card p-2 mb-3">
          <h5 class="site--heading">
          <span data-hi="राष्ट्रीय गोकुल मिशन अन्तर्गत मैत्री के बारे में" data-en="About Maitri under National Gokul Mission"></span>
          </h5>
          <p>
          <span data-hi=" पशुपालकों के द्वार पर गुणवत्तायुक्त पशु प्रजनन सुविधाये समयबद्ध
            रूप से उपलब्ध कराने में मैत्री की अहम् भूमिका है, भारत सरकार के
            राष्ट्रीय गोकुल मिशन योजनान्तर्गत उत्तर प्रदेश में जनपद स्तर से
            मैत्री का चयन कर पशुओं में कृत्रिम गर्भाधान आच्छादन को बढाया
            जाना है|" data-en="Maitri plays an important role in providing quality animal breeding facilities at the doorstep of livestock farmers in a timely manner. Under the National Gokul Mission Scheme of the Government of India, the artificial insemination coverage in animals is to be increased by selecting Maitri at the district level in Uttar Pradesh."></span>
          </p>
          <div class="d-flex gap-2 mt-3">
            <a href="{{url('avedan-karein')}}"> <button class="btn btn-primary">
              <span data-hi="Register Now" data-en="Register Now"></span>
            </button></a>
            <a href="{{url('application-status')}}"> <button class="btn btn-primary">
              <span data-hi="Check Status" data-en="Check Status"></span>
            </button></a>
          </div>
        </div>
        <div class="card p-2 mb-3">
            <h5 class="site--heading">
              <span data-hi="नयी जानकारियाँ" data-en="Latest information"></span>
            </h5>
          <marquee class="marqu1" onmouseover="stop()" onmouseout="start()" direction="up" scrolldelay="250">
            <ul class="notice--list">
              @if($latest)
          @foreach($latest as $val)
        <li><a href="{{$val->url}} " target="_blank"> {{$val->title}} </a> </li>
      @endforeach
        @endif
            </ul>
          </marquee>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="user-list-section">
          <h3 class="text-center mb-4 fw-bold">
            <span data-hi="हमारा नेतृत्व" data-en="Our Leadership"></span>
          </h3>
          <div class="row g-3 justify-content-center">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
              <div class="user-detail">
                <img src="{{ asset('assets/images/adityanathyogi.jpg')}}" />
                <div>
                  <p class="m-0 text-center"><b>
                    <span data-hi="श्री योगी आदित्यनाथ" data-en="Shri Yogi Adityanath"></span>
                  </b></p>
                  <p class="m-0 text-center lh-1"><small>
                  <span data-hi="माननीय मुख्यमंत्री, उत्तर प्रदेश।" data-en="Hon'ble Chief Minister, U.P."></span>
                  </small></p>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
              <div class="user-detail">
                <img src="{{ asset('assets/images/sm.jpeg')}}" />
                <div>
                  <p class="m-0 text-center"><b>
                  <span data-hi="श्री धर्मपाल सिंह" data-en="Shri Dharampal Singh"></span>
                  </b></p>
                  <p class="m-0 text-center lh-1"><small>
                  <span data-hi="माननीय मंत्री डेयरी विकास विभाग, पशुपालन, उत्तर प्रदेश।" data-en="Hon`ble Minister Dairy Development Dept., Animal Husbandry,U.P."></span>
                  </small></p>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
              <div class="user-detail">
                <img src="{{ asset('assets/images/ravindra.jpeg')}}" />
                <div>
                  <p class="m-0 text-center"><b>
                    <span data-hi="श्री के रविंद्र नायक, आई०ए०एस" data-en="Shri K. Ravindra Naik, IAS"></span>
                  </b></p>
                  <p class="m-0 text-center lh-1"><small>
                    <span data-hi="प्रमुख सचिव / पशुधन" data-en="Principal Secretary/ Livestock"></span>
                  </small></p>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
              <div class="user-detail">
                <img src="{{ asset('assets/images/niraj-ceo.jpeg')}}" />
                <div>
                  <p class="m-0 text-center"><b>
                  <span data-hi="डॉ. नीरज गुप्ता" data-en="Dr. Neeraj Gupta"></span>
                    </b></p>
                  <p class="m-0 text-center lh-1"><small>
                    <span data-hi="सीईओ यूपीएलडीबी, उ.प्र." data-en="C.E.O UPLDB, U.P."></span>
                  </small></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-4">
  <div class="container">
    <div class="row g-3 bg-gray-section p-2 p-md-4">
      <div class="col-xl-8">
        <div>
          <h3 class="fw-bold mb-3">
          <span data-hi="आपका स्वागत है" data-en="Welcome To"></span>
          <br />
            <span class="logo-title">
            <span data-hi="उत्तर प्रदेश पशुधन विकास बोर्ड" data-en="Uttar Pradesh Livestock Development Board"></span>
            </span>
          </h3>
          <p>
          <span data-hi="उत्तर प्रदेश शासन द्वारा शासनादेश संख्या 3991/12-प-2-98-1(20)/98, दिनांक 31 अक्टूबर, 1998 के माध्यम से उत्तर प्रदेश पशुधन विकास बोर्ड (यूपीएलडीबी) की स्थापना विषयक आदेश निर्गत किया गया । उक्त शासनादेश में प्रदत्त निर्देशों के अनुक्रम में यूपीएलडीबी का गठन करते हुए इसे सोसायटी पंजीकरण अधिनियम 1860, नियम 21, 1860 के अंतर्गत पंजीकृत कराया गया । पंजीकरण संख्या 2342/1998-99, दिनांक 07.01.1999, जिसे अब 07 जनवरी, 2029 तक के लिए नवीनीकृत किया गया है। भारत सरकार द्वारा 1997-98 में एम्ब्र्यो फ्रोजन सीमन प्रौद्योगिकी (ईएफएसटी) के विस्तार की केंद्र प्रायोजित योजना और गायों और भैंसों के प्रजनन के लिए राष्ट्रीय सांड उत्पादन कार्यक्रम (एनबीपीपी) के कार्यान्वयन के लिए स्वीकृति संख्या 3-15/97-एएचटी, दिनांक 03 मार्च, 1998 को नियंत्रित करने वाली नियम और शर्तें जारी की थीं, इस स्वीकृति में एक राज्य स्तरीय स्वायत्त निकाय के निर्माण का प्रावधान था, जिसे पशु प्रजनन कार्यक्रमों का नियंत्रक होना था और कृत्रिम गर्भाधान के सभी सहभागी एजेंसियों के साथ समन्वय कर पशु प्रजनन निवेशों यथा-तरल नाइट्रोजन एवं वीर्य स्ट्राज का उत्पादन का प्रबंधन (उपार्जन, वितरण  एवं उपयोग) करना है ।" data-en="U.P. Government established Uttar Pradesh Livestock Development Board via G.O. no. 3991/12-Pa-2-98-1(20/98,
            Dt. 31st October, 1998 and was registered under the Societies Registration Act 1860, Rule 21 of 1860 with
            the registration no. 2342/ 1998-99, Dt. 07.01.1999, which has now been renewed up to 07th January, 2024.
            Govt. of India had issued terms & conditions governing sanction No. 3-15/97-AHT, Dt. 03rd March, 1998 for
            implementation of Centrally Sponsored Scheme of Extension of Frozen Semen Technology(EFST) and National Bull
            Production Programme (NBPP) for Cattle and Buffalo Breeding during 1997-98, in this sanction there was a
            provision for creation of a State Level Autonomous Body, which was to be the incharge of Semen and liquid
            nitrogen production/procurement and sale to all agencies incharge of artificial insemination."></span>
            
          
          </p>
          <button class="btn btn-primary">
            <span data-hi="और देखें" data-en="View more"></span>
          </button>
        </div>
      </div>
      <div class="col-xl-4">
        <div class="d-flex justify-content-center flex-wrap img-box-shadow">
         
            <img class="" src="{{ asset('images/small-images/img2.jpg')}}" />
         
         
            <img class="" src="{{ asset('images/small-images/img5.jpg')}}" />
          
        
            <img class="" src="{{ asset('images/small-images/img1.jpg')}}" />
          
        
            <img class="" src="{{ asset('images/small-images/img10.jpg')}}" />
        
        </div>
      </div>
    </div>
</section>

<section class="py-4">
  <div class="container">
    <div class="row user-list-section align-items-center justify-content-center g-3 mb-5">
      <div class="col-xl-10">
        <div class="row align-items-center g-3">
          <div class="col-xl-9 col-lg-6">
            <h3 class="fw-bold mb-3 logo-title">
              <span data-hi="माननीय पशुपालन मंत्री, उत्तर प्रदेश का संदेश" data-en="Message from Hon`ble Minister, Animal Husbandry, U.P."></span>
            </h3>
            <p><i>
            <span data-hi="बोर्ड का उद्देश्य उत्तराखंड राज्य के पूरे क्षेत्र में पशुधन (गाय और भैंस) के प्रजनन और प्रबंधन में सुधार के लिए व्यवहार्य गतिविधियों को प्रोत्साहित करना, बढ़ावा देना और कार्यान्वित करना होगा, ताकि उनके उत्पादन और उत्पादकता में वृद्धि हो सके। राष्ट्रीय और अंतर्राष्ट्रीय अनुसंधान सेटअप के साथ संबंध स्थापित करना और पशुधन के लिए एक अनुसंधान सहायता कार्यक्रम का आयोजन करना, जिससे दक्षता में सुधार हो और लागत में कमी आए। पशुधन उत्पादन, उत्पादकता और पशुधन उत्पादों के सभी पहलुओं पर अध्ययन और सर्वेक्षण करना; भारतीय पशुधन उद्योग के बढ़ते वैश्वीकरण के लिए उन्नत सूचना प्रौद्योगिकी द्वारा एक गतिशील डेटाबेस और प्रबंधन सूचना प्रणाली के लिए सूचना और डेटा उत्पन्न करना।" data-en="“The board's objective shall be to encourage, promote, and carry out viable, activities to improve the breeding and management of livestock (cattle and buffaloes) to enhance their production and productivity
                throughout the territory of the State of Uttarakhand. Establish linkage with national and international
                research setup, and orchestrate a research support program for livestock leading to improved efficiency
                and cost reduction. Conduct studies and surveys on all aspects of livestock production, productivity,
                and livestock products; generate information and data leading to a dynamic database and management
                information system by advanced information technology for the growing globalization of the Indian
                livestock industry."></span>
              
            </i></p>
          </div>
          <div class="col-xl-3 col-lg-6">
            <div class="author-section">
              <img class="w-100" src="{{ asset('assets/images/sm.jpeg')}}" />
              <span data-hi="श्री धर्मपाल सिंह" data-en="Shri Dharmpal Singh"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row user-list-section align-items-center justify-content-center g-3 mb-5">
      <div class="col-xl-10">
        <div class="row align-items-center g-3 flex-column-reverse flex-md-row">
          <div class="col-xl-3 col-lg-6">
            <div class="author-section">
              <img class="w-100" src="{{ asset('assets/images/ravindra.jpeg')}}" />
              <span data-hi="श्री के रविंद्र नायक, आई०ए०एस" data-en="Shri K. Ravindra Naik, IAS"></span>
            </div>
          </div>
          <div class="col-xl-9 col-lg-6">
            <h3 class="fw-bold mb-3 logo-title">
            <span data-hi="प्रमुख सचिव / पशुधन" data-en="Principal Secretary/ Livestock"></span>
           </h3>
            <p><i>
            <span data-hi="हमारा उद्देश्य नियमित और निरंतर आधार पर सभी स्तरों पर कौशल और व्यावसायिक क्षमता को बढ़ाने के लिए मौजूदा सुविधाओं का आधुनिकीकरण और उन्नयन करना है। पशुधन के प्रजनन और विकास तथा उनकी उत्पादकता से संबंधित संस्थागत ढांचे को समग्र रूप से मजबूत बनाने में राज्य सरकार को सलाह और सहायता देना, तथा राज्य भर में पशुधन प्रजनन बुनियादी ढांचे पर पहले से किए गए निवेश पर अधिकतम लाभ प्राप्त करने के लिए नई संस्थाओं की स्थापना में सहायता करना। उत्पादकता वृद्धि और उद्यम संवर्धन के लिए तकनीकी सहायता प्रदान करना। देशी नस्लों के संरक्षण और आनुवंशिक उन्नयन के लिए पहल को बढ़ावा देना। जैव विविधता और आनुवंशिक संसाधनों के संरक्षण और आर्थिक महत्व के पशुधन की देशी नस्लों के विकास और वाणिज्यिक दोहन में राष्ट्रीय प्रयास में सहायता करना। प्रजनन क्षेत्र में बोर्ड के लिए विकास गतिविधियों को बढ़ावा देना और वित्तपोषित करना।" data-en="We aim to Modernize and upgrade existing facilities to enhance skills and professional competence at
                all levels on a regular and continuing basis. Advise and assist the State Govt. in overall strengthening
                of the institutional setup dealing with breeding and development of livestock, and their productivity,
                and help in establishing new institutions to maximize returns on investments already made on livestock
                breeding infrastructure statewide. Technical support for productivity enhancement and enterprise
                promotion. Promoting initiatives for conservation and genetic up-gradation of indigenous breeds. Assist
                the national effort in the conservation of biodiversity and genetic resources and development and
                commercial exploitation of indigenous breeds of livestock of economic importance. Promote and fund
                development activities for the board in the breeding sector."></span>
            </i></p>
          </div>
        </div>
      </div>
    </div>
    <div class="row user-list-section align-items-center justify-content-center g-3 mb-5">
      <div class="col-xl-10">
        <div class="row align-items-center g-3">
          <div class="col-xl-9 col-lg-6">
            <h3 class="fw-bold mb-3 logo-title">
              <span data-hi="यूपीएलडीबी के सीईओ का संदेश" data-en="Message from C.E.O, UPLDB, U.P."></span>
            </h3>
            <p><i>
            <span data-hi="हमारा उद्देश्य नियमित और निरंतर आधार पर सभी स्तरों पर कौशल और व्यावसायिक क्षमता को बढ़ाने के लिए मौजूदा सुविधाओं का आधुनिकीकरण और उन्नयन करना है। पशुधन के प्रजनन और विकास तथा उनकी उत्पादकता से संबंधित संस्थागत ढांचे को समग्र रूप से मजबूत बनाने में राज्य सरकार को सलाह और सहायता देना, तथा राज्य भर में पशुधन प्रजनन बुनियादी ढांचे पर पहले से किए गए निवेश पर अधिकतम लाभ प्राप्त करने के लिए नई संस्थाओं की स्थापना में सहायता करना। उत्पादकता वृद्धि और उद्यम संवर्धन के लिए तकनीकी सहायता प्रदान करना। देशी नस्लों के संरक्षण और आनुवंशिक उन्नयन के लिए पहल को बढ़ावा देना। जैव विविधता और आनुवंशिक संसाधनों के संरक्षण और आर्थिक महत्व के पशुधन की देशी नस्लों के विकास और वाणिज्यिक दोहन में राष्ट्रीय प्रयास में सहायता करना। प्रजनन क्षेत्र में बोर्ड के लिए विकास गतिविधियों को बढ़ावा देना और वित्तपोषित करना।" data-en="We aim to Modernize and upgrade existing facilities to enhance skills and professional competence at
                all levels on a regular and continuing basis. Advise and assist the State Govt. in overall strengthening
                of the institutional setup dealing with breeding and development of livestock, and their productivity,
                and help in establishing new institutions to maximize returns on investments already made on livestock
                breeding infrastructure statewide. Technical support for productivity enhancement and enterprise
                promotion. Promoting initiatives for conservation and genetic up-gradation of indigenous breeds. Assist
                the national effort in the conservation of biodiversity and genetic resources and development and
                commercial exploitation of indigenous breeds of livestock of economic importance. Promote and fund
                development activities for the board in the breeding sector."></span>
            </i></p>
          </div>
          <div class="col-xl-3 col-lg-6">
            <div class="author-section">
              <img class="w-100" src="{{ asset('assets/images/niraj-ceo.jpeg')}}" />
              <span data-hi="डॉ. नीरज गुप्ता" data-en="Dr. Neeraj Gupta"></span>
              <span></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5 my-3 counter-section">
  <div class="container">
    <div class="d-flex mb-5 flex-column align-items-center justify-content-center text-white text-center">
      
      <h2 class="fw-bold">
        <span data-hi="पशुधन संख्या उत्तर प्रदेश" data-en="Livestock Population Uttar Pradesh"></span>
      </h2>
    </div>
    <div class="row g-3">
      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-6 p-2">
        <div class="text-center">
          <h2 class="fw-bold logo-title"><span data-hi="गाय" data-en="Cattle"></span></h2>
          <p class="text-center text-white fs-4 cattle counter">1332510</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-6 p-2">
        <div class="text-center">
          <h2 class="fw-bold logo-title"><span data-hi="भैंस" data-en="Buffalo"></span></h2>
          <p class="text-center text-white fs-4 counter">101500</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-6 p-2">
        <div class="text-center">
          <h2 class="fw-bold logo-title"><span data-hi="बकरी" data-en="Goat"></span></h2>
          <p class="text-center text-white fs-4 counter">14480025</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-6 p-2">
        <div class="text-center">
          <h2 class="fw-bold logo-title"><span data-hi="घोड़ा" data-en="Horse"></span></h2>
          <p class="text-center text-white fs-4 counter">104000</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-4">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-center fw-bold">
        <span data-hi="पशुधन में क्रांतिकारी बदलाव: अत्याधुनिक खेती के माध्यम से जीवन को जोड़ना!" data-en="Revolutionizing Livestock: Connecting Lives through Cutting-Edge Farming!"></span>
        </h4>
      </div>
    </div>
    <div class="row g-3 my-3">
      <div class="col-xl-2 col-lg-3 col-sm-6 col-md-4 col-6 px-2">
        <div class="flip-card">
          <div class="flip-face flip-face-front">
            <img src="{{ asset('assets/images/bull-1.jpg')}}" />
            <h5>
              <span data-hi="राष्ट्रीय गोजातीय प्रजनन परियोजना" data-en="NATIONAL PROJECT FOR BOVINE BREEDING"></span>
            </h5>
          </div>
          <div class="flip-face flip-face-back">
            <p>
              <span data-hi="राज्य के सभी प्रजनन योग्य मवेशियों को कृत्रिम गर्भाधान कार्यक्रम के माध्यम से कवर करने के इरादे से, जमे हुए सीमेन का उपयोग करते हुए, भारत सरकार राष्ट्रीय गोजातीय प्रजनन परियोजना को प्रायोजित कर रही है।" data-en="Intending to cover the entire breedable cattle of the state through the AI program, using frozen semen,
              the Government of India is Sponsoring the National Project for Bovine Breeding."></span>
            </p>
            <button class="btn btn-primary w-100">
            <span data-hi="और जानें" data-en="Know More"></span>  
           </button>
          </div>
        </div>
      </div>
      <div class="col-xl-2 col-lg-3 col-sm-6 col-md-4 col-6 px-2">
        <div class="flip-card">
          <div class="flip-face flip-face-front">
            <img src="{{ asset('assets/images/goat.jpg')}}" />
            <h5>
            <span data-hi="बकरी प्रजनन केंद्र" data-en="GOAT BREEDING CENTRE"></span> 
              </h5>
          </div>
          <div class="flip-face flip-face-back">
            <p><span data-hi="उत्तर प्रदेश में बकरियों की आबादी का बड़ा हिस्सा जमुनापारी नस्ल का है और यह राज्य की कृषि-जलवायु परिस्थितियों के अनुकूल है। विविधीकरण कार्यक्रम के एक भाग के रूप में, बोर्ड..." data-en="The major proportion of the goat population in Uttar Pradesh belongs to the Jamunapari breed and is well
              adapted to the agro-climatic conditions of the State. As a part of the diversification program, the
              Board..."></span> 
            </p>
            <button class="btn btn-primary w-100"> <span data-hi="और जानें" data-en="Know More"></span>  </button>
          </div>
        </div>
      </div>
      <div class="col-xl-2 col-lg-3 col-sm-6 col-md-4 col-6 px-2">
        <div class="flip-card">
          <div class="flip-face flip-face-front">
            <img src="{{ asset('assets/images/foodder.jpg')}}" />
            <h5> <span data-hi="आहार विकास कार्यक्रम" data-en="FODDER DEVELOPMENT PROGRAMME"></span>  </h5>
          </div>
          <div class="flip-face flip-face-back">
            <p><span data-hi="आर्थिक रूप से किफायती डेयरी फार्मिंग में उचित आहार के महत्व पर अधिक जोर देने की आवश्यकता नहीं है। बोर्ड ने शुरू से ही चारा विकास को सबसे महत्वपूर्ण गतिविधियों में से एक के रूप में लिया था।" data-en="The importance of proper feeding in economic dairy farming need not be overemphasized. The Board had
              taken up fodder development as one of the most important activities right from the very beginning."></span> 
              </p>
            <button class="btn btn-primary w-100"><span data-hi="और जानें" data-en="Know More"></span></button>
          </div>
        </div>
      </div>
      <div class="col-xl-2 col-lg-3 col-sm-6 col-md-4 col-6 px-2">
        <div class="flip-card">
          <div class="flip-face flip-face-front">
            <img src="{{ asset('assets/images/frozensemen.jpg')}}" />
            <h5><span data-hi="हिमीकृत सीमेन प्रबंधन" data-en="FROZEN SEMEN MANAGEMENT"></span>
             </h5>
          </div>
          <div class="flip-face flip-face-back">
            <p><span data-hi="राज्य ने गाय प्रजनन के लिए इनपुट प्रदान करने के लिए तीन स्तरीय कृत्रिम गर्भाधान (ए.आई.) प्रबंधन प्रणाली विकसित की है, जिसमें बैल स्टेशन, क्षेत्रीय सीमेन बैंक (आरएसबी) और कृत्रिम गर्भाधान केंद्र शामिल हैं।" data-en="The State has evolved a three-tier Artificial Insemination (A.I.) management system to provide the inputs for cattle breeding namely Bull Stations, Regional Semen Banks (RSB), and Artificial Insemination Centres.">
            </p>
            <button class="btn btn-primary w-100"><span data-hi="और जानें" data-en="Know More"></span></button>
          </div>
        </div>
      </div>
      <div class="col-xl-2 col-lg-3 col-sm-6 col-md-4 col-6 px-2">
        <div class="flip-card">
          <div class="flip-face flip-face-front">
            <img src="{{ asset('assets/images/cow.jpg')}}" />
            <h5><span data-hi="सायर चयन कार्यक्रम" data-en="SIRE SELECTION PROGRAMME"></span>
              </h5>
          </div>
          <div class="flip-face flip-face-back">
            <p>
            <span data-hi="अगली पीढ़ी के लिए सबसे उपयुक्त सांडों की पहचान करने के लिए, यूपीएलडीबी ने क्षेत्र संतान-परीक्षण कार्यक्रम शुरू किया, जिसमें दो बुनियादी कार्य शामिल थे।" data-en=" To identify the most suitable bulls as the sires for the next generation, the UPLDB ventured into the
              field progeny-testing program involving the two basic tasks viz."></span>
             </p>
            <button class="btn btn-primary w-100"><span data-hi="और जानें" data-en="Know More"></span></button>
          </div>
        </div>
      </div>
      <div class="col-xl-2 col-lg-3 col-sm-6 col-md-4 col-6 px-2">
        <div class="flip-card">
          <div class="flip-face flip-face-front">
            <img src="{{ asset('assets/images/embryo.jpg')}}" />
            <h5><span data-hi="भ्रूण स्थानांतरण कार्यक्रम" data-en="EMBRYO TRANSFER PROGRAMME"></span>
              </h5>
          </div>
          <div class="flip-face flip-face-back">
            <p>
             <span data-hi="बेहतर नस्ल के सांडों के उत्पादन के लिए मल्टीपल ओवुलेशन एम्ब्रियो ट्रांसफर (एमओईटी) की शुरुआत की गई। इस तकनीक के तहत, बेहतरीन गायों की आनुवंशिक गुणवत्ता का उपयोग अगली पीढ़ी के सांडों के उत्पादन के लिए किया जाता है।" data-en=" Multiple Ovulation Embryo Transfer (MOET) was introduced for the production of superior sires. Under this
              technology, the genetic quality of the elite cows is utilized for the production of next-generation bulls."></span>
            </p>
            <button class="btn btn-primary w-100"><span data-hi="और जानें" data-en="Know More"></span></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="py-4">
  <div class="container">
  <div class="row">
    <h2 class="text-center">
      <span data-hi="नवीनतम समाचार और घटनाएँ" data-en="LATEST NEWS AND EVENTS">  </span>
    </h2>
 </div>
  <div class="row home_sec-new">
        <div class="col-lg-4 mt-3 position-relative">
            <img src="{{ asset('assets/images/home-ne2.jpeg')}}" width="100%" alt="">
            <div class="position-absolute home_sec-content">
                <h6>
                  <span data-hi="मुज़फ़्फ़रनगर चीयर्स - गोवंश का आशीर्वाद मिला! दो स्वस्थ..." data-en=" Muzaffarnagar Cheers - Got Bovine Blessings! Two Healthy...">   </span>
                </h6>
                <a href="{{route('eventdetails')}}">
                  <span data-hi="सभी देखें" data-en="View All">  </span>
                </a>
            </div>
        </div>
        <div class="col-lg-4 mt-3 position-relative">
            <img src="{{ asset('assets/images/home-ne1.jpeg')}}" width="100%" alt="">
            <div class="position-absolute home_sec-content">
                <h6>
                <span data-hi="उत्तर प्रदेश पशुधन बोर्ड ने डेयरी विकास के 25 वर्षों पर प्रकाश डाला। निवेश" data-en="UP Livestock Board Highlights 25 Years of Dairy Development. Invests...">  </span>
               </h6><a
                    href="{{route('eventdetails')}}"><span data-hi="सभी देखें" data-en="View All">  </span></a>
            </div>
        </div>
        <div class="col-lg-4 mt-3 position-relative">
            <img src="{{ asset('assets/images/home-ne3.jpeg')}}" width="100%" alt="">
            <div class="position-absolute home_sec-content">
                <h6>
                  <span data-hi="मैत्री एआई तकनीशियन राम मोहन ने किसान ओम प्रकाश को गोजातीय आशीर्वाद से सशक्त बनाया..." data-en="MAITRI AI Technician Ram Mohan Empower Farmer Om Prakash with Bovine Blessing...">  </span>
                </h6>
                <a href="{{route('eventdetails')}}"><span data-hi="सभी देखें" data-en="View All">  </span></a>
            </div>
        </div>
        <div class="col-lg-4 mt-3 position-relative">
            <img src="{{ asset('assets/images/home-ne4.jpeg')}}" width="100%" alt="">
            <div class="position-absolute home_sec-content">
                <h6>
                <span data-hi="पशु उत्थान वर्णसंकर केंद्र, मुड़िया मुकर्रमपुर गांव में मैत्री प्रशिक्षण..." data-en=" MAITRI Training at Pashu Utthan Varnsankar Kendra, Mudiya Mukarrampur Village ...">  </span>
               </h6>
                <a  href="{{route('eventdetails')}}"><span data-hi="सभी देखें" data-en="View All">  </span></a>
            </div>
        </div>
        <div class="col-lg-4 mt-3 position-relative">
            <img src="{{ asset('assets/images/home-ne5.jpeg')}}" width="100%" alt="">
            <div class="position-absolute home_sec-content">
                <h6>
                  <span data-hi="रायबरेली के बैलों को मिला तकनीकी उन्नयन! स्वस्थ प्रजनन के लिए AI-संचालित गर्भाधान..." data-en="Rae Bareli's Bulls Get a Tech Upgrade! AI-powered insemination for healthier....">  </span>
                 </h6>
                  <a href="{{route('eventdetails')}}"><span data-hi="सभी देखें" data-en="View All">  </span></a>
            </div>
        </div>
        <div class="col-lg-4 mt-3 position-relative">
            <img src="{{ asset('assets/images/home-ne6.jpeg')}}" width="100%" alt="">
            <div class="position-absolute home_sec-content">
                <h6>
                    <span data-hi="यूपीएलडीबी के रजत जयंती वर्ष में भवन निर्माण के 25 वर्ष पूरे होने का जश्न..." data-en="UPLDB's Silver Jubilee Year Celebrates 25 Years of Building...">  </span>
                </h6>
                <a href="{{route('eventdetails')}}"><span data-hi="सभी देखें" data-en="View All">  </span></a>
            </div>
        </div>

    </div>
  </div>
  </section>
  <section class="py-5 my-3 counter-section">
  <div class="container">
    <div class="d-flex mb-5 flex-column align-items-center justify-content-center text-white text-center">
      <h2 class="fw-bold"> <span data-hi="मैत्री जनसंख्या उत्तर प्रदेश" data-en="Maitri Population Uttar Pradesh"></span>  </h2>
    </div>
    <div class="row g-3">
      <div class="col-lg-4 p-2">
        <div class="text-center">
          <h2 class="fw-bold logo-title">2021 - 2022</h2>
          <p class="text-center text-white fs-4 cattle counter">1182</p>
        </div>
      </div>
      <div class="col-lg-4 p-2">
        <div class="text-center">
          <h2 class="fw-bold logo-title">2022 - 2023</h2>
          <p class="text-center text-white fs-4 counter">1755</p>
        </div>
      </div>
      <div class="col-lg-4 p-2">
        <div class="text-center">
          <h2 class="fw-bold logo-title">2023 - 2024</h2>
          <p class="text-center text-white fs-4 counter">1897</p>
        </div>
      </div>
      <!-- <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-6 p-2">
        <div class="text-center">
          <h2 class="fw-bold logo-title">2023</h2>
          <p class="text-center text-white fs-4 counter">{{$m23}}</p>
        </div>
      </div> -->
      <!-- <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-6 p-2">
        <div class="text-center">
          <h2 class="fw-bold logo-title">2024</h2>
          <p class="text-center text-white fs-4 counter">{{$m24}}</p>
        </div>
      </div> -->
    </div>
  </div>
</section>


<section class="py-4">
  <div class="container">
    <div class="row g-3">
      <div class="col-lg-12">
        <h5 class="site--heading"> <a href="{{route('gallery-page')}}"> <span data-hi="फोटो गैलरी" data-en="Photo Gallery"></span> </a> </h5>
        <div class="row m-0">
          <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-6 col-12 p-2">
            <img class="ftr-img" src="{{ asset('gallery/gallery1.jpeg')}}" />
          </div>
          <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-6 col-12 p-2">
            <img class="ftr-img" src="{{ asset('gallery/gallery2.jpeg')}}" />
          </div>
          <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-6 col-12 p-2">
            <img class="ftr-img" src="{{ asset('gallery/gallery3.jpeg')}}" />
          </div>
          <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-6 col-12 p-2">
            <img class="ftr-img" src="{{ asset('gallery/gallery4.jpeg')}}" />
          </div>
          <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-6 col-12 p-2">
            <img class="ftr-img" src="{{ asset('gallery/gallery5.jpeg')}}" />
          </div>
          <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-6 col-12 p-2">
            <img class="ftr-img" src="{{ asset('gallery/gallery6.jpeg')}}" />
          </div>
        </div>
      </div>
      <!-- <div class="col-lg-12">
        <div class="logo_box my-5">
          <a href="#" target="_blank">
            <img src="{{ asset('images/footer-logos/dialgov-logo.jpg')}}" /></a>
          <a href="http://pmindia.gov.in/" target="_blank"><img src="{{ asset('images/footer-logos/logo1.png')}}" /></a>
          <a href="https://data.gov.in/" target="_blank"><img src="{{ asset('images/footer-logos/dpi.jpg')}}" /></a>
          <a href="http://digitalindia.gov.in/" target="_blank"><img
              src="{{ asset('images/footer-logos/digitalIndia.png')}}" /></a>
          <a href="https://epashuhaat.gov.in/" target="_blank"><img
              src="{{ asset('images/footer-logos/epashulogo.jpg')}}" /></a>
          <a href="http://digitalindia.gov.in/" target="_blank"><img
              src="{{ asset('images/footer-logos/indiagov-logo.jpg')}}" /></a>
          <a href="http://meity.gov.in/" target="_blank"><img
              src="{{ asset('images/footer-logos/Meity_logo.png')}}" /></a>
          <a href="https://www.nddb.coop/" target="_blank"><img
              src="{{ asset('images/footer-logos/nddb-logo1.jpg')}}" /></a>
        </div>
      </div> -->
    </div>
  </div>
</section>

<section class="py-5 my-3 counter-section">
  <div class="container">
    <div class="d-flex mb-5 flex-column align-items-center justify-content-center text-white text-center">
      <h2 class="fw-bold"> <span data-hi="भारत पशुधन दैनिक डैशबोर्ड उत्तर प्रदेश" data-en="Bharat Pashudhan Daily Dashboard Uttar Pradesh"></span>  </h2>
    </div>
    <div class="row g-3">
        <div class="col-lg-3 p-2">
            <div class="text-center">
              <h5 class="fw-bold logo-title"><span data-hi="{{ $dailyDashboard['heading_of_ai'] ?? 'Number of AI Done' }}" data-en="{{ $dailyDashboard['heading_of_ai'] ?? 'Number of AI Done' }}"></span> </h5>
              <p class="text-center text-white fs-4 cattle counter">{{ $dailyDashboard['num_of_ai'] ?? '1182' }}</p>
            </div>
          </div>
        <div class="col-lg-3 p-2">
          <div class="text-center">
            <h5 class="fw-bold logo-title"><span data-hi="{{ $dailyDashboard['heading_of_pd'] ?? 'Number of PD Done' }}" data-en="{{ $dailyDashboard['heading_of_pd'] ?? 'Number of PD Done' }}"></span></h5>
            <p class="text-center text-white fs-4 counter">{{ $dailyDashboard['num_of_pd'] ?? '1755' }}</p>
          </div>
        </div>
        <div class="col-lg-3 p-2">
          <div class="text-center">
            <h5 class="fw-bold logo-title"><span data-hi="{{ $dailyDashboard['heading_of_calving'] ?? 'Number of Calving Done' }}" data-en="{{ $dailyDashboard['heading_of_calving'] ?? 'Number of Calving Done' }}"></span></h5>
            <p class="text-center text-white fs-4 counter">{{ $dailyDashboard['num_of_calving'] ?? '1897' }}</p>
          </div>
        </div>
        <div class="col-lg-3 p-2">
          <div class="text-center">
            <h5 class="fw-bold logo-title"><span data-hi="{{ $dailyDashboard['heading_of_insurance'] ?? 'Number of Insurance Done' }}" data-en="{{ $dailyDashboard['heading_of_insurance'] ?? 'Number of Insurance Done' }}"></span></h5>
            <p class="text-center text-white fs-4 counter">{{ $dailyDashboard['number_of_insurance'] ?? '1900' }}</p>
          </div>
        </div>
    </div>
  </div>
</section>


<section class="py-4">
  <div class="container">
    <div class="row">
      <h2 class="fs-3 fw-bold text-center">
        <span data-hi="कृत्रिम गर्भाधान प्रशिक्षण केंद्र" data-en="Artificial Insemination Training Centers"></span> 
      </h2>

      <div class="col-lg-6">
        <h3 class="text-center mb-2 mt-4">
        <span data-hi="सीमेन बैंक / क्षेत्रीय केंद्र" data-en="Semen Banks / Zonal Centres"></span> 
       </h3>
        <div class="swiper-container">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="page_sliderDiv">
                <img src="{{ asset('zone/vanansi-zone.jpeg')}}" width="100%" alt="">
                <div class="position-absolute">
                  <p> <span data-hi="वाराणसी जोन" data-en="Varanasi Zone"></span>  </p>
                  <a href="#"> <span data-hi="और जानें" data-en="Know More"></span>  </a>
                </div>
              </div>


            </div>
            <div class="swiper-slide">
              <div class="page_sliderDiv">
                <img src="{{ asset('zone/jhansi-zone.jpeg')}}" width="100%" alt="">
                <div class="position-absolute">
                <p> <span data-hi="झांसी जोन" data-en="Jhanshi Zone"></span>  </p>
                <a href="#"> <span data-hi="और जानें" data-en="Know More"></span>  </a>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="page_sliderDiv">
                <img src="{{ asset('zone/gorakhpur%20-zone.jpeg')}}" width="100%" alt="">
                <div class="position-absolute">
                <p> <span data-hi="गोरखपुर जोन" data-en="Gorakhpur Zone"></span>  </p>
                <a href="#"> <span data-hi="और जानें" data-en="Know More"></span>  </a>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="page_sliderDiv">
                <img src="{{ asset('zone/kanpur-zone.jpeg')}}" width="100%" alt="">
                <div class="position-absolute">
                <p> <span data-hi="कानपुर जोन" data-en="Kanpur Zone"></span>  </p>
                <a href="#"> <span data-hi="और जानें" data-en="Know More"></span>  </a>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="page_sliderDiv">
                <img src="{{ asset('zone/agra-zone.jpeg')}}" width="100%" alt="">
                <div class="position-absolute">
                <p> <span data-hi="आगरा जोन" data-en="Agra Zone"></span>  </p>
                <a href="#"> <span data-hi="और जानें" data-en="Know More"></span>  </a>
                </div>
              </div>
            </div>
            <!-- Add more slides as needed -->
          </div>
          <!-- If you want pagination -->
          <div class="swiper-pagination"></div>

        </div>
      </div>
      <div class="col-lg-6">
        <h3 class="text-center mb-2  mt-4">
          <span data-hi="सीमेन डी.एफ.एस. स्टेशन" data-en=" Semen D.F.S Stations"></span>
        </h3>
        <div class="swiper-container">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="page_sliderDiv">
                <img src="{{ asset('zone/lucknow-station.jpeg')}}" width="100%" alt="">
                <div class="position-absolute">
                <p> <span data-hi="लखनऊ स्टेशन" data-en="Lucknow Station"></span>  </p>
                <a href="#"> <span data-hi="और जानें" data-en="Know More"></span>  </a>
                </div>
              </div>


            </div>
            <div class="swiper-slide">
              <div class="page_sliderDiv">
                <img src="{{ asset('zone/babugharh-station.jpeg')}}" width="100%" alt="">
                <div class="position-absolute">
                <p> <span data-hi="बाबूगढ़ स्टेशन" data-en="Babugharh Station"></span>  </p>
                <a href="#"> <span data-hi="और जानें" data-en="Know More"></span>  </a>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="page_sliderDiv">
                <img src="{{ asset('zone/gorakhpur%20-zone.jpeg')}}" width="100%" alt="">
                <div class="position-absolute">
                <p> <span data-hi="गोरखपुर स्टेशन" data-en="Gorakhpur Station"></span>  </p>
                <a href="#"> <span data-hi="और जानें" data-en="Know More"></span>  </a>
                </div>
              </div>
            </div>
            <!-- Add more slides as needed -->
          </div>
          <!-- If you want pagination -->
          <div class="swiper-pagination"></div>

        </div>
      </div>
      <div class="col-lg-6">
        <h3 class="text-center mb-2  mt-4"><span data-hi="बुल मदर फार्म्स (बीएमएफ)" data-en="Bull Mother Farms(BMF)"></span>
        </h3>
        <div class="swiper-container">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="page_sliderDiv">
                <img src="{{ asset('zone/arazilines-varanasi-bmf.jpeg')}}" width="100%" alt="">
                <div class="position-absolute">
                <p> <span data-hi="आराजीलाइन्स वाराणसी बीएमएफ" data-en="Arazilines Varanasi BMF"></span>  </p>
                <a href="#"> <span data-hi="और जानें" data-en="Know More"></span>  </a>
                </div>
              </div>


            </div>
            <div class="swiper-slide">
              <div class="page_sliderDiv">
                <img src="{{ asset('zone/arazilines-varanasi-bmf.jpeg')}}" width="100%" alt="">
                <div class="position-absolute">
                <p> <span data-hi="आराजीलाइन्स वाराणसी बीएमएफ" data-en="Arazilines Varanasi BMF"></span>  </p>
                <a href="#"> <span data-hi="और जानें" data-en="Know More"></span>  </a>
                </div>
              </div>
            </div>
           
            <!-- Add more slides as needed -->
          </div>
          <!-- If you want pagination -->
          <div class="swiper-pagination"></div>

        </div>
      </div>
      <div class="col-lg-6">
        <h3 class="text-center mb-2  mt-4">
            <span data-hi="कृत्रिम गर्भाधान प्रशिक्षण केंद्र" data-en="Artificial Insemination Training Centers"></span> 
        </h3>
        <div class="swiper-container">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="page_sliderDiv">
                <img src="{{ asset('zone/baif-pratapgharh.jpeg')}}" width="100%" alt="">
                <div class="position-absolute">
                <p> <span data-hi="प्रतापगढ़ जोन" data-en="Pratapgharh Zone"></span>  </p>
                <a href="#"> <span data-hi="और जानें" data-en="Know More"></span>  </a>
                </div>
              </div>


            </div>
            <div class="swiper-slide">
              <div class="page_sliderDiv">
                <img src="{{ asset('zone/gourakhpur.jpeg')}}" width="100%" alt="">
                <div class="position-absolute">
                <p> <span data-hi="गोरखपुर जोन" data-en="Gorakhpur Zone"></span>  </p>
                <a href="#"> <span data-hi="और जानें" data-en="Know More"></span>  </a>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="page_sliderDiv">
                <img src="{{ asset('zone/meerut.jpeg')}}" width="100%" alt="">
                <div class="position-absolute">
                <p> <span data-hi="मेरठ जोन" data-en="Meerut Zone"></span>  </p>
                <a href="#"> <span data-hi="और जानें" data-en="Know More"></span>  </a>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="page_sliderDiv">
                <img src="{{ asset('zone/agra.jpeg')}}" width="100%" alt="">
                <div class="position-absolute">
                <p> <span data-hi="आगरा जोन" data-en="Agra Zone"></span>  </p>
                <a href="#"> <span data-hi="और जानें" data-en="Know More"></span>  </a>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="page_sliderDiv">
                <img src="{{ asset('zone/barelly.jpeg')}}" width="100%" alt="">
                <div class="position-absolute">
                <p> <span data-hi="बरेली जोन" data-en="Barelly Zone"></span>  </p>
                <a href="#"> <span data-hi="और जानें" data-en="Know More"></span>  </a>
                </div>
              </div>
            </div>
            <!-- Add more slides as needed -->
          </div>
          <!-- If you want pagination -->
          <div class="swiper-pagination"></div>

        </div>
      </div>
    </div>
  </div>
</section>



<section class="py-4">
  <div class="container">
    <div class="row">
      <div class="logo-swiper-container">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="logo-box">
            <a href="#" target="_blank">
            <img src="{{ asset('images/footer-logos/dialgov-logo.jpg')}}" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="logo-box">
            <a href="http://pmindia.gov.in/" target="_blank"><img src="{{ asset('images/footer-logos/logo1.png')}}" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="logo-box">
            <a href="https://data.gov.in/" target="_blank"><img src="{{ asset('images/footer-logos/dpi.jpg')}}" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="logo-box">
            <a href="http://digitalindia.gov.in/" target="_blank"><img
            src="{{ asset('images/footer-logos/digitalIndia.png')}}"  /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="logo-box">
            <a href="https://epashuhaat.gov.in/" target="_blank"><img src="{{ asset('images/footer-logos/epashulogo.jpg')}}" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="logo-box">
            <a href="http://digitalindia.gov.in/" target="_blank"><img src="{{ asset('images/footer-logos/indiagov-logo.jpg')}}" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="logo-box">
            <a href="http://meity.gov.in/" target="_blank"><img src="{{ asset('images/footer-logos/Meity_logo.png')}}" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="logo-box">
            <a href="https://www.nddb.coop/" target="_blank"><img src="{{ asset('images/footer-logos/nddb-logo1.jpg')}}" /></a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<section class="py-4">
  <div class="container">
  <h2 class="fs-3 fw-bold text-center mb-3"> <a href="{{route('gallery-page')}}">  <span data-hi="गैलरी" data-en="Gallery"></span> </a> </h2>
    <div class="row">
        <div class="col-md-3 col-lg-3 col-xl-2">
           <img src="{{ asset('gallery/gallery7.jpeg')}}" alt="..." class="gallery-item">
        </div>
        <div class="col-md-3 col-lg-3 col-xl-2">
            <img src="{{ asset('gallery/gallery8.jpeg')}}" alt="..." class="gallery-item">
        </div>
        <div class="col-md-3 col-lg-3 col-xl-2">
            <img src="{{ asset('gallery/gallery9.jpeg')}}" alt="..." class="gallery-item">
        </div>
        <div class="col-md-3 col-lg-3 col-xl-2">
            <img src="{{ asset('gallery/gallery10.jpeg')}}" alt="..." class="gallery-item">
        </div>
        <div class="col-md-3 col-lg-3 col-xl-2">
            <img src="{{ asset('gallery/gallery11.jpeg')}}" alt="..." class="gallery-item">
        </div>
        <div class="col-md-3 col-lg-3 col-xl-2">
            <img src="{{ asset('gallery/gallery12.jpeg')}}" alt="..." class="gallery-item">
        </div>
        <div class="col-md-3 col-lg-3 col-xl-2">
            <img src="{{ asset('gallery/gallery13.jpeg')}}" alt="..." class="gallery-item">
        </div>
        <div class="col-md-3 col-lg-3 col-xl-2">
            <img src="{{ asset('gallery/gallery14.jpeg')}}" alt="..." class="gallery-item">
        </div>
        <div class="col-md-3 col-lg-3 col-xl-2">
           <img src="{{ asset('gallery/gallery15.jpeg')}}" alt="..." class="gallery-item">
        </div>
        <div class="col-md-3 col-lg-3 col-xl-2">
            <img src="{{ asset('gallery/gallery16.jpeg')}}" alt="..." class="gallery-item">
        </div>
        <div class="col-md-3 col-lg-3 col-xl-2">
            <img src="{{ asset('gallery/gallery17.jpeg')}}" alt="..." class="gallery-item">
        </div>
        <div class="col-md-3 col-lg-3 col-xl-2">
            <img src="{{ asset('gallery/gallery18.jpeg')}}" alt="..." class="gallery-item">
        </div>

        </div>
    </div>
    </div>
  </div>
</section>


<!-- <section  class="testimonials text-center py-4 mb-5">
<div class="container">
<h2 class="fs-3 fw-bold text-center mb-5 pb-5"> <span data-hi="प्रशंसापत्र" data-en="Testimonials"></span> </h2>
  <div class="row">
    <div class="col-md-6 col-lg-3">
      <div class="card border-light bg-white text-center">
        <div class="profile-img">
        <img src="https://maitriupldb.in/assets/images/niraj-ceo.jpeg" alt="...">
        </div>
        <h6> <span data-hi="डॉ. नीरज गुप्ता" data-en="Dr. Neeraj Gupta"></span> </h6>
        <div class="card-body blockquote">
          <p class="card-text">
          <span data-hi="लोरेम इप्सम डोलर, सिट अमेट कंसेक्टेचर एडिपिसिसिंग एलीट। वह यहां सत्य का लालच करते हुए, बिना किसी आरोप के, बिना किसी भगोड़े के, आत्मा को एक अधूरे, लगभग एक ही उपनाम से पुकारता है। वोलुप्तस!" data-en=" Lorem ipsum dolor, sit amet consectetur adipisicing elit. A deserunt hic cupiditate veritatis, ad accusantium sit nesciunt laudantium nisi fugit, animi modi est asperiores odio assumenda, quasi dicta alias. Voluptas!"></span>
         </p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="card border-light bg-white text-center">
        <div class="profile-img">
        <img src="https://maitriupldb.in/assets/images/niraj-ceo.jpeg" alt="...">
        </div>
        <h6><span data-hi="डॉ. नीरज गुप्ता" data-en="Dr. Neeraj Gupta"></span></h6>
        <div class="card-body blockquote">
          <p class="card-text">  <span data-hi="लोरेम इप्सम डोलर, सिट अमेट कंसेक्टेचर एडिपिसिसिंग एलीट। वह यहां सत्य का लालच करते हुए, बिना किसी आरोप के, बिना किसी भगोड़े के, आत्मा को एक अधूरे, लगभग एक ही उपनाम से पुकारता है। वोलुप्तस!" data-en=" Lorem ipsum dolor, sit amet consectetur adipisicing elit. A deserunt hic cupiditate veritatis, ad accusantium sit nesciunt laudantium nisi fugit, animi modi est asperiores odio assumenda, quasi dicta alias. Voluptas!"></span></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="card border-light bg-white text-center">
        <div class="profile-img">
        <img src="https://maitriupldb.in/assets/images/niraj-ceo.jpeg" alt="...">
        </div>
        <h6><span data-hi="डॉ. नीरज गुप्ता" data-en="Dr. Neeraj Gupta"></span></h6>
        <div class="card-body blockquote">
          <p class="card-text">  <span data-hi="लोरेम इप्सम डोलर, सिट अमेट कंसेक्टेचर एडिपिसिसिंग एलीट। वह यहां सत्य का लालच करते हुए, बिना किसी आरोप के, बिना किसी भगोड़े के, आत्मा को एक अधूरे, लगभग एक ही उपनाम से पुकारता है। वोलुप्तस!" data-en=" Lorem ipsum dolor, sit amet consectetur adipisicing elit. A deserunt hic cupiditate veritatis, ad accusantium sit nesciunt laudantium nisi fugit, animi modi est asperiores odio assumenda, quasi dicta alias. Voluptas!"></span></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="card border-light bg-white text-center">
        <div class="profile-img">
        <img src="https://maitriupldb.in/assets/images/niraj-ceo.jpeg" alt="...">
        </div>
        <h6><span data-hi="डॉ. नीरज गुप्ता" data-en="Dr. Neeraj Gupta"></span></h6>
        <div class="card-body blockquote">
          <p class="card-text"><span data-hi="लोरेम इप्सम डोलर, सिट अमेट कंसेक्टेचर एडिपिसिसिंग एलीट। वह यहां सत्य का लालच करते हुए, बिना किसी आरोप के, बिना किसी भगोड़े के, आत्मा को एक अधूरे, लगभग एक ही उपनाम से पुकारता है। वोलुप्तस!" data-en=" Lorem ipsum dolor, sit amet consectetur adipisicing elit. A deserunt hic cupiditate veritatis, ad accusantium sit nesciunt laudantium nisi fugit, animi modi est asperiores odio assumenda, quasi dicta alias. Voluptas!"></span></p>
        </div>
      </div>
    </div>
  </div>
</div>
</section> -->




<script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
<script>
  // $('.counter').counterUp({
  //   delay: 10,
  //   time: 2000
  // });

  $(function(){
      $('.counter').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
            }
        });
      });
  });

  var swiper = new Swiper('.swiper-container', {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
</script>

<script>
  var swiper = new Swiper('.logo-swiper-container', {
    loop: true,
    autoplay: {
      delay: 2500, // Delay between transitions in milliseconds
      disableOnInteraction: false, // Continue autoplay even when user interacts with slider
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      640: {
        slidesPerView: 1,
        spaceBetween: 20,
      },
      768: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
      1024: {
        slidesPerView: 6,
        spaceBetween: 20,
      },
    },
  });
</script>

@endsection