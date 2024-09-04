@extends('master')
@section('content')
<div class="container main-div">
    @if($data)
    <h1 style="margin-top:10px;text-align: center;">
    <span data-hi="नवीनतम अपडेट अपडेट करें" data-en="Update Latest Updates"></span>
    </h1>
    @else
    <h1 style="margin-top:10px;text-align: center;">
    <span data-hi="नवीनतम अपडेट जोड़ें" data-en="Add Latest Updates"></span>
    </h1>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
	<form method="POST" action="{{ route('addUpdateLatestNews') }}" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <label for="title" class="col-md-4 col-form-label text-md-right"> Title </label>
            <div class="col-md-6">
                <input type="hidden" id="id" name="id" value="{{($data)?$data->id:''}}">
                <input name="title" id="title" type="text" class="form-control"  autofocus="off" value="{{($data)?$data->title:''}}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="url" class="col-md-4 col-form-label text-md-right">Url</label>
            <div class="col-md-6">
                <input name="url" id="url" type="text" class="form-control"  autofocus value="{{($data)?$data->url:''}}">
            </div>
        </div>
        <div class="row mb-3">
        <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
            <div class="col-md-6">
                <textarea id="description" class="form-control"  name="description" rows="4" cols="50">
               {{($data)?$data->description:''}}
                </textarea>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary" id="btn">सबमिट</button>
            </div>
        </div>
    </form>
<!--First row Closed-->
</div>
<script>	
$('#district').change(function() {
    var val = $("#district option:selected").val();
    console.log('value',val)
    if (val) {
        $.ajax({
            type: "GET",
            url: "getAllrequestedBlocks",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "_token": "{{ csrf_token() }}",
                "id": val
            },
            cache: false,
            success: function(data) {
                $('#block').empty();
                if(data.data.length>0){
                    $('#block').append($("<option>-Select one-</option>"));
                    $.each(data.data, function(i, index) {
                        console.log(index, i);
                        $('#block').append($("<option value="+index+">"+index+"</option>"));
                    });
                }else{
                    $('#block').append($("<option>Data not found.</option>"));
                }
            }
        });
    }
});
</script>
 @endsection 
