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
        <h3 class="text-center m-4 fw-bold">  <span data-hi="जिला बनाएं" data-en="District Create"></span> </h3>
        <div class="row mb-4">
            <div class="col-md-12">
                <a href="{{ route('create-division-user') }}" data-hi="जिला आईडी बनाएं" data-en="Create District ID"  class="btn btn-primary"></a>
            </div>
        </div>

        <table  id="myTable" class="table table-striped  table-responsive table-bordered">
            <thead>
                <tr>
                    <th><span data-hi="S.No" data-en="S.No "></span></th>
                    <th><span data-hi="नाम" data-en="Name "></span></th>
                    <th><span data-hi="ईमेल" data-en="Email"></span></th>
                    <th> <span data-hi="जिले" data-en=" Districts"></span></th>
                </tr>
            </thead>
            <tbody>

                @if (count($districtUserData) < 0)
                    <tr>
                        <td colspan="6" class="text-center">No data found</td>
                    </tr>
                @endif

               @php $i = 1 @endphp
                @foreach ($districtUserData as $districtUser)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $districtUser['name'] }}</td>
                        <td>{{ $districtUser['email'] }}</td>
                        <td> 
                            <span data-hi="{{ $districtUser['district_hindi'] }}" data-en="{{ $districtUser['district_eng'] }}"></span>
                        </td>
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

