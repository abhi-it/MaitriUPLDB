@extends('master')
@section('content')

<style>
    .event-details .event-details_cards .gangatiri {
        width: 23.5%;
    }

    .event-details .event-details_cards .gangatiri .count-number {
        position: absolute;
        font-size: 1.4rem;
        font-weight: 600;
        background-color: #f93;
        left: 1rem;
        top: 1rem;
        border-radius: 50%;
        width: 35px;
        color: #fff;
        text-align: center;
        height: 35px;
    }

    .event-details .event-details_cards .gangatiri img {
        border-radius: .5rem;
    }

    .event-details h3 {
        color: orange;
        margin-bottom: 1rem;
    }

    .event-details h2 {
        color: #555;
    }
</style>

<div class="container main-div" style="background-color:white;">
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
    @if(session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
    @endif
    <section class=" m-5 pb-5 event-details">
        <h2 class="text-center">
        <span data-hi="नवीनतम समाचार और घटनाएँ" data-en="LATEST NEWS AND EVENTS">  </span>
       </h2>
        <div class="my-lg-5 my-md-4 my-3">
            <h3 class="text-center">
                <span data-hi="मुजफ्फरनगर चीयर्स - गोवंश का आशीर्वाद मिला! दो स्वस्थ बछिया (मादा बछड़े)
                    मैत्री की मदद से स्थानीय किसानों द्वारा स्वागत किया गया।" data-en="Muzaffarnagar Cheers - Got Bovine Blessings! Two Healthy Heifers (Female Calves)
                Welcomed by Local Farmers with MAITRI's Help.">  </span>
             </h3>
            <div>
                <div class="event-details_cards d-flex  align-items-center flex-wrap gap-4 ">
                    <div class="position-relative gangatiri"><span class="count-number">1</span>
                        <img src="{{ asset('assets/images/home-ne2.jpeg')}}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        <div class="my-lg-5 my-md-4 my-3">
            <h3 class="text-center">
            <span data-hi="यूपी पशुधन बोर्ड ने डेयरी विकास के 25 वर्षों पर प्रकाश डाला। नस्ल संरक्षण केंद्रों और सेक्स्ड-सीमेन तकनीक में निवेश किया। दूध उत्पादन और किसानों की आय में वृद्धि हुई। बछिया शक्ति केंद्र में!" data-en=" UP Livestock Board Highlights 25 Years of Dairy Development. Invests in Breed   Conservation Centers &amp; Sexed-Semen Technology. Boosts Milk Production and Farmer Income. Heifer   Power Takes Center Stage!">  </span>    
           </h3>
            <div>
                <div class="event-details_cards d-flex  align-items-center flex-wrap gap-4 ">
                    <div class="position-relative gangatiri"><span class="count-number">1</span>
                        <img src="{{ asset('assets/images/home-ne1.jpeg')}}" alt="" class="img-fluid">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="my-lg-5 my-md-4 my-3">
            <h3 class="text-center">
                 <span data-hi="मैत्री ए.आई. तकनीशियन राम मोहन ने किसान ओम प्रकाश को गोजातीय आशीर्वाद देकर सशक्त बनाया तथा वाराणसी के मीरावन में  स्वस्थ बछिया का स्वागत किया। ए.आई. अपनाएँ, गौरव बढ़ाएँ!" data-en="MAITRI AI Technician Ram Mohan Empowers Farmer Om Prakash with Bovine Blessing welcomes Healthy Heifer in Mirawan, Varanasi. Adopt AI, Amplify Pride!">  </span>
            </h3>
            <div>
                <div class="event-details_cards d-flex  align-items-center flex-wrap gap-4 ">
                    <div class="position-relative gangatiri"><span class="count-number">1</span>
                    <img src="{{ asset('assets/images/news1.jpeg')}}" alt="" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="my-lg-5 my-md-4 my-3">
            <h3 class="text-center">
                <span data-hi="पशुपालकों के लिए संजीवनी: पं. दीनदयाल उपाध्याय पशु आरोग्य शिविर/मेला का आयोजन 15 जनवरी 2024 को लखनऊ में किया गया। पशुओं की उत्पादकता बढ़ाने तथा किसानों की आय में वृद्धि करने के लिए।" data-en="Sanjivani for cattle rearers: Pt. Deendayal Upadhyay's largest animal health camp/fair was organized in Lucknow on 15 January 2024. To increase the productivity of animals and increase the income of farmers.">  </span>
            </h3>
            <div>
                <div class="event-details_cards d-flex  align-items-center flex-wrap gap-4 ">
                    <div class="position-relative gangatiri"><span class="count-number">1</span>
                    <img src="{{ asset('assets/images/sanjivani-cattle1.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">2</span>
                    <img src="{{ asset('assets/images/sanjivani-cattle2.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">3</span>
                    <img src="{{ asset('assets/images/sanjivani-cattle3.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">4</span>
                    <img src="{{ asset('assets/images/sanjivani-cattle4.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">5</span>
                    <img src="{{ asset('assets/images/sanjivani-cattle5.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">6</span>
                    <img src="{{ asset('assets/images/sanjivani-cattle6.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">7</span>
                    <img src="{{ asset('assets/images/sanjivani-cattle7.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">8</span>
                    <img src="{{ asset('assets/images/sanjivani-cattle8.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">9</span>
                    <img src="{{ asset('assets/images/sanjivani-cattle9.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">10</span><img
                            src="{{ asset('assets/images/sanjivani-cattle10.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">11</span><img
                            src="{{ asset('assets/images/sanjivani-cattle11.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">12</span>
                    <img src="{{ asset('assets/images/sanjivani-cattle12.jpeg')}}" alt=""
                            class="img-fluid"></div>
                </div>
            </div>
        </div>
        <div class="my-lg-5 my-md-4 my-3">
            <h3 class="text-center"> 
                <span data-hi="उत्तर प्रदेश पशुधन विकास बोर्ड (यूपीएलडीबी) द्वारा पशु उत्थान वर्णसंकर केंद्र, मुड़िया मुकर्रमपुर गांव, बहेड़ी तहसील, जिला बरेली में मैत्री प्रशिक्षण आयोजित किया गया।" data-en="MAITRI Training at Pashu Utthan Varnsankar Kendra, Mudiya Mukarrampur Village, Bahedi Tehsil, Bareilly District organized by Uttar Pradesh Livestock Development Board(UPLDB).">  </span>    
            </h3>
            <div>
                <div class="event-details_cards d-flex  align-items-center flex-wrap gap-4 ">
                    <div class="position-relative gangatiri"><span class="count-number">1</span>
                    <img src="{{ asset('assets/images/maitri-training1.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">2</span>
                    <img src="{{ asset('assets/images/maitri-training2.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">3</span>
                    <img src="{{ asset('assets/images/maitri-training3.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">4</span>
                    <img src="{{ asset('assets/images/maitri-training4.jpeg')}}" alt=""
                            class="img-fluid"></div>
                </div>
            </div>
        </div>
        <div class="my-lg-5 my-md-4 my-3">
            <h3 class="text-center">
                <span data-hi="रायबरेली के बैलों को मिला तकनीकी उन्नयन! स्वस्थ और खुशहाल पशुधन के लिए AI-संचालित गर्भाधान। सेक्स सॉर्टेड आर्टिफिशियल इनसेमिनेशन के साथ पशुधन प्रजनन के भविष्य का अनावरण।" data-en="Rae Bareli's Bulls Get a Tech Upgrade! AI-powered insemination for healthier, happier livestock. Unveiling the future of Livestock breeding with Sex Sorted Artificial Insemination.">  </span>    
            </h3>
            <div>
                <div class="event-details_cards d-flex  align-items-center flex-wrap gap-4 ">
                    <div class="position-relative gangatiri"><span class="count-number">1</span>
                    <img src="{{ asset('assets/images/rea-bareli-gate1.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">2</span>
                    <img src="{{ asset('assets/images/rea-bareli-gate2.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">3</span>
                    <img src="{{ asset('assets/images/rea-bareli-gate3.jpeg')}}" alt=""
                            class="img-fluid"></div>
                </div>
            </div>
        </div>
        <div class="my-lg-5 my-md-4 my-3">
            <h3 class="text-center">
                <span data-hi="बहुत बढ़िया! मऊ को AI की मदद से हाई-टेक मिला, पशुओं के चारे से क्रांति को बढ़ावा मिला, गोजातीय आशीर्वाद!" data-en="Udderly Brilliant! Mau Gets High-Tech with AI Livestock Feeding Boosts Revolution  Bovine Blessing!">  </span>    
            
            </h3>
            <div>
                <div class="event-details_cards d-flex  align-items-center flex-wrap gap-4 ">
                    <div class="position-relative gangatiri"><span class="count-number">1</span>
                    <img src="{{ asset('assets/images/udderly1.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">2</span>
                    <img src="{{ asset('assets/images/udderly2.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">3</span>
                    <img src="{{ asset('assets/images/udderly3.jpeg')}}" alt=""
                            class="img-fluid"></div>
                </div>
            </div>
        </div>
        <div class="my-lg-5 my-md-4 my-3">
            <h3 class="text-center">
                <span data-hi="यूपीएलडीबी का रजत जयंती वर्ष #मैत्री मिशन के साथ ग्रामीण सपनों के निर्माण के 25 वर्षों का जश्न मनाता है, युवाओं को सशक्त बनाता है, दूध उत्पादन को बढ़ाता है!" data-en=" UPLDB's Silver Jubilee Year Celebrates 25 Years of Building Rural Dreams with #MAITRI Mission, Empowers Youth, Boosts Milk Yields!">  </span>        
           </h3>
            <div>
                <div class="event-details_cards d-flex  align-items-center flex-wrap gap-4 ">
                    <div class="position-relative gangatiri"><span class="count-number">1</span>
                    <img src="{{ asset('assets/images/upldb-silver5.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">2</span>
                    <img src="{{ asset('assets/images/upldb-silver2.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">3</span>
                    <img src="{{ asset('assets/images/upldb-silver3.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">4</span>
                    <img src="{{ asset('assets/images/upldb-silver4.jpeg')}}" alt=""
                            class="img-fluid"></div>
                    <div class="position-relative gangatiri"><span class="count-number">5</span>
                    <img src="{{ asset('assets/images/upldb-silver1.jpeg')}}" alt=""
                            class="img-fluid"></div>
                </div>
            </div>
        </div>
    </section>





</div>
@endsection