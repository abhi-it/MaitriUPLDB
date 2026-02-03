@extends('zonesMenu')
@section('content')

<style>
.search__button {
    display: flex;
    align-items: flex-end;
    gap: 10px;
}

</style>
<div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center m-4 fw-bold"> <span data-hi="वितरण स्टॉक विवरण" data-en="Distribution Stock Details"></span>
    </h3>

    <table id="my-new-table" class="table table-striped table-responsive table-bordered">
        <thead>
            <tr>
                <th><span data-hi="S.No" data-en="S.No"></span></th>
                <th><span data-hi="Item" data-en="Item"></span></th>
                <th><span data-hi="Quantity" data-en="Quantity"></span></th>
                <th><span data-hi="Supply Date" data-en="Supply Date"></span></th>
            </tr>
        </thead>
        <tbody>
            <?php //echo "<pre>"; print_r($zoneStocks->toArray()); exit; ?>
            @if(count($districtStocks) > 0)
            @foreach ($districtStocks as  $stock)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <?php if ($stock['item_type'] == 'species_semen') { ?>
                        <b>{{ $stock['item'] }} :</b> {{ $stock['species_semen'] }} <br>
                        <b>Breed Type :</b> {{ $stock['breed_type'] }} <br>
                        <b>Breed :</b> {{ $stock['breed'] }} <br>
                        <b>Semen Type :</b> {{ $stock['semen_type'] }} <br>
                        <b>Bull ID:</b> {{ $stock['bull_id'] }}
                    <?php } else if ($stock['item_type'] == 'container') { ?>
                        {{ $stock['item'] }} - ({{ $stock['container_capacity'] }})
                    <?php } else { ?>
                        {{ $stock['item'] }}
                    <?php } ?>
                </td>

                <td>{{ $stock['quantity'] }}</td>
                <td>{{ $stock['supply_date'] }}</td>

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
        buttons: [
            'csv', 'excel'
        ]
    });

});
</script>

@endsection