@extends('master')
@section('content')

<style>
    .maitri-update .search__button{
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
        <h3 class="text-center m-4 fw-bold">  <span data-hi="मैत्री/एआई सेंटर डेटा"    data-en="Maitri/AI Center data"></span> </h3>
        <form method="get" action="{{ Request::url() }}" class="form-comman maitri-update">
            @csrf
            <div class="row">
                <!-- <div class="form-group col-md-5 col-xl-3">
                   
            </div> -->
            <div class="form-group col-xl-3 mt-4 col-md-12 d-flex">
                <label for="inputEmail4" class="fw-bold"> <span data-hi="जिला चुनें" data-en="Select District"></span></label>
                <div>
                <select class="form-control" x-model="selectedDistrict" name="district_id" id="district_id">
                    <option value="" data-hi="जिला चुनें" data-en="Select District"></option>
                    @foreach($districts as $district)
                    <option value="{{ $district['name_hindi'] }}" selected data-hi="{{ $district['name_hindi'] }}" data-en="{{ $district['name_eng'] }}"></option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary"> <span data-hi="सर्च करें" data-en="Search"> </span></button>
                <a href="{{ Request::url() }}" class="btn btn-secondary"> <span data-hi=" रीसेट करें" data-en="Reset"></span></a>
                @if (isset($route, $year))
                    @php
                        $queryParameters = request()->query();

                        $queryParameters['export'] = true;
                        $queryParameters['year'] = $year;
                    @endphp

                <a class="btn btn-secondary btn-export" href="{{ route($route, $queryParameters) }}" >Export</a>
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
                    <th><span data-hi="तरल नाइट्रोजन" data-en="Mandal"></span></th>
                    <th><span data-hi="वीर्य" data-en="Janpad"></span></th>
                    <th><span data-hi="वीर्य का प्रकार" data-en="Tehsil"></span></th>
                    <th><span data-hi="बैनर" data-en="Block"></span></th>
                    <th> <span data-hi="डैंगलर" data-en="AI Center"></span></th>
                    <th><span data-hi="स्टैन्डी" data-en="Maitri Name"></span></th>
                    <th><span data-hi="पुस्तिका" data-en="Mobile No"></span></th>
                    <th> <span data-hi="एआई किट" data-en="bahar Pashudhan Id"></span> </th>
                    <th> <span data-hi="निर्माण तिथि" data-en="Action"></span> </th>
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
                        <td><a href="{{ route('edit-maitri-record', $data->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a></td>
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
        $(document).ready(function () {
            // $('#my-new-table').DataTable({
            //     lengthMenu: [
            //         [10, 25, 50, 100, -1],
            //         [10, 25, 50, 100, "All"]
            //     ],
            //     pageLength: 10,
            //     dom: 'lBfrtip',
            //     buttons: [
            //         'csv', 'excel'
            //     ]
            // });
        });
    </script>

@endsection

