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

.contain-form {
    margin: auto;
    padding: 20px;
}

.password-hint {
    font-size: 12px;
    color: #6c757d;
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
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="first_name">
                            <span>नाम</span>
                        </label>
                        <input type="text" class="form-control" required name="first_name" id="first_name"
                            value="{{ old('first_name', $data->FirstName ?? '') }}" placeholder="नाम" autocomplete="off">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="last_name">
                            <span>उपनाम</span>
                        </label>
                        <input type="text" class="form-control" name="last_name" id="last_name"
                            value="{{ old('last_name', $data->LastName ?? '') }}" placeholder="उपनाम" autocomplete="off">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="MobileNumber">
                            <span>मोबाइल नंबर</span>
                        </label>
                        <input type="number" class="form-control" required id="MobileNumber" name="MobileNumber"
                            value="{{ old('MobileNumber', $data->MobileNumber ?? '') }}" placeholder="मोबाइल नंबर"
                            autocomplete="off">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="gender"> <span>लिंग</span></label>
                        <select class="form-control" name="gender" required id="gender">
                            <option value="">एक का चयन करें</option>
                            <option value="male" {{ old('gender', $data->gender ?? '') == 'male' ? 'selected' : '' }}>पुरुष</option>
                            <option value="female" {{ old('gender', $data->gender ?? '') == 'female' ? 'selected' : '' }}>महिला</option>
                            <option value="others" {{ old('gender', $data->gender ?? '') == 'others' ? 'selected' : '' }}>अन्य</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="email">
                            <span>ईमेल</span>
                        </label>
                        <input type="email" class="form-control" name="email" id="email"
                            value="{{ old('email', $data->email ?? '') }}" placeholder="ईमेल" autocomplete="off">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="password">
                            <span>पासवर्ड</span>
                        </label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="पासवर्ड" autocomplete="new-password">
                        <small class="password-hint">वर्तमान पासवर्ड रखने के लिए खाली छोड़ें</small>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="password_confirmation">
                            <span>पासवर्ड की पुष्टि करें</span>
                        </label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" placeholder="पासवर्ड की पुष्टि करें" autocomplete="new-password">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="division"> <span>मंडल</span></label>
                        <select name="division_id" id="division" required class="form-control">
                            <option value="">मंडल चुनें</option>
                            @foreach($divisions as $division)
                            <option value="{{ $division->id }}"
                                {{ old('division_id', $data->division_id ?? '') == $division->id ? 'selected' : '' }}>
                                {{ $division->name_hindi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="mandal"> <span>ज़िला</span></label>
                        <select name="district_id" id="mandal" required class="form-control">
                            <option value="">जिला चुने</option>
                            @foreach($districts as $district)
                            <option value="{{ $district->id }}"
                                {{ old('district_id', $data->district_id ?? '') == $district->id ? 'selected' : '' }}>
                                {{ $district->name_hindi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="tehsil"> <span>तहसील</span></label>
                        <select name="tehsil" id="tehsil" required class="form-control">
                            @if(old('tehsil', $data->tehsil ?? ''))
                            <option value="{{ old('tehsil', $data->tehsil) }}" selected>
                                {{ old('tehsil', $data->tehsil) }}
                            </option>
                            @else
                            <option value="">तहसील चुनें</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="vikas_khand"> <span>विकास खण्ड</span></label>
                        <select name="block" id="vikas_khand" required class="form-control">
                            @if(old('block', $data->block ?? ''))
                            <option value="{{ old('block', $data->block) }}" selected>
                                {{ old('block', $data->block) }}
                            </option>
                            @else
                            <option value="">विकास खंड चुनें</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="post_office"> <span>पोस्ट ऑफिस</span></label>
                        <input type="text" name="post_office" required id="post_office"
                            value="{{ old('post_office', $data->post_office ?? '') }}" class="form-control"
                            placeholder="पोस्ट ऑफिस">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="pincode"><span>पिनकोड</span></label>
                        <input type="text" name="pincode" required maxlength="6" id="pincode"
                            value="{{ old('pincode', $data->pincode ?? '') }}" class="form-control"
                            placeholder="यहां पिनकोड दर्ज करें">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="gram_panchayat">
                            <span>ग्राम पंचायत</span>
                        </label>
                        <input type="text" class="form-control" required id="gram_panchayat"
                            value="{{ old('gram_panchayat', $data->gram_panchayat ?? '') }}" name="gram_panchayat"
                            placeholder="ग्राम पंचायत" autocomplete="off">
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label for="animal">
                        <span>पशु की जानकारी</span>
                    </label>

                    <div class="optionBox">
                        @php
                            $animalRecords = $data->getAnimalInformation ?? collect();
                            if ($animalRecords->isEmpty() && ($data->animal_type || $data->breeds || $data->cattale_no || $data->milk_day)) {
                                $animalRecords = collect([(object) [
                                    'id' => null,
                                    'animal_type' => $data->animal_type,
                                    'breeds' => $data->breeds,
                                    'cattale_no' => $data->cattale_no,
                                    'milk_day' => $data->milk_day,
                                ]]);
                            }
                        @endphp
                        @if($animalRecords->count() > 0)
                        @foreach($animalRecords as $index => $animal)
                        <div class="block row adddiv_{{ $index }}">
                            <input type="hidden" name="animal_id[]" value="{{ $animal->id ?? '' }}">

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
                                <select class="form-control" required name="animal_type[]">
                                    <option value="">एक का चयन करें</option>
                                    <option value="cow" {{ ($animal->animal_type ?? '') == 'cow' ? 'selected' : '' }}>गाय</option>
                                    <option value="buffalo" {{ ($animal->animal_type ?? '') == 'buffalo' ? 'selected' : '' }}>भैंस</option>
                                    <option value="goat" {{ ($animal->animal_type ?? '') == 'goat' ? 'selected' : '' }}>बकरी</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <input type="text" class="form-control" required name="breeds[]"
                                    value="{{ $animal->breeds ?? '' }}" placeholder="गाय/भैंस/बकरी की नस्लें"
                                    autocomplete="off">
                            </div>

                            <div class="form-group col-md-3">
                                <input type="number" class="form-control" required name="cattale_no[]"
                                    value="{{ $animal->cattale_no ?? '' }}" placeholder="पशु की जानकारी"
                                    autocomplete="off">
                            </div>

                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" required name="milk_day[]"
                                    value="{{ $animal->milk_day ?? '' }}" placeholder="दूध/प्रतिदिन/प्रति पशु"
                                    autocomplete="off">
                            </div>
                            <div class="form-group col-md-1">
                                @if(!$loop->first)
                                <button type="button" data-animalId="{{ $animal->id ?? '' }}"
                                    class="remove btn btn-danger btn-sm">हटाएं</button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="block row adddiv">
                            <input type="hidden" name="animal_id[]" value="">
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

                            <div class="form-group col-md-3">
                                <select class="form-control" required name="animal_type[]">
                                    <option value="">एक का चयन करें</option>
                                    <option value="cow">गाय</option>
                                    <option value="buffalo">भैंस</option>
                                    <option value="goat">बकरी</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <input type="text" class="form-control" required name="breeds[]" value=""
                                    placeholder="गाय/भैंस/बकरी की नस्लें" autocomplete="off">
                            </div>

                            <div class="form-group col-md-3">
                                <input type="number" class="form-control" required name="cattale_no[]"
                                    value="" placeholder="पशु की जानकारी" autocomplete="off">
                            </div>

                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" required name="milk_day[]"
                                    value="" placeholder="दूध/प्रतिदिन/प्रति पशु" autocomplete="off">
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

<script>
$(document).ready(function() {
    $('#division').change(function() {
        $('#mandal').empty();
        $('#vikas_khand').empty();
        $('#tehsil').empty();

        var val = $("#division option:selected").val();
        var text = $("#division option:selected").text().trim();

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
                    $('#mandal').append(`<option value="">जिला चुने</option>`);
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

        var mandal = $("#division option:selected").text().trim();
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
                    $('#tehsil').append(`<option value="">तहसील चुनें</option>`);
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
        var mandal = $("#division option:selected").text().trim();
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
                    $('#vikas_khand').append(`<option value="">विकास खंड चुनें</option>`);
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
            var newField = '<div class="block row"> \
                    <input type="hidden" name="animal_id[]" value=""> \
                    <div class="form-group col-md-3">\
                        <select class="form-control" name="animal_type[]" required>\
                            <option value="">एक का चयन करें</option>\
                            <option value="cow">गाय</option>\
                            <option value="buffalo">भैंस</option>\
                            <option value="goat">बकरी</option>\
                        </select>\
                    </div>\
                    <div class="form-group col-md-3">\
                        <input type="text" class="form-control" name="breeds[]" required autocomplete="off" placeholder="गाय/भैंस/बकरी की नस्लें">\
                    </div>\
                    <div class="form-group col-md-3">\
                        <input type="number" class="form-control" name="cattale_no[]" required placeholder="पशु की जानकारी" autocomplete="off">\
                    </div>\
                    <div class="form-group col-md-2">\
                        <input type="text" class="form-control" name="milk_day[]" required placeholder="दूध/प्रतिदिन/प्रति पशु" autocomplete="off">\
                    </div>\
                    <div class="form-group col-md-1"> \
                        <span class="remove btn btn-danger btn-sm">हटाएं</span> \
                    </div> \
                </div>';

            $('.optionBox .block:last').after(newField);
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
