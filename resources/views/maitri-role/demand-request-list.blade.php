@extends('submaster')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">

    {{-- Header: Title (left) + Add Button (right) --}}
    <div class="d-flex justify-content-between align-items-center m-4">
        <h3 class="fw-bold mb-0">डिमांड अनुरोध सूची</h3>
        <a href="{{ route('demandRequests') }}" class="btn btn-success">
            <i class="fa fa-plus"></i> Add Demand Request
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>क्र. सं.</th>
                <th>नाम</th>
                <th>जन्म तिथि</th>
                <th>लिंग</th>
                <th>भारत पशुधन ID</th>
                <th>जिला</th>
                <th>मंडल</th>
                <th>मोबाइल नं.</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($data) && count($data))
                @foreach($data as $key => $row)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $row->name ?? '--' }}</td>
                    <td>{{ $row->date_of_birth ?? '--' }}</td>
                    <td>{{ $row->gender ?? '--' }}</td>
                    <td>{{ $row->bharat_pashudhan_id ?? '--' }}</td>
                    <td>{{ $row->districtName?->name_eng ?? '--' }}</td>
                    <td>{{ $row->mandal ?? '--' }}</td>
                    <td>{{ $row->smart_mobile_no ?? '--' }}</td>
                    <td>
                        <a href="{{ url('view-demand-request/'.$row->id) }}" type="button" class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i> View
                        </a>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="10" style="color:red;">कोई रिकॉर्ड नहीं..</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

{{-- ================= View Details Modal ================= --}}
<div class="modal fade" id="viewDemandModal" tabindex="-1" role="dialog" aria-labelledby="viewDemandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDemandModalLabel">Demand Request Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="demandDetails">
                    <div class="text-center">Loading...</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {

    // ============ View Details ============
    $('.viewDetails').click(function() {
        var id = $(this).data('id');
        if (!id) return;

        $('#demandDetails').html('<div class="text-center">Loading...</div>');

        $.ajax({
            type: "GET",
            url: "{{ url('demand-request-details') }}/" + id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status === 'success') {
                    var d = response.data;
                    var html = `
                        <table class="table table-bordered">
                            <tr><th width="35%">Name</th><td>${d.name ?? '--'}</td></tr>
                            <tr><th>Date of Birth</th><td>${d.date_of_birth ?? '--'}</td></tr>
                            <tr><th>Gender</th><td>${d.gender ?? '--'}</td></tr>
                            <tr><th>Bharat Pashudhan ID</th><td>${d.bharat_pashudhan_id ?? '--'}</td></tr>
                            <tr><th>Smart Mobile No</th><td>${d.smart_mobile_no ?? '--'}</td></tr>
                            <tr><th>District</th><td>${d.district ?? '--'}</td></tr>
                            <tr><th>Mandal</th><td>${d.mandal ?? '--'}</td></tr>
                            <tr><th>Tehsil</th><td>${d.tehsil ?? '--'}</td></tr>
                            <tr><th>Block</th><td>${d.block ?? '--'}</td></tr>
                            <tr><th>Vikas Khand</th><td>${d.vikas_khand ?? '--'}</td></tr>
                            <tr><th>VH AI Center</th><td>${d.vh_ai_center ?? '--'}</td></tr>
                            <tr><th>Pincode</th><td>${d.pincode ?? '--'}</td></tr>
                            <tr><th>Villages Covering</th><td>${d.villages_coevring ?? '--'}</td></tr>
                            <tr><th>Demand Section</th><td>${d.demand_section ?? '--'}</td></tr>
                            <tr><th>Semen</th><td>${d.semen ?? '--'}</td></tr>
                            <tr><th>Breed</th><td>${d.breed ?? '--'}</td></tr>
                            <tr><th>Bull ID</th><td>${d.bull_id ?? '--'}</td></tr>
                            <tr><th>Sheath</th><td>${d.Sheath ?? '--'}</td></tr>
                            <tr><th>Gloves</th><td>${d.gloves ?? '--'}</td></tr>
                            <tr><th>Animal Tag</th><td>${d.animal_tag ?? '--'}</td></tr>
                            <tr><th>Mineral Mixture</th><td>${d.mineral_mixture ?? '--'}</td></tr>
                            <tr><th>Dewormer</th><td>${d.dewormer ?? '--'}</td></tr>
                            <tr><th>Insurance Booklet</th><td>${d.insurance_booklet ?? '--'}</td></tr>
                            <tr><th>Pregnancy Feed</th><td>${d.pregnancy_feed ?? '--'}</td></tr>
                            <tr><th>Calf Starter</th><td>${d.calf_starter ?? '--'}</td></tr>
                            <tr><th>Any Other Item</th><td>${d.any_other_item ?? '--'}</td></tr>
                            <tr><th>Any Suggestion</th><td>${d.any_suggestion ?? '--'}</td></tr>
                            <tr><th>Any Complaint</th><td>${d.any_complaint ?? '--'}</td></tr>
                            <tr><th>Post Office</th><td>${d.post_office ?? '--'}</td></tr>
                            <tr><th>Semen Type</th><td>${d.semen_type ?? '--'}</td></tr>
                            <tr><th>Training Year</th><td>${d.training_year ?? '--'}</td></tr>
                            <tr><th>Month</th><td>${d.month ?? '--'}</td></tr>
                            <tr><th>Question</th><td>${d.question ?? '--'}</td></tr>
                            <tr><th>Semen Source</th><td>${d.semen_source ?? '--'}</td></tr>
                            <tr><th>Registered Cow Calves</th><td>${d.registered_cow_calves ?? '--'}</td></tr>
                            <tr><th>Registered Buffalo Calves</th><td>${d.registered_buffalo_calves ?? '--'}</td></tr>
                            <tr><th>Registered Sexed Calves</th><td>${d.registered_sexed_calves ?? '--'}</td></tr>
                            <tr><th>Registered Farmers</th><td>${d.registered_farmers ?? '--'}</td></tr>
                        </table>
                    `;
                    $('#demandDetails').html(html);
                } else {
                    $('#demandDetails').html('<div class="text-danger">No data found.</div>');
                }
            },
            error: function() {
                $('#demandDetails').html('<div class="text-danger">Something went wrong.</div>');
            }
        });
    });

    // ============ Status Update ============
    $('.status').change(function() {
        var val = $(this).val();
        var id  = $(this).attr('id');
        if (val && id) {
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
                        url: "updateDemandRequestStatus",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id,
                            "val": val,
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