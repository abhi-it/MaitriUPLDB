@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
<h3 class="text-center fw-bold m-4">रिपोर्ट </h3>
<div class="row" style="margin: 10px;">
    <a href="{{url('reportDownloadToExl')}}" class="btn btn-primary">Download Excel</a>
</div>
<table class="table" border="1">
        <thead>
          <tr class="row0" style="background-color: #eca946;">
            <th  colspan="2" rowspan="2" style="vertical-align:top;">जनपद </th>
            <th  colspan="5" style="text-align: center;">स्वीकार आवेदन</th>
            <th  colspan="5" style="text-align: center;">अस्वीकार आवेदन</th>
            <th  colspan="5" style="text-align: center;">चयनित आवेदन</th>
            <th  colspan="5" style="text-align: center;">प्रतीक्षा लिस्ट</th>
          </tr>
          <tr class="row1" style="background-color: #eca946;">
            <th >सामान्य</th>
            <th >अन्य पिछड़ा वर्ग</th>
            <th >अनुसूचित जाति</th>
            <th >अनुसूचित जनजाति</th>
            <th >योग</th>
            <th >सामान्य</th>
            <th >अन्य पिछड़ा वर्ग</th>
            <th >अनुसूचित जाति</th>
            <th >अनुसूचित जनजाति</th>
            <th >योग</th>
            <th >सामान्य</th>
            <th >अन्य पिछड़ा वर्ग</th>
            <th >अनुसूचित जाति</th>
            <th >अनुसूचित जनजाति</th>
            <th >योग</th>
            <th >सामान्य</th>
            <th >अन्य पिछड़ा वर्ग</th>
            <th >अनुसूचित जाति</th>
            <th >अनुसूचित जनजाति</th>
            <th >योग</th>
          </tr>
      </thead>
      <tbody>
          @php $i=1; @endphp
@foreach($districts as $d)
@php

$approved = \App\Models\Avedan::select('category', DB::raw('count(*) as total'))
                 ->where('district_id','=',$d->id)
                 ->where('is_approved','=',1)
                 ->groupBy('category')
                 ->orderBy('category', 'DESC')
                 ->get();
$totalGeneralApproved = 0;
$totalOBCApproved = 0;
$totalSCApproved = 0;
$totalSTApproved = 0;
$totalApproved = 0;
        foreach($approved as $row)
        {

            if($row['category']=='जनरल')
            {
                $totalGeneralApproved = $row['total'];
            }

            if($row['category']=='ओ बी सी')
            {
                $totalOBCApproved = $row['total'];
            }

            if($row['category']=='एस सी')
            {
                $totalSCApproved = $row['total'];
            }

            if($row['category']=='एस टी')
            {
                $totalSTApproved = $row['total'];
            }

        }
        $totalApproved = $totalGeneralApproved+$totalOBCApproved+$totalSCApproved+$totalSTApproved;



$rejected = \App\Models\Avedan::select('category', DB::raw('count(*) as total'))
                 ->where('district_id','=',$d->id)
                 ->where('is_approved','=',2)
                 ->groupBy('category')
                 ->orderBy('category', 'DESC')
                 ->get();
$totalGeneralRejected = 0;
$totalOBCRejected = 0;
$totalSCRejected = 0;
$totalSTRejected = 0;
$totalRejected = 0;
        foreach($rejected as $row)
        {

            if($row['category']=='जनरल')
            {
                $totalGeneralRejected = $row['total'];
            }

            if($row['category']=='ओ बी सी')
            {
                $totalOBCRejected = $row['total'];
            }

            if($row['category']=='एस सी')
            {
                $totalSCRejected = $row['total'];
            }

            if($row['category']=='एस टी')
            {
                $totalSTRejected = $row['total'];
            }

        }
        $totalRejected = $totalGeneralRejected+$totalOBCRejected+$totalSCRejected+$totalSTRejected;



        $selected = \App\Models\Avedan::select('category', DB::raw('count(*) as total'))
                 ->where('district_id','=',$d->id)
                 ->where('is_approved','=',4)
                 ->groupBy('category')
                 ->orderBy('category', 'DESC')
                 ->get();
$totalGeneralSelected = 0;
$totalOBCSelected = 0;
$totalSCSelected = 0;
$totalSTSelected = 0;
$totalSelected = 0;
        foreach($selected as $row)
        {

            if($row['category']=='जनरल')
            {
                $totalGeneralSelected = $row['total'];
            }

            if($row['category']=='ओ बी सी')
            {
                $totalOBCSelected = $row['total'];
            }

            if($row['category']=='एस सी')
            {
                $totalSCSelected = $row['total'];
            }

            if($row['category']=='एस टी')
            {
                $totalSTSelected = $row['total'];
            }

        }
        $totalSelected = $totalGeneralSelected+$totalOBCSelected+$totalSCSelected+$totalSTSelected;




        $waiting = \App\Models\Avedan::select('category', DB::raw('count(*) as total'))
                 ->where('district_id','=',$d->id)
                 ->where('is_approved','=',3)
                 ->groupBy('category')
                 ->orderBy('category', 'DESC')
                 ->get();
$totalGeneralWaiting = 0;
$totalOBCWaiting = 0;
$totalSCWaiting = 0;
$totalSTWaiting = 0;
$totalWaiting = 0;
        foreach($waiting as $row)
        {

            if($row['category']=='जनरल')
            {
                $totalGeneralWaiting = $row['total'];
            }

            if($row['category']=='ओ बी सी')
            {
                $totalOBCWaiting = $row['total'];
            }

            if($row['category']=='एस सी')
            {
                $totalSCWaiting = $row['total'];
            }

            if($row['category']=='एस टी')
            {
                $totalSTWaiting = $row['total'];
            }

        }
        $totalWaiting = $totalGeneralWaiting+$totalOBCWaiting+$totalSCWaiting+$totalSTWaiting;

        $i++;
@endphp
          <tr class="row2" style="background-color: {{($i%2==0)?'#fbf8f8':'#fff'}};">
            <td colspan="2">{{$d->name_hindi}}</td>
            <td>{{$totalGeneralApproved}}</td>
            <td>{{$totalOBCApproved}}</td>
            <td>{{$totalSCApproved}}</td>
            <td>{{$totalSTApproved}}</td>
            <td>{{$totalApproved}}</td>
            <td>{{$totalGeneralRejected}}</td>
            <td>{{$totalOBCRejected}}</td>
            <td>{{$totalSCRejected}}</td>
            <td>{{$totalSTRejected}}</td>
            <td>{{$totalRejected}}</td>
            <td>{{$totalGeneralSelected}}</td>
            <td>{{$totalOBCSelected}}</td>
            <td>{{$totalSCSelected}}</td>
            <td>{{$totalSTSelected}}</td>
            <td>{{$totalSelected}}</td>
            <td>{{$totalGeneralWaiting}}</td>
            <td>{{$totalOBCWaiting}}</td>
            <td>{{$totalSCWaiting}}</td>
            <td>{{$totalSTWaiting}}</td>
            <td>{{$totalWaiting}}</td>
          </tr>
@endforeach
        </tbody>
    </table>
    <div class="row" style="margin: 10px;">
        <a href="{{url('reportDownloadToExl')}}" class="btn btn-primary">Download Excel</a>
    </div>
</div>
@endsection 
