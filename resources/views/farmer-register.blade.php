@extends('master')
@section('content')

<style>
.password-hint {
    font-size: 12px;
    color: #6c757d;
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
        <span data-hi="पशुपालक पंजीकरण फॉर्म" data-en="Farmer Signup / Registration"></span>
    </h3>
    <hr>
    <p class="text-center mb-4">
        पहले से खाता है?
        <a href="{{ route('login', ['isMaitriFarmer' => true]) }}">लॉगिन करें</a>
    </p>

    <form method="post" action="{{ route('farmer-add') }}" class="form-comman" id="farmerSignupForm">
        @csrf
        <div class="row">
            <div class="form-group col-md-4">
                <label for="first_name">
                    <span data-hi="नाम" data-en="First Name"></span>
                </label>
                <input type="text" class="form-control" name="first_name" id="first_name" required
                    value="{{ old('first_name') }}" data-placeholder-hi="नाम" autocomplete="off"
                    data-placeholder-en="First Name">
            </div>

            <div class="form-group col-md-4">
                <label for="last_name">
                    <span data-hi="उपनाम" data-en="Last Name"></span>
                </label>
                <input type="text" class="form-control" name="last_name" id="last_name"
                    value="{{ old('last_name') }}" data-placeholder-hi="उपनाम" autocomplete="off"
                    data-placeholder-en="Last Name">
            </div>

            <div class="form-group col-md-4">
                <label for="MobileNumber">
                    <span data-hi="मोबाइल नंबर" data-en="Mobile Number"></span>
                </label>
                <input type="number" class="form-control" id="MobileNumber" name="MobileNumber" required
                    value="{{ old('MobileNumber') }}" data-placeholder-hi="मोबाइल नंबर" autocomplete="off"
                    data-placeholder-en="Mobile Number">
            </div>

            <div class="form-group col-md-4">
                <label for="gender">
                    <span data-hi="लिंग" data-en="Gender"></span>
                </label>
                <select class="form-control" name="gender" id="gender" required>
                    <option value="">Select</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="others" {{ old('gender') == 'others' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label for="email">
                    <span data-hi="ईमेल" data-en="E-mail"></span>
                </label>
                <input type="email" class="form-control" name="email" id="email" required
                    value="{{ old('email') }}" data-placeholder-hi="ईमेल" autocomplete="off"
                    data-placeholder-en="Email">
            </div>

            <div class="form-group col-md-4">
                <label for="password">
                    <span data-hi="पासवर्ड" data-en="Password"></span>
                </label>
                <input type="password" class="form-control" id="password" name="password" required
                    autocomplete="new-password">
                <small class="password-hint">न्यूनतम 8 अक्षर</small>
            </div>

            <div class="form-group col-md-4">
                <label for="password_confirmation">
                    <span data-hi="पासवर्ड की पुष्टि करें" data-en="Confirm Password"></span>
                </label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    required autocomplete="new-password">
            </div>

            <div class="form-group col-md-12">
                <label for="animal">
                    <span data-hi="पशु की जानकारी" data-en="Number of cattle"></span>
                </label>
                <div class="optionBox">
                    <div class="block row adddiv_0">
                        <div class="form-group col-md-3">
                            <label>पशु प्रकार</label>
                            <select class="form-control" name="animal_type[]" required>
                                <option value="">एक का चयन करें</option>
                                <option value="cow">गाय</option>
                                <option value="buffalo">भैंस</option>
                                <option value="goat">बकरी</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>नस्लें</label>
                            <input type="text" class="form-control" name="breeds[]" required autocomplete="off"
                                placeholder="गाय/भैंस/बकरी की नस्लें">
                        </div>
                        <div class="form-group col-md-3">
                            <label>पशु संख्या</label>
                            <input type="number" class="form-control" name="cattale_no[]" required autocomplete="off"
                                placeholder="पशु की जानकारी">
                        </div>
                        <div class="form-group col-md-2">
                            <label>दूध/प्रतिदिन</label>
                            <input type="text" class="form-control" name="milk_day[]" required autocomplete="off"
                                placeholder="दूध/प्रतिदिन/प्रति पशु">
                        </div>
                        <div class="form-group col-md-1">
                            <label>&nbsp;</label>
                            <span class="add btn btn-primary btn-sm d-block">जोड़ें</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group col-md-6">
                <label for="district">
                    <span data-hi="मंडल" data-en="Mandal"></span>
                </label>
                <select name="division_id" id="district" class="form-control" required>
                    <option value="">Select Mandal</option>
                    @foreach($divisions as $val)
                    <option value="{{ $val->id }}" {{ old('division_id') == $val->id ? 'selected' : '' }}>
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
                    @foreach(($districts ?? []) as $district)
                    <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>
                        {{ $district->name_hindi }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="tehsil">
                    <span data-hi="तहसील" data-en="Tehsil"></span>
                </label>
                <select name="tehsil" id="tehsil" class="form-control" required>
                    @if(old('tehsil'))
                    <option value="{{ old('tehsil') }}" selected>{{ old('tehsil') }}</option>
                    @else
                    <option value="">Select Tehsil</option>
                    @endif
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="vikas_khand">
                    <span data-hi="विकास खण्ड" data-en="Vikas Khand"></span>
                </label>
                <select name="block" id="vikas_khand" class="form-control" required>
                    @if(old('block'))
                    <option value="{{ old('block') }}" selected>{{ old('block') }}</option>
                    @else
                    <option value="">Select Vikas Khand</option>
                    @endif
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="post_office">
                    <span data-hi="पोस्ट ऑफिस" data-en="Post Office"></span>
                </label>
                <input type="text" name="post_office" id="post_office" class="form-control" required
                    value="{{ old('post_office') }}" placeholder="पोस्ट ऑफिस">
            </div>

            <div class="form-group col-md-6">
                <label for="pincode">
                    <span data-hi="पिनकोड" data-en="Pincode"></span>
                </label>
                <input type="text" name="pincode" maxlength="6" id="pincode" class="form-control" required
                    value="{{ old('pincode') }}" placeholder="यहां पिनकोड दर्ज करें">
            </div>

            <div class="form-group col-md-6">
                <label for="gram_panchayat">
                    <span data-hi="ग्राम पंचायत" data-en="Gram Panchayat"></span>
                </label>
                <input type="text" class="form-control" id="gram_panchayat" name="gram_panchayat" required
                    value="{{ old('gram_panchayat') }}" placeholder="ग्राम पंचायत" autocomplete="off">
            </div>
        </div>

        <div class="row">
            <div class="mb-4 mt-4 text-center">
                <button type="submit" class="btn btn-primary submit buttonWizard">
                    <span data-hi="पंजीकरण करें" data-en="Sign Up"></span>
                </button>
                <a href="{{ route('login', ['isMaitriFarmer' => true]) }}" class="btn btn-secondary">
                    <span data-hi="लॉगिन" data-en="Login"></span>
                </a>
            </div>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    @if(old('division_id') && !old('district_id'))
    $('#district').trigger('change');
    @endif

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
    var fieldCount = 0;

    $('.optionBox').on('click', '.add', function() {
        if (fieldCount < maxFields) {
            var newField = '<div class="block row adddiv_' + fieldCount + '"> \
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
        $(this).closest('.block').remove();
        fieldCount--;
        $('.add').show();
    });
});
</script>
@endsection
