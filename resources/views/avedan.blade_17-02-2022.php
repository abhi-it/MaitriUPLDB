@extends('master')
@section('content')
    <style>
    * {
    box-sizing: border-box;
}
.tab{
    display: none;
    width: 100%;
    height: 50%;
    margin: 0px auto;
}
.current{
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
<script src="{{ asset('')}}js/google_Jsapi.js" type="text/javascript"></script>
<script type="text/javascript">

      // Load the Google Transliterate API
      google.load("elements", "1", {
            packages: "transliteration"
          });

      function onLoad() {
        var options = {
            sourceLanguage:
                google.elements.transliteration.LanguageCode.ENGLISH,
            destinationLanguage:
                [google.elements.transliteration.LanguageCode.HINDI],
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
 font-size : 18px;
 font-weight: bold;
 width: 100%;
 height: 100%;
 margin: 0;
 line-height: 50px;
 text-align: center;
 /* Starting position */
 transform:translateX(100%);
 /* Apply animation to this element */
 animation: scroll-left 20s linear infinite;
}
/* Move it (define the animation) */
@keyframes scroll-left {
 0%   {
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
	<marquee width="100%" direction="left" height="25px" style="font-size : 18px;font-weight: bold;">अभ्यर्थी  को प्रदेश का  एवं प्रदेश के उस जनपद का निवासी होना अनिवार्य है , जिस जनपद के लिए आवेदन किया जा रहा है ।</marquee>
 <h1 style="margin-top:10px;text-align: center;">आवेदन  - पत्र </h1>
@if(session()->get('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}  
  </div>
@endif
	<form method="post" action="{{ route('application-form.store') }}" id="myForm"  enctype="multipart/form-data">
	@csrf
        <!-- Circles which indicates the steps of the form: -->
        <div style="text-align:center;margin-top:40px;">
			<span class="step">1 </span><h3 style="display:inline;font-size: 18px;">नियम और शर्तें</h3>
            <span class="step">2 </span><h3 style="display:inline;font-size: 18px;">आवेदक का विवरण</h3>
            <span class="step">3 </span><h3 style="display:inline;font-size: 18px;">शौक्षिक योग्यता व अन्य विवरण </h3>
            <span class="step">4 </span><h3 style="display:inline;font-size: 18px;">शारांस</h3>
        </div>
        <hr>
        
        <div class="tab">
			<h3>नियम और शर्तें </h3>
			<div class="row">
				
				<div class="form-group col-md-12">यह योजना पूर्णतः स्वरोजगार सृजन की अवधारणा पर आधारित है। आवेदक को किसी भी स्थिति में शासकीय सेवा में संविलयन का कोई अधिकार नही होगा। चयनित अभ्यर्थी को 35 दिनों का सैद्धान्तिक प्रशिक्षण एवं 55 दिनों का व्यावहारिक प्रशिक्षण कराया जायेगा। चयनित अभ्यर्थी को सफलतापूर्णक प्रशिक्षण पूर्ण करने के उपरान्त मैत्री (मल्टी परपज ए0आई0 टेक्निशियन इन रुरल इण्डिया) के रुप में कार्य करने हेतु प्रमाण-पत्र, बायोलॉजिकल  कण्टेनर्स तथा ए0आई0किट आदि उपलब्ध कराये जायेगें।
				  
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">अगर आप सहमत हैं तो सेलेक्ट करें</label> <span class="text-danger">*</span>
				  <input type="checkbox" name="tc" id="tc" {{ $result->t_and_c=='1' ? 'checked' : '' }} value="1">
				</div>

		  </div>
        </div>
        
        
        
        
        <div class="tab">
		<?php //echo '<pre>';print_r($result);?>
			<h3>आवेदक का विवरण </h3>
			<div class="row">
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">आवेदक का नाम </label> <span class="text-danger">*</span>
				  <input type="text" class="form-control" name="applicant_name" id="applicant_name" placeholder="आवेदक का नाम"  autocomplete="off" value="{{$result->applicant_name}}">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputPassword4">पिता  / पति का नाम </label> <span class="text-danger">*</span>
				  <input type="text" class="form-control" id="fname" name="fname" placeholder="पिता  / पति का नाम"  autocomplete="off"  value="{{$result->fname}}">
				</div>
				
				<div class="form-group col-md-6">
				<label for="inputEmail4">लिंग</label> <span class="text-danger">*</span>
				  <select class="form-control" name="gender" id="gender">
				  <option value="">सेलेक्ट</option>
				  <option value="पुरुष" {{ $result->gender=='पुरुष' ? 'selected' : '' }}>पुरुष</option>
				  <option value="महिला" {{ $result->gender=='महिला' ? 'selected' : '' }}>महिला</option>
				  <option value="ट्रांसजेंडर" {{ $result->gender=='ट्रांसजेंडर' ? 'selected' : '' }}>ट्रांसजेंडर</option>
				  </select>
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">जन्म तिथि (हाई स्कूल प्रमाण पत्र के अनुसार)</label> <span class="text-danger">*</span>
				  <input type="text" class="form-control" name="dob" id="dob" placeholder="जन्म तिथि" readonly value="{{\Carbon\Carbon::parse($result->dob)->format('d-m-Y')}}">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">दूरभाष  / मोबाइल नंबर</label> <span class="text-danger">*</span>
				  <input maxlength="10" type="text" class="form-control" name="mobile" id="mobile" placeholder="दूरभाष  / मोबाइल नंबर"  autocomplete="off"  value="{{$result->mobile}}" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">श्रेणी</label> <span class="text-danger">*</span>
				  <select class="form-control" name="category" id="category">
					  <option value="">सेलेक्ट</option>
					  <option value="जनरल" {{ $result->category=='जनरल' ? 'selected' : '' }}>सामान्य (general)</option>
					  <option value="ओ बी सी" {{ $result->category=='ओ बी सी' ? 'selected' : '' }}>अन्य पिछड़ा वर्ग  (OBC)</option>
					  <option value="एस सी" {{ $result->category=='एस सी' ? 'selected' : '' }}>अनुसूचित जाति (SC)</option>
					  <option value="एस टी" {{ $result->category=='एस टी' ? 'selected' : '' }}>अनुसूचित जनजाति (ST)</option>
					  
				  </select>
				</div>
				
				
				
				<div class="form-group col-md-6">
				  <label for="inputPassword4">स्थायी पता </label> <span class="text-danger">*</span>
				  <input type="text" class="form-control" name="permanent_address" id="permanent_address" placeholder="स्थायी पता"  autocomplete="off"  value="{{$result->permanent_address}}">
				</div>
				<div class="form-group col-md-6">
					<label for="inputEmail4">स्थायी पते  के प्रमाण का प्रकार</label> <span class="text-danger">*</span>
					  <select class="form-control" name="address_type" id="address_type">
					  <option value="">सेलेक्ट</option>
					  <option value="आधार कार्ड" {{ $result->address_type=='आधार कार्ड' ? 'selected' : '' }}>आधार कार्ड</option>
					  <option value="पासबुक कॉपी" {{ $result->address_type=='पासबुक कॉपी' ? 'selected' : '' }}>पासबुक कॉपी</option>
					  <option value="बिजली का बिल" {{ $result->address_type=='बिजली का बिल' ? 'selected' : '' }}>बिजली का बिल</option>
					  <option value="अन्य" {{ $result->address_type=='अन्य' ? 'selected' : '' }}>अन्य</option>
					  </select>
				</div>
				
				
				
				<div class="form-group col-md-6">
				  <label for="inputPassword4">स्थायी पता स्वप्रमाणित छाया प्रति संलग्न करें </label> <span class="text-danger">*</span> <small style="color:red;">Note: JPG, JPEG, PNG, PDF files only (Max. 100 KB)</small>
				  <input type="file" class="form-control" name="permanent_address_proof" id="permanent_address_proof" autocomplete="off" value="{{$result->permanent_address_proof}}">
				</div>
					
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">ग्राम पंचायत का नाम</label> <span class="text-danger">*</span>
				  <input type="text" class="form-control" name="gram_panchayat_name" id="gram_panchayat_name" placeholder="ग्राम पंचायत का नाम"  autocomplete="off"  value="{{$result->gram_panchayat_name}}">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">विकास खण्ड </label> <span class="text-danger">*</span>
				  <input type="text" class="form-control" name="vikas_khand" id="vikas_khand" placeholder="विकास खण्ड"  autocomplete="off"  value="{{$result->vikas_khand}}">
				</div>
				<div class="form-group col-md-6">
				  <label for="inputPassword4">जनपद </label> <span class="text-danger">*</span>
				  <select class="form-control" name="janpad" id="janpad">
                        <option value="">सेलेक्ट जनपद</option>
                        @foreach($districts as $row)
							<option value="{{$row->id}}" {{ $result->district_id==$row->id ? 'selected' : '' }}>{{$row->name_hindi}}</option>
							@endforeach
                      </select>
				</div>
				<div class="form-group col-md-6">
				  <label for="inputEmail4">पत्र  - व्यव्हार का पता </label> <span class="text-danger">*</span>
				  <input type="text" class="form-control" name="letter_address" id="letter_address" placeholder="पत्र  - व्यव्हार का पता"  autocomplete="off"  value="{{$result->letter_address}}">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputPassword4">पोस्ट ऑफिस </label> <span class="text-danger">*</span>
				  <input type="text" class="form-control" name="post_office" id="post_office" placeholder="पोस्ट ऑफिस"  autocomplete="off"  value="{{$result->post_office}}">
				</div>
				<div class="form-group col-md-6">
				  <label for="inputPassword4">पिनकोड </label> <span class="text-danger">*</span>
				  <input maxlength="6" type="text" class="form-control" name="pincode" id="pincode" placeholder="पिनकोड"  autocomplete="off"  value="{{$result->pincode}}" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
				</div>
				<div class="form-group col-md-6">
				  <label for="inputPassword4">ई  - मेल  </label>
				  <input type="text" class="form-control" name="email" id="email" placeholder="ई  - मेल"  autocomplete="off"  value="{{$result->email}}">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputPassword4">आवेदक की फोटो </label> <span class="text-danger">*</span> <small style="color:red;">Note: JPG, JPEG, PNG, PDF files only (Max. 20 KB)</small>
				  <input type="file" class="form-control" name="applicant_photo" id="applicant_photo" placeholder="आवेदक की फोटो" value="{{$result->applicant_photo}}">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputPassword4">अभ्यर्थी  का हस्ताक्षर </label> <span class="text-danger">*</span> <small style="color:red;">Note: JPG, JPEG, PNG, PDF files only (Max. 20 KB)</small>
				  <input type="file" class="form-control" name="signature" id="signature" placeholder="अभ्यर्थी  का हस्ताक्षर" value="{{$result->signature}}">
				</div>
				
		  </div>
        </div>
        
        <div class="tab">
			<h3>शौक्षिक योग्यता व अन्य विवरण 
			<div class=" pull-right">
				<small style="color:red;font-size:10px;margin-right: 200px;">Note: JPG, JPEG, PNG, PDF files only (Max. 100 KB)</small>
			</div>
			</h3>
			<div class="row">
				<table>
				<tr>
				<td width="10%">उत्तीर्ण परीक्षा का नाम</td>
				<td>बोर्ड का नाम</td>
				<td>उत्तीर्ण वर्ष</td>
				<td>प्राप्तांक</td>
				<td>पूर्णांक</td>
				<td>प्रतिशत</td>
				<td style="width: 25%;">स्वप्रमाणित हाई स्कूल मार्कशीट छाया प्रति संलग्न करें</td>
				<td style="width: 25%;">स्वप्रमाणित हाई स्कूल सर्टिफिकेट छाया प्रति संलग्न करें</td>
				</tr>
				<tr>
				<td style="width: 12%;">हाई स्कूल (जीव विज्ञान) <span class="text-danger">*</span></td>
				<td><input type="text" class="form-control" name="high_board_name" id="high_board_name" placeholder="बोर्ड का नाम"  autocomplete="off"  value="{{$result->high_board_name}}"></td>
				<td><input maxlength="4" type="text" class="form-control" name="high_passing_year" id="high_passing_year" placeholder="उत्तीर्ण वर्ष"  autocomplete="off"  value="{{$result->high_passing_year}}" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" style="width: 80px;"></td>
				<td><input maxlength="3" type="text" class="form-control" name="high_marks" id="high_marks" placeholder="प्राप्तांक"  autocomplete="off"  value="{{$result->high_marks}}" style="width: 65px;"></td>
				<td><input maxlength="3" type="text" class="form-control" name="high_total_marks" id="high_total_marks" placeholder="पूर्णांक"  autocomplete="off"  value="{{$result->high_total_marks}}" style="width: 65px;"></td>
				<td><input type="text" class="form-control" readonly name="high_percentage" id="high_percentage" placeholder="प्रतिशत"  autocomplete="off"  value="{{$result->high_percentage}}" style="width: 65px;"></td>
				<td><input type="file" class="form-control" name="high_marksheet" id="high_marksheet"></td>
				<td><input type="file" class="form-control" name="high_certificate" id="high_certificate"></td>
				</tr>
				</table>
			</div>
			<div class="row">
				<table>
				<tr>
				<td style="width: 12.8%;">इण्टर (जीव विज्ञान) <span class="text-danger">&nbsp;</span></td>
				<td><input type="text" class="form-control" name="inter_board_name" id="inter_board_name" placeholder="बोर्ड का नाम"  autocomplete="off"  value="{{$result->inter_board_name}}" style="width:137px;"></td>
				<td><input maxlength="4" type="text" class="form-control" name="inter_passing_year" id="inter_passing_year" placeholder="उत्तीर्ण वर्ष"  autocomplete="off"  value="{{$result->inter_passing_year}}" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" style="width: 80px;"></td>
				<td><input maxlength="3" type="text" class="form-control" name="inter_marks" id="inter_marks" placeholder="प्राप्तांक"  autocomplete="off"  value="{{$result->inter_marks}}" style="width: 65px;"></td>
				<td><input maxlength="3" type="text" class="form-control" name="inter_total_marks" id="inter_total_marks" placeholder="पूर्णांक"  autocomplete="off"  value="{{$result->inter_total_marks}}" style="width: 65px;"></td>
				<td><input type="text" class="form-control" readonly name="inter_percentage" id="inter_percentage" placeholder="प्रतिशत"  autocomplete="off"  value="{{$result->inter_percentage}}" style="width: 65px;"></td>
				<td><input type="file" class="form-control" name="inter_marksheet" id="inter_marksheet"></td>
				<td><input type="file" class="form-control" name="inter_certificate" id="inter_certificate"></td>
				</tr>
				</table>
			</div>
			
			<div class="row">
				<table>
				<tr>
				<td style="width: 13.6%;">स्नातक<span class="text-danger">&nbsp;</span></td>
				<td><input type="text" class="form-control" name="graduation_board_name" id="graduation_board_name" placeholder="बोर्ड का नाम"  autocomplete="off"  value="{{$result->graduation_board_name}}" style="width:137px;"></td>
				<td><input maxlength="4" type="text" class="form-control" name="graduation_passing_year" id="graduation_passing_year" placeholder="उत्तीर्ण वर्ष"  autocomplete="off"  value="{{$result->graduation_passing_year}}" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" style="width: 80px;"></td>
				<td><input maxlength="4" type="text" class="form-control" name="graduation_marks" id="graduation_marks" placeholder="प्राप्तांक"  autocomplete="off"  value="{{$result->graduation_marks}}" style="width: 65px;"></td>
				<td><input maxlength="4" type="text" class="form-control" name="graduation_total_marks" id="graduation_total_marks" placeholder="पूर्णांक"  autocomplete="off"  value="{{$result->graduation_total_marks}}" style="width: 65px;"></td>
				<td><input type="text" class="form-control" readonly name="graduation_percentage" id="graduation_percentage" placeholder="प्रतिशत"  autocomplete="off"  value="{{$result->graduation_percentage}}" style="width: 65px;"></td>
				<td><input type="file" class="form-control" name="graduation_marksheet" id="graduation_marksheet"></td>
				<td><input type="file" class="form-control" name="graduation_certificate" id="graduation_certificate"></td>
				</tr>
				</table>
			</div>
			
			<div class="row">
				<table>
				<tr>
				<td style="width: 13.4%;">परास्नातक  <span class="text-danger">&nbsp;</span></td>
				<td><input type="text" class="form-control" name="postgraduation_board_name" id="postgraduation_board_name" placeholder="बोर्ड का नाम"  autocomplete="off"  value="{{$result->postgraduation_board_name}}" style="width:137px;"></td>
				<td><input maxlength="4" type="text" class="form-control" name="postgraduation_passing_year" id="postgraduation_passing_year" placeholder="उत्तीर्ण वर्ष"  autocomplete="off"  value="{{$result->postgraduation_passing_year}}" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" style="width: 80px;"></td>
				<td><input maxlength="4" type="text" class="form-control" name="postgraduation_marks" id="postgraduation_marks" placeholder="प्राप्तांक"  autocomplete="off"  value="{{$result->postgraduation_marks}}" style="width: 65px;"></td>
				<td><input maxlength="4" type="text" class="form-control" name="postgraduation_total_marks" id="postgraduation_total_marks" placeholder="पूर्णांक"  autocomplete="off"  value="{{$result->postgraduation_total_marks}}" style="width: 65px;"></td>
				<td><input type="text" class="form-control" readonly name="postgraduation_percentage" id="postgraduation_percentage" placeholder="प्रतिशत"  autocomplete="off"  value="{{$result->postgraduation_percentage}}" style="width: 65px;"></td>
				<td><input type="file" class="form-control" name="postgraduation_marksheet" id="postgraduation_marksheet"></td>
				<td><input type="file" class="form-control" name="postgraduation_certificate" id="postgraduation_certificate"></td>
				</tr>
				</table>
			</div>
		  
		  <div class="row" style="padding-top:30px;">
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">राज्य  / केंद्र सरकार द्वारा मान्यता प्राप्त संसथान से यदि पूर्व में कृत्रिम गर्भाधान के प्रशिक्षण का प्रमाण पत्र प्राप्त किया हो (स्वप्रमाणित छाया प्रति संलग्न करें)</label> <small style="color:red;">Note: JPG, JPEG, PNG, PDF files only (Max. 100 KB)</small>
				  <input type="file" class="form-control" name="training_certificate" id="training_certificate">
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">प्रशिक्षण की अवधि माह</label>
				  <select class="form-control" name="training_certificate_period_in_month" id="training_certificate_period_in_month">
					<option value="">माह</option>
					<?php
					  for($m=1;$m<=12;$m++)
					  {
						 ?>
					<option value="{{$m}}" {{ $result->training_certificate_period_in_month==$m ? 'selected' : '' }}>{{$m}} माह</option>
					<?php } ?>
				  </select>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">दिन</label>
				  <select class="form-control" name="training_certificate_period_in_days" id="training_certificate_period_in_days">
					<option value="">दिन</option>
					<?php
					  for($d=1;$d<=29;$d++)
					  {
						 ?>
					<option value="{{$d}}" {{ $result->training_certificate_period_in_days==$d ? 'selected' : '' }}>{{$d}} दिन</option>
					<?php } ?>
				  </select>
				</div>
				<div class="row errorHere" name="errorHere" id="errorHere"></div>
				
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">योजना का नाम जिसके अंतर्गत प्रशिक्षण प्राप्त किया गया</label> <span class="text-danger">*</span>
				  <input type="text" class="form-control" name="yojna_name_for_training" id="yojna_name_for_training">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">प्रशिक्षणोपरांत ए. आई.  किट तथा  बायोलोजिकल कन्टेनर प्राप्त किये गये है</label> <span class="text-danger">*</span>
				  <select class="form-control" name="AIkit" id="AIkit">
						<option value="">सेलेक्ट</option>
						<option value="हाँ" {{ $result->AIkit=='हाँ' ? 'selected' : '' }}>हाँ</option>
						<option value="नहीं" {{ $result->AIkit=='नहीं' ? 'selected' : '' }}>नहीं</option>
				  </select>
				</div>
				
				
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">वोटर आई डी कार्ड  / आधार कार्ड / पैन कार्ड की स्वप्रमाणित छाया प्रति संलग्न करें</label> <span class="text-danger">*</span> <small style="color:red;">Note: JPG, JPEG, PNG, PDF files only (Max. 100 KB)</small>
				  <input type="file" class="form-control" name="id_upload" id="id_upload">
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">जाति (एस सी / एस टी श्रेणी हेतु न्याय अधिकारी द्वारा जारी प्रमाण पत्र की स्वप्रमाणित छाया प्रति संलग्न करें</label> <span class="text-danger">*</span> <small style="color:red;">Note: JPG, JPEG, PNG, PDF files only (Max. 100 KB)</small>
				  <input type="file" class="form-control" name="caste_certificate" id="caste_certificate">
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">राजकीय चिकित्साधिकारी द्वारा प्रदत्त स्वास्थ्य प्रमाण पत्र</label> <span class="text-danger">*</span> <small style="color:red;">Note: JPG, JPEG, PNG, PDF files only (Max. 100 KB)</small>
				  <input type="file" class="form-control" name="health_certificate" id="health_certificate">
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">राष्ट्रीयता </label> <span class="text-danger">*</span>
				  <select class="form-control" name="nationality" id="nationality">
				  <option value="">सेलेक्ट</option>
				  <option value="भारतीय" {{ $result->nationality=='भारतीय' ? 'selected' : '' }}>भारतीय</option>
				  </select>
				</div>
				<div class="form-group col-md-12"><span class="text-danger">*</span>
				  <input type="checkbox" name="declaration" id="declaration" value="1">
				  <label for="inputEmail4" style="font-weight: bold;
    font-size: 16px;">मै एतदद्वारा यह घोषणा करता / करती हूँ  कि मैं __<span style="font-weight:normal;" id="applicant_named"></span>__ पुत्र / पुत्री / पत्नी _<span style="font-weight:normal;" id="fnamed">SA</span>_ निवासी ग्राम _<span style="font-weight:normal;" id="janpad_gram">DA</span>_ ग्राम पंचायत _<span style="font-weight:normal;" id="gram_panchayat_named">GH</span>_  विकास खंड _<span style="font-weight:normal;" id="vikas_khandd">BB</span>_  जनपद _<span style="font-weight:normal;" id="janpadd">Agra</span>_ का निवासी हूँ | मैं आवेदन पत्र के साथ संलग्न नियम - शर्तो से पूर्णत: अवगत हूँ  | मै पूर्णत: स्वस्थ हूँ एवं पशुपालक के द्वार पर पहुँच कर सेवा करने योग्य हूँ | यदि कोई विवरण / सूचना असत्य पायी जाती है या तथ्य  मेरे द्वारा छिपाया पाया जाता है तो मेरा आवेदन चयनोपरांत  भी निरस्त कर दिया जाए |

<br><br>स्थान : <span style="font-weight:normal;" id="janpaddD"></span>
<br>दिनांक : <span style="font-weight:normal;"><?php echo date('d-m-Y')?></span>
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
				  <label for="inputPassword4">पिता  / पति का नाम </label>
				  <span class="form-control-span" id="fname1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">जन्म तिथि (हाई स्कूल प्रमाण पत्र के अनुसार)</label>
				  <span class="form-control-span" id="dob1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">दूरभाष  / मोबाइल नंबर</label>
				  <span class="form-control-span" id="mobile1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">कैटेगरी</label>
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
				  <label for="inputPassword4">स्थायी पता स्वप्रमाणित छाया प्रति संलग्न करें </label>
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
				  <span  class="form-control-span" id="janpad1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">विकास खण्ड </label>
				  <span  class="form-control-span" id="vikas_khand1"></span>
				</div>

				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">पत्र  - व्यव्हार का पता </label>
				  <span class="form-control-span" id="letter_address1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">ई  - मेल  </label>
				  <span  class="form-control-span" id="email1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">आवेदक की फोटो </label>
				  <span  class="form-control-span" id="applicant_photo1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">अभ्यर्थी  का हस्ताक्षर </label>
				  <span  class="form-control-span" id="signature1"></span>
				</div>
				
			</div>
		
		
		<hr>
		<div class="row">
			
			<h3>शौक्षिक योग्यता व अन्य विवरण </h3>
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
				<td>स्वप्रमाणित छाया प्रति संलग्न करें</td>
				</tr>
				<tr>
				<td>हाई स्कूल (जीव विज्ञान)</td>
				<td><span class="form-control-span" id="high_board_name1"></span></td>
				<td><span class="form-control-span" id="high_passing_year1"></span></td>
				<td><span class="form-control-span" id="high_marks1"></span></td>
				<td><span class="form-control-span" class="form-control-span" id="high_total_marks1"></span></td>
				<td><span class="form-control-span" id="high_percentage1"></span></td>
				<td><span class="form-control-span" id="high_marksheet1"></span></td>
				<td><span class="form-control-span" id="high_certificate1"></span></td>
				</tr>
				<tr>
				<td width="10%">इण्टर (जीव विज्ञान)</td>
				<td><span class="form-control-span" id="inter_board_name1"></span></td>
				<td><span class="form-control-span" id="inter_passing_year1"></span></td>
				<td><span class="form-control-span" id="inter_marks1"></span></td>
				<td><span class="form-control-span" id="inter_total_marks1"></span></td>
				<td><span class="form-control-span" id="inter_percentage1"></span></td>
				<td><span class="form-control-span" id="inter_marksheet1"></td>
				<td><span class="form-control-span" id="inter_certificate1"></td>
				</tr>
				
				<tr>
				<td width="10%">स्नातक</td>
				<td><span class="form-control-span" id="graduation_board_name1"></span></td>
				<td><span class="form-control-span" id="graduation_passing_year1"></span></td>
				<td><span class="form-control-span" id="graduation_marks1"></span></td>
				<td><span class="form-control-span" id="graduation_total_marks1"></span></td>
				<td><span class="form-control-span" id="graduation_percentage1"></span></td>
				<td><span class="form-control-span" id="graduation_marksheet1"></td>
				<td><span class="form-control-span" id="graduation_certificate1"></td>
				</tr>
				
				<tr>
				<td width="10%">परास्नातक</td>
				<td><span class="form-control-span" id="postgraduation_board_name1"></span></td>
				<td><span class="form-control-span" id="postgraduation_passing_year1"></span></td>
				<td><span class="form-control-span" id="postgraduation_marks1"></span></td>
				<td><span class="form-control-span" id="postgraduation_total_marks1"></span></td>
				<td><span class="form-control-span" id="postgraduation_percentage1"></span></td>
				<td><span class="form-control-span" id="postgraduation_marksheet1"></td>
				<td><span class="form-control-span" id="postgraduation_certificate1"></td>
				</tr>
				
				</table>
			</div>
		  
		  <div class="row">
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">राज्य  / केंद्र सरकार द्वारा मान्यता प्राप्त संसथान से यदि पूर्व में कृत्रिम गर्भाधान के प्रशिक्षण का प्रमाण पत्र प्राप्त किया हो (स्वप्रमाणित छाया प्रति संलग्न करें)</label>
				  <span class="form-control-span" id="training_certificate1"></span>
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
				  <label for="inputEmail4">प्रशिक्षणोपरांत ए. आई.  किट तथा  बायोलोजिकल कन्टेनर प्राप्त किये गये है</label>
				  <span class="form-control-span" id="AIkit1"></span>
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">वोटर आई डी कार्ड  / आधार कार्ड / पैन कार्ड की स्वप्रमाणित छाया प्रति संलग्न करें</label>
				  <span class="form-control-span" id="id_upload1"></span>
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">जाति (एस सी / एस टी श्रेणी हेतु न्याय अधिकारी द्वारा जारी प्रमाण पत्र की स्वप्रमाणित छाया प्रति संलग्न करें</label>
				  <span class="form-control-span" id="caste_certificate1"></span>
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">राजकीय चिकित्साधिकारी द्वारा प्रदत्त स्वास्थ्य प्रमाण पत्र</label>
				  <span class="form-control-span" id="health_certificate1"></span>
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
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;" id="loader"> </span>
            
        </div>
        
    </form>

<!--First row Closed-->
</div>
<script>

$(document).ready(function(){
	
	$("#high_marks").keypress(function (e){
	  var charCode = (e.which) ? e.which : e.keyCode;
	  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	  }
	});
	
	$("#high_total_marks").keypress(function (e){
	  var charCode = (e.which) ? e.which : e.keyCode;
	  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	  }
	});
	
	$("#inter_marks").keypress(function (e){
	  var charCode = (e.which) ? e.which : e.keyCode;
	  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	  }
	});
	
	$("#inter_total_marks").keypress(function (e){
	  var charCode = (e.which) ? e.which : e.keyCode;
	  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	  }
	});
	
	
	$("#graduation_marks").keypress(function (e){
	  var charCode = (e.which) ? e.which : e.keyCode;
	  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	  }
	});
	
	$("#graduation_total_marks").keypress(function (e){
	  var charCode = (e.which) ? e.which : e.keyCode;
	  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	  }
	});
	
	$("#postgraduation_marks").keypress(function (e){
	  var charCode = (e.which) ? e.which : e.keyCode;
	  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	  }
	});
	
	$("#postgraduation_total_marks").keypress(function (e){
	  var charCode = (e.which) ? e.which : e.keyCode;
	  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	  }
	});
	
});
	
$(function () {
	
        $("#high_marks, #high_total_marks").change(function () {
			
			if($("#high_marks").val()!='' && $("#high_total_marks").val()!='')
			{
            var result = parseFloat(parseInt($("#high_marks").val()) * 100) / parseInt($("#high_total_marks").val());
            result = result.toFixed(2);
            result = result.replace(/\.00$/,'');
            $('#high_percentage').val(result || '');
			}
			else{
				
				$('#high_percentage').val();
			}
        });
        
        $("#inter_marks, #inter_total_marks").change(function () {
			if($("#inter_marks").val()!='' && $("#inter_total_marks").val()!='')
			{
            var result = parseFloat(parseInt($("#inter_marks").val()) * 100) / parseInt($("#inter_total_marks").val());
            result = result.toFixed(2);
            result = result.replace(/\.00$/,'');
            $('#inter_percentage').val(result || '');
            }
			else{
				
				$('#inter_percentage').val();
			}
        });
        
        
        $("#graduation_marks, #graduation_total_marks").change(function () {
			if($("#graduation_marks").val()!='' && $("#graduation_total_marks").val()!='')
			{
            var result = parseFloat(parseInt($("#graduation_marks").val()) * 100) / parseInt($("#graduation_total_marks").val());
            result = result.toFixed(2);
            result = result.replace(/\.00$/,'');
            $('#graduation_percentage').val(result || '');
            }
			else{
				
				$('#graduation_percentage').val();
			}
        });
        
        $("#postgraduation_marks, #postgraduation_total_marks").change(function () {
			if($("#postgraduation_marks").val()!='' && $("#postgraduation_total_marks").val()!='')
			{
            var result = parseFloat(parseInt($("#postgraduation_marks").val()) * 100) / parseInt($("#postgraduation_total_marks").val());
            result = result.toFixed(2);
            result = result.replace(/\.00$/,'');
            $('#postgraduation_percentage').val(result || '');
            }
			else{
				
				$('#postgraduation_percentage').val();
			}
        });
        
    });
	
	
$(function(){
    $("button#nextMe").click(function(){
        
        
        $("input").each(function() {
			var name = $(this).attr("name");
			var id = $(this).attr("id");
			var val = $(this).val();

			if ((id) && id !== "" && val!='') {
				//console.log('id=' + id + '1' + ' and value=' + val);
				$('#' + id + '1').html(val);
				if(id=='permanent_address_proof')
				{
					var ImageName = $('#' + id).val().split('\\').pop();
					$('#' + id + '1').html(ImageName);
				}
				
				if(id=='applicant_photo')
				{
					var ImageName = $('#' + id).val().split('\\').pop();
					$('#' + id + '1').html(ImageName);
				}
				
				if(id=='signature')
				{
					var ImageName = $('#' + id).val().split('\\').pop();
					$('#' + id + '1').html(ImageName);
				}
				
				if(id=='high_certificate')
				{
					var ImageName = $('#' + id).val().split('\\').pop();
					$('#' + id + '1').html(ImageName);
				}
				
				if(id=='inter_certificate')
				{
					var ImageName = $('#' + id).val().split('\\').pop();
					$('#' + id + '1').html(ImageName);
				}
				
				if(id=='training_certificate')
				{
					var ImageName = $('#' + id).val().split('\\').pop();
					$('#' + id + '1').html(ImageName);
				}
				
				if(id=='id_upload')
				{
					var ImageName = $('#' + id).val().split('\\').pop();
					$('#' + id + '1').html(ImageName);
				}
				
				if(id=='caste_certificate')
				{
					var ImageName = $('#' + id).val().split('\\').pop();
					$('#' + id + '1').html(ImageName);
				}
				
				if(id=='high_marksheet')
				{
					var ImageName = $('#' + id).val().split('\\').pop();
					$('#' + id + '1').html(ImageName);
				}
				
				if(id=='inter_marksheet')
				{
					var ImageName = $('#' + id).val().split('\\').pop();
					$('#' + id + '1').html(ImageName);
				}
				
				if(id=='graduation_marksheet')
				{
					var ImageName = $('#' + id).val().split('\\').pop();
					$('#' + id + '1').html(ImageName);
				}
				
				if(id=='graduation_certificate')
				{
					var ImageName = $('#' + id).val().split('\\').pop();
					$('#' + id + '1').html(ImageName);
				}
				
				if(id=='postgraduation_marksheet')
				{
					var ImageName = $('#' + id).val().split('\\').pop();
					$('#' + id + '1').html(ImageName);
				}
				
				if(id=='postgraduation_certificate')
				{
					var ImageName = $('#' + id).val().split('\\').pop();
					$('#' + id + '1').html(ImageName);
				}
				
				if(id=='health_certificate')
				{
					var ImageName = $('#' + id).val().split('\\').pop();
					$('#' + id + '1').html(ImageName);
				}

			}
		});  
    
    
		$("select").each(function() {
			var name = $(this).attr("name");
			var id = $(this).attr("id");
			var val = $(this).val();
			var textValue = $(this).find('option:selected').text()
			//$('#districtID').html($('#district :selected').text());
			//console.log(textValue);
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
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
}
</style>
 @endsection 
