@extends('zonesMenu')
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
        <span data-hi="Simen स्टॉक फॉर्म" data-en="Simen Stock Form"></span>
    </h3>
    <form method="post" action="{{ route('dfs-stock-save-data') }}" class="form-comman">
        @csrf
        <hr>

        <div class="row">
            
            <!-- field with add more -->
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