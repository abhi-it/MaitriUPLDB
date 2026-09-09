@extends('master')
@section('content')
    <div class="container main-div">
        <h3 style="margin-top:10px;text-align: center;">नया संस्थान
            <div class=" pull-right">
                <a href="javascript:history.back();" class="btn btn-info">Back</a>
            </div>
        </h3>
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
                    ['name', 'address', ]);
            }
            google.setOnLoadCallback(onLoad);
        </script>

        <form method="post" action="{{ route('institute.store') }}" id="addInstitute" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="name">संस्थान का नाम <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="संस्थान का नाम" autocomplete="off" value="{{ old('name') }}">
                    @if($errors->has('name'))
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="mobile">मोबाइल <span style="color: red;">*</span></label>
                    <input type="text" maxlength="10" class="form-control" name="mobile" id="mobile" placeholder="मोबाइल" autocomplete="off" value="{{ old('mobile') }}">
                    @if($errors->has('mobile'))
                        <small class="text-danger">{{ $errors->first('mobile') }}</small>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="email">ईमेल <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="ईमेल" autocomplete="off" value="{{ old('email') }}">
                    @if($errors->has('email'))
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="password">पासवर्ड <span style="color: red;">*</span></label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="पासवर्ड" autocomplete="off">
                    @if($errors->has('password'))
                        <small class="text-danger">{{ $errors->first('password') }}</small>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="address">पता <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" name="address" id="address" placeholder="पता" autocomplete="off" value="{{ old('address') }}">
                    @if($errors->has('address'))
                        <small class="text-danger">{{ $errors->first('address') }}</small>
                    @endif
                </div>

                <div class="form-group col-md-12" style="overflow:auto;margin-bottom:20px;">
                    <button type="submit" class="submit">सबमिट </button>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;" id="loader"> </span>
                </div>
            </div>

        </form>

    </div>
@endsection
