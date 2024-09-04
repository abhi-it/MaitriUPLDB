@extends('master')
@section('content')
@php
use App\Models\Districts;
@endphp
<div class="container main-div py-5" style="background-color:white; height: 100%;">
    <!--First row Start -->
	 
 <h3 style="margin-top:10px;text-align: center; font-weight:bold;">राष्ट्रीय गोकुल मिशन अंतर्गत मैत्री प्रशिक्षण हेतु जनपदवार लक्ष्य<br><br>वर्ष : <?php echo date('Y')?>-<?php echo date('Y', strtotime('+1 year'))?></h1>
@if(session()->get('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}  
  </div>
@endif

        <!------Summary Page Start---------------->
        <div class="row ">
				<table class="table table-striped table-responsive table-bordered">
					<thead>
 				<tr>
					<th>क्रं सं</th>
					<th>मण्डल</th>
					<th>जनपद</th>
					<th>सामान्य / अन्य पिछड़ा वर्ग की संख्या</th>
					<th>अनुसूचित जाति की संख्या</th>
					<th>अनुसूचित जनजाति की संख्या</th>
					<th>योग</th>
					</thead>
				</tr>
				<tbody>
				<?php 
				$i=1; 
				$general=0;
				$sc=0;
				$st=0;
				?>
				@foreach($divisions AS $div)
				<?php $district = Districts::where('division_id','=',$div->id)->where('status','=',1)->get();
				
				?>
				@foreach($district AS $row)
				<?php 
				$general+=$row->general_target; 
				$sc+=$row->sc_target;
				$st+=$row->st_target;  
				?>
				<tr>
					<td><?php echo $i++;?></td>
					<td>{{$div->name_hindi}}</td>
					<td>{{$row->name_hindi}}</td>
					<td>{{$row->general_target}}</td>
					<td>{{$row->sc_target}}</td>
					<td>{{$row->st_target}}</td>
					<td>{{$row->general_target + $row->sc_target + $row->st_target}}</td>
				</tr>
				@endforeach
				
				@endforeach
				<tr style="font-weight:bold;">
					<td></td>
					<td></td>
					<td>योग</td>
					<td>{{$general}}</td>
					<td>{{$sc}}</td>
					<td>{{$st}}</td>
					<td>{{$general+$sc+$st}}</td>
				</tr>
				</tbody>
				</table>
			</div>
        <!------Summary Page End---------------->
     
        
		<div><span style="color:red;font-weight:600; font-size:18px;text-align: left;">नोट:- संख्या समय / परिस्थिति अनुसार परिवर्तनीय है</span></div>
</div>



 @endsection 
