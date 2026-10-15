@extends('master')
@section('content')
    <div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
        <h3 class="text-center fw-bold m-4">{{ $heading }} ( आवेदन : {{ $results->total() }})</h3>


        <form method="get" action="{{ Request::url() }}" class="form-comman">
            @csrf
            <div class="row">


                <div class="form-group col-md-5 col-xl-3">
                    <label for="inputEmail4" class="fw-bold">आवेदन नंबर</label>
                    <input type="text" value="{{ @$_GET['applicationNumber'] }}" class="form-control"
                        name="applicationNumber" id="applicationNumber" placeholder="आवेदन  नंबर">
                </div>

                <div class="form-group col-xl-1 col-md-2 fw-semibold my-auto text-center">अथवा</div>

                <div class="form-group col-md-5 col-xl-3">
                    <label for="inputEmail4" class="fw-bold">मोबाइल नंबर</label>
                    <input type="text" value="{{ @$_GET['mobile'] }}" class="form-control" name="mobile" id="mobile"
                        placeholder="आवेदन  नंबर">
                </div>

                <div class="form-group col-xl-5 mt-4 col-md-12">
                    <button type="submit" class="btn btn-primary">सर्च करें</button>
                    <a href="{{ Request::url() }}" class="btn btn-secondary">रीसेट करें</a>
                    @if (isset($exportCategory))
                        <a href="{{ route('meritList', [$exportCategory, true]) }}"
                            class="btn btn-secondary btn-export">डाउनलोड एक्ससेल</a>
                    @endif
                </div>

            </div>
        </form>

        <div class="row">
            {{ $results->appends(request()->query())->links() }}
        </div>

        <table class="table table-striped table-responsive">
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
                            $high_school_calculation = round(($high_percentage * 8) / 10);
                            $inter_percentage = $row->inter_percentage;
                            $inter_calculation = round(($inter_percentage * 2) / 10);
                            $topper_number = $high_school_calculation + $inter_calculation;
                        @endphp
                        <tr>
                            <td>{{ $row->applicationNumber }}</td>
                            <td>{{ $row->applicant_name }}</td>
                            <td><span class="total-users"
                                    onClick="viewCalculation({{ $row->id }});">{{ $topper_number }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ url('merit-Avedan-details') }}/{{ $row->id }}">विवरण देखें</a>
                                @if (auth()->user()->user_type == 'Admin' and Request::segment(1) == 'avedan')
                                    | <a href="{{ url('edit-avedan') }}/{{ $row->id }}">एडिट</a>
                                @endif
                            </td>
                            <td>
                                @if ($row->is_approved == 0)
                                    <button class="btn btn-secondary total-users">लंबित</button>
                                @elseif($row->is_approved == 1)
                                    <button class="btn btn-success total-users">स्वीकृत</button>
                                @elseif($row->is_approved == 3)
                                    <button class="btn btn-info active total-users">प्रतीक्षा सूची</button>
                                @else
                                    <button class="btn btn-danger total-users">अस्वीकार</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="row">
            {{ $results->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
