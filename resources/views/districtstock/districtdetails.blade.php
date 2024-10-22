@extends('zonesMenu')
@section('content')

<style>
    .search__button{
        display: flex;
        align-items: flex-end;
        gap: 10px;
    }
    @media screen and (min-width: 1024px){
        .table-responsive {
            display: block !important;
        }
    }
</style>
    <div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
        <h3 class="text-center m-4 fw-bold">  <span data-hi="वितरण स्टॉक विवरण" data-en="Distribution Stock Details"></span> </h3>

        <table  id="my-new-table" class="table table-striped  table-responsive table-bordered">
            <thead>
                <tr>
                    <th><span data-hi="S.No" data-en="S.No"></span></th>
                    <th><span data-hi="तरल नाइट्रोजन" data-en="Liquid Nitrogen"></span></th>
                    <th><span data-hi="वीर्य" data-en="Semen"></span></th>
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

                @php $i = 1; @endphp
                @foreach ($divisionStock as $key => $stockDivision)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $stockDivision['demand_section'] }}</td>
                        <td>{{ $stockDivision['semen'] }}</td>
                        <td>{{ $stockDivision['semen_type'] }}</td>
                        <td>{{ $stockDivision['banner'] }}</td>
                        <td>{{ $stockDivision['dangler'] }}</td>
                        <td>{{ $stockDivision['standee'] }}</td>
                        <td>{{ $stockDivision['pamphlet'] }}</td>
                        <td>{{ $stockDivision['ai_kit'] }}</td>
                        <td>{{ $stockDivision['container'] }}</td>
                        <td>{{ $stockDivision['container_capacity'] }}</td>
                        <td>{{ $stockDivision['scheme'] }}</td>
                        <td>{{ $stockDivision['bull_ids'] }}</td>
                        <td>{{ $stockDivision['created_at'] }}</td>
                    </tr>
                    @php $i++ @endphp
                @endforeach


            </tbody>
        </table>

        <div class="row">

        </div>
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
        $(document).ready(function () {
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

