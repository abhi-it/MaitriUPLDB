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
    .openModal{
        display:none;
    }
    .contain-form{
        margin: auto;
        padding: 20px;
    }
</style>
<div class="container main-div">
 <h3 class="text-center fw-bold m-4">उच्च उपज देने वाले पशु विवरण प्रपत्र</h3>
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
            <form action="{{route('addUpdateAnimalDetails')}}"   enctype="multipart/form-data" method="post">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">जानवर</label> 
                        <input type="hidden" id="user_id" name="user_id" value="{{Auth::user()->id}}">
                        <select class="form-control" name="type" id="type" required>
                            <option value="">एक का चयन करें</option>
                                <option value="buffalo">भैंस</option>
                                <option value="cow">गाय</option>
                                <option value="goat">बकरी</option>
                                <option value="horse">घोड़ा</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                    <label for="inputEmail4">पशु फोटो</label> 
                        <input type="file" name="file"  class="form-control" requires>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">विवरण</label> 
                        <textarea id="request_message" class="form-control"  name="details" rows="4" cols="50"></textarea>
                    </div>
                </div>
                <div style="overflow:auto;margin-bottom:20px;">
                    <div style="margin-top: 5px;" >
                        <button type="submit" class="submit btn btn-primary buttonWizard" id="submitForm">जमा करे</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
