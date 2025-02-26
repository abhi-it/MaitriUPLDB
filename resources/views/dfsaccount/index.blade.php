@extends('master')
@section('content')

<div class="container">
    <h3 class="text-center m-4 fw-bold">
        <span data-hi="डीएफएस उपयोगकर्ता की सूचियाँ" data-en="Lists of DFS User"></span>
    </h3>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <a href="/create-dfs"><button class="btn btn-primary mb-3 mt-3">Create DFS <i class="fa fa-plus"></i></button></a>
    <div class="d-flex mt-4">
        {{ $dfsUser->links() }}
    </div>
    <table id="my-new-table" class="table table-striped table-responsive table-bordered">
        <thead>
            <tr>
                <th>S.No</th>
                <th><span data-hi="नाम" data-en="Name"></span></th>
                <th><span data-hi="ईमेल" data-en="Email"></span></th>
                <th><span data-hi="मोबाइल नंबर" data-en="Mobile"></span></th>
                <th><span data-hi="लिंग" data-en="Gender"></span></th>
                <th><span data-hi="मंडल" data-en="Division"></span></th>
                <th><span data-hi="ज़िला" data-en="District"></span></th>
                <th><span data-hi="कार्रवाई" data-en="Action"></span></th>
            </tr>
        </thead>
        <tbody>
            @foreach($dfsUser as $key => $user)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->MobileNumber }}</td>
                <td>{{ ucfirst($user->gender) }}</td>
                <td>{{ $user->division ? $user->division->name_hindi : 'N/A' }}</td>
                <td>{{ $user->district ? $user->district->name_hindi : 'N/A' }}</td>
                <td>
                    <!-- Edit Button -->
                    <a href="{{ route('dfs-edit', $user->id) }}" class="btn btn-warning btn-sm">
                        <i class="fa fa-edit"></i>
                    </a>

                    <!-- Delete Button -->
                    <form action="{{ route('dfs-destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex   mt-4">
        {{ $dfsUser->links() }}
    </div>

</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection