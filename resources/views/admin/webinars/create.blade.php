@extends('broadcaster.layout.header')
@section('content')
<div class="container">

    <h3 class="text-center mt-3">{{ $stage->id ? 'Update Webinar' : 'Create Webinar' }}</h3>
    <div class="form-create-webinar">
        <form action="{{ $stage->id ? route('stage.update', $stage->id) : route('webinars.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-sm-6 m-auto">
                    <label>Webinar Title:</label>
                    <input type="text" class="form-control" value="{{ old('title', $stage->title) }}" name="stage_name"
                        required>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-sm-6 m-auto">
                    <label>Webinar Description:</label>
                    <textarea name="description" rows="5" cols="5"
                        class="form-control">{{ old('description', $stage->description) }}</textarea>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-sm-6 m-auto">
                    <label>Schedule Date & Time:</label>
                    <input type="datetime-local" value="{{ old('scheduled_at', $stage->scheduled_at) }}"
                        class="form-control" name="scheduled_at">
                </div>
            </div>

            <div class="row mt-4 mb-4">
                <div class="col-sm-6 m-auto">
                    <button type="submit"
                        class="btn btn-primary">{{ $stage->id ? 'Update Webinar' : 'Create Webinar' }}</button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection