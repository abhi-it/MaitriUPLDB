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

    <form method="GET" action="{{ route('deo-show-stock-record') }}" class="mb-4">
        <div class="row">
            <input type="hidden" name="district_id" id="district_id" value="{{ $getData->district_id }}">
            <input type="hidden" name="division_id" id="division_id" value="{{ $getData->division_id }}">
            <div class="col-md-6">
                <label>AI Center:</label>
                <select name="aicenter" id="select_aicenter" class="form-control">
                    <option value="" data-hi="AI केंद्र का चयन करें" data-en="Select AI Center"></option>
                    @foreach($aiCenters as $aiCenterName)
                    <option value="{{ $aiCenterName['id'] }}">
                        {{ $aiCenterName['aicenter'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="inputEmail4"> <span data-hi="मैत्री चुनें" data-en="Select Maitri"></span> </label>
                <select name="select_maitri" id="select_maitri" class="form-control">
                    <option value="" data-hi="मैत्री चुनें" data-en="Select Maitri"></option>
                </select>
            </div>

            <div class="col-md-4">
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
            <div class="col-md-4">
                <label>Species:</label>
                <select name="semen" class="form-control">
                    <option value="">Select Species</option>
                    <option value="cow" {{ request('semen') == 'cow' ? 'selected' : '' }}>
                        Cow</option>
                    <option value="buffalo" {{ request('semen') == 'buffalo' ? 'selected' : '' }}>Buffalo</option>
                    <option value="goat" {{ request('semen') == 'goat' ? 'selected' : '' }}>Goat</option>
                </select>
            </div>
            <div class="col-md-4">
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
        <a href="{{ route('deo-show-stock-record') }}" class="btn btn-secondary">Reset</a>
    </form>

    <table id="my-new-table" class="table table-striped  table-responsive table-bordered">
        <thead>
            <tr>
                <th><span data-hi="S.No" data-en="S.No"></span></th>
                <th><span data-hi="मैत्री नाम" data-en="Maitri Name"></span></th>
                <th><span data-hi="संख्या" data-en="Number"></span></th>
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
            @foreach ($deoStock as $key => $stockdeo)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $stockdeo->maitri_name }}</td>
                <td>{{ $stockdeo->maitri_mobile_no }}</td>
                <td>{{ $stockdeo->demand_section }}</td>
                <td>{{ $stockdeo->semen }}</td>
                <td>{{ $stockdeo->semen_straws }}</td>
                <td>{{ $stockdeo->semen_type }}</td>
                <td>{{ $stockdeo->banner }}</td>
                <td>{{ $stockdeo->dangler }}</td>
                <td>{{ $stockdeo->standee }}</td>
                <td>{{ $stockdeo->pamphlet }}</td>
                <td>{{ $stockdeo->ai_kit }}</td>
                <td>{{ $stockdeo->container }}</td>
                <td>{{ $stockdeo->container_capacity }}</td>
                <td>{{ $stockdeo->scheme }}</td>
                <td>{{ $stockdeo->bull_ids }}</td>
                <td>{{ $stockdeo->created_at }}</td>
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