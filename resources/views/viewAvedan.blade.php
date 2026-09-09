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
                    <div class="form-group col-md-5 col-xl-2">
                        <label for="inputEmail4" class="fw-bold"> <span data-hi="सेलेक्ट जनपद"
                                data-en="Select Janpad"></span></label>
                        <select class="form-control" x-model="selectedDistrict" name="district_id" id="district_id"
                            @change="onChangeDistrict">
                            <option value="" disabled selected data-hi="सेलेक्ट जनपद" data-en="Select Janpad">
                            </option>
                            <template x-for="option in districts" :key="option">
                                <option x-bind:value="option.id" x-text="option.name_hindi"
                                    x-bind:selected="queryParams.district_id == option.id ? true : false"></option>
                            </template>

                        </select>
                    </div>

                    <div class="form-group col-xl-1 col-md-2 fw-semibold my-auto text-center"> <span data-hi="अथवा"
                            data-en="Or"></span> </div>
                @endif
                <div class="form-group col-md-5 col-xl-2">
                    <label for="inputEmail4" class="fw-bold" data-hi="आवेदन नंबर" data-en="Application Number"></label>
                    <input type="text" value="{{ @$_GET['applicationNumber'] }}" class="form-control"
                        name="applicationNumber" id="applicationNumber" data-placeholder-hi="आवेदन  नंबर"
                        data-placeholder-en="Application Number">
                </div>

                <div class="form-group col-xl-1 col-md-2 fw-semibold my-auto text-center"><span data-hi="अथवा"
                        data-en="Or"></span></div>

                <div class="form-group col-md-5 col-xl-2">
                    <label for="inputEmail4" class="fw-bold" data-hi="मोबाइल नंबर" data-en="Mobile Number"></label>
                    <input type="text" value="{{ @$_GET['mobile'] }}" class="form-control" name="mobile" id="mobile"
                        data-placeholder-hi="मोबाइल नंबर" data-placeholder-en="Mobile Number">
                </div>

                <div class="form-group col-xl-1 col-md-2 fw-semibold my-auto text-center"><span data-hi="अथवा"
                        data-en="Or"></span></div>

                <div class="form-group col-md-5 col-xl-2">
                    <label for="inputEmail4" class="fw-bold" data-hi="पशु सखी स्थिति" data-en="Pashu Sakhi Status"></label>
                    <select class="form-control" name="pashu_sakhi" id="pashu_sakhi">
                        <option value="" disabled selected data-hi="सेलेक्ट पशु सखी स्थिति"
                            data-en="Select Pashu Sakhi Status"></option>
                        <option value="yes" {{ @$_GET['pashu_sakhi'] == 'yes' ? 'selected' : '' }}> Yes </option>
                        <option value="no" {{ @$_GET['pashu_sakhi'] == 'no' ? 'selected' : '' }}> No </option>
                    </select>
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
                            @if(isset($institutes) && !empty($institutes))
                            <th><span data-hi="आवेदन को इंस्टीट्यूट में असाइन करें" data-en="Assign to Institute"></span> </th>
                            @endif
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
                                    <td><a href="javascript:void(0)"
                                            onClick="viewCalculation({{ $row->id }});">{{ $topper_number }}</a>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ url('view-Avedan-details') }}/{{ $row->id }}">
                                            <span data-hi="विवरण देखें" data-en="View Details"></span>
                                        </a>
                                        @if (auth()->user()->user_type == 'Admin' and (Request::segment(1) == 'avedan' or Request::segment(1) == 'total-avedan'))
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
                                    @if(isset($institutes) && !empty($institutes))
                                    <td>
                                        @if ($row->institute_id == null)
                                            <button class="btn btn-primary assign-institute-btn"
                                                data-id="{{ $row->id }}" data-institute-id="{{ $row->institute_id }}">Assign to Institute</button>
                                        @elseif ($row->institute_id != null && $row->maitri_id)
                                            <a target="_blank" href="{{ url('certificate-preview') }}/{{ $row->maitri_id }}"
                                                class="btn btn-sm btn-primary" title="View Certificate">
                                                <span data-hi="प्रदर्शन" data-en="View"> Certificate </span>
                                            </a>
                                        @else
                                            <button class="btn btn-primary assign-institute-btn"
                                                data-id="{{ $row->id }}" data-institute-id="{{ $row->institute_id }}" data-hi="संशोधित करें" data-en="Update Institute">Update Institute</button>
                                        @endif

                                    </td>
                                    @endif

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

    @if(isset($institutes) && !empty($institutes))
    <!-- Assign Institute Modal Start -->
    <div class="modal fade" id="assignInstituteModal" tabindex="-1" role="dialog"
        aria-labelledby="assignInstituteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignInstituteModalLabel">Assign to Institute</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="assignInstituteForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="application_id" id="application_id">
                        <div class="form-group">
                            <label for="institute_id">Choose Institute</label>
                            <select name="institute_id" id="institute_id" class="form-control" required>
                                <option value="" disabled selected>Select Institute</option>
                                @foreach ($institutes as $institute)
                                    <option data-hindi="{{ $institute->name_hindi }}" value="{{ $institute->id }}"> {{ $institute->name_en ?? $institute->name_hindi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Assign Institute Modal End -->
    @endif
    <!-- Edit Modal Pop-up End -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Open modal and load data
            $('.assign-institute-btn').on('click', function() {
                const application_id = $(this).data('id');
                $('#application_id').val(application_id);
                $('#assignInstituteModal').modal('show');

                const institute_id = $(this).data('institute-id');
                // Set the selected option for #institute_id
                $('#institute_id').val(institute_id);
                $('#institute_id').trigger('change');
                // If using bootstrap selectpicker, refresh it (optional)
                if ($.fn.selectpicker) {
                    $('#institute_id').selectpicker('refresh');
                }
            });



            $('#assignInstituteForm').submit(function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('assignInstitute') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $('#assignInstituteModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Institute assigned successfully',
                        }).then(() => {
                            // Optionally, reload or do something useful
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Something went wrong. Please try again.',
                        });
                    }
                });
            });

        });
    </script>

    @include('bladeJS.viewAvedanJs')
@endsection
