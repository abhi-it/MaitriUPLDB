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
            <span data-hi="उपलब्ध इन्वेंट्री" data-en="Available Inventory"></span>
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

                @if(count($deoStock)>0)
                    @foreach ($deoStock as $key => $stockDeo)
                        <tr>
                            <td>{{ $stockDeo->demand_section; }}</td>
                            <td>{{ $stockDeo->semen }}</td>
                            <td>{{ $stockDeo->semen_type }}</td>
                            <td>{{ $stockDeo->banner }}</td>
                            <td>{{ $stockDeo->dangler }}</td>
                            <td>{{ $stockDeo->standee }}</td>
                            <td>{{ $stockDeo->pamphlet }}</td>
                            <td>{{ $stockDeo->ai_kit }}</td>
                            <td>{{ $stockDeo->container }}</td>
                            <td>{{ $stockDeo->container_capacity }}</td>
                            <td>{{ $stockDeo->scheme }}</td>
                            <td>{{ $stockDeo->bull_ids }}</td>
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
        <span data-hi="वितरण प्रपत्र" data-en="Distribution form"></span>
         </h3>
        <form method="post" action="{{ route('deo-save-stock-data') }}" class="form-comman">
            @csrf
            <hr>
            
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="AI केंद्र का चयन करें" data-en="Select AI Center"></span> 
                    </label> 
                    
                    <select name="select_aicenter" id="select_aicenter" class="form-control" required>
                        <option value="" data-hi="AI केंद्र का चयन करें" data-en="Select AI Center"></option>
                        @foreach($ai_centerName as $aiCenterName)
                            <option value="{{ $aiCenterName['id'] }}" data-hi="{{ $aiCenterName['name_hindi'] }}" data-en="{{ $aiCenterName['name_eng'] }}"></option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="मैत्री चुनें" data-en="Select Maitri"></span> 
                    </label> 
                    
                    <select name="select_maitri" id="select_maitri" class="form-control" required>
                        <option value="" data-hi="मैत्री चुनें" data-en="Select Maitri"></option>
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
                        <option value="catle" data-hi="गाय" data-en="Cattle"></option>
                        <option value="buffalo" data-hi="भैंस" data-en="Buffalo"></option>
                        <option value="goat" data-hi="बकरी" data-en="Goat"></option>
                    </select>
                </div>
                <!-- New Dropdown Add -->
                    
                <div class="form-group col-md-6 catle-options d-none">
                    <label for="breed">
                        <span data-hi="नस्ल" data-en="Breed"></span>
                    </label>
                    <select name="breed" id="breed" class="form-control">
                        <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                        <option value="swadeshi" data-hi="स्वदेशी" data-en="Swadeshi"></option>
                        <option value="hybrids-crossbred" data-hi="संकर" data-en="Hybrids - Crossbred"></option>
                        <option value="videshi" data-hi="विदेशी" data-en="Videshi"></option>
                    </select>
                </div>

                <!-- Breed Types 1 (for Swadeshi) -->
                <div class="form-group col-md-6 d-none" id="breedType1-options">
                    <label for="breedType1">
                        <span data-hi="नस्ल के प्रकार" data-en="Breed Type"></span>
                    </label>
                    <select name="breedType1" id="breedType1" class="form-control">
                        <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                        <option value="gangatiri" data-hi="गंगातिरी" data-en="Gangatiri"></option>
                        <option value="gir" data-hi="गिर" data-en="Gir"></option>
                        <option value="tharparkar" data-hi="थारपारकर" data-en="Tharparkar"></option>
                        <option value="haryana" data-hi="हरयाणा" data-en="Haryana"></option>
                    </select>
                </div>
                

                <!-- Breed Types 2 (for Hybrids - Crossbred) -->
                <div class="form-group col-md-6 d-none" id="breedType2-options">
                    <label for="breedType2">
                        <span data-hi="नस्ल के प्रकार" data-en="Breed Type"></span>
                    </label>
                    <select name="breedType2" id="breedType2" class="form-control">
                        <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                        <option value="jersey-cross" data-hi="जर्सी क्रॉस" data-en="Jersey Cross"></option>
                        <option value="holstein-friesian-cross" data-hi="होल्स्टीन फ़्रीज़ियन क्रॉस" data-en="Holstein Friesian Cross"></option>
                    </select>
                </div>
                

                <!-- Breed Types 3 (for Videshi) -->
                <div class="form-group col-md-6 d-none" id="breedType3-options">
                    <label for="breedType3">
                        <span data-hi="नस्ल के प्रकार" data-en="Breed Type"></span>
                    </label>
                    <select name="breedType3" id="breedType3" class="form-control">
                        <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                        <option value="imported-jersey" data-hi="आयातित जर्सी" data-en="Imported Jersey"></option>
                        <option value="imported-holstein-friesian" data-hi="होल्स्टीन फ़्रीज़ियन क्रॉस" data-en="Imported Holstein Friesian"></option>
                        <option value="Jersey" data-hi="जर्सी" data-en="Jersey"></option>
                        <option value="holstein-friesian" data-hi="होल्स्टीन फ़्रीज़ियन" data-en="Holstein Friesian"></option>
                    </select>
                </div>
               
                
                <div class="form-group col-md-6 d-none" id="buffalo-options">
                    <label for="breedType4">
                        <span data-hi="नस्ल" data-en="Breed"></span>
                    </label>
                    <select name="breedType4" id="breedType4" class="form-control">
                        <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                        <option value="murrah" data-hi="मुर्रा" data-en="Murrah"></option>
                        <option value="bhadawari" data-hi="भदावारी" data-en="Bhadawari"></option>
                    </select>
                </div>  
               
                <div class="form-group col-md-6 d-none" id="goat-options">
                    <label for="breedType5">
                        <span data-hi="नस्ल" data-en="Breed"></span>
                    </label>
                    <select name="breedType5" id="breedType5" class="form-control">
                        <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                        <option value="jamunapari" data-hi="जमुनापारी" data-en="Jamunapari"></option>
                        <option value="barbari" data-hi="बारबरी" data-en="Barbari"></option>
                        <option value="Sirohi" data-hi="सिरोही" data-en="Sirohi"></option>
                        <option value="black-bengal" data-hi="ब्लैक बंगाल" data-en="Black Bengal"></option>
                        <option value="jakhrana" data-hi="ब्लैक बंगाल" data-en="Jakhrana"></option>
                        <option value="saanen" data-hi="बसानेन" data-en="Saanen"></option>
                    </select>
                </div>
                
                <!-- New Dropdown End -->
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
                    <input name="banner" min="0" id="banner" type="number" class="form-control"  data-placeholder-hi="बैनर" data-placeholder-en="Banner" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="डैंगलर चार्ट (संख्या में)" data-en="Dangler Chart(In Numbers)"></span> 
                    </label> 
                    <input name="dangler" min="0" id="dangler" type="number" class="form-control" data-placeholder-hi="डैंगलर चार्ट (संख्या में)" data-placeholder-en="Dangler Chart(In Numbers)" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="स्टैंडी (संख्या में)" data-en="Standee(In Numbers)"></span> 
                    </label> 
                    <input name="standee" min="0" id="standee" type="number" class="form-control"  data-placeholder-hi="स्टैंडी (संख्या में)" data-placeholder-en="Standee(In Numbers)" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="पैम्फलेट (संख्या में)" data-en="Pamphlet(In Numbers)"></span> 
                    </label> 
                    <input name="pamphlet" min="0" id="pamphlet" type="number" class="form-control"  data-placeholder-hi="पैम्फलेट (संख्या में)" data-placeholder-en="Pamphlet(In Numbers)" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="एआई किट (संख्या में)" data-en="AI Kit(In Numbers) "></span> 
                    </label> 
                    <input name="ai_kit" min="0" id="ai_kit" type="number" class="form-control" data-placeholder-hi="एआई किट (संख्या में)" data-placeholder-en="AI Kit(In Numbers) " autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                        <span data-hi="कंटेनर(संख्या में)" data-en="Container(In Numbers)"></span> 
                    </label> 
                    <input name="container" min="0" id="container" type="number" class="form-control"  data-placeholder-hi="कंटेनर(संख्या में)" data-placeholder-en="Container(In Numbers)" autofocus>
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

        $('#select_aicenter').change(function() {
            var aiCenterID = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ route('search-maitri-data') }}",
                dataType: 'json',
                data: { id: aiCenterID },
                success: function (result) {
                    // Clear existing options in select_maitri
                    $('#select_maitri').empty();

                    // Check if data is returned successfully
                    if (result.success && result.type === 'maitri' && result.success != '') {
                        // Populate select_maitri with new options
                        $.each(result.success, function(index, maitri) {
                            // Add new options with the required value and text
                            $('#select_maitri').append(
                                $('<option></option>').val(maitri.id).text('Name: '+maitri.maitri_name+'(Num: '+ maitri.maitri_mobile_no +', Bharat Pashudhan Id: '+ maitri.any_bharat_id +', Longitude: '+ maitri.longitude +', Latitude: '+ maitri.latitude +')')
                            );
                        });
                    } else {
                        // Optionally handle case when no data is returned
                        $('#select_maitri').append(
                            $('<option></option>').text('No Maitri available').prop('disabled', true)
                        );
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching data: " + error);
                }
            });
        })

        $('#semen').change(function() {
            var selectedValue = $(this).val();
            $('.catle-options').addClass('d-none');
            $('#buffalo-options').addClass('d-none');
            $('#goat-options').addClass('d-none');
            
            // Show relevant dropdowns based on the selection
            if (selectedValue === 'catle') {
                $('.catle-options').removeClass('d-none');
            } else if (selectedValue === 'buffalo') {
                $('#buffalo-options').removeClass('d-none');
            } else if (selectedValue === 'goat') {
                $('#goat-options').removeClass('d-none');
            }

            $('#breedType1-options, #breedType2-options, #breedType3-options').addClass('d-none');
        });

        $('#breed').change(function() {
            var selectedBreed = $(this).val();
            $('#breedType1-options').addClass('d-none');
            $('#breedType2-options').addClass('d-none');
            $('#breedType3-options').addClass('d-none');
            
            // Show relevant breed type dropdowns based on Breed selection
            if (selectedBreed === 'swadeshi') {
                $('#breedType1-options').removeClass('d-none');
            } else if (selectedBreed === 'hybrids-crossbred') {
                $('#breedType2-options').removeClass('d-none');
            } else if (selectedBreed === 'videshi') {
                $('#breedType3-options').removeClass('d-none');
            }
        });

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