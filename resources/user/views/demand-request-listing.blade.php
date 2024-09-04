@extends('master')
@section('content')

    <div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
        <h3 style="margin-top:10px;text-align: center;">Demand Requests Listing</h3>
        <div class="row">
        </div>
        <table id="myTable202" class="table table-striped table-responsive table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date Of Birth</th>
                    <th>Gender</th>
                    <th>Training Center Id</th>
                    <th>Districts - Block</th>
                    <th>Mobile No</th>
                    <th>Request Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @if(count($data)>0)
            @foreach($data as $val)
            <tr>
                <td>{{$val->name}}</td>
                <td>{{ date('j F, Y', strtotime($val->date_of_birth))}}</td>
                <td>{{$val->gender}}</td>
                <td>{{$val->training_center_id}}</td>
                <td>{{$val->district}} - {{$val->block}} </td>
                <td>{{$val->smart_mobile_no}}</td> 
                <td> <a href="javascript:void(0)" class="btn btn-secondary">{{date('d/m/Y', strtotime($val->created_at))}}</a>  </td>
                <td><button class="btn btn-danger deleteRequest" data-id="{{$val->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6" style="color:red;">No record found..</td>
            </tr>
            @endif
            </tbody>
        </table>
        <div class="row">
       {!! $data->links() !!}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>	
 const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });

$('.deleteRequest').click(function() {
    var val = $(this).data("id");
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "{{ route('deleteRequests') }}",
                    dataType: 'json',
                    data: { id: val, _token: "{{ csrf_token() }}" },
                    success: function (result) {
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Your record has been deleted.',
                            'success'
                        );
                        location.reload();
                    }
                });
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your record is safe!',
                    'error'
                );
            }
        });
    });

</script>

@endsection

