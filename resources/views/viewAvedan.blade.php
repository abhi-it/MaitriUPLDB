@extends('master')
@section('content')

<div x-data="viewAvedan" class="container main-div">
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center fw-bold m-4">{{ $heading }} ( आवेदन : {{ $results->total() }})</h3>
        </div>
    </div>

    <form method="get" action="{{ Request::url() }}" class="form-comman">
        @csrf
        <div class="row">

            @if (auth()->user()->user_type == 'Admin' || auth()->user()->user_type == 'Director')


            <div class="form-group col-md-5 col-xl-3">
                <label for="inputEmail4" class="fw-bold"> <span data-hi="सेलेक्ट जनपद"
                        data-en="Select Janpad"></span></label>
                <select class="form-control" x-model="selectedDistrict" name="district_id" id="district_id"
                    @change="onChangeDistrict">
                    <option value="" disabled selected data-hi="सेलेक्ट जनपद" data-en="Select Janpad"></option>
                    <template x-for="option in districts" :key="option">
                        <option x-bind:value="option.id" x-text="option.name_hindi"
                            x-bind:selected="queryParams.district_id == option.id ? true : false"></option>
                    </template>

                </select>
            </div>

            <div class="form-group col-xl-1 col-md-2 fw-semibold my-auto text-center"> <span data-hi="अथवा"
                    data-en="Or"></span> </div>
            @endif
            <div class="form-group col-md-5 col-xl-3">
                <label for="inputEmail4" class="fw-bold" data-hi="आवेदन नंबर" data-en="Application Number"></label>
                <input type="text" value="{{ @$_GET['applicationNumber'] }}" class="form-control"
                    name="applicationNumber" id="applicationNumber" data-placeholder-hi="आवेदन  नंबर"
                    data-placeholder-en="Application Number">
            </div>

            <div class="form-group col-xl-1 col-md-2 fw-semibold my-auto text-center"><span data-hi="अथवा"
                    data-en="Or"></span></div>

            <div class="form-group col-md-5 col-xl-3">
                <label for="inputEmail4" class="fw-bold" data-hi="मोबाइल नंबर" data-en="Mobile Number"></label>
                <input type="text" value="{{ @$_GET['mobile'] }}" class="form-control" name="mobile" id="mobile"
                    data-placeholder-hi="मोबाइल नंबर" data-placeholder-en="Mobile Number">
            </div>

            <div class="form-group col-xl-3 mt-4 col-md-12">
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
    <div class="row">
        <div class="col-md-12">
            <div class="pagnation-scroll">
                {{ $results->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="myTable202" class="table table-striped  table-responsive table-bordered">
                <thead>
                    <tr>
                        <th> <span data-hi="आवेदन नंबर" data-en="Applicant's Number"></span> </th>
                        <th><span data-hi="आवेदक का नाम" data-en="Applicant's Name"></span> </th>
                        <th><span data-hi="अभ्यर्थी का स्वत: मूल्यांकन अंक"
                                data-en="Candidate's Self-Assessment Marks"></span>
                        </th>
                        <th> <span data-hi="आवेदन दिनांक" data-en="Avedan Date"></span> </th>
                        <th> <span data-hi="देखें" data-en="View"></span> </th>
                        <th><span data-hi="स्थिति" data-en="Status"></span> </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($results->count())
                    @foreach ($results as $row)
                    @php
                    $high_percentage = $row->high_percentage;
                    $high_school_calculation = round(($high_percentage*8)/10);
                    $inter_percentage = $row->inter_percentage;
                    $inter_calculation = round(($inter_percentage*2)/10);
                    $topper_number = $high_school_calculation + $inter_calculation;
                    @endphp

                    <tr>
                        <td>{{ $row->applicationNumber }}</td>
                        <td>{{ $row->applicant_name }}</td>
                        <td><a href="javascript:void(0)"
                                onClick="viewCalculation({{ $row->id }});">{{ $topper_number }}</a>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ url('view-Avedan-details') }}/{{ $row->id }}">
                                <span data-hi="विवरण देखें" data-en="View Details"></span>
                            </a>
                            @if (auth()->user()->user_type == 'Admin' and (Request::segment(1) == 'avedan' or
                            Request::segment(1) == 'total-avedan'))
                            | <a href="{{ url('edit-avedan') }}/{{ $row->id }}">
                                <span data-hi="एडिट" data-en="Edit"></span>
                            </a>
                            @endif
                        </td>
                        <td>
                            @if ($row->is_approved == 0)
                            <a href="javascript:void(0)" class="btn btn-secondary">
                                <span data-hi="लंबित" data-en="Pending"></span> </a>
                            @elseif($row->is_approved == 1)
                            <a href="javascript:void(0)" class="btn btn-success">
                                <span data-hi="स्वीकृत" data-en="Accepted"></span> </a>
                            @elseif($row->is_approved == 2)
                            <a href="javascript:void(0)" class="btn btn-success">
                                <span data-hi="अस्वीकार" data-en="Rejected"></span> </a>
                            @elseif($row->is_approved == 3)
                            <a href="javascript:void(0)" class="btn btn-info active">
                                <span data-hi="प्रतीक्षा सूची में है.." data-en="Waiting.."></span></a>
                            @elseif($row->is_approved == 4)
                            <a href="javascript:void(0)" class="btn btn-info active">
                                <span data-hi="चयनित" data-en="Selected"></span>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6" style="color:red;">No record found..</td>
                        @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="pagnation-scroll">
                {{ $results->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@include('bladeJS.viewAvedanJs')
@endsection