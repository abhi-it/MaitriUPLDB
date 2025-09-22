@extends('master')

@section('content')
<div class="container">

    <h3 class="mb-3">Posts</h3>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Button -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#postModal" onclick="openAddModal()">Add
        Post</button>

    <!-- Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Hindi Title</th>
                <th>English Title</th>
                <th>Image</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr>
                <td>{{ $post->hindi_title }}</td>
                <td>{{ $post->eng_title }}</td>
                <td>
                    @if($post->image)
                    <img src="{{ asset('uploads/'.$post->image) }}" width="80">
                    @endif
                </td>
                <td>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#postModal"
                        onclick="openEditModal({{ $post->id }}, '{{ $post->hindi_title }}', '{{ $post->eng_title }}', '{{ $post->image }}')">
                        Edit
                    </button>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete this post?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted">No record found</td>
            </tr>
            @endforelse
        </tbody>

    </table>

    {{ $posts->links() }}
</div>

<!-- Modal -->
<div class="modal fade" id="postModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="postForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>English Title</label>
                        <input type="text" name="eng_title" id="eng_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Hindi Title</label>
                        <input type="text" name="hindi_title" id="hindi_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" onchange="previewImage(event)">
                        <img id="preview" src="" width="100" style="margin-top:10px; display:none;">
                        <img id="oldImage" src="" width="100" style="margin-top:10px; display:none;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById("modalTitle").innerText = "Add Post";
    document.getElementById("postForm").action = "{{ route('posts.store') }}";
    document.getElementById("formMethod").value = "POST";

    document.getElementById("hindi_title").value = "";
    document.getElementById("eng_title").value = "";
    document.getElementById("preview").style.display = "none";
    document.getElementById("oldImage").style.display = "none";
}

function openEditModal(id, hindi_title, eng_title, image) {
    document.getElementById("modalTitle").innerText = "Edit Post";
    document.getElementById("postForm").action = "/posts/" + id;
    document.getElementById("formMethod").value = "PUT";

    document.getElementById("hindi_title").value = hindi_title;
    document.getElementById("eng_title").value = eng_title;

    document.getElementById("preview").style.display = "none";

    if (image) {
        document.getElementById("oldImage").src = "/uploads/" + image;
        document.getElementById("oldImage").style.display = "block";
    } else {
        document.getElementById("oldImage").style.display = "none";
    }
}

function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('preview');
        output.src = reader.result;
        output.style.display = "block";
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection