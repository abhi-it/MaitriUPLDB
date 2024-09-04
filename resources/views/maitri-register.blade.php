@extends('master')
@section('content')
<div class="container main-div py-5" style="background-color:white;">
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
        <span data-hi="मैत्री (पशु मित्र) पंजीकरण फॉर्म" data-en="Maitri Registration Form"></span>
         </h3>
        <form method="post" action="{{ route('maitri-add') }}" class="form-comman">
            @csrf
            <hr>
            <div class="row">
            <div class="form-group col-md-6">
                    <label for="inputEmail4"> <span data-hi="पहला नाम" data-en="First Name"></span>  </label> 
                    <input type="text" class="form-control" name="first_name" id="first_name" required data-placeholder-hi="पहला नाम " autocomplete="off" data-placeholder-en="First Name">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> <span data-hi="उपनाम" data-en="Last Name"></span>  </label> 
                    <input type="text" class="form-control" name="last_name" id="last_name"  required data-placeholder-hi="उपनाम" autocomplete="off" data-placeholder-en="Last Name">
                </div>


                <div class="form-group col-md-6">
                    <label for="inputPassword4"><span data-hi="ई-मेल" data-en="E-mail"></span>   </label>
                    <input type="text" class="form-control" name="email" id="email" required data-placeholder-hi="ईमेल" autocomplete="off" data-placeholder-en="Email">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4"><span data-hi="पासवर्ड" data-en="Password"></span> </label> 
                    <input type="password" class="form-control" id="password" name="password"  required data-placeholder-hi="पासवर्ड" autocomplete="off" data-placeholder-en="Password">
                </div>

                <div class="form-group col-md-6">
                    <label for="inputPassword4"><span data-hi="मोबाइल नंबर" data-en="Mobile Number"></span> </label> 
                    <input type="number" class="form-control" id="MobileNumber" name="MobileNumber" required data-placeholder-hi="मोबाइल नंबर" autocomplete="off" data-placeholder-en="Mobile Number">
                </div>


                <div class="form-group col-md-6">
                    <label for="inputPassword4"><span data-hi="भारत पशुधन आईडी" data-en="Bharat Livestock ID"></span> </label> 
                    <input type="text" class="form-control" id="bharat_id" name="bharat_id" required data-placeholder-hi="भारत पशुधन आईडी" autocomplete="off" data-placeholder-en="Bharat Livestock ID">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"><span data-hi="एआई सेंटर" data-en="AI Center"></span> </label> 
                    <select class="form-control" name="ai_center" id="ai_center" required>
                        <option value="" data-hi="किसी एक को चुनें" data-en="select one"></option>
                        @foreach($aicenter as $val)
                            <option value="{{$val->id}}" >{{$val->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4"><span data-hi="प्रशिक्षण केंद्र" data-en="Training Center"></span> </label> 
                    <input type="text" class="form-control" id="traing_center" name="traing_center" required data-placeholder-hi="प्रशिक्षण केंद्र" autocomplete="off" data-placeholder-en="Training Center">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"><span data-hi="लिंग" data-en="Gender"></span></label> 
                    <select class="form-control" name="gender" id="gender" required>
                        <option value="" data-hi="किसी एक को चुनें" data-en="select one"></option>
                        <option value="male" data-hi="पुरुष" data-en="Male"></option>
                        <option value="female" data-hi="महिला" data-en="Female"></option>
                        <option value="others" data-hi="अन्य" data-en="Other">  </option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"><span data-hi="मंडल का नाम" data-en="Mandal"></span> </label> 
                    <select class="form-control" name="division_id" id="divisionID">
                    <option value="" data-hi="किसी एक को चुनें" data-en="select one">किसी एक को चुनें</option>
                        @foreach($divisions as $val)
                            <option value="{{$val->id}}" data-hi="{{$val->name_hindi}}" data-en="{{$val->name_eng}}"></option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> <span data-hi="जिला" data-en="District"></span> </label> 
                    <select class="form-control" name="district_id" id="districID" >
                        
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> <span data-hi="ब्लॉक" data-en="Block"></span> </label> 
                    <select class="form-control" name="block" id="block" >
                        
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4"> <span data-hi="तहसील" data-en="Tehsil"></span>   </label> 
                    <select class="form-control" name="tehsil" id="tehsil" >
                        
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4"> <span data-hi="ग्राम पंचायत" data-en="Gram Panchayat"></span>  </label> 
                        <select class="form-control" name="gram_panchayat" id="gram_panchayat" >
                        
                        </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4"><span data-hi="पोस्ट ऑफ़िस" data-en="Post Office"></span>  </label> 
                        <select class="form-control" name="post_office" id="post_office" >
                        
                        </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4"><span data-hi="ग्राम" data-en="Village"></span>  </label> 
                        <select class="form-control" name="village" id="village" >
                        
                        </select>
                </div>

                <!-- <div class="form-group col-md-6">
                    <label for="inputPassword4">पोस्ट ऑफ़िस</label> 
                    <input type="text" class="form-control" id="post_office" name="post_office" required placeholder="पोस्ट ऑफ़िस" autocomplete="off" >
                </div> -->
                <!-- <div class="form-group col-md-6">
                    <label for="inputPassword4">ब्लॉक</label> 
                    <input type="text" class="form-control" id="block" name="block" required placeholder="ब्लॉक" autocomplete="off" >
                </div> -->
                <!-- <div class="form-group col-md-6">
                    <label for="inputPassword4">तहसील</label> 
                    <input type="text" class="form-control" id="tehsil" name="tehsil" required placeholder="तहसील" autocomplete="off" >
                </div> -->
            </div>
            <!------Summary Page End---------------->
            <div class="row">
                <div class="mb-4 mt-4 text-center" >
                    <button type="submit" class="btn btn-primary submit buttonWizard">
                        <span data-hi="सबमिट" data-en="Submit"></span>    
                    </button>
                </div>
            </div>
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
            var control =
            new google.elements.transliteration.TransliterationControl(options);
            control.makeTransliteratable(
                [
                    'first_name',
                    'last_name',
                ]);
        }
        google.setOnLoadCallback(onLoad);
    </script>
<script>
     $(document).ready(function() {
        $('#districID').prop('disabled', true);
        $('#block').prop('disabled',true);
        $('#tehsil').prop('disabled',true);
        $('#gram_panchayat').prop('disabled', true);
        $('#village').prop('disabled', true);
        $('#post_office').prop('disabled', true);
        
        
        $('#divisionID').change(function() {
            $('#districID').prop('disabled', true);
            $('#block').prop('disabled',true);
            $('#tehsil').prop('disabled',true);
            $('#gram_panchayat').prop('disabled', true);
            $('#village').prop('disabled', true);
            $('#post_office').prop('disabled', true);
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
                        $('#gram_panchayat').prop('disabled', true);
                        $('#districID').empty();
                        if(data){
                            $('#districID').append($("<option>-किसी एक को चुनें-</option>"));
                            data.forEach(item => {
                                $('#districID').append('<option value="'+item.id+'">' + item.name_eng + '</option>')
                            });

                        }
                    }
                });
            }
        });

        $('#districID').change(function() {
            $('#block').prop('disabled',true);
            $('#tehsil').prop('disabled',true);
            $('#gram_panchayat').prop('disabled', true);
            $('#village').prop('disabled', true);
            $('#post_office').prop('disabled', true);
            var val = $("#districID option:selected").val();
            if(val){
                $.ajax({
                    type: "POST",
                    url: "get-block",
                    // url: "get-village-grampanchayat",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": val
                    },
                    cache: false,
                    success: function(data) {
                        $('#block').prop('disabled',true);
                        $('#block').empty();
                        console.log('data',data)
                        if(data){
                            $('#block').prop('disabled', false);
                            $('#block').append($("<option>-किसी एक को चुनें-</option>"));
                            data.forEach(item => {
                                var hight  =  (item.aspirational_block)?'*':"";
                                var color  =   (item.aspirational_block)?'text-primary fs-6':"";
                                $('#block').append('<option class="'+color+'" value="'+item.id+'">' + item.block_name + '<span> '+hight+' </span></option>')
                            });
                        }
                    }
                });
            }
        });

        $('#block').change(function() {
            $('#tehsil').prop('disabled',true);
            $('#gram_panchayat').prop('disabled', true);
            $('#village').prop('disabled', true);
            $('#post_office').prop('disabled', true);
            var val = $("#block option:selected").val();
            if(val){
                $.ajax({
                    type: "POST",
                    url: "get-village-grampanchayat",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": val,
                        "dis_id":$("#districID option:selected").val(),
                    },
                    cache: false,
                    success: function(data) {
                        $('#gram_panchayat').prop('disabled', true);
                        $('#gram_panchayat').empty();
                        $('#tehsil').empty();
                        if(data.village){
                            var result = data.village;
                            $('#gram_panchayat').prop('disabled', false);
                            $('#gram_panchayat').append($("<option>-किसी एक को चुनें-</option>"));
                            result.forEach(item => {
                                $('#gram_panchayat').append('<option value="'+item.id+'">' + item.gram_panchayat + '</option>')
                            });
                        }
                        if(data.tehsil){
                            var result = data.tehsil;
                            $('#tehsil').prop('disabled', false);
                            $('#tehsil').append($("<option>-किसी एक को चुनें-</option>"));
                            result.forEach(item => {
                                $('#tehsil').append('<option value="'+item.id+'">' + item.tehsil + '</option>')
                            });
                        }
                    }
                });
            }
        });

        $('#gram_panchayat').change(function() {
            $('#village').prop('disabled', true);
            $('#post_office').prop('disabled', true);
            var val = $("#gram_panchayat option:selected").val();
            if(val){
                $.ajax({
                    type: "POST",
                    url: "get-village",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": val,
                        "dis_id":$("#districID option:selected").val(),
                    },
                    cache: false,
                    success: function(data) {
                        $('#village').prop('disabled', true);
                        $('#post_office').prop('disabled', true);
                        $('#village').empty();
                        $('#post_office').empty();
                        if(data.village){
                            var result = data.village;
                            $('#village').prop('disabled', false);
                            $('#village').append($("<option>-किसी एक को चुनें-</option>"));
                            result.forEach(item => {
                                $('#village').append('<option value="'+item.id+'">' + item.name + '</option>')
                            });
                        }
                        if(data.postoffice){
                            var result = data.postoffice;
                            $('#post_office').prop('disabled', false);
                            $('#post_office').append($("<option>-किसी एक को चुनें-</option>"));
                            result.forEach(item => {
                                $('#post_office').append('<option value="'+item.id+'">' + item.post_office + '</option>')
                            });
                        }
                    }
                });
            }
        });
     });
</script>
