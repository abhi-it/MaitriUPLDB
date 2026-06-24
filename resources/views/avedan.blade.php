@extends('master')
@section('content')
    <style>
        * {
            box-sizing: border-box;
        }

        .tab {
            display: none;
            width: 100%;
            height: 50%;
            margin: 0px auto;
        }

        .current {
            display: block;
        }

        .buttonWizard {
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 17px;
            font-family: inherit;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }

        .previous {
            background-color: #bbbbbb;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 36px;
            width: 36px;
            cursor: pointer;
            margin: 10px 15px;
            color: #fff;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.8;
            padding: 10px;
        }

        .step.active {
            opacity: 1;
            background-color: #69c769;
        }

        .step.finish {
            background-color: #4CAF50;
        }

        .error {
            color: #f00;
        }
    </style>
    <script src="{{ asset('') }}js/google_Jsapi.js" type="text/javascript"></script>
    <script type="text/javascript">
        // Load the Google Transliterate API
        google.load("elements", "1", {
            packages: "transliteration"
        });

        function onLoad() {
            var options = {
                sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
                destinationLanguage: [google.elements.transliteration.LanguageCode.HINDI],
                shortcutKey: 'ctrl+g',
                transliterationEnabled: true
            };

            // Create an instance on TransliterationControl with the required
            // options.
            var control =
                new google.elements.transliteration.TransliterationControl(options);

            // Enable transliteration in the textbox with id
            // 'transliterateTextarea'.
            control.makeTransliteratable(
                [
                    'applicant_name',
                    'fname',
                    'mother',
                    'permanent_address',
                    'vikas_khand',
                    'high_board_name',
                    'inter_board_name',
                    'graduation_board_name',
                    'postgraduation_board_name',
                    'yojna_name_for_training',
                ]);
        }
        google.setOnLoadCallback(onLoad);
    </script>


    <style>
        .scroll-left {
            height: 50px;
            overflow: hidden;
            position: relative;
            background: #fff;
            color: #000;
            border: 0px solid orange;
        }

        .scroll-left p {
            position: absolute;
            font-size: 18px;
            font-weight: bold;
            width: 100%;
            height: 100%;
            margin: 0;
            line-height: 50px;
            text-align: center;
            /* Starting position */
            transform: translateX(100%);
            /* Apply animation to this element */
            animation: scroll-left 20s linear infinite;
        }

        /* Move it (define the animation) */
        @keyframes scroll-left {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    </style>

    <div class="container main-div">
        <!--First row Start -->
        <!--div class="scroll-left"><p>अभ्यर्थी का जनपद निवासी होना अनिवार्य है</p>
                     </div-->
        <marquee width="100%" direction="left" height="25px" style="font-size : 18px;font-weight: bold;">
        <span data-hi=" अभ्यर्थी को उत्तर प्रदेश के उस जनपद का निवासी होना अनिवार्य है , जिस जनपद के लिए आवेदन किया जा रहा है ।" data-en="It is mandatory for the candidate to be a resident of the district of Uttar Pradesh for which the application is being made."></span>
        
       </marquee>
       <h3 class="text-center fw-bold m-4"> <span data-hi="आवेदन - पत्र" data-en="Application Form"></span> </h3>
        @if (session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
        @endif
        <form method="post" action="{{ route('application-form.store') }}" id="myForm" enctype="multipart/form-data">
            @csrf
            <!-- Circles which indicates the steps of the form: -->
            <div style="text-align:center;margin-top:40px;">
                <span class="step">1 </span>
                <h3 style="display:inline;font-size: 18px;"><span data-hi="नियम और शर्तें" data-en="Terms and conditions"></span> </h3>
                <span class="step">2 </span>
                <h3 style="display:inline;font-size: 18px;">
                <span data-hi="आवेदक का विवरण" data-en="Applicant details"></span>    
                </h3>
                <span class="step">3 </span>
                <h3 style="display:inline;font-size: 18px;">
                <span data-hi="शैक्षिक योग्यता व अन्य विवरण" data-en="Educational Qualification and other details"></span>        
                </h3>
                <span class="step">4 </span>
                <h3 style="display:inline;font-size: 18px;">
                <span data-hi="आवेदक का बैंक विवरण" data-en="Applicant Bank Details"></span>        
                </h3>
                <span class="step">5 </span>
                <h3 style="display:inline;font-size: 18px;">  <span data-hi="सारांश" data-en="Summary"></span>    
                </h3>
            </div>
            <hr>

            <div class="tab">
                <!-- <h3><span data-hi="नियम एवं शर्तें" data-en="Terms and conditions"></span>      </h3> -->
                <div class="row">

                    <div class="form-group col-md-12" style="font-size: 16px;">
<!-- 
                    <iframe src="{{ asset('documents/terms-and-conditions-2025-09-02.pdf') }}" 
                            width="100%" 
                            height="800px" 
                            style="border:none;">
                    </iframe> -->

                    <div id="pdf-container" style="width:100%; padding-bottom:20px;">
    <div id="pdf-viewer" style="display:flex; justify-content:center;"></div>
</div>

<!-- Checkbox below PDF -->
<div style="margin-top:10px; text-align:center;">
 <span class="text-danger">*</span>
 <span data-hi=" अगर आप सहमत हैं तो चिन्हित करें" data-en=" Mark if you agree"> </span> </label>
                        <input type="checkbox" name="tc" id="tc" {{ $result->t_and_c == '1' ? 'checked' : '' }}value="1"><label for="inputEmail4"> 
                             
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    const url = "{{ asset('documents/terms_n_condition.pdf') }}";

    const loadingTask = pdfjsLib.getDocument(url);
    loadingTask.promise.then(function(pdf) {
        pdf.getPage(1).then(function(page) {
            const scale = 0.6; // 🔎 80% zoom
            const viewport = page.getViewport({ scale: scale });

            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            document.getElementById('pdf-viewer').appendChild(canvas);

            const renderContext = {
                canvasContext: context,
                viewport: viewport
            };
            page.render(renderContext);

            // ✅ Adjust container height so PDF fits neatly
            document.getElementById('pdf-container').style.height = (viewport.height + 40) + "px"; 
        });
    });
</script>


                        <!-- <h5><b>
                        <span data-hi="राष्ट्रीय गोकुल मिशन अन्तर्गत कृत्रिम गर्भाधान आच्छादन बढ़ाने हेतु स्वरोजगारी मैत्री की
                                    स्थापना नियम-शर्तें निम्न प्रकार हैं-" data-en="To increase the artificial insemination coverage under National Gokul Mission, the rules and conditions for setting up Swarojgari Maitri are as follows-"></span></b></h5>
                        <br><b>1:- <span data-hi="योग्यता" data-en="Ability"></span>   : </b><br>

                        <b>(क) </b> <span data-hi="शैक्षिक योग्यता: अनिवार्य  न्यूनतम अर्हता हाईस्कूल (विज्ञान वर्ग ) उत्तीर्ण हो, इण्टर को वरीयता दी जायेगी।" data-en="Educational Qualification: Mandatory minimum qualification is passing high school (science stream), preference will be given to intermediate."></span>  <br>
                        <b>(ख) </b>  <span data-hi="आवेदक चयनित क्षेत्र की ग्राम पंचायत का निवासी हो एवं उसके पास स्वयं का दो पहिया वाहन हो। " data-en="The applicant should be a resident of the village panchayat of the selected area and should have his own two wheeler."></span>   <br>
                        <b>(ग) </b> <span data-hi="पूर्णतः स्वस्थ एवं कार्य  करने के योग्य हो। पशुपालक के द्वार पर पहुँच कर सेवा कर सके। " data-en="Should be completely healthy and capable of working. Should be able to reach the door of the animal keeper and serve him."></span>  <br>
                        <b>(घ) </b><span data-hi="राजकीय चिकित्साधिकारी द्वारा प्रदत्त स्वास्थ्य प्रमाण-पत्र अपलोड करना अनिवार्य है। वोटर आई.डी. कार्ड/आधार कार्ड/पैन कार्ड आदि अन्य फोटो युक्त आई.डी. जो निर्वाचन आयोग से अनुमन्य है अपलोड करना अनिवार्य  है। " data-en="It is mandatory to upload the health certificate issued by the government medical officer. It is mandatory to upload voter ID card/Aadhar card/PAN card etc. or other photo ID which is approved by the Election Commission."></span>
                         <br>
                        <b>(ड) </b><span data-hi="मैत्री चयन हेतु निर्धारित मानक के अनुसार यदि दो या दो से अधिक अभ्यर्थियों के कुल प्राप्त अंकों में समानता हो तो प्रथम दृष्टया प्रवासी श्रमिकों/पशु सखी/पैरावेट (जो वर्तमान में पशुचिकित्सा अधिकारी की देख-रेख में कार्य कर रहा हो) अभ्यर्थी को, तत्पश्चात् अधिक उम्र के अभ्यर्थी को वरीयता दी जायगेी।" data-en="As per the standard set for Maitri selection, if there is equality in the total marks obtained by two or more candidates, then preference will be given firstly to the migrant labourer/pashu sakhi/paravet (who is currently working under the supervision of a veterinary officer) candidate, and then to the candidate of older age."></span> 
                       <br>
                        <b>2:-</b> <span data-hi="आवेदक की आयु दिनांक 01.08.2024 को 18 वर्ष हो।" data-en="TThe age of the applicant should be 18 years as on 01.08.2024."></span>  <br>
                        <b>3:-</b> <span data-hi="आवेदन पत्र जमा करने की अन्तिम तिथि:- 08.09.2024" data-en="Last date for submission of application form:- 08.09.2024"></span>
                        <br>
                        <b>4:-</b><span data-hi="यह योजना पूर्णतः स्वरोजगार सृजन की अवधारणा पर आधारित है। आवेदक को किसी भी स्थिति में शासकीय सेवा में संविलियन का कोई अधिकार नहीं होगा। चयनित अभ्यर्थियों को 30 दिनों का सैद्धांतिक प्रशिक्षण (कार्य दिवस) और 60 दिनों का व्यावहारिक प्रशिक्षण कराया जाएगा। चयनित अभ्यर्थियों को सफलतापूर्वक प्रशिक्षण पूर्ण करने के उपरांत मित्र (मल्टी परपज ए.आई. टेक्निशियन इन रूरल इंडिया) के रूप में कार्य करने हेतु प्रमाण-पत्र, प्रशिक्षण केन्द्र द्वारा उपलब्ध कराई गई आई.डी. (प्रशिक्षण केन्द्र की आई.डी.), भारत पशुधन आई.डी. और उपकरण (ए.आई. किट, कास्ट्रेटर, बायोलॉजिकल क्रायोकंटेनर-3 लीटर) उपलब्ध कराए जाएंगे।" data-en="This scheme is completely based on the concept of self-employment generation. The applicant will not have any right to absorption in government service under any circumstances. The selected candidates will be given 30 days of theoretical training (working days) and 60 days of practical training. After successful completion of training, the selected candidates will be provided a certificate to work as MITRA (Multi Purpose AI Technician in Rural India), ID provided by the Training Center (ID of Training Center), Bharat Pashudhan ID and equipment (AI Kit, Castrator, Biological Cryocontainer-3 liters)."></span>  <br>
                        <b>5:-</b><span data-hi="समस्त मैत्री को स्थापना के बाद उनसे संबंधित ए.आई. केन्द्र पर उनकी मांग के अनुसार कृत्रिम गर्भाधान संबंधी समस्त संसाधन समय पर उपलब्ध कराए जाएंगे। साथ ही, दिए गए इन संसाधनों का मुख्यालय द्वारा अनुश्रवण भी किया जाएगा।" data-en="After establishment of all Maitri, all the resources related to artificial insemination will be made available on time as per their demand at their respective AI centers. Also, these resources will be monitored by the headquarters."></span>   <br>
                        <b>6:- </b> <span style="color:#000;font-weight:600; "> <span data-hi="चयनित अभ्यर्थियों को चयन के बाद इस आशय का शपथ-पत्र देना होगा कि वे एक स्वरोजगारी के रूप में कार्य करेंगे। सरकारी सेवा में किसी भी स्थिति में संविलियन का कोई अधिकार नहीं होगा और इसके लिए कभी दावा नहीं करेंगे।" data-en="After selection, the selected candidates will have to give an affidavit to the effect that they will work as a self-employed person. They will not have any right to absorption in government service under any circumstances and will never claim for it." ></span> </span><br>
                        <b>7:- </b> <span data-hi="मैत्री का कार्य प्रारम्भ करने की तिथि से 5 वर्ष की अवधि के पूर्व कार्य बंद कर देने की अवस्था में प्रशिक्षण की अवधि में योजनान्तर्गत व्यय की गई धनराशि तथा समस्त उपकरण सही अवस्था में वापस करने के लिए वचनबद्ध रहेंगे। मुख्यालय द्वारा जनपद स्तर पर उनके द्वारा किए गए कार्य की समीक्षा की जाएगी और अनियमितता पाए जाने पर कार्यवाही की जाएगी। कृत्रिम गर्भाधान की मानक संचालन प्रक्रिया (SOP) के सापेक्ष कार्य न करने की दशा में मैत्री को उपलब्ध कराई गई भारत पशुधन आई.डी. से वंचित कर दिया जाएगा और उनके कार्य के सापेक्ष प्रोत्साहन राशि के लिए किया गया दावा मान्य नहीं होगा।" data-en="In case Maitri stops working before a period of 5 years from the date of starting of work, they will be committed to return the money spent under the scheme and all the equipment in good condition during the training period. The work done by them at the district level will be reviewed by the headquarters and action will be taken if any irregularity is found. In case of not working as per the standard operating procedure (SOP) of artificial insemination, Maitri will be deprived of the Bharat Pashudhan ID provided to her and the claim made for incentive amount for her work will not be valid."></span> <br>
                        <b>8:- </b> <span data-hi="चयन के उपरांत आवेदनकर्ता को सक्षम स्तर से जारी स्वास्थ्य प्रमाण-पत्र मुख्य पशु चिकित्साधिकारी कार्यालय में जमा कराना अनिवार्य होगा।" data-en="After selection, it will be mandatory for the applicant to submit the health certificate issued by the competent level in the Chief Veterinary Officer's office."></span> <br>

                        <b>9:- </b> <span style="color:Red"> <span data-hi="आवश्यक सूचना/अद्यतन जानकारी इस पोर्टल यू.आर.एल. https://maitriupldb.in/ पर ही उपलब्ध रहेगी। इस संबंध में पृथक से कोई भी सूचना नहीं दी जाएगी।" data-en="Necessary information/updated information will be available on this portal URL https://maitriupldb.in/ only. No separate information will be given in this regard."></span></span> <br>
                            
                        <b>10:- </b> <span data-hi="मैत्री द्वारा किए गए कृत्रिम गर्भाधान कार्य को भारत पशुधन पर अंकन के उपरांत डिजिटल डाटा को जनपदीय क्षेत्र में परिषद द्वारा सत्यापित करने के बाद प्रोत्साहन राशि दी जाएगी और मैत्री स्थापना हेतु एक वर्ष तक प्रति माह उन्हें टैपरिंग ग्रांट दिया जाएगा, जिसमें से 50 प्रतिशत धनराशि रोकी जाएगी, जिसे वर्ष के अंत में उनके कार्य प्रदर्शन पर ही दी जाएगी।" data-en="After marking the artificial insemination work done by Maitri on Bharat Pashudhan, incentive amount will be given after the digital data is verified by the council in the district area and they will be given a tapering grant every month for one year for establishing Maitri, out of which 50 percent of the amount will be withheld, which will be given only on their work performance at the end of the year."></span> <br>

                        <span style="color:Red">
                        <span data-hi="नोट :- उ.प्र. पशुधन विकास परिषद द्वारा जनपदवार चयन किए जाने वाले स्वरोजगारी मैत्री (मल्टी परपज ए.आई. टेक्निशियन इन रूरल इंडिया) की संख्या पोर्टल पर उपलब्ध है।" data-en="Note:- The number of self-employed Maitri (Multi Purpose AI Technician in Rural India) selected district-wise by the UP Pashudhan Vikas Parishad is available on the portal."></span>
                        </span> -->
                    </div>

                    <!-- <div class="form-group col-md-6">
                        <label for="inputEmail4"> <span data-hi="अगर आप सहमत हैं तो चिन्हित करें" data-en="Mark if you agree"> </span> </label> <span class="text-danger">*</span>
                        <input type="checkbox" name="tc" id="tc" {{ $result->t_and_c == '1' ? 'checked' : '' }}
                            value="1">
                    </div> -->

                </div>
            </div>

            <div class="tab">
             
                <h3><span data-hi="आवेदक का विवरण" data-en="Applicant's Details"> </span> </h3>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4"><span data-hi="आवेदक का नाम" data-en="Name of applicant"> </span>  </label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" name="applicant_name" id="applicant_name"
                            placeholder="आवेदक का नाम" autocomplete="off" value="{{ $result->applicant_name }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputPassword4"><span data-hi="पिता / पति का नाम" data-en="Father/Husband's Name"> </span>  </label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" id="fname" name="fname"
                            placeholder="पिता  / पति का नाम" autocomplete="off" value="{{ $result->fname }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputPassword4"><span data-hi="माता का नाम" data-en="Mother's name"> </span>   </label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" id="mother" name="mother" placeholder="माता का नाम"
                            autocomplete="off" value="{{ $result->mother }}">
                    </div>
  
                    <div class="form-group col-md-6">
                        <label for="inputEmail4"><span data-hi="लिंग" data-en="Gender"> </span>  </label> <span class="text-danger">*</span>
                        <select class="form-control" name="gender" id="gender">
                            <option value="">चुने</option>
                            <option value="पुरुष" {{ $result->gender == 'पुरुष' ? 'selected' : '' }}>पुरुष</option>
                            <option value="महिला" {{ $result->gender == 'महिला' ? 'selected' : '' }}>महिला</option>
                            <option value="ट्रांसजेंडर" {{ $result->gender == 'ट्रांसजेंडर' ? 'selected' : '' }}>
                                ट्रांसजेंडर
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-md-6" id="pashu_sakhi_field" style="display:none;">
                        <label for="inputEmail4"><span data-hi="पशु सखी/आजीविका सखी (एनआरएलएम)" data-en="पशु सखी/आजीविका सखी (एनआरएलएम)"> </span>  </label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pashu_sakhi" id="pashu_sakhi_yes" value="1" {{ $result->pashu_sakhi == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="pashu_sakhi_yes">
                                हाँ
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pashu_sakhi" id="pashu_sakhi_no" value="0" {{ $result->pashu_sakhi == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="pashu_sakhi_no">
                                नहीं
                            </label>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail4"><span data-hi="जन्म तिथि (हाई स्कूल प्रमाण-पत्र के अनुसार)" data-en="Date of Birth (As per High School Certificate)"> </span>  </label> 
                        <span class="text-danger">* 
                            <span data-hi="( न्यूनतम उम्र 18 वर्ष एवं अधिकतम 40 वर्ष होनी चाहिये )" data-en="(Minimum age should be 18 years and maximum age should be 40 years)"> </span> 
                        </span>
                        <?php
                       
                        if ($result->dob != '') {
                            $dob = date('d-m-Y', strtotime($result->dob));
                        } else {
                            $dob = '';
                        }
                        ?>
                        <input type="text" class="form-control" name="dob" id="dob" placeholder="जन्म तिथि"
                            readonly value="{{ $dob }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4"><span data-hi="पिछला आवेदन नंबर" data-en="Previous Avedan Number"> </span> </label>
                        <input type="text" class="form-control" name="previous_avedan_number" id="previous_avedan_number"
                            placeholder="पिछला आवेदन नंबर" autocomplete="off" value="{{ $result->previous_avedan_number }}">
                    </div>


                    <!-- <div class="form-group col-md-6">
                        <label for="inputEmail4"> <span data-hi="दूरभाष / मोबाइल नंबर" data-en="Telephone / Mobile Number"> </span> </label> <span class="text-danger">*</span>
                        <input maxlength="10" type="text" class="form-control" name="mobile" id="mobile"
                            placeholder="दूरभाष / मोबाइल नंबर" autocomplete="off" value="{{ $result->mobile }}"
                            onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                    </div> -->
                    
                    <!-- 29 Aug 2025 Add two field option -->
                    <div class="form-group col-md-6">
                        <label for="inputEmail4"> <span data-hi="प्राथमिक फोन नंबर" data-en="Primary Phone number"> </span> </label> <span class="text-danger">*</span>
                        <input maxlength="10" type="text" class="form-control" name="mobile" id="mobile"
                        placeholder="प्राथमिक फोन नंबर" autocomplete="off" value="{{ $result->mobile }}"
                        onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4"> <span data-hi="वैकल्पिक मोबाइल फोन संख्या" data-en="Alternate Mobile Phone Number"> </span> </label>
                        <input maxlength="10" type="text" class="form-control" name="alternet_mobile" id="alternet_mobile"
                        placeholder="वैकल्पिक मोबाइल फोन संख्या" autocomplete="off" value="{{ $result->alternet_mobile }}"
                        onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                    </div>
                    <!-- 29 Aug 2025 Add two field option End-->

                    <div class="form-group col-md-6">
                        <label for="inputEmail4"><span data-hi="श्रेणी" data-en="Category"> </span> </label> <span class="text-danger">*</span>
                        <select class="form-control" name="category" id="category">
                            <option value="">चुने</option>
                            <option value="जनरल" {{ $result->category == 'जनरल' ? 'selected' : '' }}>सामान्य (GENERAL)
                            </option>
                            <option value="ओ बी सी" {{ $result->category == 'ओ बी सी' ? 'selected' : '' }}>अन्य पिछड़ा वर्ग
                                (OBC)</option>
                            <option value="एस सी" {{ $result->category == 'एस सी' ? 'selected' : '' }}>अनुसूचित जाति (SC)
                            </option>
                            <option value="एस टी" {{ $result->category == 'एस टी' ? 'selected' : '' }}>अनुसूचित जनजाति
                                (ST)
                            </option>

                        </select>
                    </div>



                    <div class="form-group col-md-6">
                        <label for="inputPassword4"><span data-hi="स्थायी पता" data-en="Permanent Address"> </span>  </label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" name="permanent_address" id="permanent_address"
                            placeholder="स्थायी पता" autocomplete="off" value="{{ $result->permanent_address }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4"><span data-hi="स्थायी पते के प्रमाण-पत्र का प्रकार" data-en="Type of Permanent Address Certificate"> </span> </label> <span
                            class="text-danger">*</span>
                        <select class="form-control" name="address_type" id="address_type">
                            <option value="">चुने </option>
                            <option value="आधार कार्ड" {{ $result->address_type == 'आधार कार्ड' ? 'selected' : '' }}>आधार
                                कार्ड</option>
                            <option value="पासबुक कॉपी" {{ $result->address_type == 'पासबुक कॉपी' ? 'selected' : '' }}>
                                पासबुक कॉपी</option>
                            <option value="बिजली का बिल" {{ $result->address_type == 'बिजली का बिल' ? 'selected' : '' }}>
                                बिजली का बिल</option>
                            <option value="अन्य" {{ $result->address_type == 'अन्य' ? 'selected' : '' }}>अन्य</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4"><span data-hi="स्थायी पता के प्रमाण-पत्र संख्या " data-en="Permanent Address Certificate Number"> </span>  </label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" name="address_number" id="address_number"
                            placeholder="स्थायी पता के प्रमाण-पत्र संख्या" autocomplete="off" value="{{ $result->address_number }}">
                    </div>


                    <div class="form-group col-md-6">
                        <label for="inputPassword4"><span data-hi="स्थायी पता का प्रमाण-पत्र अपलोड करें " data-en="Upload Certificate of Permanent Address"> </span>
                       </label> <small
                            style="color:red;">Note: JPG, JPEG, PNG files only (Max. 2 MB)</small>
                        <input type="file" class="form-control" name="permanent_address_proof"
                            id="permanent_address_proof" autocomplete="off">
                    </div>


                    <!-- <div class="form-group col-md-6">
                        <label for="inputPassword4"><span data-hi="जनपद" data-en="Janpad"> </span> </label> <span class="text-danger">*</span>
                        <select class="form-control" name="janpad" id="janpad">
                            <option value="">जनपद चुनें </option>
                            @foreach ($districts as $row)
                                <option value="{{ $row->id }}"
                                    {{ $result->district_id == $row->id ? 'selected' : '' }}>{{ $row->name_hindi }}
                                </option>
                            @endforeach
                        </select>
                    </div> -->
                    <!--  {{ $result->district_id == $row->id ? 'selected' : '' }}-->
                       
                    <!-- Previous Code Comment -->
                    <!-- <div class="form-group col-md-6">
                        <label for="inputEmail4"> <span data-hi="ज़िला" data-en="District"></span> <span class="text-danger">*</span></label>
                        <select name="janpad" id="janpad" class="form-control" autofocus>
                            <option value="">जनपद चुनें </option>
                            @foreach ($districts as $row)
                                <option value="{{ $row->id }}">{{ $row->name_hindi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4"> <span data-hi="तहसील" data-en="Tehsil"></span> <span class="text-danger">*</span></label>
                        <select name="tehsil" id="tehsil" class="form-control" placeholder="तहसील" autofocus required>

                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4"> <span data-hi="विकास खण्ड" data-en="Vikas Khand"></span> <span class="text-danger">*</span></label>
                        <select name="vikas_khand" id="vikas_khand" class="form-control" required placeholder="विकास खण्ड"
                            autofocus>

                        </select>
                    </div> -->
                    <!-- Previous Code Comment -->
    
                    <!-- New code Here 02 Sep 2025 -->
                    <div class="form-group col-md-6">
                        <label for="janpad_name" class="form-label"><span data-hi="ज़िला" data-en="District"></span> <span class="text-danger">*</span></label>
                        <select class="form-select janpad_name" id="janpad_name" name="janpad">
                            <option value="" data-hi="जनपद चुनें" data-en="Select District"> </option>
                            @foreach ($districts as $row)
                                <option value="{{ $row->id }}" data-hindi_name="{{ $row->name_hindi }}">{{ $row->name_hindi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6" id="tehsil-wrapper">
                        <div id="tehsil-select-wrapper">
                            <label for=""><span data-hi="तहसील" data-en="Tehsil"></span></label>
                            <select class="form-select" id="tehsil" name="tehsil">
                                <option value="" data-hi="तहसील चुनें" data-en="Select Tehsil"></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6" id="block-wrapper">
                        <div id="block-select-wrapper">
                            <label for=""><span data-hi="विकास खण्ड" data-en="Vikas Khand"></span></label>
                            <select class="form-select block" id="vikas_khand" name="vikas_khand">
                                <option value="" data-hi="विकास खंड चुनें" data-en="Select Vikas Khand"></option>
                            </select>
                        </div>
                    </div>

                    <!-- New code Here 02 Sep 2025 -->


                    <!-- <div class="form-group col-md-6">
                        <label for="inputPassword4"><span data-hi="तहसील" data-en="Tehsil"> </span>  </label> <span class="text-danger">*</span>
                            <select class="form-control" name="tehsil" id="tehsil">
                               
                            </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail4"><span data-hi="विकास खण्ड" data-en="Vikas Khand"> </span>  
                    </label> 
                            <select class="form-control" name="vikas_khand" id="vikas_khand">
                               
                            </select>
                    
                    </div> -->

                    <div class="form-group col-md-6">
                        <label ><span data-hi="ग्राम पंचायत का नाम" data-en="Name of Gram Panchayat"> </span> </label> 
                            <!-- <select class="form-control" name="gram_panchayat_name" id="gram_panchayat_name">
                            </select> -->
                            <input type="text" name="gram_panchayat_name" class="form-control" id="gram_panchayat_name" placeholder="ग्राम पंचायत का नाम">
                    </div>
                    
                    <!-- 29 Aug 2025 Add filed to Gram Panchayat -->
                     <div class="form-group col-md-6">
                        <label >
                            <span data-hi="ग्राम पंचायत से संबंधित निकटतम पशु चिकित्सालय" data-en="Gram Panchayat Nearest Veterinary Hospital"> </span>
                        </label> 
                        <input type="text" class="form-control" name="gram_panchayat_hospital" id="gram_panchayat_hospital"
                            placeholder="ग्राम पंचायत से संबंधित निकटतम पशु चिकित्सालय" autocomplete="off" value="{{ $result->gram_panchayat_hospital }}">
                    </div>
                     <!-- 29 Aug 2025 Add filed to Gram Panchayat -->

                    <div class="form-group col-md-6">
                        <label >
                            <span data-hi="पत्र - व्यवहार का पता" data-en="Postal address"> </span>
                        </label> 
                        <input type="text" class="form-control" name="letter_address" id="letter_address"
                            placeholder="पत्र  - व्यवहार का पता" autocomplete="off" value="{{ $result->letter_address }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label ><span data-hi="पोस्ट ऑफिस" data-en="Post Office"> </span>  </label> 
                            <!-- <select class="form-control" name="post_office" id="post_office"> 
                            </select> -->
                            <input type="text" name="post_office" class="form-control" id="post_office" placeholder="पोस्ट ऑफिस">
                    </div>

                    <!-- 29 Aug 2025 Comment the code -->
                    <!-- <div class="form-group col-md-6">
                        <label for="inputPassword4"><span data-hi="एआई सेंटर (पशु चिकित्सा अस्पताल / एलईओ सेंटर)" data-en="AI Centre (Veterinary Hospital / LEO Center)"> </span></label>
                            <select class="form-control" name="ai_center" id="ai_center">
                               
                            </select>
                    </div> -->

                    <div class="form-group col-md-6">
                        <label for="inputPassword4"><span data-hi="पिनकोड" data-en="Pincode"> </span>  </label> <span class="text-danger">*</span>
                        <input maxlength="6" type="text" class="form-control" name="pincode" id="pincode"
                            placeholder="पिनकोड" autocomplete="off" value="{{ $result->pincode }}"
                            onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4"><span data-hi="ई-मेल" data-en="E-mail"> </span>   </label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="ई -मेल"
                            autocomplete="off" value="{{ $result->email }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4"><span data-hi="आवेदक की फोटो" data-en="Applicant's photo"> </span> 
                         </label> <span class="text-danger">*</span> <small
                            style="color:red;">Note: JPG, JPEG, PNG files only (Max. 2 MB)</small>
                        <input type="file" class="form-control" name="applicant_photo" id="applicant_photo"
                            placeholder="आवेदक की फोटो">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputPassword4"><span data-hi="आवेदक का हस्ताक्षर" data-en="Applicant's Signature"> </span>   </label> <span class="text-danger">*</span> <small
                            style="color:red;">Note: JPG, JPEG, PNG only (Max. 2 MB)</small>
                        <input type="file" class="form-control" name="signature" id="signature"
                            placeholder="आवेदक  का हस्ताक्षर">
                    </div>

                </div>
            </div>

            <div class="tab">
                <h3><span data-hi="शैक्षिक योग्यता व अन्य विवरण" data-en="Educational Qualification and other details"> </span> 
                    <div class=" pull-right">
                        <small style="color:red;font-size:10px;margin-right: 200px;">Note: JPG, JPEG, PNG files only (Max.
                            2 MB)</small>
                    </div>
                </h3>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="checkbox" name="edu_declaration" id="edu_declaration" value="1" {{ $result->edu_declaration == 1 ? 'checked' : '' }}> <span data-hi="मैं एतद्द्वारा घोषणा करता/करती हूँ कि मैंने जीव विज्ञान (Biology) विषय के साथ इंटरमीडिएट (12वीं) परीक्षा उत्तीर्ण की है।" data-en="I hereby declare that I have successfully passed the Intermediate (12th) examination with Biology as a subject."> </span> <span class="text-danger">*</span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="">
                    <table class="table  exam-data">
                        <thead>
                            <tr>
                                <th> <span data-hi="उत्तीर्ण परीक्षा का नाम" data-en="Name of the exam passed"> </span></th>
                                <th> <span data-hi="बोर्ड का नाम" data-en="Name of the Board"> </span></th>
                                <th><span data-hi="उत्तीर्ण वर्ष" data-en="Passing Year"> </span></th>
                                <th><span data-hi="प्राप्तांक" data-en="Obtained Marks"> </span></th>
                                <th><span data-hi="पूर्णांक" data-en="Maximum Marks"> </span></th>
                                <th><span data-hi="प्रतिशत" data-en="Percentage"> </span></th>
                                <th><span data-hi="अंकतालिका अपलोड करें" data-en="Upload Marksheet"> </span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span data-hi=" हाई स्कूल (विज्ञान वर्ग)" data-en="High School(Science Stream)"> </span>  <span class="text-danger">*</span></div></td>
                                <td>
                                <input type="text" class="form-control" name="high_board_name" id="high_board_name" placeholder="बोर्ड का नाम" autocomplete="off" value="{{ $result->high_board_name }}" style="width: 350px;">
                                </td>
                                <td>
                                <input maxlength="4" type="text" class="form-control" name="high_passing_year" id="high_passing_year" placeholder="उत्तीर्ण वर्ष"  autocomplete="off" value="{{ $result->high_passing_year }}"  onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  style="width: 80px;">
                                </td>
                                <td>
                                <input maxlength="4" type="text" class="form-control"
                            name="high_marks" id="high_marks" placeholder="प्राप्तांक" autocomplete="off"
                            value="{{ $result->high_marks }}" style="width: 65px;">
                                </td>
                                <td>
                                <input maxlength="4" type="text" class="form-control"
                            name="high_total_marks" id="high_total_marks" placeholder="पूर्णांक"
                            autocomplete="off" value="{{ $result->high_total_marks }}" style="width: 65px;">
                                </td>
                                <td>
                                <input type="text" class="form-control" readonly
                            name="high_percentage" id="high_percentage" placeholder="प्रतिशत" autocomplete="off"
                            value="{{ $result->high_percentage }}" style="width: 65px;">
                                </td>
                                <td>
                                <input style="width: 98px;" type="file"
                                class="form-control" name="high_marksheet" id="high_marksheet">
                                </td>
                            </tr>

                            <tr>
                                <td> <span data-hi="इंटरमीडिएट (विज्ञान वर्ग)" data-en="Intermediate(Science Stream)"> </span> <span class="text-danger">*</span>   </td>
                                <td>
                                <input type="text" class="form-control"
                            name="inter_board_name" id="inter_board_name" placeholder="बोर्ड का नाम"
                            autocomplete="off" value="{{ $result->inter_board_name }}" style="width: 350px;">
                                </td>
                                <td>
                                <input maxlength="4" type="text" class="form-control"
                            name="inter_passing_year" id="inter_passing_year" placeholder="उत्तीर्ण वर्ष"
                            autocomplete="off" value="{{ $result->inter_passing_year }}"
                            onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                            style="width: 80px;">
                                </td>
                                <td>
                                <input maxlength="4" type="text" class="form-control"
                            name="inter_marks" id="inter_marks" placeholder="प्राप्तांक" autocomplete="off"
                            value="{{ $result->inter_marks }}" style="width: 65px;">
                                </td>
                                <td>
                                <input maxlength="4" type="text" class="form-control"
                            name="inter_total_marks" id="inter_total_marks" placeholder="पूर्णांक"
                            autocomplete="off" value="{{ $result->inter_total_marks }}" style="width: 65px;">
                                </td>
                                <td>
                                <input type="text" class="form-control" readonly
                            name="inter_percentage" id="inter_percentage" placeholder="प्रतिशत"
                            autocomplete="off" value="{{ $result->inter_percentage }}" style="width: 65px;">
                                </td>
                                <td><input style="width: 98px;" type="file"
                                class="form-control" name="inter_marksheet" id="inter_marksheet"></td>
                            </tr>
                            <tr>
                                <td>
                                <span data-hi="स्नातक" data-en="Graduate"> </span>    
                                </td>
                                <td>
                                <input type="text" class="form-control"
                            name="graduation_board_name" id="graduation_board_name" placeholder="बोर्ड का नाम"
                            autocomplete="off" value="{{ $result->graduation_board_name }}"
                            style="width: 350px;">
                                </td>
                                <td>
                                <input maxlength="4" type="text" class="form-control"
                            name="graduation_passing_year" id="graduation_passing_year"
                            placeholder="उत्तीर्ण वर्ष" autocomplete="off"
                            value="{{ $result->graduation_passing_year }}"
                            onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                            style="width: 80px;">
                                </td>
                                <td><input maxlength="4" type="text" class="form-control"
                            name="graduation_marks" id="graduation_marks" placeholder="प्राप्तांक"
                            autocomplete="off" value="{{ $result->graduation_marks }}" style="width: 65px;"></td>
                                <td>
                                <input maxlength="4" type="text" class="form-control"
                            name="graduation_total_marks" id="graduation_total_marks" placeholder="पूर्णांक"
                            autocomplete="off" value="{{ $result->graduation_total_marks }}"
                            style="width: 65px;">
                                </td>
                                <td><input type="text" class="form-control" readonly
                            name="graduation_percentage" id="graduation_percentage" placeholder="प्रतिशत"
                            autocomplete="off" value="{{ $result->graduation_percentage }}"
                            style="width: 65px;"></td>
                            <td>
                            <input style="width: 98px;" type="file"
                            class="form-control" name="graduation_marksheet" id="graduation_marksheet">
                            </td>
                            </tr>
                            <tr>
                                <td><span data-hi="परास्नातक" data-en="Masters"> </span>    </td>
                                <td><input type="text" class="form-control"
                            name="postgraduation_board_name" id="postgraduation_board_name"
                            placeholder="बोर्ड का नाम" autocomplete="off"
                            value="{{ $result->postgraduation_board_name }}" style="width: 350px;"></td>
                                <td>
                                <input maxlength="4" type="text" class="form-control"
                            name="postgraduation_passing_year" id="postgraduation_passing_year"
                            placeholder="उत्तीर्ण वर्ष" autocomplete="off"
                            value="{{ $result->postgraduation_passing_year }}"
                            onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                            style="width: 80px;">
                                </td>
                                <td>
                                <input maxlength="4" type="text" class="form-control"
                            name="postgraduation_marks" id="postgraduation_marks" placeholder="प्राप्तांक"
                            autocomplete="off" value="{{ $result->postgraduation_marks }}" style="width: 65px;">
                                </td>
                                <td>
                                <input maxlength="4" type="text" class="form-control"
                            name="postgraduation_total_marks" id="postgraduation_total_marks"
                            placeholder="पूर्णांक" autocomplete="off"
                            value="{{ $result->postgraduation_total_marks }}" style="width: 65px;">
                                </td>
                                <td>
                                <input type="text" class="form-control" readonly
                            name="postgraduation_percentage" id="postgraduation_percentage" placeholder="प्रतिशत"
                            autocomplete="off" value="{{ $result->postgraduation_percentage }}"
                            style="width: 65px;">
                                </td>
                                <td>
                                <input style="width: 98px;" type="file"
                                class="form-control" name="postgraduation_marksheet" id="postgraduation_marksheet">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="row">

                    <div class="container">
                        <div class="row"
                            style="font-size: 13px;background: black;color: white;padding: 10px;font-weight: bold;">
                            <div class="col align-self-center">
                                <span data-hi="उत्तीर्ण परीक्षा का नाम" data-en="Name of the exam passed"> </span>
                            </div>
                            <div class="col align-self-center" style="padding-right: 250px;">
                                <span data-hi="बोर्ड का नाम" data-en="Name of the Board"> </span>
                            </div>
                            <div class="col align-self-center">
                                <span data-hi="उत्तीर्ण वर्ष" data-en="Passing Year"> </span>
                            </div>
                            <div class="col align-self-center">
                                <span data-hi="प्राप्तांक" data-en="Obtained Marks"> </span>
                            </div>
                            <div class="col align-self-center">
                                <span data-hi="पूर्णांक" data-en="Maximum Marks"> </span>
                            </div>
                            <div class="col align-self-center">
                                <span data-hi="प्रतिशत" data-en="Percentage"> </span>
                            </div>
                            <div class="col align-self-center" style="font-size: 12px;">
                                <span data-hi="अंकतालिका अपलोड करें" data-en="Upload Marksheet"> </span>
                            </div>
                        </div>

                        <div class="row" style="font-size: 14px;margin-top: 5px;">
                            <div class="col align-self-center" style="font-size: 11px;">
                            <span data-hi=" हाई स्कूल (विज्ञान वर्ग)" data-en="High School(Science Stream)"> </span>
                               <span
                                    class="text-danger">*</span></div>
                            <div class="col align-self-center"><input type="text" class="form-control"
                                    name="high_board_name" id="high_board_name" placeholder="बोर्ड का नाम"
                                    autocomplete="off" value="{{ $result->high_board_name }}" style="width: 350px;">
                            </div>
                            <div class="col align-self-center"><input maxlength="4" type="text" class="form-control"
                                    name="high_passing_year" id="high_passing_year" placeholder="उत्तीर्ण वर्ष"
                                    autocomplete="off" value="{{ $result->high_passing_year }}"
                                    onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                    style="width: 80px;"></div>
                            <div class="col align-self-center"><input maxlength="4" type="text" class="form-control"
                                    name="high_marks" id="high_marks" placeholder="प्राप्तांक" autocomplete="off"
                                    value="{{ $result->high_marks }}" style="width: 65px;"></div>
                            <div class="col align-self-center"><input maxlength="4" type="text" class="form-control"
                                    name="high_total_marks" id="high_total_marks" placeholder="पूर्णांक"
                                    autocomplete="off" value="{{ $result->high_total_marks }}" style="width: 65px;">
                            </div>
                            <div class="col align-self-center"><input type="text" class="form-control" readonly
                                    name="high_percentage" id="high_percentage" placeholder="प्रतिशत" autocomplete="off"
                                    value="{{ $result->high_percentage }}" style="width: 65px;"></div>
                            <div class="col align-self-center"><input style="width: 98px;" type="file"
                                    class="form-control" name="high_marksheet" id="high_marksheet"></div>
                        </div>

                        <div class="row" style="font-size: 14px;margin-top: 5px;">
                            <div class="col align-self-center" style="font-size: 11px;">
                            <span data-hi="इंटरमीडिएट (विज्ञान वर्ग)" data-en="Intermediate(Science Stream)"> </span>    
                            </div>
                            <div class="col align-self-center"><input type="text" class="form-control"
                                    name="inter_board_name" id="inter_board_name" placeholder="बोर्ड का नाम"
                                    autocomplete="off" value="{{ $result->inter_board_name }}" style="width: 350px;">
                            </div>
                            <div class="col align-self-center"><input maxlength="4" type="text" class="form-control"
                                    name="inter_passing_year" id="inter_passing_year" placeholder="उत्तीर्ण वर्ष"
                                    autocomplete="off" value="{{ $result->inter_passing_year }}"
                                    onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                    style="width: 80px;"></div>
                            <div class="col align-self-center"><input maxlength="4" type="text" class="form-control"
                                    name="inter_marks" id="inter_marks" placeholder="प्राप्तांक" autocomplete="off"
                                    value="{{ $result->inter_marks }}" style="width: 65px;"></div>
                            <div class="col align-self-center"><input maxlength="4" type="text" class="form-control"
                                    name="inter_total_marks" id="inter_total_marks" placeholder="पूर्णांक"
                                    autocomplete="off" value="{{ $result->inter_total_marks }}" style="width: 65px;">
                            </div>
                            <div class="col align-self-center"><input type="text" class="form-control" readonly
                                    name="inter_percentage" id="inter_percentage" placeholder="प्रतिशत"
                                    autocomplete="off" value="{{ $result->inter_percentage }}" style="width: 65px;">
                            </div>
                            <div class="col align-self-center"><input style="width: 98px;" type="file"
                                    class="form-control" name="inter_marksheet" id="inter_marksheet"></div>
                        </div>


                        <div class="row" style="font-size: 14px;margin-top: 5px;">
                            <div class="col align-self-center" style="font-size: 11px;">
                            <span data-hi="स्नातक" data-en="Graduate"> </span>    
                            </div>
                            <div class="col align-self-center"><input type="text" class="form-control"
                                    name="graduation_board_name" id="graduation_board_name" placeholder="बोर्ड का नाम"
                                    autocomplete="off" value="{{ $result->graduation_board_name }}"
                                    style="width: 350px;"></div>
                            <div class="col align-self-center"><input maxlength="4" type="text" class="form-control"
                                    name="graduation_passing_year" id="graduation_passing_year"
                                    placeholder="उत्तीर्ण वर्ष" autocomplete="off"
                                    value="{{ $result->graduation_passing_year }}"
                                    onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                    style="width: 80px;"></div>
                            <div class="col align-self-center"><input maxlength="4" type="text" class="form-control"
                                    name="graduation_marks" id="graduation_marks" placeholder="प्राप्तांक"
                                    autocomplete="off" value="{{ $result->graduation_marks }}" style="width: 65px;">
                            </div>
                            <div class="col align-self-center"><input maxlength="4" type="text" class="form-control"
                                    name="graduation_total_marks" id="graduation_total_marks" placeholder="पूर्णांक"
                                    autocomplete="off" value="{{ $result->graduation_total_marks }}"
                                    style="width: 65px;"></div>
                            <div class="col align-self-center"><input type="text" class="form-control" readonly
                                    name="graduation_percentage" id="graduation_percentage" placeholder="प्रतिशत"
                                    autocomplete="off" value="{{ $result->graduation_percentage }}"
                                    style="width: 65px;"></div>
                            <div class="col align-self-center"><input style="width: 98px;" type="file"
                                    class="form-control" name="graduation_marksheet" id="graduation_marksheet"></div>
                        </div>


                        <div class="row" style="font-size: 14px;margin-top: 5px;">
                            <div class="col align-self-center" style="font-size: 11px;">
                                <span data-hi="परास्नातक" data-en="Masters"> </span>    
                            </div>
                            <div class="col align-self-center"><input type="text" class="form-control"
                                    name="postgraduation_board_name" id="postgraduation_board_name"
                                    placeholder="बोर्ड का नाम" autocomplete="off"
                                    value="{{ $result->postgraduation_board_name }}" style="width: 350px;"></div>
                            <div class="col align-self-center"><input maxlength="4" type="text" class="form-control"
                                    name="postgraduation_passing_year" id="postgraduation_passing_year"
                                    placeholder="उत्तीर्ण वर्ष" autocomplete="off"
                                    value="{{ $result->postgraduation_passing_year }}"
                                    onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
                                    style="width: 80px;"></div>
                            <div class="col align-self-center"><input maxlength="4" type="text" class="form-control"
                                    name="postgraduation_marks" id="postgraduation_marks" placeholder="प्राप्तांक"
                                    autocomplete="off" value="{{ $result->postgraduation_marks }}" style="width: 65px;">
                            </div>
                            <div class="col align-self-center"><input maxlength="4" type="text" class="form-control"
                                    name="postgraduation_total_marks" id="postgraduation_total_marks"
                                    placeholder="पूर्णांक" autocomplete="off"
                                    value="{{ $result->postgraduation_total_marks }}" style="width: 65px;"></div>
                            <div class="col align-self-center"><input type="text" class="form-control" readonly
                                    name="postgraduation_percentage" id="postgraduation_percentage" placeholder="प्रतिशत"
                                    autocomplete="off" value="{{ $result->postgraduation_percentage }}"
                                    style="width: 65px;"></div>
                            <div class="col align-self-center"><input style="width: 98px;" type="file"
                                    class="form-control" name="postgraduation_marksheet" id="postgraduation_marksheet">
                            </div>
                        </div>


                    </div>

                </div> -->


                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">
                        <span data-hi="यदि पूर्व में प्राइवेट कृत्रिम गर्भाधान कार्यकर्त्ता के सम्बन्ध मै प्रशिक्षण प्राप्त किया है तो योजनान्तर्गत जारी प्रमाण-पत्र" data-en="If training has been received in relation to private artificial insemination worker in the past then certificate issued under the scheme"> </span>    
                         </label> <span
                            class="text-danger">*</span>
                        <select class="form-control" name="training_adopted" id="training_adopted">
                            <option value="">चुनें</option>
                            <option value="केन्द्र" {{ $result->training_adopted == 'केन्द्र' ? 'selected' : '' }}>केन्द्र
                            </option>
                            <option value="राज्य" {{ $result->training_adopted == 'राज्य' ? 'selected' : '' }}>राज्य
                            </option>
                            <option value="स्ववित्त पोषित"
                                {{ $result->training_adopted == 'स्ववित्त पोषित' ? 'selected' : '' }}>स्ववित्त पोषित
                            </option>
                            <option value="अन्य" {{ $result->training_adopted == 'अन्य' ? 'selected' : '' }}>अन्य
                            </option>
                            <option value="नहीं" {{ $result->training_adopted == 'नहीं' ? 'selected' : '' }}>नहीं
                            </option>
                        </select>
                    </div>
                </div>

                <div class="row showHide">

                    <div class="form-group col-md-4">
                        <label for="inputEmail4"><span data-hi="राज्य / केंद्र सरकार द्वारा मान्यता प्राप्त संस्थान से यदि पूर्व में
                            कृत्रिम गर्भाधान के प्रशिक्षण का प्रमाण-पत्र प्राप्त किया हो (प्रमाण - पत्र अपलोड करें)" data-en="If previously obtained certificate of training in artificial insemination from an institute recognized by State / Central Government (Upload certificate)"> </span>   
                        </label>
                        <small style="color:red;">Note: JPG, JPEG, PNG files only (Max. 2 MB)</small>
                        <input type="file" class="form-control" name="training_certificate"
                            id="training_certificate">
                    </div>

                    <div class="form-group col-md-4" style="margin-top: 35px;">
                        <label for="inputEmail4"><span data-hi=" प्रशिक्षण की अवधि माह" data-en="Duration of training month"> </span>  </label>
                        <select class="form-control" name="training_certificate_period_in_month"
                            id="training_certificate_period_in_month">
                            <option value="">माह</option>
                            <?php
					  for($m=1;$m<=12;$m++)
					  {
						 ?>
                            <option value="{{ $m }}"
                                {{ $result->training_certificate_period_in_month == $m ? 'selected' : '' }}>
                                {{ $m }} माह</option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-4" style="margin-top: 35px;">
                        <label for="inputEmail4">दिन</label>
                        <select class="form-control" name="training_certificate_period_in_days"
                            id="training_certificate_period_in_days">
                            <option value="">दिन</option>
                            <?php
					  for($d=1;$d<=29;$d++)
					  {
						 ?>
                            <option value="{{ $d }}"
                                {{ $result->training_certificate_period_in_days == $d ? 'selected' : '' }}>
                                {{ $d }} दिन</option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">
                        <span data-hi="योजना का नाम जिसके अंतर्गत प्रशिक्षण प्राप्त किया गया" data-en="Name of scheme under which training received"> </span>
                        </label> <span
                            class="text-danger">*</span>
                        <input type="text" class="form-control" value="{{ $result->yojna_name_for_training }}"
                            name="yojna_name_for_training" id="yojna_name_for_training">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">
                        <span data-hi="भारत पशुधन आईडी" data-en="Bharat Pashudhan ID"> </span>
                        </label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" value="{{ $result->bharat_pshudhan_id }}" placeholder="भारत पशुधन आईडी"
                            name="bharat_pshudhan_id" id="bharat_pshudhan_id">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">
                        <span data-hi=" प्रशिक्षणोपरांत ए. आई. किट तथा बायोलोजिकल कन्टेनर प्राप्त किये गये
                            है" data-en="After the training, AI kits and biological containers have been received"> </span>
                       </label> <span class="text-danger">*</span>
                        <select class="form-control" name="AIkit" id="AIkit">
                            <option value="">चुनें</option>
                            <option value="हाँ" {{ $result->AIkit == 'हाँ' ? 'selected' : '' }}>हाँ</option>
                            <option value="नहीं" {{ $result->AIkit == 'नहीं' ? 'selected' : '' }}>नहीं</option>
                        </select>
                    </div>

                </div>


                <div class="row" style="padding-top:30px;">

                    <div class="form-group col-md-12">
                        <label for="inputEmail4">
                        <span data-hi="वोटर आई डी कार्ड / आधार कार्ड / पैन कार्ड आदि अन्य फोटो युक्त आईडी जो  निर्वाचन आयोग से अनुमन्य है, में से कोई एक अपलोड करें" data-en="Upload any one of the Voter ID Card / Aadhar Card / PAN Card etc. other photo ID as permitted by the Election Commission"> </span>    
                       </label> <span
                            class="text-danger">*</span> <small style="color:red;">Note: JPG, JPEG, PNG files only (Max.
                            2 MB)</small>
                        <input type="file" class="form-control" name="id_upload" id="id_upload">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputEmail4">
                        <span data-hi="जाति (अनुसूचित जाति) श्रेणी हेतु न्याय अधिकारी द्वारा जारी प्रमाण - पत्र अपलोड करें" data-en="Upload certificate issued by judicial officer for caste (SC, ST) category"> </span>  
                        </label> <small style="color:red;">Note: JPG, JPEG, PNG files only (Max. 2
                            MB)</small>
                        <input type="file" class="form-control" name="caste_certificate" id="caste_certificate">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputEmail4">
                        <span data-hi=" राजकीय चिकित्साधिकारी द्वारा प्रदत्त स्वास्थ्य प्रमाण - पत्र अपलोड करें (यह केवल सत्यापन के समय ही आवश्यक है)" data-en="Upload health certificate issued by government medical officer (This is only necessary at the time of verification.)"> </span>  
                       </label>
                     
                        <input type="file" class="form-control" name="health_certificate" id="health_certificate">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputEmail4">  <span data-hi=" राष्ट्रीयता" data-en="Nationality"> </span>    </label> <span class="text-danger">*</span>
                        <select class="form-control" name="nationality" id="nationality">
                            <option value="">चुनें</option>
                            <option selected="selected" value="भारतीय"
                                {{ $result->nationality == 'भारतीय' ? 'selected' : '' }}>भारतीय</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12"><span class="text-danger">*</span>
                        <input type="checkbox" name="declaration" id="declaration" value="1">
                        <label for="inputEmail4" style="font-weight: bold;font-size: 16px;"><span data-hi="मै एतद्‌द्वारा यह घोषणा  करता / करती हूँ कि मैं " data-en="मै एतद्‌द्वारा यह घोषणा  करता / करती हूँ कि मैं "> </span>__ <span style="font-weight:normal;" id="applicant_named"></span>__
                           <span data-hi="पुत्र / पुत्री / पत्नी" data-en="Son / Daughter / Wife"> </span>_<span style="font-weight:normal;" id="fnamed">SA</span>_ <span data-hi="निवासी ग्राम" data-en="Residents / Village"> </span> _<span style="font-weight:normal;" id="janpad_gram">DA</span>_ <span data-hi="ग्राम पंचायत " data-en="Gram Panchayat"> </span> _<span
                                style="font-weight:normal;" id="gram_panchayat_named">GH</span>_ 
                                <span data-hi="विकास खंड" data-en="Vikas Khand"> </span>_<span
                                style="font-weight:normal;" id="vikas_khandd">BB</span>_  <span data-hi="जनपद" data-en="Janpad"> </span> _<span
                                style="font-weight:normal;" id="janpadd">Agra</span>_ <span data-hi="का निवासी हूँ | मैं आवेदन पत्र के
                            साथ संलग्न नियम - शर्तो से पूर्णत: अवगत हूँ | मै पूर्णत: स्वस्थ हूँ एवं पशुपालक के द्वार पर
                            पहुँच कर सेवा करने योग्य हूँ | मैं मैत्री स्वरोजगारी के रूप में कार्य करूंगा/करुंगी। सरकारी सेवा में किसी भी स्थिति में संविलियन का कोई अधिकार नहीं होगा और इसके लिए कभी दावा नहीं करूंगा/करुंगी। यदि कोई विवरण / सूचना असत्य पायी जाती है या तथ्य मेरे द्वारा छिपाया पाया जाता है तो मेरा आवेदन चयनोपरांत भी निरस्त कर दिया जाए |" data-en="I am a resident of. I am fully aware of the terms and conditions attached with the application form. I am completely healthy and capable of reaching the door of the cattle keeper and serving him.I will work as per mother tongue. I will not have any right to absorption in Government service under any circumstances and will never claim for it. If any details / information is found to be false or facts are found to be hidden by me, then my application should be cancelled even after selection."> </span> 

                            <br><br>स्थान : <span style="font-weight:normal;" id="janpaddD"></span>
                            <br>दिनांक : <span style="font-weight:normal;"><?php echo date('d-m-Y'); ?></span>
                        </label>
                    </div>
                </div>

            </div>

            <div class="tab">
                <h3> <span data-hi="आवेदक का बैंक विवरण" data-en="Applicant Bank Detailss"></span></h3>
                <div class="row">

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">
                        <span data-hi="बैंक का नाम " data-en="Bank Name"></span>      
                         </label> <span class="text-danger">*</span>
                        <select name="bank_name" id="bank_name" class="form-control">
                            <option value="">-कोई भी एक चुनें-</option>
                                @if(count($banks)>0)
                                @foreach($banks as $val)
                                <option value="{{$val->id}}">{{$val->name_hi}}</option>
                                @endforeach
                                @endif
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputPassword4">
                        <span data-hi="खाता संख्या" data-en="Account Number"></span>      
                       </label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" id="account_number" name="account_number"
                            placeholder="खाता संख्या" autocomplete="off" value="{{ $result->account_number }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">
                        <span data-hi="आईएफएससी कोड" data-en="IFSC Code"></span>     
                        </label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code"
                            placeholder="आईएफएससी कोड" autocomplete="off" value="{{ $result->ifsc_code }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">
                        <span data-hi="पीएफएमएस " data-en="PFMS"></span>    
                        </label> 
                        <!-- <span class="text-danger">*</span> -->
                        <input type="text" class="form-control" id="pfms" name="pfms"
                            placeholder="पीएफएमएस" autocomplete="off" value="{{ $result->pfms }}">
                    </div>
                </div>
            </div>


            <!------Summary Page Start---------------->
            <div class="tab">
                <h3><span data-hi="आवेदक का विवरण" data-en="Applicant's Details"> </span>    </h3>
                <div class="row">

                    <div class="form-group col-md-4">
                        <label for="inputEmail4"><span data-hi="आवेदक का नाम" data-en="Applicant's name"> </span>  </label>
                        <span class="form-control-span" id="applicant_name1">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4"><span data-hi="पिता / पति का नाम" data-en="Father/Husband's Name"> </span> </label>
                        <span class="form-control-span" id="fname1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4"><span data-hi="माता का नाम" data-en="Mother's name"> </span> </label>
                        <span class="form-control-span" id="mother1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputEmail4">
                        <span data-hi="जन्म तिथि (हाई स्कूल प्रमाण पत्र के अनुसार)" data-en="Date of Birth (As per High School Certificate)"> </span>
                          </label>
                        <span class="form-control-span" id="dob1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputEmail4"> 
                            <span data-hi="दूरभाष / मोबाइल नंबर" data-en="Telephone / Mobile Number"> </span>
                        </label>
                        <span class="form-control-span" id="mobile1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputEmail4"> <span data-hi="श्रेणी" data-en="Category"> </span> </label>
                        <span class="form-control-span" id="category1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4">
                        <span data-hi="स्थायी पता" data-en="Permanent Address"> </span>     
                         </label>
                        <span class="form-control-span" id="permanent_address1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputEmail4">
                        <span data-hi="स्थायी पता का प्रमाण का प्रकार" data-en="Type of Permanent Address Proof"> </span>         
                        </label>
                        <span class="form-control-span" id="address_type1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4">
                            <span data-hi="स्थायी पता का प्रमाण - पत्र" data-en="Permanent Address Proof"> </span>        
                        </label>
                        <span class="form-control-span" id="permanent_address_proof1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4">
                            <span data-hi="पोस्ट ऑफिस" data-en="Post Office"> </span>     
                            </label>
                        <span class="form-control-span" id="post_office1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4">
                        <span data-hi="पिनकोड" data-en="Pincode"> </span>         
                        </label>
                        <span class="form-control-span" id="pincode1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputEmail4">
                            <span data-hi=" ग्राम पंचायत का नाम" data-en="Name of Gram Panchayat"> </span> 
                       </label>
                        <span class="form-control-span" id="gram_panchayat_name1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputEmail4">
                        <span data-hi="लिंग" data-en="Gender"> </span>     
                        </label>
                        <span class="form-control-span" id="gender1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4"> <span data-hi="जनपद" data-en="Janapd"> </span> </label>
                        <span class="form-control-span" id="janpad1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputEmail4"><span data-hi="विकास खण्ड" data-en="Vikas Khand"> </span>  </label>
                        <span class="form-control-span" id="vikas_khand1"></span>
                    </div>


                    <div class="form-group col-md-4">
                        <label for="inputEmail4"><span data-hi="पत्र -व्यवहार का पता" data-en="Postal address"> </span>  </label>
                        <span class="form-control-span" id="letter_address1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4"><span data-hi="ई - मेल" data-en="E-mail"> </span>  </label>
                        <span class="form-control-span" id="email1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4"><span data-hi="आवेदक की फोटो" data-en="Applicant's photo"> </span>  </label>
                        <span class="form-control-span"><img id="applicant_photo_priview" width="100"></span>
                        <span class="form-control-span" id="applicant_photo_url" style="margin-left: 36px;"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4">
                        <span data-hi="आवेदक का हस्ताक्षर" data-en="Applicant's Signature"> </span>
                        </label>
                        <span class="form-control-span"><img id="signature_priview" width="100"></span>
                        <span class="form-control-span" id="signature_url" style="margin-left: 36px;"></span>
                    </div>

                </div>


                <hr>
                <div class="row">

                    <h3> <span data-hi="शैक्षिक योग्यता व अन्य विवरण" data-en="Educational Qualification and other details"> </span> </h3>
                    <br>
                    <div class="row">
                        <table class="table table-striped  table-responsive table-bordered">
                            <tr>
                                <td style="width: 12%;"><span data-hi="उत्तीर्ण परीक्षा का नाम" data-en="Name of exam passed"> </span></td>
                                <td><span data-hi="बोर्ड का नाम" data-en="Name of the Board"> </span> </td>
                                <td><span data-hi="उत्तीर्ण वर्ष" data-en="Passing Year"> </span></td>
                                <td><span data-hi="प्राप्तांक" data-en="Obtained Marks"> </span> </td>
                                <td><span data-hi="पूर्णांक" data-en="Maximum Marks"> </span>  </td>
                                <td><span data-hi="प्रतिशत" data-en="Percentage"> </span> </td>
                                <td><span data-hi="अंकतालिका" data-en="Mark sheet"> </span>  </td>
                                <td><span data-hi="प्रमाण - पत्र" data-en="Certificate"> </span>  </td>
                            </tr>
                            <tr>
                                <td><span data-hi=" हाई स्कूल (विज्ञान वर्ग)" data-en="High School(Science Stream)"> </span></td>
                                <td><span class="form-control-span" id="high_board_name1"></span></td>
                                <td><span class="form-control-span" id="high_passing_year1"></span></td>
                                <td><span class="form-control-span" id="high_marks1"></span></td>
                                <td><span class="form-control-span" class="form-control-span"
                                        id="high_total_marks1"></span></td>
                                <td><span class="form-control-span" id="high_percentage1"></span></td>
                                <td>
                                    <span class="form-control-span"><img id="high_marksheet_priview"
                                            width="100"></span>
                                    <span class="form-control-span" id="high_marksheet_url"
                                        style="margin-left: 36px;"></span>
                                </td>
                                <td>
                                    <span class="form-control-span"><img id="high_certificate_priview"
                                            width="100"></span>
                                    <span class="form-control-span" id="high_certificate_url"
                                        style="margin-left: 36px;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%"><span data-hi="इण्टर (जीव विज्ञान)" data-en="Intermediate (Biology)"> </span> </td>
                                <td><span class="form-control-span" id="inter_board_name1"></span></td>
                                <td><span class="form-control-span" id="inter_passing_year1"></span></td>
                                <td><span class="form-control-span" id="inter_marks1"></span></td>
                                <td><span class="form-control-span" id="inter_total_marks1"></span></td>
                                <td><span class="form-control-span" id="inter_percentage1"></span></td>
                                <td>
                                    <span class="form-control-span"><img id="inter_marksheet_priview"
                                            width="100"></span>
                                    <span class="form-control-span" id="inter_marksheet_url"
                                        style="margin-left: 36px;"></span>
                                </td>
                                <td>
                                    <span class="form-control-span"><img id="inter_certificate_priview"
                                            width="100"></span>
                                    <span class="form-control-span" id="inter_certificate_url"
                                        style="margin-left: 36px;"></span>
                                </td>
                            </tr>

                            <tr>
                                <td width="10%"><span data-hi="स्नातक" data-en="Graduate"> </span> </td>
                                <td><span class="form-control-span" id="graduation_board_name1"></span></td>
                                <td><span class="form-control-span" id="graduation_passing_year1"></span></td>
                                <td><span class="form-control-span" id="graduation_marks1"></span></td>
                                <td><span class="form-control-span" id="graduation_total_marks1"></span></td>
                                <td><span class="form-control-span" id="graduation_percentage1"></span></td>
                                <td>
                                    <span class="form-control-span"><img id="graduation_marksheet_priview"
                                            width="100"></span>
                                    <span class="form-control-span" id="graduation_marksheet_url"
                                        style="margin-left: 36px;"></span>
                                </td>
                                <td>
                                    <span class="form-control-span"><img id="graduation_certificate_priview"
                                            width="100"></span>
                                    <span class="form-control-span" id="graduation_certificate_url"
                                        style="margin-left: 36px;"></span>
                                </td>
                            </tr>

                            <tr>
                                <td width="10%"><span data-hi="परास्नातक" data-en="Masters"> </span></td>
                                <td><span class="form-control-span" id="postgraduation_board_name1"></span></td>
                                <td><span class="form-control-span" id="postgraduation_passing_year1"></span></td>
                                <td><span class="form-control-span" id="postgraduation_marks1"></span></td>
                                <td><span class="form-control-span" id="postgraduation_total_marks1"></span></td>
                                <td><span class="form-control-span" id="postgraduation_percentage1"></span></td>
                                <td>
                                    <span class="form-control-span"><img id="postgraduation_marksheet_priview"
                                            width="100"></span>
                                    <span class="form-control-span" id="postgraduation_marksheet_url"
                                        style="margin-left: 36px;"></span>
                                </td>
                                <td>
                                    <span class="form-control-span"><img id="postgraduation_certificate_priview"
                                            width="100"></span>
                                    <span class="form-control-span" id="postgraduation_certificate_url"
                                        style="margin-left: 36px;"></span>
                                </td>
                            </tr>

                        </table>
                    </div>

                    <div class="row">

                        <div class="form-group col-md-12">
                            <label for="inputEmail4">
                                <span data-hi="योजनान्तर्गत प्रशिक्षण का प्रमाण-पत्र" data-en="Certificate of training under the scheme"> </span>
                            </label>
                            <span class="form-control-span" id="training_adopted1"></span>
                        </div>

                    </div>



                    <div class="row showHideSummary">

                        <div class="form-group col-md-4">
                            <label for="inputEmail4"><span data-hi="राज्य / केंद्र सरकार द्वारा मान्यता प्राप्त संस्थान से यदि पूर्व में
                                कृत्रिम गर्भाधान के प्रशिक्षण का प्रमाण पत्र प्राप्त किया हो" data-en="If previously obtained certificate of training in artificial insemination from an institute recognized by State / Central Government"> </span>
                            </label>

                            <span class="form-control-span"><img id="training_certificate_priview" width="100"></span>
                            <span class="form-control-span" id="training_certificate_url"
                                style="margin-left: 36px;"></span>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputEmail4">
                            <span data-hi="प्रशिक्षण की अवधि माह" data-en="Duration of training month"> </span>
                           </label>
                            <span class="form-control-span" id="training_certificate_period_in_month1"></span>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputEmail4">
                            <span data-hi="दिन" data-en="Day"> </span> </label>
                            <span class="form-control-span" id="training_certificate_period_in_days1"></span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4">
                            <span data-hi="योजना का नाम जिसके अंतर्गत प्रशिक्षण प्राप्त किया गया" data-en="Name of scheme under which training received"> </span>
                           </label>
                            <span class="form-control-span" id="yojna_name_for_training1"></span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4">
                            <span data-hi="प्रशिक्षणोपरांत ए. आई. किट तथा बायोलोजिकल कन्टेनर प्राप्त किये गये है" data-en="After the training, AI kits and biological containers have been received"> </span>
                            </label>
                            <span class="form-control-span" id="AIkit1"></span>
                        </div>

                    </div>


                    <div class="row" style="padding-top:30px;">

                        <div class="form-group col-md-12">
                            <label for="inputEmail4">
                            <span data-hi=" वोटर आई डी कार्ड / आधार कार्ड / पैन कार्ड की प्रति" data-en="Copy of Voter ID Card / Aadhar Card / PAN Card"> </span>
                           </label>
                            <span class="form-control-span"><img id="id_upload_priview" width="100"></span>
                            <span class="form-control-span" id="id_upload_url" style="margin-left: 36px;"></span>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputEmail4">
                            <span data-hi="जाति (अनुसूचित जाति श्रेणी हेतु न्याय अधिकारी द्वारा जारी प्रमाण पत्र )" data-en="Caste (Certificate issued by Judicial Officer for Scheduled Caste Category)"> </span>
                            </label>
                            <span class="form-control-span"><img id="caste_certificate_priview" width="100"></span>
                            <span class="form-control-span" id="caste_certificate_url" style="margin-left: 36px;"></span>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputEmail4">
                            <span data-hi="राजकीय चिकित्साधिकारी द्वारा प्रदत्त स्वास्थ्य प्रमाण-पत्र" data-en="Health certificate issued by the State Medical Officer"> </span>
                            </label>
                            <span class="form-control-span"><img id="health_certificate_priview" width="100"></span>
                            <span class="form-control-span" id="health_certificate_url"
                                style="margin-left: 36px;"></span>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputEmail4">
                            <span data-hi="राष्ट्रीयता" data-en="Nationality"> </span>
                             </label>
                            <span class="form-control-span" id="nationality1"></span>
                        </div>
                    </div>
                </div>
            </div>


            <!------Summary Page End---------------->

            <div style="overflow:auto;margin-bottom:20px;">
                <div style="float:right; margin-top: 5px;" id="finalSubmit">
                    <button type="button" class="previous buttonWizard">   <span data-hi="पिछला" data-en="Previous"> </span> </button>
                    <button type="button" class="next buttonWizard" id="nextMe"> <span data-hi="सहेजें और अगला" data-en=" Save & Next"> </span>
                   </button>
                    <button type="button" class="submit buttonWizard">Submit</button>
                </div>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"
                    id="loader"> </span>

            </div>

        </form>

        <!--First row Closed-->
    </div>
    <script>
        $(document).ready(function() {

            $('#janpad_name').change(function() {
                var janpad_name = $(this).find(':selected').data('hindi_name'); 

                if (janpad_name) {
                    $.ajax({
                        url: '/get-tehsil',
                        type: 'GET',
                        data: { janpad_name: janpad_name },
                        success: function(response) {
                            var tehsilSelect = $('#tehsil');
                            tehsilSelect.empty();
                            tehsilSelect.append('<option value="">Select Tehsil</option>');
                            $.each(response, function(index, value) {
                                if(value != null || value != ''){
                                    tehsilSelect.append('<option value="' + value + '">' + value + '</option>');
                                }
                            });
                        }
                    });
                } else {
                    $('#tehsil').empty().append('<option value="">Select Tehsil</option>');
                }
            });

            $('#tehsil').change(function() {
                var janpad_name = $('#janpad_name').find(':selected').data('hindi_name');
                var block = $(this).val();
                
                if ( janpad_name && block ) {
                    $.ajax({
                        url: '/get-block',
                        type: 'GET',
                        data: { janpad_name: janpad_name, block: block },
                        success: function(response) {
                            var blockSelect =  $('#vikas_khand');
                            blockSelect.empty();
                            blockSelect.append('<option value="">Select Vikas Khand</option>');
                            $.each(response, function(index, value) {
                                blockSelect.append('<option value="' + value + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('#vikas_khand').empty().append('<option value="">Select Vikas Khand</option>');
                }
            });

            // $('#janpad').change(function() {
            //     $('#vikas_khand').prop('disabled', false);
            //     $('#vikas_khand').empty();
            //     $('#ai_center').prop('disabled', false);
            //     $('#ai_center').empty();
            //     $('#tehsil').prop('disabled', false);
            //     $('#tehsil').empty();
            //      $('#post_office').empty();
            
            //     // var mandal = $("#district option:selected").text();
            //     var janpad = $("#janpad option:selected").text();
            //     var janpad_id = $("#janpad option:selected").val();
            //     $.ajax({
            //         type: "GET",
            //         url: "get-all-tehsil-new",
            //         data: {
            //             // "mandal": mandal,
            //             "janpad": janpad,
            //             "janpad_id": janpad_id,
            //         },
            //         cache: false,
            //         success: function(data) {
            //             var getTehsil = data.data;
            //             var gramPanchayat = data.gram_panchayat;
            //             if (getTehsil && getTehsil.length > 0) {
            //                 $('#tehsil').append(`<option value="">Select Tehsil</option>`);
            //                 getTehsil.forEach(item => {
            //                     if (item.tehsil && item.tehsil.trim() !== '') {
            //                         $('#tehsil').append(
            //                             `<option value="${item.tehsil}">${item.tehsil}</option>`);
            //                     }
            //                 });

            //                 // if(gramPanchayat && gramPanchayat.length > 0){
            //                 //     $('#post_office').append(`<option value="">Select Post Office</option>`);
            //                 //     gramPanchayat.forEach(item => {
            //                 //         if (item.post_office && item.post_office.trim() !== '') {
            //                 //             $('#post_office').append(
            //                 //                 `<option value="${item.post_office}">${item.post_office}</option>`);
            //                 //         }
            //                 //     });
            //                 // }else{
            //                 //     $('#post_office').append('<option value="">No Record</option>');
            //                 // }

            //             } else {
            //                 $('#tehsil').append('<option value="">-Data not found.-</option>');
            //             }
            //         }
            //     });
            // });
            
            // $('#tehsil').change(function() {
            //     $('#vikas_khand').prop('disabled', false);
            //     $('#vikas_khand').empty();
            //     $('#ai_center').prop('disabled', false);
            //     $('#ai_center').empty();
            //     var tehsil = $(this).val();
            //     var mandal = $("#district option:selected").text();
            //     var janpad = $("#mandal option:selected").val();
            //     $.ajax({
            //         type: "GET",
            //         url: "get-all-block",
            //         data: {
            //             "tehsil": tehsil,
            //             "mandal": mandal,
            //             "janpad": janpad,
            //         },
            //         cache: false,
            //         success: function(data) {
            //             var getBlock = data.data;
            //             if (getBlock && getBlock.length > 0) {
            //                 $('#vikas_khand').append(`<option value="">Select Vikas Khand</option>`);
            //                 getBlock.forEach(item => {
            //                     if (item.block && item.block.trim() !== '') {
            //                         $('#vikas_khand').append(
            //                             `<option value="${item.block}">${item.block}</option>`);
            //                     }
            //                 });
            //             } else {
            //                 $('#vikas_khand').append('<option value="">-Data not found.-</option>');
            //             }
            //         }
            //     });
            // });
            
            // $('#vikas_khand').change(function() {
            //     $('#ai_center').prop('disabled', false);
            //     var block = $(this).val();
            //     var tehsil = $('#tehsil').val();
            //     var mandal = $("#district option:selected").text();
            //     var janpad = $("#mandal option:selected").val();
            //     $('#ai_center').empty();
            //     $.ajax({
            //         type: "GET",
            //         url: "get-all-aicenter",
            //         data: {
            //             "block": block,
            //             "tehsil": tehsil,
            //             "mandal": mandal,
            //             "janpad": janpad,
            //         },
            //         cache: false,
            //         success: function(data) {
            //             var getAiCenter = data.data;
            //             if (getAiCenter && getAiCenter.length > 0) {
            //                 $('#ai_center').append(`<option value="">Select AI Center</option>`);
            //                 getAiCenter.forEach(item => {
            //                     if (item.center_name && item.center_name.trim() !== '') {
            //                         $('#ai_center').append(
            //                             `<option value="${item.center_name}">${item.center_name}</option>`
            //                         );
            //                     }
            //                 });
            //             } else {
            //                 $('#ai_center').append('<option value="">-Data not found.-</option>');
            //             }
            //         }
            //     });
            // });

            // $('#janpad').change(function() {
            //     var val = $("#janpad option:selected").val();
            //     var text = $("#janpad option:selected").text();
            //     console.log('val',val,'text',text)
            //     if(val){
            //         $.ajax({
            //             type: "GET",
            //             url: "getAllBlocks",
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //             },
            //             data: {
            //                 "_token": "{{ csrf_token() }}",
            //                 "id": val,
            //                 "text":text,
            //             },
            //             cache: false,
            //             success: function(data) {
            //                 console.log('data',data)
            //                 var blocks = data.blocks;
            //                 var postoffice = data.postoffice;
            //                 var ai_center  =data.ai_center;
            //                 var tehsil    =  data.tehsil;
            //                 $('#vikas_khand').prop('disabled', false);
            //                 $('#vikas_khand').empty();
            //                 $('#post_office').prop('disabled', false);
            //                 $('#post_office').empty();
            //                 $('#ai_center').prop('disabled', false);
            //                 $('#ai_center').empty();
            //                 $('#tehsil').prop('disabled', false);
            //                 $('#tehsil').empty();
            //                 if(blocks.length>0){
            //                     $('#vikas_khand').append($("<option>-विकास खण्ड चुनें-</option>"));
            //                     blocks.forEach(item => {
            //                         $('#vikas_khand').append('<option value="'+item.block_name+'">' + item.block_name + '</option>')
            //                     });
            //                 }else{
            //                     $('#vikas_khand').append($("<option value=''>-Data not found.-</option>"));
            //                 }

            //                 if(postoffice.length>0){
            //                     $('#post_office').append($("<option value=''>-पोस्ट ऑफिस चुनें-</option>"));
            //                     postoffice.forEach(item => {
            //                         $('#post_office').append('<option value="'+item.post_office+'">' + item.post_office + '</option>')
            //                     });
            //                 }else{
            //                     $('#post_office').append($("<option value=''>-Data not found.-</option>"));
            //                 }
            //                 if(ai_center.length>0){
            //                     $('#ai_center').append($("<option value=''>-एआई सेंटर चुनें-</option>"));
            //                     ai_center.forEach(item => {
            //                         $('#ai_center').append('<option value="'+item.name+'">' + item.name + '</option>')
            //                     });
            //                 }else{
            //                     $('#ai_center').append($("<option value=''>-Data not found.-</option>"));
            //                 }
            //                 if(tehsil.length>0){
            //                     $('#tehsil').append($("<option value=''>-तहसील चुनें-</option>"));
            //                     tehsil.forEach(item => {
            //                         $('#tehsil').append('<option value="'+item.tehsil+'">' + item.tehsil + '</option>')
            //                     });
            //                 }else{
            //                     $('#tehsil').append($("<option value=''>-Data not found.-</option>"));
            //                 }
            //             }
            //         });
            //     }
            // });

            // $('#vikas_khand').change(function() {
            //     var val = $("#vikas_khand option:selected").val();
            //     var name = $("#vikas_khand option:selected").val();
            //     var janpad_id = $("#janpad option:selected").val();
            //     console.log('vikas_khand',val)
            //     if(val){
            //         $.ajax({
            //             type: "GET",
            //             url: "getAllGramPanchayat",
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //             },
            //             data: {
            //                 "_token": "{{ csrf_token() }}",
            //                 "id": val,
            //                 "janpad_id": janpad_id,
            //                 "name": name,
            //             },
            //             cache: false,
            //             success: function(data) {
            //                 // $('#gram_panchayat_name').prop('disabled', false);
            //                 // $('#gram_panchayat_name').empty();
            //                 // if(data.length>0){
            //                 //     console.log('data',data)
            //                 //     $('#gram_panchayat_name').append($("<option value=''>-ग्राम पंचायत चुनें-</option>"));
            //                 //     data.forEach(item => {
            //                 //         $('#gram_panchayat_name').append('<option value="'+item.gram_panchayat+'">' + item.gram_panchayat + '</option>')
            //                 //     });
            //                 // }else{
            //                 //     $('#gram_panchayat_name').append($("<option value=''>-Data not found.-</option>"));
            //                 // }
            //             }
            //         });
            //     }
            // });

            $('#applicant_photo').change(function(event) {
                var tmppath = URL.createObjectURL(event.target.files[0]);
                document.getElementById('applicant_photo_priview').src = window.URL.createObjectURL(this
                    .files[0]);
                $("#applicant_photo_url").html("<a href='" + tmppath + "' target='_blank'>View</a>");
            });

            $('#signature').change(function(event) {
                var tmppath = URL.createObjectURL(event.target.files[0]);
                document.getElementById('signature_priview').src = window.URL.createObjectURL(this.files[
                    0]);
                $("#signature_url").html("<a href='" + tmppath + "' target='_blank'>View</a>");
            });

            $('#high_marksheet').change(function(event) {
                var tmppath = URL.createObjectURL(event.target.files[0]);
                document.getElementById('high_marksheet_priview').src = window.URL.createObjectURL(this
                    .files[0]);
                $("#high_marksheet_url").html("<a href='" + tmppath + "' target='_blank'>View</a>");
            });

            $('#high_certificate').change(function(event) {
                var tmppath = URL.createObjectURL(event.target.files[0]);
                document.getElementById('high_certificate_priview').src = window.URL.createObjectURL(this
                    .files[0]);
                $("#high_certificate_url").html("<a href='" + tmppath + "' target='_blank'>View</a>");
            });

            $('#inter_marksheet').change(function(event) {
                var tmppath = URL.createObjectURL(event.target.files[0]);
                document.getElementById('inter_marksheet_priview').src = window.URL.createObjectURL(this
                    .files[0]);
                $("#inter_marksheet_url").html("<a href='" + tmppath + "' target='_blank'>View</a>");
            });

            $('#inter_certificate').change(function(event) {
                var tmppath = URL.createObjectURL(event.target.files[0]);
                document.getElementById('inter_certificate_priview').src = window.URL.createObjectURL(this
                    .files[0]);
                $("#inter_certificate_url").html("<a href='" + tmppath + "' target='_blank'>View</a>");
            });

            $('#graduation_marksheet').change(function(event) {
                var tmppath = URL.createObjectURL(event.target.files[0]);
                document.getElementById('graduation_marksheet_priview').src = window.URL.createObjectURL(
                    this.files[0]);
                $("#graduation_marksheet_url").html("<a href='" + tmppath + "' target='_blank'>View</a>");
            });

            $('#graduation_certificate').change(function(event) {
                var tmppath = URL.createObjectURL(event.target.files[0]);
                document.getElementById('graduation_certificate_priview').src = window.URL.createObjectURL(
                    this.files[0]);
                $("#graduation_certificate_url").html("<a href='" + tmppath + "' target='_blank'>View</a>");
            });

            $('#postgraduation_marksheet').change(function(event) {
                var tmppath = URL.createObjectURL(event.target.files[0]);
                document.getElementById('postgraduation_marksheet_priview').src = window.URL
                    .createObjectURL(this.files[0]);
                $("#postgraduation_marksheet_url").html("<a href='" + tmppath +
                    "' target='_blank'>View</a>");
            });

            $('#postgraduation_certificate').change(function(event) {
                var tmppath = URL.createObjectURL(event.target.files[0]);
                document.getElementById('postgraduation_certificate_priview').src = window.URL
                    .createObjectURL(this.files[0]);
                $("#postgraduation_certificate_url").html("<a href='" + tmppath +
                    "' target='_blank'>View</a>");
            });

            $('#training_certificate').change(function(event) {
                var tmppath = URL.createObjectURL(event.target.files[0]);
                document.getElementById('training_certificate_priview').src = window.URL.createObjectURL(
                    this.files[0]);
                $("#training_certificate_url").html("<a href='" + tmppath + "' target='_blank'>View</a>");
            });

            $('#id_upload').change(function(event) {
                var tmppath = URL.createObjectURL(event.target.files[0]);
                document.getElementById('id_upload_priview').src = window.URL.createObjectURL(this.files[
                    0]);
                $("#id_upload_url").html("<a href='" + tmppath + "' target='_blank'>View</a>");
            });

            $('#caste_certificate').change(function(event) {
                var tmppath = URL.createObjectURL(event.target.files[0]);
                document.getElementById('caste_certificate_priview').src = window.URL.createObjectURL(this
                    .files[0]);
                $("#caste_certificate_url").html("<a href='" + tmppath + "' target='_blank'>View</a>");
            });

            $('#health_certificate').change(function(event) {
                var tmppath = URL.createObjectURL(event.target.files[0]);
                document.getElementById('health_certificate_priview').src = window.URL.createObjectURL(this
                    .files[0]);
                $("#health_certificate_url").html("<a href='" + tmppath + "' target='_blank'>View</a>");
            });

            $("#high_marks").keypress(function(e) {
                var charCode = (e.which) ? e.which : e.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
            });

            $("#high_total_marks").keypress(function(e) {
                var charCode = (e.which) ? e.which : e.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
            });

            $("#inter_marks").keypress(function(e) {
                var charCode = (e.which) ? e.which : e.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
            });

            $("#inter_total_marks").keypress(function(e) {
                var charCode = (e.which) ? e.which : e.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
            });


            $("#graduation_marks").keypress(function(e) {
                var charCode = (e.which) ? e.which : e.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
            });

            $("#graduation_total_marks").keypress(function(e) {
                var charCode = (e.which) ? e.which : e.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
            });

            $("#postgraduation_marks").keypress(function(e) {
                var charCode = (e.which) ? e.which : e.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
            });

            $("#postgraduation_total_marks").keypress(function(e) {
                var charCode = (e.which) ? e.which : e.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
            });

        });

        $(function() {

            $("#high_marks, #high_total_marks").change(function() {

                if ($("#high_marks").val() != '' && $("#high_total_marks").val() != '') {
                    var result = parseFloat(parseInt($("#high_marks").val()) * 100) / parseInt($(
                        "#high_total_marks").val());
                    result = result.toFixed(2);
                    result = result.replace(/\.00$/, '');
                    $('#high_percentage').val(result || '');
                } else {

                    $('#high_percentage').val();
                }
            });

            $("#inter_marks, #inter_total_marks").change(function() {
                if ($("#inter_marks").val() != '' && $("#inter_total_marks").val() != '') {
                    var result = parseFloat(parseInt($("#inter_marks").val()) * 100) / parseInt($(
                        "#inter_total_marks").val());
                    result = result.toFixed(2);
                    result = result.replace(/\.00$/, '');
                    $('#inter_percentage').val(result || '');
                } else {

                    $('#inter_percentage').val();
                }
            });


            $("#graduation_marks, #graduation_total_marks").change(function() {
                if ($("#graduation_marks").val() != '' && $("#graduation_total_marks").val() != '') {
                    var result = parseFloat(parseInt($("#graduation_marks").val()) * 100) / parseInt($(
                        "#graduation_total_marks").val());
                    result = result.toFixed(2);
                    result = result.replace(/\.00$/, '');
                    $('#graduation_percentage').val(result || '');
                } else {

                    $('#graduation_percentage').val();
                }
            });

            $("#postgraduation_marks, #postgraduation_total_marks").change(function() {
                if ($("#postgraduation_marks").val() != '' && $("#postgraduation_total_marks").val() !=
                    '') {
                    var result = parseFloat(parseInt($("#postgraduation_marks").val()) * 100) / parseInt($(
                        "#postgraduation_total_marks").val());
                    result = result.toFixed(2);
                    result = result.replace(/\.00$/, '');
                    $('#postgraduation_percentage').val(result || '');
                } else {

                    $('#postgraduation_percentage').val();
                }
            });





            $("#training_adopted").change(function() {

                if ($('#training_adopted').val() == 'नहीं') {

                    $('.showHide').hide();
                    $('.showHideSummary').hide();
                    $('#yojna_name_for_training').val('');
                    $('#AIkit').prop('selectedIndex', 0);
                    $('#training_certificate_period_in_month').prop('selectedIndex', 0);
                    $('#training_certificate_period_in_days').prop('selectedIndex', 0);
                    $('#training_certificate').val(null);

                } else {

                    $('.showHide').show();
                    $('.showHideSummary').show();
                }
            });



        });


        $(function() {


            <?php
	
	if(@$result->training_adopted=='नहीं'){?>

            $('.showHide').hide();
            $('.showHideSummary').hide();

            <?php } else if(@$result->training_adopted==''){?>

            $('.showHide').hide();
            $('.showHideSummary').hide();

            <?php } else { ?>

            $('.showHide').show();
            $('.showHideSummary').show();

            <?php } ?>

            function toggleEduFields() {
                var checked = $('#edu_declaration').is(':checked');
                $('.exam-data input, .exam-data select, .exam-data textarea').each(function() {
                    if ($(this).attr('readonly')) return;
                    $(this).prop('disabled', !checked);
                });
                $('.exam-data').css('opacity', checked ? '1' : '0.4');
                $('.exam-data').css('pointer-events', checked ? '' : 'none');
            }

            toggleEduFields();

            $('#edu_declaration').on('change', function() {
                toggleEduFields();
                if (!$(this).is(':checked')) {
                    $('.exam-data input:not([readonly])').val('');
                    $('.exam-data select').val('');
                }
            });

            $("button#nextMe").click(function() {

                $("input").each(function() {
                    var name = $(this).attr("name");
                    var id = $(this).attr("id");
                    var val = $(this).val();

                    if ((id) && id !== "" && val != '') {
                        $('#' + id + '1').html(val);
                    }
                });


                $("select").each(function() {
                    var name = $(this).attr("name");
                    var id = $(this).attr("id");
                    var val = $(this).val();
                    var textValue = $(this).find('option:selected').text()
                    $('#' + id + '1').html(textValue);
                });


            });

            function togglePashuSakhi() {
                if ($('#gender').val() === 'महिला') {
                    $('#pashu_sakhi_field').show();
                } else {
                    $('#pashu_sakhi_field').hide();
                    $('input[name="pashu_sakhi"]').prop('checked', false);
                }
            }
            togglePashuSakhi();
            $('#gender').on('change', togglePashuSakhi);

            $('#myForm').on('submit', function(e) {
                if (!$('#edu_declaration').is(':checked')) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    $('#finalSubmit').show();
                    $('#loader').hide();
                    alert('कृपया शैक्षिक घोषणा चेकबॉक्स को चेक करें। / Please check the educational declaration checkbox before submitting.');
                    $('html, body').animate({ scrollTop: $('#edu_declaration').offset().top - 100 }, 500);
                }
            });
        });
    </script>
    <style>
        .form-control-span {
            display: block;
            width: 100%;
            font-size: 12px;
            line-height: 1.25;
            color: #060ded;
            background-color: #fff;
            background-image: none;
            -webkit-background-clip: padding-box;
            background-clip: padding-box;
            /*border: 1px solid rgba(0,0,0,.15);*/
            border-radius: 0.25rem;
            -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        }
    </style>
@endsection
