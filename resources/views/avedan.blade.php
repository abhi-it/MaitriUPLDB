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
                    'post_office',
                    'permanent_address',
                    'gram_panchayat_name',
                    'vikas_khand',
                    'letter_address',
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

    <div class="container main-div" style="background-color:white; height: 100%;">
        <!--First row Start -->
        <!--div class="scroll-left"><p>अभ्यर्थी का जनपद निवासी होना अनिवार्य है</p>
                     </div-->
        <marquee width="100%" direction="left" height="25px" style="font-size : 18px;font-weight: bold;">अभ्यर्थी को उत्तर
            प्रदेश के उस जनपद का निवासी होना अनिवार्य है , जिस जनपद के लिए आवेदन किया जा रहा है ।</marquee>
        <h1 style="margin-top:10px;text-align: center;">आवेदन - पत्र </h1>
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
                <h3 style="display:inline;font-size: 18px;">नियम और शर्तें</h3>
                <span class="step">2 </span>
                <h3 style="display:inline;font-size: 18px;">आवेदक का विवरण</h3>
                <span class="step">3 </span>
                <h3 style="display:inline;font-size: 18px;">शैक्षिक योग्यता व अन्य विवरण </h3>
                <span class="step">4 </span>
                <h3 style="display:inline;font-size: 18px;">सारांश
                </h3>
            </div>
            <hr>

            <div class="tab">
                <h3>नियम एवं शर्तें </h3>
                <div class="row">

                    <div class="form-group col-md-12" style="font-size: 16px;">
                        <h5><b><span>राष्ट्रीय गोकुल मिशन अन्तर्गत कृत्रिम गर्भाधान आच्छादन बढ़ाने हेतु स्वरोजगारी मैत्री की
                                    स्थापना नियम-शर्तें निम्न प्रकार हैं-</span></b></h5>
                        <br><b>1:- योग्यता : </b><br>

                        <b>(क) </b>शैक्षिक योग्यता: अनिवार्य न्यूनतम अर्हता हाईस्कूल (विज्ञान वर्ग) उत्तीर्ण हो, इण्टर (जीव विज्ञान) को वरीयता दी जायेगी। <br>
                        <b>(ख) </b>आवेदक चयनित क्षेत्र की ग्राम पंचायत का निवासी हो। <br>
                        <b>(ग) </b>पूर्णतः स्वस्थ एवं कार्य करने के योग्य हो। पशुपालक के द्वार पर पहुँच कर सेवा कर सके। राजकीय चिकित्साधिकारी द्वारा प्रदत्त स्वास्थ्य प्रमाण -पत्र अपलोड करना अनिवार्य है।<br>
                        <b>(घ) </b>वोटर आई.डी. कार्ड/आधार कार्ड/पैन कार्ड आदि अन्य फोटो युक्त आईडी जो निर्वाचन आयोग से अनुमन्य है अपलोड करना अनिवार्य है। <br>
                        <b>(ड) </b>मैत्री चयन हेतु निर्धारित मानक के अनुसार यदि दो या दो से अधिक अभ्यर्थियों के कुल प्राप्त अंकों में समानता हो तो प्रथम दृष्टया प्रवासी श्रमिकों/पशु सखी/पैरावेट (जो वर्तमान में पशुचिकित्सा अधिकारी की देख-रेख में कार्य कर रहा हो) अभ्यर्थी को, तत्पश्चात् अधिक उम्र के अभ्यर्थी को वरीयता दी जायेगी।<br>
                        <b>2:-</b> आवेदक की आयु दिनांक 01.10.2023 को न्यूनतम् 18 वर्ष हो।<br>
                        <b>3:-</b> आवेदन पत्र जमा करने की अन्तिम तिथि:- 25.10.2023<br>
                        <b>4:-</b> यह योजना पूर्णतः स्वरोजगार सृजन की अवधारणा पर आधारित है। आवेदक को किसी भी स्थिति में शासकीय सेवा में संविलियन का कोई अधिकार नहीं होगा। चयनित अभ्यर्थी को 35 दिनों का सैद्धान्तिक प्रशिक्षण एवं 55 दिनों का व्यावहारिक प्रशिक्षण कराया जायेगा। चयनित अभ्यर्थी को सफलतापूर्वक प्रशिक्षण पूर्ण करने के उपरान्त मैत्री (मल्टीपरपज ए0आई0 टेक्निशियन इन रूरल इण्डिया) के रूप में कार्य करने हेतु प्रमाण-पत्र, बायोलॉजिकल कण्टेनर्स तथा ए0आई0किट आदि उपलब्ध कराये जायेगें। <br>
                        <b>5:-</b> चयनित अभ्यर्थियों को चयनोपरान्त इस आशय का शपथ-पत्र देना होगा कि वे एक स्वरोजगारी के रूप में कार्य करेगें। सरकारी सेवा में किसी भी स्थिति में संविलियन का कोई अधिकार नहीं होगा तथा इसके लिए कभी दावा नहीं करेगें। <br>
                        <b>6:- </b> मैत्री का कार्य प्रारम्भ करने की तिथि से 5 वर्ष की अवधि के पूर्व कार्य बन्द कर देने की अवस्था में प्रशिक्षण की अवधि में योजनान्तर्गत व्यय की गई धनराशि तथा समस्त उपकरण सही अवस्था में वापस करने के लिये वचनबद्ध रहेंगे।<br>
                        <b>7:- </b> चयन के उपरांत आवेदनकर्ता को सक्षम स्तर से जारी स्वास्थ्य प्रमाण-पत्र मुख्य पशु चिकित्साधिकारी कार्यालय में जमा कराना अनिवार्य होगा। <br>
                        <b>8:- </b> <span style="color:Red">आवश्यक सूचना / अद्यतन जानकारी इस पोर्टल पर ही उपलब्ध रहेगी। इस सम्बन्ध में पृथक से कोई भी सूचना नहीं दी जायेगी।</span> <br>
                        <span style="color:Red"> नोट :- उ0प्र0 पशुधन विकास परिषद द्वारा जनपदवार चयन किये जाने वाले
                            स्वरोजगारी मैत्री (मल्टीपरपज ए0आई0 टेक्निशियन इन रूरल इण्डिया) की संख्या पोर्टल पर उपलब्ध है।
                        </span>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">अगर आप सहमत हैं तो चिन्हित करें</label> <span class="text-danger">*</span>
                        <input type="checkbox" name="tc" id="tc" {{ $result->t_and_c == '1' ? 'checked' : '' }}
                            value="1">
                    </div>

                </div>
            </div>

            <div class="tab">
                <?php //echo '<pre>';print_r($result);
                ?>
                <h3>आवेदक का विवरण </h3>
                <div class="row">

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">आवेदक का नाम </label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" name="applicant_name" id="applicant_name"
                            placeholder="आवेदक का नाम" autocomplete="off" value="{{ $result->applicant_name }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputPassword4">पिता / पति का नाम </label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" id="fname" name="fname"
                            placeholder="पिता  / पति का नाम" autocomplete="off" value="{{ $result->fname }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputPassword4">माता का नाम </label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" id="mother" name="mother" placeholder="माता का नाम"
                            autocomplete="off" value="{{ $result->mother }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">लिंग</label> <span class="text-danger">*</span>
                        <select class="form-control" name="gender" id="gender">
                            <option value="">चुने</option>
                            <option value="पुरुष" {{ $result->gender == 'पुरुष' ? 'selected' : '' }}>पुरुष</option>
                            <option value="महिला" {{ $result->gender == 'महिला' ? 'selected' : '' }}>महिला</option>
                            <option value="ट्रांसजेंडर" {{ $result->gender == 'ट्रांसजेंडर' ? 'selected' : '' }}>
                                ट्रांसजेंडर
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">जन्म तिथि (हाई स्कूल प्रमाण-पत्र के अनुसार)</label> <span
                            class="text-danger">* ( उम्र 18 से 40 वर्ष के बीच में होनी चाहिये )</span>
                        <?php
                        //echo '<pre>';print_r($result);
                        if ($result->dob != '') {
                            $dob = date('Y-m-d', strtotime($result->dob));
                        } else {
                            $dob = '';
                        }
                        ?>
                        <input type="text" class="form-control" name="dob" id="dob" placeholder="जन्म तिथि"
                            readonly value="{{ $dob }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">दूरभाष / मोबाइल नंबर</label> <span class="text-danger">*</span>
                        <input maxlength="10" type="text" class="form-control" name="mobile" id="mobile"
                            placeholder="दूरभाष / मोबाइल नंबर" autocomplete="off" value="{{ $result->mobile }}"
                            onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">श्रेणी</label> <span class="text-danger">*</span>
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
                        <label for="inputPassword4">स्थायी पता </label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" name="permanent_address" id="permanent_address"
                            placeholder="स्थायी पता" autocomplete="off" value="{{ $result->permanent_address }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">स्थायी पते के प्रमाण-पत्र का प्रकार</label> <span
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
                        <label for="inputPassword4">स्थायी पता का प्रमाण-पत्र अपलोड करें </label> <small
                            style="color:red;">Note: JPG, JPEG, PNG files only (Max. 100 KB)</small>
                        <input type="file" class="form-control" name="permanent_address_proof"
                            id="permanent_address_proof" autocomplete="off">
                    </div>


                    <div class="form-group col-md-6">
                        <label for="inputPassword4">जनपद </label> <span class="text-danger">*</span>
                        <select class="form-control" name="janpad" id="janpad">
                            <option value="">जनपद चुनें </option>
                            @foreach ($districts as $row)
                                <option value="{{ $row->id }}"
                                    {{ $result->district_id == $row->id ? 'selected' : '' }}>{{ $row->name_hindi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">विकास खण्ड </label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" name="vikas_khand" id="vikas_khand"
                            placeholder="विकास खण्ड" autocomplete="off" value="{{ $result->vikas_khand }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">ग्राम पंचायत का नाम</label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" name="gram_panchayat_name" id="gram_panchayat_name"
                            placeholder="ग्राम पंचायत का नाम" autocomplete="off"
                            value="{{ $result->gram_panchayat_name }}">
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">पत्र - व्यवहार का पता </label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" name="letter_address" id="letter_address"
                            placeholder="पत्र  - व्यवहार का पता" autocomplete="off"
                            value="{{ $result->letter_address }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputPassword4">पोस्ट ऑफिस </label> <span class="text-danger">*</span>
                        <input type="text" class="form-control" name="post_office" id="post_office"
                            placeholder="पोस्ट ऑफिस" autocomplete="off" value="{{ $result->post_office }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">पिनकोड </label> <span class="text-danger">*</span>
                        <input maxlength="6" type="text" class="form-control" name="pincode" id="pincode"
                            placeholder="पिनकोड" autocomplete="off" value="{{ $result->pincode }}"
                            onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">ई-मेल </label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="ई -मेल"
                            autocomplete="off" value="{{ $result->email }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">आवेदक की फोटो </label> <span class="text-danger">*</span> <small
                            style="color:red;">Note: JPG, JPEG, PNG files only (Max. 20 KB)</small>
                        <input type="file" class="form-control" name="applicant_photo" id="applicant_photo"
                            placeholder="आवेदक की फोटो">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputPassword4">आवेदक का हस्ताक्षर </label> <span class="text-danger">*</span> <small
                            style="color:red;">Note: JPG, JPEG, PNG only (Max. 20 KB)</small>
                        <input type="file" class="form-control" name="signature" id="signature"
                            placeholder="आवेदक  का हस्ताक्षर">
                    </div>

                </div>
            </div>

            <div class="tab">
                <h3>शैक्षिक योग्यता व अन्य विवरण
                    <div class=" pull-right">
                        <small style="color:red;font-size:10px;margin-right: 200px;">Note: JPG, JPEG, PNG files only (Max.
                            100 KB)</small>
                    </div>
                </h3>
                <div class="row">

                    <div class="container">
                        <div class="row"
                            style="font-size: 13px;background: black;color: white;padding: 10px;font-weight: bold;">
                            <div class="col align-self-center">उत्तीर्ण परीक्षा का नाम</div>
                            <div class="col align-self-center" style="padding-right: 250px;">बोर्ड का नाम</div>
                            <div class="col align-self-center">उत्तीर्ण वर्ष</div>
                            <div class="col align-self-center">प्राप्तांक</div>
                            <div class="col align-self-center">पूर्णांक</div>
                            <div class="col align-self-center">प्रतिशत</div>
                            <div class="col align-self-center" style="font-size: 12px;">अंकतालिका अपलोड करें</div>
                        </div>

                        <div class="row" style="font-size: 14px;margin-top: 5px;">
                            <div class="col align-self-center" style="font-size: 11px;">हाई स्कूल (विज्ञान वर्ग)<span
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
                            <div class="col align-self-center" style="font-size: 11px;">इंटरमीडिएट (विज्ञान वर्ग)</div>
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
                            <div class="col align-self-center" style="font-size: 11px;">स्नातक</div>
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
                            <div class="col align-self-center" style="font-size: 11px;">परास्नातक</div>
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

                </div>


                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">यदि पूर्व में प्राइवेट कृत्रिम गर्भाधान कार्यकर्त्ता के सम्बन्ध मै
                            प्रशिक्षण प्राप्त किया है तो योजनान्तर्गत जारी प्रमाण-पत्र </label> <span
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
                        <label for="inputEmail4">राज्य / केंद्र सरकार द्वारा मान्यता प्राप्त संस्थान से यदि पूर्व में
                            कृत्रिम गर्भाधान के प्रशिक्षण का प्रमाण-पत्र प्राप्त किया हो (प्रमाण - पत्र अपलोड करें)</label>
                        <small style="color:red;">Note: JPG, JPEG, PNG files only (Max. 100 KB)</small>
                        <input type="file" class="form-control" name="training_certificate"
                            id="training_certificate">
                    </div>

                    <div class="form-group col-md-4" style="margin-top: 35px;">
                        <label for="inputEmail4">प्रशिक्षण की अवधि माह</label>
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
                        <label for="inputEmail4">योजना का नाम जिसके अंतर्गत प्रशिक्षण प्राप्त किया गया</label> <span
                            class="text-danger">*</span>
                        <input type="text" class="form-control" value="{{ $result->yojna_name_for_training }}"
                            name="yojna_name_for_training" id="yojna_name_for_training">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">प्रशिक्षणोपरांत ए. आई. किट तथा बायोलोजिकल कन्टेनर प्राप्त किये गये
                            है</label> <span class="text-danger">*</span>
                        <select class="form-control" name="AIkit" id="AIkit">
                            <option value="">चुनें</option>
                            <option value="हाँ" {{ $result->AIkit == 'हाँ' ? 'selected' : '' }}>हाँ</option>
                            <option value="नहीं" {{ $result->AIkit == 'नहीं' ? 'selected' : '' }}>नहीं</option>
                        </select>
                    </div>

                </div>


                <div class="row" style="padding-top:30px;">

                    <div class="form-group col-md-12">
                        <label for="inputEmail4">वोटर आई डी कार्ड / आधार कार्ड / पैन कार्ड आदि अन्य फोटो युक्त आईडी जो
                            निर्वाचन आयोग से अनुमन्य है, में से कोई एक अपलोड करें</label> <span
                            class="text-danger">*</span> <small style="color:red;">Note: JPG, JPEG, PNG files only (Max.
                            100 KB)</small>
                        <input type="file" class="form-control" name="id_upload" id="id_upload">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputEmail4">जाति (अनुसूचित जाति) श्रेणी हेतु न्याय अधिकारी द्वारा जारी प्रमाण - पत्र
                            अपलोड करें</label> <small style="color:red;">Note: JPG, JPEG, PNG files only (Max. 100
                            KB)</small>
                        <input type="file" class="form-control" name="caste_certificate" id="caste_certificate">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputEmail4">राजकीय चिकित्साधिकारी द्वारा प्रदत्त स्वास्थ्य प्रमाण - पत्र अपलोड
                            करें</label>
                        <!--span class="text-danger">*</span> <small style="color:red;">Note: JPG, JPEG, PNG files only (Max. 100 KB)</small-->
                        <input type="file" class="form-control" name="health_certificate" id="health_certificate">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputEmail4">राष्ट्रीयता </label> <span class="text-danger">*</span>
                        <select class="form-control" name="nationality" id="nationality">
                            <option value="">चुनें</option>
                            <option selected="selected" value="भारतीय"
                                {{ $result->nationality == 'भारतीय' ? 'selected' : '' }}>भारतीय</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12"><span class="text-danger">*</span>
                        <input type="checkbox" name="declaration" id="declaration" value="1">
                        <label for="inputEmail4" style="font-weight: bold;
    font-size: 16px;">मै एतद्‌द्वारा यह घोषणा
                            करता / करती हूँ कि मैं __<span style="font-weight:normal;" id="applicant_named"></span>__
                            पुत्र / पुत्री / पत्नी _<span style="font-weight:normal;" id="fnamed">SA</span>_ निवासी
                            ग्राम _<span style="font-weight:normal;" id="janpad_gram">DA</span>_ ग्राम पंचायत _<span
                                style="font-weight:normal;" id="gram_panchayat_named">GH</span>_ विकास खंड _<span
                                style="font-weight:normal;" id="vikas_khandd">BB</span>_ जनपद _<span
                                style="font-weight:normal;" id="janpadd">Agra</span>_ का निवासी हूँ | मैं आवेदन पत्र के
                            साथ संलग्न नियम - शर्तो से पूर्णत: अवगत हूँ | मै पूर्णत: स्वस्थ हूँ एवं पशुपालक के द्वार पर
                            पहुँच कर सेवा करने योग्य हूँ | यदि कोई विवरण / सूचना असत्य पायी जाती है या तथ्य मेरे द्वारा
                            छिपाया पाया जाता है तो मेरा आवेदन चयनोपरांत भी निरस्त कर दिया जाए |

                            <br><br>स्थान : <span style="font-weight:normal;" id="janpaddD"></span>
                            <br>दिनांक : <span style="font-weight:normal;"><?php echo date('d-m-Y'); ?></span>
                        </label>
                    </div>
                </div>

            </div>


            <!------Summary Page Start---------------->
            <div class="tab">
                <h3>आवेदक का विवरण </h3>
                <div class="row">

                    <div class="form-group col-md-4">
                        <label for="inputEmail4">आवेदक का नाम </label>
                        <span class="form-control-span" id="applicant_name1">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4">पिता / पति का नाम </label>
                        <span class="form-control-span" id="fname1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4">माता का नाम </label>
                        <span class="form-control-span" id="mother1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputEmail4">जन्म तिथि (हाई स्कूल प्रमाण पत्र के अनुसार)</label>
                        <span class="form-control-span" id="dob1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputEmail4">दूरभाष / मोबाइल नंबर</label>
                        <span class="form-control-span" id="mobile1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputEmail4">श्रेणी</label>
                        <span class="form-control-span" id="category1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4">स्थायी पता </label>
                        <span class="form-control-span" id="permanent_address1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputEmail4">स्थायी पता का प्रमाण का प्रकार</label>
                        <span class="form-control-span" id="address_type1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4">स्थायी पता का प्रमाण - पत्र </label>
                        <span class="form-control-span" id="permanent_address_proof1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4">पोस्ट ऑफिस </label>
                        <span class="form-control-span" id="post_office1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4">पिनकोड </label>
                        <span class="form-control-span" id="pincode1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputEmail4">ग्राम पंचायत का नाम</label>
                        <span class="form-control-span" id="gram_panchayat_name1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputEmail4">लिंग</label>
                        <span class="form-control-span" id="gender1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4">जनपद </label>
                        <span class="form-control-span" id="janpad1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputEmail4">विकास खण्ड </label>
                        <span class="form-control-span" id="vikas_khand1"></span>
                    </div>


                    <div class="form-group col-md-4">
                        <label for="inputEmail4">पत्र -व्यवहार का पता </label>
                        <span class="form-control-span" id="letter_address1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4">ई - मेल </label>
                        <span class="form-control-span" id="email1"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4">आवेदक की फोटो </label>
                        <span class="form-control-span"><img id="applicant_photo_priview" width="100"></span>
                        <span class="form-control-span" id="applicant_photo_url" style="margin-left: 36px;"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4">आवेदक का हस्ताक्षर </label>
                        <span class="form-control-span"><img id="signature_priview" width="100"></span>
                        <span class="form-control-span" id="signature_url" style="margin-left: 36px;"></span>
                    </div>

                </div>


                <hr>
                <div class="row">

                    <h3>शैक्षिक योग्यता व अन्य विवरण </h3>
                    <br>
                    <div class="row table-responsive">
                        <table class="table">
                            <tr>
                                <td style="width: 12%;">उत्तीर्ण परीक्षा का नाम</td>
                                <td>बोर्ड का नाम</td>
                                <td>उत्तीर्ण वर्ष</td>
                                <td>प्राप्तांक</td>
                                <td>पूर्णांक</td>
                                <td>प्रतिशत</td>
                                <td>अंकतालिका </td>
                                <td>प्रमाण - पत्र</td>
                            </tr>
                            <tr>
                                <td>हाई स्कूल (विज्ञान वर्ग)</td>
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
                                <td width="10%">इण्टर (जीव विज्ञान)</td>
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
                                <td width="10%">स्नातक</td>
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
                                <td width="10%">परास्नातक</td>
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
                            <label for="inputEmail4">योजनान्तर्गत प्रशिक्षण का प्रमाण-पत्र</label>
                            <span class="form-control-span" id="training_adopted1"></span>
                        </div>

                    </div>



                    <div class="row showHideSummary">

                        <div class="form-group col-md-4">
                            <label for="inputEmail4">राज्य / केंद्र सरकार द्वारा मान्यता प्राप्त संस्थान से यदि पूर्व में
                                कृत्रिम गर्भाधान के प्रशिक्षण का प्रमाण पत्र प्राप्त किया हो</label>

                            <span class="form-control-span"><img id="training_certificate_priview" width="100"></span>
                            <span class="form-control-span" id="training_certificate_url"
                                style="margin-left: 36px;"></span>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputEmail4">प्रशिक्षण की अवधि माह</label>
                            <span class="form-control-span" id="training_certificate_period_in_month1"></span>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputEmail4">दिन</label>
                            <span class="form-control-span" id="training_certificate_period_in_days1"></span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4">योजना का नाम जिसके अंतर्गत प्रशिक्षण प्राप्त किया गया</label>
                            <span class="form-control-span" id="yojna_name_for_training1"></span>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4">प्रशिक्षणोपरांत ए. आई. किट तथा बायोलोजिकल कन्टेनर प्राप्त किये गये
                                है</label>
                            <span class="form-control-span" id="AIkit1"></span>
                        </div>

                    </div>


                    <div class="row" style="padding-top:30px;">

                        <div class="form-group col-md-12">
                            <label for="inputEmail4">वोटर आई डी कार्ड / आधार कार्ड / पैन कार्ड की प्रति</label>
                            <span class="form-control-span"><img id="id_upload_priview" width="100"></span>
                            <span class="form-control-span" id="id_upload_url" style="margin-left: 36px;"></span>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputEmail4">जाति (अनुसूचित जाति श्रेणी हेतु न्याय अधिकारी द्वारा जारी प्रमाण
                                पत्र</label>
                            <span class="form-control-span"><img id="caste_certificate_priview" width="100"></span>
                            <span class="form-control-span" id="caste_certificate_url" style="margin-left: 36px;"></span>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputEmail4">राजकीय चिकित्साधिकारी द्वारा प्रदत्त स्वास्थ्य प्रमाण-पत्र</label>
                            <span class="form-control-span"><img id="health_certificate_priview" width="100"></span>
                            <span class="form-control-span" id="health_certificate_url"
                                style="margin-left: 36px;"></span>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="inputEmail4">राष्ट्रीयता </label>
                            <span class="form-control-span" id="nationality1"></span>
                        </div>
                    </div>


                </div>


            </div>


            <!------Summary Page End---------------->

            <div style="overflow:auto;margin-bottom:20px;">
                <div style="float:right; margin-top: 5px;" id="finalSubmit">
                    <button type="button" class="previous buttonWizard">Previous</button>
                    <button type="button" class="next buttonWizard" id="nextMe">Save & Next</button>
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
