a@extends('master')
@section('content')
    <script>
        function setDateTimeModel(id, applicationID) {
            $('#applicationID').html(applicationID);
            $('#application_id').val(id);

            $('#setDateTimeModel').modal('show');

        }
    </script>
    @if (session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <form method="post" action="{{ url('uploadDocuments') }}" id="verification" enctype="multipart/form-data">
        @csrf
        <div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
            <h3 style="margin-top:10px;text-align: center;">{{ $heading }}</h3>
            <table id="myTable" class="table">
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
                            <tr>
                                <td>{{ $row->applicationNumber }}</td>
                                <td>{{ $row->applicant_name }}</td>
                                <td>{{ $row->topper_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ url('view-Avedan-details') }}/{{ $row->id }}">विवरण देखें</a>
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
                                        <a href="javascript:void(0)"
                                            onclick="setDateTimeModel({{ $row->id }}, '{{ $row->applicationNumber }}')"
                                            class="btn btn-danger">अपलोड स्वास्थ प्रमाण पत्र</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

        </div>

        <!------Start Model Popup Window------------------>
        <style>
            .modal-dialog {
                width: 560px;
                height: 600px !important;
            }

            .modal-content {
                /* 80% of window height */
                height: 60%;
                background-color: #fff;
            }

            .modal-header {
                background-color: #000;
                padding: 16px 16px;
                color: #FFF;
                border-bottom: 2px dashed #000;
            }
        </style>

        <!-- Modal -->
        <div class="modal fade" id="setDateTimeModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">अपलोड स्वास्थ प्रमाण पत्र</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: red;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="application_id" id="application_id">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="inputEmail4">आवेदन नंबर</label>
                                <span id="applicationID"></span>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="inputEmail4">स्वास्थ प्रमाण पत्र</label> <span class="text-danger">*</span>
                                <input type="file" class="form-control" name="health_certificate"
                                    id="health_certificate">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close" data-dismiss="modal">बंद करें</button>
                        <button type="submit" class="btn btn-primary submitMe">अपलोड</button>
                        <span class="spinner-border spinner-border-sm loader saveLoader" role="status" aria-hidden="true"
                            style="display:none;"></span>
                    </div>
                </div>
            </div>
        </div>
        <!------End Model Popup Window------------------>
    </form>

    <script>
        $(document).ready(function() {
            jQuery.extend(jQuery.validator.messages, {
                required: "Required.",
            });
            /*----------------Comments form validate Start----------------*/
            $('#verification').validate({
                rules: {
                    "health_certificate": {
                        required: true,
                    }
                },
                submitHandler: function(form) {

                    $('.close').hide();
                    $('.submitMe').hide();
                    $('.saveLoader').show();
                    form.submit();
                },
            });
            /*----------------Comments form validate End----------------*/
        });
    </script>
@endsection
