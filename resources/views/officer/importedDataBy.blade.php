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
                <th><span data-hi="मैत्री लक्ष्य फ़ाइल" data-en="Maitri Target File"></span></th>
                <th><span data-hi="स्कैन की गई फ़ाइल" data-en="Scanned File"></span></th>
                <th><span data-hi="कब जोड़ा गया" data-en="Created At"></span></th>
            </tr>
        </thead>
        <tbody id="recordSet">
          
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    
    $('#select_cvo').select2();

    var table = $('#myTable121').DataTable({
        "pageLength": 25,
        "searching": false,
        "language": {
            "emptyTable": "Please Select CVO"
        }
    });

    $(document).on('change', '.select_cvo', function() {
        var importedId = $(this).val();
        table.clear().destroy();
        // $('#recordSet').empty();
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
                            '<td>' + (record.maitri_target_file 
                                    ? '<a href="/scanned_files/' + record.maitri_target_file + '" download="' + record.maitri_target_file + '">' +
                                        '<button type="button" class="btn-sm btn btn-primary"><i class="fa fa-download"></i> Download</button>' +
                                    '</a>' 
                                    : 'N/A') + '</td>' +
                            '<td>' + (record.scanned_file 
                                    ? '<a href="/scanned_files/' + record.scanned_file + '" download="' + record.scanned_file + '">' +
                                        '<button type="button" class="btn-sm btn btn-primary"><i class="fa fa-download"></i> Download</button>' +
                                    '</a>' 
                                    : 'N/A') + '</td>' +
                            '<td>' + (record.created_at || 'N/A') + '</td>' +
                            '</tr>';
                        i++;
                        $('#recordSet').append(row);
                    });
                    table = $('#myTable121').DataTable({
                        "pageLength": 25,
                        "language": {
                            "emptyTable": "Please Select CVO"
                        }
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