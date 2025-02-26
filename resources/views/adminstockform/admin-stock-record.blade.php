@extends('master')
@section('content')

<style>
.search__button {
    display: flex;
    align-items: flex-end;
    gap: 10px;
}

@media screen and (min-width: 1024px) {
    .table-responsive {
        display: block !important;
    }
}
</style>
<div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center m-4 fw-bold"> <span data-hi="एडमिन इन्वेंटरी रिकॉर्ड"
            data-en="Admin Inventory Record"></span> </h3>

    <table id="my-new-table" class="table table-striped table-responsive table-bordered">
        <thead>
            <tr>
                <th><span data-hi="S.No" data-en="S.No"></span></th>
                <th><span data-hi="तरल नाइट्रोजन" data-en="Liquid Nitrogen"></span></th>
                <th><span data-hi="नस्ल" data-en="Breed"></span></th>
                <th><span data-hi="प्रजाति वीर्य" data-en="Species Semen"></span></th>
                <th><span data-hi="वीर्य स्ट्रॉस" data-en="Semen Straws"></span></th>
                <th><span data-hi="वीर्य का प्रकार" data-en="Semen Type"></span></th>
                <th><span data-hi="बैनर" data-en="Banner"></span></th>
                <th> <span data-hi="डैंगलर" data-en="Dangler"></span></th>
                <th><span data-hi="स्टैन्डी" data-en="Standee"></span></th>
                <th><span data-hi="पुस्तिका" data-en="Pamphlet"></span></th>
                <th><span data-hi="एआई किट" data-en="AI Kit"></span> </th>
                <th><span data-hi="पात्र" data-en="Container"></span> </th>
                <th><span data-hi="कंटेनर क्षमता" data-en="Container Capacity"></span> </th>
                <th><span data-hi="कायोजनार्रवाई" data-en="Scheme"></span> </th>
                <th><span data-hi="बैल पहचान विवरण" data-en="Bull ID Details"></span> </th>
                <th><span data-hi="निर्माण तिथि" data-en="Creation Date"></span> </th>
            </tr>
        </thead>
        <tbody>
            @if(count($adminInventory) > 0)
            @foreach ($adminInventory as $key => $stockAdmin)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $stockAdmin->demand_section }}</td>
                <td>{{ isset($stockAdmin->breed) ? ucwords($stockAdmin->breed) : 'N/A' }}</td>
                <td>{{ ucwords($stockAdmin->semen) }}</td>
                <td>{{ isset($stockAdmin->semen_straws) ? $stockAdmin->semen_straws : 'N/A' }}</td>
                <td>{{ ucwords($stockAdmin->semen_type) }}</td>
                <td>{{ $stockAdmin->banner }}</td>
                <td>{{ $stockAdmin->dangler }}</td>
                <td>{{ $stockAdmin->standee }}</td>
                <td>{{ $stockAdmin->pamphlet }}</td>
                <td>{{ $stockAdmin->ai_kit }}</td>
                <td>{{ $stockAdmin->container }}</td>
                <td>{{ $stockAdmin->container_capacity }}</td>
                <td>{{ $stockAdmin->scheme }}</td>
                <td>{{ $stockAdmin->bull_ids }}</td>
                <td>{{ $stockAdmin->created_at }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.print.min.js"></script>
<!-- End DataTable -->

<script>
$(document).ready(function() {
    console.log("Table column count: ", $('#my-new-table thead tr th').length);
    console.log("First row column count: ", $('#my-new-table tbody tr:first td').length);

    $(window).on('load', function() {
        setTimeout(function() {
            $('#my-new-table').DataTable();
        }, 500);
    });
    $('#my-new-table').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],
        language: {
            emptyTable: "No records found..."
        },
        pageLength: 10,
        dom: 'lBfrtip',
        buttons: ['csv', 'excel'],
        columns: [{
                title: "S.No"
            },
            {
                title: "Liquid Nitrogen"
            },
            {
                title: "Breed"
            },
            {
                title: "Semen"
            },
            {
                title: "Semen Straws"
            },
            {
                title: "Semen Type"
            },
            {
                title: "Banner"
            },
            {
                title: "Dangler"
            },
            {
                title: "Standee"
            },
            {
                title: "Pamphlet"
            },
            {
                title: "AI Kit"
            },
            {
                title: "Container"
            },
            {
                title: "Container Capacity"
            },
            {
                title: "Scheme"
            },
            {
                title: "Bull ID Details"
            },
            {
                title: "Creation Date"
            }
        ],
        columnDefs: [{
            targets: "_all",
            defaultContent: "N/A"
        }]
    });
});
</script>

@endsection