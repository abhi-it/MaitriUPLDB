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
        <div class="col-sm-3">
            <div class="card text-center">
                <div class="card-header">अनुरोध सूची</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $applications->count() }}</h5>
                    <a href="{{route('avedan-list')}}" class="btn btn-primary">देखना</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">
// $(window).on('load', function() {
//     var modelShown = localStorage.getItem('maitri');
//     console.log('localStorage', localStorage, modelShown)
//     if (modelShown != 'YES') {
//         $('#exampleModal').modal('show');
//         localStorage.setItem('maitri', 'YES');
//     }
// });
</script>
