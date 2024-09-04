@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
<h3 style="margin-top:10px;text-align: center;">{{$heading}} ( कुल मैत्री : {{ $results->total() }} {{$janpad}})</h3>

@if(session()->get('success'))
    <div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		{{ session()->get('success') }}  
	  </div><br />
  @endif
<form method="get" action="{{Request::url()}}">
	@csrf
			<div class="row">
				@if(auth()->user()->user_type=='District Officer')
				<div class="form-group col-md-2">
				  <label for="inputEmail4">मैत्री का नाम</label>
					<input type="text" value="{{@$_GET['maitri_name']}}" class="form-control" name="maitri_name" id="maitri_name" placeholder="मैत्री का नाम">
				</div>
				
				<div class="form-group col-md-2">
				  <label for="inputEmail4">मोबाइल नंबर</label>
					<input type="text" value="{{@$_GET['mobile']}}" class="form-control" name="mobile" id="mobile" placeholder="मोबाइल नंबर">
				</div>
				@else
				
				<div class="form-group col-md-2">
				  <label for="inputEmail4">जनपद</label>
					<select class="form-control" name="janpad" id="janpad">
                        <option value="">जनपद चुनें </option>
                        @foreach($districts as $row)
							<option value="{{$row->id}}" {{ @$_GET['janpad']==$row->id ? 'selected' : '' }}>{{$row->name_hindi}}</option>
							@endforeach
                    </select>
				</div>
				@endif
				<div class="form-group col-md-6" style="margin-top: 29px;width:100px;">
				<button type="submit" class="btn btn-primary" >देखें </button> 
				<a href="{{Request::url()}}" class="btn btn-secondary">रीसेट करें</a>
				@if(auth()->user()->user_type!='District Officer')
					@if($results->count())
					<a class="btn btn-secondary" href="{{ route('exportMaitriDetails') }}" onclick="event.preventDefault(); document.getElementById('submit-form').submit();">डाउनलोड</a>
					@endif
				@endif
				</div>
				
		  </div>
</form>

<form id="submit-form" action="{{ route('exportMaitriDetails') }}" method="POST">
	@csrf
	<input type="hidden" value="{{@$_GET['maitri_name']}}" name="maitri_name">
	<input type="hidden" value="{{@$_GET['mobile']}}" name="mobile">
	<input type="hidden" value="{{@$_GET['janpad']}}" name="district_id">
</form>

<div class="row">
@if($results){{ $results->withQueryString(); }}@endif
</div>

<table class="table table-striped  table-responsive table-bordered">
    <thead>
        <tr>
			<th>तहसील</th>
			<th>विकास खण्ड</th>
			<th>पशुचिकित्सालय का नाम</th>
			<th>ग्राम पंचायत का नाम (जहाँ का निवासी हो)</th>
			<th>कार्यक्षेत्र</th>
			<th>प्राईवेट कृत्रिम गर्भाधान कार्यकर्ता/पशुमित्र/मैत्री का नाम</th>
			<th>पिता का नाम</th>
			<th>पता</th>
			<th>मोबाईल नं.</th>
			<th>किस योजनान्तर्गत प्रशिक्षण प्राप्त किया</th>
			<th>संस्था का नाम जहाँ से प्रशिक्षण प्राप्त किया गया </th>
			<th>प्रशिक्षण अवधि (दिन में)</th>
            <th>दिनांक</th>
            <th>देखें</th>
        </tr>
    </thead>
    <tbody>
		@if($results->count())
		@foreach($results as $row)
        <tr>
            <td>{{$row->tehseel}}</td>
            <td>{{$row->vikas_khand}}</td>
            <td>{{$row->animal_hospitals}}</td>
            <td>{{$row->gram_panchayat}}</td>
            <td>{{$row->maitri_workfield}}</td>
            <td>{{$row->maitri_name}}</td>
            <td>{{$row->father}}</td>
            <td>{{$row->address}}</td>
            <td>{{$row->mobile}}</td>
            <td>{{$row->training_name}}</td>
            <td>{{$row->institute}}</td>
            <td>{{$row->training_period}}</td>
            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y')}}</td>
            <td>
				<a href="{{url('maitri-details')}}/{{$row->id}}" >विवरण देखें</a> | 
				<a href="{{url('maitri-delete')}}/{{$row->id}}" >Delete</a>
			</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="5" style="color:red;">No records..</td>
        </tr>
		@endif
    </tbody>
</table>
<div class="row">
@if($results){{ $results->withQueryString(); }}@endif
</div>
</div>
@endsection 
