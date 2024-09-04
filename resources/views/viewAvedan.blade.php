@extends('master')
@section('content')

    <div x-data="viewAvedan" class="container main-div">
        <h3 style="margin-top:10px;text-align: center;">{{ $heading }} ( आवेदन : {{ $results->total() }})</h3>


        <form method="get" action="{{ Request::url() }}">
            @csrf
            <div class="row form-comman">

                @if (auth()->user()->user_type == 'Admin' || auth()->user()->user_type == 'Director')


                <div class="form-group col-md-3">
                    <label for="inputEmail4" class="fw-bold">सेलेक्ट जनपद </label>
                    <select class="form-control" x-model="selectedDistrict" name="district_id" id="district_id"
                    @change="onChangeDistrict">
                    <option value="" disabled selected>सेलेक्ट जनपद</option>
                    <template x-for="option in districts" :key="option">
                        <option x-bind:value="option.id" x-text="option.name_hindi"
                        x-bind:selected="queryParams.district_id == option.id ? true : false"></option>
                    </template>

                </select>
            </div>

            <div class="form-group col-md-1 fw-semibold my-auto text-center">अथवा</div>
            @endif
                <div class="form-group col-md-3">
                    <label for="inputEmail4"  class="fw-bold">आवेदन नंबर</label>
                    <input type="text" value="{{ @$_GET['applicationNumber'] }}" class="form-control"
                        name="applicationNumber" id="applicationNumber" placeholder="आवेदन  नंबर">
                </div>

                <div class="form-group col-md-1 fw-semibold my-auto text-center">अथवा</div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4"  class="fw-bold">मोबाइल नंबर</label>
                    <input type="text" value="{{ @$_GET['mobile'] }}" class="form-control" name="mobile" id="mobile"
                        placeholder="मोबाइल नंबर">
                </div>

                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-primary">सर्च करें</button>
                    <a href="{{ Request::url() }}" class="btn btn-secondary">रीसेट करें</a>
                    @if (isset($route, $year))
                        @php
                            $queryParameters = request()->query();

                            $queryParameters['export'] = true;
                            $queryParameters['year'] = $year;
                        @endphp

                        <a class="btn btn-secondary btn-export" href="{{ route($route, $queryParameters) }}"
                            >Export</a>
                    @endif
                </div>

            </div>
        </form>
        <div class="row">
           <div class="col-md-12">
           {{ $results->appends(request()->query())->links() }}
           </div>
        </div>
        <table id="myTable202" class="table table-striped  table-responsive table-bordered">
            <thead>
                <tr>
                    <th>आवेदन नंबर</th>
                    <th>आवेदक का नाम</th>
                    <th>अभ्यर्थी का स्वत: मूल्यांकन अंक</th>
                    <th>दिनांक</th>
                    <th>देखें</th>
                    <th>स्थिति</th>
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
                                    onClick="viewCalculation({{ $row->id }});">{{ $topper_number }}</a></td>
                            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ url('view-Avedan-details') }}/{{ $row->id }}">विवरण देखें</a>
                                @if (auth()->user()->user_type == 'Admin' and (Request::segment(1) == 'avedan' or Request::segment(1) == 'total-avedan'))
                                    | <a href="{{ url('edit-avedan') }}/{{ $row->id }}">एडिट</a>
                                @endif
                            </td>
                            <td>
                                @if ($row->is_approved == 0)
                                    <a href="javascript:void(0)" class="btn btn-secondary">लंबित</a>
                                @elseif($row->is_approved == 1)
                                    <a href="javascript:void(0)" class="btn btn-success">स्वीकृत</a>
                                @elseif($row->is_approved == 2)
                                    <a href="javascript:void(0)" class="btn btn-success">अस्वीकार</a>
                                @elseif($row->is_approved == 3)
                                    <a href="javascript:void(0)" class="btn btn-info active">प्रतीक्षा सूची में है..</a>
                                @elseif($row->is_approved == 4)
                                    <a href="javascript:void(0)" class="btn btn-info active">चयनित</a>
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
        <div class="row">
           <div class="col-md-12">
            {{ $results->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    @include('bladeJS.viewAvedanJs')
@endsection
