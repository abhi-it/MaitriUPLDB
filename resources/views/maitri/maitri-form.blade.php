@extends('master')
@section('content')

<style>
.password-hint {
    font-size: 12px;
    color: #6c757d;
}
</style>
<div class="container main-div py-5" style="background-color:white;">
    <h3 class="text-center fw-bold m-4">सिंगल मैत्री जोड़ें</h3>
    <hr>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('addUpdateMaitri') }}" class="form-comman" id="maitriCreateForm">
        @csrf
        <div class="row">
            <div class="form-group col-md-4">
                <label for="maitri_name">अभ्यर्थी का नाम</label>
                <input type="text" class="form-control" name="maitri_name" id="maitri_name" required
                    value="{{ old('maitri_name') }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="maitri_mobile_no">अभ्यर्थी का मोबाइल नंबर</label>
                <input type="text" class="form-control" name="maitri_mobile_no" id="maitri_mobile_no" required
                    value="{{ old('maitri_mobile_no') }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="gender">लिंग</label>
                <select class="form-control" name="gender" id="gender">
                    <option value="">Select</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="others" {{ old('gender') == 'others' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label for="email">ईमेल</label>
                <input type="email" class="form-control" name="email" id="email" required
                    value="{{ old('email') }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="password">पासवर्ड</label>
                <input type="password" class="form-control" id="password" name="password" required
                    autocomplete="new-password">
                <small class="password-hint">न्यूनतम 8 अक्षर</small>
            </div>

            <div class="form-group col-md-4">
                <label for="password_confirmation">पासवर्ड की पुष्टि करें</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    required autocomplete="new-password">
            </div>

            <div class="form-group col-md-4">
                <label for="father_name">पिता का नाम</label>
                <input type="text" class="form-control" name="father_name" id="father_name"
                    value="{{ old('father_name') }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="father_mobile_no">पिता का मोबाइल नंबर</label>
                <input type="text" class="form-control" name="father_mobile_no" id="father_mobile_no"
                    value="{{ old('father_mobile_no') }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="adhaar_card">आधार कार्ड संख्या</label>
                <input type="text" class="form-control" name="adhaar_card" id="adhaar_card"
                    value="{{ old('adhaar_card') }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="certificate_no">प्रमाणपत्र संख्या</label>
                <input type="text" class="form-control" name="certificate_no" id="certificate_no"
                    value="{{ old('certificate_no') }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="any_bharat_id">प्रशिक्षण से पूर्व इनाफ भारत पशुधन की आई डी</label>
                <input type="text" class="form-control" name="any_bharat_id" id="any_bharat_id"
                    value="{{ old('any_bharat_id') }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="center_name">प्रशिक्षण केंद्र का नाम</label>
                <input type="text" class="form-control" name="center_name" id="center_name"
                    value="{{ old('center_name') }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="pass_date">सत्र एवं दिनांक</label>
                <input type="text" class="form-control" name="pass_date" id="pass_date"
                    value="{{ old('pass_date') }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="expiry_date">प्रशिक्षण अवधि (कब से कब तक)</label>
                <input type="text" class="form-control" name="expiry_date" id="expiry_date"
                    value="{{ old('expiry_date') }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="equipment_received">उपकरण प्राप्त है या नहीं</label>
                <input type="text" class="form-control" name="equipment_received" id="equipment_received"
                    value="{{ old('equipment_received') }}" autocomplete="off">
            </div>

            <div class="form-group col-md-6">
                <label for="district">मंडल का नाम</label>
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
                <label for="mandal">जनपद का नाम</label>
                <select name="district_id" id="mandal" class="form-control" required>
                    <option value="">Select District</option>
                    @if(old('district_id'))
                    @foreach($districts as $district)
                    <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>
                        {{ $district->name_hindi }}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="tehsil">तहसील</label>
                <select name="tehsil" id="tehsil" class="form-control">
                    @if(old('tehsil'))
                    <option value="{{ old('tehsil') }}" selected>{{ old('tehsil') }}</option>
                    @else
                    <option value="">Select Tehsil</option>
                    @endif
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="vikas_khand">ब्लॉक</label>
                <select name="block" id="vikas_khand" class="form-control">
                    @if(old('block'))
                    <option value="{{ old('block') }}" selected>{{ old('block') }}</option>
                    @else
                    <option value="">Select Block</option>
                    @endif
                </select>
            </div>

            <div class="form-group col-md-4">
                <label for="gram_panchayat">ग्राम पंचायत</label>
                <input type="text" class="form-control" name="gram_panchayat" id="gram_panchayat"
                    value="{{ old('gram_panchayat') }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="post_office">पोस्ट ऑफिस</label>
                <input type="text" class="form-control" name="post_office" id="post_office"
                    value="{{ old('post_office') }}" autocomplete="off">
            </div>

            <div class="form-group col-md-4">
                <label for="pincode">पिनकोड</label>
                <input type="text" class="form-control" name="pincode" id="pincode" maxlength="6"
                    value="{{ old('pincode') }}" autocomplete="off">
            </div>

            <div class="form-group col-md-6">
                <label for="latitude">अक्षांश</label>
                <input type="text" class="form-control" name="latitude" id="latitude"
                    value="{{ old('latitude') }}" autocomplete="off">
            </div>

            <div class="form-group col-md-6">
                <label for="longitude">देशान्तर</label>
                <input type="text" class="form-control" name="longitude" id="longitude"
                    value="{{ old('longitude') }}" autocomplete="off">
            </div>
        </div>

        <div class="row">
            <div class="mb-4 mt-4 text-center">
                <button type="submit" class="btn btn-primary" id="btn">सबमिट</button>
                <a href="{{ route('maitri-listing') }}" class="btn btn-secondary">वापस जाएं</a>
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
                    $('#vikas_khand').append(`<option value="">Select Block</option>`);
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
