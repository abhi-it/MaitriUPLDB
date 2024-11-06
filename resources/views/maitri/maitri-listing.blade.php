@extends('master')
@section('content')
    <div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center fw-bold m-4">मैत्री सूची</h3>
        <div class="container text-center">
          
                <form  action="{{ Request::url() }}" method="get" class="form-comman">
                <div class="row">
                    <div class="col-md-4 mt-4 mb-4">
                        <select name="id" id="id" class="form-control">
                            <option>-select one-</option>
                            @foreach($dist as $val)
                                @if($val!='' ||$val != null)
                                <option value="{{$val['mandal_name']}}">{{$val['mandal_name']}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 mt-4 mb-4">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                    <div class="col-md-1 mt-4 mb-4">
                        <a href="{{ Request::url() }}" class="btn btn-danger text-white">रीसेट करें</a>
                    </div>
                    </div>    
                </form>
            
            <div class="row">
            <form method="get" action="{{ route('exportselectedmaitries') }}"> 
                    <div class="col-md-1 mb-4">
                        <input type="hidden" id="dis_id" name="id">
                        <button class="btn btn-primary" type="submit" id="maitriExport" >Export</button>
                    </div>
                </form>
            </div>
        </div>
            <table id="myTable202" class="table table-striped  table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Mandal </th>
                        <th>Janpad </th>
                        <th>Name </th>
                        <th> Mobile No</th>
                        <th>Address</th>
                        <th>Adhar Card </th>
                        <th>Father's Name</th>
                        <th>Certificate No</th>
                        <th>Geo Location</th>
                    </tr>
                </thead>
                <tbody >
                @if(count($data)>0)
                    @php $i = 1 @endphp
                    @foreach($data as $val)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{$val->mandal_name}}</td>
                        <td>{{$val->janpad_name}}</td>
                        <td>{{$val->maitri_name}}</td>
                        <td>{{$val->maitri_mobile_no}}</td>
                        <td>{{$val->gram_panchayat}}  {{$val->post_office}}  {{$val->block}} {{$val->tehsil}}</td>
                        <td>{{$val->adhaar_card}}</td> 
                        <td> {{$val->father_name}} </td>
                        <td>{{$val->certificate_no}}</td>
                        <td>
                            <button class="btn btn-primary edit-btn" data-id="{{ $val->id }}">Edit</button>
                        </td>
                    </tr>
                    @php $i++ @endphp
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" style="color:red;">No record found..</td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="row">
            {{ $items->appends(request()->except('page'))->links() }}
            </div>
      
    </div>


    <!-- Edit Modal Pop-up Start -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Record</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="recordId">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="mandal_name">Mandal Name</label>
                                    <input type="text" class="form-control" readonly name="mandal_name" id="mandal_name">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="janpad_name">Janpad Name</label>
                                    <input type="text" class="form-control" readonly name="janpad_name" id="janpad_name">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="maitri_name">Maitri Name</label>
                                    <input type="text" class="form-control" readonly name="maitri_name" id="maitri_name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" class="form-control" name="latitude" id="latitude">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" class="form-control" name="longitude" id="longitude">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal Pop-up End -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function () {
    // Open modal and load data
    $('.edit-btn').click(function () {
        const recordId = $(this).data('id');

        // Make AJAX call to get record data
        $.get('/matri-to-fetch-record/' + recordId, function (data) {
            $('#recordId').val(data.id);
            $('#mandal_name').val(data.mandal_name);
            $('#janpad_name').val(data.janpad_name);
            $('#maitri_name').val(data.maitri_name);
            $('#latitude').val(data.latitude);
            $('#longitude').val(data.longitude);
            // Populate other fields similarly...
            $('#editModal').modal('show');
        });
    });

    // Submit form via AJAX
    $('#editForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '/matri-to-update-record',
            data: $(this).serialize(),
            success: function (response) {
                $('#editModal').modal('hide');
                alert('Record updated successfully');
                location.reload();
            },
            error: function (error) {
                alert('An error occurred while updating.');
            }
        });
    });
});
</script>


<script>
    $('#id').change(function() {
        $('#dis_id').val();
        var val = $("#id option:selected").text();
        console.log('val',val)
        if(val){
            $('#dis_id').val(val);
        }
    });
</script>
@endsection

