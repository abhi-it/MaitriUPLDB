@extends('master')
@section('content')
@php
use App\Models\Districts;
@endphp
<div class="container main-div py-5" style="background-color:white; height: 100%;">

 <h4 style="margin-top:10px;text-align: center; font-weight:bold;">
	<span data-hi="जिला अनुसार लक्ष्य" data-en="Districtwise Target"></span>
 	<br><br> <span>Year - {{ $year }} </span></h4>

	@if(Auth::user() && Auth::user()->role == 'Superadmin')
	<div class="row mt-3 mb-2">
		<div class="col-md-12 text-end">
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
				Upload CSV/Excel
			</button>
		</div>
	</div>

	<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="importModalLabel">Import Data</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<div class="modal-body">
					<form action="{{ route('districts.import') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="form-group mb-3">
							<label for="file">Choose File</label>
							<input type="file" name="file" class="form-control" required>
						</div>
						<button type="submit" class="btn btn-primary">Import</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	@endif


@if(session()->get('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}  
  </div>
@endif

<!------Summary Page Start---------------->
<div class="row">
		<table class="table table-striped  table-responsive table-bordered">
			<thead>
				<tr>
				<th rowspan="2"><span data-hi=" क्रं सं" data-en="S. No."></span></th>
				<th rowspan="2"><span data-hi="मण्डल" data-en="Mandal"></span></th>
				<th rowspan="2"><span data-hi="जनपद" data-en="Janpad"></span></th>
				<th colspan="2"><span data-hi="सामान्य घटक" data-en="General Component"></span></th>
				<th><span data-hi="अनुसूचित जाति घटक" data-en="SCSP Component"></span></th>
				<th><span data-hi="अनुसूचित जनजाति घटक" data-en="TSP Component"></span></th>
				<th rowspan="2"><span data-hi="योग" data-en="Total"></span></th>
				</tr>
				<tr>
				<th><span data-hi="सामान्य  वर्ग की संख्या" data-en="General"></span></th>
				<th><span data-hi="अन्य पिछड़ा वर्ग की संख्या" data-en="OBC"></span></th>
				<th><span data-hi="अनुसूचित जाति की संख्या" data-en="Scheduled Caste Category"></span></th>
				<th><span data-hi="अनुसूचित जनजाति की संख्या" data-en="Scheduled Tribe Category"></span></th>

				</tr>
			</thead>
		<tbody>
		<?php 
		$i=1; 
		$general=0;
		$sc=0;
		$st=0;
		$obc=0;
		?>
		@foreach($divisions AS $div)
			<?php $district = Districts::where('division_id','=', $div->id)->where('status','=',1)->where('year','=', $year)->get(); ?>
			@foreach($district AS $row)
			<?php 
				$general+=$row->general_target; 
				$obc+=$row->obc_target; 
				$sc+=$row->sc_target;
				$st+=$row->st_target;  
			?>
			<tr>
				<td><?php echo $i++;?></td>
				<td>{{$div->name_hindi}}</td>
				<td>{{$row->name_hindi}}</td>
				<td>*{{$row->general_target}}</td>
				<td>*{{$row->obc_target}}</td>
				<td>*{{$row->sc_target}}</td>
				<td>*{{$row->st_target}}</td>
				<td>* - {{$row->general_target + $row->obc_target + $row->sc_target + $row->st_target}}</td>
			</tr>
			@endforeach
		
		@endforeach
		<tr style="font-weight:bold;">
			<td></td>
			<td></td>
			<td> <span data-hi="योग" data-en="Total"></span> </td>
			<td>{{$general}}</td>
			<td>{{$obc}}</td>
			<td>{{$sc}}</td>
			<td>{{$st}}</td>
			<td>{{$general+$obc+$sc+$st}}</td>
		</tr>
		</tbody>
		</table>
</div>
<!------Summary Page End---------------->

{{--<div class="row mt-5">
    @foreach($years as $yr)
        @if($yr !== $year) 
            <div class="col-sm-4 mt-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Year {{ $yr }}</h5>
                        <a href="{{ route('lakshya', ['year' => $yr]) }}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>--}}
        
		<div><span style="color:red;font-weight:600; font-size:18px;text-align: left;">
			<span data-hi="नोट:- संख्या समय / परिस्थिति अनुसार परिवर्तनीय है" data-en="Note:- Number is changeable according to time / situation"></span>	
		</span></div>
</div>



 @endsection 
