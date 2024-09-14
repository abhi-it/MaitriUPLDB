@extends('master')
@section('content')
    <div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center fw-bold m-4">मैत्री सूची</h3>
        <div class="container text-center">
          
                <form  action="{{ Request::url() }}" method="get" class="form-comman">
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
                    <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                    <div class="col-md-1 mt-4 mb-4">
                        <a href="{{ Request::url() }}" class="btn btn-danger text-white">रीसेट करें</a>
                    </div>
                    </div>    
                </form>
            
            <div class="row">
            <form method="get" action="{{ route('exportselectedmaitries') }}"> 
                    <div class="col-md-1 mb-4">
                        <input type="hidden" id="dis_id" name="id">
                        <button class="btn btn-primary" type="submit" id="maitriExport" >Export</button>
                    </div>
                </form>
            </div>
        </div>
            <table id="myTable202" class="table table-striped  table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>Mandal </th>
                        <th>Janpad </th>
                        <th>Name </th>
                        <th> Mobile No</th>
                        <th>Address</th>
                        <th>Adhar Card </th>
                        <th>Father's Name</th>
                        <th>Certificate No</th>
                    </tr>
                </thead>
                <tbody >
                @if(count($data)>0)
                @foreach($data as $val)
                <tr>
                    <td>{{$val->mandal_name}}</td>
                    <td>{{$val->janpad_name}}</td>
                    <td>{{$val->maitri_name}}</td>
                    <td>{{$val->maitri_mobile_no}}</td>
                    <td>{{$val->gram_panchayat}}  {{$val->post_office}}  {{$val->block}} {{$val->tehsil}}</td>
                    <td>{{$val->adhaar_card}}</td> 
                    <td> {{$val->father_name}} </td>
                    <td>{{$val->certificate_no}}</td>
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
<script>
    $('#id').change(function() {
        $('#dis_id').val();
        var val = $("#id option:selected").text();
        console.log('val',val)
        if(val){
            $('#dis_id').val(val);
        }
    });
</script>
@endsection

