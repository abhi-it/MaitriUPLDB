@extends('submaster')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center fw-bold m-4">सेवा अनुरोध सूची</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>क्र. सं.</th>
                <!-- <th>User Name</th> -->
                <th>सेवा का नाम</th>
                <!-- <th>Maitri Name</th> -->
                <th>संदेश</th>
                <th>स्थिति देखे</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
            @if(count($data))
            @foreach($data as$key=> $row)
            <tr>
                <td>{{$key+1}}</td>
                <!-- <td>{{$row->user->name}}</td> -->
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



                <!-- <td>{{$row->maitri->name}}</td> -->
                <td>{{$row->request_message}}</td>
                @if($row->status==1)
                <td> <button class="btn btn-primary">नया है</button></td>
                @elseif($row->status==2)
                <td><button class="btn btn-warning">इंतज़ार में है</button></td>
                @elseif($row->status==3)
                <td><button class="btn btn-danger">अस्वीकार किया गया है</button></td>
                @elseif($row->status==0)
                <td><button class="btn btn-success">स्वीकार कर लिया है</button></td>
                @endif

                <!-- <td>
				<a href="{{url('maitri-details')}}/{{$row->id}}" >Edit</a> | 
                <button type="button" class="btn custom-btn btn-danger deleteUser"  data-id="{{$row->id}}"><i class="fa fa-trash">Delete</i></button>

			</td> -->
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="5" style="color:red;">No records..</td>
            </tr>
            @endif
        </tbody>
    </table>

</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
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
                        url: "delete-request",
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