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
    
<h4 class="text-center fw-bold m-4">राजकीय चिकित्साधिकारी द्वारा प्रदत्त स्वास्थ्य प्रमाण
 <div class=" pull-right">
			<a href="{{ url('avedan') }}" class="btn btn-info">Back</a>
		</div>
 </h4>
@if(session()->get('success'))
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
	<form method="post" action="{{ url('avedanUpdatedDocuments') }}/{{$result->id}}" id="avedanUpdatedDocuments"  enctype="multipart/form-data">
	@csrf
        
        <div class="tab1">
			
				<div class="row" style="padding-top:30px;">
				<div class="form-group col-md-6">
				  <label for="inputEmail4">राजकीय चिकित्साधिकारी द्वारा प्रदत्त स्वास्थ्य प्रमाण - पत्र अपलोड करें</label> <!--span class="text-danger">*</span> <small style="color:red;">Note: JPG, JPEG, PNG files only (Max. 100 KB)</small-->
				  <input type="file" class="form-control" name="health_certificate" id="health_certificate">
				  @if($result->health_certificate!='')
					<a href="{{ asset('')}}upload_documents/{{$result->health_certificate}}" target="_blank">View</a>
				  @else
					N/A
				  @endif
				</div>
		</div>
		  
        </div>
		@php
			$year = date('Y');
		@endphp
        <div style="overflow:auto;margin-bottom:20px;">
            <div style="margin-top: 5px;" id="finalSubmit">
                <button type="submit" class="btn btn-primary submit">चयनित एवं अपलोड</button> 
                <a href="javascript:void(0)" class="btn btn-danger" style="margin-left:20px;" data-toggle="modal" data-target="#exampleModalCenter">अचयनित/अस्वीकार</a>
                <a href="{{ url('waiting-list') }}/{{ $year }}/1" class="btn btn-primary" style="margin-left:20px;">प्रतीक्षा सूची</a>
            </div>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;" id="loader"> </span>
            
        </div>
    
    </form>

<!--First row Closed-->
</div>
<script>

$(document).ready(function(){
	
	$('#applicant_photo').change( function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		document.getElementById('applicant_photo_priview').src = window.URL.createObjectURL(this.files[0]);
		$("#applicant_photo_url").html("<a href='"+tmppath+"' target='_blank'>View</a>");
	});
	
	$('#signature').change( function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		document.getElementById('signature_priview').src = window.URL.createObjectURL(this.files[0]);
		$("#signature_url").html("<a href='"+tmppath+"' target='_blank'>View</a>");
	});
	
	$('#high_marksheet').change( function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		document.getElementById('high_marksheet_priview').src = window.URL.createObjectURL(this.files[0]);
		$("#high_marksheet_url").html("<a href='"+tmppath+"' target='_blank'>View</a>");
	});
	
	$('#high_certificate').change( function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		document.getElementById('high_certificate_priview').src = window.URL.createObjectURL(this.files[0]);
		$("#high_certificate_url").html("<a href='"+tmppath+"' target='_blank'>View</a>");
	});
	
	$('#inter_marksheet').change( function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		document.getElementById('inter_marksheet_priview').src = window.URL.createObjectURL(this.files[0]);
		$("#inter_marksheet_url").html("<a href='"+tmppath+"' target='_blank'>View</a>");
	});
	
	$('#inter_certificate').change( function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		document.getElementById('inter_certificate_priview').src = window.URL.createObjectURL(this.files[0]);
		$("#inter_certificate_url").html("<a href='"+tmppath+"' target='_blank'>View</a>");
	});
	
	$('#graduation_marksheet').change( function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		document.getElementById('graduation_marksheet_priview').src = window.URL.createObjectURL(this.files[0]);
		$("#graduation_marksheet_url").html("<a href='"+tmppath+"' target='_blank'>View</a>");
	});
	
	$('#graduation_certificate').change( function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		document.getElementById('graduation_certificate_priview').src = window.URL.createObjectURL(this.files[0]);
		$("#graduation_certificate_url").html("<a href='"+tmppath+"' target='_blank'>View</a>");
	});
	
	$('#postgraduation_marksheet').change( function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		document.getElementById('postgraduation_marksheet_priview').src = window.URL.createObjectURL(this.files[0]);
		$("#postgraduation_marksheet_url").html("<a href='"+tmppath+"' target='_blank'>View</a>");
	});
	
	$('#postgraduation_certificate').change( function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		document.getElementById('postgraduation_certificate_priview').src = window.URL.createObjectURL(this.files[0]);
		$("#postgraduation_certificate_url").html("<a href='"+tmppath+"' target='_blank'>View</a>");
	});
	
	$('#training_certificate').change( function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		document.getElementById('training_certificate_priview').src = window.URL.createObjectURL(this.files[0]);
		$("#training_certificate_url").html("<a href='"+tmppath+"' target='_blank'>View</a>");
	});
	
	$('#id_upload').change( function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		document.getElementById('id_upload_priview').src = window.URL.createObjectURL(this.files[0]);
		$("#id_upload_url").html("<a href='"+tmppath+"' target='_blank'>View</a>");
	});
	
	$('#caste_certificate').change( function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		document.getElementById('caste_certificate_priview').src = window.URL.createObjectURL(this.files[0]);
		$("#caste_certificate_url").html("<a href='"+tmppath+"' target='_blank'>View</a>");
	});
	
	$('#health_certificate').change( function(event) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		document.getElementById('health_certificate_priview').src = window.URL.createObjectURL(this.files[0]);
		$("#health_certificate_url").html("<a href='"+tmppath+"' target='_blank'>View</a>");
	});
	
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
        
        
        
        
        
        $("#training_adopted").change(function () {
			
			if($('#training_adopted').val()=='नहीं')
			{
				
				$('.showHide').hide();
				$('.showHideSummary').hide();
				$('#yojna_name_for_training').val('');
				$('#AIkit').prop('selectedIndex',0);
				$('#training_certificate_period_in_month').prop('selectedIndex',0);
				$('#training_certificate_period_in_days').prop('selectedIndex',0);
				$('#training_certificate').val(null);
				
			}else{
				
				$('.showHide').show();
				$('.showHideSummary').show();
			}
        });
        
        
        
    });
	
	
$(function(){
	
	
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
	
    $("button#nextMe").click(function(){

        $("input").each(function() {
			var name = $(this).attr("name");
			var id = $(this).attr("id");
			var val = $(this).val();

			if ((id) && id !== "" && val!='') {
				//console.log('id=' + id + '1' + ' and value=' + val);
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


<script>
	
$(document).ready(function() {
jQuery.extend(jQuery.validator.messages, {
    required: "Required.",
});

        $.validator.addMethod('date', function(value, element, param) {
            return (value != 0) && (value <= 31) && (value == parseInt(value, 10));
        }, 'Please enter a valid date!');
        $.validator.addMethod('month', function(value, element, param) {
            return (value != 0) && (value <= 12) && (value == parseInt(value, 10));
        }, 'Please enter a valid month!');
        $.validator.addMethod('year', function(value, element, param) {
            return (value != 0) && (value >= 1900) && (value == parseInt(value, 10));
        }, 'Please enter a valid year not less than 1900!');
        $.validator.addMethod('username', function(value, element, param) {
            var nameRegex = /^[a-zA-Z0-9]+$/;
            return value.match(nameRegex);
        }, 'Only a-z, A-Z, 0-9 characters are allowed');
        
        $.validator.addMethod("checkFileSize", function(value, element, param) {
			
		if(value!=''){

		   FileSize = element.files[0].size;
		   
				if(FileSize>param)
				 return false;
				 return true;
		}else{
			return true;
		}
	}, "File size must be less than or equal to 100 KB.");
	
	$.validator.addMethod("checkFileSize20KB", function(value, element, param) {
			
		if(value!=''){
		   FileSize = element.files[0].size;
		   
				if(FileSize>param)
				 return false;
				 return true;
		}else{
			return true;
		}
	}, "File size must be less than or equal to 20 KB.");
	
	$.validator.addMethod("uploadTrainingCertificate", function(value, element) {
    	
		var month 	= $("#training_certificate_period_in_month")[0].selectedIndex;
		var day 	= $("#training_certificate_period_in_days")[0].selectedIndex;
		var name 	= $('#training_certificate').val().split('\\').pop();
		training_certificate_name = name.split('.')[0];
		
		
		if(training_certificate_name=='' && (month>=1 || day>=1))
		{
			return false;
		}
		
        return true;
      
    }, "Please upload training certificate");
    
    $.validator.addMethod("selectMonthORday", function(value, element) {
    	
		var month 	= $("#training_certificate_period_in_month")[0].selectedIndex;
		var day 	= $("#training_certificate_period_in_days")[0].selectedIndex;
		var name 	= $('#training_certificate').val().split('\\').pop();
		training_certificate_name = name.split('.')[0];

		if(training_certificate_name!='' && (month<1 && day<1))
		{
			return false;
		}
		
        return true;
      
    }, "Please select month or day");
    
    $.validator.addMethod("verifyHighSchoolMarks", function(value, element) {
    	
		var high_marks 	= $("#high_marks").val();
		var high_total_marks 	= $("#high_total_marks").val();
		
		if(high_marks!='' && high_total_marks!='')
		{
		if(high_marks>high_total_marks)
		{
			return false;
		}
	}
		
        return true;
      
    }, "Enter valid marks");
    
    
    $.validator.addMethod("verifyInterMarks", function(value, element) {
    	
		var inter_marks 	= $("#inter_marks").val();
		var inter_total_marks 	= $("#inter_total_marks").val();
		
		if(inter_marks!='' && inter_total_marks!='')
		{
		if(inter_marks>inter_total_marks)
		{
			return false;
		}
	}
		
        return true;
      
    }, "Enter valid marks");
    
    
    $.validator.addMethod("checkCategory", function(value, element) {
    	
		var category = $("#category")[0].selectedIndex;
		var day 	= $("#training_certificate_period_in_days")[0].selectedIndex;
		var name 	= $('#caste_certificate').val().split('\\').pop();
		caste_certificate_name = name.split('.')[0];

		if(caste_certificate_name=='' && (category==3 || category==4))
		{
			
			return false;
			
		}else{
			
			return true;
			
		}
      
    }, "Please upload caste certificate");
    
    
    
    $.validator.addMethod("checkDOB", function (value, element) {
         
	var userinput = document.getElementById("dob").value;
    var dob = new Date(userinput);
    var month_diff = new Date('{{@$ageCalcultedFrom}}') - dob.getTime();
    var age_dt = new Date(month_diff); 
    var year = age_dt.getUTCFullYear();
    var age = Math.abs(year - 1970);

        if(age < 18) {  
            return false;  
        }else if(age > 40) {  
            return false;  
        }   
        return true;  
    }, "You are not eligible! Age should be between 18 to 40 years");
    
 /*----------------Comments form validate Start----------------*/
 $('#avedanUpdatedDocuments').validate({     
	 	
	 	rules: {
				
				
				applicant_name: "required",
				yojna_name_for_training: "required",
				AIkit: "required",
				coption: "required",
				tc: "required",
                category: "required",
                fname: "required",
                mother: "required",
                mobile: {
                    required:true,
                    number:true,
                    minlength:10,
                    maxlength:10,
                    
                },
				address_type: "required",
				post_office: "required",
				pincode: "required",
				gender: "required",
                permanent_address: "required",
                gram_panchayat_name: "required",
                vikas_khand: "required",
                janpad: "required",
                letter_address: "required",
                high_board_name: "required",
                high_passing_year: "required",
                "high_marks": {
					required:true,
					verifyHighSchoolMarks: true,
			    },
                high_total_marks: "required",
                high_percentage: "required",
                "permanent_address_proof": {
					extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
					checkFileSize: 100000,
			    },
                "applicant_photo": {
					extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
					checkFileSize20KB: 20000,
			    },
                "signature": {
					extension: "pdf|PDF|png|PNG|jpg|JPG|jpeg|JPEG",
					checkFileSize20KB: 20000,
			    },
			    "high_marksheet": {
					extension: "png|PNG|jpg|JPG|jpeg|JPEG",
					checkFileSize: 100000,
			    },
			    
			    "inter_marksheet": {
					extension: "png|PNG|jpg|JPG|jpeg|JPEG",
					checkFileSize: 100000,
			    },
			    
			    "graduation_marksheet": {
					extension: "png|PNG|jpg|JPG|jpeg|JPEG",
					checkFileSize: 100000,
			    },
			    "graduation_certificate": {
					extension: "png|PNG|jpg|JPG|jpeg|JPEG",
					checkFileSize: 100000,
			    },
			    
			    "postgraduation_marksheet": {
					extension: "png|PNG|jpg|JPG|jpeg|JPEG",
					checkFileSize: 100000,
			    },
			    "postgraduation_certificate": {
					extension: "png|PNG|jpg|JPG|jpeg|JPEG",
					checkFileSize: 100000,
			    },
			    
                "training_certificate": {
					extension: "png|PNG|jpg|JPG|jpeg|JPEG",
					checkFileSize: 100000,
			    },
                "id_upload": {
					extension: "png|PNG|jpg|JPG|jpeg|JPEG",
					checkFileSize: 100000,
			    },
                "caste_certificate": {
					checkCategory: true,
					extension: "png|PNG|jpg|JPG|jpeg|JPEG",
					checkFileSize: 100000,
			    },
                nationality: "required",
            },
  
	 	
        submitHandler: function (form) {
		
		$(".submit").attr("disabled", true);
	    $(".submit").html("Please wait..");
		form.submit();
		},		
   });
 /*----------------Comments form validate End----------------*/
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
</script>
 @endsection 
