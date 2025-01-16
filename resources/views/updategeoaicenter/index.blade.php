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
    <h3 class="text-center m-4 fw-bold"> <span data-hi="एआई केंद्र जीईओ स्थान" data-en="AI Center GEO Location"></span>
    </h3>
    <a href="/inactive-aicenter-geo-location"><button class="mb-3 btn btn-primary">Inactive AI Center GEO
            Location</button></a>
    <form method="get" action="{{ Request::url() }}" class="form-comman maitri-update">
        @csrf
        <div class="row">
            <!-- <div class="form-group col-md-5 col-xl-3">
                   
            </div> -->
            <div class="form-group col-xl-3 mt-4 col-md-12">
                <label for="inputEmail4" class="fw-bold"> <span data-hi="जिला चुनें"
                        data-en="Select District"></span></label>

                <select class="form-control" name="district_id" id="mandal">
                    <option value="" data-hi="जिला चुनें" data-en="Select District"></option>
                    @foreach($districts as $district)
                    <option value="{{ $district['name_hindi'] }}" data-hi="{{ $district['name_hindi'] }}"
                        data-en="{{ $district['name_eng'] }}" @if(request('district_id')==$district['name_hindi'])
                        selected @endif></option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-xl-3 mt-4 col-md-12">
                <label class="fw-bold">Select AiCenter</label>

                <select name="aicenter" id="aicenter" class="form-control" autofocus>
                    <option value="" data-hi="एआई सेंटर चुनें" data-en="Select AiCenter"></option>
                    @foreach($aiCenterData as $aiCenter)
                    <option value="{{ $aiCenter['name'] }}" data-hi="{{ $aiCenter['name'] }}"
                        data-en="{{ $aiCenter['name'] }}" @if(request('aicenter')==$aiCenter['name']) selected @endif>
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-xl-3 mt-4 col-md-12">
                <button type="submit" class="btn btn-primary"> <span data-hi="सर्च करें" data-en="Search">
                    </span></button>
                <a href="{{ Request::url() }}" class="btn btn-secondary"> <span data-hi=" रीसेट करें"
                        data-en="Reset"></span></a>
            </div>
            @if (isset($route, $year))
            @php
            $queryParameters = request()->query();

            $queryParameters['export'] = true;
            $queryParameters['year'] = $year;
            @endphp

            <a class="btn btn-secondary btn-export" href="{{ route($route, $queryParameters) }}">Export</a>
            @endif

        </div>
    </form>

    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
    <div class="pagination">
        <div class="col-md-12">
            <div class="pagnation-scroll">
                {{ $allAicenter->links() }}
            </div>
        </div>
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
        <div class="col-md-12">
            <div class="pagnation-scroll">
                {{ $allAicenter->links() }}
            </div>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>



<script>
$(document).ready(function() {

    // $('#mandal').change(function() {
    //     $('#vikas_khand').prop('disabled', false).empty();
    //     $('#ai_center').prop('disabled', false).empty();
    //     $('#tehsil').prop('disabled', false).empty();

    //     var mandal = $("#district option:selected").text();
    //     var janpad = $("#mandal option:selected").val();

    //     $.ajax({
    //         type: "GET",
    //         url: "get-all-tehsil",
    //         data: {
    //             "mandal": mandal,
    //             "janpad": janpad,
    //         },
    //         cache: false,
    //         success: function(data) {
    //             var getTehsil = data.data;
    //             if (getTehsil && getTehsil.length > 0) {
    //                 $('#tehsil').append(
    //                     '<option value="">Select Tehsil</option>');
    //                 getTehsil.forEach(item => {
    //                     if (item.tehsil && item.tehsil.trim() !== '') {
    //                         $('#tehsil').append(
    //                             `<option value="${item.tehsil}">${item.tehsil}</option>`
    //                         );
    //                     }
    //                 });

    //             } else {
    //                 $('#tehsil').append(
    //                     '<option value="">-Data not found.-</option>');
    //             }
    //         },
    //         error: function() {
    //             $('#tehsil').append(
    //                 '<option value="">-Error fetching data.-</option>');
    //         }
    //     });
    // });

    // $('#tehsil').change(function() {
    //     $('#vikas_khand').prop('disabled', false);
    //     $('#vikas_khand').empty();
    //     $('#ai_center').prop('disabled', false);
    //     $('#ai_center').empty();
    //     var tehsil = $(this).val();
    //     var mandal = $("#district option:selected").text();
    //     var janpad = $("#mandal option:selected").val();
    //     $.ajax({
    //         type: "GET",
    //         url: "get-all-block",
    //         data: {
    //             "tehsil": tehsil,
    //             "mandal": mandal,
    //             "janpad": janpad,
    //         },
    //         cache: false,
    //         success: function(data) {
    //             var getBlock = data.data;
    //             if (getBlock && getBlock.length > 0) {
    //                 $('#vikas_khand').append(
    //                     `<option value="">Select Block</option>`);
    //                 getBlock.forEach(item => {
    //                     if (item.block && item.block.trim() !== '') {
    //                         $('#vikas_khand').append(
    //                             `<option value="${item.block}">${item.block}</option>`
    //                         );
    //                     }
    //                 });
    //                 if (block) {
    //                     $('#vikas_khand').val(block);
    //                 }
    //             } else {
    //                 $('#vikas_khand').append('<option value="">-Data not found.-</option>');
    //             }
    //         }
    //     });
    // });

});
</script>

@endsection