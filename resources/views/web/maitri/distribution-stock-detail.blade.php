@extends('submaster')
@section('content')

<style>
    .table-responsive {
        display: inline-table;
        width: 100%;
    
    }
</style>
<div class="container main-div">
   <h3 class="text-center fw-bold m-4"> <span data-hi="वितरण स्टॉक विवरण" data-en="Distribution Stock Details"></span></h3>
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
            <?php //echo "<pre>"; print_r($maitriStocks->toArray()); exit; ?>
            @if(count($maitriStocks) > 0)
            @foreach ($maitriStocks as  $stock)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <?php if ($stock['item_type'] == 'species_semen') { ?>
                        <b>{{ $stock['item'] }} :</b> {{ $stock['species_semen'] }} <br>
                        <b>Breed Type :</b> {{ $stock['breed_type'] }} <br>
                        <b>Breed :</b> {{ $stock['breed'] }} <br>
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
@endsection 
