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
        'permanent_address',
        'gram_panchayat_name',
        'niyay_panchayat_name',
        'vikas_khand',
        'letter_address',
        'high_board_name',
        'inter_board_name',
        ]);
      }
      google.setOnLoadCallback(onLoad);
    </script>
    
<div class="container main-div" style="background-color:white; height: 100%;">
    <!--First row Start -->
	 
 <h1 style="margin-top:10px;text-align: center;">आवेदन  - पत्र - अपडेट  
 <div class=" pull-right">
			<a href="{{ url('avedan') }}" class="btn btn-info">Back</a>
		</div>
 </h1>
@if(session()->get('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}  
  </div>
@endif
	<form method="post" action="{{ url('avedanUpdated') }}/{{$result->id}}" id="avedanEdit"  enctype="multipart/form-data">
	@csrf
        <!-- Circles which indicates the steps of the form: -->
        <div style="text-align:center;margin-top:40px;">
            <span class="step">1 </span><h3 style="display:inline;font-size: 18px;"> 
				<span data-hi="आवेदक का विवरण" data-en="Applicant details"></span>    </h3>
            <span class="step">2 </span><h3 style="display:inline;font-size: 18px;">
				<span data-hi="शैक्षिक योग्यता व अन्य विवरण" data-en="Educational Qualification and other details"></span>  
			</h3>
			<span class="step">4 </span>
                <h3 style="display:inline;font-size: 18px;">
                <span data-hi="आवेदक का बैंक विवरण" data-en="Applicant Bank Details"></span>        
                </h3>
            <span class="step">4 </span><h3 style="display:inline;font-size: 18px;">
				<span data-hi="सारांश" data-en="Summary"></span>    
			</h3>
        </div>
        <hr>
        
        <div class="tab">
			<h3>आवेदक का विवरण </h3>
			<div class="row">
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">आवेदक का नाम </label>
				  <input type="text" class="form-control" value="{{$result->applicant_name}}" name="applicant_name" id="applicant_name" placeholder="आवेदक का नाम">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputPassword4">पिता  / पति का नाम </label>
				  <input type="text" class="form-control" value="{{$result->fname}}" id="fname" name="fname" placeholder="पिता  / पति का नाम">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">जन्म तिथि (हाई स्कूल प्रमाण पत्र के अनुसार)</label>
				  <input type="text" class="form-control" value="{{\Carbon\Carbon::parse($result->dob)->format('d-m-Y')}}" name="dob" id="dob" placeholder="जन्म तिथि" readonly>
				</div>

				<div class="form-group col-md-6">
                        <label for="inputEmail4"><span data-hi="पिछला आवेदन नंबर" data-en="Previous Avedan Number"> </span> </label>
                        <input type="text" class="form-control" name="previous_avedan_number" id="previous_avedan_number"
                            placeholder="पिछला आवेदन नंबर" autocomplete="off" value="{{ $result->previous_avedan_number }}">
                    </div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">दूरभाष  / मोबाइल नंबर</label>
				  <input type="text" class="form-control" value="{{$result->mobile}}" name="mobile" id="mobile" placeholder="दूरभाष  / मोबाइल नंबर">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4"></label>
				  <select class="form-control" name="category" id="category">
					  <option value="">सेलेक्ट</option>
					  <option value="जनरल" {{ $result->category=='जनरल' ? 'selected' : '' }}>सामान्य</option>
					  <option value="एस सी" {{ $result->category=='एस सी' ? 'selected' : '' }}>अनुसूचित जाति</option>
					  <option value="एस टी" {{ $result->category=='एस टी' ? 'selected' : '' }}>अनुसूचित जनजाति</option>
					  <option value="ओ बी सी" {{ $result->category=='ओ बी सी' ? 'selected' : '' }}>अन्य पिछड़ा वर्ग</option>
				  </select>
				</div>
				<div class="form-group col-md-6">
					<label for="inputPassword4"><span data-hi="स्थायी पता के प्रमाण-पत्र संख्या " data-en="Permanent Address Certificate Number"> </span>  </label> 
					<input type="text" class="form-control" name="address_number" id="address_number"
						placeholder="स्थायी पता के प्रमाण-पत्र संख्या" autocomplete="off" value="{{ $result->address_number }}">
				</div>

				<div class="form-group col-md-6">
				  <label for="inputPassword4">स्थायी पता </label>
				  <input type="text" class="form-control" value="{{$result->permanent_address}}" name="permanent_address" id="permanent_address" placeholder="स्थायी पता">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputPassword4">स्थायी पता का प्रमाण - पत्र </label>
				  @if($result->permanent_address_proof!='')
							<a href="{{ url('downloadFile', $result->permanent_address_proof) }}">Download</a>
				  @else
							No documents
				  @endif
				  <input type="file" class="form-control" name="permanent_address_proof" id="permanent_address_proof">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputPassword4">न्याय पंचायत का नाम </label>
				  <input type="text" class="form-control" value="{{$result->niyay_panchayat_name}}" name="niyay_panchayat_name" id="niyay_panchayat_name" placeholder="न्याय पंचायत का नाम">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputPassword4">जनपद </label>
				  <select class="form-control" name="janpad" id="janpad">
                        <option value="">जनपद चुने</option>
                        @foreach($districts as $row)
							<option value="{{$row->id}}" {{ $result->district_id==$row->id ? 'selected' : '' }}>{{$row->name_hindi}}</option>
							@endforeach
                      </select>
				</div>

				<div class="form-group col-md-6">
					<label for="inputPassword4"><span data-hi="तहसील" data-en="Tehsil"> </span> </label>
					<input type="text" class="form-control" value="{{$result->tehsil}}" name="tehsil" id="tehsil" placeholder="तहसील">
				</div>

				<div class="form-group col-md-6">
					<label for="inputEmail4"><span data-hi="विकास खण्ड" data-en="Vikas Khand"> </span>  </label> 
					<input type="text" class="form-control" value="{{$result->vikas_khand}}" name="vikas_khand" id="vikas_khand" placeholder="विकास खण्ड">
				</div>
				<div class="form-group col-md-6">
				  <label for="inputEmail4">ग्राम पंचायत का नाम</label>
				  <input type="text" class="form-control" value="{{$result->gram_panchayat_name}}" name="gram_panchayat_name" id="gram_panchayat_name" placeholder="ग्राम पंचायत का नाम">
				</div>

				<div class="form-group col-md-6">
					<label for="inputPassword4"><span data-hi="पोस्ट ऑफिस" data-en="Post Office"> </span>  </label> 
					<input type="text" class="form-control" value="{{$result->post_office}}" name="post_office" id="post_office" placeholder="पोस्ट ऑफिस">
				</div>

				<div class="form-group col-md-6">
					<label for="inputPassword4"><span data-hi="एआई सेंटर (पशु चिकित्सा अस्पताल / एलईओ सेंटर)" data-en="AI Centre (Veterinary Hospital / LEO Center)"> </span>  </label> 
					<input type="text" class="form-control" value="{{$result->ai_center}}" name="ai_center" id="ai_center" placeholder="एआई सेंटर">
				</div>

			
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">पत्र  - व्यवहार का पता </label>
				  <input type="text" class="form-control" value="{{$result->letter_address}}" name="letter_address" id="letter_address" placeholder="पत्र  - व्यव्हार का पता">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputPassword4">ई  - मेल  </label>
				  <input type="text" class="form-control" value="{{$result->email}}" readonly name="email" id="email" placeholder="ई  - मेल">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputPassword4">आवेदक की फोटो </label>
				  @if($result->applicant_photo!='')
					<img height="100" src="{{ asset('')}}upload_documents/{{$result->applicant_photo}}" style="margin-bottom: 5px;">
				  @else
					No Photo
				  @endif
				  <input type="file" class="form-control" name="applicant_photo" id="applicant_photo" placeholder="आवेदक की फोटो">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputPassword4">अभ्यर्थी  का हस्ताक्षर </label>
				  @if($result->signature!='')
					<img height="100" src="{{ asset('')}}upload_documents/{{$result->signature}}" style="margin-bottom: 5px;">
				  @else
					No signature
				  @endif
				  <input type="file" class="form-control" name="signature" id="signature" placeholder="अभ्यर्थी  का हस्ताक्षर">
				</div>
				
		  </div>
        </div>
        
        <div class="tab">
			<h3>शैक्षिक योग्यता व अन्य विवरण </h3>
			<div class="row">
				<table>
				<tr>
				<td width="10%">उत्तीर्ण परीक्षा का नाम</td>
				<td>बोर्ड का नाम</td>
				<td>उत्तीर्ण वर्ष</td>
				<td>प्राप्तांक</td>
				<td>पूर्णांक</td>
				<td>प्रतिशत</td>
				<td>अंकतालिका</td>
				</tr>
				<tr>
				<td>हाई स्कूल (जीव विज्ञान)</td>
				<td><input type="text" value="{{$result->high_board_name}}" class="form-control" name="high_board_name" id="high_board_name" placeholder="बोर्ड का नाम"></td>
				<td><input type="text" value="{{$result->high_passing_year}}" class="form-control" name="high_passing_year" id="high_passing_year" placeholder="उत्तीर्ण वर्ष"></td>
				<td><input type="text" value="{{$result->high_marks}}" class="form-control" name="high_marks" id="high_marks" placeholder="प्राप्तांक"></td>
				<td><input type="text" value="{{$result->high_total_marks}}" class="form-control" name="high_total_marks" id="high_total_marks" placeholder="पूर्णांक"></td>
				<td><input type="text" value="{{$result->high_percentage}}" class="form-control" readonly name="high_percentage" id="high_percentage" placeholder="प्रतिशत"></td>
				<td>
					<input type="file" class="form-control" name="high_marksheet" id="high_marksheet"> 
				  @if($result->high_marksheet!='')
							<a href="{{ url('downloadFile', $result->high_marksheet) }}">हाई स्कूल की अंकतालिका</a>
				  @else
							No documents
				  @endif
				</td>
				</tr>
				</table>
			</div>
			<div class="row">
				<table>
				<tr>
				<td width="10%">इण्टर (जीव विज्ञान)</td>
				<td><input type="text" value="{{$result->inter_board_name}}" class="form-control" name="inter_board_name" id="inter_board_name" placeholder="बोर्ड का नाम"></td>
				<td><input type="text" value="{{$result->inter_passing_year}}" class="form-control" name="inter_passing_year" id="inter_passing_year" placeholder="उत्तीर्ण वर्ष"></td>
				<td><input type="text" value="{{$result->inter_marks}}" class="form-control" name="inter_marks" id="inter_marks" placeholder="प्राप्तांक"></td>
				<td><input type="text" value="{{$result->inter_total_marks}}" class="form-control" name="inter_total_marks" id="inter_total_marks" placeholder="पूर्णांक"></td>
				<td><input type="text" value="{{$result->inter_percentage}}" class="form-control" readonly name="inter_percentage" id="inter_percentage" placeholder="प्रतिशत"></td>
				<td><input type="file" class="form-control" name="inter_marksheet" id="inter_marksheet">
				@if($result->inter_marksheet!='')
							<a href="{{ url('downloadFile', $result->inter_marksheet) }}">इण्टर का अंकतालिका</a>
				  @else
							No documents
				  @endif
				</td>
				
				</tr>
				</table>
			</div>
		  <div class="row"><hr></div>
		  <div class="row">
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">राज्य  / केंद्र सरकार द्वारा मान्यता प्राप्त संस्थान से यदि पूर्व में कृत्रिम गर्भाधान के प्रशिक्षण का प्रमाण-पत्र प्राप्त किया हो 
				  @if($result->training_certificate!='')
							<a href="{{ url('downloadFile', $result->training_certificate) }}">डाउनलोड</a>
				  @else
							No documents
				  @endif
				  </label>
				  <input type="file" class="form-control" name="training_certificate" id="training_certificate">
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">प्रशिक्षण की अवधि माह</label>
				  <select class="form-control" name="training_certificate_period_in_month" id="training_certificate_period_in_month">
					<option value="">माह</option>
					<?php
					  for($m=0;$m<=12;$m++)
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
					  for($m=0;$m<=29;$m++)
					  {
						 ?>
					<option value="{{$m}}" {{ $result->training_certificate_period_in_days==$m ? 'selected' : '' }}>{{$m}} दिन</option>
					<?php } ?>
				  </select>
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">वोटर आई डी कार्ड  / आधार कार्ड / पैन कार्ड का प्रमाण - पत्र 
				  @if($result->id_upload!='')
							<a href="{{ url('downloadFile', $result->id_upload) }}">डाउनलोड</a>
				  @else
							No documents
				  @endif
				  </label>
				  <input type="file" class="form-control" name="id_upload" id="id_upload">
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">जाति (अनुसूचित जाति / अनुसूचित जनजाति) श्रेणी हेतु न्याय अधिकारी द्वारा जारी प्रमाण-पत्रं
				  @if($result->caste_certificate!='')
							<a href="{{ url('downloadFile', $result->caste_certificate) }}">डाउनलोड</a>
				  @else
							No documents
				  @endif
				  </label>
				  <input type="file" class="form-control" name="caste_certificate" id="caste_certificate">
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">राष्ट्रीयता </label>
				  <select class="form-control" name="nationality" id="nationality">
				  <option value="">चुने</option>
				  <option value="भारतीय" {{ $result->nationality=='भारतीय' ? 'selected' : '' }}>भारतीय</option>
				  </select>
				</div>
				
			<div class="form-group col-md-12">
				  <label for="inputEmail4">स्थिति</label>
				  <select class="form-control" name="is_approved" id="is_approved">
				  <option value="">चुने</option>
				  <option value="0" {{ $result->is_approved=='0' ? 'selected' : '' }}>नया आवेदन</option>
				  <option value="1" {{ $result->is_approved=='1' ? 'selected' : '' }}>स्वीकार</option>
				  <option value="2" {{ $result->is_approved=='2' ? 'selected' : '' }}>अस्वीकार</option>
				  </select>
				</div>
		</div>
		  
        </div>
		<div class="tab">
                <h3> <span data-hi="आवेदक का बैंक विवरण" data-en="Applicant Bank Detailss"></span></h3>
                <div class="row">

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">
                        <span data-hi="बैंक का नाम " data-en="Bank Name"></span>      
                         </label> 
                        <select name="bank_name" id="bank_name" class="form-control">
                            <option value="">-कोई भी एक चुनें-</option>
                                @if(count($banks)>0)
                                @foreach($banks as $val)
                                <option value="{{$val->id}}"  {{ $result->bank_name==$val->id ? 'selected' : '' }} >{{$val->name_hi}}</option>
                                @endforeach
                                @endif
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputPassword4">
                        <span data-hi="खाता संख्या" data-en="Account Number"></span>      
                       </label> 
                        <input type="text" class="form-control" id="account_number" name="account_number"
                            placeholder="खाता संख्या" autocomplete="off" value="{{ $result->account_number }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">
                        <span data-hi="आईएफएससी कोड" data-en="IFSC Code"></span>     
                        </label> 
                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code"
                            placeholder="आईएफएससी कोड" autocomplete="off" value="{{ $result->ifsc_code }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">
                        <span data-hi="पीएफएमएस " data-en="PFMS"></span>    
                        </label> 
                        <input type="text" class="form-control" id="pfms" name="pfms"
                            placeholder="पीएफएमएस" autocomplete="off" value="{{ $result->pfms }}">
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
				  <label for="inputEmail4">श्रेणी</label>
				  <span class="form-control-span" id="category1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">स्थायी पता </label>
				  <span class="form-control-span" id="permanent_address1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">स्थायी पता का प्रमाण - पत्र</label>
				  <span class="form-control-span" id="permanent_address_proof1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">ग्राम पंचायत का नाम</label>
				  <span class="form-control-span" id="gram_panchayat_name1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">न्याय पंचायत का नाम </label>
				  <span  class="form-control-span" id="niyay_panchayat_name1"></span>
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
				  <label for="inputEmail4">पत्र  - व्यवहार का पता </label>
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
				<td>अंकतालिका</td>
				<td>प्रमाण - पत्र</td>
				</tr>
				<tr>
				<td>हाई स्कूल (जीव विज्ञान)</td>
				<td><span class="form-control-span" id="high_board_name1"></span></td>
				<td><span class="form-control-span" id="high_passing_year1"></span></td>
				<td><span class="form-control-span" id="high_marks1"></span></td>
				<td><span class="form-control-span" class="form-control-span" id="high_total_marks1"></span></td>
				<td><span class="form-control-span" id="high_percentage1"></span></td>
				<td><span class="form-control-span" id="high_certificate1"></span></td>
				</tr>
				<tr>
				<td width="10%">इण्टर (जीव विज्ञान)</td>
				<td><span class="form-control-span" id="inter_board_name1"></span></td>
				<td><span class="form-control-span" id="inter_passing_year1"></span></td>
				<td><span class="form-control-span" id="inter_marks1"></span></td>
				<td><span class="form-control-span" id="inter_total_marks1"></span></td>
				<td><span class="form-control-span" id="inter_percentage1"></span></td>
				<td><span class="form-control-span" id="inter_certificate1"></td>
				</tr>
				</table>
			</div>
		  
		  <div class="row">
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">राज्य  / केंद्र सरकार द्वारा मान्यता प्राप्त संसथान से यदि पूर्व में कृत्रिम गर्भाधान के प्रशिक्षण का प्रमाण - पत्र प्राप्त किया हो</label>
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
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">वोटर आई डी कार्ड  / आधार कार्ड / पैन कार्ड का प्रमाण - पत्र</label>
				  <span class="form-control-span" id="id_upload1"></span>
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">जाति (अनुसूचित जाति / अनुसूचित जनजाति) श्रेणी हेतु न्याय अधिकारी द्वारा जारी प्रमाण-पत्र</label>
				  <span class="form-control-span" id="caste_certificate1"></span>
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">राष्ट्रीयता </label>
				  <span class="form-control-span" id="nationality1"></span>
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">स्थिति </label>
				  <span class="form-control-span" id="is_approved1"></span>
				</div>
		</div>
		  
        
		</div>
		
		
		</div>
        
        
        <!------Summary Page End---------------->
     
        <div style="overflow:auto;margin-bottom:20px;">
            <div style="float:right; margin-top: 5px;" id="finalSubmit">
                <button type="button" class="previous buttonWizard">Previous</button>
                <button type="button" class="next buttonWizard" id="nextMe">Next</button>
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
	
});
	
$(function () {
	
        $("#high_marks, #high_total_marks").change(function () { // input on change
			
			if($("#high_marks").val()!='' && $("#high_total_marks").val()!='')
			{
            var result = parseFloat(parseInt($("#high_marks").val()) * 100) / parseInt($("#high_total_marks").val());
            result = result.toFixed(2);
            result = result.replace(/\.00$/,'');
            $('#high_percentage').val(result || ''); //shows value in "#rate"
			}
			else{
				
				$('#high_percentage').val(); //shows value in "#rate"
			}
        });
        
        $("#inter_marks, #inter_total_marks").change(function () { // input on change
			if($("#inter_marks").val()!='' && $("#inter_total_marks").val()!='')
			{
            var result = parseFloat(parseInt($("#inter_marks").val()) * 100) / parseInt($("#inter_total_marks").val());
            result = result.toFixed(2);
            result = result.replace(/\.00$/,'');
            $('#inter_percentage').val(result || ''); //shows value in "#rate"
            }
			else{
				
				$('#inter_percentage').val(); //shows value in "#rate"
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

			}
		});  
    
    
		$("select").each(function() {
			var name = $(this).attr("name");
			var id = $(this).attr("id");
			var val = $(this).val();
			var textValue = $(this).find('option:selected').text()
			//$('#districtID').html($('#district :selected').text());
			console.log(textValue);
			$('#' + id + '1').html(textValue);
		});  
    
    
    });
});

	// $('#janpad').change(function() {
	// 	var val = $("#janpad option:selected").val();
	// 	var text = $("#janpad option:selected").text();
	// 	console.log('val',val,'text',text)
	// 	if(val){
	// 		$.ajax({
	// 			type: "GET",
	// 			url: "getAllBlocks",
	// 			headers: {
	// 				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 			},
	// 			data: {
	// 				"_token": "{{ csrf_token() }}",
	// 				"id": val,
	// 				"text":text,
	// 			},
	// 			cache: false,
	// 			success: function(result) {
	// 				console.log('hello',result)
	// 				var blocks = result.blocks;
	// 				var postoffice = result.postoffice;
	// 				var ai_center  =result.ai_center;
	// 				var tehsil    =  result.tehsil;
	// 				$('#vikas_khand').prop('disabled', false);
	// 				$('#vikas_khand').empty();
	// 				$('#post_office').prop('disabled', false);
	// 				$('#post_office').empty();
	// 				$('#ai_center').prop('disabled', false);
	// 				$('#ai_center').empty();
	// 				$('#tehsil').prop('disabled', false);
	// 				$('#tehsil').empty();
	// 				// if(blocks.length>0){
	// 				// 	$('#vikas_khand').append($("<option>-विकास खण्ड चुनें-</option>"));
	// 				// 	blocks.forEach(item => {
	// 				// 		$('#vikas_khand').append('<option value="'+item.block_name+'">' + item.block_name + '</option>')
	// 				// 	});
	// 				// }else{
	// 				// 	$('#vikas_khand').append($("<option value=''>-Data not found.-</option>"));
	// 				// }

	// 				// if(postoffice.length>0){
	// 				// 	$('#post_office').append($("<option value=''>-पोस्ट ऑफिस चुनें-</option>"));
	// 				// 	postoffice.forEach(item => {
	// 				// 		$('#post_office').append('<option value="'+item.post_office+'">' + item.post_office + '</option>')
	// 				// 	});
	// 				// }else{
	// 				// 	$('#post_office').append($("<option value=''>-Data not found.-</option>"));
	// 				// }
	// 				// if(ai_center.length>0){
	// 				// 	$('#ai_center').append($("<option value=''>-एआई सेंटर चुनें-</option>"));
	// 				// 	ai_center.forEach(item => {
	// 				// 		$('#ai_center').append('<option value="'+item.name+'">' + item.name + '</option>')
	// 				// 	});
	// 				// }else{
	// 				// 	$('#ai_center').append($("<option value=''>-Data not found.-</option>"));
	// 				// }
	// 				// if(tehsil.length>0){
	// 				// 	$('#tehsil').append($("<option value=''>-तहसील चुनें-</option>"));
	// 				// 	tehsil.forEach(item => {
	// 				// 		$('#tehsil').append('<option value="'+item.tehsil+'">' + item.tehsil + '</option>')
	// 				// 	});
	// 				// }else{
	// 				// 	$('#tehsil').append($("<option value=''>-Data not found.-</option>"));
	// 				// }
	// 			}
	// 		});
	// 	}
	// });

	// $('#vikas_khand').change(function() {
	// 	var val = $("#vikas_khand option:selected").val();
	// 	console.log('vikas_khand',val)
	// 	if(val){
	// 		$.ajax({
	// 			type: "GET",
	// 			url: "getAllGramPanchayat",
	// 			headers: {
	// 				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 			},
	// 			data: {
	// 				"_token": "{{ csrf_token() }}",
	// 				"id": val
	// 			},
	// 			cache: false,
	// 			success: function(data) {
	// 				$('#gram_panchayat_name').prop('disabled', false);
	// 				$('#gram_panchayat_name').empty();
	// 				if(data.length>0){
	// 					console.log('data',data)
	// 					$('#gram_panchayat_name').append($("<option value=''>-ग्राम पंचायत चुनें-</option>"));
	// 					data.forEach(item => {
	// 						$('#gram_panchayat_name').append('<option value="'+item.gram_panchayat+'">' + item.gram_panchayat + '</option>')
	// 					});
	// 				}else{
	// 					$('#gram_panchayat_name').append($("<option value=''>-Data not found.-</option>"));
	// 				}
	// 			}
	// 		});
	// 	}
	// });
</script>
 @endsection 
