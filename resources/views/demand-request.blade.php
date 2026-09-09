@extends('submaster')
@section('content')
<style>
form#loginForm {
    padding: 15px 35px;
    width: 88%;
    margin: 40px auto;
}

form#loginForm p span {
    margin-bottom: 40px !important;
    display: block;
    margin-top: 14px;
}

.demand-request-remove-btn {
    padding: 9px 25px;
    border-radius: 5px;
}

@media screen and (max-width: 767px) {
    form#loginForm {
        width: 100%;
    }
}
</style>
<div class="container main-div py-5" style="background-color:white; height: 100%; min-height:380px;">
    <!--First row Start -->

    <h3 class="text-center fw-bold m-4">
        <span data-hi="मासिक मांग अनुरोध पत्र" data-en="Monthly Demand Request Form"></span>
    </h3>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if($errors)
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
    @endif
    <form method="POST" action="{{ route('addDemandRequests') }}" id="loginForm" name="loginForm"
        enctype="multipart/form-data" class="form-comman">
        <p class="text-danger text-center ml-2 fs-6 fw-bold">
            <span data-hi="कृपया यह फॉर्म केवल एक बार भरें" data-en="Please fill up this form only once"></span>
        </p>
        @csrf
        <div class="row">

            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="नाम" data-en="Name"></span> </label>
                <input name="name" id="name" type="text" required class="form-control" data-placeholder-en="Name"
                    data-placeholder-hi="नाम" autofocus="off">
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="जन्म की तारीख" data-en="Date of Birth"></span> </label>
                <input name="date_of_birth" id="date_of_birth" required type="date" data-placeholder-en="Date of Birth"
                    data-placeholder-hi="जन्म की तारीख" class="form-control" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="लिंग" data-en="Gender"></span> </label>
                <select name="gender" id="gender" class="form-control" required autofocus>
                    <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                    <option value="male" data-hi="पुरुष" data-en="Male"></option>
                    <option value="female" data-hi="महिला" data-en="Female"></option>
                    <option value="other" data-hi="अन्य" data-en="Other"></option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="प्रशिक्षण केंद्र का नाम"
                        data-en="Name of the Training Center"></span> </label>
                <select name="training_center_id" id="training_center_id" required class="form-control" autofocus>
                    <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                    @foreach($institute as $val)
                    <option value="{{$val->name}}" data-hi="{{$val->name}}" data-en="{{$val->name}}"></option>
                    @endforeach
                    <option value="other" data-hi="अन्य" data-en="Other"></option>
                </select>
            </div>

            <div class="form-group col-md-6 added_vh_ai_center">
                <label for="inputEmail4"> <span data-hi="कृपया प्रशिक्षण केंद्र का नाम दर्ज करें"
                        data-en="Please Enter Training Center Name "></span> </label>
                <input name="training_center_id" id="training_center_added" required type="text" class="form-control"
                    data-placeholder-hi="प्रशिक्षण केंद्र का नाम दर्ज करें"
                    data-placeholder-en="Enter Training Center Name">
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="प्रशिक्षण समापन वर्ष"
                        data-en="Training Completion Year"></span> </label>
                <input name="training_year" id="training_year" required type="text"
                    data-placeholder-en="Training Completion Year" data-placeholder-hi="प्रशिक्षण समापन वर्ष"
                    placeholder="" class="form-control" autofocus>
            </div>


            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="भारत पशुधन आईडी" data-en="Bharat Livestock ID"></span> </label>
                <input name="bharat_pashudhan_id" required id="bharat_pashudhan_id" type="text"
                    data-placeholder-en="Bharat Livestock ID" data-placeholder-hi="भारत पशुधन आईडी" class="form-control"
                    autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="व्हाट्सएप मोबाइल नंबर" data-en="WhatsApp Mobile Number"></span>
                </label>
                <input name="smart_mobile_no" id="smart_mobile_no" required type="text" class="form-control"
                    data-placeholder-en="WhatsApp Mobile Number" data-placeholder-hi="व्हाट्सएप मोबाइल नंबर" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="मंडल" data-en="Mandal"></span> </label>
                <select name="district" id="district" class="form-control" autofocus required>
                    <option value="" data-hi="मंडल चुनें" data-en="Select Mandal"></option>
                    @if(count($division)>0)
                    @foreach($division as $key=>$val)
                    <option value="{{$val->id}}">{{$val->name_hindi}}</option>
                    @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="ज़िला" data-en="District"></span> </label>
                <select name="mandal" id="mandal" class="form-control" autofocus required>

                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="तहसील" data-en="Tehsil"></span> </label>
                <select name="tehsil" id="tehsil" class="form-control" placeholder="तहसील" autofocus required>

                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="विकास खण्ड" data-en="Vikas Khand"></span> </label>
                <select name="vikas_khand" id="vikas_khand" class="form-control" required placeholder="विकास खण्ड"
                    autofocus>

                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="एआई सेंटर (पशु चिकित्सा अस्पताल / एलईओ सेंटर)"
                        data-en="AI Centre (Veterinary Hospital / LEO Center)"></span> </label>
                <select name="vh_ai_center" id="ai_center" class="form-control" autofocus required>

                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="पोस्ट ऑफिस" data-en="Post Office"></span> </label>
                <input type="text" name="post_office" id="post_office" required class="form-control"
                    placeholder="पोस्ट ऑफिस" autofocus>
            </div>


            <div class="form-group col-md-6">
                <label for="inputEmail4"><span data-hi="पिनकोड" data-en="Pincode"></span></label>
                <span id="error-message" style="color: red; display:none; font-size:10px; ">(Pincode must be a 6-digit
                    number.)</span>
                <input type="text" name="pincode" maxlength="6" required id="pincode" class="form-control"
                    data-placeholder-en="Enter Pincode Here" data-placeholder-hi="यहां पिनकोड दर्ज करें" autofocus>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="आपके भारत पशुधन आईडी पर कितने गांव मैप किए गए हैं"
                        data-en="How many Villages are mapped on your Bharat Pashudhan ID"></span> </label>
                <input name="villages_coevring" id="villages_coevring" required type="text" class="form-control"
                    data-placeholder-en="How many Villages are mapped on your Bharat Pashudhan ID"
                    data-placeholder-hi="आपके भारत पशुधन आईडी पर कितने गांव मैप किए गए हैं" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="तरल नाइट्रोजन (लीटर में)" data-en="Liquid Nitrogen (in Litre)"></span>
                </label>
                <input name="demand_section" id="demand_section" required type="text" class="form-control"
                    data-placeholder-hi="तरल नाइट्रोजन" data-placeholder-en="Liquid Nitrogen (in Litre)" autofocus>
            </div>



            <div class="form-group col-md-12 pt-4 main_div_block" style="background: #eee;">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">
                            <span data-hi="प्रजाति वीर्य" data-en="Species Semen"></span>
                        </label>
                        <select name="semen[]" id="semen" class="form-control" required autofocus>
                            <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                            <option value="cow" data-hi="गाय" data-en="Cattle"></option>
                            <option value="buffalo" data-hi="भैंस" data-en="Buffalo"></option>
                            <option value="goat" data-hi="बकरी" data-en="Goat"></option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail4"> <span data-hi="वीर्य प्रकार" data-en="Semen Type"></span> </label>
                        <select name="semen_type[]" id="semen_type" required class="form-control" autofocus>
                            <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                            <option value="conventional" data-hi="सामान्य" data-en="Conventional"></option>
                            <option value="sexed" data-hi="वर्गीकृत" data-en="Sexed"></option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail4"> <span data-hi="वीर्य का स्रोत" data-en="Source of Semen"></span>
                        </label>
                        <select name="semen_source[]" id="semen_source" required class="form-control" autofocus>
                            <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                            <option value="UPLDB" data-hi="यूपीएलडीबी" data-en="UPLDB"></option>
                            <option value="BAIF" data-hi="बीएआईएफ़" data-en="BAIF"></option>
                            <option value="ABC Salon" data-hi="एबीसी सैलून" data-en="ABC Salon"></option>
                            <option value="Amul" data-hi="अमूल" data-en="Amul"></option>
                            <option value="Haryana" data-hi="हरियाणा" data-en="Haryana"></option>
                            <option value="Hissar Bovine" data-hi="हिसार गोजातीय" data-en="Hissar Bovine"></option>
                            <option value="Morna Breeding" data-hi="मोरना प्रजनन" data-en="Morna Breeding"></option>
                            <option value="others" data-hi="अन्य" data-en="Others"></option>
                        </select>
                    </div>

                    <div class="form-group col-md-4 semen_source_added">
                        <label for="inputEmail4"> <span data-hi="कृपया वीर्य का स्रोत भरें"
                                data-en="Please enter source of semen"></span> </label>
                        <input type="text" name="semen_source[]" required class="form-control" id="semen_source_added"
                            data-placeholder-hi="वीर्य का स्रोत" data-placeholder-en="Source of Semen">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail4"> <span data-hi="नस्ल" data-en="Breed"></span> </label>
                        <input name="breed[]" id="breed" type="text" required class="form-control"
                            data-placeholder-hi="नस्ल" data-placeholder-en="Breed" autofocus>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail4"> <span data-hi="बुल आई.डी." data-en="Bull ID"></span> </label>
                        <input name="bull_id[]" id="bull_id" type="text" required class="form-control"
                            data-placeholder-hi="बुल आई.डी." data-placeholder-en="Bull ID" autofocus>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail4"> <span data-hi="एआई शीथ की मात्रा" data-en="AI Sheath Quantity"></span>
                        </label>
                        <input name="Sheath[]" id="Sheath" type="text" required class="form-control"
                            data-placeholder-hi="शीत क्वांटिटी" data-placeholder-en="AI Sheath Quantity" autofocus>
                    </div>
                    <div class="form-group col-md-12 text-center">
                        <span class="add btn btn-primary btn-sm demand-request-add-btn">Add More</span>
                        <!-- <span class="remove">Remove</span> -->
                    </div>
                </div>
            </div>


            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="एआई ग्लव्स की मात्रा" data-en="AI Gloves Quantity"></span>
                </label>
                <input name="gloves" id="gloves" type="text" required class="form-control"
                    data-placeholder-hi="एआई ग्लव्स की मात्रा" data-placeholder-en="AI Gloves Quantity" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="कितने पशु टैग की आवश्यकता है?"
                        data-en="How many Animal Tags are required?"></span>
                </label>
                <input name="animal_tag" id="animal_tag" type="text" required class="form-control"
                    data-placeholder-hi="पशु टैग की आवश्यकता" data-placeholder-en="How many Animal Tags are required?"
                    autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="खनिज मिश्रण (किलोग्राम में)"
                        data-en="Mineral mixtures (In Kg)"></span> </label>
                <input name="mineral_mixture" id="mineral_mixture" required type="text" class="form-control"
                    data-placeholder-hi="खनिज मिश्रण (किलोग्राम में)" data-placeholder-en="Mineral mixtures (In Kg)"
                    autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="कृमिनाशक (बोलस)" data-en="Bolus"></span> </label>
                <input name="dewormer" id="dewormer" type="text" required class="form-control"
                    data-placeholder-hi="कृमिनाशक" data-placeholder-en="Bolus" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="बीमा पुस्तिका" data-en="Insurance Booklet"></span> </label>
                <input name="insurance_booklet" id="insurance_booklet" required type="text" class="form-control"
                    data-placeholder-hi="बीमा पुस्तिका" data-placeholder-en="Insurance Booklet" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="गर्भावस्था फ़ीड (किलोग्राम में) "
                        data-en="Pregnancy Feed (In Kg)"></span> </label>
                <input name="pregnancy_feed" id="pregnancy_feed" required type="text" class="form-control"
                    data-placeholder-hi="गर्भावस्था फ़ीड" data-placeholder-en="Pregnancy Feed" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="बछड़ा स्टार्टर (किलोग्राम में) "
                        data-en="Calf Starter (In Kg)"></span> </label>
                <input name="calf_starter" id="calf_starter" required type="text" class="form-control"
                    data-placeholder-hi="बछड़ा स्टार्टर" data-placeholder-en="Calf Starter" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="कोई अन्य वस्तु" data-en="Any Other Item"></span> </label>
                <input name="any_other_item" id="any_other_item" required type="text" class="form-control"
                    data-placeholder-hi="अन्य वस्तु" data-placeholder-en="Any other item" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="कोई सुझाव?" data-en="Any Suggestion"></span> </label>
                <input name="any_suggestion" id="any_suggestion" required type="text" class="form-control"
                    data-placeholder-hi="सुझाव" data-placeholder-en="Suggetion" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="कोई  शिकायत?" data-en="Any Complaint"></span> </label>
                <select name="any_complaint" id="any_complaint" required class="form-control" placeholder="शिकायत">
                    <option value="स्ट्रॉ से संबंधित" data-hi="स्ट्रॉ से संबंधित" data-en="Related to Straws"> </option>
                    <option value="तरल नाइट्रोजन से संबंधित" data-hi="तरल नाइट्रोजन से संबंधित "
                        data-en="Related to Liquid Nitrogen"></option>
                    <option value="कंटेनर से संबंधित" data-hi="कंटेनर से संबंधित" data-en="Related to Container">
                    </option>
                    <option value="भारत पशुधन आईडी से संबंधित" data-hi="भारत पशुधन आईडी से संबंधित"
                        data-en="Related to Bharat Pashudhan ID"></option>
                    <option value="प्रोत्साहन राशि से संबंधित" data-hi="प्रोत्साहन राशि से संबंधित"
                        data-en="Related to Incentive amount"> </option>
                    <option value="बीमा से संबंधित" data-hi="बीमा से संबंधित" data-en="Related to Insurance"> </option>
                </select>
                <!-- <input name="any_complaint" id="any_complaint" type="text" class="form-control"  placeholder="शिकायत" autofocus> -->
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="महीना" data-en="Month"></span> </label>
                <input name="month" id="month" type="month" required data-placeholder-hi="महीना"
                    data-placeholder-en="Month" class="form-control" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="प्रश्न" data-en="Query/Question"></span> </label>
                <input name="question" id="question" type="text" required data-placeholder-hi="प्रश्न"
                    data-placeholder-en="Question" class="form-control" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="भारत पशुधन पर पंजीकृत गाय संतति की संख्या"
                        data-en="Number of Cow Calves Registered on Bharat Pashudhan">
                    </span> </label>
                <input name="registered_cow_calves" id="registered_cow_calves" required type="text"
                    data-placeholder-hi="भारत पशुधन पर पंजीकृत गाय संतति की संख्या"
                    data-placeholder-en="Number of Cow Calves Registered on Bharat Pashudhan" class="form-control"
                    autofocus>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="भारत पशुधन पर पंजीकृत भैंस संतति की संख्या"
                        data-en="Number of Buffalo Calves Registered on Bharat Pashudhan"></span> </label>
                <input name="registered_buffalo_calves" required id="registered_buffalo_calves" type="text"
                    data-placeholder-hi="भारत पशुधन पर पंजीकृत भैंस संतति की संख्या"
                    data-placeholder-en="Number of Buffalo Calves Registered on Bharat Pashudhan" class="form-control"
                    autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="भारत पशुधन पर पंजीकृत वर्गीकृत संतति की संख्या"
                        data-en="Number of SeXed Semen Calves Registered on Bharat Pashudhan"></span> </label>
                <input name="registered_sexed_calves" required id="registered_sexed_calves" type="text"
                    ata-placeholder-hi="भारत पशुधन पर पंजीकृत वर्गीकृत वीर्य संतति की संख्या"
                    data-placeholder-en="Number of SeXed Semen Calves Registered on Bharat Pashudhan"
                    class="form-control" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="भारत पशुधन पर पंजीकृत किसानों की संख्या"
                        data-en="Number of Farmers Registered on Bharat Pashudhan"></span> </label>
                <input name="registered_farmers" required id="registered_farmers" type="text"
                    ata-placeholder-hi="भारत पशुधन पर पंजीकृत किसानों की संख्या"
                    data-placeholder-en="Number of Farmers Registered on Bharat Pashudhan" class="form-control"
                    autofocus>
            </div>
            <div class="form-group col-md-12 text-center">
                <button type="submit" class="btn btn-primary" id="btn">
                    <span data-hi="सबमिट" data-en="Submit"></span>
                </button>
            </div>

        </div>
    </form>
    <!--First row Closed-->
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // loginForm
    $('#loginForm').on('submit', function(event) {

        let pincode = $('#pincode').val();
        let isValid = /^[0-9]{6}$/.test(pincode);

        if (!isValid) {
            event.preventDefault();
            $('#error-message').show();
            $('#pincode')[0].scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            $('#pincode').focus();
        } else {
            $('#error-message').hide();
        }
    });

    $('#pincode').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
});

$('.added_vh_ai_center').hide();
$('.semen_source_added').hide();

var maxFields = 6;
var fieldCount = 0;
$('.demand-request-add-btn').click(function() {
    if (fieldCount < maxFields) {
        var newField = '<div class="form-group col-md-12 pt-4 sub_block_' + fieldCount + '" style="background: #eee;">\
            <div class="row">\
                <div class="form-group col-md-4">\
                    <label for="inputEmail4">\
                        <span data-hi="प्रजाति वीर्य" data-en="Species Semen"></span>\
                    </label>\
                    <select name="semen[]" id="semen" required class="form-control" autofocus>\
                        <option value="" data-hi="एक का चयन करें" data-en="select one"></option>\
                        <option value="cow" data-hi="गाय" data-en="Cattle"></option>\
                        <option value="buffalo" data-hi="भैंस" data-en="Buffalo"></option>\
                        <option value="goat" data-hi="बकरी" data-en="Goat"></option>\
                    </select>\
                </div>\
                <div class="form-group col-md-4">\
                    <label for="inputEmail4"> <span data-hi="वीर्य प्रकार" data-en="Semen Type"></span> </label>\
                    <select name="semen_type[]" required id="semen_type" class="form-control" autofocus>\
                        <option value="" data-hi="एक का चयन करें" data-en="select one"></option>\
                        <option value="conventional" data-hi="सामान्य" data-en="Conventional"></option>\
                        <option value="sexed" data-hi="वर्गीकृत" data-en="Sexed"></option>\
                    </select>\
                </div>\
                <div class="form-group col-md-4">\
                    <label for="inputEmail4"> <span data-hi="वीर्य का स्रोत" data-en="Source of Semen"></span>\
                    </label>\
                    <select name="semen_source[]" required id="semen_source" class="form-control" autofocus>\
                        <option value="" data-hi="एक का चयन करें" data-en="select one"></option>\
                        <option value="UPLDB" data-hi="यूपीएलडीबी" data-en="UPLDB"></option>\
                        <option value="BAIF" data-hi="बीएआईएफ़" data-en="BAIF"></option>\
                        <option value="ABC Salon" data-hi="एबीसी सैलून" data-en="ABC Salon"></option>\
                        <option value="Amul" data-hi="अमूल" data-en="Amul"></option>\
                        <option value="Haryana" data-hi="हरियाणा" data-en="Haryana"></option>\
                        <option value="Hissar Bovine" data-hi="हिसार गोजातीय" data-en="Hissar Bovine"></option>\
                        <option value="Morna Breeding" data-hi="मोरना प्रजनन" data-en="Morna Breeding"></option>\
                        <option value="others" data-hi="अन्य" data-en="Others"></option>\
                    </select>\
                </div>\
                <div class="form-group col-md-4">\
                    <label for="inputEmail4"> <span data-hi="नस्ल" data-en="Breed"></span> </label>\
                    <input name="breed[]" required id="breed" type="text" class="form-control" data-placeholder-hi="नस्ल"\
                        data-placeholder-en="Breed" autofocus>\
                </div>\
                <div class="form-group col-md-4">\
                    <label for="inputEmail4"> <span data-hi="बुल आई.डी." data-en="Bull ID"></span> </label>\
                    <input name="bull_id[]" required id="bull_id" type="text" class="form-control"\
                        data-placeholder-hi="बुल आई.डी." data-placeholder-en="Bull ID" autofocus>\
                </div>\
                <div class="form-group col-md-4">\
                    <label for="inputEmail4"> <span data-hi="एआई शीथ की मात्रा" data-en="AI Sheath Quantity"></span>\
                    </label>\
                    <input name="Sheath[]" required id="Sheath" type="text" class="form-control"\
                        data-placeholder-hi="शीत क्वांटिटी" data-placeholder-en="AI Sheath Quantity" autofocus>\
                </div>\
                <div class="form-group col-md-12 text-center">\
                    <span class="demand-request-remove-btn btn btn-danger btn-sm" data-index="' + fieldCount + '">Remove</span>\
                </div>\
            </div>\
        </div>';

        $('.main_div_block:last').after(newField);
        fieldCount++;

        var lang = $(".switchlang option:selected").val();
        localStorage.setItem("selectedProject", lang);
        switchLang(lang)

        if (fieldCount === maxFields) {
            $('.demand-request-add-btn').hide();
        }
    }

});

$(document).on('click', '.demand-request-remove-btn', function() {
    var index = $(this).data('index');
    $(this).closest('.sub_block_' + index).remove();
    fieldCount--;
    $('.demand-request-add-btn').show();
});


var allData = {};
$('#district').change(function() {
    $('#mandal').prop('disabled', false);
    $('#mandal').empty();
    $('#vikas_khand').prop('disabled', false);
    $('#vikas_khand').empty();
    $('#ai_center').prop('disabled', false);
    $('#ai_center').empty();
    $('#tehsil').prop('disabled', false);
    $('#tehsil').empty();

    var val = $("#district option:selected").val();
    var text = $("#district option:selected").text();
    if (val) {
        $.ajax({
            type: "GET",
            url: "get-all-district",
            data: {
                "id": val,
                "mandal": text,
            },
            cache: false,
            success: function(data) {
                var getMandal = data.district;
                if (getMandal && getMandal.length > 0) {
                    $('#mandal').append(`<option value="">Select District</option>`);
                    getMandal.forEach(item => {
                        if (item.name_hindi && item.name_hindi.trim() !== '') {
                            $('#mandal').append(
                                `<option value="${item.name_hindi}">${item.name_hindi}</option>`
                            );
                        }
                    });
                } else {
                    $('#mandal').append('<option value="">-Data not found.-</option>');
                }
            }
        });
    }
});

$('#mandal').change(function() {
    $('#vikas_khand').prop('disabled', false);
    $('#vikas_khand').empty();
    $('#ai_center').prop('disabled', false);
    $('#ai_center').empty();
    $('#tehsil').prop('disabled', false);
    $('#tehsil').empty();

    var mandal = $("#district option:selected").text();
    var janpad = $("#mandal option:selected").val();
    $.ajax({
        type: "GET",
        url: "get-all-tehsil",
        data: {
            "mandal": mandal,
            "janpad": janpad,
        },
        cache: false,
        success: function(data) {
            var getTehsil = data.data;
            if (getTehsil && getTehsil.length > 0) {
                $('#tehsil').append(`<option value="">Select Tehsil</option>`);
                getTehsil.forEach(item => {
                    if (item.tehsil && item.tehsil.trim() !== '') {
                        $('#tehsil').append(
                            `<option value="${item.tehsil}">${item.tehsil}</option>`);
                    }
                });
            } else {
                $('#tehsil').append('<option value="">-Data not found.-</option>');
            }
        }
    });
});

$('#tehsil').change(function() {
    $('#vikas_khand').prop('disabled', false);
    $('#vikas_khand').empty();
    $('#ai_center').prop('disabled', false);
    $('#ai_center').empty();
    var tehsil = $(this).val();
    var mandal = $("#district option:selected").text();
    var janpad = $("#mandal option:selected").val();
    $.ajax({
        type: "GET",
        url: "get-all-block",
        data: {
            "tehsil": tehsil,
            "mandal": mandal,
            "janpad": janpad,
        },
        cache: false,
        success: function(data) {
            var getBlock = data.data;
            if (getBlock && getBlock.length > 0) {
                $('#vikas_khand').append(`<option value="">Select Vikas Khand</option>`);
                getBlock.forEach(item => {
                    if (item.block && item.block.trim() !== '') {
                        $('#vikas_khand').append(
                            `<option value="${item.block}">${item.block}</option>`);
                    }
                });
            } else {
                $('#vikas_khand').append('<option value="">-Data not found.-</option>');
            }
        }
    });
});

$('#vikas_khand').change(function() {
    $('#ai_center').prop('disabled', false);
    var block = $(this).val();
    var tehsil = $('#tehsil').val();
    var mandal = $("#district option:selected").text();
    var janpad = $("#mandal option:selected").val();
    $('#ai_center').empty();
    $.ajax({
        type: "GET",
        url: "get-all-aicenter",
        data: {
            "block": block,
            "tehsil": tehsil,
            "mandal": mandal,
            "janpad": janpad,
        },
        cache: false,
        success: function(data) {
            var getAiCenter = data.data;
            if (getAiCenter && getAiCenter.length > 0) {
                $('#ai_center').append(`<option value="">Select AI Center</option>`);
                getAiCenter.forEach(item => {
                    if (item.center_name && item.center_name.trim() !== '') {
                        $('#ai_center').append(
                            `<option value="${item.center_name}">${item.center_name}</option>`
                        );
                    }
                });
            } else {
                $('#ai_center').append('<option value="">-Data not found.-</option>');
            }
        }
    });
});

// function populateDropdown(selector, data, valueField, defaultText) {
//     $(selector).empty();
//     $(selector).append(`<option value="">${defaultText}</option>`);

//     if (data && data.length > 0) {
//         data.forEach(item => {
//             $(selector).append(`<option value="${item[valueField]}">${item[valueField]}</option>`);
//         });
//     } else {
//         $(selector).append('<option value="">-Data not found.-</option>');
//     }
// }




$('#training_center_id').change(function() {
    $('.added_vh_ai_center').hide()
    var val = $("#training_center_id option:selected").val();
    $('#training_center_added').val(val);
    if (val == 'other') {
        $('#training_center_added').val();
        $('.added_vh_ai_center').show()
    }
})


$('#semen_source').change(function() {
    $('.semen_source_added').hide()
    var val = $("#semen_source option:selected").val();
    $('#semen_source_added').val(val)
    if (val == 'others') {
        $('#semen_source_added').val()
        $('.semen_source_added').show()
    }
})
</script>
@endsection
