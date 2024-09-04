@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
<h3 style="margin-top:10px;text-align: center;">
<span data-hi="किसान आवश्यकता प्रपत्र" data-en="Farmer Requirement Form"></span>

<div class=" pull-right">
			<a href="javascript:history.back();" class="btn btn-info"><span data-hi="पीछे" data-en="Back"></span></a>
		</div>
</h3>
<script src="{{ asset('')}}js/google_Jsapi.js" type="text/javascript"></script>
<script type="text/javascript">

      // Load the Google Transliterate API
      google.load("elements", "1", {
            packages: "transliteration"
          });

      function onLoad() {
        var options = {
            sourceLanguage:
                google.elements.transliteration.LanguageCode.ENGLISH,
            destinationLanguage:
                [google.elements.transliteration.LanguageCode.HINDI],
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
        ['name', 'address',]);
      }
      google.setOnLoadCallback(onLoad);
    </script>
@if(session()->get('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}  
  </div>
@endif
@if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
			<form method="post" action="{{ route('submitSemanForm') }}" id="SemanForm"  enctype="multipart/form-data">
	@csrf
			<div class="row">
        <div class="form-group col-md-6">
				  <label for="inputEmail4"><span data-hi="पूरा नाम" data-en="Full Name"></span> </label>
				  <input type="text" maxlength="10" class="form-control" name="former_name" id="name" placeholder="पूरा नाम"  autocomplete="off">
				</div>
        <div class="form-group col-md-6">
            <label for="inputPassword4"><span data-hi="स्थायी पता" data-en="Permanent Address"></span> </label> 
            <input type="text" class="form-control" name="permanent_address" id="permanent_address"
                placeholder="स्थायी पता" autocomplete="off" >
        </div>
        <div class="form-group col-md-6">
				  <label for="inputEmail4"><span data-hi="जिला" data-en="District"></span> </label>
				  <select class="form-control" name="distirct_id" id="distirct_id" placeholder="जिला"  autocomplete="off">
            <option value="">जनपद चुनें </option>
            @foreach ($districts as $row)
                <option value="{{ $row->id }}">{{ $row->name_hindi }}
                </option>
            @endforeach
          </select>
				</div>
        <div class="form-group col-md-6">
				  <label for="inputEmail4"><span data-hi="ब्लॉक" data-en="Block"></span> </label>
          <select class="form-control" name="division_id" id="division_id" placeholder="ब्लॉक"  autocomplete="off">
            <option value="">ब्लॉक चुनें </option>
            
          </select>
				</div>
        <div class="form-group col-md-6">
				  <label for="inputEmail4"><span data-hi="पिन कोड" data-en="Pin Code"></span></label>
				  <input type="number" minlength="6" maxlength="6" class="form-control" name="pin_code" id="pin_code" placeholder="पिन कोड"  autocomplete="off">
				</div>
				<div class="form-group col-md-6">
				  <label for="inputEmail4"> <span data-hi="सीमेन स्ट्रॉ" data-en="Semen Strew"></span>  </label>
                  <select class="form-control" name="semens_strew" id="semens_strew" placeholder="सीमेन स्ट्रॉ"  autocomplete="off">
                    <option value="Conventional Semen / SeXed Semen">Conventional Semen / SeXed Semen</option>
                    <option value="Breedwise colorcodes in Sire Directory">Breedwise colorcodes in Sire Directory</option>
                  </select>
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4"><span data-hi="एल एन 2" data-en="LN 2"></span> </label>
				  <input type="text" maxlength="10" class="form-control" name="ln2" id="ln2" placeholder="एल एन 2"  autocomplete="off">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4"><span data-hi="खनिज मिश्रण" data-en="Mineral mixture "></span>  </label>
				  <input type="text" class="form-control" name="minieral_mixture" id="minieral_mixture" placeholder="खनिज मिश्रण"  autocomplete="off">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4"><span data-hi="गर्भावस्था फ़ीड" data-en="Pregnancy Feed"></span></label>
				  <input type="text" class="form-control" name="pregnancy_feed" id="pregnancy_feed" placeholder="गर्भावस्था फ़ीड"  autocomplete="off">
				</div>

                <div class="form-group col-md-6">
				  <label for="inputEmail4"> <span data-hi="बछड़ा स्टार्टर" data-en="Calf Starter"></span>  </label>
				  <input type="text" class="form-control" name="calf_starter" id="calf_starter" placeholder="बछड़ा स्टार्टर"  autocomplete="off">
				</div>
				
			<div class="form-group col-md-12" style="overflow:auto;margin-bottom:20px;">
                <button type="submit" class="submit">Submit</button>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;" id="loader"> </span>
            
        </div>
				
		  </div>
		</form>

</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#distirct_id').on('change', function() {
      $('#division_id').empty();
      if($('#distirct_id option:selected').val()!=''){
        $.ajax({
          type: "get",
          url: "{{ route('getBlocks') }}",
          cache: true,
          data: {distirct_id: $('#distirct_id option:selected').val()},
          success: function (result) {
            console.log(result?.data)
            var html='<option value="">ब्लॉक चुनें </option>'
            if(result?.data.length>0){
              $(result?.data).each((key,element)=>{
                console.log(element)
                html+='<option value="'+element.id+'">'+element.name_hindi+'</option>';
              })
              $('#division_id').append(html)
            }
          }
        });
      }
    })
  })
</script>
@endsection 
