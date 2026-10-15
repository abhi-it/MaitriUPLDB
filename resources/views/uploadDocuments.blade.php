@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center fw-bold m-4">
        {{$heading}}
        @if (isset($routeName))
        <a class="btn btn-secondary btn-export float-right" href="{{ route($routeName,[true]) }}">Export</a>
        @endif
    </h3>
    @if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
    <table id="myTable" class="table table-striped  table-responsive table-bordered">
        <thead>
            <tr>
                <th>आवेदन नंबर</th>
                <th>आवेदक का नाम</th>
                <th>अभ्यर्थी का स्वत: मूल्यांकन अंक</th>
                <th>दिनांक</th>
                <th>एक्शन</th>
                <th>स्थिति</th>
            </tr>
        </thead>
        <tbody>
            @if($results->count())
            @foreach($results as $row)
            <tr>
                <td>{{$row->applicationNumber}}</td>
                <td>{{$row->applicant_name}}</td>
                <td><span class="total-users" onClick="viewCalculation({{$row->id}});">{{$row->topper_number}}</span>
                </td>
                <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y')}}</td>
                <td><a href="{{url('editUploadAvedan')}}/{{$row->id}}">अपलोड डॉक्युमेंट्स</a></td>
                <td>
                    @if($row->is_approved==0)
                    <button type="button" class="btn btn-secondary total-users">लंबित</button>
                    @elseif($row->is_approved==1)
                    <button type="button" class="btn btn-success total-users">स्वीकृत</button>
                    @elseif($row->is_approved==3)
                    <button type="button" class="btn btn-info active total-users">प्रतीक्षा सूची</button>
                    @else
                    <button type="button" class="btn btn-danger total-users">अस्वीकार</button>
                    @endif
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection