@extends('master')
@section('content')

<style>
.errorclass {
    font-size: 8px;
    color: red;
}
</style>
<div class="container main-div py-5" style="background-color:white;">
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif

    <div class="container">
        <h2><span data-hi="{{ isset($event) ? 'ईवेंट/समाचार संपादित करें' : 'नया ईवेंट/समाचार बनाएँ' }}" data-en="{{ isset($event) ? 'Edit Event/News' : 'Create New Event/News' }}"></span></h2>

        <form action="{{ isset($event) ? route('save-events-data', $event->id) : route('save-events-data') }}"
            method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title"><span data-hi="शीर्षक" data-en="Title"></span></label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $event->title ?? '') }}"
                    required>
            </div>

            <div class="form-group">
                <label for="title"><span data-hi="शीर्षक हिंदी" data-en="Title Hindi"></span></label>
                <input type="text" name="title_hindi" class="form-control" value="{{ old('title_hindi', $event->title_hindi ?? '') }}"
                    required>
            </div>

            <div class="form-group">
                <label for="description"><span data-hi="विवरण" data-en="Description"></span></label>
                <textarea name="description" class="form-control" rows="5"
                    required>{{ old('description', $event->description ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label for="images"><span data-hi="सामने की छवि" data-en="Front Image"></label>
                <input type="file" name="front_images" class="form-control" id="frontImageUpload" accept="image/*">

                <!-- Show preview of existing images if it's an update -->
                <div id="FrontimagePreview" class="mt-3">
                    @if(isset($event) && $event->front_image)
                        <img src="{{ asset($event->front_image) }}" width="100" style="margin-right: 10px;" alt="image">
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="images"><span data-hi="गैलरी छवियाँ" data-en="Gallery Images"></label>
                <input type="file" name="images[]" class="form-control" multiple id="imageUpload" accept="image/*">

                <!-- Show preview of existing images if it's an update -->
                <div id="imagePreview" class="mt-3">
                    @if(isset($event) && $event->images)
                        @foreach(json_decode($event->images, true) as $image)
                            <img src="{{ asset($image) }}" width="100" style="margin-right: 10px;" alt="image">
                        @endforeach
                    @endif
                </div>
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($event) ? 'Update' : 'Create' }}</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{ asset('assets/js/checkRemaninngStock.js') }}"></script>
    <script>
        document.getElementById('imageUpload').addEventListener('change', function(e) {
            const previewContainer = document.getElementById('imagePreview');
            previewContainer.innerHTML = '';
            const files = e.target.files;

            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.marginRight = '10px';
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        });

        document.getElementById('frontImageUpload').addEventListener('change', function(e) {
            const previewContainer = document.getElementById('FrontimagePreview');
            previewContainer.innerHTML = '';
            const files = e.target.files;

            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.marginRight = '10px';
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        });
    </script>
    
</div>
<script>


</script>

@endsection