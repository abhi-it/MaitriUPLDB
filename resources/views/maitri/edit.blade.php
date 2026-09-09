@extends('master')
@section('content')

<style>
.password-hint {
    font-size: 12px;
    color: #6c757d;
}
</style>
<div class="container main-div py-5" style="background-color:white;">
    <h3 class="text-center fw-bold m-4">
        <span data-hi="मैत्री रिकॉर्ड संपादित करें" data-en="Edit Maitri Record"></span>
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

    <form method="post" action="{{ route('update-maitri-data', $maitri->id) }}" class="form-comman">
        @csrf
        <div class="row">
            <div class="form-group col-md-4">
                <label for="maitri_name">
                    <span data-hi="मैत्री नाम" data-en="Maitri Name"></span>
                </label>
                <input type="text" class="form-control" name="maitri_name" id="maitri_name" required
                    value="{{ old('maitri_name', $maitri->maitri_name) }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="maitri_mobile_no">
                    <span data-hi="मोबाइल नंबर" data-en="Mobile Number"></span>
                </label>
                <input type="text" class="form-control" name="maitri_mobile_no" id="maitri_mobile_no" required
                    value="{{ old('maitri_mobile_no', $maitri->maitri_mobile_no) }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="gender">
                    <span data-hi="लिंग" data-en="Gender"></span>
                </label>
                <select class="form-control" name="gender" id="gender">
                    <option value="">Select</option>
                    <option value="male" {{ old('gender', $maitri->gender) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $maitri->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="others" {{ old('gender', $maitri->gender) == 'others' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label for="email">
                    <span data-hi="ईमेल" data-en="E-mail"></span>
                </label>
                <input type="email" class="form-control" name="email" id="email"
                    value="{{ old('email', $maitri->email) }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="password">
                    <span data-hi="पासवर्ड" data-en="Password"></span>
                </label>
                <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                <small class="password-hint">
                    <span data-hi="वर्तमान पासवर्ड रखने के लिए खाली छोड़ें" data-en="Leave blank to keep current password"></span>
                </small>
            </div>

            <div class="form-group col-md-4">
                <label for="password_confirmation">
                    <span data-hi="पासवर्ड की पुष्टि करें" data-en="Confirm Password"></span>
                </label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    autocomplete="new-password">
            </div>

            <div class="form-group col-md-4">
                <label for="father_name">
                    <span data-hi="पिता का नाम" data-en="Father's Name"></span>
                </label>
                <input type="text" class="form-control" name="father_name" id="father_name"
                    value="{{ old('father_name', $maitri->father_name) }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="father_mobile_no">
                    <span data-hi="पिता का मोबाइल" data-en="Father Mobile"></span>
                </label>
                <input type="text" class="form-control" name="father_mobile_no" id="father_mobile_no"
                    value="{{ old('father_mobile_no', $maitri->father_mobile_no) }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="adhaar_card">
                    <span data-hi="आधार कार्ड" data-en="Aadhaar Card"></span>
                </label>
                <input type="text" class="form-control" name="adhaar_card" id="adhaar_card"
                    value="{{ old('adhaar_card', $maitri->adhaar_card) }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="certificate_no">
                    <span data-hi="प्रमाण पत्र संख्या" data-en="Certificate No"></span>
                </label>
                <input type="text" class="form-control" name="certificate_no" id="certificate_no"
                    value="{{ old('certificate_no', $maitri->certificate_no) }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="any_bharat_id">
                    <span data-hi="भारत आईडी" data-en="Bharat ID"></span>
                </label>
                <input type="text" class="form-control" name="any_bharat_id" id="any_bharat_id"
                    value="{{ old('any_bharat_id', $maitri->any_bharat_id) }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="center_name">
                    <span data-hi="केंद्र का नाम" data-en="Center Name"></span>
                </label>
                <input type="text" class="form-control" name="center_name" id="center_name"
                    value="{{ old('center_name', $maitri->center_name) }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="pass_date">
                    <span data-hi="पास तिथि" data-en="Pass Date"></span>
                </label>
                <input type="date" class="form-control" name="pass_date" id="pass_date"
                    value="{{ old('pass_date', $maitri->pass_date) }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="expiry_date">
                    <span data-hi="समाप्ति तिथि" data-en="Expiry Date"></span>
                </label>
                <input type="date" class="form-control" name="expiry_date" id="expiry_date"
                    value="{{ old('expiry_date', $maitri->expiry_date) }}" autocomplete="off">
            </div>

            <div class="form-group col-md-6">
                <label for="district">
                    <span data-hi="मंडल" data-en="Mandal"></span>
                </label>
                <select name="division_id" id="district" class="form-control" required>
                    <option value="">Select Mandal</option>
                    @foreach($divisions as $val)
                    <option value="{{ $val->id }}" {{ old('division_id', $maitri->division_id) == $val->id ? 'selected' : '' }}>
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
                        {{ old('district_id', $maitri->district_id) == $district->id ? 'selected' : '' }}>
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
                    @if(old('tehsil', $maitri->tehsil))
                    <option value="{{ old('tehsil', $maitri->tehsil) }}" selected>
                        {{ old('tehsil', $maitri->tehsil) }}
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
                    @if(old('block', $maitri->block))
                    <option value="{{ old('block', $maitri->block) }}" selected>
                        {{ old('block', $maitri->block) }}
                    </option>
                    @else
                    <option value="">Select Vikas Khand</option>
                    @endif
                </select>
            </div>

            <div class="form-group col-md-4">
                <label for="gram_panchayat">
                    <span data-hi="ग्राम पंचायत" data-en="Gram Panchayat"></span>
                </label>
                <input type="text" class="form-control" name="gram_panchayat" id="gram_panchayat"
                    value="{{ old('gram_panchayat', $maitri->gram_panchayat) }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="post_office">
                    <span data-hi="पोस्ट ऑफिस" data-en="Post Office"></span>
                </label>
                <input type="text" class="form-control" name="post_office" id="post_office"
                    value="{{ old('post_office', $maitri->post_office) }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="pincode">
                    <span data-hi="पिनकोड" data-en="Pincode"></span>
                </label>
                <input type="text" class="form-control" name="pincode" id="pincode" maxlength="6"
                    value="{{ old('pincode', $maitri->pincode) }}" autocomplete="off">
            </div>

            <div class="form-group col-md-6">
                <label for="latitude">Latitude</label>
                <input type="text" class="form-control" name="latitude" id="latitude"
                    value="{{ old('latitude', $maitri->latitude) }}" autocomplete="off">
            </div>

            <div class="form-group col-md-6">
                <label for="longitude">Longitude</label>
                <input type="text" class="form-control" name="longitude" id="longitude"
                    value="{{ old('longitude', $maitri->longitude) }}" autocomplete="off">
            </div>
        </div>

        <div class="row">
            <div class="mb-4 mt-4 text-center">
                <button type="submit" class="btn btn-primary">
                    <span data-hi="अपडेट करें" data-en="Update"></span>
                </button>
                <a href="{{ route('maitri-listing') }}" class="btn btn-secondary">
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
});
</script>
@endsection
