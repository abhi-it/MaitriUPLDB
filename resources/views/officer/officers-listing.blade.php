@extends('master')
@section('content')
    <div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
        <h3 class="text-center m-4 fw-bold">
            <span data-hi="जनपद कुल चयनित आवेदक का विवरण एवं सुची" data-en="Details and list of total selected applicants of the district"></span>
        </h3>
        <div class="row">
            <form  action="{{ Request::url() }}" method="get" class="form-comman">
                @csrf
                <div class="col-md-4 mt-4 mb-4">
                    <select name="id" id="id" class="form-control">
                        <option>- सेलेक्ट जनपद -</option>
                        @foreach($dist as $val)
                            @if($val!='' ||$val != null)
                            <option value="{{$val['mandal_name']}}">{{$val['mandal_name']}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 m-2">
                    <button type="submit" class="btn btn-primary">सर्च करें</button>
                     <a href="{{ Request::url() }}" class="btn btn-secondary">रीसेट करें</a>
                </div>
            </form>
            <form method="get" action="{{ route('exportCVOList') }}" > 
                @csrf
                <div class="col-md-2 m-2">
                    <input type="hidden" id="dis_id" name="dis_id">
                    <button class="btn btn-primary" type="submit" id="cvoExportList" >
                    एक्सपोर्ट</button>
                </div>
            </form>
        </div>
        <table id="myTable202" class="table table-striped  table-responsive table-bordered">
            <thead>
                <tr>
                    <th><span data-hi="मंडल का नाम" date-en="Mandal Name"></span> </th>
                    <th> <span data-hi="जनपद का नाम" date-en="Janpad Name"></span>  </th>
                    <th><span data-hi="अधिकारी का नाम" date-en="Officer Name"></span> </th>
                    <th><span data-hi="लॉगिन आईडी" date-en="Login ID"></span></th>
                    <th><span data-hi="ईमेल" date-en="Email"></span></th>
                    <th><span data-hi="मोबाइल नंबर" date-en="Mobile Number"></span></th>
                    <th><span data-hi="आधार नंबर" date-en="Aadhar Number"></span></th>
                    <th> <span data-hi="पद का नाम" date-en="Designation"></span></th>
                    <th><span data-hi="पशु देखभाल केंद्र" date-en="Animal Care Center"></span> </th>
                    <th><span data-hi="गतिविधि" date-en="Action"></span> </th>
                </tr>
            </thead>
            <tbody >
            @if(count($data)>0)
            @foreach($data as $val)
            <tr>
                <td>{{($val->mandal_name)?$val->mandal_name:'-'}}</td>
                <td>{{($val->janpad_name)?$val->janpad_name:'-'}}</td>
                <td>{{($val->officer_name)?$val->officer_name:'-'}}</td>
                <td>{{($val->login_id)?$val->login_id:'-'}}</td>
                <td>{{($val->email)?$val->email:'-'}}</td>
                <td>{{($val->adhar_no)?$val->adhar_no:'-'}}</td>
                <td>{{($val->mobile_no)?$val->mobile_no:'-'}}</td>
                <td>{{($val->designation)?$val->designation:'-'}}</td> 
                <td>{{($val->animal_care_center)?$val->animal_care_center:'-'}} </td>
                <td>
                    <a href="{{ url('view-officer-details') }}/{{ $val->id }}" class="btn btn-secondary">
                        <span data-hi="विवरण देखें" data-en="View Details"></span>
                    </a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="9" style="color:red;">No record found..</td>
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
        var val = $("#id option:selected").val();
        console.log('val',val)
        if(val){
            $('#dis_id').val(val);
        }
    });
</script>
@endsection

