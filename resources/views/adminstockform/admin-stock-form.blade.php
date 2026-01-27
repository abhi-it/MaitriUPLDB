@extends('master')
@section('content')
<style>
.d-none {
    display: none;
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
        <span data-hi="एडमिन स्टॉक फॉर्म" data-en="Admin Stock Form"></span>
    </h3>
    <form method="post" action="{{ route('admin-stock-save-data') }}" class="form-comman">
        @csrf
        <hr>

        <div class="row">
            
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="सीमेन डी.एफ.एस. स्टेशन" data-en="Semen DFS Station"></span>
                </label>
                <select name="dfs_station" id="dfs_station" class="form-control" autofocus="">
                    <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                    <option value="DFS Babugarh, Hapur" data-hi="डीएफएस बाबूगढ़, हापुड़" data-en="DFS Babugarh, Hapur">
                    </option>
                    <option value="DFS Rehmankheda, Lucknow" data-hi="डीएफएस रहमानखेड़ा, लखनऊ"
                        data-en="DFS Rehmankheda, Lucknow"></option>
                    <option value="DFS Majra Lakhimpur Kheri" data-hi="डीएफएस माजरा लखीमपुर खीरी"
                        data-en="DFS Majra Lakhimpur Kheri"></option>
                    <option value="ABC Salon" data-hi="एबीसी सैलून" data-en="ABC Salon"></option>
                    <option value="Amul" data-hi="अमूल" data-en="Amul"></option>
                    <option value="BAIF" data-hi="बीएआईएफ़" data-en="BAIF"></option>
                    <option value="Hissar" data-hi="हिसार" data-en="Hissar"></option>
                    <option value="Morna Bio-Technology" data-hi="मोर्ना बायो-टेक्नोलॉजी"
                        data-en="Morna Bio-Technology"></option>
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

            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="तरल नाइट्रोजन (लीटर में)" data-en="Liquid Nitrogen (in Litre)"></span>
                </label>
                <input name="liquid_nitrogen" id="liquid_nitrogen" type="text" class="form-control"
                    data-placeholder-hi="तरल नाइट्रोजन (लीटर में)" data-placeholder-en="Liquid Nitrogen (in Litre)"
                    autofocus>
            </div>

            <!-- New Functionlity Added -->
            <div class="form-group col-md-12 pt-4 main_div_block" style="background: #eee;"> <!-- clone this on click add more -->
                <div class="row"> 
                    <div class="form-group col-md-4">
                        <label>
                            <span data-hi="प्रजाति वीर्य" data-en="Species Semen"></span>
                        </label>
                        <select name="semen[]" class="form-control semen-select" required>
                            <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                            <option value="cow" data-hi="गाय" data-en="Cow"></option>
                            <option value="buffalo" data-hi="भैंस" data-en="Buffalo"></option>
                            <option value="goat" data-hi="बकरी" data-en="Goat"></option>
                        </select>
                    </div>

                    <!-- Breed Type Dropdown -->
                    <div class="form-group col-md-4 catle-options">
                        <label>
                            <span data-hi="नस्ल के प्रकार" data-en="Breed Type"></span>
                        </label>
                        <select name="breedType[]" class="form-control breed-type-select"></select>
                    </div>

                    <!-- Breed  -->
                    <div class="form-group col-md-4 breedType1-options">
                        <label><span data-hi="नस्ल" data-en="Breed"></span></label>
                        <select name="breed[]" class="form-control breed-select"></select>
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
                </div>
            </div>

            <!-- add more here -->

            <div class="form-group col-md-12 text-center">
                <span class="add btn btn-primary btn-sm demand-request-add-btn">Add More</span>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="बैनर(संख्या में)" data-en="Banner(In Numbers)"></span>
                </label>
                <input name="banner" id="banner" type="number" class="form-control" data-placeholder-hi="बैनर"
                    data-placeholder-en="Banner" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="डैंगलर चार्ट (संख्या में)" data-en="Dangler Chart(In Numbers)"></span>
                </label>
                <input name="dangler" id="dangler" type="number" class="form-control"
                    data-placeholder-hi="डैंगलर चार्ट (संख्या में)" data-placeholder-en="Dangler Chart(In Numbers)"
                    autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="स्टैंडी (संख्या में)" data-en="Standee(In Numbers)"></span>
                </label>
                <input name="standee" id="standee" type="number" class="form-control"
                    data-placeholder-hi="स्टैंडी (संख्या में)" data-placeholder-en="Standee(In Numbers)" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="पैम्फलेट (संख्या में)" data-en="Pamphlet(In Numbers)"></span>
                </label>
                <input name="pamphlet" id="pamphlet" type="number" class="form-control"
                    data-placeholder-hi="पैम्फलेट (संख्या में)" data-placeholder-en="Pamphlet(In Numbers)" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="एआई किट (संख्या में)" data-en="AI Kit(In Numbers) "></span>
                </label>
                <input name="ai_kit" id="ai_kit" type="number" class="form-control"
                    data-placeholder-hi="एआई किट (संख्या में)" data-placeholder-en="AI Kit(In Numbers) " autofocus>
            </div>

            <div class="form-group col-md-12 pt-4 container_div_block" style="background: #eee;">
                <div class="row">
                    
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">
                            <span data-hi="कंटेनर क्षमता" data-en="Container Capacity"></span>
                        </label>
                        <select name="container_capacity[]" class="form-control container-capacity" autofocus>
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
                            <span data-hi="कंटेनर(संख्या में)" data-en="Container(In Numbers)"></span>
                        </label>
                        <input name="container_qty[]" type="number" class="form-control container-qty"
                            data-placeholder-hi="कंटेनर(संख्या में)" data-placeholder-en="Container(In Numbers)" autofocus>
                    </div>

                </div>
            </div>

            <!-- add more container here -->

            <div class="form-group col-md-12 text-center">
                <span class="add btn btn-primary btn-sm container-demand-add-btn">Add More</span>
            </div>
            
            <?php /*
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
            </div> */ ?>
        </div>
        <!------Summary Page End---------------->
        <div class="row">
            <div class="mb-4 mt-4 text-centerx">
                <button type="submit" class="btn btn-primary submit buttonWizard">
                    <span data-en="Submit" data-hi="सबमिट"></span>
                </button>
            </div>
        </div>
</div>
<script>
$(document).ready(function() {

    var maxFields = 10;
    var fieldCount = 1;
    $('.demand-request-add-btn').on('click', function () {

        if (fieldCount >= maxFields) {
            alert('You can add maximum ' + maxFields + ' entries.');
            return;
        }

        // check if last block is filled
        var $lastBlock = $('.main_div_block:last');
        var isValid = true;
        $lastBlock.find('select, input').each(function () {
            if ($(this).val() === '') {
                isValid = false;
                return false; // break loop
            }
        });

        if (!isValid) {
            alert('Please fill all fields in the last entry before adding a new one.');
            return;
        }

        var $clone = $('.main_div_block:first').clone();

        // Clear values
        $clone.find('input').val('');
        $clone.find('select').val('');
        $clone.find('.breed-type-select').empty();
        $clone.find('.breed-select').empty();

        // Add remove button if not exists
        if ($clone.find('.demand-request-remove-btn').length === 0) {
            $clone.append(`
                <div class="text-end mt-2">
                    <span class="btn btn-danger btn-sm demand-request-remove-btn">
                        Remove
                    </span>
                </div>
            `);
        }

        // Append clone
        $('.main_div_block:last').after($clone);

        fieldCount++;
    });

    // REMOVE
    $(document).on('click', '.demand-request-remove-btn', function () {
        $(this).closest('.main_div_block').remove();
        fieldCount--;
    });

    $(document).on('change', '.semen-select', function () {

        var $block = $(this).closest('.main_div_block');
        var selectedValue = $(this).val();

        var $breedType = $block.find('.breed-type-select');
        var $breed = $block.find('.breed-select');

        $breedType.empty();
        $breed.empty();

        if (selectedValue) {
            $breedType.append(
                '<option value="">Select one</option>' +
                '<option value="swadeshi">Swadeshi</option>' +
                '<option value="hybrids-crossbred">Hybrids - Crossbred</option>' +
                '<option value="videshi">Videshi</option>'
            );
        }

        switchLang($('.switchlang').val());
    });

    $(document).on('change', '.breed-type-select', function () {

        var $block = $(this).closest('.main_div_block');

        var selectedValue = $(this).val();
        var semenType = $block.find('.semen-select').val();
        var $breed = $block.find('.breed-select');

        $breed.empty();

        // ===== COW =====
        if (selectedValue === 'swadeshi' && semenType === 'cow') {
            $breed.append(
                '<option value="">Select one</option>' +
                '<option value="gangatiri">Gangatiri</option>' +
                '<option value="sahiwal">Sahiwal</option>' +
                '<option value="tharparkar">Tharparkar</option>' +
                '<option value="haryana">Haryana</option>' +
                '<option value="gir">Gir</option>'
            );
        }

        if (selectedValue === 'hybrids-crossbred' && semenType === 'cow') {
            $breed.append(
                '<option value="">Select one</option>' +
                '<option value="jersey-cross">Jersey Cross</option>' +
                '<option value="holstein-friesian-cross">Holstein Friesian Cross</option>'
            );
        }

        if (selectedValue === 'videshi' && semenType === 'cow') {
            $breed.append(
                '<option value="">Select one</option>' +
                '<option value="imported-jersey">Imported Jersey</option>' +
                '<option value="imported-holstein-friesian">Imported Holstein Friesian</option>'
            );
        }

        // ===== BUFFALO =====
        if (selectedValue === 'swadeshi' && semenType === 'buffalo') {
            $breed.append(
                '<option value="">Select one</option>' +
                '<option value="murrah">Murrah</option>' +
                '<option value="bhadawari">Bhadawari</option>'
            );
        }

        if (selectedValue === 'hybrids-crossbred' && semenType === 'buffalo') {
            $breed.append(
                '<option value="">Select one</option>' +
                '<option value="mehsana">Mehsana</option>' +
                '<option value="godavari">Godavari</option>' +
                '<option value="banni">Banni</option>'
            );
        }

        // ===== GOAT =====
        if (selectedValue === 'swadeshi' && semenType === 'goat') {
            $breed.append(
                '<option value="">Select one</option>' +
                '<option value="jamunapari">Jamunapari</option>' +
                '<option value="barbari">Barbari</option>'
            );
        }

        if (selectedValue === 'hybrids-crossbred' && semenType === 'goat') {
            $breed.append(
                '<option value="">Select one</option>' +
                '<option value="boer-goat">Boer Goat</option>' +
                '<option value="saanen">Saanen</option>' +
                '<option value="anglo-nubian">Anglo-Nubian</option>'
            );
        }

        switchLang($('.switchlang').val());
    });


    // ================= CONTAINER ADD MORE =================

    var maxContainers = 10;
    var containerCount = 1;

    $('.container-demand-add-btn').on('click', function () {

        if (containerCount >= maxContainers) {
            alert('You can add maximum ' + maxContainers + ' containers.');
            return;
        }

        // check if last block is filled
        var $lastBlock = $('.container_div_block:last');
        var isValid = true;
        $lastBlock.find('select, input').each(function () {
            if ($(this).val() === '') {
                isValid = false;
                return false; // break loop
            }
        });

        if (!isValid) {
            alert('Please fill all fields in the last container before adding a new one.');
            return;
        }

        var $clone = $('.container_div_block:first').clone();

        // clear values
        $clone.find('input').val('');
        $clone.find('select').val('');

        // add remove button if not exists
        if ($clone.find('.container-remove-btn').length === 0) {
            $clone.append(`
                <div class="text-end mt-2">
                    <span class="btn btn-danger btn-sm container-remove-btn">
                        Remove
                    </span>
                </div>
            `);
        }

        $('.container_div_block:last').after($clone);
        containerCount++;
    });

    // REMOVE container
    $(document).on('click', '.container-remove-btn', function () {
        $(this).closest('.container_div_block').remove();
        containerCount--;
    });

    //================ end ==========================
    

});
</script>

@endsection