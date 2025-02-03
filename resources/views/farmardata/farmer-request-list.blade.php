@extends('master')
@section('content')
<div class="container main-div" style="background-color:white;min-height:380px;">
    <h3 class="text-center fw-bold m-4"><span data-hi=" किसान अनुरोध सूची" data-en="Farmer Request List"></span></h3>

    <form method="get" action="{{ Request::url() }}" class="form-comman">
        @csrf
        <div class="row">

            @if (auth()->user()->user_type == 'Admin' || auth()->user()->user_type == 'Director')


            <div class="form-group col-md-5 col-xl-3">
                <label for="inputEmail4" class="fw-bold"> <span data-hi="सेलेक्ट जनपद"
                        data-en="Select Janpad"></span></label>
                <select class="form-control" name="district_id" id="district_id">
                    <option value="">किसी एक को चुनें</option>
                    @foreach($district as $dis)
                    <option value="{{ $dis['id'] }}" data-hi="{{ $dis['name_hindi'] }}"
                        data-en="{{ $dis['name_eng'] }}"></option>
                    @endforeach
                </select>
            </div>
            @endif


            <div class="form-group col-xl-3 mt-4 col-md-12">
                <button type="submit" class="btn btn-primary"> <span data-hi="सर्च करें" data-en="Search">
                    </span></button>
                <a href="{{ Request::url() }}" class="btn btn-secondary"> <span data-hi=" रीसेट करें"
                        data-en="Reset"></span></a>
                @if (isset($route, $year))
                @php
                $queryParameters = request()->query();

                $queryParameters['export'] = true;
                $queryParameters['year'] = $year;
                @endphp

                <a class="btn btn-secondary btn-export" href="{{ route($route, $queryParameters) }}">Export</a>
                @endif
            </div>

        </div>
    </form>
    <div class="pagination">
        <div class="col-md-12">
            <div class="pagnation-scroll">
                {{ $data->links() }}
            </div>
        </div>
    </div>
    <table class="table table-striped  table-responsive table-bordered">
        <thead>
            <tr>
                <th>क्र. सं.</th>
                <th>किसान का नाम</th>
                <th>ज़िला</th>
                <th>सेवा का नाम</th>
                <th>संदेश</th>
                <th>मैत्री को नियुक्त करें</th>
                <th>स्थिति</th>
                <th>स्थिति बदलें</th>
                <th>डिलीट करे</th>
            </tr>
        </thead>
        <tbody>
            @if(count($data))
            @foreach($data as$key=> $row)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$row->user->name  }}</td>
                <td>{{$row->user->district['name_hindi']}}</td>
                @if($row->service_name == 'health_medical_checkip')
                <td>स्वास्थ्य/चिकित्सा जांच</td>
                @elseif($row->service_name == 'animal_insurance')
                <td>पशु बीमा</td>
                @elseif($row->service_name == 'vaccination')
                <td>टीकाकरण</td>
                @elseif($row->service_name == 'pregnancy_diagnosis')
                <td>गर्भावस्था निदान</td>
                @else
                <td>--</td>
                @endif

                <td>{{$row->request_message}}</td>
                <td>{{($row->maitri->name) ?? '--'}}</td>

                @if($row->status==1)
                <td> <button class="btn btn-primary btn-sm">नया है</button></td>
                @elseif($row->status==2)
                <td><button class="btn btn-warning btn-sm">इंतज़ार में है</button></td>
                @elseif($row->status==3)
                <td><button class="btn btn-danger btn-sm">अस्वीकार किया गया है</button></td>
                @elseif($row->status==0)
                <td><button class="btn btn-success btn-sm">स्वीकार कर लिया है</button></td>
                @endif
                <td>
                    <button type="button" class="btn custom-btn btn-primary changeStatus btn-sm" data-id="{{$row->id}}"
                        data-farmer="{{$row->user->name}}" data-status="{{$row->status}}"
                        data-mairtiId="{{$row->maitri->id}}" data-service="{{$row->service_name}}">
                        Change Status
                    </button>
                </td>
                <td>
                    <button type="button" class="btn custom-btn btn-danger deleteUser" data-id="{{$row->id}}"><i
                            class="fa fa-trash">Delete</i></button>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="9" class="text-center" style="color:red;">No records..</td>
            </tr>
            @endif
        </tbody>
    </table>
    <div class="pagination">
        {{ $data->links() }}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Change Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="statusForm">
                        <div class="mb-3">
                            <label for="modalStatus" class="form-label">Status</label>
                            <select name="modalStatus" id="modalStatus" class="form-select">
                                <option value="1">नया है</option>
                                <option value="2">इंतज़ार में है</option>
                                <option value="3">अस्वीकार किया गया है</option>
                                <option value="0">स्वीकार कर लिया है</option>
                            </select>
                            <select name="assign_maitri" id="assign_maitri" class="form-select mt-2">
                                <option value="" data-hi="मैत्री को नियुक्त करें" data-en="Assign Maitri"></option>
                                @foreach($getMaitri as $mairti)
                                <option value="{{ $mairti['id'] }}">{{ $mairti['name'] }}</option>
                                @endforeach

                            </select>
                        </div>
                        <input type="hidden" id="rowId" name="rowId">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" id="saveStatus">Save changes</button>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
<style>
body {
    overflow-x: hidden;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {

    $('.changeStatus').click(function() {
        var rowId = $(this).data('id');
        var currentStatus = $(this).data('status');
        var mairtiId = $(this).attr('data-mairtiId');

        $('#rowId').val(rowId);
        $('#modalStatus').val(currentStatus);
        if ($("#assign_maitri option[value='" + mairtiId + "']").length > 0) {
            $('#assign_maitri').val(mairtiId).change();
        } else {
            console.warn('Option value not found:', mairtiId);
        }
        $('#statusModal').modal('show');
    });

    $('#saveStatus').click(function() {
        var rowId = $('#rowId').val();
        var newStatus = $('#modalStatus').val();
        var assign_maitri = $('#assign_maitri').val();
        Swal.fire({
            title: "Are you sure?",
            text: "You won't to change this status",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#206b4c",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, change it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin-update-status',
                    method: 'POST',
                    data: {
                        id: rowId,
                        status: newStatus,
                        assign_maitri: assign_maitri,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#statusModal').modal('hide');
                        Swal.fire({
                            title: "Change!",
                            text: "Status has been changed.",
                            icon: "success"
                        });
                        location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        })
    });


    $('.deleteUser').click(function() {
        var id = $(this).attr("data-id");
        if (id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#206b4c",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "admin-delete-request",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id
                        },
                        cache: false,
                        success: function(data) {
                            if (data.status == 'Success') {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your record has been deleted.",
                                    icon: "success"
                                });
                                location.reload();
                            }
                        }
                    });
                }
            });
        }
    });
});
</script>