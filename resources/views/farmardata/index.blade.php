@extends('master')
@section('content')

<style>
.errorclass {
    font-size: 8px;
    color: red;
}
</style>
<div class="container main-div py-5" style="background-color:white;">
    <h3 class="text-center fw-bold m-4">
        <span data-hi="किसान पंजीकरण डेटा" data-en="Farmer Registration Data"></span>
    </h3>
    <form method="get" action="{{ Request::url() }}" class="form-comman">
            @csrf
            <div class="row">

                <div class="form-group col-md-5 col-xl-3">
                    <label for="inputEmail4" class="fw-bold"> <span data-hi="सेलेक्ट जनपद" data-en="Select Janpad"></span></label>
                    <select class="form-control" name="district_id" id="district_id">
                        <option value="">Select District</option>
                        @foreach($districts as $data)
                        <option value="{{ $data['id'] }}" {{ $data['id'] == request('district_id') ? 'selected' : '' }}>{{ $data['name_hindi'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-xl-1 col-md-2 fw-semibold my-auto text-center"> <span data-hi="अथवा" data-en="Or" ></span> </div>

                <div class="form-group col-md-5 col-xl-3">
                    <label for="inputEmail4"  class="fw-bold" data-hi="मोबाइल नंबर" data-en="Mobile Number" ></label>
                    <input type="text" value="{{ @$_GET['mobile'] }}" class="form-control" name="mobile" id="mobile"
                    data-placeholder-hi="मोबाइल नंबर" data-placeholder-en="Mobile Number">
                </div>

                <div class="form-group col-xl-3 mt-4 col-md-12">
                    <button type="submit" class="btn btn-primary"> <span data-hi="सर्च करें" data-en="Search"> </span></button>
                    <a href="{{ Request::url() }}" class="btn btn-secondary"> <span data-hi=" रीसेट करें" data-en="Reset"></span></a>
                   
                </div>

            </div>
        </form>
        <form method="get" action="{{ route('exportFarmarList') }}" > 
            @csrf
            <div class="col-md-2 m-2">
                <input type="hidden" id="mobile" name="mobile" value="{{ request('mobile') ?: '' }}">
                <input type="hidden" id="dis_id" name="dis_id" value="{{ request('district_id') ?: '' }}">

                <button class="btn btn-primary" type="submit" id="exportFarmarList" >
                    <span data-hi="एक्सपोर्ट" data-en="Export"></span>
                </button>
            </div>
        </form>

    <div class="pagination">
        {{ $farmarUser->links() }}
    </div>
    <table class="table table-striped  table-responsive table-bordered" style="display:block !important;">
        <thead>
            <tr>
                <th><span data-hi="S.No" data-en="S.No"></span></th>
                <th><span data-hi="नाम" data-en="Name"></span></th>
                <th><span data-hi="मोबाइल नंबर" data-en="Mobile Num"></span></th>
                <th><span data-hi="जिला" data-en="District"></span></th>
                <th><span data-hi="तहसील" data-en="Tehsil"></span></th>
                <th><span data-hi="ब्लॉक" data-en="Block"></span></th>
                <th><span data-hi="पोस्ट ऑफ़िस" data-en="Post Office"></span></th>
                <th><span data-hi="ग्राम पंचायत" data-en="Gram Panchayat"></span></th>
                <th><span data-hi="नस्ल" data-en="Breed"></span></th>
                <th><span data-hi="कैटेल संख्या" data-en="Cattale Num"></span></th>
                <th><span data-hi="दूध/प्रतिदिन/प्रति पशु" data-en="Milk/Day/Per Animal"></span></th>
            </tr>
        </thead>
        <tbody>
            @if ($farmarUser->isEmpty())
            <tr>
                <td colspan="11" class="text-center">No data found</td>
            </tr>
            @endif
            @php $i = 1; @endphp
            @foreach($farmarUser as $data)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $data['FirstName'] ?? 'N/A' }}</td>
                <td>{{ $data['MobileNumber'] ?? 'N/A' }}</td>
                <td>{{ $data['name_hindi'] ?? 'N/A' }}</td>
                <td>{{ $data['tehsil'] ?? 'N/A' }}</td>
                <td>{{ $data['block'] ?? 'N/A' }}</td>
                <td>{{ $data['post_office'] ?? 'N/A' }}</td>
                <td>{{ $data['gram_panchayat'] ?? 'N/A' }}</td>
                <td>{{ $data['breeds'] ?? 'N/A' }}</td>
                <td>{{ $data['cattale_no'] ?? 'N/A' }}</td>
                <td>{{ $data['milk_day'] ?? 'N/A' }}</td>
            </tr>
            @php $i++ @endphp
            @endforeach
        </tbody>

    </table>
    <div class="pagination">
        {{ $farmarUser->links() }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{ asset('assets/js/checkRemaninngStock.js') }}"></script>

@endsection