@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center fw-bold m-4">अपडेट संस्थान
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

    <form method="post" action="{{ route('institute.update', $data->id) }}">
        @method('PATCH')
        @csrf
        <div class="row">
            <div class="form-group col-md-6">
                <label for="name">संस्थान का नाम <span style="color: red;">*</span></label>
                <input type="text" class="form-control" value="{{ old('name', $data->name) }}" name="name" id="name"
                    placeholder="संस्थान का नाम" autocomplete="off">
                @if($errors->has('name'))
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="mobile">मोबाइल <span style="color: red;">*</span></label>
                <input type="text" maxlength="10" class="form-control" value="{{ old('mobile', $data->mobile) }}" name="mobile"
                    id="mobile" placeholder="मोबाइल नंबर दर्ज करें" autocomplete="off">
                @if($errors->has('mobile'))
                    <small class="text-danger">{{ $errors->first('mobile') }}</small>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="email">ईमेल <span style="color: red;">*</span></label>
                <input type="text" class="form-control" value="{{ old('email', $data->email) }}" name="email" id="email"
                    placeholder="ईमेल पता दर्ज करें" autocomplete="off">
                @if($errors->has('email'))
                    <small class="text-danger">{{ $errors->first('email') }}</small>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="address">पता <span style="color: red;">*</span></label>
                <input type="text" class="form-control" value="{{ old('address', $data->address) }}" name="address" id="address"
                    placeholder="पता दर्ज करें" autocomplete="off">
                @if($errors->has('address'))
                    <small class="text-danger">{{ $errors->first('address') }}</small>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="lattitude">अक्षांश <span style="color: red;">*</span></label>
                <input type="text" class="form-control" value="{{ old('lattitude', $data->lattitute) }}" name="lattitude" id="lattitude"
                    placeholder="अक्षांश दर्ज करें" autocomplete="off">
                @if($errors->has('lattitude'))
                    <small class="text-danger">{{ $errors->first('lattitude') }}</small>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="longitude">देशान्तर <span style="color: red;">*</span></label>
                <input type="text" class="form-control" value="{{ old('longitude', $data->longitute) }}" name="longitude" id="longitude"
                    placeholder="देशांतर दर्ज करें" autocomplete="off">
                @if($errors->has('longitude'))
                    <small class="text-danger">{{ $errors->first('longitude') }}</small>
                @endif
            </div>

            <div class="form-group col-md-12" style="overflow:auto;margin-bottom:20px;">
                <button type="submit" class="submit btn btn-primary">Update</button>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"
                    id="loader"> </span>
            </div>
        </div>

    </form>

</div>
@endsection
