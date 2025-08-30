@extends('master')
@section('content')

<div class="container main-div py-5" style="background-color:white; height: 100%; min-height:380px;">
    <div class="d-flex justify-content-between align-items-center m-4 position-relative">
        <h3 class="fw-bold mb-0 position-absolute start-50 translate-middle-x">
            <span data-hi="वीडियो गैलरी" data-en="Video Gallery"></span>
        </h3>
        @if(Auth::user() && Auth::user()->role == 'Superadmin')
            <a href="{{ route('add-video-gallery') }}" class="btn btn-primary ms-auto">
                + Add Video
            </a>
        @endif
    </div>

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

    <div class="container mt-5">
        <div class="row">
            @foreach($data as $item)
                <div class="col-md-6 mb-4">
                    <h5 class="mt-3">{{ $item->title }}</h5>
                    <p class="text-muted">{{ $item->description }}</p>
                    <div class="card h-80shadow-sm">
                        <div class="card-body text-center">
                            @php
                                $ext = pathinfo($item->url, PATHINFO_EXTENSION);
                            @endphp

                            @if(in_array($ext, ['mp4','mov','avi','wmv']))
                                <video width="100%" height="200" controls>
                                    <source src="{{ asset($item->url) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif(in_array($ext, ['jpg','jpeg','png','gif']))
                                <img src="{{ asset($item->url) }}" class="img-fluid" style="height:200px; object-fit:cover;">
                            @elseif($ext === 'pdf')
                                <embed src="{{ asset($item->url) }}" type="application/pdf" width="100%" height="200px"/>
                            @endif

                            @if(Auth::user() && Auth::user()->role == 'Superadmin')
                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    <a href="{{ route('edit-video-gallery', $item->id) }}" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>
                                    <form action="{{ route('delete-video-gallery', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this file?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>

@endsection