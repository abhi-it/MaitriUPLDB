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
    <h3 class="text-center m-4 fw-bold"> <span data-hi="वितरित रिकॉर्ड" data-en="Distributed Record"></span> </h3>

    <table id="my-new-table" class="table table-striped table-responsive table-bordered">
        <thead>
            <tr>
                <th><span data-hi="S.No" data-en="S.No"></span></th>
                <th><span data-hi="Maitri" data-en="Maitri"></span></th>
                <th><span data-hi="Item" data-en="Item"></span></th>
                <th><span data-hi="Quantity" data-en="Quantity"></span></th>
                <th><span data-hi="Supply Date" data-en="Supply Date"></span> </th>
                <th><span data-hi="निर्माण तिथि" data-en="Creation Date"></span> </th>
            </tr>
        </thead>
        <tbody>
            @if(count($aiCenterDistributedRecord) > 0)
            @foreach ($aiCenterDistributedRecord as $key => $stock)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $stock->maitri->maitri_name }} ({{ $stock->maitri->maitri_mobile_no }})</td>
                <td>
                    <?php if ($stock->item_type == 'species_semen') { ?>
                        <b>{{ $stock->item }} :</b> {{ $stock->species_semen }} <br>
                        <b>Bread Type :</b> {{ $stock->breed_type }} <br>
                        <b>Bread :</b> {{ $stock->breed }} <br>
                        <b>Bull ID:</b> {{ $stock->bull_id }}
                    <?php } else if ($stock->item_type == 'container') { ?>
                        {{ $stock->item }} - ({{ $stock->container_capacity }})
                    <?php } else { ?>
                        {{ $stock->item }}
                    <?php } ?>
                </td>
                <td>{{ $stock->quantity }}</td>
                <td>{{ $stock->supply_date }}</td>
                <td>{{ $stock->created_at }}</td>
            </tr>
            @endforeach
            @endif
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


    function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    var selectedMaitri = getUrlParameter('select_maitri');
    var selectedAICenter = getUrlParameter('aicenter');

    console.log("URL Params - AI Center:", selectedAICenter, "Maitri:", selectedMaitri);

    if (selectedAICenter) {
        $('#select_aicenter').val(selectedAICenter).trigger('change');
    }

    $('#select_aicenter').change(function() {
        var aiCenterID = $(this).val();
        console.log("AI Center Changed: ", aiCenterID);

        if (!aiCenterID) return;
        $.ajax({
            type: "GET",
            url: "{{ route('search-maitri-data') }}",
            dataType: 'json',
            data: {
                id: aiCenterID,
                district: $('#district_id').val(),
                division: $('#division_id').val(),
            },
            success: function(result) {
                $('#select_maitri').empty();
                if (result.success && result.type === 'maitri' && result.success !== '') {
                    const $selectMaitri = $('#select_maitri');
                    $selectMaitri.empty().append('<option value="">Select Maitri</option>');

                    $.each(result.success, function(index, maitri) {
                        $selectMaitri.append(
                            $('<option></option>')
                            .val(maitri.id)
                            .text(
                                `Name: ${maitri.maitri_name} (Num: ${maitri.maitri_mobile_no}, Bharat Pashudhan Id: ${maitri.any_bharat_id})`
                            )
                        );
                    });

                    if (selectedMaitri) {
                        $selectMaitri.val(selectedMaitri).trigger('change');
                    }
                } else {
                    $('#select_maitri').append(
                        $('<option></option>').text('No Maitri available').prop(
                            'disabled', true)
                    );
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data: " + error);
            }
        });
    })

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