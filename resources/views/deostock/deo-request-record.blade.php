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
        <h3 class="text-center m-4 fw-bold">  <span data-hi="ज़िला स्टॉक रिकॉर्ड" data-en="Request Record"></span> </h3>

        <table  id="myTable" class="table table-striped  table-responsive table-bordered">
            <thead>
                <tr>
                    <th><span data-hi="S.No" data-en="S.No"></span></th>
                    <th><span data-hi="उपयोगकर्ता नाम" data-en="UserName"></span></th>
                    <th><span data-hi="विभाजन" data-en="Division"></span></th>
                    <th><span data-hi="तरल नाइट्रोजन" data-en="Liquid Nitrogen"></span></th>
                    <th><span data-hi="वीर्य" data-en="Semen"></span></th>
                    <th><span data-hi="वीर्य का प्रकार" data-en="Semen Type"></span></th>
                    <th><span data-hi="बैनर" data-en="Banner"></span></th>
                    <th> <span data-hi="कामचोर" data-en="Dangler"></span></th>
                    <th><span data-hi="स्टैन्डी" data-en="Standee"></span></th>
                    <th><span data-hi="पुस्तिका" data-en="Pamphlet"></span></th>
                    <th> <span data-hi="एआई किट" data-en="AI Kit"></span> </th>
                    <th> <span data-hi="पात्र" data-en="Container"></span> </th>
                    <th> <span data-hi="कंटेनर क्षमता" data-en="Container Capacity"></span> </th>
                    <th> <span data-hi="कायोजनार्रवाई" data-en="Scheme"></span> </th>
                    <th> <span data-hi="बैल पहचान विवरण" data-en="Bull ID Details"></span> </th>
                    <th> <span data-hi="स्थिति" data-en="Status"></span> </th>
                </tr>
            </thead>
            <tbody>

                @if(count($getRecordData) == 0)
                    <tr>
                        <td colspan="16" class="text-center">No Record Found</td>
                    </tr>
                @endif

                @php $i = 1; @endphp
                @foreach ($getRecordData as $key => $requestRecord)
                    <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $requestRecord->user_name }}</td>
                    <td><span data-hi="{{ $requestRecord->block_hindi }}" data-en="{{ $requestRecord->block_name }}"></span></td>
                    <td>{{ $requestRecord->demand_section }}</td>
                    <td>{{ $requestRecord->semen }}</td>
                    <td>{{ $requestRecord->semen_type }}</td>
                    <td>{{ $requestRecord->banner }}</td>
                    <td>{{ $requestRecord->dangler }}</td>
                    <td>{{ $requestRecord->standee }}</td>
                    <td>{{ $requestRecord->pamphlet }}</td>
                    <td>{{ $requestRecord->ai_kit }}</td>
                    <td>{{ $requestRecord->container }}</td>
                    <td>{{ $requestRecord->container_capacity }}</td>
                    <td>{{ $requestRecord->scheme }}</td>
                    <td>{{ $requestRecord->bull_ids }}</td>
                    <td><button class="btn btn-danger">{{ $requestRecord->status }}</button></td>
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

