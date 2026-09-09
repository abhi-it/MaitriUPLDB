@extends('submaster')
@section('content')
<style>
.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, .125);
    border-radius: 0.25rem;
}

.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}

.modal-dialog {
    max-width: 40% !important;
}

.openModal {
    display: none;
}

.contain-form {
    margin: auto;
    padding: 20px;
}
</style>
<div class="container main-div">
    <h3 class="text-center fw-bold m-4">सेवा अनुरोध प्रपत्र</h3>
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
    @if(!empty($missingLocation))
    <div class="alert alert-warning">
        आपकी प्रोफ़ाइल में {{ implode(', ', $missingLocation) }} की जानकारी अधूरी है।
        सही मैत्री देखने के लिए कृपया अपनी प्रोफ़ाइल अपडेट करें।
        <a href="{{ route('farmer-details') }}" class="alert-link fw-bold">प्रोफ़ाइल अपडेट करें</a>
    </div>
    @endif

    <div class="row">

        <div class="col-sm-8 contain-form card">
            <form action="{{route('farmer-request')}}" method="post">
                @csrf
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">सेवा</label>
                        <select class="form-control" name="services" id="services" required>
                            <option value="">एक का चयन करें</option>
                            <option value="health_medical_checkip" {{ old('services') == 'health_medical_checkip' ? 'selected' : '' }}>स्वास्थ्य/चिकित्सा जांच</option>
                            <option value="animal_insurance" {{ old('services') == 'animal_insurance' ? 'selected' : '' }}>पशु बीमा</option>
                            <option value="vaccination" {{ old('services') == 'vaccination' ? 'selected' : '' }}>टीकाकरण</option>
                            <option value="pregnancy_diagnosis" {{ old('services') == 'pregnancy_diagnosis' ? 'selected' : '' }}>गर्भावस्था निदान</option>
                            <option value="artificial_insemination" {{ old('services') == 'artificial_insemination' ? 'selected' : '' }}>कृत्रिम गर्भाधान</option>
                            <option value="livestock_insurance" {{ old('services') == 'livestock_insurance' ? 'selected' : '' }}>पशुधन बीमा</option>
                            <option value="calving" {{ old('services') == 'calving' ? 'selected' : '' }}>बछड़ा जनन</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12" id="maiti-div">
                        <label for="matries">मैत्री</label>
                        <select class="form-control" name="maitri_id" id="matries" {{ empty($farmer->district_id) ? 'disabled' : 'required' }}>
                            <option value="">एक का चयन करें</option>
                            @if($maitries->count() > 0)
                                @foreach($maitries->groupBy('block') as $blockName => $blockMaitries)
                                    @php
                                        $blockLabel = $blockName ?: 'अन्य';
                                        if (!empty($farmer->block) && $blockName == $farmer->block) {
                                            $blockLabel .= ' (आपका विकास खण्ड)';
                                        }
                                    @endphp
                                    <optgroup label="विकास खण्ड: {{ $blockLabel }}">
                                        @foreach($blockMaitries as $val)
                                            <option value="{{ $val->id }}" {{ old('maitri_id') == $val->id ? 'selected' : '' }}>
                                                {{ $val->maitri_name }}
                                                @if($val->maitri_mobile_no)
                                                    ({{ $val->maitri_mobile_no }})
                                                @endif
                                                @if($val->center_name)
                                                    - {{ $val->center_name }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            @elseif(empty($farmer->district_id))
                                <option value="" disabled>ज़िला अपडेट करने के बाद मैत्री सूची दिखेगी</option>
                            @else
                                <option value="" disabled>इस ज़िले में मैत्री उपलब्ध नहीं है</option>
                            @endif
                        </select>
                        <small class="text-muted">मैत्री केवल आपके ज़िले की दिखाई गई है, विकास खण्ड के अनुसार क्रम में।</small>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">संदेश</label>
                        <textarea id="request_message" class="form-control" required name="request_message" rows="10"
                            cols="50"></textarea>
                    </div>
                </div>
                <div style="overflow:auto;margin-bottom:20px;">
                    <div style="margin-top: 5px;">
                        <button type="submit" class="submit btn btn-primary buttonWizard" id="submitForm"
                            {{ empty($farmer->district_id) ? 'disabled' : '' }}>जमा
                            करे</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('') }}js/google_Jsapi.js" type="text/javascript"></script>
<script type="text/javascript">
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

    var control = new google.elements.transliteration.TransliterationControl(options);

    control.makeTransliteratable(
        [
            'request_message',
        ]);
}
google.setOnLoadCallback(onLoad);
</script>
@endsection

