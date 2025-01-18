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

/*.modal-dialog {
    max-width: 40% !important;
}*/

.openModal {
    display: none;
}

.contain-form {
    margin: auto;
    padding: 20px;
}
</style>
<div class="container main-div">
    <!-- <h3 style="margin-top:10px;text-align: center;">Service Request Form</h3> -->
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
        <div class="col-sm-3">
            <div class="card text-center">
                <div class="card-header">सेवा अनुरोध सूची</div>
                <div class="card-body">
                    <h5 class="card-title">{{ count($data) }}</h5>
                    <a href="{{ url('/farmer-requests') }}" class="btn btn-primary">देखना</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">प्रतिपुष्टी फ़ार्म</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" enctype="multipart/form-data" action="{{route('farmer-dashdata')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">बीमा:</label>
                        <select class="form-control" id="insurance" name="insurance" required>
                            <option value="no">नहीं</option>
                            <option value="yes">हाँ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="animal_file" class="col-form-label">प्रतिक्रिया</label>
                        <textarea id="feedback" class="form-control" name="feedback" rows="4" cols="50"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">बंद करे</button>
                    <button type="submit" class="btn btn-primary" id="submit">जमा करें</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- User Details Modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailsModalLabel">अपना विवरण पूरा करें</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('update-farmer-details') }}" class="form-comman">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="inputEmail4">
                                <span>नाम</span>
                            </label>
                            <input type="text" class="form-control" name="first_name" id="first_name" required
                                placeholder="नाम" autocomplete="off">
                        </div>


                        <div class="form-group col-md-4">
                            <label for="inputPassword4">
                                <span>मोबाइल नंबर</span>
                            </label>
                            <input type="number" class="form-control" id="MobileNumber" name="MobileNumber" required
                                placeholder="मोबाइल नंबर" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputEmail4"> <span>लिंग</span></label>
                            <select class="form-control" name="gender" id="gender" required>
                                <option value="">एक का चयन करें</option>
                                <option value="male">पुरुष</option>
                                <option value="female">महिला</option>
                                <option value="others">अन्य</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="animal">
                                <span>पशु की जानकारी</span>
                            </label>
                            <div class="optionBox">
                                <div class="block row adddiv_0">
                                    <div class="form-group col-md-3">
                                        <select class="form-control" id="animal_type" name="animal_type[]" required>
                                            <option value="">एक का चयन करें</option>
                                            <option value="cow">गाय</option>
                                            <option value="buffalo">भैंस</option>
                                            <option value="goat">बकरी</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="text" class="form-control" id="breeds" name="breeds[]" required
                                            placeholder="गाय/भैंस/बकरी की नस्लें" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="number" class="form-control" id="cattale_no" name="cattale_no[]"
                                            required placeholder="पशु की जानकारी" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <input type="text" class="form-control" id="milk_day" name="milk_day[]" required
                                            placeholder="दूध/प्रतिदिन/प्रति पशु" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-1">
                                        <span class="add btn btn-primary btn-sm">जोड़ें</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4"> <span>मंडल</span></label>
                            <select name="division_id" id="district" class="form-control" autofocus required>
                                <option value="">मंडल चुनें</option>
                                @if(count($divisions)>0)
                                @foreach($divisions as $key => $val)
                                <option value="{{$val->id}}">{{$val->name_hindi}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4"> <span>ज़िला</span></label>
                            <select name="district_id" id="mandal" class="form-control" autofocus required>

                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4"> <span>तहसील</span></label>
                            <select name="tehsil" id="tehsil" class="form-control" autofocus required>

                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4"> <span>विकास खण्ड</span></label>
                            <select name="block" id="vikas_khand" class="form-control" autofocus required>

                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4"> <span>पोस्ट ऑफिस</span></label>
                            <input type="text" name="post_office" id="post_office" required class="form-control"
                                placeholder="पोस्ट ऑफिस" autofocus>
                        </div>


                        <div class="form-group col-md-6">
                            <label for="inputEmail4"><span>पिनकोड</span></label>
                            <span id="error-message" style="color: red; display:none; font-size:10px; ">(Pincode must be
                                a 6-digit
                                number.)</span>
                            <input type="text" name="pincode" maxlength="6" id="pincode" required class="form-control"
                                placeholder="यहां पिनकोड दर्ज करें" autofocus>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputPassword4">
                                <span>ग्राम पंचायत</span>
                            </label>
                            <input type="text" class="form-control" id="gram_panchayat" required name="gram_panchayat"
                                required placeholder="ग्राम पंचायत" autocomplete="off">
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
</div>


@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {

    // $(window).on('load', function() {
    //     var modelShown = localStorage.getItem('farmer');
    //     console.log('localStorage', localStorage, modelShown)
    //     if (modelShown != 'YES') {
    //         $('#exampleModal').modal('show');
    //         localStorage.setItem('farmer', 'YES');
    //     }
    // });

    $('.optionBox').on('click', '.add', function() {
        var newRow = $(this).closest('.block').clone();
        newRow.find('input').val('');
        newRow.find('.add').removeClass('add btn-primary').addClass('remove btn-danger').text(
            'हटाएं');
        $('.optionBox').append(newRow);
    });

    // Function to remove a row
    $('.optionBox').on('click', '.remove', function() {
        $(this).closest('.block').remove(); // Remove the row
    });

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
        url: "{{ route('check.user.details') }}",
        type: "GET",
        success: function(response) {
            if (response.status === "not_filled") {

                var getUserData = response.userData;
                var district = response.districtName;
                $('#first_name').val(getUserData.FirstName);
                $('#MobileNumber').val(getUserData.MobileNumber);
                $('#gender').val(getUserData.gender);
                $('#user_id').val(getUserData.id);
                $('#post_office').val(getUserData.post_office);
                $('#pincode').val(getUserData.pincode);
                $('#gram_panchayat').val(getUserData.gram_panchayat);

                // $('.optionBox').empty();
                $.each(response.animal_type, function(index, animalType) {
                    var breed = response.breeds[index];
                    var cattaleNo = response.cattale_no[index];
                    var milkDay = response.milk_day[index];

                    var newRow = `
                    <div class="block row adddiv_${index}">
                        <div class="form-group col-md-3">
                            <select class="form-control" name="animal_type[]" required>
                                <option value="cow" ${animalType === 'cow' ? 'selected' : ''}>गाय</option>
                                <option value="buffalo" ${animalType === 'buffalo' ? 'selected' : ''}>भैंस</option>
                                <option value="goat" ${animalType === 'goat' ? 'selected' : ''}>बकरी</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <input type="text" class="form-control" name="breeds[]" required value="${breed}" placeholder="गाय/भैंस/बकरी की नस्लें" autocomplete="off">
                        </div>
                        <div class="form-group col-md-3">
                            <input type="number" class="form-control" name="cattale_no[]" required value="${cattaleNo}" placeholder="पशु की जानकारी" autocomplete="off">
                        </div>
                        <div class="form-group col-md-2">
                            <input type="text" class="form-control" name="milk_day[]" required value="${milkDay}" placeholder="दूध/प्रतिदिन/प्रति पशु" autocomplete="off">
                        </div>
                        <div class="form-group col-md-1">
                            <span class="remove btn btn-danger btn-sm">हटाएं</span>
                        </div>
                    </div>`;
                    $('.optionBox').append(newRow);
                });

                $('.optionBox').on('click', '.remove', function() {
                    $(this).closest('.block').remove();
                });

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
                $('#exampleModal').modal('show');
                $('#userDetailsModal').modal('show');

            } else if (response.status === "filled") {
                console.log("User details are already filled.");
            }
        },
        error: function(xhr) {
            console.error("An error occurred:", xhr.responseJSON.message);
        }
    });

    $('#user-details-form').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: "/submit-user-details",
            type: "POST",
            data: formData,
            success: function(response) {
                alert("Details submitted successfully!");
                $('#userDetailsModal').modal('hide');
            },
            error: function(xhr) {
                console.error("An error occurred:", xhr.responseJSON.message);
            }
        });
    });
});
</script>