@extends('master')
@section('content')
<style>

    .custom-class{
        border: 0;
        border-bottom: 1px solid;
        width: 60%;
        text-align: center
    }
    .form-comman .form-group label {
  display: block;
  clear: both;
}
.form-comman .form-group input, .form-comman .form-group select {
  background: #fff;
  width: 100%;
  text-align: left;
  outline: none;
  border: 1px solid #ccc;
  padding: 10px;
  border-radius: 9px;
}
     .inner-form-container {
        width: 100%;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 50px;
    }
</style>
<div class="container main-div py-5" >
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
        <h3 style="margin-top:10px;text-align: center;">
            <span data-hi="रिफ्रेशर प्रशिक्षण फॉर्म" data-en="Refresher Training Form"></span>
        </h3>
        <hr>
        <form method="post" action="{{ route('training-requests') }}" class="form-comman">
            @csrf
            <div class="inner-form-container">
            <div class="row">
                
                <h5><span data-hi="प्रशिक्षण तिथि" data-en="Training Date"></span></h5>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="से तिथि" data-en="From Date"></span>
                    </label> 
                    <input type="date" class="form-comman" name="from_date" id="from_date" required  autocomplete="off" >
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="तक तिथि" data-en="To Date"></span>
                    </label> 
                    <input type="date" class="form-comman" name="to_date" id="to_date"  required  autocomplete="off" >
                </div>


                <h5><span data-hi="अवधि" data-en="Duration"></span></h5>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="दिन" data-en="Days"></span>
                    </label> 
                    <input type="text" class="form-comman" name="days" id="days" required  autocomplete="off" >
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="महीने" data-en="Months"></span>
                    </label> 
                    <input type="text" class="form-comman" name="months" id="months"  required  autocomplete="off" >
                </div>

                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="संस्थान" data-en="Institute"></span>
                    </label> 
                    <input type="text" class="form-comman" name="institute" id="institute" required  autocomplete="off" >
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="जिला" data-en="District "></span>
                    </label> 
                    <input type="text" class="form-comman" name="district" id="district"  required  autocomplete="off" >
                </div>

                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="एआई केंद्र" data-en="AI Center"></span>
                    </label> 
                    <select name="ai_center" id="ai_center"  class="form-comman" required  autocomplete="off">
                        <option value="">कोई भी एक चुनें</option>
                        @if(count($ai)>0)
                            @foreach($ai as $center)
                            <option value="{{$center->name}}">{{$center->name}}</option>
                            @endforeach
                        @endif
                    </select>
                   
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="अस्पताल" data-en="Hospital "></span>
                    </label> 
                    <select name="hospital" id="hospital"  class="form-comman" required  autocomplete="off">
                        <option value="">कोई भी एक चुनें</option>
                        @if(count($vh)>0)
                            @foreach($vh as $center)
                            <option value="{{$center->name}}">{{$center->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <h5><span data-hi="भरत पशुधन पर भोजन कराया" data-en="Feeding done on Bharat Pashudhan"></span></h5>
                <div class="form-group col-md-4">
                    <label for="inputEmail4"> 
                        <span data-hi="एआई" data-en="AI "></span>
                    </label> 
                    <input type="text" class="form-comman" name="ai" id="ai"  required  autocomplete="off" >
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail4"> 
                        <span data-hi="पीडी" data-en="PD "></span>
                    </label> 
                    <input type="text" class="form-comman" name="pd" id="pd"  required  autocomplete="off" >
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail4"> 
                        <span data-hi="बछड़ा" data-en="Calving "></span>
                    </label> 
                    <input type="text" class="form-comman" name="calving" id="calving"  required  autocomplete="off" >
                </div>
                <div class="form-group col-md-12">
                    <label for="inputEmail4"> 
                        <span data-hi="मौजूदा भारत पशुधन आईडी" data-en="Existing Bharat Pashudhan ID "></span>
                    </label> 
                    <input type="text" class="form-comman" name="bharat_pshudhan_id" id="bharat_pshudhan_id"  required  autocomplete="off" >
                </div>

            
            </div>
            <!------Summary Page End---------------->
            <div class="row">
                <div class="mb-4 mt-4 text-center" >
                    <button type="submit" class="btn btn-primary submit buttonWizard">Submit</button>
                </div>
            </div>
            </div>
        </form>
</div>
@endsection 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script src="{{ asset('') }}js/google_Jsapi.js" type="text/javascript"></script>
    <script type="text/javascript">
    
</script>
