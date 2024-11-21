@extends('master')
@section('content')

    <div x-data="viewAvedan" class="container main-div">
        <h3 class="text-center fw-bold m-4"><span data-hi="नियुक्त उम्मीदवार" data-en="Placed Candidates"></span></h3>


        <form method="get" action="{{ Request::url() }}" class="form-comman">
            @csrf
            <div class="row">
                <div class="form-group col-md-5 col-xl-3">
                    <label for="inputEmail4"  class="fw-bold" data-hi="आवेदन नंबर" data-en="Application Number"></label>
                    <input type="text" value="{{ @$_GET['applicationNumber'] }}" class="form-control"
                        name="applicationNumber" id="applicationNumber" data-placeholder-hi="आवेदन  नंबर"  data-placeholder-en="Application Number">
                </div>

                <div class="form-group col-xl-1 col-md-2 fw-semibold my-auto text-center"><span data-hi="अथवा" data-en="Or" ></span></div>

                <div class="form-group col-md-5 col-xl-3">
                    <label for="inputEmail4"  class="fw-bold" data-hi="मोबाइल नंबर" data-en="Mobile Number" ></label>
                    <input type="text" value="{{ @$_GET['mobile'] }}" class="form-control" name="mobile" id="mobile"
                    data-placeholder-hi="मोबाइल नंबर" data-placeholder-en="Mobile Number">
                </div>

                <div class="form-group col-xl-1 col-md-2 fw-semibold my-auto text-center"><span data-hi="अथवा" data-en="Or" ></span></div>

                <div class="form-group col-md-5 col-xl-3">
                    <label for="inputEmail4"  class="fw-bold" data-hi="प्रशिक्षण केंद्र" data-en="Training Center" ></label>
                    <input type="text" value="{{ @$_GET['mobile'] }}" class="form-control" name="mobile" id="mobile"
                    data-placeholder-hi="प्रशिक्षण केंद्र" data-placeholder-en=" Training Center">
                </div>

                <div class="form-group col-xl-3 mt-4 col-md-12">
                    <button type="submit" class="btn btn-primary"> <span data-hi="सर्च करें" data-en="Search"> </span></button>
                    <a href="{{ Request::url() }}" class="btn btn-secondary"> <span data-hi=" रीसेट करें" data-en="Reset"></span></a>
                    @if (isset($route, $year))
                        @php
                            $queryParameters = request()->query();

                            $queryParameters['export'] = true;
                            $queryParameters['year'] = $year;
                        @endphp

                        <a class="btn btn-secondary btn-export" href="{{ route($route, $queryParameters) }}" >Export</a>
                    @endif
                </div>

            </div>
        </form>
        <div class="row">
           <div class="col-md-12">
         
           </div>
        </div>
        <table id="myTable202" class="table table-striped  table-responsive table-bordered">
            <thead>
                <tr>
                    <th>  <span data-hi="आवेदन नंबर" data-en="Applicant's Number"></span> </th>
                    <th><span data-hi="आवेदक का नाम" data-en="Applicant's Name"></span> </th>
                    <th><span data-hi="अभ्यर्थी का स्वत: मूल्यांकन अंक" data-en="Candidate's Self-Assessment Marks"></span> </th>
                    <th> <span data-hi="दिनांक" data-en="Date"></span> </th>
                    <th> <span data-hi="देखें" data-en="View"></span> </th>
                    <th><span data-hi="स्थिति" data-en="Status"></span> </th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>
        <div class="row">
           <div class="col-md-12">
           
            </div>
        </div>
    </div>
@endsection
