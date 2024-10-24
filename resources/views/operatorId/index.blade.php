@extends('master')
@section('content')

<style>
    .search__button{
    display: flex;
    align-items: flex-end;
    gap: 10px;
    }
</style>
    <div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
        <h3 class="text-center m-4 fw-bold">  <span data-hi="ऑपरेटर आईडी प्रबंधन" data-en="Operator ID Management"></span> </h3>
        <div class="row mb-4">
            <div class="col-md-12">
                <a href="{{ route('create-zone') }}" class="btn btn-primary" data-hi="क्षेत्र आईडी बनाएं" data-en="Create Zone ID"></a>
                <a href="{{ route('district-deo-user-step1') }}" data-hi="ज़िला आईडी बनाएं" data-en="Create District ID"  class="btn btn-primary"></a>
                <a href="{{ route('deo-user-step1') }}" data-hi="डीईओ आईडी बनाएं" data-en="Create DEO ID" class="btn btn-primary"></a>
            </div>
        </div>

        <table  id="myTable" class="table table-striped  table-responsive table-bordered">
            <thead>
                <tr>
                    <th><span data-hi="S.No" data-en="S.No"></span></th>
                    <th><span data-hi="नाम" data-en="Name"></span></th>
                    <th><span data-hi="ईमेल" data-en="Email"></span></th>
                    <th><span data-hi="क्षेत्र/जिला/डीईओ" data-en="Zone/District/Deo"></span></th>
                   

                    {{-- <th> <span data-hi="कार्रवाई" data-en="Action"></span> </th> --}}
                </tr>
            </thead>
            <tbody>

                @if ($zoneUsers->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No data found</td>
                    </tr>
                @endif


                @php $i = 1 @endphp
                @foreach ($zoneUsers as $zoneUser)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $zoneUser->name }} ( {{ $zoneUser->user_type }} )</td>
                        <td>{{ $zoneUser->email }}</td>
                        <td> 
                            <span data-hi="{{ $zoneUser->getDeoUser->zone->name_hi ?? 'N/A' }}" data-en="{{ $zoneUser->getDeoUser->zone->name_en ?? 'N/A' }}"></span>
                        </td>
                    </tr>
                    @php $i++ @endphp
                @endforeach

            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>

</script>

@endsection

