@extends('master')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center m-4 fw-bold">
        <span data-hi="सीवीओ की सूची डेटा आयात" data-en="List of CVOs Imported the data"></span>
    </h3>

    <div class="row mb-4">
        <div class="col-sm-12">
            <select name="select_cvo" id="select_cvo" class="select_cvo form-control">
                <option value="">Select CVO</option>
                @foreach($dataImportedBy as $val)
                    <option value="{{ $val->id }}">Name: {{ $val->name }} | Email: {{ $val->email }} | Record Count: {{ $val->count }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <table id="myTable121" class="table table-striped  table-responsive table-bordered">
        <thead>
            <tr>
                <th><span data-hi="S.No" data-en="S.No"></span> </th>
                <th><span data-hi="मंडल का नाम" data-en="Mandal Name"></span> </th>
                <th> <span data-hi="जनपद का नाम" data-en="Janpad Name"></span>  </th>
                <th><span data-hi="अधिकारी का नाम" data-en="Officer Name"></span> </th>
                <th><span data-hi="लॉगिन आईडी" data-en="Login ID"></span></th>
                <th><span data-hi="ईमेल" data-en="Email"></span></th>
                <th><span data-hi="मोबाइल नंबर" data-en="Mobile Number"></span></th>
                <th><span data-hi="आधार नंबर" data-en="Aadhar Number"></span></th>
                <th> <span data-hi="पद का नाम" data-en="Designation"></span></th>
                <th><span data-hi="पशु देखभाल केंद्र" data-en="Animal Care Center"></span> </th>
            </tr>
        </thead>
        <tbody id="recordSet">
            <tr>
                <td colspan="10" class="text-center">Please Select CVO</td>
            </tr>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    
    $('#select_cvo').select2();

    $(document).on('change', '.select_cvo', function() {
        var importedId = $(this).val();
        $('#recordSet').empty();
        $.ajax({
            url: '/get-record-details',
            type: 'GET',
            data: {
                id: importedId
            },
            success: function(response) {
                if (response.success) {

                    var getRecord = response.data;
                    var i = 1;
                    $(getRecord).each(function(index, record) {
                        var row = '<tr>' +
                            '<td>' + i + '</td>' +
                            '<td>' + (record.mandal_name || 'N/A') + '</td>' +
                            '<td>' + (record.janpad_name || 'N/A') + '</td>' +
                            '<td>' + (record.officer_name || 'N/A') + '</td>' +
                            '<td>' + (record.login_id || 'N/A') + '</td>' +
                            '<td>' + (record.email || 'N/A') + '</td>' +
                            '<td>' + (record.mobile_no || 'N/A') + '</td>' +
                            '<td>' + (record.adhar_no || 'N/A') + '</td>' +
                            '<td>' + (record.designation || 'N/A') + '</td>' +
                            '<td>' + (record.animal_care_center || 'N/A') + '</td>' +
                            '</tr>';
                        i++;
                        $('#recordSet').append(row);
                    });
                    
                   
                   
                } else {
                    alert('Record not found');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
                alert('An error occurred while fetching the record');
            }
        });
    });
});
</script>

@endsection