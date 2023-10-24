@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
<h3 style="margin-top:10px;text-align: center;">नया संस्थान
<div class=" pull-right">
			<a href="javascript:history.back();" class="btn btn-info">Back</a>
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
@if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
			<form method="post" action="{{ route('institute.store') }}" id="addInstitute"  enctype="multipart/form-data">
	@csrf
			<div class="row">
				<div class="form-group col-md-6">
				  <label for="inputEmail4">संस्थान का नाम </label>
				  <input type="text" class="form-control" name="name" id="name" placeholder="संस्थान का नाम"  autocomplete="off">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">मोबाइल </label>
				  <input type="text" maxlength="10" class="form-control" name="mobile" id="mobile" placeholder="मोबाइल"  autocomplete="off">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">ईमेल </label>
				  <input type="text" class="form-control" name="email" id="email" placeholder="ईमेल"  autocomplete="off">
				</div>
				
				<div class="form-group col-md-6">
				  <label for="inputEmail4">पता </label>
				  <input type="text" class="form-control" name="address" id="address" placeholder="पता"  autocomplete="off">
				</div>
				
			<div class="form-group col-md-12" style="overflow:auto;margin-bottom:20px;">
                <button type="submit" class="submit">Submit</button>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;" id="loader"> </span>
            
        </div>
				
		  </div>
		</form>

</div>
@endsection 
