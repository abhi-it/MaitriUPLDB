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
    <!-- <h3 style="margin-top:10px;text-align: center;">Service Request Form</h3> -->
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
                    <div class="card-header">सेवा अनुरोध सूची</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ count($data) }}</h5>
                        <a href="{{ url('/farmer-requests') }}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Feedback Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  method="post"  enctype="multipart/form-data" action="{{route('farmer-dashdata')}}"> 
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="message-text" class="col-form-label">Insurance:</label>
                <select  class="form-control" id="insurance" name="insurance" required>
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                </select>
            </div>
            <div class="form-group">
                <label for="animal_file" class="col-form-label">Feedback</label>
                <textarea id="feedback" class="form-control"  name="feedback" rows="4" cols="50"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="submit">Submit </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">
    
  $(window).on('load', function() {
    var modelShown = localStorage.getItem('farmer');
    console.log('localStorage',localStorage,modelShown)
    if(modelShown != 'YES'){
      $('#exampleModal').modal('show');
      localStorage.setItem('farmer', 'YES');
    }
  });
</script>