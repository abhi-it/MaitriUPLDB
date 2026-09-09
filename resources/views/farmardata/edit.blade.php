@extends('master')
@section('content')

<style>
.errorclass {
    font-size: 8px;
    color: red;
}
.password-hint {
    font-size: 12px;
    color: #6c757d;
}
</style>
<div class="container main-div py-5" style="background-color:white;">
    <h3 class="text-center fw-bold m-4">
        <span data-hi="किसान रिकॉर्ड संपादित करें" data-en="Edit Farmer Record"></span>
    </h3>
    <hr>
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

    <form method="post" action="{{ route('update-farmer-record', $farmer->id) }}" class="form-comman">
        @csrf
        <div class="row">
            <div class="form-group col-md-4">
                <label for="first_name">
                    <span data-hi="नाम" data-en="First Name"></span>
                </label>
                <input type="text" class="form-control" name="first_name" id="first_name" required
                    value="{{ old('first_name', $farmer->FirstName) }}" data-placeholder-hi="नाम"
                    autocomplete="off" data-placeholder-en="First Name">
            </div>

            <div class="form-group col-md-4">
                <label for="last_name">
                    <span data-hi="उपनाम" data-en="Last Name"></span>
                </label>
                <input type="text" class="form-control" name="last_name" id="last_name"
                    value="{{ old('last_name', $farmer->LastName) }}" data-placeholder-hi="उपनाम"
                    autocomplete="off" data-placeholder-en="Last Name">
            </div>

            <div class="form-group col-md-4">
                <label for="MobileNumber">
                    <span data-hi="मोबाइल नंबर" data-en="Mobile Number"></span>
                </label>
                <input type="number" class="form-control" id="MobileNumber" name="MobileNumber" required
                    value="{{ old('MobileNumber', $farmer->MobileNumber) }}" data-placeholder-hi="मोबाइल नंबर"
                    autocomplete="off" data-placeholder-en="Mobile Number">
            </div>

            <div class="form-group col-md-4">
                <label for="gender">
                    <span data-hi="लिंग" data-en="Gender"></span>
                </label>
                <select class="form-control" name="gender" id="gender">
                    <option value="" data-hi="एक का चयन करें" data-en="select one">Select</option>
                    <option value="male" {{ old('gender', $farmer->gender) == 'male' ? 'selected' : '' }}
                        data-hi="पुरुष" data-en="Male">Male</option>
                    <option value="female" {{ old('gender', $farmer->gender) == 'female' ? 'selected' : '' }}
                        data-hi="महिला" data-en="Female">Female</option>
                    <option value="others" {{ old('gender', $farmer->gender) == 'others' ? 'selected' : '' }}
                        data-hi="अन्य" data-en="Other">Other</option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label for="email">
                    <span data-hi="ईमेल" data-en="E-mail"></span>
                </label>
                <input type="email" class="form-control" name="email" id="email"
                    value="{{ old('email', $farmer->email) }}" data-placeholder-hi="ईमेल"
                    autocomplete="off" data-placeholder-en="Email">
            </div>

            <div class="form-group col-md-4">
                <label for="password">
                    <span data-hi="पासवर्ड" data-en="Password"></span>
                </label>
                <input type="password" class="form-control" id="password" name="password"
                    data-placeholder-hi="पासवर्ड" autocomplete="new-password" data-placeholder-en="Password">
                <small class="password-hint">
                    <span data-hi="वर्तमान पासवर्ड रखने के लिए खाली छोड़ें" data-en="Leave blank to keep current password"></span>
                </small>
            </div>

            <div class="form-group col-md-4">
                <label for="password_confirmation">
                    <span data-hi="पासवर्ड की पुष्टि करें" data-en="Confirm Password"></span>
                </label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    data-placeholder-hi="पासवर्ड की पुष्टि करें" autocomplete="new-password"
                    data-placeholder-en="Confirm Password">
            </div>

            <div class="form-group col-md-12">
                <label for="animal">
                    <span data-hi="पशु की जानकारी" data-en="Number of cattle"></span>
                </label>
                <div class="optionBox">
                    @php
                        $animalRecords = $farmer->getAnimalInformation ?? collect();
                        if ($animalRecords->isEmpty() && ($farmer->animal_type || $farmer->breeds || $farmer->cattale_no || $farmer->milk_day)) {
                            $animalRecords = collect([(object) [
                                'id' => null,
                                'animal_type' => $farmer->animal_type,
                                'breeds' => $farmer->breeds,
                                'cattale_no' => $farmer->cattale_no,
                                'milk_day' => $farmer->milk_day,
                            ]]);
                        }
                    @endphp
                    @if($animalRecords->count() > 0)
                        @foreach($animalRecords as $index => $animal)
                        <div class="block row adddiv_{{ $index }}">
                            <input type="hidden" name="animal_id[]" value="{{ $animal->id ?? '' }}">
                            @if ($loop->first)
                            <div class="form-group col-md-3">
                                <label><span data-hi="पशु प्रकार" data-en="Animal Type"></span></label>
                            </div>
                            <div class="form-group col-md-3">
                                <label><span data-hi="नस्लें" data-en="Breeds"></span></label>
                            </div>
                            <div class="form-group col-md-3">
                                <label><span data-hi="पशु संख्या" data-en="Cattle Number"></span></label>
                            </div>
                            <div class="form-group col-md-2">
                                <label><span data-hi="दूध/प्रतिदिन/प्रति पशु" data-en="Milk/day/Per Animal"></span></label>
                            </div>
                            <div class="form-group col-md-1">
                                <span class="add btn btn-primary btn-sm">
                                    <span data-hi="जोड़ें" data-en="Add"></span>
                                </span>
                            </div>
                            @endif
                            <div class="form-group col-md-3">
                                <select class="form-control" name="animal_type[]">
                                    <option value="">एक का चयन करें</option>
                                    <option value="cow" {{ ($animal->animal_type ?? '') == 'cow' ? 'selected' : '' }}>गाय</option>
                                    <option value="buffalo" {{ ($animal->animal_type ?? '') == 'buffalo' ? 'selected' : '' }}>भैंस</option>
                                    <option value="goat" {{ ($animal->animal_type ?? '') == 'goat' ? 'selected' : '' }}>बकरी</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" class="form-control" name="breeds[]"
                                    value="{{ $animal->breeds ?? '' }}" autocomplete="off"
                                    data-placeholder-hi="गाय/भैंस/बकरी की नस्लें"
                                    data-placeholder-en="Breeds of Cow/Buffalo">
                            </div>
                            <div class="form-group col-md-3">
                                <input type="number" class="form-control" name="cattale_no[]"
                                    value="{{ $animal->cattale_no ?? '' }}" autocomplete="off"
                                    data-placeholder-hi="पशु की जानकारी" data-placeholder-en="Cattle Number">
                            </div>
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="milk_day[]"
                                    value="{{ $animal->milk_day ?? '' }}" autocomplete="off"
                                    data-placeholder-hi="दूध/प्रतिदिन/प्रति पशु"
                                    data-placeholder-en="Milk/day/Per Animal">
                            </div>
                            <div class="form-group col-md-1">
                                @if(!$loop->first)
                                <button type="button" data-animalId="{{ $animal->id ?? '' }}"
                                    class="remove btn btn-danger btn-sm">Remove</button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="block row adddiv_0">
                            <input type="hidden" name="animal_id[]" value="">
                            <div class="form-group col-md-3">
                                <select class="form-control" name="animal_type[]">
                                    <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                                    <option value="cow" data-hi="गाय" data-en="Cow"></option>
                                    <option value="buffalo" data-hi="भैंस" data-en="Buffalo"></option>
                                    <option value="goat" data-hi="बकरी" data-en="Goat"></option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" class="form-control" name="breeds[]" autocomplete="off"
                                    data-placeholder-hi="गाय/भैंस/बकरी की नस्लें"
                                    data-placeholder-en="Breeds of Cow/Buffalo">
                            </div>
                            <div class="form-group col-md-3">
                                <input type="number" class="form-control" name="cattale_no[]" autocomplete="off"
                                    data-placeholder-hi="पशु की जानकारी" data-placeholder-en="Cattle Number">
                            </div>
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" name="milk_day[]" autocomplete="off"
                                    data-placeholder-hi="दूध/प्रतिदिन/प्रति पशु"
                                    data-placeholder-en="Milk/day/Per Animal">
                            </div>
                            <div class="form-group col-md-1">
                                <span class="add btn btn-primary btn-sm">
                                    <span data-hi="जोड़ें" data-en="Add"></span>
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group col-md-6">
                <label for="district">
                    <span data-hi="मंडल" data-en="Mandal"></span>
                </label>
                <select name="division_id" id="district" class="form-control" required>
                    <option value="" data-hi="मंडल चुनें" data-en="Select Mandal"></option>
                    @foreach($divisions as $val)
                    <option value="{{ $val->id }}" {{ old('division_id', $farmer->division_id) == $val->id ? 'selected' : '' }}>
                        {{ $val->name_hindi }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="mandal">
                    <span data-hi="ज़िला" data-en="District"></span>
                </label>
                <select name="district_id" id="mandal" class="form-control" required>
                    <option value="">Select District</option>
                    @foreach($districts as $district)
                    <option value="{{ $district->id }}"
                        {{ old('district_id', $farmer->district_id) == $district->id ? 'selected' : '' }}>
                        {{ $district->name_hindi }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="tehsil">
                    <span data-hi="तहसील" data-en="Tehsil"></span>
                </label>
                <select name="tehsil" id="tehsil" class="form-control">
                    @if(old('tehsil', $farmer->tehsil))
                    <option value="{{ old('tehsil', $farmer->tehsil) }}" selected>
                        {{ old('tehsil', $farmer->tehsil) }}
                    </option>
                    @else
                    <option value="">Select Tehsil</option>
                    @endif
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="vikas_khand">
                    <span data-hi="विकास खण्ड" data-en="Vikas Khand"></span>
                </label>
                <select name="block" id="vikas_khand" class="form-control">
                    @if(old('block', $farmer->block))
                    <option value="{{ old('block', $farmer->block) }}" selected>
                        {{ old('block', $farmer->block) }}
                    </option>
                    @else
                    <option value="">Select Vikas Khand</option>
                    @endif
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="post_office">
                    <span data-hi="पोस्ट ऑफिस" data-en="Post Office"></span>
                </label>
                <input type="text" name="post_office" id="post_office" class="form-control"
                    value="{{ old('post_office', $farmer->post_office) }}" placeholder="पोस्ट ऑफिस">
            </div>

            <div class="form-group col-md-6">
                <label for="pincode">
                    <span data-hi="पिनकोड" data-en="Pincode"></span>
                </label>
                <input type="text" name="pincode" maxlength="6" id="pincode" class="form-control"
                    value="{{ old('pincode', $farmer->pincode) }}"
                    data-placeholder-en="Enter Pincode Here" data-placeholder-hi="यहां पिनकोड दर्ज करें">
            </div>

            <div class="form-group col-md-6">
                <label for="gram_panchayat">
                    <span data-hi="ग्राम पंचायत" data-en="Gram Panchayat"></span>
                </label>
                <input type="text" class="form-control" id="gram_panchayat" name="gram_panchayat"
                    value="{{ old('gram_panchayat', $farmer->gram_panchayat) }}"
                    data-placeholder-hi="ग्राम पंचायत" autocomplete="off" data-placeholder-en="Gram Panchayat">
            </div>
        </div>

        <div class="row">
            <div class="mb-4 mt-4 text-center">
                <button type="submit" class="btn btn-primary submit buttonWizard">
                    <span data-hi="अपडेट करें" data-en="Update"></span>
                </button>
                <a href="{{ route('farmers-data') }}" class="btn btn-secondary">
                    <span data-hi="वापस जाएं" data-en="Back"></span>
                </a>
            </div>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#district').change(function() {
        $('#mandal').empty();
        $('#vikas_khand').empty();
        $('#tehsil').empty();

        var val = $("#district option:selected").val();
        var text = $("#district option:selected").text().trim();
        if (val) {
            $.ajax({
                type: "GET",
                url: "{{ route('get-all-district') }}",
                data: {
                    "id": val,
                    "mandal": text,
                },
                cache: false,
                success: function(data) {
                    var districts = data.district || [];
                    var janpads = data.data || [];
                    $('#mandal').append(`<option value="">Select District</option>`);
                    if (districts.length > 0) {
                        districts.forEach(function(item) {
                            if (item.name_hindi) {
                                $('#mandal').append(
                                    `<option value="${item.id}">${item.name_hindi}</option>`
                                );
                            }
                        });
                    } else if (janpads.length > 0) {
                        janpads.forEach(function(item) {
                            if (item.janpad_name && item.janpad_name.trim() !== '') {
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
        $('#vikas_khand').empty();
        $('#tehsil').empty();

        var mandal = $("#district option:selected").text().trim();
        var janpad = $("#mandal option:selected").text().trim();
        $.ajax({
            type: "GET",
            url: "{{ route('get-all-tehsil') }}",
            data: {
                "mandal": mandal,
                "janpad": janpad,
            },
            cache: false,
            success: function(data) {
                var getTehsil = data.data;
                if (getTehsil && getTehsil.length > 0) {
                    $('#tehsil').append(`<option value="">Select Tehsil</option>`);
                    getTehsil.forEach(function(item) {
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
        $('#vikas_khand').empty();
        var tehsil = $(this).val();
        var mandal = $("#district option:selected").text().trim();
        var janpad = $("#mandal option:selected").text().trim();
        $.ajax({
            type: "GET",
            url: "{{ route('get-all-block') }}",
            data: {
                "tehsil": tehsil,
                "mandal": mandal,
                "janpad": janpad,
            },
            cache: false,
            success: function(data) {
                var getBlock = data.data;
                if (getBlock && getBlock.length > 0) {
                    $('#vikas_khand').append(`<option value="">Select Vikas Khand</option>`);
                    getBlock.forEach(function(item) {
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

    var maxFields = 2;
    var fieldCount = $('.optionBox .block').length ? $('.optionBox .block').length - 1 : 0;
    if (fieldCount >= maxFields) {
        $('.add').hide();
    }

    $('.optionBox').on('click', '.add', function() {
        if (fieldCount < maxFields) {
            var newField = '<div class="block row adddiv_' + fieldCount + '"> \
                    <input type="hidden" name="animal_id[]" value=""> \
                    <div class="form-group col-md-3">\
                        <select class="form-control" name="animal_type[]">\
                            <option value="">एक का चयन करें</option>\
                            <option value="cow">गाय</option>\
                            <option value="buffalo">भैंस</option>\
                            <option value="goat">बकरी</option>\
                        </select>\
                    </div>\
                    <div class="form-group col-md-3">\
                        <input type="text" class="form-control" name="breeds[]" autocomplete="off" placeholder="गाय/भैंस/बकरी की नस्लें">\
                    </div>\
                    <div class="form-group col-md-3">\
                        <input type="number" class="form-control" name="cattale_no[]" placeholder="पशु की जानकारी" autocomplete="off">\
                    </div>\
                    <div class="form-group col-md-2">\
                        <input type="text" class="form-control" name="milk_day[]" placeholder="दूध/प्रतिदिन/प्रति पशु" autocomplete="off">\
                    </div>\
                    <div class="form-group col-md-1"> \
                        <span class="remove btn btn-danger btn-sm">Remove</span> \
                    </div> \
                </div>';

            $('.block:last').after(newField);
            fieldCount++;

            if (fieldCount === maxFields) {
                $('.add').hide();
            }
        }
    });

    $('.optionBox').on('click', '.remove', function() {
        var animalId = $(this).attr('data-animalId');
        if (animalId) {
            $('.optionBox').append('<input type="hidden" name="removeAnimal[]" value="' + animalId + '"/>');
        }
        $(this).closest('.block').remove();
        fieldCount--;
        $('.add').show();
    });
});
</script>

@endsection
