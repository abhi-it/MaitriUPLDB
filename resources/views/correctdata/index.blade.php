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
    <!-- <form method="GET" action="{{ route('correctdata-get') }}" class="row g-2 mb-3">
        <div class="col-md-3">
            <select name="mandal_name" class="form-select">
                <option value="" selected>-- Select Mandal --</option>
                @foreach($mandals as $m)
                    @if(!empty($m->mandal_name))
                        <option value="{{ $m->mandal_name }}" 
                            {{ request('mandal_name') == $m->mandal_name ? 'selected' : '' }}>
                            {{ $m->mandal_name }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select name="janpad_name" class="form-select">
                <option value="" selected>-- Select Janpad --</option>
                @foreach($janpads as $j)
                    @if(!empty($j->janpad_name))
                        <option value="{{ $j->janpad_name }}" 
                            {{ request('janpad_name') == $j->janpad_name ? 'selected' : '' }}>
                            {{ $j->janpad_name }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select name="tehsil" class="form-select">
                <option value="" selected>-- Select Tehsil --</option>
                @foreach($tehsils as $t)
                    @if(!empty($t->tehsil))
                        <option value="{{ $t->tehsil }}" 
                            {{ request('tehsil') == $t->tehsil ? 'selected' : '' }}>
                            {{ $t->tehsil }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="col-md-3 d-flex">
            <button type="submit" class="btn btn-primary me-2">Filter</button>
            <a href="{{ route('correctdata-get') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form> -->

    <form method="GET" action="{{ route('correctdata-get') }}" class="mb-4 row g-3">
        <div class="col-md-3">
            <label>Mandal</label>
            <select name="mandal_name" id="filter_mandal" class="form-select">
                <option value="">Select Mandal</option>
                @foreach($mandalNames as $mandal)
                    @if(!empty($mandal))
                        <option value="{{ $mandal }}" {{ $selectedMandal == $mandal ? 'selected' : '' }}>
                            {{ $mandal }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label>Janpad</label>
            <select name="janpad_name" id="filter_janpad" class="form-select">
                <option value="">Select Janpad</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>Tehsil</label>
            <select name="tehsil" id="filter_tehsil" class="form-select">
                <option value="">Select Tehsil</option>
            </select>
        </div>

        <div class="col-md-3">
            <button class="btn btn-primary mt-4">Search</button>
            <a href="{{ route('correctdata-get') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

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
            @foreach ($data as $key => $item)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $item->mandal_name }}</td>
                    <td>{{ $item->janpad_name }}</td>
                    <td>{{ $item->tehsil }}</td>
                    <td>{{ $item->block }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editModal" 
                                data-id="{{ $item->id }}"
                                data-mandal="{{ $item->mandal_name }}"
                                data-janpad="{{ $item->janpad_name }}"
                                data-tehsil="{{ $item->tehsil }}"
                                data-block="{{ $item->block }}">
                            Edit
                        </button>
                        <form action="{{ route('correctdata-destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
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
                                    @if(!empty($mandal))
                                    <option value="{{ $mandal }}">{{ $mandal }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="janpad_name" class="form-label">Janpad Name</label>
                            <select class="form-select janpad_name" id="janpad_name" name="janpad_name" required>
                                <option value="">Select Janpad</option>
                            </select>
                        </div>
                        <div class="mb-3" id="tehsil-wrapper">
                            <div id="tehsil-select-wrapper">
                                <label for="">Tehsil</label>
                                <select class="form-select" id="tehsil" name="tehsil">
                                    <option value="">Select Tehsil</option>
                                </select>
                            </div>

                            <div id="tehsil-input-wrapper" style="display:none;">
                                <label for="">Tehsil</label>
                                <input type="text" name="new_tehsil" id="tehsil-input" class="form-control" placeholder="Enter new Tehsil">
                            </div>

                            <button type="button" id="toggle-tehsil" class="btn btn-sm btn-outline-primary mt-2">
                                Add New Tehsil
                            </button>
                        </div>
                        <div class="mb-3" id="block-wrapper">
                            <div id="block-select-wrapper">
                                <label for="">Block</label>
                                <select class="form-select block" id="block" name="block">
                                    <option value="">Select Block</option>
                                </select>
                            </div>

                            <div id="block-input-wrapper" style="display:none;">
                                <label for="">Block</label>
                                <input type="text" name="new_block" id="block-input" class="form-control" placeholder="Enter new Block">
                            </div>

                            <button type="button" id="toggle-block" class="btn btn-sm btn-outline-primary mt-2">
                                Add New Block
                            </button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    @if(request('mandal_name'))
        $('#filter_mandal').val("{{ request('mandal_name') }}").trigger('change');

        setTimeout(function () {
            $('#janpad_name').val("{{ request('janpad_name') }}").trigger('change');
        }, 500);

        setTimeout(function () {
            $('#tehsil').val("{{ request('tehsil') }}").trigger('change');
        }, 1000);
    @endif
});
</script>

<script>

    $('#mandal_name, #filter_mandal').change(function() {
        var mandal_name = $(this).val();
        if (mandal_name) {
            $.ajax({
                url: '/get-janpad-names',
                type: 'GET',
                data: { mandal_name: mandal_name },
                success: function(response) {
                    var janpadSelect = $('#janpad_name, #filter_janpad');
                    janpadSelect.empty();
                    janpadSelect.append('<option value="">Select Janpad</option>');
                    $.each(response, function(index, value) {
                        janpadSelect.append('<option value="' + value + '">' + value + '</option>');
                    });
                }
            });
        } else {
            $('#janpad_name, #filter_janpad').empty().append('<option value="">Select Janpad</option>');
        }
    });

    $('#janpad_name, #filter_janpad').change(function() {
        var mandal_name = $('#mandal_name, #filter_mandal').val();
        var janpad_name = $(this).val();

        if (mandal_name && janpad_name) {
            $.ajax({
                url: '/get-tehsil-names',
                type: 'GET',
                data: { mandal_name: mandal_name, janpad_name: janpad_name },
                success: function(response) {
                    var tehsilSelect = $('#tehsil, #filter_tehsil');
                    tehsilSelect.empty();
                    tehsilSelect.append('<option value="">Select Tehsil</option>');
                    $.each(response, function(index, value) {
                        tehsilSelect.append('<option value="' + value + '">' + value + '</option>');
                    });
                }
            });
        } else {
             $('#tehsil, #filter_tehsil').empty().append('<option value="">Select Tehsil</option>');
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
    $(document).on('click', '.edit-btn', function () {
      
        let id = $(this).data('id');
        let mandal = $(this).data('mandal');
        let janpad = $(this).data('janpad');
        let tehsil = $(this).data('tehsil');
        let block = $(this).data('block');

        $('#editForm').attr('action', '/correctdata/' + id);

        $('#edit_mandal_name').val(mandal).trigger('change');
        setTimeout(function() {
            $('#edit_janpad_name').val(janpad).trigger('change');
        }, 500);

        setTimeout(function() {
            $('#edit_tehsil').val(tehsil).trigger('change');
        }, 1000);

        setTimeout(function() {
            $('#edit_block').val(block);
        }, 1500);

        $('#editModal').modal('show');
    });

    document.addEventListener('DOMContentLoaded', function () {
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            let form = $(this).closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "This record will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    function setupToggle(toggleId, selectWrapperId, inputWrapperId, selectId, inputId, labelSelect, labelInput) {
        const toggleBtn = document.getElementById(toggleId);
        const selectWrapper = document.getElementById(selectWrapperId);
        const inputWrapper = document.getElementById(inputWrapperId);
        const select = document.getElementById(selectId);
        const input = document.getElementById(inputId);

        toggleBtn.addEventListener("click", function () {
            if (selectWrapper.style.display !== "none") {
                selectWrapper.style.display = "none";
                inputWrapper.style.display = "block";
                select.removeAttribute("name");
                input.setAttribute("name", select.getAttribute("id").replace("-select", ""));
                toggleBtn.textContent = labelSelect;
            } else {
                inputWrapper.style.display = "none";
                selectWrapper.style.display = "block";
                input.removeAttribute("name");
                select.setAttribute("name", select.getAttribute("id").replace("-select", ""));
                toggleBtn.textContent = labelInput;
            }
        });
    }

    setupToggle("toggle-tehsil", "tehsil-select-wrapper", "tehsil-input-wrapper", "tehsil", "tehsil-input", "Choose Existing Tehsil", "Add New Tehsil");
    setupToggle("toggle-block", "block-select-wrapper", "block-input-wrapper", "block", "block-input", "Choose Existing Block", "Add New Block");
});
</script>


@endsection