@extends('master')
@section('content')

<div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center m-4 fw-bold"> <span data-hi="ऑपरेटर आईडी प्रबंधन" data-en="Operator ID Management"></span>
    </h3>
    <div class="row mb-4">
        <div class="col-md-12">
            <a href="{{ url()->previous() }}">Back</a>
        </div>
    </div>

    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif

    <table id="myTable" class="table table-striped  table-responsive table-bordered">
        <thead>
            <tr>
                <th><span data-hi="S.No" data-en="S.No"></span></th>
                <th><span data-hi="नाम" data-en="Name"></span></th>
                <th><span data-hi="ईमेल" data-en="Email"></span></th>
                <th><span data-hi="क्षेत्र/जिला/डीईओ" data-en="CVO"></span></th>
                <!-- <th><span data-hi="एडिट/डिलीट" data-en="Action"></span></th> -->
            </tr>
        </thead>
        <tbody>

            @if ($getCvos->isEmpty())
            <tr>
                <td colspan="6" class="text-center">No data found</td>
            </tr>
            @endif

            @php $i = 1 @endphp
            @foreach ($getCvos as $getCvo)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $getCvo->name }}</td>
                <td>{{ $getCvo->email }}</td>
                <td>
                    <span data-hi="{{ $getCvo->district->name_hindi ?? 'N\A' }}"
                        data-en="{{ $getCvo->district->name_eng ?? 'N\A' }}"></span>
                    
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