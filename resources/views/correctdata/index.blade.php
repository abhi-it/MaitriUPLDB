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
    @if(session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
    @endif
    <h3 class="text-center fw-bold m-4">
        <span data-hi="आवेदन फॉर्म के लिए सही डेटा" data-en="Correct Data for avedan form"></span>
    </h3>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Add New Data</button>
    <table class="table table-striped  table-responsive table-bordered">
        <thead>
            <tr>
                <th>S.No</th>
                <th><span data-hi="तरल नाइट्रोजन" data-en="Mandal Name"></span></th>
                <th><span data-hi="वीर्य" data-en="Janpad Name"></span></th>
                <th><span data-hi="वीर्य स्ट्रॉस" data-en="Teshil"></span></th>
                <th><span data-hi="वीर्य का प्रकार" data-en="Block"></span></th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->mandal_name }}</td>
                    <td>{{ $item->janpad_name }}</td>
                    <td>{{ $item->block }}</td>
                    <td>{{ $item->tehsil }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" 
                                data-id="{{ $item->id }}"
                                data-mandal_name="{{ $item->mandal_name }}"
                                data-janpad_name="{{ $item->janpad_name }}"
                                data-block="{{ $item->block }}"
                                data-tehsil="{{ $item->tehsil }}">
                            Edit
                        </button>
                        <form action="{{ route('correctdata-destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $data->links() }}
    </div>
    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Add New Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('correctdata-store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="mandal_name" class="form-label">Mandal Name</label>
                            <select class="form-select mandal_name" id="mandal_name" name="mandal_name" required>
                                <option value="">Select Mandal</option>
                                @foreach ($mandalNames as $mandal)
                                    <option value="{{ $mandal }}">{{ $mandal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="janpad_name" class="form-label">Janpad Name</label>
                            <select class="form-select janpad_name" id="janpad_name" name="janpad_name" required>
                                <option value="">Select Janpad</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tehsil" class="form-label">Tehsil</label>
                            <select class="form-select tehsil" id="tehsil" name="tehsil" required>
                                <option value="">Select Tehsil</option>
                            </select>
                            <button type="button" class="btn btn-link" id="addNewTehsilBtn">Add New Tehsil</button>
                        </div>
                        <div class="mb-3">
                            <label for="block" class="form-label">Block</label>
                            <select class="form-select block" id="block" name="block" required>
                                <option value="">Select Block</option>
                            </select>
                            <button type="button" class="btn btn-link" id="addNewBlockBtn">Add New Block</button>
                        </div>
                    
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="editForm">
                        @csrf
                        @method('PUT')
                       <div class="mb-3">
                            <label for="mandal_name" class="form-label">Mandal Name</label>
                            <select class="form-select" id="edit_mandal_name" name="mandal_name" required>
                                <option value="">Select Mandal</option>
                                @foreach ($mandalNames as $mandal)
                                    <option value="{{ $mandal }}">{{ $mandal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="janpad_name" class="form-label">Janpad Name</label>
                            <select class="form-select" id="edit_janpad_name" name="janpad_name" required>
                                <option value="">Select Janpad</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tehsil" class="form-label">Tehsil</label>
                            <select class="form-select" id="edit_tehsil" name="tehsil" required>
                                <option value="">Select Tehsil</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="block" class="form-label">Block</label>
                            <select class="form-select" id="edit_block" name="block" required>
                                <option value="">Select Block</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
   
    $('#mandal_name').change(function() {
        var mandal_name = $(this).val();
        
        if (mandal_name) {
            $.ajax({
                url: '/get-janpad-names',
                type: 'GET',
                data: { mandal_name: mandal_name },
                success: function(response) {
                    var janpadSelect = $('#janpad_name');
                    janpadSelect.empty();
                    janpadSelect.append('<option value="">Select Janpad</option>');
                    $.each(response, function(index, value) {
                        janpadSelect.append('<option value="' + value + '">' + value + '</option>');
                    });
                }
            });
        } else {
            $('#janpad_name').empty().append('<option value="">Select Janpad</option>');
        }
    });

    $('#janpad_name').change(function() {
        var mandal_name = $('#mandal_name').val();
        var janpad_name = $(this).val();

        if (mandal_name && janpad_name) {
            $.ajax({
                url: '/get-tehsil-names',
                type: 'GET',
                data: { mandal_name: mandal_name, janpad_name: janpad_name },
                success: function(response) {
                    var tehsilSelect = $('#tehsil');
                    tehsilSelect.empty();
                    tehsilSelect.append('<option value="">Select Tehsil</option>');
                    $.each(response, function(index, value) {
                        tehsilSelect.append('<option value="' + value + '">' + value + '</option>');
                    });
                }
            });
        } else {
             $('#tehsil').empty().append('<option value="">Select Tehsil</option>');
        }
    });

    $('#tehsil').change(function() {
        var mandal_name = $('.mandal_name').val();
        var janpad_name = $('.janpad_name').val();
        var block = $(this).val();
        
        if (mandal_name && janpad_name && block) {
            $.ajax({
                url: '/get-block-names',
                type: 'GET',
                data: { mandal_name: mandal_name, janpad_name: janpad_name, block: block },
                success: function(response) {
                    var blockSelect =  $('#block');
                    blockSelect.empty();
                    blockSelect.append('<option value="">Select Block</option>');
                    $.each(response, function(index, value) {
                        blockSelect.append('<option value="' + value + '">' + value + '</option>');
                    });
                }
            });
        } else {
            $('#block').empty().append('<option value="">Select Block</option>');
        }
    });

    $('#addNewBlockBtn').click(function() {
        var newBlock = prompt('Enter new block name:');
        if (newBlock) {
            $.post('/store-new-block', {
                _token: '{{ csrf_token() }}',
                mandal_name: $('#mandal_name').val(),
                janpad_name: $('#janpad_name').val(),
                block: newBlock
            }, function(response) {
                alert(response.message);
                $('#block').append('<option value="' + newBlock + '">' + newBlock + '</option>');
            });
        }
    });

    $('#addNewTehsilBtn').click(function() {
        var newTehsil = prompt('Enter new tehsil name:');
        if (newTehsil) {
            $.post('/store-new-tehsil', {
                _token: '{{ csrf_token() }}',
                mandal_name: $('#mandal_name').val(),
                janpad_name: $('#janpad_name').val(),
                block: $('#block').val(),
                tehsil: newTehsil
            }, function(response) {
                alert(response.message);
                $('#tehsil').append('<option value="' + newTehsil + '">' + newTehsil + '</option>');
            });
        }
    });
</script>

<script>

    $(document).ready(function(){
        $('#edit_mandal_name').change(function() {
            var mandal_name = $(this).val();
            
            if (mandal_name) {
                $.ajax({
                    url: '/get-janpad-names',
                    type: 'GET',
                    data: { mandal_name: mandal_name },
                    success: function(response) {
                        var janpadSelect = $('#edit_janpad_name');
                        janpadSelect.empty();
                        janpadSelect.append('<option value="">Select Janpad</option>');
                        $.each(response, function(index, value) {
                            janpadSelect.append('<option value="' + value + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#edit_janpad_name').empty().append('<option value="">Select Janpad</option>');
            }
        });
    
        $('#edit_janpad_name').change(function() {
            var mandal_name = $('#edit_mandal_name').val();
            var janpad_name = $(this).val();
    
            if (mandal_name && janpad_name) {
                $.ajax({
                    url: '/get-tehsil-names',
                    type: 'GET',
                    data: { mandal_name: mandal_name, janpad_name: janpad_name },
                    success: function(response) {
                        var tehsilSelect = $('#edit_tehsil');
                        tehsilSelect.empty();
                        tehsilSelect.append('<option value="">Select Tehsil</option>');
                        $.each(response, function(index, value) {
                            tehsilSelect.append('<option value="' + value + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                 $('#edit_tehsil').empty().append('<option value="">Select Tehsil</option>');
            }
        });
    
        $('#edit_tehsil').change(function() {
            var mandal_name = $('#edit_mandal_name').val();
            var janpad_name = $('#edit_janpad_name').val();
            var block = $(this).val();
            
            if (mandal_name && janpad_name && block) {
                $.ajax({
                    url: '/get-block-names',
                    type: 'GET',
                    data: { mandal_name: mandal_name, janpad_name: janpad_name, block: block },
                    success: function(response) {
                        var blockSelect =  $('#edit_block');
                        blockSelect.empty();
                        blockSelect.append('<option value="">Select Block</option>');
                        $.each(response, function(index, value) {
                            blockSelect.append('<option value="' + value + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#edit_block').empty().append('<option value="">Select Block</option>');
            }
        });
    }) 
</script>

<script>
    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); 
        var id = button.data('id');
        var mandal_name = button.data('mandal_name');
        var janpad_name = button.data('janpad_name');
        var block = button.data('block');
        var tehsil = button.data('tehsil');
        
        var modal = $(this);
        modal.find('#editForm').attr('action', '/correctdata/' + id);
        modal.find('#edit_mandal_name').val(mandal_name);
        modal.find('#edit_janpad_name').val(janpad_name);
        modal.find('#edit_block').val(block);
        modal.find('#edit_tehsil').val(tehsil);
    });
</script>

@endsection