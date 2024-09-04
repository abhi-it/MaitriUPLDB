@extends('master')
@section('content')
    <script>
        $(document).ready(function() {
            $("#ckbCheckAll").click(function() {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });
        });

        function setDateTimeModel() {

            var checked = $("#verification input:checked").length > 0;
            if (!checked) {
                alert("Please select at least one checkbox");
                return false;
            }
            $('#setDateTimeModel').modal('show');

        }
    </script>
    @if (session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <form method="post" action="{{ url('saveDocumnetVerification') }}" id="verification" enctype="multipart/form-data">
        @csrf
        <div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
            <h3 style="margin-top:10px;text-align: center;">
                {{ $heading }}
                @if (isset($routeName))
                <a class="btn btn-secondary btn-export float-right" href="{{ route($routeName,[true]) }}">Export</a>
                @endif
            </h3>
            <table id="myTable" class="table table-striped table-responsive table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="ckbCheckAll">चुने</th>
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
                                <td><input type="checkbox" value="{{ $row->id }}" name="application_id[]"
                                        id="application_id" class="checkBoxClass"></td>
                                <td>{{ $row->applicationNumber }}</td>
                                <td>{{ $row->applicant_name }}</td>
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
                    @endif
                </tbody>
            </table>
            @if ($results->count())
                <div class="form-group col-md-12 d-flex justify-content-center">
                    <button type="button" class="btn btn-primary" onclick="setDateTimeModel()">Set Date</button>
                </div>
            @endif
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
                background-color: #BBD6EC;
            }

            .modal-header {
                background-color: #e96d29;
                padding: 16px 16px;
                color: #FFF;
                border-bottom: 2px dashed #e96d29;
            }
        </style>

        <!-- Modal -->
        <div class="modal fade" id="setDateTimeModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">डॉक्युमेंट वेरिफिकेशन के लिए दिनांक और समय सेट कीजिए
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">दिनांक</label> <span class="text-danger">*</span>
                                <input type="text" class="form-control" name="date" id="date"
                                    placeholder="दिनांक" readonly>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="inputPassword4">समय </label> <span class="text-danger">*</span>
                                <select class="form-control" name="hour" id="hour">
                                    <option value="">घण्टा</option>
                                    <?php
					  for($m=1;$m<=12;$m++)
					  {
						 ?>
                                    <option value="{{ $m }}">{{ $m }}</option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="inputPassword4">&nbsp;</label> <span class="text-danger"></span>
                                <select class="form-control" name="minute" id="minute">
                                    <option value="">मिनट</option>
                                    <?php
					  for($m=0;$m<=59;$m++)
					  {
						  if($m<=9)
						  {
						?>
                                    <option value="0{{ $m }}">0{{ $m }}</option>
                                    <?php }else { ?>
                                    <option value="{{ $m }}">{{ $m }}</option>

                                    <?php } } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="inputPassword4">&nbsp;</label> <span class="text-danger"></span>
                                <select class="form-control" name="ampm" id="ampm">
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submitMe">Submit</button>
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
                    "date": {
                        required: true,
                    },
                    "hour": {
                        required: true,
                    },
                    "minute": {
                        required: true,
                    },
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
