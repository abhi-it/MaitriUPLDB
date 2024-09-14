@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
<h3 class="text-center fw-bold m-4">न्यू रिपोर्ट मण्डलवार </h3>
<div class="row" style="margin: 10px;">
    <a href="{{url('newReportDivisionWiseDownloadToExl')}}" class="btn btn-primary">Download Excel</a>
</div>
<table class="table" border="1">
        <thead>
          <tr class="row1" style="background-color: #eca946;">
            <th >S No.</th>
            <th >District Name</th>
            <th >Total</th>
            <th >Pending</th>
            <th >Accepted</th>
            <th >Rejected</th>
            <th >Approved</th>
            <th >Waiting</th>
          </tr>
      </thead>
      <tbody>
@php $i=1; 

$total_net = 0;
$pending_total = 0;
$accepted_total = 0;
$rejected_total = 0;
$waiting_total = 0;
$approved_total = 0;

@endphp
@foreach($arrayJanpad as $dis)
    @php $district = $dis['district'];

    $isRepeat = true;

    @endphp



    @foreach($district as $d)

@php

$result = \App\Models\Avedan::select('is_approved', DB::raw('count(*) as total'))
                 ->where('district_id','=',$d['id'])
                 ->groupBy('is_approved')
                 ->get();
$total = \App\Models\Avedan::where ('district_id', '=', $d['id'])->count();

$pending = 0;
$accepted = 0;
$rejected = 0;
$waiting = 0;
$approved = 0;

        foreach($result as $row)
        {

            if($row['is_approved']==0)
            {
                $pending = $row['total'];
            }

            if($row['is_approved']==1)
            {
                $accepted = $row['total'];
            }

            if($row['is_approved']==2)
            {
                $rejected = $row['total'];
            }

            if($row['is_approved']==3)
            {
                $waiting = $row['total'];
            }

            if($row['is_approved']==4)
            {
                $approved = $row['total'];
            }

        }

$total_net += $total;
$pending_total += $pending;
$accepted_total += $accepted;
$rejected_total += $rejected;
$waiting_total += $waiting;
$approved_total += $approved;

@endphp

          <tr class="row2" style="background-color: {{($i%2==0)?'#fbf8f8':'#fff'}};">
            <td>{{$i++}}.</td>
            <td >{{$d['name_hindi']}}</td>
            <td >{{$total}}</td>
            <td >{{$pending}}</td>
            <td >{{$accepted}}</td>
            <td >{{$rejected}}</td>
            <td >{{$approved}}</td>
            <td >{{$waiting}}</td>
          </tr>
@endforeach
@endforeach
<tr class="row2" style="background-color: #c5e4c5">
    <td></td>
    <td >Total</td>
    <td >{{$total_net}}</td>
    <td >{{$pending_total}}</td>
    <td >{{$accepted_total}}</td>
    <td >{{$rejected_total}}</td>
    <td >{{$approved_total}}</td>
    <td >{{$waiting_total}}</td>
</tr>
</tbody>
</table>
    <div class="row" style="margin: 10px;">
        <a href="{{url('newReportDivisionWiseDownloadToExl')}}" class="btn btn-primary">Download Excel</a>
    </div>
</div>
@endsection 
