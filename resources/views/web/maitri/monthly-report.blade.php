@extends('submaster')
@section('content')
<style>
    .resetbtn{
        margin-top: -87px !important;
        margin-left: 50% !important;
    }
</style>
<div class="container main-div">
<h3 class="text-center fw-bold m-4">मासिक प्रगति रिपोर्ट (एमपीआर) </h3>

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
    @if(count($data))
        @foreach($data as $key => $row)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $row->user->name }}</td>
                
                <td>
                    @switch($row->service_name)
                        @case('frozen_semen_ai')
                            Frozen Semen AI
                            @break
                        @case('sex_semen_ai')
                            Sex Sorted Semen AI
                            @break
                        @case('ivf_embryo')
                            IVF Embryo
                            @break
                        @case('health_medical_checkup') 
                            Health/Medical Checkup
                            @break
                        @case('animal_insurance')
                            Animal Insurance
                            @break
                        @case('vaccination')
                            Vaccination
                            @break
                        @case('pregnancy_diagnosis')
                            Pregnancy Diagnosis
                            @break
                        @default
                            -
                    @endswitch
                </td>

                <td>{{ $row->request_message }}</td>
                <td>
                    @php
                        $statusMap = [
                            1 => ['btn btn-primary', 'New'],
                            2 => ['btn btn-warning', 'Waiting'],
                            3 => ['btn btn-danger', 'Decline'],
                            0 => ['btn btn-success', 'Accept'],
                        ];
                        [$color, $name] = $statusMap[$row->status] ?? ['btn btn-secondary', 'Unknown'];
                    @endphp
                    <button class="{{ $color }}">{{ $name }}</button>
                </td>
                <td>{{ date('M jS Y', strtotime($row->created_at)) }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" style="color:red;">No records..</td>
        </tr>
    @endif
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
