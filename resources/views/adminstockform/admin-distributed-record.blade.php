@extends('master')
@section('content')

<style>
.search__button {
    display: flex;
    align-items: flex-end;
    gap: 10px;
}

</style>
<div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center m-4 fw-bold"> <span data-hi="वितरित रिकॉर्ड" data-en="Distributed Record"></span> </h3>
    <?php /*
    <form method="GET" action="{{ route('admin-distributed-record') }}" class="mb-4">
        <div class="row">
            <!-- <div class="col-md-3">
                <label>Bull ID:</label>
                <input type="text" name="bull_id" class="form-control" value="{{ request('bull_id') }}">
            </div> -->
            @if(Auth::user()->role == 'Superadmin')
            <div class="col-md-3">
                <label>Role:</label>
                <select name="role" class="form-control">
                    <option value="">Select Role</option>
                    <option value="DFS" {{ request('role') == 'DFS' ? 'selected' : '' }}>DFS</option>
                    <option value="zone" {{ request('role') == 'zone' ? 'selected' : '' }}>Zone</option>
                    <option value="district" {{ request('role') == 'district' ? 'selected' : '' }}>District</option>
                    <option value="DEO" {{ request('role') == 'DEO' ? 'selected' : '' }}>DEO</option>
                </select>
            </div>
            @endif
            @if(Auth::user()->role == 'DFS')
            <div class="col-md-3">
                <label>Zone:</label>
                <select name="zone" class="form-control">
                    <option value="">Select Zone</option>
                    @foreach($zones as $zone)
                    <option value="{{ $zone->id }}" data-en="{{ $zone->name_en }}" data-hi="{{ $zone->name_hi }}"
                        {{ request('zone') == $zone->id ? 'selected' : '' }}>
                        {{ $zone->name_en }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-md-3">
                <label>Breed:</label>
                <select name="breed" class="form-control">
                    <option value="">Select Breed</option>
                    <option value="swadeshi" {{ request('breed') == 'swadeshi' ? 'selected' : '' }}>
                        Swadeshi</option>
                    <option value="hybrids-crossbred" {{ request('breed') == 'hybrids-crossbred' ? 'selected' : '' }}>
                        Hybrids -
                        Crossbred</option>
                    <option value="videshi" {{ request('breed') == 'videshi' ? 'selected' : '' }}>Videshi</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Species:</label>
                <select name="semen" class="form-control">
                    <option value="">Select Species</option>
                    <option value="cow" {{ request('semen') == 'cow' ? 'selected' : '' }}>
                        Cow</option>
                    <option value="buffalo" {{ request('semen') == 'buffalo' ? 'selected' : '' }}>Buffalo</option>
                    <option value="goat" {{ request('semen') == 'goat' ? 'selected' : '' }}>Goat</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Semen Type:</label>
                <select name="semen_type" class="form-control">
                    <option value="">Select Semen</option>
                    <option value="conventional" {{ request('semen_type') == 'conventional' ? 'selected' : '' }}>
                        Conventional</option>
                    <option value="sexed" {{ request('semen_type') == 'sexed' ? 'selected' : '' }}>Sexed</option>
                </select>
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('admin-distributed-record') }}" class="btn btn-secondary">Reset</a>
    </form>

    */ ?>

    <table id="my-new-table" class="table table-striped table-responsive table-bordered">
        <thead>
            <tr>
                <th><span data-hi="S.No" data-en="S.No"></span></th>
                <th><span data-hi="Zone" data-en="Zone"></span></th>
                <th><span data-hi="Item" data-en="Item"></span></th>
                <th><span data-hi="Quantity" data-en="Quantity"></span></th>
                <th><span data-hi="Supply Date" data-en="Supply Date"></span> </th>
                <th><span data-hi="निर्माण तिथि" data-en="Creation Date"></span> </th>
            </tr>
        </thead>
        <tbody>
            @if(count($adminDistributedRecord) > 0)
            @foreach ($adminDistributedRecord as $key => $stockAdmin)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $stockAdmin->zone->name_en }}</td>
                <td>
                    <?php if ($stockAdmin->item_type == 'species_semen') { ?>
                        <b>{{ $stockAdmin->item }} :</b> {{ $stockAdmin->species_semen }} <br>
                        <b>Bread Type :</b> {{ $stockAdmin->breed_type }} <br>
                        <b>Bread :</b> {{ $stockAdmin->breed }} <br>
                        <b>Bull ID:</b> {{ $stockAdmin->bull_id }}
                    <?php } else if ($stockAdmin->item_type == 'container') { ?>
                        {{ $stockAdmin->item }} - ({{ $stockAdmin->container_capacity }})
                    <?php } else { ?>
                        {{ $stockAdmin->item }}
                    <?php } ?>
                </td>
                <td>{{ $stockAdmin->quantity }}</td>
                <td>{{ $stockAdmin->supply_date }}</td>
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