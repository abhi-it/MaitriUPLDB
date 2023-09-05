@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
<h3 style="margin-top:10px;text-align: center;">संस्थान आवंटन
<!--div class=" pull-right">
			<a href="javascript:history.back();" class="btn btn-info">Back</a>
		</div-->
</h3>



@if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
			<form method="post" action="{{ url('saveAllocation') }}" id="saveAllocation"  enctype="multipart/form-data">
	@csrf
			<div class="row">
				
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">संस्थान का नाम </label>
					<select class="form-control" name="institute_id" id="instituteID">
						<option value="">सेलेक्ट संस्थान</option>
						@foreach($results as $row)
							<option value="{{$row->id}}">{{$row->name}}</option>
						@endforeach
					</select>
				</div>
				
				<div class="form-group col-md-4">
				  <label for="inputEmail4">सेलेक्ट जनपद </label>
					<select class="form-control" name="district_id" id="district_id">
						<option value="">सेलेक्ट जनपद</option>
						@foreach($districts as $row)
							<option value="{{$row->id}}">{{$row->name_hindi}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col-md-4">
				<label for="inputEmail4">कैटेगरी</label>
				  <select class="form-control" name="category" id="caste">
					  <option value="">सेलेक्ट</option>
					  <option value="1">सामान्य / अन्य  पिछड़ा वर्ग</option>
					  <option value="2">अनुसूचित जाति</option>
					  <option value="3">अनुसूचित जनजाति</option>
				  </select>
				</div>
				
				
				<div class="form-group col-md-12" id="responseID"></div>
				
		  </div>
		</form>

</div>
@endsection 
