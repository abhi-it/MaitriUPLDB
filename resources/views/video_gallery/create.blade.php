@extends('master')
@section('content')

<div class="container main-div py-3" style="background-color:white; height: 100%; min-height:380px;">
    <h3 class="text-center fw-bold m-4">
        <span data-hi="वीडियो गैलरी" data-en="Add Video Gallery"></span>
    </h3>
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

    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-sm-8 contain-form card p-4">
                <form action="{{ route('save-video-gallery') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12 mb-3">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label for="type">Video Type</label>
                            <input type="text" name="type" id="type" class="form-control" required>
                        </div>
                         <div class="form-group col-md-12 mb-3" id="file-input">
                            <label for="file">Upload Video</label>
                            <input type="file" name="file" id="file" class="form-control">
                        </div>
                        <div class="form-group col-md-12 mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


@endsection