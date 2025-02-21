@extends('zonesMenu')
@section('content')

<style>
.errorclass {
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
        <span data-hi="उपलब्ध इन्वेंट्री" data-en="Available Inventory"></span>
    </h3>

    <table class="table table-striped  table-responsive table-bordered">
        <thead>
            <tr>
                <th><span data-hi="तरल नाइट्रोजन" data-en="Liquid Nitrogen"></span></th>
                <th><span data-hi="वीर्य" data-en="Semen"></span></th>
                <th><span data-hi="वीर्य स्ट्रॉस" data-en="Semen Straws"></span></th>
                <th><span data-hi="वीर्य का प्रकार" data-en="Semen Type"></span></th>
                <th><span data-hi="बैनर" data-en="Banner"></span></th>
                <th> <span data-hi="डैंगलर" data-en="Dangler"></span></th>
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

            @if(count($zoneInventory)>0)
            @foreach ($zoneInventory as $key => $stockZone)
            <tr>
                <td>{{ $stockZone->demand_section; }}</td>
                <td>{{ $stockZone->semen }}</td>
                <td>{{ $stockZone->semen_straws }}</td>
                <td>{{ $stockZone->semen_type }}</td>
                <td>{{ $stockZone->banner }}</td>
                <td>{{ $stockZone->dangler }}</td>
                <td>{{ $stockZone->standee }}</td>
                <td>{{ $stockZone->pamphlet }}</td>
                <td>{{ $stockZone->ai_kit }}</td>
                <td>{{ $stockZone->container }}</td>
                <td>{{ $stockZone->container_capacity }}</td>
                <td>{{ $stockZone->scheme }}</td>
                <td>{{ $stockZone->bull_ids }}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="13" class="text-center" style="color:red;">No record found..</td>
            </tr>
            @endif

        </tbody>
    </table>

    <h3 class="text-center fw-bold m-4">
        <span data-hi="वितरण स्टॉक फॉर्म" data-en="Distribution Stock Form"></span>
    </h3>

    <input type="hidden" name="getUserId" id="getUser_id" value="{{ $user_id }}" />
    <form method="post" action="{{ route('save-division-stock-data') }}" class="form-comman">
        @csrf
        <hr>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="inputEmail4">
                    <span data-hi="जिला चुनें" data-en="Select District"></span>
                </label>
                <input type="hidden" value="{{ $zone_id }}" id="zone_id" name="zone_id">
                <select name="select_district" id="select_district" data-type="district" class="form-control">
                    <option value="" data-hi="जिला चुनें" data-en="Select District"></option>
                    @foreach($districtName as $districts)
                    <option value="{{ $districts['id'] }}" data-hi="{{ $districts['name_hindi'] }}"
                        data-en="{{ $districts['name_eng'] }}"></option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="तरल नाइट्रोजन (लीटर में)" data-en="Liquid Nitrogen (in Litre)"></span>
                    <span id="errorDemand" class="errorclass"></span>
                </label>
                <input name="demand_section" id="demand_section" data-filed_type="demand_section" type="text"
                    class="form-control" data-placeholder-hi="तरल नाइट्रोजन (लीटर में)"
                    data-placeholder-en="Liquid Nitrogen (in Litre)" autofocus>
            </div>
            <!-- New Functionlity Added -->
            <div class="form-group col-md-12 pt-4 main_div_block" style="background: #eee;">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>
                            <span data-hi="प्रजाति वीर्य" data-en="Species Semen"></span>
                        </label>
                        <select name="semen[]" class="form-control semen-select">
                            <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                            <option value="catle" data-hi="गाय" data-en="Cow"></option>
                            <option value="buffalo" data-hi="भैंस" data-en="Buffalo"></option>
                            <option value="goat" data-hi="बकरी" data-en="Goat"></option>
                        </select>
                    </div>

                    <!-- Cattle Dropdown -->
                    <div class="form-group col-md-4 catle-options d-none">
                        <label>
                            <span data-hi="नस्ल" data-en="Breed"></span>
                        </label>
                        <select name="breed[]" class="form-control breed-select">
                            <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                            <option value="swadeshi" data-hi="स्वदेशी" data-en="Swadeshi"></option>
                            <option value="hybrids-crossbred" data-hi="संकर" data-en="Hybrids - Crossbred"></option>
                            <option value="videshi" data-hi="विदेशी" data-en="Videshi"></option>
                        </select>
                    </div>

                    <!-- Breed Types -->
                    <div class="form-group col-md-4 breedType1-options d-none">
                        <label><span data-hi="नस्ल के प्रकार" data-en="Breed Type"></span></label>
                        <select name="breedType1[]" class="form-control">
                            <option value="">Select one</option>
                            <option value="gangatiri">Gangatiri</option>
                            <option value="sahiwal">Sahiwal</option>
                            <option value="gir">Gir</option>
                            <option value="tharparkar">Tharparkar</option>
                            <option value="haryana">Haryana</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4 breedType2-options d-none">
                        <label><span data-hi="नस्ल के प्रकार" data-en="Breed Type"></span></label>
                        <select name="breedType2[]" class="form-control">
                            <option value="">Select one</option>
                            <option value="jersey-cross">Jersey Cross</option>
                            <option value="holstein-friesian-cross">Holstein Friesian Cross</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4 breedType3-options d-none">
                        <label><span data-hi="नस्ल के प्रकार" data-en="Breed Type"></span></label>
                        <select name="breedType3[]" class="form-control">
                            <option value="">Select one</option>
                            <option value="imported-jersey">Imported Jersey</option>
                            <option value="imported-holstein-friesian">Imported Holstein Friesian</option>
                        </select>
                    </div>

                    <!-- Buffalo Dropdown -->
                    <div class="form-group col-md-4 buffalo-options d-none">
                        <label><span data-hi="नस्ल" data-en="Breed"></span></label>
                        <select name="breedType4[]" class="form-control">
                            <option value="">Select one</option>
                            <option value="murrah">Murrah</option>
                            <option value="bhadawari">Bhadawari</option>
                        </select>
                    </div>

                    <!-- Goat Dropdown -->
                    <div class="form-group col-md-4 goat-options d-none">
                        <label><span data-hi="नस्ल" data-en="Breed"></span></label>
                        <select name="breedType5[]" class="form-control">
                            <option value="">Select one</option>
                            <option value="jamunapari">Jamunapari</option>
                            <option value="barbari">Barbari</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span data-hi="वीर्य प्रकार" data-en="Semen Type"></span></label>
                        <select name="semen_type[]" class="form-control">
                            <option value="">Select one</option>
                            <option value="conventional">Conventional</option>
                            <option value="sexed">Sexed</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span data-hi="बुल आई.डी." data-en="Bull ID"></span></label>
                        <input name="bull_id[]" type="text" required class="form-control" placeholder="Bull ID">
                    </div>

                    <div class="form-group col-md-4">
                        <label><span data-hi="वीर्य स्ट्रॉस मात्रा" data-en="Semen Straws Quantity"></span></label>
                        <input name="semen_straws[]" type="number" min="1" class="form-control"
                            placeholder="Semen Straws Quantity">
                    </div>

                    <div class="form-group col-md-12 text-center">
                        <span class="add btn btn-primary btn-sm demand-request-add-btn">Add More</span>
                    </div>
                </div>
            </div>
            <!-- New Functionlity End Code -->
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="बैनर(संख्या में)" data-en="Banner(In Numbers)"></span>
                    <span id="errorBanner" class="errorclass"></span>
                </label>
                <input name="banner" min="0" id="banner" data-filed_type="banner" type="number" class="form-control"
                    data-placeholder-hi="बैनर" data-placeholder-en="Banner" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="डैंगलर चार्ट (संख्या में)" data-en="Dangler Chart(In Numbers)"></span>
                    <span id="errorDangler" class="errorclass"></span>
                </label>
                <input name="dangler" min="0" id="dangler" data-filed_type="dangler" type="number" class="form-control"
                    data-placeholder-hi="डैंगलर चार्ट (संख्या में)" data-placeholder-en="Dangler Chart(In Numbers)"
                    autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="स्टैंडी (संख्या में)" data-en="Standee(In Numbers)"></span>
                    <span id="errorStandee" class="errorclass"></span>
                </label>
                <input name="standee" min="0" id="standee" data-filed_type="standee" type="number" class="form-control"
                    data-placeholder-hi="स्टैंडी (संख्या में)" data-placeholder-en="Standee(In Numbers)" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="पैम्फलेट (संख्या में)" data-en="Pamphlet(In Numbers)"></span>
                    <span id="errorPamphlet" class="errorclass"></span>
                </label>
                <input name="pamphlet" min="0" id="pamphlet" data-filed_type="pamphlet" type="number"
                    class="form-control" data-placeholder-hi="पैम्फलेट (संख्या में)"
                    data-placeholder-en="Pamphlet(In Numbers)" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="एआई किट (संख्या में)" data-en="AI Kit(In Numbers) "></span>
                    <span id="errorAiKit" class="errorclass"></span>
                </label>
                <input name="ai_kit" min="0" id="ai_kit" data-filed_type="ai_kit" type="number" class="form-control"
                    data-placeholder-hi="एआई किट (संख्या में)" data-placeholder-en="AI Kit(In Numbers) " autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="कंटेनर(संख्या में)" data-en="Container(In Numbers)"></span>
                    <span id="errorContainer" class="errorclass"></span>
                </label>
                <input name="container" min="0" id="container" data-filed_type="container" type="number"
                    class="form-control" data-placeholder-hi="कंटेनर(संख्या में)"
                    data-placeholder-en="Container(In Numbers)" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="कंटेनर क्षमता" data-en="Container Capacity"></span>
                </label>
                <select name="container_capacity" id="container_capacity" class="form-control" autofocus>
                    <option value="" data-hi="एक का चयन करें" data-en="select one"> </option>
                    <option value="BA-0.5" data-en="BA-0.5" data-hi="बीए-0.5"></option>
                    <option value="BA-1.5" data-en="BA-1.5" data-hi="बीए-1.5"></option>
                    <option value="BA-3" data-en="BA-3" data-hi="बीए-3"></option>

                    <option value="BA-20" data-en="BA-20" data-hi="बीए-20"></option>
                    <option value="BA-35" data-en="BA-35" data-hi="बीए-35"></option>
                    <option value="J-12" data-en="J-12" data-hi="जे-12"></option>
                    <option value="J-47" data-en="J-47" data-hi="जे-47"></option>
                    <option value="TA-55" data-en="TA-55" data-hi="टीए-55"></option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="योजना" data-en="Scheme"></span>
                </label>
                <select name="scheme" id="scheme" class="form-control" autofocus>
                    <option value="" data-hi="एक का चयन करें" data-en="select one"> </option>
                    <option value="Livestock Insurance" data-en="Livestock Insurance" data-hi="पशुधन बीमा"></option>
                    <option value="Sexed Semen" data-en="Sexed Semen" data-hi="वर्गीकृत वीर्य"></option>
                    <option value="AI" data-en="AI" data-hi="ए आई"></option>
                    <option value="Rashtriya Krishi Vikas Yojna" data-hi="राष्ट्रीय कृषि विकास योजना"
                        data-en="Rashtriya Krishi Vikas Yojna"></option>
                </select>
            </div>
        </div>
        <!------Summary Page End---------------->
        <div class="row">
            <div class="mb-4 mt-4 text-center">
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

    var maxFields = 6;
    var fieldCount = 1;
    $('.demand-request-add-btn').click(function() {
        if (fieldCount < maxFields) {
            var clone = $('.main_div_block:first').clone();

            // Reset input/select values in cloned div
            clone.find('input, select').val('');
            clone.find(
                '.catle-options, .buffalo-options, .goat-options, .breedType1-options, .breedType2-options, .breedType3-options'
            ).addClass('d-none');

            // Add remove button only for new cloned fields
            clone.append(
                '<div class="form-group col-md-12 text-center"><span class="demand-request-remove-btn btn btn-danger btn-sm">Remove</span></div>'
            );

            clone.find('.demand-request-add-btn').remove();
            $('.main_div_block:last').after(clone);
            fieldCount++;

            if (fieldCount === maxFields) {
                $('.demand-request-add-btn').hide(); // Hide "Add More" button when max reached
            }
        }
    });

    $(document).on('click', '.demand-request-remove-btn', function() {
        $(this).closest('.main_div_block').remove();
        fieldCount--;

        if (fieldCount < maxFields) {
            $('.demand-request-add-btn').show(); // Show "Add More" button if less than max
        }
    });

    $(document).on('change', '.semen-select', function() {
        var selectedValue = $(this).val();
        var parentDiv = $(this).closest('.main_div_block');

        parentDiv.find('.catle-options, .buffalo-options, .goat-options').addClass('d-none');

        if (selectedValue === 'catle') {
            parentDiv.find('.catle-options').removeClass('d-none');
        } else if (selectedValue === 'buffalo') {
            parentDiv.find('.buffalo-options').removeClass('d-none');
        } else if (selectedValue === 'goat') {
            parentDiv.find('.goat-options').removeClass('d-none');
        }

        parentDiv.find('.breedType1-options, .breedType2-options, .breedType3-options').addClass(
            'd-none');
    });

    $(document).on('change', '.breed-select', function() {
        var selectedBreed = $(this).val();
        var parentDiv = $(this).closest('.main_div_block');

        parentDiv.find('.breedType1-options, .breedType2-options, .breedType3-options').addClass(
            'd-none');

        if (selectedBreed === 'swadeshi') {
            parentDiv.find('.breedType1-options').removeClass('d-none');
        } else if (selectedBreed === 'hybrids-crossbred') {
            parentDiv.find('.breedType2-options').removeClass('d-none');
        } else if (selectedBreed === 'videshi') {
            parentDiv.find('.breedType3-options').removeClass('d-none');
        }
    });

});
</script>

@endsection