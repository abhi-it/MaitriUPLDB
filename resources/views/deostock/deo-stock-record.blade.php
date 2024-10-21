@extends('zonesMenu')
@section('content')

<style>
    .search__button{
    display: flex;
    align-items: flex-end;
    gap: 10px;
    }
</style>
    <div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
        <h3 class="text-center m-4 fw-bold">  <span data-hi="वितरित रिकॉर्ड" data-en="Distributed Record"></span> </h3>

        <table  id="myTable" class="table table-striped  table-responsive table-bordered">
            <thead>
                <tr>
                    <th><span data-hi="S.No" data-en="S.No"></span></th>
                    <th><span data-hi="मैत्री नाम" data-en="Maitri Name"></span></th>
                    <th><span data-hi="संख्या" data-en="Number"></span></th>
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

                @if(count($deoStock) == 0)
                    <tr>
                        <td colspan="15" class="text-center">No Record Found</td>
                    </tr>
                @endif


               
                @php $i = 1; @endphp
                @foreach ($deoStock as $key => $stockdeo)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $stockdeo->user_name }}</td>
                        <td>{{ $stockdeo->maitri_mobile_no }}</td>
                        <td>{{ $stockdeo->demand_section }}</td>
                        <td>{{ $stockdeo->semen }}</td>
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
<script>

</script>

@endsection

