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
            <form method="post" action="{{ route('update-maitri-details') }}" class="form-comman">
                @csrf
                <input type="hidden" name="user_id" value="{{ $id ?? '' }}">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="first_name">
                            <span>नाम</span>
                        </label>
                        <input type="text" class="form-control" required name="first_name" id="first_name"
                            value="{{ $data->maitri_name ?? '' }}" placeholder="नाम" autocomplete="off">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="MobileNumber">
                            <span>मोबाइल नंबर</span>
                        </label>
                        <input type="number" class="form-control" required id="MobileNumber" name="MobileNumber"
                            value="{{ $data->maitri_mobile_no ?? '' }}" placeholder="मोबाइल नंबर" autocomplete="off">
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
                        <select name="division_id" id="district" required class="form-control">
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
                            <option value="">ज़िला चुनें</option>
                            @foreach($districts as $district)
                            <option value="{{ $district->id }}"
                                {{ isset($data->district_id) && $data->district_id == $district->id ? 'selected' : '' }}>
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



    $('#district').change(function() {
        $('#mandal').prop('disabled', false);
        $('#mandal').empty();
        $('#vikas_khand').prop('disabled', false);
        $('#vikas_khand').empty();
        $('#ai_center').prop('disabled', false);
        $('#ai_center').empty();
        $('#tehsil').prop('disabled', false);
        $('#tehsil').empty();

        var val = $("#district option:selected").val();
        var text = $("#district option:selected").text();
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

    $.ajax({
        url: "{{ route('check-maitri-details') }}",
        type: "GET",
        success: function(response) {


            var getUserData = response.userData;
            var district = response.districtName;
            $('#first_name').val(getUserData.FirstName);
            $('#MobileNumber').val(getUserData.MobileNumber);
            $('#gender').val(getUserData.gender);
            $('#user_id').val(getUserData.id);
            $('#post_office').val(getUserData.post_office);
            $('#pincode').val(getUserData.pincode);
            $('#gram_panchayat').val(getUserData.gram_panchayat);
            $('.optionBox').empty();



            if (getUserData.division_id) {
                $('#district').val(getUserData.division_id);
                $('#district').change();
                $('#district option[value="' + getUserData.division_id + '"]').click();
            }

            setTimeout(() => {
                if (district) {
                    $('#mandal').val(district);
                    $('#mandal').change();
                    $('#mandal option[value="' + district + '"]').click();
                }
            }, 1000);

            setTimeout(() => {
                if (getUserData.tehsil) {
                    $('#tehsil').val(getUserData.tehsil);
                    $('#tehsil').change();
                    $('#tehsil option[value="' + getUserData.tehsil + '"]').click();
                }
            }, 1300);

            setTimeout(() => {
                if (getUserData.block) {
                    $('#vikas_khand').val(getUserData.block);
                    $('#vikas_khand').change();
                    $('#vikas_khand option[value="' + getUserData.block + '"]')
                        .click();
                }
            }, 1600);


        },
        error: function(xhr) {
            console.error("An error occurred:", xhr.responseJSON.message);
        }
    });

});
</script>
