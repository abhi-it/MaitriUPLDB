@extends('master')
@section('content')

<div class="container main-div py-3" style="background-color:white; height: 100%; min-height:380px;">
    <h3 class="text-center fw-bold m-4">
        <span data-hi="वीडियो गैलरी" data-en="Edit Video Gallery"></span>
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
                <form action="{{ route('update-video-gallery', $video->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $video->title) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Video Type <span class="text-danger">*</span></label>
                        <input type="text" name="type" class="form-control"
                            value="{{ old('type', $video->type) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $video->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File</label>
                        <div>
                            @if($video->url)
                                @php
                                    $ext = pathinfo($video->url, PATHINFO_EXTENSION);
                                @endphp

                                @if(in_array($ext, ['mp4','mov','avi','wmv']))
                                    <video width="320" height="240" controls>
                                        <source src="{{ asset($video->url) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @elseif(in_array($ext, ['jpg','jpeg','png','gif']))
                                    <img src="{{ asset($video->url) }}" alt="Preview"
                                        width="200" class="img-thumbnail">

                                @elseif($ext === 'pdf')
                                    <a href="{{ asset($video->url) }}" target="_blank" class="btn btn-sm btn-info">
                                        View PDF
                                    </a>
                                @endif
                            @else
                                <p>No file uploaded yet.</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload New File (optional)</label>
                        <input type="file" name="file" class="form-control">
                        <small class="text-muted">Allowed: mp4, mov, avi, wmv, jpg, jpeg, png, gif, pdf (max 200MB)</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('video-gallery') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
