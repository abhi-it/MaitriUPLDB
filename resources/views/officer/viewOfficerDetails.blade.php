@extends('master')
@section('content')
   
    <div class="container main-div" style="background-color:white; height: 100%;">
        <h3 class="text-center m-5 fw-bolder">
            <span data-hi="चयनित आवेदक का विवरण" data-en="Details of Selected Applicants"></span>    
            <div class=" pull-right">
                <a href="javascript:history.back()" class="btn btn-info">
                <span data-hi="पीछे" data-en="Back"></span>    
                </a>
            </div>
        </h3>
        @if (session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <style>
            .form-control-span {
                display: inline;
                width: 100%;
                font-size: 12px;
                line-height: 1.25;
                color: #060ded;
                background-color: #fff;
                background-image: none;
                -webkit-background-clip: padding-box;
                background-clip: padding-box;
                /*border: 1px solid rgba(0,0,0,.15);*/
                border-radius: 0.25rem;
                -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
                -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            }
        </style>

        <!------Summary Page Start---------------->
        <div class="tab1">
        <div class="formone">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="inputEmail4">
                        <span data-hi="मंडल का नाम" data-en="Mandal Name"></span>
                    </label> : {{ $data->mandal_name }}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="जनपद का नाम" data-en="Janpad Name"></span>
                    </label> : {{ $data->janpad_name}}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="लॉगिन आईडी" data-en="Login ID"></span>
                    </label> : {{ $data->login_id }}
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="मोबाइल नंबर" data-en="Mobile Number"></span>
                    </label> : {{ $data->mobile_no }}
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="आधार नंबर" data-en="Aadhar Number"></span>
                    </label> : {{ $data->adhar_no }}
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="ईमेल" data-en="Email"></span>
                    </label> : {{ $data->email }}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4">
                        <span data-hi="अधिकारी का नाम" data-en="Name of Officer"></span>
                    </label> :
                        {{ $data->officer_name}}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4">
                        <span data-hi="पद का नाम" data-en="Designation"></span>
                    </label> : {{ $data->designation }}
                </div>


                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="पशु देखभाल केंद्र" data-en="Animal Care Center"></span>
                    </label> : {{ $data->animal_care_center }}
                </div>

               
            </div>
          </div>  
        </div>
    </div>
    </div>
@endsection
