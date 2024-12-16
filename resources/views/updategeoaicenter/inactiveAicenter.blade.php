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
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center m-4 fw-bold"> <span data-hi="निष्क्रिय AI केंद्र GEO स्थान" data-en="Inactive AI Center GEO Location"></span>
    </h3>
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
                            data-en="{{ $district['name_eng'] }}" 
                            @if(request('district_id') == $district['name_hindi']) selected @endif></option>
                        @endforeach
                    </select>

                    <select name="aicenter" id="aicenter" class="form-control"autofocus>
                        <option value="" data-hi="एआई सेंटर चुनें" data-en="Select AiCenter"></option>
                        @foreach($aiCenterData as $aiCenter)
                            <option value="{{ $aiCenter['name'] }}" data-hi="{{ $aiCenter['name'] }}"
                                data-en="{{ $aiCenter['name'] }}"
                                @if(request('aicenter') == $aiCenter['name']) selected @endif></option>
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
    <div class="pagination">
        {{ $allAicenter->links() }}
    </div>
    <table class="table table-striped table-responsive table-bordered">
        <thead>
            <tr>
                <th><span data-hi="S.No" data-en="S.No"></span></th>
                <th><span data-hi="मंडल" data-en="Mandal"></span></th>
                <th><span data-hi="जनपद" data-en="Janpad"></span></th>
                <th><span data-hi="प्रकार" data-en="Type"></span></th>
                <th> <span data-hi="एआई सेंटर" data-en="AI Center"></span></th>
                <th> <span data-hi="स्थिति" data-en="Status"></span> </th>
                <th> <span data-hi="अपडेट करें" data-en="Action"></span> </th>
            </tr>
        </thead>
        <tbody>
            @php if($allAicenter->isEmpty()){ @endphp
                <tr><td colspan="7" class="text-center">No Record</td></tr>
            @php } @endphp

            @php $i = 1; @endphp
            @foreach ($allAicenter as $key => $data)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ ($data->mandal_name) ? $data->mandal_name : 'N/A'}}</td>
                <td>{{ ($data->janpad_name) ? $data->janpad_name : 'N/A' }}</td>
                <td>{{ ($data->type) ? $data->type : 'N/A' }}</td>
                <td>{{ ($data->name) ? $data->name : 'N/A' }}</td>
                <td>{{ $data->status == 0 ? 'Active' : 'Inactive' }}</td>
                <td><a href="{{ route('edit-geo-aicenter', $data->id) }}" class="btn btn-primary"><i
                            class="fa fa-edit"></i></a></td>
            </tr>
            @php $i++ @endphp
            @endforeach
        </tbody>
    </table>
    <div class="pagination">
        {{ $allAicenter->links() }}
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

@endsection