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

.openModal {
    display: none;
}

.contain-form {
    margin: auto;
    padding: 20px;
}
</style>
<div class="container main-div">
    <h3 class="text-center fw-bold m-4">प्रोफ़ाइल अद्यतन</h3>
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
        <div class="contain-form card">
            <form method="post" action="{{ route('update-farmer-details') }}" class="form-comman">
                @csrf
                <input type="hidden" name="user_id" value="{{ $id ?? '' }}">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="first_name">
                            <span>नाम</span>
                        </label>
                        <input type="text" class="form-control" required name="first_name" id="first_name"
                            value="{{ $data->FirstName ?? '' }}" placeholder="नाम" autocomplete="off">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="MobileNumber">
                            <span>मोबाइल नंबर</span>
                        </label>
                        <input type="number" class="form-control" required id="MobileNumber" name="MobileNumber"
                            value="{{ $data->MobileNumber ?? '' }}" placeholder="मोबाइल नंबर" autocomplete="off">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="gender"> <span>लिंग</span></label>
                        <select class="form-control" name="gender" required id="gender">
                            <option value="">एक का चयन करें</option>
                            <option value="male"
                                {{ (isset($data->gender) && $data->gender == 'male') ? 'selected' : '' }}>पुरुष</option>
                            <option value="female"
                                {{ (isset($data->gender) && $data->gender == 'female') ? 'selected' : '' }}>महिला
                            </option>
                            <option value="others"
                                {{ (isset($data->gender) && $data->gender == 'others') ? 'selected' : '' }}>अन्य
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="division"> <span>मंडल</span></label>
                        <select name="division_id" id="division" required class="form-control">
                            <option value="">मंडल चुनें</option>
                            @foreach($divisions as $division)
                            <option value="{{ $division->id }}"
                                {{ isset($data->division_id) && $data->division_id == $division->id ? 'selected' : '' }}>
                                {{ $division->name_hindi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="mandal"> <span>ज़िला</span></label>
                        <select name="district_id" id="mandal" required class="form-control">
                            @foreach($districts as $district)
                            <option value="{{ $district->name_hindi }}"
                                {{ isset($data->district) && $data->district->id == $district->id ? 'selected' : '' }}>
                                {{ $district->name_hindi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="tehsil"> <span>तहसील</span></label>
                        <select name="tehsil" id="tehsil" required class="form-control">
                            <option value="{{ $data->tehsil ?? '' }}">{{ $data->tehsil ?? 'N/A' }}</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="vikas_khand"> <span>विकास खण्ड</span></label>
                        <select name="block" id="vikas_khand" required class="form-control">
                            <option value="{{ $data->block ?? '' }}">{{ $data->block ?? 'N/A' }}</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="post_office"> <span>पोस्ट ऑफिस</span></label>
                        <input type="text" name="post_office" required id="post_office"
                            value="{{ $data->post_office ?? '' }}" class="form-control" placeholder="पोस्ट ऑफिस">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="pincode"><span>पिनकोड</span></label>
                        <span id="error-message" style="color: red; display:none; font-size:10px;">(Pincode must be a
                            6-digit number.)</span>
                        <input type="text" name="pincode" required maxlength="6" id="pincode"
                            value="{{ $data->pincode ?? '' }}" class="form-control" placeholder="यहां पिनकोड दर्ज करें">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="gram_panchayat">
                            <span>ग्राम पंचायत</span>
                        </label>
                        <input type="text" class="form-control" required id="gram_panchayat"
                            value="{{ $data->gram_panchayat ?? '' }}" name="gram_panchayat" placeholder="ग्राम पंचायत"
                            autocomplete="off">
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label for="animal">
                        <span>पशु की जानकारी</span>
                    </label>

                    @php
                    // cattale_no, breeds, and milk_day are comma-separated strings
                    $cattaleNoArray = explode(',', $data->cattale_no);
                    $breedsArray = explode(',', $data->breeds);
                    $milkDayArray = explode(',', $data->milk_day);
                    $animalTypes = explode(',', $data->animal_type); // You can modify this if animal_typ
                    @endphp

                    <div class="optionBox">
                        @if($data->getAnimalInformation )
                        @foreach($data->getAnimalInformation as $index => $animal)
                        <div class="block row adddiv_{{ $index }}">
                            <input type="hidden" name="animal_id[]" value="{{ $animal->id }}">

                            @if ($loop->first)
                            <div class="form-group col-md-3 label-col">
                                <label for="animal_type">पशु प्रकार</label>
                            </div>
                            <div class="form-group col-md-3 label-col">
                                <label for="breeds">नस्लें</label>
                            </div>
                            <div class="form-group col-md-3 label-col">
                                <label for="cattale_no">पशु संख्या</label>
                            </div>
                            <div class="form-group col-md-2 label-col">
                                <label for="milk_day">दूध/प्रतिदिन/प्रति पशु</label>
                            </div>
                            <div class="form-group col-md-1 label-col">
                                <span class="add btn btn-primary btn-sm">जोड़ें</span>
                            </div>
                            @endif

                            <div class="form-group col-md-3">
                                <select class="form-control" required id="animal_type" name="animal_type[]">
                                    <option value="">एक का चयन करें</option>
                                    <option value="cow" {{ $animal->animal_type == 'cow' ? 'selected' : '' }}>गाय
                                    </option>
                                    <option value="buffalo" {{ $animal->animal_type == 'buffalo' ? 'selected' : '' }}>
                                        भैंस</option>
                                    <option value="goat" {{ $animal->animal_type == 'goat' ? 'selected' : '' }}>बकरी
                                    </option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <input type="text" class="form-control" required id="breeds" name="breeds[]"
                                    value="{{ $animal->breeds ?? '' }}" placeholder="गाय/भैंस/बकरी की नस्लें"
                                    autocomplete="off">
                            </div>

                            <div class="form-group col-md-3">
                                <input type="number" class="form-control" required id="cattale_no" name="cattale_no[]"
                                    value="{{ $animal->cattale_no ?? '' }}" placeholder="पशु की जानकारी"
                                    autocomplete="off">
                            </div>

                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" required id="milk_day" name="milk_day[]"
                                    value="{{ $animal->milk_day ?? '' }}" placeholder="दूध/प्रतिदिन/प्रति पशु"
                                    autocomplete="off">
                            </div>
                            <div class="form-group col-md-1">
                                <button type="button" data-animalId="{{ $animal->id }}"
                                    class="remove btn btn-danger btn-sm">हटाएं</button>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="block row adddiv_{{ $index }}">
                            <input type="hidden" name="animal_id[]" value="{{ $animal->id }}">

                            @if ($loop->first)
                            <div class="form-group col-md-3 label-col">
                                <label for="animal_type">पशु प्रकार</label>
                            </div>
                            <div class="form-group col-md-3 label-col">
                                <label for="breeds">नस्लें</label>
                            </div>
                            <div class="form-group col-md-3 label-col">
                                <label for="cattale_no">पशु संख्या</label>
                            </div>
                            <div class="form-group col-md-2 label-col">
                                <label for="milk_day">दूध/प्रतिदिन/प्रति पशु</label>
                            </div>
                            <div class="form-group col-md-1 label-col">
                                <span class="add btn btn-primary btn-sm">जोड़ें</span>
                            </div>
                            @endif

                            <div class="form-group col-md-3">
                                <select class="form-control" required id="animal_type" name="animal_type[]">
                                    <option value="">एक का चयन करें</option>
                                    <option value="cow" {{ $animal->animal_type == 'cow' ? 'selected' : '' }}>गाय
                                    </option>
                                    <option value="buffalo" {{ $animal->animal_type == 'buffalo' ? 'selected' : '' }}>
                                        भैंस</option>
                                    <option value="goat" {{ $animal->animal_type == 'goat' ? 'selected' : '' }}>बकरी
                                    </option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <input type="text" class="form-control" required id="breeds" name="breeds[]"
                                    value="{{ $animal->breeds ?? '' }}" placeholder="गाय/भैंस/बकरी की नस्लें"
                                    autocomplete="off">
                            </div>

                            <div class="form-group col-md-3">
                                <input type="number" class="form-control" required id="cattale_no" name="cattale_no[]"
                                    value="{{ $animal->cattale_no ?? '' }}" placeholder="पशु की जानकारी"
                                    autocomplete="off">
                            </div>

                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" required id="milk_day" name="milk_day[]"
                                    value="{{ $animal->milk_day ?? '' }}" placeholder="दूध/प्रतिदिन/प्रति पशु"
                                    autocomplete="off">
                            </div>
                            <div class="form-group col-md-1">
                                <button type="button" data-animalId="{{ $animal->id }}"
                                    class="remove btn btn-danger btn-sm">हटाएं</button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="mb-4 mt-5 m-auto">
                        <button type="submit" class="btn btn-primary submit buttonWizard">
                            <span>सबमिट</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script>
$(document).ready(function() {
    var allData = {};
    var preSelectedDistrict = $("#division").val();
    var preSelectedMandal = $("#mandal").val();

    if (preSelectedDistrict) {
        var text = $("#division option:selected").text();

        $.ajax({
            type: "GET",
            url: "getDistrict",
            data: {
                "id": preSelectedDistrict,
                "mandal": text,
            },
            cache: false,
            success: function(data) {
                var getMandal = data.data;
                var mandalOptions = '';

                if (getMandal && getMandal.length > 0) {
                    mandalOptions += `<option value="">जिला चुने</option>`;
                    getMandal.forEach(item => {
                        if (item.janpad_name && item.janpad_name.trim() !== '') {
                            mandalOptions +=
                                `<option value="${item.janpad_name}" ${item.janpad_name === preSelectedMandal ? 'selected' : ''}>${item.janpad_name}</option>`;
                        }
                    });

                    $('#mandal').html(mandalOptions);
                } else {
                    $('#mandal').html('<option value="">-Data not found.-</option>');
                }
            }
        });
    }

    $('#division').change(function() {
        $('#mandal').prop('disabled', false);
        $('#mandal').empty();
        $('#vikas_khand').prop('disabled', false);
        $('#vikas_khand').empty();
        $('#ai_center').prop('disabled', false);
        $('#ai_center').empty();
        $('#tehsil').prop('disabled', false);
        $('#tehsil').empty();

        var val = $("#division option:selected").val();
        var text = $("#division option:selected").text();

        if (val) {
            $.ajax({
                type: "GET",
                url: "get-all-district",
                data: {
                    "id": val,
                    "mandal": text,
                },
                cache: false,
                success: function(data) {
                    var getMandal = data.data;
                    if (getMandal && getMandal.length > 0) {
                        $('#mandal').append(`<option value="">जिला चुने</option>`);
                        getMandal.forEach(item => {
                            if (item.janpad_name && item.janpad_name.trim() !==
                                '') {
                                $('#mandal').append(
                                    `<option value="${item.janpad_name}">${item.janpad_name}</option>`
                                );
                            }
                        });
                    } else {
                        $('#mandal').append('<option value="">-Data not found.-</option>');
                    }
                }
            });
        }
    });

    $('#mandal').change(function() {
        $('#vikas_khand').prop('disabled', false);
        $('#vikas_khand').empty();
        $('#ai_center').prop('disabled', false);
        $('#ai_center').empty();
        $('#tehsil').prop('disabled', false);
        $('#tehsil').empty();

        var mandal = $("#district option:selected").text();
        var janpad = $("#mandal option:selected").val();
        $.ajax({
            type: "GET",
            url: "get-all-tehsil",
            data: {
                "mandal": mandal,
                "janpad": janpad,
            },
            cache: false,
            success: function(data) {
                var getTehsil = data.data;
                if (getTehsil && getTehsil.length > 0) {
                    $('#tehsil').append(`<option value="">तहसील चूने</option>`);
                    getTehsil.forEach(item => {
                        if (item.tehsil && item.tehsil.trim() !== '') {
                            $('#tehsil').append(
                                `<option value="${item.tehsil}">${item.tehsil}</option>`
                            );
                        }
                    });
                } else {
                    $('#tehsil').append('<option value="">-Data not found.-</option>');
                }
            }
        });
    });

    $('#tehsil').change(function() {
        $('#vikas_khand').prop('disabled', false);
        $('#vikas_khand').empty();
        $('#ai_center').prop('disabled', false);
        $('#ai_center').empty();
        var tehsil = $(this).val();
        var mandal = $("#district option:selected").text();
        var janpad = $("#mandal option:selected").val();
        $.ajax({
            type: "GET",
            url: "get-all-block",
            data: {
                "tehsil": tehsil,
                "mandal": mandal,
                "janpad": janpad,
            },
            cache: false,
            success: function(data) {
                var getBlock = data.data;
                if (getBlock && getBlock.length > 0) {
                    $('#vikas_khand').append(
                        `<option value="">विकास खंड चूने</option>`);
                    getBlock.forEach(item => {
                        if (item.block && item.block.trim() !== '') {
                            $('#vikas_khand').append(
                                `<option value="${item.block}">${item.block}</option>`
                            );
                        }
                    });
                } else {
                    $('#vikas_khand').append('<option value="">-Data not found.-</option>');
                }
            }
        });
    });

    $(".add").click(function() {
        var newRow = $(this).closest('.row').clone();
        newRow.find("input").val('');
        newRow.find(".add").remove();

        newRow.find(".label-col").hide();
        $(this).closest('.optionBox').append(newRow);
    });

    $(document).on('click', '.remove', function() {
        var animalId = $(this).attr('data-animalId');
        var addRemoveHtml = '';
        addRemoveHtml += '<input type="hidden" name="removeAnimal[]" value="' + animalId + '"/>';
        $('.optionBox').append(addRemoveHtml);
        $(this).closest('.row').remove();
    });




});
</script>