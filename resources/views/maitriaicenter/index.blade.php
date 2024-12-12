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
<div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center m-4 fw-bold"> <span data-hi="मैत्री/एआई सेंटर डेटा" data-en="Maitri/AI Center data"></span>
    </h3>
    <form method="get" action="{{ Request::url() }}" class="form-comman maitri-update">
        @csrf
        <div class="row">
            <!-- <div class="form-group col-md-5 col-xl-3">
                   
            </div> -->
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

                    <select name="tehsil" id="tehsil" class="form-control" placeholder="तहसील" autofocus>
                        <option value="" data-hi="तहसील चुनें" data-en="Select Tehsil"></option>
                        @foreach($tehsilData as $tehsil)
                            @if($tehsil != '')
                                <option value="{{ $tehsil['tehsil'] }}" data-hi="{{ $tehsil['tehsil'] }}"
                                data-en="{{ $tehsil['tehsil'] }}"
                                @if(request('tehsil') == $tehsil['tehsil']) selected @endif></option>
                            @endif
                        @endforeach
                    </select>



                    <select name="block" id="vikas_khand" class="form-control" placeholder="विकास खण्ड" autofocus>
                        <option value="" data-hi="ब्लॉक चुनें" data-en="Select Block"></option>
                        @foreach($blockData as $block)
                            <option value="{{ $block['block'] }}" data-hi="{{ $block['block'] }}"
                                data-en="{{ $block['block'] }}"
                                @if(request('block') == $block['block']) selected @endif></option>
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
    <table class="table table-striped table-responsive table-bordered">
        <thead>
            <tr>
                <th><span data-hi="S.No" data-en="S.No"></span></th>
                <th><span data-hi="मंडल" data-en="Mandal"></span></th>
                <th><span data-hi="जनपद" data-en="Janpad"></span></th>
                <th><span data-hi="तहसील" data-en="Tehsil"></span></th>
                <th><span data-hi="ब्लॉक" data-en="Block"></span></th>
                <th> <span data-hi="एआई सेंटर" data-en="AI Center"></span></th>
                <th><span data-hi="मैत्री नाम" data-en="Maitri Name"></span></th>
                <th><span data-hi="मोबाइल" data-en="Mobile No"></span></th>
                <th> <span data-hi="भारत पशुधन आईडी" data-en="bahar Pashudhan Id"></span> </th>
                <th> <span data-hi="अपडेट करें" data-en="Action"></span> </th>
            </tr>
        </thead>
        <tbody>

            @php $i = 1; @endphp
            @foreach ($manganurodhdata as $key => $data)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ ($data->mandal_name) ? $data->mandal_name : 'N/A'}}</td>
                <td>{{ ($data->janpad_name) ? $data->janpad_name : 'N/A' }}</td>
                <td>{{ ($data->tehsil) ? $data->tehsil : 'N/A' }}</td>
                <td>{{ ($data->block) ? $data->block : 'N/A' }}</td>
                <td>{{ ($data->center_name) ? $data->center_name : 'N/A' }}</td>
                <td>{{ ($data->maitri_name) ? $data->maitri_name : 'N/A' }}</td>
                <td>{{ ($data->maitri_mobile_no) ? $data->maitri_mobile_no : 'N/A' }}</td>
                <td>{{ ($data->any_bharat_id) ? $data->any_bharat_id : 'N/A' }}</td>
                <td><a href="{{ route('edit-maitri-record', $data->id) }}" class="btn btn-primary"><i
                            class="fa fa-edit"></i></a></td>
            </tr>
            @php $i++ @endphp
            @endforeach
        </tbody>
    </table>
    <div class="pagination">
        {{ $manganurodhdata->links() }}
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