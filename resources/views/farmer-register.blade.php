@extends('master')
@section('content')
<div class="container main-div py-5">
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
    <h3 class="text-center fw-bold m-4">
        <span data-hi="पशुपालक पंजीकरण फॉर्म" data-en="Farmer Registration"></span>
    </h3>
    <hr>
    <form method="post" action="{{ route('farmer-add') }}" class="form-comman">
        @csrf
        <div class="row">
            <div class="form-group col-md-4">
                <label for="inputEmail4">
                    <span data-hi="नाम" data-en="First Name"></span>
                </label>
                <input type="text" class="form-control" name="first_name" id="first_name" required
                    data-placeholder-hi="नाम" autocomplete="off" data-placeholder-en="First Name">
            </div>
            <!-- <div class="form-group col-md-6">
                <label for="inputEmail4">
                    <span data-hi="उपनाम" data-en="Last Name"></span>
                </label>
                <input type="text" class="form-control" name="last_name" id="last_name" required
                    data-placeholder-hi="उपनाम" autocomplete="off" data-placeholder-en="Last Name">
            </div>

            <div class="form-group col-md-6">
                <label for="inputPassword4">
                    <span data-hi="ईमेल" data-en="E-mail"></span>
                </label>
                <input type="text" class="form-control" name="email" id="email" required data-placeholder-hi="ईमेल"
                    autocomplete="off" data-placeholder-en="Email">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">
                    <span data-hi="पासवर्ड" data-en="Password"></span>
                </label>
                <input type="password" class="form-control" id="password" name="password" required
                    data-placeholder-hi="पासवर्ड" autocomplete="off" data-placeholder-en="Password">
            </div> -->

            <div class="form-group col-md-4">
                <label for="inputPassword4">
                    <span data-hi="मोबाइल नंबर" data-en="Mobile Number"></span>
                </label>
                <input type="number" class="form-control" id="MobileNumber" name="MobileNumber" required
                    data-placeholder-hi="मोबाइल नंबर" autocomplete="off" data-placeholder-en="Mobile Number">
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4"> <span data-hi="लिंग" data-en="Gender"> </span></label>
                <select class="form-control" name="gender" id="gender" required>
                    <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                    <option value="male" data-hi="पुरुष" data-en="Male"></option>
                    <option value="female" data-hi="महिला" data-en="Female"></option>
                    <option value="others" data-hi="अन्य" data-en="Other"> </option>
                </select>
            </div>


            <div class="form-group col-md-12">
                <label for="animal">
                    <span data-hi="पशु की जानकारी" data-en="Number of cattle"></span>
                </label>
                <div class="optionBox">
                    <div class="block row adddiv_0">
                        <div class="form-group col-md-3">
                            <select class="form-control" id="animal_type" name="animal_type[]" required>
                                <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                                <option value="cow" data-hi="गाय" data-en="Cow"> </option>
                                <option value="buffalo" data-hi="भैंस" data-en="Buffalo"> </option>
                                <option value="goat" data-hi="बकरी" data-en="Goat"></option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <!-- <label for="inputPassword4">
                                <span data-hi="गाय/भैंस/बकरी की नस्लें" data-en="Breeds of Cow/Buffalo"></span>
                            </label> -->
                            <input type="text" class="form-control" id="breeds" name="breeds[]" required
                                data-placeholder-hi="गाय/भैंस/बकरी की नस्लें" autocomplete="off"
                                data-placeholder-en="Breeds of Cow/Buffalo">
                        </div>
                        <div class="form-group col-md-3">
                            <input type="number" class="form-control" id="cattale_no" name="cattale_no[]" required
                                data-placeholder-hi="पशु की जानकारी" data-placeholder-en="Cattle Number"
                                autocomplete="off">
                        </div>
                        <div class="form-group col-md-2">
                            <!-- <label for="inputPassword4">
                                <span data-hi="दूध/प्रतिदिन/प्रति पशु" data-en="Milk/day/Per Animal"></span>
                            </label> -->
                            <input type="text" class="form-control" id="milk_day" name="milk_day[]" required
                                data-placeholder-hi="दूध/प्रतिदिन/प्रति पशु" autocomplete="off"
                                data-placeholder-en="Milk/day/Per Animal">
                        </div>


                        <div class="form-group col-md-1">
                            <span class="add btn btn-primary btn-sm"> <span data-hi="जोड़ें" data-en="Add"></span>
                            </span>
                            <!-- <span class="remove">Remove</span> -->
                        </div>
                    </div>
                </div>


            </div>

            <!-- <div class="form-group col-md-6">
                    <label for="inputEmail4"><span data-hi="ज़िला" data-en="Mandal"></span> </label> 
                    <select class="form-control" name="division_id" id="divisionID">
                    <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                    
                        @foreach($divisions as $val)
                            <option value="{{$val->id}}" data-hi="{{$val->name_hindi}}" data-en="{{$val->name_eng}}"></option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4">
                    <span data-hi="उप जिला" data-en="District"></span>
                     </label> 
                    <select class="form-control" name="district_id" id="districID" >
                        
                    </select>
                </div>  -->

            <!-- New HTML Start -->
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="मंडल" data-en="Mandal"></span> </label>
                <select name="division_id" id="district" class="form-control" autofocus required>
                    <option value="" data-hi="मंडल चुनें" data-en="Select Mandal"></option>
                    @if(count($divisions)>0)
                    @foreach($divisions as $key => $val)
                    <option value="{{$val->id}}">{{$val->name_hindi}}</option>
                    @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="ज़िला" data-en="District"></span> </label>
                <select name="district_id" id="mandal" class="form-control" autofocus required>

                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="तहसील" data-en="Tehsil"></span> </label>
                <select name="tehsil" id="tehsil" class="form-control" placeholder="तहसील" autofocus required>

                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="विकास खण्ड" data-en="Vikas Khand"></span> </label>
                <select name="block" id="vikas_khand" class="form-control" placeholder="विकास खण्ड" autofocus required>

                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="पोस्ट ऑफिस" data-en="Post Office"></span> </label>
                <input type="text" name="post_office" id="post_office" required class="form-control"
                    placeholder="पोस्ट ऑफिस" autofocus>
            </div>


            <div class="form-group col-md-6">
                <label for="inputEmail4"><span data-hi="पिनकोड" data-en="Pincode"></span></label>
                <span id="error-message" style="color: red; display:none; font-size:10px; ">(Pincode must be a 6-digit
                    number.)</span>
                <input type="text" name="pincode" maxlength="6" id="pincode" required class="form-control"
                    data-placeholder-en="Enter Pincode Here" data-placeholder-hi="यहां पिनकोड दर्ज करें" autofocus>
            </div>
            <!-- New HTML End -->


            <div class="form-group col-md-6">
                <label for="inputPassword4">
                    <span data-hi="ग्राम पंचायत" data-en="Gram Panchayat"></span>
                </label>
                <input type="text" class="form-control" id="gram_panchayat" required name="gram_panchayat" required
                    data-placeholder-hi="ग्राम पंचायत" autocomplete="off" data-placeholder-en="Gram Panchayat">
            </div>
        </div>
        <!------Summary Page End---------------->
        <div class="row">
            <div class="mb-4 mt-4 text-center">
                <button type="submit" class="btn btn-primary submit buttonWizard">
                    <span data-hi="सबमिट" data-en="Submit"></span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script src="{{ asset('') }}js/google_Jsapi.js" type="text/javascript"></script>
<script type="text/javascript">
// Load the Google Transliterate API
google.load("elements", "1", {
    packages: "transliteration"
});

function onLoad() {
    var options = {
        sourceLanguage: google.elements.transliteration.LanguageCode.ENGLISH,
        destinationLanguage: [google.elements.transliteration.LanguageCode.HINDI],
        shortcutKey: 'ctrl+g',
        transliterationEnabled: true
    };

    // Create an instance on TransliterationControl with the required
    // options.
    var control =
        new google.elements.transliteration.TransliterationControl(options);

    // Enable transliteration in the textbox with id
    // 'transliterateTextarea'.
    control.makeTransliteratable(
        [
            'first_name',
            'last_name',
            'breeds',
            'post_office',
            'gram_panchayat',
            'block',
            'tehsil',
        ]);
}
google.setOnLoadCallback(onLoad);
</script>
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
            url: "get-all-tehsil",
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

    // $('#vikas_khand').change(function() {
    //     $('#ai_center').prop('disabled', false);
    //     var block = $(this).val();
    //     var tehsil = $('#tehsil').val();
    //     var mandal = $("#district option:selected").text();
    //     var janpad = $("#mandal option:selected").val();
    //     $('#ai_center').empty();
    //     $.ajax({
    //         type: "GET",
    //         url: "get-all-aicenter",
    //         data: {
    //             "block": block,
    //             "tehsil": tehsil,
    //             "mandal": mandal,
    //             "janpad": janpad,
    //         },
    //         cache: false,
    //         success: function(data) {
    //             var getAiCenter = data.data;
    //             if (getAiCenter && getAiCenter.length > 0) {
    //                 $('#ai_center').append(`<option value="">Select AI Center</option>`);
    //                 getAiCenter.forEach(item => {
    //                     if (item.center_name && item.center_name.trim() !== '') {
    //                         $('#ai_center').append(
    //                             `<option value="${item.center_name}">${item.center_name}</option>`
    //                             );
    //                     }
    //                 });
    //             } else {
    //                 $('#ai_center').append('<option value="">-Data not found.-</option>');
    //             }
    //         }
    //     });
    // });


    /*$('#districID').prop('disabled', true);
    $('#divisionID').change(function() {
        var val = $("#divisionID option:selected").val();
        if(val){
            $.ajax({
                type: "POST",
                url: "get-district",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": val
                },
                cache: false,
                success: function(data) {

                    $('#districID').prop('disabled', false);
                    $('#districID').empty();
                    if(data){
                        $('#districID').append($("<option value='' data-hi='एक का चयन करें' data-en='select one'></option>"));
                        data.forEach(item => {
                            $('#districID').append('<option value="'+item.id+'">' + item.name_hindi + '</option>')
                        });

                    }
                }
            });
        }
    });*/

    var maxFields = 2;
    var fieldCount = 0;

    $('.add').click(function() {
        if (fieldCount < maxFields) {
            var newField = '<div class="block row adddiv_' + fieldCount + '"> \
                    <div class="form-group col-md-3">\
                        <select class="form-control" id="animal_type" name="animal_type[]" required>\
                            <option value="">एक का चयन करें</option>\
                            <option value="cow">गाय</option>\
                            <option value="buffalo">भैंस</option>\
                            <option value="goat">बकरी</option>\
                        </select>\
                    </div>\
                    <div class="form-group col-md-3">\
                        <input type="text" class="form-control" id="breeds" name="breeds[]" required autocomplete="off" placeholder="गाय/भैंस/बकरी की नस्लें">\
                    </div>\
                    <div class="form-group col-md-3">\
                        <input type="number" class="form-control" id="cattale_no" name="cattale_no[]" required placeholder="पशु की जानकारी" autocomplete="off">\
                    </div>\
                    <div class="form-group col-md-2">\
                        <input type="text" class="form-control" id="milk_day" name="milk_day[]" required placeholder="दूध/प्रतिदिन/प्रति पशु" autocomplete="off">\
                    </div>\
                    <div class="form-group col-md-1"> \
                        <span class="remove btn btn-danger btn-sm" data-index="' + fieldCount + '">Remove</span> \
                    </div> \
                </div>';

            $('.block:last').after(newField);
            fieldCount++;

            if (fieldCount === maxFields) {
                $('.add').hide();
            }
        }
    });

    $('.optionBox').on('click', '.remove', function() {
        var index = $(this).data('index');
        $(this).closest('.adddiv_' + index).remove();
        fieldCount--;
        $('.add').show();
    });

    $('.optionBox').on('change', '.animal_type', function() {
        var selectedValue = $(this).val();
        console.log(selectedValue);
    });

});
</script>