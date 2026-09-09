@extends('master')
@section('content')
    <style>
        .login-form-box {
            display: none;
        }
        .login-form-box.active {
            display: block;
        }

        .radio-option {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .radio-option .form-check-label {
            padding-left: 0 !important;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
    <?php
    $UserKey = Hash::make('GoKulMisSiOn@1#2$3');
    Session::put('UserKey', $UserKey);
    ?>
    <div class="container main-div" style="background-color:white;">
        <h3 class="text-center fw-bold m-4">Login</h3>

        @php
            $hideAdmin = request()->boolean('hideAdmin');
            $isInstitute = request()->boolean('isInstitute');
            $isMaitriFarmer = request()->boolean('isMaitriFarmer');

            if ($isInstitute) {
                $activeLogin = 'institute';
            } elseif ($isMaitriFarmer || $hideAdmin) {
                $activeLogin = 'maitriFarmer';
            } else {
                $activeLogin = 'admin';
            }
        @endphp

        @if (session('success'))
            <div class="alert alert-danger">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="radio-option">
            @if (!$hideAdmin)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="checkOption" id="admin" value="admin"
                        {{ $activeLogin === 'admin' ? 'checked' : '' }}>
                    <label class="form-check-label" for="admin">Admin</label>
                </div>
            @endif
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="checkOption" id="maitriFarmer" value="maitriFarmer"
                    {{ $activeLogin === 'maitriFarmer' ? 'checked' : '' }}>
                <label class="form-check-label" for="maitriFarmer">Maitri/Farmer</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="checkOption" id="institute" value="institute"
                    {{ $activeLogin === 'institute' ? 'checked' : '' }}>
                <label class="form-check-label" for="institute">Institute</label>
            </div>
        </div>

        <div class="login-form-box admin-form {{ $activeLogin === 'admin' ? 'active' : '' }}">
            <form method="POST" action="{{ route('login') }}" id="loginForm" name="loginForm">
                @csrf
                <div class="row mb-3">
                    <label for="admin_email" class="col-md-4 col-form-label text-md-right text-dark">{{ __('ईमेल पता') }}</label>
                    <div class="col-md-6">
                        <input id="admin_email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ $activeLogin === 'admin' ? old('email') : '' }}" autocomplete="username">
                        <span class="error" id="admin_email_err"></span>
                        @error('email')
                            @if($activeLogin === 'admin')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @endif
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="admin_password" class="col-md-4 col-form-label text-md-right text-dark">{{ __('पासवर्ड') }}</label>
                    <div class="col-md-6">
                        <input id="admin_password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" autocomplete="current-password">
                        <span class="error" id="admin_password_err"></span>
                        @error('password')
                            @if($activeLogin === 'admin')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @endif
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="admin_remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-dark" for="admin_remember">{{ __('Remember Me') }}</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-4 mt-4">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="login-form-box mairti-farmer-form {{ $activeLogin === 'maitriFarmer' ? 'active' : '' }}">
            <form method="POST" action="{{ route('maitri-farmer-login') }}" id="maitriFarmerLoginForm">
                @csrf
                <div class="row mb-3">
                    <label for="maitri_email" class="col-md-4 col-form-label text-md-right text-dark">{{ __('ईमेल पता') }}</label>
                    <div class="col-md-6">
                        <input id="maitri_email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ $activeLogin === 'maitriFarmer' ? old('email') : '' }}" autocomplete="username" required>
                        @error('email')
                            @if($activeLogin === 'maitriFarmer')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @endif
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="maitri_password" class="col-md-4 col-form-label text-md-right text-dark">{{ __('पासवर्ड') }}</label>
                    <div class="col-md-6">
                        <input id="maitri_password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" autocomplete="current-password" required>
                        @error('password')
                            @if($activeLogin === 'maitriFarmer')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @endif
                        @enderror
                    </div>
                </div>
                <div class="row mb-4 mt-4">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="login-form-box institute-form {{ $activeLogin === 'institute' ? 'active' : '' }}">
            <form method="POST" action="{{ route('institute.login') }}" id="instituteLoginForm">
                @csrf
                <div class="row mb-3">
                    <label for="institute_email" class="col-md-4 col-form-label text-md-right text-dark">{{ __('ईमेल पता') }}</label>
                    <div class="col-md-6">
                        <input id="institute_email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ $activeLogin === 'institute' ? old('email') : '' }}" autocomplete="username" required>
                        @error('email')
                            @if($activeLogin === 'institute')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @endif
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="institute_password" class="col-md-4 col-form-label text-md-right text-dark">{{ __('पासवर्ड') }}</label>
                    <div class="col-md-6">
                        <input id="institute_password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" autocomplete="current-password" required>
                        @error('password')
                            @if($activeLogin === 'institute')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @endif
                        @enderror
                    </div>
                </div>
                <div class="row mb-4 mt-4">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function showLoginForm(type) {
                $('.login-form-box').removeClass('active');
                if (type === 'admin') {
                    $('.admin-form').addClass('active');
                } else if (type === 'maitriFarmer') {
                    $('.mairti-farmer-form').addClass('active');
                } else if (type === 'institute') {
                    $('.institute-form').addClass('active');
                }
            }

            showLoginForm($('input[name="checkOption"]:checked').val() || '{{ $activeLogin }}');

            $('input[name="checkOption"]').change(function() {
                showLoginForm($(this).val());
            });

            $('#loginForm').validate({
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
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                submitHandler: function(form) {
                    var pwd = btoa($('#admin_password').val());
                    $('#admin_password').val(pwd + '<?php echo $UserKey; ?>');
                    form.submit();
                }
            });
        });
    </script>
@endsection
