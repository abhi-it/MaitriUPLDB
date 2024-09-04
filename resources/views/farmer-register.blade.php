@extends('master')
@section('content')
<div class="container main-div py-5" >
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
        <h3 style="margin-top:10px;text-align: center;">
            <span data-hi="पशुपालक पंजीकरण  फॉर्म" data-en="Animal Husbandry Registration Form"></span>
        </h3>
        <hr>
        <form method="post" action="{{ route('farmer-add') }}" class="form-comman">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">
                        <span data-hi="पहला नाम" data-en="First Name"></span>
                     </label> 
                    <input type="text" class="form-control" name="first_name" id="first_name" required data-placeholder-hi="पहला नाम " autocomplete="off" data-placeholder-en="First Name">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> 
                     <span data-hi="उपनाम" data-en="Last Name"></span>
                    </label> 
                    <input type="text" class="form-control" name="last_name" id="last_name"  required data-placeholder-hi="उपनाम" autocomplete="off" data-placeholder-en="Last Name">
                </div>

                <div class="form-group col-md-6">
                    <label for="inputPassword4">
                    <span data-hi="ईमेल" data-en="E-mail"></span>
                     </label>
                    <input type="text" class="form-control" name="email" id="email" required data-placeholder-hi="ईमेल" autocomplete="off" data-placeholder-en="Email">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">
                    <span data-hi="पासवर्ड" data-en="Password"></span>
                    </label> 
                    <input type="password" class="form-control" id="password" name="password"  required data-placeholder-hi="पासवर्ड" autocomplete="off" data-placeholder-en="Password">
                </div>

                <div class="form-group col-md-6">
                <label for="inputPassword4">
                    <span data-hi="मोबाइल नंबर" data-en="Mobile Number"></span>
                </label> 
                    <input type="number" class="form-control" id="MobileNumber" name="MobileNumber" required data-placeholder-hi="मोबाइल नंबर" autocomplete="off" data-placeholder-en="Mobile Number">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> <span data-hi="लिंग" data-en="Gender"> </span></label> 
                    <select class="form-control" name="gender" id="gender" required>
                        <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                        <option value="male" data-hi="पुरुष" data-en="Male"></option>
                        <option value="female" data-hi="महिला" data-en="Female"></option>
                        <option value="others"  data-hi="अन्य" data-en="Other">  </option>
                    </select>
                </div>
            

                <div class="form-group col-md-6">
                    <label for="animal">
                    <span data-hi="मवेशियों की संख्या" data-en="Number of cattle"></span>
                   </label>
                    <div class="block mb-2">
                        <span class="add btn btn-primary"> <span data-hi="जोड़ें" data-en="Add"></span> </span>
                    </div>
                    <div class="optionBox">
                        <div class="block row adddiv_0">
                            <div class="form-group col-md-5">
                                <select class="form-control" id="animal_type" name="animal_type[]" required >
                                <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                                    <option value="cow" data-hi="गाय" data-en="Cow"> </option>
                                    <option value="buffalo" data-hi="भैंस" data-en="Buffalo">  </option>
                                    <option value="goat" data-hi="बकरी" data-en="Goat"></option>
                                </select>
                            </div>
                            <div class="form-group col-md-5">
                                <input type="number" class="form-control" id="cattale_no" name="cattale_no[]" required data-placeholder-hi="मवेशियों की संख्या" data-placeholder-en="Cattle Number" autocomplete="off" >
                            </div> 
                            <div class="form-group col-md-1">
                                <!-- <span class="remove">Remove</span> -->
                            </div>
                        </div>
                    </div>
 

                </div>

                <div class="form-group col-md-6">
                    <label for="inputPassword4">
                    <span data-hi="गाय/भैंस की नस्लें" data-en="Breeds of Cow/Buffalo"></span>
                    </label> 
                    <input type="text" class="form-control" id="breeds" name="breeds" required data-placeholder-hi="गाय/भैंस की नस्लें" autocomplete="off" data-placeholder-en="Breeds of Cow/Buffalo">
                </div>
            
                <div class="form-group col-md-6">
                    <label for="inputEmail4"><span data-hi="ज़िला" data-en="District"></span> </label> 
                    <select class="form-control" name="division_id" id="divisionID">
                    <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                    
                        @foreach($divisions as $val)
                            <option value="{{$val->id}}" data-hi="{{$val->name_hindi}}" data-en="{{$val->name_eng}}"></option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4">
                    <span data-hi="उप जिला" data-en="Sub District"></span>
                     </label> 
                    <select class="form-control" name="district_id" id="districID" >
                        
                    </select>
                </div>   
                <div class="form-group col-md-6">
                    <label for="inputPassword4">
                    <span data-hi="ग्राम पंचायत" data-en="Gram Panchayat"></span>
                    </label> 
                    <input type="text" class="form-control" id="gram_panchayat" name="gram_panchayat" required data-placeholder-hi="ग्राम पंचायत" autocomplete="off" data-placeholder-en="Gram Panchayat" >
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">
                    <span data-hi="पोस्ट ऑफ़िस" data-en="Post Office"></span>    
                    </label> 
                    <input type="text" class="form-control" id="post_office" name="post_office" required data-placeholder-hi="पोस्ट ऑफ़िस" autocomplete="off" data-placeholder-en="Post Office">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">
                    <span data-hi="ब्लॉक" data-en="Block"></span>    </label> 
                    <input type="text" class="form-control" id="block" name="block" required data-placeholder-hi="ब्लॉक" autocomplete="off" data-placeholder-en="Block">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4"><span data-hi="तहसील" data-en="Tehsil"></span></label> 
                    <input type="text" class="form-control" id="tehsil" name="tehsil" required data-placeholder-hi="तहसील" autocomplete="off" data-placeholder-en="Tehsil">
                </div>
            </div>
            <!------Summary Page End---------------->
            <div class="row">
                <div class="mb-4 mt-4 text-center" >
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
        $('#districID').prop('disabled', true);
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
        });
       
        var maxFields = 2; 
        var fieldCount = 0; 

        $('.add').click(function() {
            if (fieldCount < maxFields) {
                var newField = '<div class="block row adddiv_'+fieldCount+'"> \
                    <div class="form-group col-md-5"> \
                        <select class="form-control animal_type" id="animal_type" name="animal_type[]" > \
                            <option value="">किसी एक को चुनें</option> \
                            <option value="cow">गाय</option> \
                            <option value="buffalo">भैंस</option> \
                            <option value="goat">बकरी</option> \
                        </select> \
                    </div> \
                    <div class="form-group col-md-5"> \
                        <input type="number" class="form-control cattale_no" id="cattale_no" name="cattale_no[]"  placeholder="मवेशियों की संख्या" autocomplete="off"> \
                    </div> \
                    <div class="form-group col-md-1"> \
                        <span class="remove" data-index="'+fieldCount+'">Remove</span> \
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
            $(this).closest('.adddiv_'+index).remove();
            fieldCount--;
            $('.add').show(); 
        });

        $('.optionBox').on('change', '.animal_type', function() {
            var selectedValue = $(this).val();
            console.log(selectedValue);
        });

     });
</script>
