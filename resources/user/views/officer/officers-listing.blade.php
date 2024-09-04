@extends('master')
@section('content')
    <div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
        <h3 class="mt-5 text-center" style="margin-top:10px;text-align: center; font-weight:600;">
            
        <span data-hi="जनपद कुल चयनित आवेदक का विवरण एवं सुची" data-en="Details and list of total selected applicants from the district"></span>
        </h3>
        <form  action="{{ Request::url() }}" method="get">
        <div class="row">
            
                <div class="col-md-4 mt-4 mb-4">
                    <select name="id" id="id" class="form-control">
                        <option>-select one-</option>
                        @foreach($dist as $val)
                        @if($val!='' ||$val != null)
                        <option value="{{$val['mandal_name']}}">{{$val['mandal_name']}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1 mt-4 mb-4">
                   <input type="submit" class="btn btn-primary" value="submit">
                </div>
                <div class="col-md-1 mt-4 mb-4">
                    <a href="{{ Request::url() }}" class="btn btn-danger">रीसेट करें</a>
                </div>
        </div>
        </form>
        <table id="myTable202" class="table table-striped table-responsive table-bordered">
            <thead>
                <tr>
                    <th>Mandal </th>
                    <th>Janpad </th>
                    <th>Name </th>
                    <th>Email</th>
                    <th> Mobile No</th>
                    <th>Designation </th>
                    <th>Animal Care Center</th>
                </tr>
            </thead>
            <tbody >
            @if(count($data)>0)
            @foreach($data as $val)
            <tr>
                <td>{{$val->mandal_name}}</td>
                <td>{{$val->janpad_name}}</td>
                <td>{{$val->officer_name}}</td>
                <td>{{($val->email)?$val->email:'-'}}</td>
                <td>{{($val->mobile_no)?$val->mobile_no:'-'}}</td>
                <td>{{($val->designation)?$val->designation:'-'}}</td> 
                <td>{{$val->animal_care_center}} </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6" style="color:red;">No record found..</td>
            </tr>
            @endif
            </tbody>
        </table>
        <div class="row">
        {{ $items->appends(request()->except('page'))->links() }}
        </div>
    </div>
    
@endsection

