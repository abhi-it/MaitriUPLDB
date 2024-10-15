@extends('zonesMenu')
@section('content')
<div class="container main-div py-5" style="background-color:white;">
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
        <h3 class="text-center fw-bold m-4">
        <span data-hi="ब्लॉक स्टॉक फॉर्म" data-en="Block Stock Form"></span>
         </h3>
        <form method="post" action="{{ route('deo-request-save-form-data') }}" class="form-comman">
            @csrf
            <hr>
            
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="inputEmail4"> 
                        <span data-hi="ब्लॉक चुनें" data-en="Select Block"></span> 
                    </label> 
                    <select name="select_block" id="select_block" class="form-control">
                        <option value="" data-hi="ब्लॉक चुनें" data-en="Select Block"></option>
                        <option value="{{ $blockName['id'] }}" data-hi="{{ $blockName['block_hindi'] }}" data-en="{{ $blockName['block_name'] }}"></option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="तरल नाइट्रोजन (लीटर में)" data-en="Liquid Nitrogen (in Litre)"></span> 
                    </label> 
                    <input name="demand_section" id="demand_section" type="text" class="form-control"  data-placeholder-hi="तरल नाइट्रोजन (लीटर में)" data-placeholder-en="Liquid Nitrogen (in Litre)" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="प्रजाति वीर्य" data-en="Species Semen"></span>
                    </label> 
                    <select name="semen" id="semen" class="form-control" autofocus="">
                        <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                        <option value="catle" data-hi="मवेशी" data-en="Cattle"></option>
                        <option value="buffalo" data-hi="भैंस" data-en="Buffalo"></option>
                        <option value="goat" data-hi="बकरी" data-en="Goat"></option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4">  <span data-hi="वीर्य प्रकार" data-en="Semen Type"></span> </label> 
                    <select name="semen_type" id="semen_type" class="form-control" autofocus="">
                        <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                        <option value="conventional" data-hi="सामान्य" data-en="Conventional"></option>
                        <option value="sexed" data-hi="वर्गीकृत" data-en="Sexed"></option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4">  <span data-hi="बुल आई.डी. विवरण" data-en="Bull ID Details"></span> </label> 
                    <div class="row after-add-more">
                        <div class="form-group col-md-9">
                            <input type="text" name="bull_ids[]" id="bull_ids" class="form-control" data-placeholder-hi="बुल आई.डी. विवरण" data-placeholder-en="Bull ID Details" >
                        </div>
                        <div class="form-group col-md-3 change">
                            <a class="btn btn-primary add-more">Add More</a>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="बैनर(संख्या में)" data-en="Banner(In Numbers)"></span> 
                    </label> 
                    <input name="banner" id="banner" type="number" class="form-control"  data-placeholder-hi="बैनर" data-placeholder-en="Banner" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="डैंगलर चार्ट (संख्या में)" data-en="Dangler Chart(In Numbers)"></span> 
                    </label> 
                    <input name="dangler" id="dangler" type="number" class="form-control" data-placeholder-hi="डैंगलर चार्ट (संख्या में)" data-placeholder-en="Dangler Chart(In Numbers)" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="स्टैंडी (संख्या में)" data-en="Standee(In Numbers)"></span> 
                    </label> 
                    <input name="standee" id="standee" type="number" class="form-control"  data-placeholder-hi="स्टैंडी (संख्या में)" data-placeholder-en="Standee(In Numbers)" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="पैम्फलेट (संख्या में)" data-en="Pamphlet(In Numbers)"></span> 
                    </label> 
                    <input name="pamphlet" id="pamphlet" type="number" class="form-control"  data-placeholder-hi="पैम्फलेट (संख्या में)" data-placeholder-en="Pamphlet(In Numbers)" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="एआई किट (संख्या में)" data-en="AI Kit(In Numbers) "></span> 
                    </label> 
                    <input name="ai_kit" id="ai_kit" type="number" class="form-control" data-placeholder-hi="एआई किट (संख्या में)" data-placeholder-en="AI Kit(In Numbers) " autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="कंटेनर(संख्या में)" data-en="Container(In Numbers)"></span> 
                    </label> 
                    <input name="container" id="container" type="number" class="form-control"  data-placeholder-hi="कंटेनर(संख्या में)" data-placeholder-en="Container(In Numbers)" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="कंटेनर क्षमता" data-en="Container Capacity"></span> 
                    </label> 
                    <select name="container_capacity" id="container_capacity"  class="form-control"  autofocus>
                        <option value="" data-hi="एक का चयन करें" data-en="select one"> </option>
                        <option value="BA-0.5" data-en="BA-0.5" data-hi="बीए-0.5" ></option>
                        <option value="BA-1.5" data-en="BA-1.5" data-hi="बीए-1.5" ></option>
                        <option value="BA-3" data-en="BA-3" data-hi="बीए-3" ></option>

                        <option value="BA-20" data-en="BA-20" data-hi="बीए-20" ></option>
                        <option value="BA-35" data-en="BA-35" data-hi="बीए-35" ></option>
                        <option value="J-12" data-en="J-12" data-hi="जे-12" ></option>
                        <option value="J-47" data-en="J-47" data-hi="जे-47" ></option>
                        <option value="TA-55" data-en="TA-55" data-hi="टीए-55" ></option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="योजना" data-en="Scheme"></span> 
                    </label> 
                    <select name="scheme" id="scheme"  class="form-control"  autofocus>
                        <option value="" data-hi="एक का चयन करें" data-en="select one"> </option>
                        <option value="Livestock Insurance" data-en="Livestock Insurance" data-hi="पशुधन बीमा" ></option>
                        <option value="Sexed Semen" data-en="Sexed Semen" data-hi="वर्गीकृत वीर्य" ></option>
                        <option value="AI" data-en="AI" data-hi="ए आई" ></option>
                        <option value="Rashtriya Krishi Vikas Yojna" data-hi="राष्ट्रीय कृषि विकास योजना" data-en="Rashtriya Krishi Vikas Yojna" ></option>
                    </select>
                </div>
            </div>
            <!------Summary Page End---------------->
            <div class="row">
                <div class="mb-4 mt-4 text-center" >
                    <button type="submit" class="btn btn-primary submit buttonWizard">
                        <span data-en="Submit" data-hi="सबमिट"></span>
                    </button>
                </div>
            </div>
</div>
<script>
    $(document).ready(function() {
    $("body").on("click",".add-more",function(){ 
        console.log('hello user')
        var html = $(".after-add-more").first().clone();
          $(html).find(".change").html("<a class='btn btn-danger remove text-white'> Remove</a>");
        $(".after-add-more").last().after(html);
    });
    $("body").on("click",".remove",function(){ 
        $(this).parents(".after-add-more").remove();
    });
});
</script>

@endsection 