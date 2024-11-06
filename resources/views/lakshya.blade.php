@extends('master')
@section('content')
@php
use App\Models\Districts;
@endphp
<div class="container main-div py-5" style="background-color:white; height: 100%;">
    <!--First row Start -->
	 
 <h3 style="margin-top:10px;text-align: center; font-weight:bold;">
	<span data-hi="राष्ट्रीय गोकुल मिशन अंतर्गत मैत्री प्रशिक्षण हेतु जनपदवार लक्ष्य" data-en="District wise target for maitri training under National Gokul Mission"></span>
 	<br><br> <span data-hi="वर्ष" data-en="Year"></span>
  : <?php echo date('Y')?>-<?php echo date('Y', strtotime('+1 year'))?></h1>
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
					<th> <span data-hi=" क्रं सं" data-en="S. No."></span></th>
					<th> <span data-hi="मण्डल" data-en="Mandal"></span> </th>
					<th> <span data-hi="जनपद" data-en="janpad"></span> </th>
					<th> <span data-hi="सामान्य  वर्ग की संख्या" data-en="General No."></span> </th>
					<th> <span data-hi="अन्य पिछड़ा वर्ग की संख्या" data-en="OBC No."></span> </th>
					<th> <span data-hi="अनुसूचित जाति की संख्या" data-en="Number of scheduled castes"></span></th>
					<th> <span data-hi=" अनुसूचित जनजाति की संख्या" data-en="Number of Scheduled Tribes"></span></th>
					<th> <span data-hi="योग" data-en="Total"></span> </th>
					</thead>
				</tr>
				<tbody>
				<?php 
				$i=1; 
				$general=0;
				$sc=0;
				$st=0;
				$obc=0;
				?>
				@foreach($divisions AS $div)
				<?php $district = Districts::where('division_id','=',$div->id)->where('status','=',1)->get();
				
				?>
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
     
        
		<div><span style="color:red;font-weight:600; font-size:18px;text-align: left;">
			<span data-hi="नोट:- संख्या समय / परिस्थिति अनुसार परिवर्तनीय है" data-en="Note:- Number is changeable according to time / situation"></span>	
		</span></div>
</div>



 @endsection 
