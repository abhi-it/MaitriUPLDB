@extends('master')
@section('content')
@php
use App\Models\Districts;
@endphp
<div class="container main-div" style="background-color:white; height: 100%;">
    <!--First row Start -->
	 
 <h1 style="margin-top:10px;text-align: center;">आवेदन  - पत्र
		<div class=" pull-right">
			@if($result->category=='जनरल' OR $result->category=='ओ बी सी') 
			<a href="{{ url('merit-list') }}/1" class="btn btn-info">Back</a>
			@elseif($result->category=='एस सी')
			<a href="{{ url('merit-list') }}/2" class="btn btn-info">Back</a>
			@else
			<a href="{{ url('merit-list') }}/3" class="btn btn-info">Back</a>
			@endif
		</div>
 </h1>
@if(session()->get('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}  
  </div>
@endif
<style>
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
					'जनरल'=>'सामान्य (general)', 
					'ओ बी सी'=>'अन्य पिछड़ा वर्ग  (OBC)',
					'एस सी'=>'अनुसूचित जाति (SC)', 
					'एस टी'=>'अनुसूचित जनजाति (ST)',  
					);
					?>
				  <label for="inputEmail4">श्रेणी</label> : {{@$category[$result->category]}}
				  <span class="form-control-span" id="category1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">स्थायी पता का प्रमाण का प्रकार </label> : {{$result->address_type}}
				  <span class="form-control-span" id="address_type1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">स्थायी पता </label> : {{$result->permanent_address}}
				  <span class="form-control-span" id="permanent_address1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputPassword4">स्थायी पता  छाया प्रति संलग्न करें </label> : 
				  @if($result->permanent_address_proof!='')
				  <div  class="form-control-span" id="signature1">
					<img class="img-thumbnail" width="100" src="{{ asset('')}}upload_documents/{{$result->permanent_address_proof}}">
				  </div>
				  <div  class="form-control-span" id="signature1">
					<a href="{{ asset('')}}upload_documents/{{$result->permanent_address_proof}}" target="_blank">View</a>
				  </div>
				  @else
							No documents
				  @endif
				  <span class="form-control-span" id="permanent_address_proof1"></span>
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
				
				<div class="form-group col-md-4">@php $district = Districts::find($result->district_id)@endphp
				  <label for="inputPassword4">जनपद </label> : {{$district->name_hindi}}
				  <span  class="form-control-span" id="janpad1"></span>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">विकास खण्ड </label> : {{$result->vikas_khand}}
				  <span  class="form-control-span" id="vikas_khand1"></span>
				</div>
				
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">पत्र  - व्यव्हार का पता </label> : {{$result->letter_address}}
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
				  <div  class="form-control-span" id="applicant_photo1">
					<a href="{{ asset('')}}upload_documents/{{$result->applicant_photo}}" target="_blank">View</a>
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
				  <div  class="form-control-span" id="signature1">
					<a href="{{ asset('')}}upload_documents/{{$result->signature}}" target="_blank">View</a>
				  </div>
				  @else
							No documents
				  @endif
				  
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
				<td>मार्कशीट</td>
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
				  <div  class="form-control-span" id="signature1">
					<a href="{{ asset('')}}upload_documents/{{$result->high_marksheet}}" target="_blank">View</a>
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
				  <div  class="form-control-span" id="signature1">
					<a href="{{ asset('')}}upload_documents/{{$result->inter_marksheet}}" target="_blank">View</a>
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
				  <div  class="form-control-span" id="signature1">
					<a href="{{ asset('')}}upload_documents/{{$result->graduation_marksheet}}" target="_blank">View</a>
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
				  <div  class="form-control-span" id="signature1">
					<a href="{{ asset('')}}upload_documents/{{$result->postgraduation_marksheet}}" target="_blank">View</a>
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
				  <label for="inputEmail4">राज्य  / केंद्र सरकार द्वारा मान्यता प्राप्त संसथान से यदि पूर्व में कृत्रिम गर्भाधान के प्रशिक्षण का प्रमाण पत्र प्राप्त किया हो ( छाया प्रति संलग्न करें)</label> : 
				  <span class="form-control-span" id="training_certificate1">
				  @if($result->training_certificate!='')
				  <img class="img-thumbnail" width="100" src="{{ asset('')}}upload_documents/{{$result->training_certificate}}">
				  <a href="{{ asset('')}}upload_documents/{{$result->training_certificate}}" target="_blank">View</a>
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
				  <label for="inputEmail4">वोटर आई डी कार्ड  / आधार कार्ड / पैन कार्ड की छाया प्रति संलग्न करें</label> : 
				  <span class="form-control-span" id="id_upload1">
				  @if($result->id_upload!='')
				  
				  <img class="img-thumbnail" width="100" src="{{ asset('')}}upload_documents/{{$result->id_upload}}">
				  <a href="{{ asset('')}}upload_documents/{{$result->id_upload}}" target="_blank">View</a>
				  @else
							No documents
				  @endif
				  </span>
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">जाति (एस सी / एस टी श्रेणी हेतु न्याय अधिकारी द्वारा जारी प्रमाण पत्र की  छाया प्रति संलग्न करें</label> : 
				  <span class="form-control-span" id="caste_certificate1">
				  @if($result->caste_certificate!='')
				  <img class="img-thumbnail" width="100" src="{{ asset('')}}upload_documents/{{$result->caste_certificate}}">
				  <a href="{{ asset('')}}upload_documents/{{$result->caste_certificate}}" target="_blank">View</a>
				  @else
							No documents
				  @endif
				   </span>
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">राष्ट्रीयता </label> : {{$result->nationality}}
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">स्टेटस </label>
			@if($result->is_approved==0)
				<a href="javascript:void(0)" class="btn btn-secondary">लंबित</a>
			@elseif($result->is_approved==1)
				<a href="javascript:void(0)" class="btn btn-success">स्वीकृत</a>
			@elseif($result->is_approved==2)
				<a href="javascript:void(0)" class="btn btn-success">अस्वीकार</a>
			@elseif($result->is_approved==3)
				<a href="javascript:void(0)" class="btn btn-info active">प्रतीक्षा सूची में है..</a>
			@elseif($result->is_approved==4)
				<a href="javascript:void(0)" class="btn btn-info active">चयनित</a>
			@endif
				</div>
		</div> 
		  @if(auth()->user()->user_type=='District Officer' AND $result->is_approved==0) <!-----Then Display these buttons-->
			  
				@if($waitingButtonShow==1) <!-----Then Display these buttons-->
				  
				<div class="row">
					<a href="{{url('avedanStatus')}}/{{$result->id}}/1" class="btn btn-primary">स्वीकार</a>
					<a href="javascript:void(0)" class="btn btn-danger" style="margin-left:20px;" data-toggle="modal" data-target="#exampleModalCenter">अस्वीकार</a>
				</div>
				@else
				<div class="row">
					<a href="{{url('avedanStatus')}}/{{$result->id}}/3" class="btn btn-warning">प्रतीक्षा सूची बनायें</a>
					<a href="javascript:void(0)" class="btn btn-danger" style="margin-left:20px;" data-toggle="modal" data-target="#exampleModalCenter">अस्वीकार</a>
				</div>
				@endif
			@endif
		</div>
		

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
	  <form method="post" action="{{ url('rejectApplication') }}" id="myForm"  enctype="multipart/form-data">
		@csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">अस्वीकार आवेदन</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<div class="row">
				<input type="hidden" value="{{$result->id}}" name="application_id">
				<div class="form-group col-md-12">
				  <label for="inputEmail4">आवेदन संख्या  </label> : {{$result->applicationNumber}}
				</div>
				
				<div class="form-group col-md-12">
				  <label for="inputEmail4">आवेदन अस्वीकार करने का कारण  </label>
				  <textarea class="form-control" style="width:470px;height:200px;" name="comments" id="comments"></textarea>
				</div>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary communicationAddress1" data-dismiss="modal">बंद करें</button>
        <button type="submit" class="btn btn-primary communicationAddress2">अस्वीकार करें</button>
        <span class="spinner-border spinner-border-sm loader saveLoader" role="status" aria-hidden="true" style="display:none;"></span>
		<span class="saveCommunicationAddress"></span>
      </div>
    </div>
    </form>
  </div>
</div>
<script>
$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
});


$(document).ready(function() {
 /*----------------Comments form validate Start----------------*/
 $('#myForm').validate({     
	 	rules: {
			    "comments": {
					required: true,
			    },
        },
        submitHandler: function (form) {
		
		$('.communicationAddress1').hide();
		$('.communicationAddress2').hide();
		$('.saveLoader').show();
		$('.saveCommunicationAddress').html('Please Wait, Saving..');
		form.submit();
		},		
   });
 /*----------------Comments form validate End----------------*/
});

</script>
		
</div>
        
        
        <!------Summary Page End---------------->
     
        

</div>

 @endsection 
