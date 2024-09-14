@extends('master')
@section('content')
    <?php
    use Illuminate\Support\Facades\Crypt;
    $UserKey = Hash::make('GoKulMisSiOn@1#2$3');
    Session::put('UserKey', $UserKey);
    ?>
    <div class="container main-div" style="background-color:white; ">
        <!--First row Start -->

        <h3 class="text-center fw-bold m-4">Login </h3>
        @if (session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}" id="loginForm" name="loginForm">
            @csrf

            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('ईमेल पता') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                    <span class="error" id="email_err"></span>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('पासवर्ड') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" autocomplete="current-password">
                    <span class="error" id="password_err"></span>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
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

            <div class="row mb-4 mt-4">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary" id="btn">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>
        </form>
        <!--First row Closed-->
    </div>
    <script>
        $(document).ready(function() {

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
