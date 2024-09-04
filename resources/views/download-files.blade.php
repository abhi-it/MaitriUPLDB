@extends('master')
@section('content')
<div class="container main-div" style="background-color:white;">
    <h1 style="margin-top:10px;text-align: center;margin-bottom:20px;">
        <span data-hi="स्कैन किए गए शपथ पत्रों की सूची"  data-en="List of Scanned Affidavits"></span>
    </h1>
    <div class="row">
        <div class="form-group col-md-12">
            <table class="table table-bordered">
                <tr style="background-color:#d3d3d3;">
                    <th > <span data-hi="क्रं सं" data-en="S.No."></span>  </th>
                    <th ><span data-hi="दस्तावेज़ का शीर्षक" data-en="Document Title"></span> </th>
                    <th ><span data-hi="लक्ष्य के प्रति अधिक मैत्री की मांग" data-en="Seeking more maitri towards the target"></span> </th>
                    <th ><span data-hi="फ़ाइलें देखें" data-en="View Files"></span></th>
                </tr>
                @if ($results->count())
                    @foreach ($results as $key=> $row)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td><span data-hi="स्कैन शपथ - पत्र"  data-en="Scanned Affidavit"></span>   </td>
                        <td>
                            @if($row->maitri_target_file)
                            <a target="_blank" href="{{ asset('') }}scanned_files/{{ $row->maitri_target_file }}">
                                <i class="fa fa-eye" aria-hidden="true"></i> 
                            </a>
                            @endif
                        </td>
                        <td>
                            <a target="_blank" href="{{ asset('') }}scanned_files/{{ $row->scanned_file }}">
                                <i class="fa fa-eye" aria-hidden="true"></i> 
                            </a>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center ">No record found..</td>
                    </tr>
                @endif
            </table>
        </div>
        <div class="row">
            {{ $results->links() }}
        </div>
    </div>
</div>
@endsection
