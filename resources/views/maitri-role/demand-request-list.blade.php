@extends('submaster')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">

    <div class="d-flex justify-content-between align-items-center m-4">
        <h3 class="fw-bold mb-0">डिमांड अनुरोध सूची</h3>
        <a href="{{ route('demandRequests') }}" class="btn btn-success">
            <i class="fa fa-plus"></i> Add Demand Request
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>क्र. सं.</th>
                <th>नाम</th>
                <th>जन्म तिथि</th>
                <th>लिंग</th>
                <th>भारत पशुधन ID</th>
                <th>जिला</th>
                <th>मोबाइल नं.</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($data) && count($data))
                @foreach($data as $key => $row)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $row->name ?? '--' }}</td>
                    <td>{{ $row->date_of_birth ?? '--' }}</td>
                    <td>{{ $row->gender ?? '--' }}</td>
                    <td>{{ $row->bharat_pashudhan_id ?? '--' }}</td>
                    <td>{{ $row->district ?? '--' }}</td>
                    <td>{{ $row->smart_mobile_no ?? '--' }}</td>
                    <td>
                        <a href="{{ url('view-demand-request/'.$row->id) }}" type="button" class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i> View
                        </a>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="10" style="color:red;">कोई रिकॉर्ड नहीं..</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection