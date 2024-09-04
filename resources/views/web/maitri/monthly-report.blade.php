@extends('submaster')
@section('content')
<style>
    .resetbtn{
        margin-top: -87px !important;
        margin-left: 50% !important;
    }
</style>
<div class="container main-div">
<h3 style="margin-top:10px;text-align: center;">मासिक प्रगति रिपोर्ट (एमपीआर) </h3>

    <form action="{{url('filtered-monthly-report')}}" method="post">
            @csrf
        <div class="row mb-5 mt-5">
            <div class="col-md-2">
                <select class="form-control" name="month" id="month">
                    <option value=''>--Select Month--</option>
                    <option value='1'>Janaury</option>
                    <option value='2'>February</option>
                    <option value='3'>March</option>
                    <option value='4'>April</option>
                    <option value='5'>May</option>
                    <option value='6'>June</option>
                    <option value='7'>July</option>
                    <option value='8'>August</option>
                    <option value='9'>September</option>
                    <option value='10'>October</option>
                    <option value='11'>November</option>
                    <option value='12'>December</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control" min="1900" max="2099" step="1" value="2024" name="year" style="height: calc(2.25rem + 2px);"/>
            </div>
            <div class="col-md-2">
                <input type="submit" class="form-control btn btn-primary" value="Submit" name="submit" />
            </div>
           
        </div>
    </form>
    <div class="col-md-2 mb-5 resetbtn">
        <a href="{{url('monthly-report')}}"><button class="btn btn-danger" style="width:170px;">Reset</button></a>
    </div>

    
<div class="card">
    <table class="table">
        <thead>
            <tr>    
                <th>क्रमांक</th>
                <th>पशुपालक</th>
                <th>सेवा का नाम  </th>
                <th>संदेश</th>
                <th>स्थिति</th>
                <th>जोड़ी गई तिथि</th>
            </tr>
        </thead>
        <tbody>
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
                <td>{{$row->request_message}}</td>
                <td>  
                    @php
                        $color = ''; 
                        $name  = '';
                        if ($row->status == 1) {
                            $color = "btn btn-primary";
                            $name  = "New";
                        } elseif ($row->status == 2) {
                            $color = "btn btn-warning";
                            $name   = "Waiting";
                        } elseif ($row->status == 3) {
                            $color = "btn btn-danger";
                            $name  = "Decline";
                        } elseif ($row->status == 0) {
                            $color = "btn btn-success";
                            $name = "Accept";
                        }
                    @endphp
                        <button class="{{$color}}">{{$name}} </button>
                
                </td>
                <td> {{date('M Do', strtotime($row->created_at))}}</td>
            
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="5" style="color:red;">No records..</td>
            </tr>
            @endif
        </tbody>
        
        </tbody>
    </table>
</div>



</div>
@endsection 

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
</script> -->
