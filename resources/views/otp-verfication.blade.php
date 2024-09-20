@extends('master')
@section('content')

    <div class="container main-div" style="background-color:white; ">
        <!--First row Start -->

        <h3 class="text-center fw-bold m-4"><span data-hi="ओटीपी सत्यापन" data-en="OTP Verification"></span> </h3>
        @if (session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('otpverification') }}" id="loginForm" name="loginForm">
            @csrf

            <div class="row mb-3">
                <label for="otp" class="col-md-4 col-form-label text-md-right">{{ __('ओटीपी') }}</label>

                <div class="col-md-6">
                    <input id="otp" type="number" class="form-control @error('number') is-invalid @enderror"
                        name="otp" min="6" onKeyPress="if(this.value.length==6) return false">
                </div>
            </div>
            <div class="row mb-4 mt-4">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary" id="btn">
                        <span data-hi="सबमिट" data-en="Submit"></span>
                    </button>
                </div>
            </div>
        </form>
        <!--First row Closed-->
    </div>
@endsection
