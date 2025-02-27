@extends('zonesMenu')
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

    <form method="GET" action="{{ route('show-zone-stock-record') }}" class="mb-4">
        <div class="row">
            <!-- <div class="col-md-3">
                <label>Bull ID:</label>
                <input type="text" name="bull_id" class="form-control" value="{{ request('bull_id') }}">
            </div> -->
            <div class="col-md-3">
                <label>District:</label>
                <select name="district" class="form-control">
                    <option value="">Select District</option>
                    @foreach($districts as $district )
                    <option value="{{ $district->id }}" data-hi="{{ $district->name_hindi }}"
                        data-en="{{ $district->name_eng }}"
                        {{ request('district') == $district->id ? 'selected' : '' }}>
                    </option>
                    @endforeach

                </select>
            </div>

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
        <a href="{{ route('show-zone-stock-record') }}" class="btn btn-secondary">Reset</a>
    </form>
    <table id="my-new-table" class="table table-striped  table-responsive table-bordered">
        <thead>
            <tr>
                <th><span data-hi="S.No" data-en="S.No"></span></th>
                <th><span data-hi="उपयोगकर्ता नाम" data-en="UserName"></span></th>
                <th><span data-hi="ज़िला" data-en="District"></span></th>
                <th><span data-hi="तरल नाइट्रोजन" data-en="Liquid Nitrogen"></span></th>
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
            @php $i = 1; @endphp
            @foreach ($zoneStock as $key => $stockZone)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $stockZone->name }}</td>
                <td><span data-hi="{{ $stockZone->name_hindi }}" data-en="{{ $stockZone->name_eng }}"></span></td>
                <td>{{ $stockZone->demand_section }}</td>
                <td>{{ $stockZone->semen }}</td>
                <td>{{ $semen_straws->semen_straws ?? 'N\A' }}</td>
                <td>{{ $stockZone->semen_type }}</td>
                <td>{{ $stockZone->banner }}</td>
                <td>{{ $stockZone->dangler }}</td>
                <td>{{ $stockZone->standee }}</td>
                <td>{{ $stockZone->pamphlet }}</td>
                <td>{{ $stockZone->ai_kit }}</td>
                <td>{{ $stockZone->container }}</td>
                <td>{{ $stockZone->container_capacity }}</td>
                <td>{{ $stockZone->scheme }}</td>
                <td>{{ $stockZone->bull_ids }}</td>
                <td>{{ $stockZone->created_at }}</td>
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