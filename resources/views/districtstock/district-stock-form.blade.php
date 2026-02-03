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

    <table id="my-new-table" class="table table-striped table-responsive table-bordered">
        <thead>
            <tr>
                <th><span data-hi="S.No" data-en="S.No"></span></th>
                <th><span data-hi="Item" data-en="Item"></span></th>
                <th><span data-hi="Quantity" data-en="Quantity"></span></th>
            </tr>
        </thead>
        <tbody>
            <?php //echo "<pre>"; print_r($finalStocks->toArray()); exit; ?>
            @if(count($finalStocks) > 0)
            @foreach ($finalStocks as  $stockAdmin)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <?php if ($stockAdmin['item_type'] == 'species_semen') { ?>
                        <b>{{ $stockAdmin['item_name'] }} :</b> {{ $stockAdmin['species_semen'] }} <br>
                        <b>Breed Type :</b> {{ $stockAdmin['breed_type'] }} <br>
                        <b>Breed :</b> {{ $stockAdmin['breed'] }} <br>
                        <b>Semen Type :</b> {{ $stockAdmin['semen_type'] }} <br>
                        <b>Bull ID:</b> {{ $stockAdmin['bull_id'] }}
                        <input type="hidden" 
                            class="stock-item"
                            data-type="species_semen"
                            data-semen="{{ $stockAdmin['species_semen'] }}"
                            data-breedtype="{{ $stockAdmin['breed_type'] }}"
                            data-breed="{{ $stockAdmin['breed'] }}"
                            data-sementype="{{ $stockAdmin['semen_type'] }}"
                            data-bull="{{ $stockAdmin['bull_id'] }}"
                            value="{{$stockAdmin['remaining_qty']}}">

                    <?php } else if ($stockAdmin['item_type'] == 'container') { ?>
                        {{ $stockAdmin['item_name'] }} - ({{ $stockAdmin['container_capacity'] }})
                        <input type="hidden" 
                            class="stock-item"
                            data-type="container"
                            data-capacity="{{ $stockAdmin['container_capacity'] }}"
                            value="{{$stockAdmin['remaining_qty']}}">
                    <?php } else { ?>
                        {{ $stockAdmin['item_name'] }}
                        <input type="hidden"
                            class="stock-item"
                            data-type="{{ $stockAdmin['item_type'] }}"
                            value="{{ $stockAdmin['remaining_qty'] }}">
                    <?php } ?>
                </td>

                <td>{{ $stockAdmin['remaining_qty'] }}</td>

            </tr>
            @endforeach
            @endif
        </tbody>
    </table>

    <h3 class="text-center fw-bold m-4">
        <span data-hi="ज़िला स्टॉक फॉर्म" data-en="District Stock Form"></span>
    </h3>
    <form method="post" action="{{ route('district-save-stock-data') }}" class="form-comman">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user_id }}" />
        <input type="hidden" name="zone_id" value="{{ $zone_id }}">
        <input type="hidden" name="division_id" value="{{ $division_id }}">
        <input type="hidden" name="district_id" value="{{ $district_id }}">
        <hr>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="AI केंद्र का चयन करें" data-en="Select AI Center"></span>
                </label>
                <select name="select_aiCenter" id="select_aiCenter" data-type="ai_center" class="form-control" required>
                    @if(count($aiCenters)>0)
                    <option value="" data-hi="AI केंद्र का चयन करें" data-en="Select AI Center"></option>
                    @foreach($aiCenters as $aiCenter)
                    @php if($aiCenter['aicenter'] != ''){ @endphp
                    <option value="{{ $aiCenter['id'] }}" data-hi="{{ $aiCenter['aicenter'] }}"
                        data-en="{{ $aiCenter['aicenter'] }}"></option>
                    @php } @endphp
                    @endforeach
                    @else
                    <option value="" data-hi="कोई AI केंद्र नहीं" data-en="No AI Center"></option>
                    @endif
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="आपूर्ति तिथि" data-en="Supply Date"></span>
                </label>
                <input name="supply_date" id="selectDate_supply" data-filed_type="selectDate_supply" type="date"
                    class="form-control" autofocus>
            </div>

            <div class="form-group col-md-12">
                <label for="inputEmail4">
                    <span data-hi="तरल नाइट्रोजन (लीटर में)" data-en="Liquid Nitrogen (in Litre)"></span>
                </label>
                <small id="liquid_nitrogen_msg" style="color:red"></small>
                <input name="liquid_nitrogen" id="dist_liquid_nitrogen" data-filed_type="demand_section" type="text"
                    class="form-control" data-placeholder-hi="तरल नाइट्रोजन (लीटर में)"
                    data-placeholder-en="Liquid Nitrogen (in Litre)" onkeyup="validateSimpleStock(this, 'liquid_nitrogen')">
            </div>
            

            <!-- Semen Functionlity with add more -->
            <div class="form-group col-md-12 pt-4 main_div_block" style="background: #eee;">
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
                <input name="banner" id="dist_banner" type="number" class="form-control" data-placeholder-hi="बैनर"
                    data-placeholder-en="Banner" onkeyup="validateSimpleStock(this, 'banner')">
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="डैंगलर चार्ट (संख्या में)" data-en="Dangler Chart(In Numbers)"></span>
                </label>
                <input name="dangler" id="dist_dangler" type="number" class="form-control"
                    data-placeholder-hi="डैंगलर चार्ट (संख्या में)" data-placeholder-en="Dangler Chart(In Numbers)"
                    onkeyup="validateSimpleStock(this, 'dangler_chart')">
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="स्टैंडी (संख्या में)" data-en="Standee(In Numbers)"></span>
                </label>
                <input name="standee" id="dist_standee" type="number" class="form-control"
                    data-placeholder-hi="स्टैंडी (संख्या में)" data-placeholder-en="Standee(In Numbers)" onkeyup="validateSimpleStock(this, 'standee')">
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="पैम्फलेट (संख्या में)" data-en="Pamphlet(In Numbers)"></span>
                </label>
                <small id="pamphlet_msg" style="color:red"></small>
                <input name="pamphlet" id="dist_pamphlet" type="number" class="form-control"
                    data-placeholder-hi="पैम्फलेट (संख्या में)" data-placeholder-en="Pamphlet(In Numbers)" onkeyup="validateSimpleStock(this, 'pamphlet')">
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="एआई किट (संख्या में)" data-en="AI Kit(In Numbers) "></span>
                </label>
                <small id="ai_kit_msg" style="color:red"></small>
                <input name="ai_kit" id="dist_ai_kit" type="number" class="form-control"
                    data-placeholder-hi="एआई किट (संख्या में)" data-placeholder-en="AI Kit(In Numbers) " onkeyup="validateSimpleStock(this, 'ai_kit')">
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
        </div>
        <!------Summary Page End---------------->
        <div class="row">
            <div class="mb-4 mt-4 text-centerx">
                <button type="submit" class="btn btn-primary submit buttonWizard">
                    <span data-en="Submit" data-hi="सबमिट"></span>
                </button>
            </div>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{ asset('assets/js/checkRemaninngStock.js') }}"></script>

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

        //Stop if last row failed validation
        const lastIndex = $('.main_div_block').length - 1;
        const stockKey = 'semen_' + lastIndex;
        const dupKey   = 'duplicate_' + lastIndex;
        if (validationState[stockKey] === false || validationState[dupKey] === false) {
            alert('Please correct errors in the current entry before adding a new one.');
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

        const $block = $(this).closest('.main_div_block');
        const index = $('.main_div_block').index($block);

        delete validationState['semen_' + index];
        delete validationState['duplicate_' + index];

        $block.remove();
        fieldCount--;

        reindexSemenValidation();
        updateSubmitButton();
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

    function reindexSemenValidation() {
        const newState = {};

        $('.main_div_block').each(function (newIndex) {

            if (validationState['semen_' + newIndex] !== undefined) {
                newState['semen_' + newIndex] = validationState['semen_' + newIndex];
            }

            if (validationState['duplicate_' + newIndex] !== undefined) {
                newState['duplicate_' + newIndex] = validationState['duplicate_' + newIndex];
            }

        });

        Object.keys(validationState).forEach(k => delete validationState[k]);
        Object.assign(validationState, newState);

        checkDuplicateSemenRows();
    }


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

        //Stop if last container row invalid
        const lastIndex = $('.container_div_block').length - 1;
        const stockKey = 'container_' + lastIndex;
        const dupKey   = 'duplicate_container_' + lastIndex;

        if (validationState[stockKey] === false || validationState[dupKey] === false) {
            alert('Please correct errors in the current container entry before adding a new one.');
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

        const $block = $(this).closest('.container_div_block');
        const index = $('.container_div_block').index($block);

        // remove validation keys related to this row
        delete validationState['container_' + index];
        delete validationState['duplicate_container_' + index];

        $block.remove();
        containerCount--;

        // re-run validation to refresh indexes
        reindexContainerValidation();
        updateSubmitButton();
    });

    //================ end ==========================
    

});


const validationState = {};

function validateSimpleStock(input, type) {

    const qty = parseInt(input.value || 0);

    const stock = parseInt(
        document.querySelector(`.stock-item[data-type="${type}"]`)?.value || 0
    );

    const key = type;

    if (qty > stock) {
        showError(input, "Invalid Quantity");
        validationState[key] = false;
    } else {
        clearError(input);
        validationState[key] = true;
    }

    updateSubmitButton();
}


function showError(input, msg) {
    let el = input.nextElementSibling;
    if (!el || !el.classList.contains('errorclass')) {
        el = document.createElement('div');
        el.className = 'errorclass';
        input.after(el);
    }
    el.innerText = msg;
}

function clearError(input) {
    const el = input.nextElementSibling;
    if (el && el.classList.contains('errorclass')) {
        el.innerText = '';
    }
}

function updateSubmitButton() {
    const valid = Object.values(validationState).every(v => v === true);
    document.querySelector('.buttonWizard').disabled = !valid;
}

// ================= CONTAINER STOCK VALIDATION =================

$(document).on('change input', '.container_div_block .container-capacity, .container_div_block .container-qty', function () {
        const $block = $(this).closest('.container_div_block');
        validateContainerRow($block);   // STOCK CHECK
        checkDuplicateContainers();     // DUPLICATE CHECK
});

// ================= DUPLICATE SEMEN COMBINATION CHECK =================

$(document).on('change input', 
    '.main_div_block .semen-select, .main_div_block .breed-type-select, .main_div_block .breed-select, .main_div_block select[name="semen_type[]"], .main_div_block input[name="bull_id[]"], .main_div_block input[name="semen_straws[]"]', 
    function () {
        const $block = $(this).closest('.main_div_block');
        validateSemenRow($block);   // STOCK VALIDATION
        checkDuplicateSemenRows();
});
function checkDuplicateSemenRows() {

    const seen = {};

    $('.main_div_block').each(function (index) {

        const $block = $(this);
        const semen     = $block.find('.semen-select').val();
        const breedType = $block.find('.breed-type-select').val();
        const breed     = $block.find('.breed-select').val();
        const semenType = $block.find('select[name="semen_type[]"]').val();
        const bull      = $block.find('input[name="bull_id[]"]').val();
        const qtyInput  = $block.find('input[name="semen_straws[]"]')[0];

        const key = 'duplicate_' + index;

        if (!semen || !breedType || !breed || !bull) {
            validationState[key] = true;
            return;
        }

        //const comboKey = `${semen}|${breedType}|${breed}|${bull}`;
        const comboKey = `${semen}|${breedType}|${breed}|${semenType}|${bull}`;

        if (seen[comboKey]) {
            showDuplicateError(qtyInput, "Duplicate entry not allowed");
            validationState[key] = false;
        } else {
            clearDuplicateError(qtyInput);
            validationState[key] = true;
            seen[comboKey] = true;
        }

    });

    updateSubmitButton();
}

function validateSemenRow($block) {

    const semen     = $block.find('.semen-select').val();
    const breedType = $block.find('.breed-type-select').val();
    const breed     = $block.find('.breed-select').val();
    const semenType = $block.find('select[name="semen_type[]"]').val();
    const bull      = $block.find('input[name="bull_id[]"]').val();
    const qtyInput  = $block.find('input[name="semen_straws[]"]')[0];
    const qty       = parseInt(qtyInput?.value || 0);

    const key = 'semen_' + $('.main_div_block').index($block);

    console.log(semen, breedType, breed, semenType, bull, qty);

    // wait until all identity fields selected
    if (!semen || !breedType || !breed || !semenType || !bull) {
        validationState[key] = false;
        return;
    }

    const stockEl = document.querySelector(
    `.stock-item[data-type="species_semen"][data-semen="${semen}"][data-breedtype="${breedType}"][data-breed="${breed}"][data-sementype="${semenType}"][data-bull="${bull}"]`
    );

    if (!stockEl) {
        showError(qtyInput, "Stock not found");
        validationState[key] = false;
    } else {
        const stock = parseInt(stockEl.value || 0);
        if (qty > stock) {
            showError(qtyInput, "Exceeds available stock");
            validationState[key] = false;
        } else {
            clearError(qtyInput);
            validationState[key] = true;
        }
    }

    updateSubmitButton();
}


function showDuplicateError(input, msg) {
    let el = input.parentNode.querySelector('.duplicate-error');
    if (!el) {
        el = document.createElement('div');
        el.className = 'errorclass duplicate-error';
        input.after(el);
    }
    el.innerText = msg;
}

function clearDuplicateError(input) {
    const el = input.parentNode.querySelector('.duplicate-error');
    if (el) el.remove();
}


// ================= DUPLICATE CONTAINER CHECK =================
$(document).on('change input', '.container-capacity, .container-qty', function () {
    checkDuplicateContainers();
});
function checkDuplicateContainers() {

    const seen = {};

    $('.container_div_block').each(function (index) {

        const $block = $(this);
        const capacity = $block.find('.container-capacity').val();
        const qtyInput = $block.find('.container-qty')[0];

        const key = 'duplicate_container_' + index;

        if (!capacity) {
            validationState[key] = true;
            return;
        }

        if (seen[capacity]) {
            showDuplicateError(qtyInput, "Duplicate container not allowed");
            validationState[key] = false;
        } else {
            clearDuplicateError(qtyInput);
            validationState[key] = true;
            seen[capacity] = true;
        }

    });

    updateSubmitButton();
}

function validateContainerRow($block) {

    const capacity = $block.find('.container-capacity').val();
    const qtyInput = $block.find('.container-qty')[0];
    const qty      = parseInt(qtyInput?.value || 0);

    const key = 'container_' + $('.container_div_block').index($block);

    if (!capacity) {
        clearError(qtyInput);
        validationState[key] = false;
        updateSubmitButton();
        return;
    }

    const stockEl = document.querySelector(
        `.stock-item[data-type="container"][data-capacity="${capacity}"]`
    );

    if (!stockEl) {
        showError(qtyInput, "Stock not found");
        validationState[key] = false;
    } else {
        const stock = parseInt(stockEl.value || 0);

        if (qty > stock) {
            showError(qtyInput, "Exceeds available stock");
            validationState[key] = false;
        } else {
            clearError(qtyInput);
            validationState[key] = true;
        }
    }

    updateSubmitButton();
}


function reindexContainerValidation() {
    const newState = {};

    $('.container_div_block').each(function (newIndex) {

        if (validationState['container_' + newIndex] !== undefined) {
            newState['container_' + newIndex] = validationState['container_' + newIndex];
        }

        if (validationState['duplicate_container_' + newIndex] !== undefined) {
            newState['duplicate_container_' + newIndex] = validationState['duplicate_container_' + newIndex];
        }

    });

    Object.keys(validationState).forEach(k => delete validationState[k]);
    Object.assign(validationState, newState);

    checkDuplicateContainers(); // refresh duplicates
}

</script>

@endsection