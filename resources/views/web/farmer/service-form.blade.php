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

    <div class="row">

        <div class="col-sm-8 contain-form card">
            <form action="{{route('farmer-request')}}" method="post">
                @csrf
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">सेवा</label>
                        <input type="hidden" id="user_id" name="user_id" value="{{Auth::user()->id}}">
                        <select class="form-control" name="services" id="services" required>
                            <option value="">एक का चयन करें</option>
                            <option value="health_medical_checkip">स्वास्थ्य/चिकित्सा जांच</option>
                            <option value="animal_insurance">पशु बीमा</option>
                            <option value="vaccination">टीकाकरण</option>
                            <option value="pregnancy_diagnosis">गर्भावस्था निदान</option>
                        </select>
                    </div>
                    <!-- <div class="form-group col-md-12" id="maiti-div">
                        <label for="inputEmail4">मैत्री</label> 
                        <select class="form-control" name="maitri_id" id="matries" required>
                            @if(count($maitries)>0)
                            <option value="">एक का चयन करें</option>
                            @foreach($maitries as $val)
                            <option value="{{$val->id}}"> {{ucfirst($val->FirstName)}} {{ucfirst($val->LastName)}}</option>
                            @endforeach
                            @else
                            <option>Data not found</option>
                            @endif
                        </select>
                    </div> -->
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">संदेश</label>
                        <textarea id="request_message" class="form-control" required name="request_message" rows="10"
                            cols="50"></textarea>
                    </div>
                </div>
                <div style="overflow:auto;margin-bottom:20px;">
                    <div style="margin-top: 5px;">
                        <button type="submit" class="submit btn btn-primary buttonWizard" id="submitForm">जमा
                            करे</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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