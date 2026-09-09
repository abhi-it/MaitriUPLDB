@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
    <h3 class="text-center fw-bold m-4">रिफ्रेशर ट्रेनिंग सूची</h3>

    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
    @if(session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
    @endif

    <div class="container text-center">
        <form action="{{ route('maitri-refresher-list') }}" method="get" class="form-comman">
            <div class="row">
                <div class="col-md-4 mt-4 mb-4">
                    <select name="id" id="id" class="form-control">
                        <option value="">-select one-</option>
                        @foreach($dist as $val)
                        <option value="{{ $val['name_hindi'] }}" {{ $val['name_hindi'] == request('id') ? 'selected' : '' }}>
                            {{ $val['name_hindi'] }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1 mt-4 mb-4">
                    <input type="submit" class="btn btn-primary" value="Submit">
                </div>
                <div class="col-md-1 mt-4 mb-4">
                    <a href="{{ route('maitri-refresher-list') }}" class="btn btn-danger text-white">रीसेट करें</a>
                </div>
                <div class="col-md-2 mt-4 mb-4">
                    <a href="{{ route('maitri-listing') }}" class="btn btn-secondary">मैत्री सूची</a>
                </div>
            </div>
        </form>
    </div>

    <table class="table table-striped table-responsive table-bordered">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Mandal</th>
                <th>Janpad</th>
                <th>Name</th>
                <th>Mobile No</th>
                <th>Pass Out Date</th>
                <th>Block</th>
                <th>Tehsil</th>
                <th>Center</th>
                <th>Added On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if(count($data) > 0)
            @php $i = ($data->currentPage() - 1) * $data->perPage() + 1; @endphp
            @foreach($data as $val)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $val->mandal_name }}</td>
                <td>{{ $val->janpad_name }}</td>
                <td>{{ $val->maitri_name }}</td>
                <td>{{ $val->maitri_mobile_no }}</td>
                <td>{{ $val->pass_date ?: 'N/A' }}</td>
                <td>{{ $val->block }}</td>
                <td>{{ $val->tehsil }}</td>
                <td>{{ $val->center_name }}</td>
                <td>{{ $val->refresher_training_at ? $val->refresher_training_at->format('d-m-Y H:i') : 'N/A' }}</td>
                <td>
                    <a href="{{ route('edit-maitri-data', $val->id) }}" class="btn btn-success btn-sm">Update</a>
                </td>
            </tr>
            @php $i++ @endphp
            @endforeach
            @else
            <tr>
                <td colspan="11" class="text-center text-danger">No refresher training records found.</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="row">
        {{ $items->links() }}
    </div>
</div>
@endsection
