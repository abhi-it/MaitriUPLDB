@extends('master')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="container main-div py-5" style="background-color:white;">
<h1>Select Zone and District</h1>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form action="/save-selection" method="POST">
        @csrf
        <label for="zone">Zone:</label>
        <select name="zone_id" id="zone" class="form-control">
            <option value="">Select Zone</option>
            @foreach($zones as $zone)
                <option value="{{ $zone->id }}">{{ $zone->name_en }}</option>
            @endforeach
        </select>

        <label for="district">District:</label>
        <select name="district_ids[]" id="district" multiple class="form-control">
            <option value="">Select District</option>
        </select>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#district').select2();

        $('#zone').change(function () {
            var zone_id = $(this).val();
            if (zone_id) {
                $.ajax({
                    url: '/districts/' + zone_id,
                    type: 'GET',
                    success: function (data) {
                        $('#district').empty();
                        data.forEach(function (district) {
                            $('#district').append('<option value="' + district.id + '">' + district.name_eng + '</option>');
                        });
                        $('#district').trigger('change');  // Refresh Select2 options
                    }
                });
            } else {
                $('#district').empty();
            }
        });
    });
</script>

@endsection 