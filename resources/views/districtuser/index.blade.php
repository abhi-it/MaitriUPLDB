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
        <h3 class="text-center m-4 fw-bold">  <span data-hi="जिला वस्तुसूची" data-en="District Inventory"></span> </h3>
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

            </tbody>
        </table>

        <div class="row">

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>

</script>

@endsection

