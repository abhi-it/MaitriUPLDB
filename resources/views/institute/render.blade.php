<script>
$(document).ready(function () {
	
    $("#ckbCheckAll").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });
    
    
    $('#saveAllocation').submit( function(){
		
		
		if($('#instituteID').val()=='')
		{
			
			alert("Please select Institute!");
			return false;
		}
		
		if($('#district_id').val()=='')
		{
			
			alert("Please select District!");
			return false;
		}
		
		if($('#caste').val()=='')
		{
			
			alert("Please select Category!");
			return false;
		}
		
		
		if (!$('#saveAllocation .checkBoxClass').is(':checked')){
			
			alert("Please select at least one candidate!");
			return false;
		}
		
	    $(".btn").attr("disabled", true);
	    $(".btn").html("Please wait..");
	});
});
</script>
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
<h3 class="text-center fw-bold m-4">चयनित अभ्यर्थियों की सूची</h3>
<table class="table">
    <thead>
        <tr>
            <th><input type="checkbox" id="ckbCheckAll"> Select</th>
            <th>आवेदन  नंबर</th>
            <th>आवेदक का नाम</th>
            <th>अर्जित अंक</th>
            <th>दिनांक</th>
            <th>देखें</th>
            <th>स्टेटस</th>
        </tr>
    </thead>
    <tbody>
		@if($results->count())
		@foreach($results as $row)
        <tr>
			<td><input type="checkbox" {{ in_array($row->id, $allocateData) ? 'checked' : '' }} value="{{$row->id}}" name="application_id[]" id="application_id" class="checkBoxClass"></td>
            <td>{{$row->applicationNumber}}</td>
            <td>{{$row->applicant_name}}</td>
            <td>{{$row->topper_number}}</td>
            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y')}}</td>
            <td>
				<a href="{{url('view-Avedan-details')}}/{{$row->id}}" >विवरण देखें</a>
				@if(auth()->user()->user_type=='Admin' AND (Request::segment(1)=='avedan' OR Request::segment(1)=='total-avedan'))
				 | <a href="{{url('edit-avedan')}}/{{$row->id}}" >एडिट</a>
				@endif
			</td>
            <td>
			@if($row->is_approved==0)
				<a href="javascript:void(0)" class="btn btn-secondary">लंबित</a>
			@elseif($row->is_approved==1)
				<a href="javascript:void(0)" class="btn btn-success">स्वीकृत</a>
			@elseif($row->is_approved==3)
				<a href="javascript:void(0)" class="btn btn-info active">प्रतीक्षा सूची</a>
			@else
				<a href="javascript:void(0)" class="btn btn-danger">अस्वीकार</a>
			@endif
			</td>
        </tr>
        @endforeach
        @else
        <tr><td style="color:red;">कोई आवेदन नहीं है</td></tr>
		@endif
    </tbody>
</table>
<div class="form-group col-md-12">@if($results->count())
                <button type="submit" class="btn btn-primary submit">Submit</button>
				<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;" id="loader"> </span>
            @endif
        </div>
</div> 

