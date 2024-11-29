@extends('master')
@section('content')

<style>
    .cus-btn{
        display: flex;
        justify-content: center;
        gap: 5px;
    }
</style>
    <div x-data="viewAvedan" class="container main-div">
        <h3 class="text-center fw-bold m-4"><span data-hi="मैत्री जीईओ स्थान" data-en="Maitri GEO Location"></span></h3>
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <div class="row">
           <div class="col-md-12">
           {{ $allMaitri->appends(request()->query())->links() }}
           </div>
        </div>
        <table id="myTable202" class="table table-striped  table-responsive table-bordered">
            <thead>
                <tr>
                    <th><span data-hi="S.No" data-en="S.no"></span></th>
                    <th><span data-hi="मंडल" data-en="Mandal"></span></th>
                    <th><span data-hi="जनपद" data-en="Janpad"></span></th>
                    <th><span data-hi="जनपद" data-en="Maitri"></span></th>
                    <th><span data-hi="एआई केंद्र का नाम" data-en="AI Center"></span></th>
                    <th><span data-hi="मोबाइल नंबर" data-en="Mobile No"></span></th>
                    <th><span data-hi="ब्लाक" data-en="Block"></span></th>
                    <th><span data-hi="तहसील" data-en="Tehsil"></span></th>
                    <th><span data-hi="अक्षांश" data-en="Latitude"></span></th>
                    <th><span data-hi="देशान्तर" data-en="Longitude"></span></th>
                    <th><span data-hi="अद्यतन" data-en="Action"></span></th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1 @endphp
                @foreach($allMaitri as $maitri)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $maitri['mandal_name'] }}</td>
                    <td>{{ $maitri['janpad_name'] }}</td>
                    <td>{{ $maitri['maitri_name'] }}</td>
                    <td>{{ $maitri['center_name'] }}</td>
                    <td>{{ $maitri['maitri_mobile_no'] }}</td>
                    <td>{{ $maitri['block'] }}</td>
                    <td>{{ $maitri['tehsil'] }}</td>
                    <td>{{ $maitri['latitude'] }}</td>
                    <td>{{ $maitri['longitude'] }}</td>
                    <td>
                        <div class="cus-btn">
                            <a href="{{ route('edit-geo-maitri', $maitri->id) }}" class="btn btn-warning btn-sm"> 
                                <i class="ri-edit-box-line"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @php $i++ @endphp
                @endforeach
            </tbody>
        </table>
        <div class="row">
           <div class="col-md-12">
            {{ $allMaitri->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
