@extends('submaster')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
<h3 class="text-center fw-bold m-4">सेवा अनुरोध सूची</h3>

<table class="table">
    <thead>
        <tr>
			<th>क्र. सं.</th>
			<th>उपयोगकर्ता नाम</th>
			<th>सेवा का नाम </th>
			<th>मैत्री नाम</th>
			<th>Message</th>
			<th>स्थिति</th>
            <!-- <th>Action</th> -->
        </tr>
    </thead>
    <tbody>
		@if(count($data))
		@foreach($data as$key=> $row)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$row->user->name}}</td>
             @if($row->service_name=='frozen_semen_ai')
                <td>Frozen Semen AI</td>
            @elseif($row->service_name=='sex_semen_ai')
                <td>Sex Sorted Semen AI</td>
            @elseif($row->service_name=='ivf_embryo')
                <td>IVF Embryo</td>
            @elseif($row->service_name=='health_medical_checkip')
                <td>Helath/Medical Checkup</td>
            @elseif($row->service_name=='animal_insurance')
                <td>Animal Insurance</td>
            @elseif($row->service_name=='vaccination')
                <td>Vaccination</td>
            @elseif($row->service_name=='pregnancy_diagnosis')
                <td>Pregnancy Diagnosis</td>
            @endif
        
            
            <td>{{$row->maitri->name}}</td>
            <td>{{$row->request_message}}</td>
            <td>  
                @php
                    $color = ''; 
                    if ($row->status == 1) {
                        $color = "btn btn-primary";
                    } elseif ($row->status == 2) {
                        $color = "btn btn-warning";
                    } elseif ($row->status == 3) {
                        $color = "btn btn-danger";
                    } elseif ($row->status == 0) {
                        $color = "btn btn-success";
                    }
                @endphp

                <select class="form-control status {{$color}}" name="status" id="{{$row->id}}" >
                    <option value="1" {{($row->status==1)?'selected':""}}>नया है</option>
                    <option value="2" {{($row->status==2)?'selected':""}}>इंतज़ार में है</option>
                    <option value="3"{{($row->status==3)?'selected':""}} >अस्वीकार किया गया है</option>
                    <option value="0" {{($row->status==0)?'selected':""}} >स्वीकार कर लिया है</option>
                </select>
            </td>
            <!-- <td> @if($row->status==1)
                 <button class="btn btn-primary"> New</button>
                 @elseif($row->status==2)
                 <button class="btn btn-warning"> Waiting</button>
                 @elseif($row->status==3)
                 <button class="btn btn-danger">Decline</button>
                 @elseif($row->status==0)
                 <button class="btn btn-success"> Accept</button>
                @endif -->
            <!-- </td> -->
            <!-- <td>
				<a href="{{url('maitri-details')}}/{{$row->id}}" >Edit</a> | 
                <button type="button" class="btn custom-btn btn-danger deleteUser"  data-id="{{$row->id}}"><i class="fa fa-trash">Delete</i></button>

			</td> -->
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="5" style="color:red;">कोई रिकॉर्ड नहीं..</td>
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

        $('.status').change(function() {
            var val = $(this).val();
            var id = $(this).attr('id'); 
            console.log('id', id, 'value', val); 
            if(val && id){
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#206b4c",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Update it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "updateServiceRequest",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id,
                                "val":val,
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
