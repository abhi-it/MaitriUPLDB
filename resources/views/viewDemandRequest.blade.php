@extends('master')
@section('content')
@php
$distric  =  App\Models\Districts::where([])->select('name_hindi')->pluck('name_hindi')->first();

@endphp
   
    <div class="container main-div" style="background-color:white; height: 100%;">
        <!--First row Start -->

        <h3 class="text-center m-5 fw-bolder">
            <span data-hi="मांग अनुरोध सूची विवरण" data-en="Demand Request List details"></span>    
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
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="inputEmail4">
                        <span data-hi="नाम" data-en="Name"></span>
                    </label> : {{ $data->name }}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="जन्म तिथि" data-en="Date of Birth"></span>
                    </label> : {{ \Carbon\Carbon::parse($data->dob)->format('d-m-Y') }}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="लिंग" data-en="Gender"></span>
                    </label> : {{ $data->gender }}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4">
                        <span data-hi="प्रशिक्षण केंद्र का नाम" data-en="Name of Training Center"></span>
                    </label> :
                        {{ $data->training_center_id}}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4">
                        <span data-hi="भारत पशुधन आईडी" data-en="Bharat Livestock ID"></span>
                    </label> : {{ $data->bharat_pashudhan_id }}
                </div>


                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="ज़िला" data-en="District"></span>
                    </label> : {{ ($data->district)?$distric:'' }}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="विकास खण्ड" data-en="Vikash Khand"></span>
                    </label> : {{ $data->vikas_khand }}
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="पोस्ट ऑफिस" data-en="Post Office"></span>
                    </label> : {{ $data->post_office }}
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="तहसील" data-en="Tehsil"></span>
                    </label> : {{ $data->tehsil }}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                    <span data-hi="एआई सेंटर (पशु चिकित्सा अस्पताल / एलईओ सेंटर)" data-en="AI Centre (Veterinary Hospital / LEO Centre)">
                    </span>        
                </label> : {{ $data->vh_ai_center }}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="आपके भारत पशुधन आईडी पर कितने गांव मैप किए गए हैं?" data-en="How many villages are mapped on your Bharat Pashudhan ID?"></span>
                    </label> :
                        {{ $data->villages_coevring }}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="प्रजाति वीर्य" data-en="Species Semen"></span>
                    </label> : {{ $data->semen }}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputPassword4"><span data-hi="वीर्य प्रकार" data-en="Semen Type"></span> 
                    </label> : {{ $data->semen_type }}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4">
                        <span data-hi="नस्ल" data-en="Breed"></span>
                    </label> : {{ $data->breed }}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4">
                        <span data-hi="कितने पशु टैग की आवश्यकता है?" data-en="How many animal tags are needed?"></span>
                    </label> : {{ $data->animal_tag }}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4">
                        <span data-hi="खनिज मिश्रण" data-en="Mineral mixtures"></span>
                    </label> : {{ $data->mineral_mixture }}
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail4">
                        <span data-hi="व्हाट्सएप मोबाइल नंबर" data-en="WhatsApp Mobile Number"></span>
                    </label> : {{ $data->smart_mobile_no }}
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail4">
                        <span data-hi="तरल नाइट्रोजन (लीटर में)" data-en="Liquid Nitrogen (in Litre)"></span>
                    </label> : {{ $data->demand_section }}
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail4">
                        <span data-hi="गर्भावस्था फ़ीड" data-en="Pregnancy Feed"></span>
                    </label> : {{ $data->pregnancy_feed }}
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail4">
                        <span data-hi="प्रश्न" data-en="Query/Question"></span>
                    </label> : {{ $data->question }}
                </div>
                <div class="form-group col-md-4">
                    <label for="inputEmail4">
                        <span data-hi="वीर्य का स्रोत" data-en="Source of Semen"></span>
                    </label> : {{ $data->semen_source }}
                </div>
            
                <div class="form-group col-md-4">
                    <label for="inputEmail4">
                        <span data-hi="कोई अन्य वस्तु" data-en="Any Other Item"></span>
                    </label> : {{ $data->any_other_item }}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="कोई सुझाव?" data-en="Any Suggestions"></span>
                    </label> : {{ $data->any_suggestion }}
                </div>

                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="कोई शिकायत?" data-en="Any complaints?"></span>
                    </label> : {{$data->any_complaint}}
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="भारत पशुधन पर पंजीकृत गाय बछड़ों की संख्या" data-en="Number of Cow Calves Registered on Bharat Pashudhan"></span>
                    </label> : {{$data->registered_cow_calves}}
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="भारत पशुधन पर पंजीकृत भैंस बछड़ों की संख्या" data-en="Number of Buffalo Calves Registered on Bharat Pashudhan"></span>
                    </label> : {{$data->registered_buffalo_calves}}
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">
                        <span data-hi="भारत पशुधन पर पंजीकृत यौन बछड़ों की संख्या" data-en="Number of SeXed Calves Registered on Bharat Pashudhan"></span>
                    </label> : {{$data->registered_buffalo_calves}}
                </div>

                
            </div>


            


      

        </div>

    </div>


    <!------Summary Page End---------------->



    </div>
@endsection
