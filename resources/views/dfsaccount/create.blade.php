@extends('master')
@section('content')

<div class="container">
    <h3 class="text-center m-4 fw-bold">
        <span data-hi="{{ isset($user) ? 'DFS उपयोगकर्ता को अपडेट करें ' : 'डीएफएस उपयोगकर्ता बनाएं' }}"
            data-en="{{ isset($user) ? 'Update DFS User' :  'Create DFS User' }}"></span>
    </h3>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ isset($user) ? route('dfs-update', $user->id) : route('save-dfs-data') }}" method="post">
        @csrf
        <div class="row">
            <div class="form-group col-md-4">
                <label for="inputEmail4">
                    <span data-hi="नाम" data-en="First Name"></span>
                </label>
                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                    value="{{ $user->FirstName ?? old('first_name') }}" name="first_name" id="first_name"
                    data-placeholder-hi="नाम" autocomplete="off" data-placeholder-en="First Name">
                @error('first_name')
                <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4">
                    <span data-hi="मध्य नाम" data-en="Middle Name"></span>
                </label>
                <input type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name"
                    id="middle_name" data-placeholder-hi="मध्य नाम" value="{{ $user->FirstName ?? old('middle_name') }}"
                    autocomplete="off" data-placeholder-en="Middle Name">
                @error('middle_name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4">
                    <span data-hi="उपनाम" data-en="Last Name"></span>
                </label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                    id="last_name" data-placeholder-hi="उपनाम" autocomplete="off"
                    value="{{ $user->LastName ?? old('last_name') }}" data-placeholder-en="Last Name">
                @error('last_name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-3">
                <label for="inputPassword4">
                    <span data-hi="ईमेल" data-en="E-mail"></span>
                </label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                    data-placeholder-hi="ईमेल" autocomplete="off" value="{{ $user->email ?? old('email') }}"
                    data-placeholder-en="Email">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label for="inputPassword4">
                    <span data-hi="पासवर्ड" data-en="Password"></span>
                </label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" data-placeholder-hi="पासवर्ड" autocomplete="off" value="{{ old('password') }}"
                    data-placeholder-en="Password">
                @error('password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-3">
                <label for="inputPassword4">
                    <span data-hi="मोबाइल नंबर" data-en="Mobile Number"></span>
                </label>
                <input type="number" class="form-control @error('MobileNumber') is-invalid @enderror" id="MobileNumber"
                    name="MobileNumber" data-placeholder-hi="मोबाइल नंबर"
                    value="{{ $user->MobileNumber ?? old('MobileNumber') }}" autocomplete="off"
                    data-placeholder-en="Mobile Number">
                @error('MobileNumber')
                <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>
            <div class="form-group col-md-3">
                <label for="inputEmail4"> <span data-hi="लिंग" data-en="Gender"> </span></label>
                <select class="form-control @error('gender') is-invalid @enderror" name="gender" id="gender">
                    <option value="" data-hi="एक का चयन करें" data-en="Select One"></option>
                    <option value="male" data-hi="पुरुष" data-en="Male"
                        {{ old('gender', $user->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>

                    <option value="female" data-hi="महिला" data-en="Female"
                        {{ old('gender', $user->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>

                    <option value="others" data-hi="अन्य" data-en="Other"
                        {{ old('gender', $user->gender ?? '') == 'others' ? 'selected' : '' }}>Other</option>

                </select>
                @error('gender')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="मंडल" data-en="Mandal"></span> </label>
                <select name="division_id" id="district" class="form-control @error('gender') is-invalid @enderror"
                    autofocus>
                    <option value="" data-hi="मंडल चुनें" data-en="Select Mandal"></option>
                    @if(count($divisions)>0)
                    @foreach($divisions as $key => $val)
                    <option value="{{$val->id}}"
                        {{ old('division_id', $user->division_id ?? '' ) == $val->id ? 'selected' : '' }}>
                        {{$val->name_hindi}}</option>
                    @endforeach
                    @endif
                </select>
                @error('division_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="ज़िला" data-en="District"></span> </label>
                <select name="district_id" id="mandal" class="form-control" autofocus>

                </select>
                @error('district_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="तहसील" data-en="Tehsil"></span> </label>
                <select name="tehsil" id="tehsil" class="form-control" placeholder="तहसील" autofocus>

                </select>
                @error('tehsil')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="विकास खण्ड" data-en="Vikas Khand"></span> </label>
                <select name="block" id="vikas_khand" class="form-control" placeholder="विकास खण्ड" autofocus>

                </select>
                @error('block')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="inputEmail4"> <span data-hi="पोस्ट ऑफिस" data-en="Post Office"></span> </label>
                <input type="text" name="post_office" id="post_office"
                    class="form-control @error('pincode') is-invalid @enderror" placeholder="पोस्ट ऑफिस" autofocus
                    value="{{ old('post_office') }}">
                @error('post_office')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group col-md-4">
                <label for="inputEmail4"><span data-hi="पिनकोड" data-en="Pincode"></span></label>
                <input type="text" name="pincode" maxlength="6" id="pincode"
                    class="form-control @error('pincode') is-invalid @enderror" data-placeholder-en="Enter Pincode Here"
                    value="{{ $user->pincode ?? old('pincode') }}" data-placeholder-hi="यहां पिनकोड दर्ज करें"
                    autofocus>
                @error('pincode')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="gram_panchayat">
                    <span data-hi="ग्राम पंचायत" data-en="Gram Panchayat"></span>
                </label>
                <input type="text" class="form-control @error('gram_panchayat') is-invalid @enderror"
                    id="gram_panchayat" name="gram_panchayat" data-placeholder-hi="ग्राम पंचायत"
                    value="{{ $user->gram_panchayat ?? old('gram_panchayat') }}" autocomplete="off"
                    data-placeholder-en="Gram Panchayat">
                @error('gram_panchayat')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="mb-4 mt-4 text-center">
                <button type="submit" class="btn btn-primary submit buttonWizard">

                    <span data-hi="{{ isset($user) ? 'अपडेट' : 'बनाएं' }}"
                        data-en="{{ isset($user) ? 'Update' :  'Create' }}"></span>
                </button>
            </div>
        </div>
    </form>

</div>

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
                url: "{{ route('get-all-district') }}",
                data: {
                    "id": val,
                    "mandal": text,
                },
                cache: false,
                success: function(data) {
                    var getMandal = data.data;
                    if (getMandal && getMandal.length > 0) {
                        $('#mandal').append(`<option value="">Select District</option>`);
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
                    $('#vikas_khand').append(
                        `<option value="">Select Vikas Khand</option>`);
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
});
</script>
@endsection