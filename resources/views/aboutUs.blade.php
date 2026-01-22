<?php
$latest = App\Models\Latestupdate::whereStatus(1)->get();
?>
@extends('master')

@section('content')

<div class="container main-div my-4" style="background-color:#fff;">

    <h3 class="fw-bold mb-3 text-center">
        <span data-hi="बोर्ड के बारे में" data-en="About the Board"></span>
    </h3>

    <div class="card mb-4">
        <div class="card-header text-white fw-bold" style="background:#f36c21;">
            <span data-hi="बोर्ड के बारे में" data-en="About the Board"></span>
        </div>

        <div class="card-body" style="font-size:14px; text-align:justify; line-height:1.6;">

            <p>
                <span data-en="U.P. Government established Uttar Pradesh Livestock Development Board via G.O. no. 3991/12 Pa-2-98-1(20)/98, Dt. 31st October, 1998 and was registered under the Societies Registration Act 1860, Rule 21 of 1860 with the registration no. 2342/1998-99, Dt. 07.01.1999, which has now been renewed up to 07th January, 2029. Govt. of India had issued terms & conditions governing sanction No. 3-15/97-AHT, Dt. 03rd March, 1998 for implementation of Centrally Sponsored Scheme of Extension of Frozen Semen Technology (EFST) and National Bull Production Programme (NBPP) for Cattle and Buffalo Breeding during 1997-98. In this sanction there was a provision for creation of a State Level Autonomous Body, which was to be the incharge of Semen and liquid nitrogen production/procurement and sale to all agencies incharge of artificial insemination. This Body was to be formed under Societies' Registration Act or Company registered under Companies Act. The Board is an autonomous body, being governed by the Board of Directors with Additional Chief Secretary / Principal Secretary, Animal Husbandry as the Chairman. It is headed by the Chief Executive Officer, and has a core group of professionals and limited supporting staff deployed from Animal Husbandry Department for State Implementing Agency (SIA). The basic aim of the Board is to restructure and reorient the cattle and buffalo breeding operations in the State."
                      data-hi="उत्तर प्रदेश सरकार ने शासनादेश संख्या 3991/12 पा-2-98-1(20)/98, दिनांक 31 अक्टूबर, 1998 के माध्यम से उत्तर प्रदेश पशुधन विकास परिषद की स्थापना की और इसे सोसाइटी पंजीकरण अधिनियम 1860, नियम 21 के तहत पंजीकरण संख्या 2342/1998-99, दिनांक 07.01.1999 के साथ पंजीकृत किया गया था, जिसे अब 07 जनवरी, 2029 तक नवीनीकृत किया गया है। भारत सरकार ने 1997-98 के दौरान गाय और भैंस प्रजनन के लिए फ्रोजन सीमेन टेक्नोलॉजी (EFST) और नेशनल बुल प्रोडक्शन प्रोग्राम (NBPP) के कार्यान्वयन के लिए नियम और शर्तें जारी की थीं। इस मंजूरी में एक राज्य स्तरीय स्वायत्त निकाय के निर्माण का प्रावधान था, जो कृत्रिम गर्भाधान की सभी एजेंसियों को वीर्य और तरल नाइट्रोजन उत्पादन/खरीद और बिक्री का प्रभारी होगा।"></span>
            </p>

            <p>
                <span data-en="The UPLDB is working in collaboration with State Animal Husbandry Department and also in co-ordination with other agencies performing cattle and buffalo breeding activities in the State, like: Pradeshik Cooperative Dairy Federation (PCDF), Bhartiya Agro Industrial Foundation Limited (BAIF), State Agricultural Universities (SAU's), State Veterinary University, Indian Veterinary Research Institute (IVRI), and ICAR institutes, etc. along with other related State departments, like Department of Rural Development. This agency (SIA) is a viable entity, generating funds for meeting its establishment and other costs to keep it operational. It was the mandate of the Govt. of India that Transfer of Assets available in the form of Sperm Stations, Training Centers, State Livestock Farms, etc. from A. H. department and like-wise agencies shall be transferred completely to the Board/SIA. The SIA Head Quarters is managed by a core group of professionals and limited supporting staff to maintain the establishment cost of SIA to the barest minimum. A similar approach has been adopted by the SIA while engaging personnel in the field units. Initially the personnel are drawn from the State Department of Animal Husbandry. If suitable man power is not available, recruitment from extra departmental sources has been considered to keep the SIA functioning."
                      data-hi="यू.पी.एल.डी.बी. राज्य पशुपालन विभाग के सहयोग से और राज्य में गाय और भैंस प्रजनन गतिविधियों को करने वाली अन्य एजेंसियों जैसे: प्रादेशिक को-ऑपरेटिव डेयरी फेडरेशन (PCDF), भारतीय एग्रो इंडस्ट्रियल फाउंडेशन लिमिटेड (BAIF), राज्य कृषि विश्वविद्यालयों (SAU's), राज्य पशु चिकित्सा विश्वविद्यालय, भारतीय पशु चिकित्सा अनुसंधान संस्थान (IVRI), और ICAR संस्थानों आदि के साथ-साथ ग्रामीण विकास विभाग जैसे अन्य संबंधित राज्य विभागों के समन्वय में काम कर रहा है।"></span>
            </p>

            <p>
                <span data-en="This has ensured that there is proportionate reduction of manpower in the department while engaging of adequate qualified personnel in the SIA. The basic aim of the Board is to restructure and reorient the cattle and buffalo breeding operations in the State."
                      data-hi="इसने विभाग में जनशक्ति की आनुपातिक कमी सुनिश्चित की है जबकि SIA में पर्याप्त योग्य कर्मियों को शामिल किया गया है। बोर्ड का मूल उद्देश्य राज्य में गाय और भैंस प्रजनन कार्यों का पुनर्गठन और पुनर्विन्यास करना है।"></span>
            </p>

        </div>
    </div>

    <div class="row">

        <div class="col-md-7">
            <div class="card mb-4 h-100">
                <div class="card-header text-white fw-bold" style="background:#f36c21;">
                    <span data-hi="हमारा मिशन और उद्देश्य" data-en="OUR MISSION & OBJECTIVES"></span>
                </div>

                <div class="card-body" style="font-size:14px;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0 ps-0">
                            <i class="fa fa-check-circle text-success me-2"></i>
                            <span data-en="To cover all breedable bovines under organized breeding network."
                                  data-hi="सभी प्रजनन योग्य गौवंश को संगठित प्रजनन नेटवर्क के अंतर्गत लाना।"></span>
                        </li>
                        <li class="list-group-item border-0 ps-0">
                            <i class="fa fa-check-circle text-success me-2"></i>
                            <span data-en="To maintain quality breeding inputs and services."
                                  data-hi="गुणवत्तापूर्ण प्रजनन इनपुट और सेवाएं बनाए रखना।"></span>
                        </li>
                        <li class="list-group-item border-0 ps-0">
                            <i class="fa fa-check-circle text-success me-2"></i>
                            <span data-en="To conserve and develop indigenous breeds."
                                  data-hi="स्वदेशी नस्लों का संरक्षण और विकास करना।"></span>
                        </li>
                        <li class="list-group-item border-0 ps-0">
                            <i class="fa fa-check-circle text-success me-2"></i>
                            <span data-en="To ensure implementation of the State Breeding Policy in cattle and buffalo."
                                  data-hi="गाय और भैंस में राज्य प्रजनन नीति का कार्यान्वयन सुनिश्चित करना।"></span>
                        </li>
                        <li class="list-group-item border-0 ps-0">
                            <i class="fa fa-check-circle text-success me-2"></i>
                            <span data-en="To develop synergies with and ensure participation of all the concerned agencies."
                                  data-hi="सभी संबंधित एजेंसियों के साथ तालमेल विकसित करना और भागीदारी सुनिश्चित करना।"></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card mb-4 ">
                <div class="card-header text-white fw-bold" style="background:#f36c21;">
                    <span data-hi="नयी जानकारियाँ" data-en="Latest News"></span>
                </div>

                <div class="card-body" style="font-size:13px;">
                    <ul class="ps-3">
                        <marquee class="marqu1" onmouseover="stop()" onmouseout="start()" direction="up" scrolldelay="250">
                        <ul class="notice--list">
                            @if($latest)
                            @foreach($latest as $val)
                            <li><a href="{{$val->url}} " target="_blank"> {{$val->title}} </a> </li>
                            @endforeach
                            @endif
                        </ul>
                    </marquee>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection