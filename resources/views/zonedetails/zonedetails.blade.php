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
    <h3 class="text-center m-4 fw-bold"> <span data-hi="जोन स्टॉक विवरण" data-en="Zone Stock Details"></span> </h3>

    <table id="my-new-table" class="table table-striped table-responsive table-bordered">
        <thead>
            <tr>
                <th><span data-hi="S.No" data-en="S.No"></span></th>
                <th><span data-hi="Item" data-en="Item"></span></th>
                <th><span data-hi="Quantity" data-en="Quantity"></span></th>
            </tr>
        </thead>
        <tbody>
            <?php //echo "<pre>"; print_r($finalStocks->toArray()); exit; ?>
            @if(count($finalStocks) > 0)
            @foreach ($finalStocks as  $stockAdmin)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <?php if ($stockAdmin['item_type'] == 'species_semen') { ?>
                        <b>{{ $stockAdmin['item_name'] }} :</b> {{ $stockAdmin['species_semen'] }} <br>
                        <b>Bread Type :</b> {{ $stockAdmin['breed_type'] }} <br>
                        <b>Bread :</b> {{ $stockAdmin['breed'] }} <br>
                        <b>Bull ID:</b> {{ $stockAdmin['bull_id'] }}
                        <input type="hidden" id="{{$stockAdmin['item_type']}}_{{$stockAdmin['species_semen']}}_{{$stockAdmin['breed_type']}}_{{$stockAdmin['breed']}}_{{$stockAdmin['bull_id']}}" value="{{$stockAdmin['remaining_qty']}}">
                    <?php } else if ($stockAdmin['item_type'] == 'container') { ?>
                        {{ $stockAdmin['item_name'] }} - ({{ $stockAdmin['container_capacity'] }})
                        <input type="hidden" id="stock_{{$stockAdmin['item_type']}}_{{$stockAdmin['container_capacity']}}" value="{{$stockAdmin['remaining_qty']}}">
                    <?php } else { ?>
                        {{ $stockAdmin['item_name'] }}
                        <input type="hidden" id="stock_{{$stockAdmin['item_type']}}" value="{{$stockAdmin['remaining_qty']}}">
                    <?php } ?>
                </td>

                <td>{{ $stockAdmin['remaining_qty'] }}</td>

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