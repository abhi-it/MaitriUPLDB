@extends('master')
@section('content')

<style>
.maitri-update .search__button {
    display: flex;
    align-items: flex-end;
    gap: 10px;
}

.maitri-update .d-flex {
    display: flex;
    flex-direction: column;
}

.maitri-update .d-flex div {
    display: flex;
    align-items: center;
    gap: 13px;
}

.maitri-update .d-flex div select {
    min-width: 265px;
}
</style>
<div class="container main-div">
    <h3 class="text-center fw-bold m-4"><span data-hi="मैत्री जीईओ स्थान" data-en="Inactive Maitri GEO Location"></span></h3>
    <a href="{{ url()->previous() }}"><button class="mb-3 btn btn-primary"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;<b>Back</b></button></a>
    <form method="get" action="{{ Request::url() }}" class="form-comman maitri-update">
        @csrf
        <div class="row">
            <div class="form-group col-xl-3 mt-4 col-md-12 d-flex">
                <label for="inputEmail4" class="fw-bold"> <span data-hi="जिला चुनें"
                        data-en="Select District"></span></label>
                <div>
                    <select class="form-control" name="district_id" id="mandal">
                        <option value="" data-hi="जिला चुनें" data-en="Select District"></option>
                        @foreach($districts as $district)
                        <option value="{{ $district['name_hindi'] }}" data-hi="{{ $district['name_hindi'] }}"
                            data-en="{{ $district['name_eng'] }}" @if(request('district_id')==$district['name_hindi'])
                            selected @endif></option>
                        @endforeach 
                    </select>

                    <select name="tehsil" id="tehsil" class="form-control" placeholder="तहसील" autofocus>
                        <option value="" data-hi="तहसील चुनें" data-en="Select Tehsil"></option>
                        @foreach($tehsilData as $tehsil)
                        @if($tehsil != '')
                        <option value="{{ $tehsil['tehsil'] }}" data-hi="{{ $tehsil['tehsil'] }}"
                            data-en="{{ $tehsil['tehsil'] }}" @if(request('tehsil')==$tehsil['tehsil']) selected @endif>
                        </option>
                        @endif
                        @endforeach
                    </select>

                    <select name="block" id="vikas_khand" class="form-control" autofocus>
                        <option value="" data-hi="ब्लॉक चुनें" data-en="Select Block"></option>
                        @foreach($blockData as $block)
                        <option value="{{ $block['block'] }}" data-hi="{{ $block['block'] }}"
                            data-en="{{ $block['block'] }}" @if(request('block')==$block['block']) selected @endif>
                        </option>
                        @endforeach
                    </select>

                    <select name="aicenter" id="aicenter" class="form-control" autofocus>
                        <option value="" data-hi="एआई सेंटर चुनें" data-en="Select AiCenter"></option>
                        @foreach($aiCenterData as $aiCenter)
                        <option value="{{ $aiCenter['center_name'] }}" data-hi="{{ $aiCenter['center_name'] }}"
                            data-en="{{ $aiCenter['center_name'] }}" @if(request('aicenter')==$aiCenter['center_name'])
                            selected @endif></option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary"> <span data-hi="सर्च करें" data-en="Search">
                        </span></button>
                    <a href="{{ Request::url() }}" class="btn btn-secondary"> <span data-hi=" रीसेट करें"
                            data-en="Reset"></span></a>
                    @if (isset($route, $year))
                    @php
                    $queryParameters = request()->query();

                    $queryParameters['export'] = true;
                    $queryParameters['year'] = $year;
                    @endphp

                    <a class="btn btn-secondary btn-export" href="{{ route($route, $queryParameters) }}">Export</a>
                    @endif
                </div>
            </div>
    </form>

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
                <th> <span data-hi="स्थिति" data-en="Status"></span> </th>
                <th><span data-hi="अद्यतन" data-en="Action"></span></th>
            </tr>
        </thead>
        <tbody>
            @php if($allMaitri->isEmpty()){ @endphp
                <tr><td colspan="12" class="text-center">No Record</td></tr>
            @php } @endphp
            
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
                <td>{{ $maitri['status'] == 0 ? 'Active' : 'Inactive' }}</td>
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