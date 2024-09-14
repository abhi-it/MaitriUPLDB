@extends('submaster')
@section('content')
<style>
    .card {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, .125);
        border-radius: 0.25rem;
    }

    .card-body {
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 1.25rem;
    }

    .modal-dialog {
        max-width: 40% !important;
    }
    .openModal{
        display:none;
    }
    .contain-form{
        margin: auto;
        padding: 20px;
    }
</style>
<div class="container main-div">
<h3 class="text-center fw-bold m-4">Service Request Form</h3>
        @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
        @endif
        @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
        @endif
      
    <div class="row">
        
        <div class="col-sm-8 contain-form card">
            <form action="{{route('farmer-request')}}" method="post">
                @csrf
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">Services</label> 
                        <input type="hidden" id="user_id" name="user_id" value="{{Auth::user()->id}}">
                        <select class="form-control" name="services" id="services" required>
                            <option value="">select</option>
                            <optgroup label="Breeding Services">
                                <option value="frozen_semen_ai">Frozen Semen AI</option>
                                <option value="sex_semen_ai">Sex Sorted Semen AI</option>
                                <option value="ivf_embryo">IVF Embryo</option>
                            </optgroup>
                            <option value="health_medical_checkip">Helath/Medical Checkup</option>
                            <option value="animal_insurance">Animal Insurance</option>
                            <option value="vaccination">Vaccination</option>
                            <option value="pregnancy_diagnosis">Pregnancy Diagnosis</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12" id="maiti-div">
                        <label for="inputEmail4">Maitri's</label> 
                        <select class="form-control" name="maitri_id" id="matries" required>
                            @if(count($maitries)>0)
                            <option value="">Select One</option>
                            @foreach($maitries as $val)
                            <option value="{{$val->id}}"> {{ucfirst($val->FirstName)}} {{ucfirst($val->LastName)}}</option>
                            @endforeach
                            @else
                            <option>Data not found</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">Message</label> 
                        <textarea id="request_message" class="form-control"  name="request_message" rows="4" cols="50"></textarea>
                    </div>
                </div>
                <div style="overflow:auto;margin-bottom:20px;">
                    <div style="margin-top: 5px;" >
                        <button type="submit" class="submit btn btn-primary buttonWizard" id="submitForm">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
