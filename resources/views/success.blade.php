@extends('master')
@section('content')
@php
use App\Models\Districts;
use App\Models\Rejectcomment;
@endphp
<div class="container main-div" style="background-color:white; height: 100%;">
    <!--First row Start -->
@if(session()->get('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}  
  </div>
@endif

        <!------Summary Page Start---------------->
        
 <style>
 .font-weight-medium {
    font-weight: 600;
}
.form-control-span {
    display: inline;
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
  <div class="col-12 p-4">
    <div class="row">
        <h5 class="d-block w-100 col-12 border-bottom pb-2 px-0 mb-4 font-weight-bold">
			<?php
			$heading = \Session::get('heading');
			$confirmationMesage1 = \Session::get('confirmationMesage1');
			$confirmationMesage2 = \Session::get('confirmationMesage2');
			echo $heading;       
			?>
			</h5> 
        <div class="col-12 mx-auto mb-4" id="printID">
			<div class="col-12 confirmation_box my-5 text-center">
				<button id="noPrint" type="button" class="btn btn-primary mt-4" style="cursor: pointer;" onclick="$('#printID').print();">प्रिंट करें</button>
             </div>
             <div class="col-12 confirmation_box my-5 text-center">
			  <img src="{{ asset('')}}images/logo.jpg" alt="" class="img-fluid" id="logo" style="display:none;">
              <img src="{{ asset('')}}images/check.png" width="40" alt="Success" id="succesIMG">
              <h5 class="font-weight-medium my-3"><?php echo $confirmationMesage1;?></h5>
              <h5 class="font-weight-medium my-3">आपका आवेदन <?php echo $district->name_hindi;?> सी. वी. ओ. को भेज दिया गया है।</h5>
              <h5 class="font-weight-medium my-3"><?php echo $confirmationMesage2;?></h5>
              </div>
              
              
<div class="col-12 confirmation_box my-5 text-center">
              
 
<!------Summary Page Start---------------->
        <div class="tab1">
			<h3>आवेदक का विवरण </h3>
			<div class="row">
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">आवेदक का नाम </label> : {{$result->applicant_name}}
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">पिता  / पति का नाम </label> : {{$result->fname}}
				  <span class="form-control-span" id="fname1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">माता का नाम </label> : {{$result->mother}}
				  <span class="form-control-span" id="fname1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">जन्म तिथि (हाई स्कूल प्रमाण पत्र के अनुसार)</label> : {{\Carbon\Carbon::parse($result->dob)->format('d-m-Y')}}
				  <span class="form-control-span" id="dob1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">दूरभाष  / मोबाइल नंबर</label> : {{$result->mobile}}
				  <span class="form-control-span" id="mobile1"></span>
				</div>
				
				<div class="form-group col-md-4">
					<?php $category = array(
					'जनरल'=>'सामान्य (GENERAL)', 
					'ओ बी सी'=>'अन्य पिछड़ा वर्ग  (OBC)',
					'एस सी'=>'अनुसूचित जाति (SC)', 
					'एस टी'=>'अनुसूचित जनजाति (ST)',  
					);
					?>
				  <label for="inputEmail4">श्रेणी</label> : {{@$category[$result->category]}}
				  <span class="form-control-span" id="category1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">स्थायी पते  के प्रमाण का प्रकार </label> : {{$result->address_type}}
				  <span class="form-control-span" id="address_type1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">स्थायी पता </label> : {{$result->permanent_address}}
				  <span class="form-control-span" id="permanent_address1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">स्थायी पता का प्रमाण - पत्र </label> : 
				  @if($result->permanent_address_proof!='')
				  <div  class="form-control-span" id="permanent_address_proof1">
					<img class="img-thumbnail" width="100" src="{{ asset('')}}upload_documents/{{$result->permanent_address_proof}}">
				  </div>
				  @else
							No documents
				  @endif
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">पोस्ट ऑफिस </label> : {{$result->post_office}}
				  <span class="form-control-span" id="post_office1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">पिनकोड </label> : {{$result->pincode}}
				  <span class="form-control-span" id="pincode1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">ग्राम पंचायत का नाम</label> : {{$result->gram_panchayat_name}}
				  <span class="form-control-span" id="gram_panchayat_name1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">लिंग</label> : {{$result->gender}}
				  <span  class="form-control-span" id="gender1"></span>
				</div>
                
				@if($result->gender == 'महिला')
				<div class="form-group col-md-4">
				  <label for="inputEmail4">पशु सखी/आजीविका सखी/ एनआरएलएम</label> : {{$result->pashu_sakhi == '1' ? 'हाँ' : 'नहीं'}}
				  <span  class="form-control-span" id="pashu_sakhi1"></span>
				</div>
				@endif

				<div class="form-group col-md-4">@php $district = Districts::find($result->district_id)@endphp
				  <label for="inputPassword4">जनपद </label> : {{$district->name_hindi}}
				  <span  class="form-control-span" id="janpad1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">विकास खण्ड </label> : {{$result->vikas_khand}}
				  <span  class="form-control-span" id="vikas_khand1"></span>
				</div>
				
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">पत्र  - व्यवहार का पता </label> : {{$result->letter_address}}
				  <span class="form-control-span" id="letter_address1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">ई  - मेल  </label> : {{$result->email}}
				  <span  class="form-control-span" id="email1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">आवेदक की फोटो </label> : 
				  @if($result->applicant_photo!='')
				  <div  class="form-control-span" id="applicant_photo1">
					<img class="img-thumbnail" width="100" src="{{ asset('')}}upload_documents/{{$result->applicant_photo}}">
				  </div>
				  @else
							No documents
				  @endif
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">अभ्यर्थी  का हस्ताक्षर </label> : 
				  @if($result->signature!='')
				  <div  class="form-control-span" id="signature1">
					<img class="img-thumbnail" width="100" src="{{ asset('')}}upload_documents/{{$result->signature}}">
				  </div>
				  @else
							No documents
				  @endif
				  
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
				</tr>
				<tr>
				<td>हाई स्कूल (जीव विज्ञान)</td>
				<td><span class="form-control-span" id="high_board_name1">{{$result->high_board_name}}</span></td>
				<td><span class="form-control-span" id="high_passing_year1">{{$result->high_passing_year}}</span></td>
				<td><span class="form-control-span" id="high_marks1"></span>{{$result->high_marks}}</td>
				<td><span class="form-control-span" id="high_total_marks1">{{$result->high_total_marks}}</span></td>
				<td><span class="form-control-span" id="high_percentage1">{{$result->high_percentage}}</span></td>
				
				<td><span class="form-control-span" id="high_certificate1">
					
					
				@if($result->high_marksheet!='' && @file_exists(public_path(). '/upload_documents/'. $result->high_marksheet))
				  <div  class="form-control-span" id="signature1">
					<img class="img-thumbnail" width="100" src="{{ asset('')}}upload_documents/{{$result->high_marksheet}}">
				  </div>
				  
				  @else
							No documents
				  @endif

				 </span></td>
				 
				
				</tr>
				<tr>
				<td width="10%">इण्टर (जीव विज्ञान)</td>
				<td><span class="form-control-span" id="inter_board_name1">{{$result->inter_board_name}}</span></td>
				<td><span class="form-control-span" id="inter_passing_year1">{{$result->inter_passing_year}}</span></td>
				<td><span class="form-control-span" id="inter_marks1">{{$result->inter_marks}}</span></td>
				<td><span class="form-control-span" id="inter_total_marks1">{{$result->inter_total_marks}}</span></td>
				<td><span class="form-control-span" id="inter_percentage1">{{$result->inter_percentage}}</span></td>
				<td><span class="form-control-span" id="inter_certificate1">
					@if($result->inter_marksheet!='' && @file_exists(public_path(). '/upload_documents/'. $result->inter_marksheet))
				  <div  class="form-control-span" id="signature1">
					<img class="img-thumbnail" width="100" src="{{ asset('')}}upload_documents/{{$result->inter_marksheet}}">
				  </div>
				  
				  @else
							No documents
				  @endif
	
					</span></td>
					
					
				</tr>
				
				<tr>
				<td width="10%">स्नातक</td>
				<td><span class="form-control-span" id="inter_board_name1">{{$result->graduation_board_name}}</span></td>
				<td><span class="form-control-span" id="inter_passing_year1">{{$result->graduation_passing_year}}</span></td>
				<td><span class="form-control-span" id="inter_marks1">{{$result->graduation_marks}}</span></td>
				<td><span class="form-control-span" id="inter_total_marks1">{{$result->graduation_total_marks}}</span></td>
				<td><span class="form-control-span" id="inter_percentage1">{{$result->graduation_percentage}}</span></td>
				<td><span class="form-control-span" id="inter_certificate1">
					@if($result->graduation_marksheet!='' && @file_exists(public_path(). '/upload_documents/'. $result->graduation_marksheet))
				  <div  class="form-control-span" id="signature1">
					<img class="img-thumbnail" width="100" src="{{ asset('')}}upload_documents/{{$result->graduation_marksheet}}">
				  </div>
				  @else
							No documents
				  @endif
					
					</span></td>
				</tr>
				
				
				<tr>
				<td width="10%">परास्नातक</td>
				<td><span class="form-control-span" id="inter_board_name1">{{$result->postgraduation_board_name}}</span></td>
				<td><span class="form-control-span" id="inter_passing_year1">{{$result->postgraduation_passing_year}}</span></td>
				<td><span class="form-control-span" id="inter_marks1">{{$result->postgraduation_marks}}</span></td>
				<td><span class="form-control-span" id="inter_total_marks1">{{$result->postgraduation_total_marks}}</span></td>
				<td><span class="form-control-span" id="inter_percentage1">{{$result->postgraduation_percentage}}</span></td>
				<td><span class="form-control-span" id="inter_certificate1">
					@if($result->postgraduation_marksheet!='' && @file_exists(public_path(). '/upload_documents/'. $result->postgraduation_marksheet))
				  <div  class="form-control-span" id="signature1">
					<img class="img-thumbnail" width="100" src="{{ asset('')}}upload_documents/{{$result->postgraduation_marksheet}}">
				  </div>
				  @else
							No documents
				  @endif
					</span></td>
				</tr>
				
				</table>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
				  <label for="inputEmail4">प्रशिक्षण का प्रमाण किस संस्थान से लिया गया है</label> : 
				  <span class="form-control-span" id="training_adopted1">{{$result->training_adopted}}</span>
				</div>
			</div>
		  
		  <div class="row">
				@if($result->training_adopted!='नहीं')
				<div class="form-group col-md-9">
				  <label for="inputEmail4">राज्य  / केंद्र सरकार द्वारा मान्यता प्राप्त संसथान से यदि पूर्व में कृत्रिम गर्भाधान के प्रशिक्षण का प्रमाण पत्र प्राप्त किया हो </label> : 
				  <span class="form-control-span" id="training_certificate1">
				  @if($result->training_certificate!='')
				  <img class="img-thumbnail" width="100" src="{{ asset('')}}upload_documents/{{$result->training_certificate}}">
				  @else
							No documents
				  @endif
				  </span>
				</div>
				
				<div class="form-group col-md-2">
				  <label for="inputEmail4">माह</label> : 
				  <span class="form-control-span" id="high_percentage1">{{$result->training_certificate_period_in_month}}</span>
				</div>
				
				<div class="form-group col-md-1">
				  <label for="inputEmail4">दिन</label> : 
				  <span class="form-control-span" id="high_percentage1">{{$result->training_certificate_period_in_days}}</span>
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">योजना का नाम जिसके अंतर्गत प्रशिक्षण प्राप्त किया गया</label> : 
				  <span class="form-control-span" id="yojna_name_for_training1">{{$result->yojna_name_for_training}}</span>
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">प्रशिक्षणोपरांत ए. आई.  किट तथा  बायोलोजिकल कन्टेनर प्राप्त किये गये है</label> : 
				  <span class="form-control-span" id="AIkit1">{{$result->AIkit}}</span>
				</div>
				@endif
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">वोटर आई डी कार्ड  / आधार कार्ड / पैन कार्ड का प्रमाण - पत्र</label> : 
				  <span class="form-control-span" id="id_upload1">
				  @if($result->id_upload!='')
				  <img class="img-thumbnail" width="100" src="{{ asset('')}}upload_documents/{{$result->id_upload}}">
				  @else
							No documents
				  @endif
				  </span>
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">जाति (अनुसूचित जाति  / अनुसूचित जनजाति  श्रेणी हेतु न्याय अधिकारी द्वारा जारी प्रमाण पत्र </label> : 
				  <span class="form-control-span" id="caste_certificate1">
				  @if($result->caste_certificate!='')
				  <img class="img-thumbnail" width="100" src="{{ asset('')}}upload_documents/{{$result->caste_certificate}}">
				  @else
							No documents
				  @endif
				   </span>
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">राष्ट्रीयता </label> : {{$result->nationality}}
				</div>
		</div>
		
		
		
		<!--------Comment Start here------------>
			@php $coments = Rejectcomment::where('application_id', '=', $result->id)->first()@endphp
			@if(!empty($coments))
			<div class="alert alert-danger" style="width: 100%;">
				{{$coments->comments}}	
			</div>
			@endif
		    <!--------Comment End here------------>
		
		</div>
		
</div>
        
        
        <!------Summary Page End---------------->             
              
              
</div>

        </div>

    </div>
  </div>
  <script>
  $.fn.extend({
	print: function() {
		$('#noPrint').hide();
		$('#logo').show();
		$('#succesIMG').hide();
		var frameName = 'printIframe';
		var doc = window.frames[frameName];
		if (!doc) {
			$('<iframe>').hide().attr('name', frameName).appendTo(document.body);
			doc = window.frames[frameName];
		}
		doc.document.body.innerHTML = this.html();
		doc.window.print();
		$('#noPrint').show();
		$('#logo').hide();
		$('#succesIMG').show();
		return this;
	}
}); 
</script>     
        <!------Summary Page End---------------->
     
        

</div>

 @endsection 
