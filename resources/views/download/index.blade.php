@extends('master')
@section('content')
<div class="container py-5">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h3 class="text-center fw-bold mb-4">Documents</h3>

    <!-- Button trigger modal -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
        + Add Document
    </button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Title</th>
                <th>File</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($documents->count() > 0)
                @foreach($documents as $index => $doc)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td><span data-hi="{{ $doc->title_hindi }}" data-en="{{ $doc->title }}"></span></td>
                    <td><a href="{{ asset($doc->file_path) }}" target="_blank">Download</a></td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" 
                            data-bs-target="#editModal{{ $doc->id }}">Edit</button>
                        <form action="{{ route('documents-destroy',$doc->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this?')">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $doc->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('documents-update',$doc->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header"><h5>Edit Document</h5></div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Title</label>
                                        <input type="text" name="title" class="form-control" value="{{ $doc->title }}" required>
                                    </div>
                                     <div class="mb-3">
                                        <label>Hindi Title</label>
                                        <input type="text" name="title_hindi" class="form-control" value="{{ $doc->title_hindi }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Replace File (optional)</label>
                                        <input type="file" name="file" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button class="btn btn-success">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center text-muted">No documents found</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('documents-store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header"><h5>Add Document</h5></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Hindi Title</label>
                        <input type="text" name="title_hindi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>File</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
