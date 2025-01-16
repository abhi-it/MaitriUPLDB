@extends('master')
@section('content')

<style>
.errorclass {
    font-size: 8px;
    color: red;
}
</style>
<div class="container main-div py-5" style="background-color:white;">
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
    <h3 class="text-center fw-bold m-4">
        <span data-hi="दैनिक डैशबोर्ड" data-en="Daily Dashboard"></span>
    </h3>

    <form method="post" action="{{ route('save-daily-dashboard') }}" class="form-comman">
        @csrf
        <hr>
        @php
        $startYear = 2020; // Starting year
        $endYear = date('Y'); // Current year
        $selectedYear = 2026; // The selected start year (2026-2027)
        @endphp
        <input type="hidden" name="id" id="record_id" value="">

        <div class="row">
            <div class="number_of_ai">
                <label for="inputEmail4" class="fw-bold">
                    <span data-hi="AI पूर्ण की गई संख्या" data-en="Number of AI"></span>
                </label>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <input type="text" name="heading_of_ai" class="form-control" required
                            data-placeholder-hi="लेबल दर्ज करें" data-placeholder-en="Enter a Label" autofocus />
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="num_of_ai" class="form-control" required
                            data-placeholder-hi="AI की संख्या दर्ज करें" data-placeholder-en="Enter Number of AI"
                            autofocus />
                    </div>
                </div>
            </div>
            <div class="mt-3 number_of_pd">
                <label for="inputEmail4" class="fw-bold">
                    <span data-hi="पूर्ण किये गए पी.डी. की संख्या" data-en="Number of PD"></span>
                </label>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <input type="text" name="heading_of_pd" class="form-control" required
                            data-placeholder-hi="लेबल दर्ज करें" data-placeholder-en="Enter a Label" autofocus />
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="num_of_pd" class="form-control" required
                            data-placeholder-hi="पीडी की संख्या दर्ज करें" data-placeholder-en="Number of PD"
                            autofocus />
                    </div>
                </div>
            </div>
            <div class="mt-3 number_of_Calving">
                <label for="inputEmail4" class="fw-bold">
                    <span data-hi="बछड़ों की संख्या" data-en="Number of Calving"></span>
                </label>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <input type="text" name="heading_of_calving" class="form-control" required
                            data-placeholder-hi="लेबल दर्ज करें" data-placeholder-en="Enter a Label" autofocus />
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="num_of_calving" class="form-control" required
                            data-placeholder-hi="बछड़ों की संख्या दर्ज करें"
                            data-placeholder-en="Enter Number of Calving" autofocus />
                    </div>
                </div>
            </div>
            <div class="mt-3 number_of_insurance">
                <label for="inputEmail4" class="fw-bold">
                    <span data-hi="बीमा की संख्या" data-en="Number of Insurance"></span>
                </label>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <input type="text" name="heading_of_insurance" class="form-control" required
                            data-placeholder-hi="लेबल दर्ज करें" data-placeholder-en="Enter a Label" autofocus />
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="number_of_insurance" class="form-control" required
                            data-placeholder-hi="बीमा की संख्या दर्ज करें"
                            data-placeholder-en="Enter Number of Insurance" autofocus />
                    </div>
                </div>
            </div>
        </div>
        <!------Summary Page End---------------->
        <div class="row">
            <div class="mb-4 mt-4 text-center">
                <button type="submit" class="btn btn-primary submit buttonWizard">
                    <span data-en="Submit" data-hi="सबमिट"></span>
                </button>
            </div>
        </div>
    </form>
    <h3 class="text-center fw-bold m-4">
        <span data-hi="दैनिक डैशबोर्ड रिकॉर्ड" data-en="Daily Dashboard Record"></span>
    </h3>
    <table class="table table-striped  table-responsive table-bordered">
        <thead>
            <tr>
                <th><span data-hi="S.No" data-en="S.No"></span></th>
                <th><span data-hi="AI पूर्ण की गई संख्या" data-en="Number of AI"></span></th>
                <th><span data-hi="एआई शीर्षक" data-en="AI Heading"></span></th>
                <th><span data-hi="पीडी की संख्या" data-en="Number of PD"></span></th>
                <th><span data-hi="पीडी शीर्षक" data-en="PD Heading"></span></th>
                <th> <span data-hi="बछड़े का जन्म शीर्षक" data-en="Calving Heading"></span></th>
                <th> <span data-hi="बछड़ों की संख्या" data-en="Number of Calving"></span></th>
                <th><span data-hi="बीमा शीर्षक" data-en="Insurance Heading"></span></th>
                <th><span data-hi="बीमा की संख्या" data-en="Number of Insurance"></span></th>
                <th> <span data-hi="निर्माण तिथि" data-en="Creation Date"></span> </th>
                <th> <span data-hi="अद्यतन" data-en="Update"></span> </th>
            </tr>
        </thead>
        <tbody>
            @if ($dailyDashboard->isEmpty())
            <tr>
                <td colspan="15" class="text-center">No data found</td>
            </tr>
            @endif

            @php $i = 1 @endphp
            @foreach($dailyDashboard as $daliData)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $daliData['heading_of_ai'] }}</td>
                <td>{{ $daliData['num_of_ai'] }}</td>
                <td>{{ $daliData['heading_of_pd'] }}</td>
                <td>{{ $daliData['num_of_pd'] }}</td>
                <td>{{ $daliData['heading_of_calving'] }}</td>
                <td>{{ $daliData['num_of_calving'] }}</td>
                <td>{{ $daliData['heading_of_insurance'] }}</td>
                <td>{{ $daliData['number_of_insurance'] }}</td>
                <td>{{ $daliData['created_at'] }}</td>
                <td><button type="button" class="btn btn-danger edit-btn"
                        data-record="{{ json_encode($daliData) }}">Edit</button></td>
            </tr>
            @php $i++ @endphp
            @endforeach

        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{ asset('assets/js/checkRemaninngStock.js') }}"></script>
<script>
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        const record = JSON.parse(this.getAttribute('data-record'));

        // Populate form fields with data
        document.getElementById('record_id').value = record.id;
        document.querySelector('input[name="heading_of_ai"]').value = record.heading_of_ai;
        document.querySelector('input[name="num_of_ai"]').value = record.num_of_ai;
        document.querySelector('input[name="heading_of_pd"]').value = record.heading_of_pd;
        document.querySelector('input[name="num_of_pd"]').value = record.num_of_pd;
        document.querySelector('input[name="heading_of_calving"]').value = record.heading_of_calving;
        document.querySelector('input[name="num_of_calving"]').value = record.num_of_calving;
        document.querySelector('input[name="heading_of_insurance"]').value = record
            .heading_of_insurance;
        document.querySelector('input[name="number_of_insurance"]').value = record.number_of_insurance;

        // Scroll to form or bring it into focus
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
</script>

@endsection