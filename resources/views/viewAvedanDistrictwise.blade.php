@extends('master')
@section('content')
    <div x-data="viewAvedanDistrictwise" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
        <h3 style="margin-top:10px;text-align: center;">{{ $heading }} ( आवेदन : {{ $results->total() }}) </h3>

        <form method="get" action="{{ url('avedan-districtwise') }}/{{ $sessionYear }}">
            @csrf
            <input type="hidden" name="year" value="{{ $sessionYear }}">
            <div class="row">

                <div class="form-group col-md-3">
                    <label for="inputEmail4">सेलेक्ट जनपद </label>
                    <select class="form-control" x-model="selectedDistrict" name="district_id" id="district_id"
                        @change="onChangeDistrict">
                        <option value="" disabled selected>सेलेक्ट जनपद</option>
                        <template x-for="option in districts" :key="option">
                            <option x-bind:value="option.id" x-text="option.name_hindi"
                                x-bind:selected="queryParams.district_id == option.id ? true : false"></option>
                        </template>

                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4">सेलेक्ट विकासखण्ड </label>
                    <select class="form-control" x-model="selectedBlock" name="vikas_khand" id="vikas_khand">
                        <option value="" disabled selected>सेलेक्ट विकासखण्ड </option>
                        <template x-for="option in vikasKhand" :key="option">
                            <option x-bind:value="option" x-text="option"
                                x-bind:selected="queryParams.vikas_khand == option ? true : false"></option>
                        </template>

                    </select>
                </div>

                <div class="form-group
                                col-md-4">
                    <label for="inputEmail4">श्रेणी</label>
                    <select class="form-control" x-model="selectedCategory" name="category">
                        <option value="" disabled selected>सेलेक्ट</option>
                        <template x-for="option in categories" :key="option">
                            <option x-bind:value="option" x-text="option"
                                x-bind:selected="queryParams.category == option ? true : false"></option>
                        </template>
                    </select>
                </div>

                <div class="form-group col-md-3" style="padding-top: 5px;">
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;width:100px;">देंखे</button>
                    <a href="{{ Request::url() }}" class="btn btn-secondary" style="margin-top: 25px;">रीसेट करें</a>
                </div>

            </div>
        </form>

        <div class="row">
            {{ $results->appends($filter)->links() }}
        </div>


        <table id="myTable303" class="table">
            <thead>
                <tr>
                    <th>आवेदन नंबर</th>
                    <th>आवेदक का नाम</th>
                    <th>श्रेणी</th>
                    <th>अभ्यर्थी का स्वत: मूल्यांकन अंक</th>
                    <th>दिनांक</th>
                    <th>देखें</th>
                    <th>स्थिति</th>
                </tr>
            </thead>
            <tbody>
                @if ($results->count())
                    @foreach ($results as $row)
                        <tr>
                            <td>{{ $row->applicationNumber }}</td>
                            <td>{{ $row->applicant_name }}</td>
                            <td>{{ $row->category }}</td>
                            <td><a href="javascript:void(0)"
                                    onClick="viewCalculation({{ $row->id }});">{{ $row->topper_number }}</a></td>
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
                                @elseif($row->is_approved == 3)
                                    <a href="javascript:void(0)" class="btn btn-info active">प्रतीक्षा सूची</a>
                                @else
                                    <a href="javascript:void(0)" class="btn btn-danger">अस्वीकार</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="row">
            {{ $results->links() }}
        </div>
    </div>
    @include('bladeJS.viewAvedanDistrictwiseJs')
@endsection
