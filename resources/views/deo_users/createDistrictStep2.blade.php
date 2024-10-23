@extends('master')
@section('content')
    <style>
        .search__button {
            display: flex;
            align-items: flex-end;
            gap: 10px;
        }

    </style>

    <div x-data="deoUser()" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
        <h3 class="text-center m-4 fw-bold"> <span data-hi="ज़िला ऑपरेटर आईडी बनाएं" data-en="Create District Operator ID"></span> </h3>
        <div class="custom-radio-container">
            <div class="row">
                <div class="col-md-12">


                        <div x-show="errorMessage" class="alert alert-danger" role="alert">
                            <span x-text="errorMessage"></span>
                        </div>


                    <div class="row">

                        <form method="POST" id="deoUserForm" @submit.prevent="submitForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="username" class="col-md-4 col-form-label text-md-right"> <span data-hi="उपयोगकर्ता नाम" data-en="Username"></span> </label>
                                <div class="col-md-6">
                                    <input name="username" id="username" type="text" class="form-control"
                                        autofocus="off" value="{{ old('username') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-right"> <span data-hi="ईमेल" data-en="Email"></span> </label>
                                <div class="col-md-6">
                                    <input name="email" id="email" type="email" class="form-control" autofocus="off"
                                        value="{{ old('email') }}">
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-right"> <span data-hi="पासवर्ड" data-en="Password"></span> </label>
                                <div class="col-md-6">
                                    <input name="password" id="password" type="password" class="form-control"
                                        autofocus="off" value="{{ old('password') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="confirm_password" class="col-md-4 col-form-label text-md-right"> <span data-hi="पासवर्ड पुष्टि करें" data-en="Confirm Password"></span> </label>
                                <div class="col-md-6">
                                    <input name="confirm_password" id="confirm_password" type="password"
                                        class="form-control" autofocus="off" value="{{ old('confirm_password') }}">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" id="btn"> <span data-hi="बनाएं" data-en="Create"></span> </button>
                                </div>
                            </div>

                        </form>

                    </div>



                </div>
            </div>
        </div>



    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        function deoUser() {
            return {
                init() {
                    setInterval(() => {
                        this.errorMessage = null;
                    }, 5000);
                },
                errorMessage: null,
                submitForm() {
                    var thisRef = this;
                    let formData = new FormData(document.getElementById('deoUserForm'));

                    let url = "{{ route('deo-district-store-step2') }}"
                    axios.post(url, formData).then(response => {
                        console.log(response, 'response');
                        if (response.status == 200) {

                            Swal.fire({
                                title: 'Success!',
                                text: 'DEO User created successfully!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = "{{ route('operator-id') }}"
                            });
                        }
                    }).catch(error => {

                        // console.log(error.response.data.errors, 'error.response.data.errors[0]');
                        thisRef.errorMessage = Object.values(error.response.data.errors)[0][0];
                        return false;
                    })
                }
            }
        }
    </script>
@endsection
