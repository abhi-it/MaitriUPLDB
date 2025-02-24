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
    <h3 class="text-center m-4 fw-bold"> <span data-hi="वितरित रिकॉर्ड" data-en="Distributed Record"></span> </h3>

    <table id="my-new-table" class="display table table-striped table-responsive table-bordered" width="100%">
        <thead>
            <tr>
                <th><span data-hi="S.No" data-en="S.No"></span></th>
                <th><span data-hi="उपयोगकर्ता नाम" data-en="UserName"></span></th>
                <th><span data-hi="क्षेत्र" data-en="Zone"></span></th>
                <th><span data-hi="तरल नाइट्रोजन" data-en="Liquid Nitrogen"></span></th>
                <th><span data-hi="LN2 आपूर्ति तिथि" data-en="LN2 Supply Date"></span></th>
                <th><span data-hi="वीर्य" data-en="Semen"></span></th>
                <th><span data-hi="वीर्य स्ट्रॉस" data-en="Semen Straws"></span></th>
                <th><span data-hi="वीर्य का प्रकार" data-en="Semen Type"></span></th>
                <th><span data-hi="बैनर" data-en="Banner"></span></th>
                <th> <span data-hi="डैंगलर" data-en="Dangler"></span></th>
                <th><span data-hi="स्टैन्डी" data-en="Standee"></span></th>
                <th><span data-hi="पुस्तिका" data-en="Pamphlet"></span></th>
                <th> <span data-hi="एआई किट" data-en="AI Kit"></span> </th>
                <th> <span data-hi="पात्र" data-en="Container"></span> </th>
                <th> <span data-hi="कंटेनर क्षमता" data-en="Container Capacity"></span> </th>
                <th> <span data-hi="कायोजनार्रवाई" data-en="Scheme"></span> </th>
                <th> <span data-hi="बैल पहचान विवरण" data-en="Bull ID Details"></span> </th>
                <th> <span data-hi="निर्माण तिथि" data-en="Creation Date"></span> </th>
            </tr>
        </thead>
        <tbody>
            @if(count($zoneStock) > 0)
            @foreach ($zoneStock as $stockZone)
            @php $i = 1; @endphp
            @foreach($stockZone as $zoneUser)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $zoneUser->FirstName }}</td>
                <td><span data-hi="{{ $zoneUser->name_hi }}" data-en="{{ $zoneUser->name_en }}"></span></td>
                <td>{{ $zoneUser->demand_section }}</td>
                <td>{{ $zoneUser->supply_date ? $zoneUser->supply_date : 'N/A' }}</td>
                <td>{{ $zoneUser->semen }}</td>
                <td>{{ $zoneUser->semen_straws ?? 'N\A' }}</td>
                <td>{{ $zoneUser->semen_type }}</td>
                <td>{{ $zoneUser->banner }}</td>
                <td>{{ $zoneUser->dangler }}</td>
                <td>{{ $zoneUser->standee }}</td>
                <td>{{ $zoneUser->pamphlet }}</td>
                <td>{{ $zoneUser->ai_kit }}</td>
                <td>{{ $zoneUser->container }}</td>
                <td>{{ $zoneUser->container_capacity }}</td>
                <td>{{ $zoneUser->scheme }}</td>
                <td>{{ $zoneUser->bull_ids }}</td>
                <td>{{ $zoneUser->created_at }}</td>
            </tr>
            @endforeach
            @php $i++ @endphp
            @endforeach
            @else
            <tr>
                <td colspan="18" class="text-center" style="color:red;">No record found..</td>
            </tr>
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
    $('#my-new-table').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],
        pageLength: 10,
        dom: 'lBfrtip',
        buttons: [
            'csv', 'excel'
        ]
    });

});
</script>


@endsection