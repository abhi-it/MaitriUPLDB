@extends('master')
@section('content')

<style>
    .errorclass{
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
    <div class="row mb-4">
        <div class="col-md-12">
            <a href="{{ route('create-event-news') }}" class="btn btn-primary" data-hi="इवेंट और समाचार बनाएं" data-en="Create Event & News"></a>
        </div>
    </div>
    <h3 class="text-center fw-bold m-4">
        <span data-hi="घटना एवं समाचार" data-en="Event & News"></span>
    </h3>
    <table class="table table-striped  table-responsive table-bordered">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Title</th>
                <th>Description</th>
                <th>Front Images</th>
                <th>Gallery Images</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

            @if($events->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">No Record Found</td>
                </tr>
            @endif


            @php $i = 1 @endphp
            @foreach($events as $event)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ Str::limit($event->title, 100) }}</td>
                    <td>{{ Str::limit($event->description, 100) }}</td>
                    @if($event->front_image)
                        <td><img src="{{ asset($event->front_image) }}" width="50" alt="image"></td>
                    @else
                        <td>N/A</td>
                    @endif
                    <td>
                        @foreach(json_decode($event->images, true) as $image)
                            <img src="{{ asset($image) }}" width="50" alt="image">
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('edit-event', $event->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('events-delete', $event->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @php $i++ @endphp
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{ asset('assets/js/checkRemaninngStock.js') }}"></script>
<script>
    

</script>

@endsection 