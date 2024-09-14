@extends('master')
@section('content')
@php
use App\Models\Districts;
@endphp
<div class="container main-div">
    <div class="row mt-4 mb-3 m-2">
        <div class="col-md-6 text-left">
        <h3 class="fw-bold">नयी जानकारियाँ</h3>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{route('add-latest-update')}}" class="btn btn-primary">Add New</a>
        </div>
    </div>
   
    
    @if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}  
    </div>
    @endif
    <div class="card mb-5">
        <table class="table table-striped  table-responsive table-bordered">
            <thead>
                <tr>
                    <th width="5%">क्रं सं</th>
                    <th width="5%">शीर्षक</th>
                    <th width="15%">यूआरएल</th>
                    <th width="20%">विवरण</th>
                    <th width="5%">द्वारा जोड़ा गया</th>
                    <th width="5%">स्थिति</th>
                    <th width="10%">गतिविधि</th>
                </tr>
            </thead>
            <tbody>
                @if(count($data)>0)
                @foreach($data as $key=> $row)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{substr($row->title,0,20)}},,</td>
                    <td><a href="{{$row->url}}" target="_blank"> {{$row->url}}</a></td>
                    <td>{{substr($row->description,0,100)}},,,,</td>
                    <td>{{$row->user->name}}</td>
                    <td>
                        <select class="form-control status" name="status" id="{{$row->id}}" >
                            <option value="1" {{($row->status==='1')?'selected':""}}>Active</option>
                            <option value="0" {{($row->status=='0')?'selected':""}}>Inactive</option>
                        </select>
                    </td>
                    <td>
                    <div class="d-flex gap-2">
                        <a href="{{url('edit-latest-updated')}}/{{$row->id}}" class="btn btn-secondary" ><i class="fa fa-edit" aria-hidden="true"></i></a>
                        <button class="btn btn-danger deleteRecords" data-id="{{$row->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                    </div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="6" class="text-center">Data not found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
     $(document).ready(function() {
        $('.deleteRecords').click(function() {
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
                            url: "delete-updates",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id
                            },
                            cache: false,
                            success: function(data) {
                                if (data.status == 'success') {
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

        $('.status').change(function() {
            var id  = $(this).attr('id'); 
            console.log('id', id); 
            if(id){
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#206b4c",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Change it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "changeStatusUpdates",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id,
                            },
                            cache: false,
                            success: function(data) {
                                if (data.status == 'success') {
                                    Swal.fire({
                                        title: "Updated!",
                                        text: "This request has been updated.",
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
 @endsection 
