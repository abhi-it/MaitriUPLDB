@extends('zonesMenu')
@section('content')
<style>
    .errorclass{
        font-size: 8px;
        color: red;
    }
</style>
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
            <span data-hi="उपलब्ध इन्वेंट्री" data-en="Available Inventroy"></span>
        </h3>

         <table class="table table-striped  table-responsive table-bordered">
            <thead>
                <tr>
                    <th><span data-hi="तरल नाइट्रोजन" data-en="Liquid Nitrogen"></span></th>
                    <th><span data-hi="वीर्य" data-en="Semen"></span></th>
                    <th><span data-hi="वीर्य का प्रकार" data-en="Semen Type"></span></th>
                    <th><span data-hi="बैनर" data-en="Banner"></span></th>
                    <th> <span data-hi="कामचोर" data-en="Dangler"></span></th>
                    <th><span data-hi="स्टैन्डी" data-en="Standee"></span></th>
                    <th><span data-hi="पुस्तिका" data-en="Pamphlet"></span></th>
                    <th> <span data-hi="एआई किट" data-en="AI Kit"></span> </th>
                    <th> <span data-hi="पात्र" data-en="Container"></span> </th>
                    <th> <span data-hi="कंटेनर क्षमता" data-en="Container Capacity"></span> </th>
                    <th> <span data-hi="कायोजनार्रवाई" data-en="Scheme"></span> </th>
                    <th> <span data-hi="बैल पहचान विवरण" data-en="Bull ID Details"></span> </th>
                </tr>
            </thead>
            <tbody>

                @if(count($districtInventory)>0)
                    @foreach ($districtInventory as $key => $stockDistrict)
                        <tr>
                            <td>{{ $stockDistrict->demand_section; }}</td>
                            <td>{{ $stockDistrict->semen }}</td>
                            <td>{{ $stockDistrict->semen_type }}</td>
                            <td>{{ $stockDistrict->banner }}</td>
                            <td>{{ $stockDistrict->dangler }}</td>
                            <td>{{ $stockDistrict->standee }}</td>
                            <td>{{ $stockDistrict->pamphlet }}</td>
                            <td>{{ $stockDistrict->ai_kit }}</td>
                            <td>{{ $stockDistrict->container }}</td>
                            <td>{{ $stockDistrict->container_capacity }}</td>
                            <td>{{ $stockDistrict->scheme }}</td>
                            <td>{{ $stockDistrict->bull_ids }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="12" class="text-center" style="color:red;">No record found..</td>
                    </tr>
                @endif

            </tbody>
        </table>

        <h3 class="text-center fw-bold m-4">
        <span data-hi="ज़िला स्टॉक फॉर्म" data-en="District Stock Form"></span>
         </h3>
         <input type="hidden" name="getUserId" id="getUser_id" value="{{ $user_id }}"/>
        <form method="post" action="{{ route('district-save-stock-data') }}" class="form-comman">
            @csrf
            <hr>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="inputEmail4"> 
                        <span data-hi="AI केंद्र का चयन करें" data-en="Select AI Center"></span> 
                    </label> 
                    <input type="hidden" value="{{ $zone_id }}" name="zone_id" id="zone_id">
                    <input type="hidden" value="{{ $division_id }}" name="division_id">
                    <input type="hidden" value="{{ $district_id }}" name="district_id">
                    <select name="select_aiCenter" id="select_aiCenter" data-type="ai_center" class="form-control" required>
                        
                        @if(count($aiCenters)>0)
                            <option value="" data-hi="AI केंद्र का चयन करें" data-en="Select AI Center"></option>
                            @foreach($aiCenters as $aiCenter)
                                <option value="{{ $aiCenter['id'] }}" data-hi="{{ $aiCenter['name'] }}" data-en="{{ $aiCenter['name_eng'] }}"></option>  
                            @endforeach
                        @else
                            <option value="" data-hi="कोई AI केंद्र नहीं" data-en="No AI Center"></option>
                        @endif
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="तरल नाइट्रोजन (लीटर में)" data-en="Liquid Nitrogen (in Litre)"></span> 
                        <span id="errorDemand" class="errorclass"></span> 
                    </label> 
                    <input name="demand_section" id="demand_section" data-filed_type="demand_section" type="text" class="form-control"  data-placeholder-hi="तरल नाइट्रोजन (लीटर में)" data-placeholder-en="Liquid Nitrogen (in Litre)" autofocus>
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
                        <span id="errorBanner" class="errorclass"></span> 
                    </label> 
                    <input name="banner" min="1" id="banner" data-filed_type="banner" type="number" class="form-control"  data-placeholder-hi="बैनर" data-placeholder-en="Banner" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="डैंगलर चार्ट (संख्या में)" data-en="Dangler Chart(In Numbers)"></span> 
                        <span id="errorDangler" class="errorclass"></span>
                    </label> 
                    <input name="dangler" min="1" id="dangler" data-filed_type="dangler" type="number" class="form-control" data-placeholder-hi="डैंगलर चार्ट (संख्या में)" data-placeholder-en="Dangler Chart(In Numbers)" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="स्टैंडी (संख्या में)" data-en="Standee(In Numbers)"></span> 
                        <span id="errorStandee" class="errorclass"></span>
                    </label> 
                    <input name="standee" min="1" id="standee" data-filed_type="standee" type="number" class="form-control"  data-placeholder-hi="स्टैंडी (संख्या में)" data-placeholder-en="Standee(In Numbers)" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="पैम्फलेट (संख्या में)" data-en="Pamphlet(In Numbers)"></span> 
                        <span id="errorPamphlet" class="errorclass"></span>
                    </label> 
                    <input name="pamphlet" min="1" id="pamphlet" data-filed_type="pamphlet" type="number" class="form-control"  data-placeholder-hi="पैम्फलेट (संख्या में)" data-placeholder-en="Pamphlet(In Numbers)" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="एआई किट (संख्या में)" data-en="AI Kit(In Numbers) "></span>
                        <span id="errorAiKit" class="errorclass"></span> 
                    </label> 
                    <input name="ai_kit" min="1" id="ai_kit" data-filed_type="ai_kit" type="number" class="form-control" data-placeholder-hi="एआई किट (संख्या में)" data-placeholder-en="AI Kit(In Numbers) " autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="कंटेनर(संख्या में)" data-en="Container(In Numbers)"></span> 
                        <span id="errorContainer" class="errorclass"></span> 
                    </label> 
                    <input name="container" min="1" id="container" data-filed_type="container" type="number" class="form-control"  data-placeholder-hi="कंटेनर(संख्या में)" data-placeholder-en="Container(In Numbers)" autofocus>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{ asset('assets/js/checkRemaninngStock.js') }}"></script>
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