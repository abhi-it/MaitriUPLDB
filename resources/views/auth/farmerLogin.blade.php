@extends('master')
@section('content')
<style>
.radio-option {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 30px 0;
}

.radio-option .form-check-label {
    padding-left: 0 !important;
}

.hide_field {
    display: none;
}

.error {
    color: red;
    font-size: 14px;
}
</style>
<?php
    use Illuminate\Support\Facades\Crypt;
    $UserKey = Hash::make('GoKulMisSiOn@1#2$3');
    Session::put('UserKey', $UserKey);
    ?>
<div class="container main-div" style="background-color:white; ">
    <!--First row Start -->

    <h3 class="text-center fw-bold m-4"><span data-hi="किसान लॉगिन" data-en="Farmer login"></span></h3>
    @if (session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif

    <div class="mairti-farmer-form">
        <form id="maitriFarmerloginForm">

            <div class="row mb-3 mt-3">
                <label for="mobileNumber" class="col-md-4 col-form-label text-md-right">{{ __('मोबाइल नंबर') }}</label>
                <div class="col-md-6">
                    <input id="mobileNumber" type="number"
                        class="form-control @error('mobileNumber') is-invalid @enderror" name="mobileNumber"
                        value="{{ old('email') }}" autocomplete="mobileNumber" autofocus>
                    <span class="error" id="mobile_err"></span>
                </div>
            </div>

            <div class="row mb-3 mt-3 otp_div hide_field">
                <label for="mobileNumber"
                    class="col-md-4 col-form-label text-md-right">{{ __('ओटीपी दर्ज करें') }}</label>
                <div class="col-md-6">
                    <input id="otp-enter" type="number" class="form-control @error('otp-enter') is-invalid @enderror"
                        name="otpEnter" value="{{ old('otp-enter') }}" autocomplete="otpEnter" autofocus>
                    <span class="error" id="otp_err"></span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mb-4 mt-4 send_otp_btn">
                <div class="col-md-8 offset-md-4">
                    <button type="button" class="btn btn-primary" id="send-otp">
                        {{ __('Send OTP') }}
                    </button>
                </div>
            </div>

            <div class="row mb-4 mt-4 login_btn hide_field">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary" id="btn">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>

        </form>
    </div>

    <!--First row Closed-->
</div>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    jQuery('#send-otp').click(function() {
        jQuery('#mobile_err').empty();
        let phone = jQuery('#mobileNumber').val();


        if (phone === '' || phone.length !== 10) {
            $('#mobile_err').text('कृपया वैध मोबाइल नंबर दर्ज करें');
            return;
        } else {
            $('#mobile_err').text('');
        }

        $.ajax({
            url: 'send-otp-faramer-maitri',
            type: 'GET',
            data: {
                phone: phone,
            },
            success: function(response) {
                if (response.status == 'error') {
                    jQuery('#mobile_err').append(response.message);
                } else {
                    jQuery('.otp_div').removeClass('hide_field');
                    jQuery('.login_btn').removeClass('hide_field');
                    jQuery('.send_otp_btn').css('display', 'none');
                }
            },
            error: function(xhr, status, error) {
                // Handle error
                alert('An error occurred: ' + error);
            }
        });
    })

    $('#maitriFarmerloginForm').submit(function(e) {
        e.preventDefault();
        var mobileNumber = $('#mobileNumber').val();
        var otp = $('#otp-enter').val();

        if (otp === '' || otp.length !== 5) {
            $('#otp_err').text('कृपया सही ओटीपी दर्ज करें');
            return;
        } else {
            $('#otp_err').text('');
        }

        $.ajax({
            url: "/login-farmer-maitri",
            type: "POST",
            data: {
                mobileNumber: mobileNumber,
                otp: otp,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.status == "success" && response.loginStatus == 'farmer') {
                    window.location.href = "/farmer-dashboard";
                } else if (response.status == "success" && response.loginStatus ==
                    'maitri') {
                    window.location.href = "/maitri-dashboard";
                } else {
                    $('#otp_err').text("अमान्य ओटीपी, कृपया पुनः प्रयास करें।");
                }
            },
            error: function(xhr) {
                alert("लॉगिन में त्रुटि हुई।");
            }
        });
    });


    var $validator = $('#loginForm').validate({

        highlight: function(element) {
            $(element).parent().addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).parent().removeClass('has-error');
        },

        doNotHideMessage: true,
        errorElement: 'span',
        errorClass: 'error',

        rules: {
            "email": {
                required: true,
                email: true,
            },
            "password": {
                required: true,
            },

        },
        submitHandler: function(form) {
            var pwd = btoa($('#password').val());
            $("#password").val(pwd + '<?php echo $UserKey; ?>');
            //return false;
            form.submit();
        },
    });


});
</script>
@endsection