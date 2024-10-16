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
        <h3 class="text-center m-4 fw-bold">  <span data-hi="क्षेत्र वस्तुसूची" data-en="Zone Inventory"></span> </h3>
        <div class="row mb-4">
            <div class="col-md-12">
                <a href="{{ route('create-division-user') }}" data-hi="जिला आईडी बनाएं" data-en="Create District ID"  class="btn btn-primary"></a>
            </div>
        </div>

        <table  id="myTable" class="table table-striped  table-responsive table-bordered">
            <thead>
                <tr>
                    <th><span data-hi="नाम" data-en="Name "></span></th>
                    <th><span data-hi="ईमेल" data-en="Email"></span></th>
                    <th><span data-hi="क्षेत्र" data-en="Zone"></span></th>
                    <th><span data-hi="मंडल" data-en="Mandal"></span></th>
                    <th> <span data-hi="जिले" data-en=" Districts"></span></th>
                    <th><span data-hi="ब्लॉक" data-en="Block"></span></th>
                    {{-- <th><span data-hi="केंद्र" data-en="AICenter"></span></th> --}}

                    {{-- <th> <span data-hi="कार्रवाई" data-en="Action"></span> </th> --}}
                </tr>
            </thead>
            <tbody>

                @if ($deoUsers->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No data found</td>
                    </tr>
                @endif

               
                @foreach ($deoUsers as $deoUser)
                    <tr>
                        <td>{{ $deoUser->name }}</td>
                        <td>{{ $deoUser->email }}</td>
                        <td> 
                            <span data-hi="{{ $deoUser->getDeoUser->zone->name_hi ?? 'N/A' }}" data-en="{{ $deoUser->getDeoUser->zone->name_en ?? 'N/A' }}"></span>
                        </td>
                        <td> 
                            <span data-hi="{{ $deoUser->getDeoUser->division->name_hindi ?? 'N/A' }}" data-en="{{ $deoUser->getDeoUser->division->name_eng ?? 'N/A' }}"></span>
                        </td>

                        <td>
                            @if(isset($districtName[$deoUser->id]))
                                @foreach($districtName[$deoUser->id] as $district)
                                    <span data-hi="{{ $district['name_hindi'] ?? 'N/A' }}" data-en="{{ $district['name_eng'] ?? 'N/A' }}"></span>
                                @endforeach
                            @else
                                <span>N/A</span>
                            @endif
                        </td>

                        
                        <td> 
                            <span data-hi="{{ $deoUser->getDeoUser->block->name_hindi ?? 'N/A' }}" data-en="{{ $deoUser->getDeoUser->block->name_eng ?? 'N/A' }}"></span>
                        </td>

                        {{-- <td> <span data-hi="{{ $deoUser->getDeoUser->aicenter->aicenter_name }}" data-en="{{ $deoUser->getDeoUser->aicenter->aicenter_name }}"></span></td> --}}
                    </tr>
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

