@extends('submaster')
@section('content')
<style>
    .card {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, .125);
        border-radius: 0.25rem;
    }

    .card-body {
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 1.25rem;
    }

    .modal-dialog {
        max-width: 40% !important;
    }
    .openModal{
        display:none;
    }
    .contain-form{
        margin: auto;
        padding: 20px;
    }
</style>
<div class="container main-div">
    <!-- <h3 style="margin-top:10px;text-align: center;">Service Request Form</h3> -->
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
      
        <div class="row">
            <div class="col-sm-3">
                <div class="card text-center">
                    <div class="card-header">सेवा अनुरोध सूची</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ count($data) }}</h5>
                        <a href="{{ url('/farmer-requests') }}" class="btn btn-primary">देखना</a>
                    </div>
                </div>
            </div>
        </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">प्रतिपुष्टी फ़ार्म</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  method="post"  enctype="multipart/form-data" action="{{route('farmer-dashdata')}}"> 
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="message-text" class="col-form-label">बीमा:</label>
                <select  class="form-control" id="insurance" name="insurance" required>
                    <option value="no">नहीं</option>
                    <option value="yes">हाँ</option>
                </select>
            </div>
            <div class="form-group">
                <label for="animal_file" class="col-form-label">प्रतिक्रिया</label>
                <textarea id="feedback" class="form-control"  name="feedback" rows="4" cols="50"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">बंद करे</button>
            <button type="submit" class="btn btn-primary" id="submit">जमा करें</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- User Details Modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailsModalLabel">Complete Your Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="post" action="{{ route('farmer-add') }}" class="form-comman">
        @csrf
        <div class="row">
            <div class="form-group col-md-4">
                <label for="inputEmail4">
                    <span data-hi="नाम" data-en="First Name"></span>
                </label>
                <input type="text" class="form-control" name="first_name" id="first_name" required
                    data-placeholder-hi="नाम" autocomplete="off" data-placeholder-en="First Name">
            </div>
            

            <div class="form-group col-md-4">
                <label for="inputPassword4">
                    <span data-hi="मोबाइल नंबर" data-en="Mobile Number"></span>
                </label>
                <input type="number" class="form-control" id="MobileNumber" name="MobileNumber" required
                    data-placeholder-hi="मोबाइल नंबर" autocomplete="off" data-placeholder-en="Mobile Number">
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4"> <span data-hi="लिंग" data-en="Gender"> </span></label>
                <select class="form-control" name="gender" id="gender" required>
                    <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                    <option value="male" data-hi="पुरुष" data-en="Male"></option>
                    <option value="female" data-hi="महिला" data-en="Female"></option>
                    <option value="others" data-hi="अन्य" data-en="Other"> </option>
                </select>
            </div>


            <div class="form-group col-md-12">
                <label for="animal">
                    <span data-hi="पशु की जानकारी" data-en="Number of cattle"></span>
                </label>
                <div class="optionBox">
                    <div class="block row adddiv_0">
                        <div class="form-group col-md-3">
                            <select class="form-control" id="animal_type" name="animal_type[]" required>
                                <option value="" data-hi="एक का चयन करें" data-en="select one"></option>
                                <option value="cow" data-hi="गाय" data-en="Cow"> </option>
                                <option value="buffalo" data-hi="भैंस" data-en="Buffalo"> </option>
                                <option value="goat" data-hi="बकरी" data-en="Goat"></option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                          
                            <input type="text" class="form-control" id="breeds" name="breeds[]" required
                                data-placeholder-hi="गाय/भैंस/बकरी की नस्लें" autocomplete="off"
                                data-placeholder-en="Breeds of Cow/Buffalo">
                        </div>
                        <div class="form-group col-md-3">
                            <input type="number" class="form-control" id="cattale_no" name="cattale_no[]" required
                                data-placeholder-hi="पशु की जानकारी" data-placeholder-en="Cattle Number"
                                autocomplete="off">
                        </div>
                        <div class="form-group col-md-2">
                            
                            <input type="text" class="form-control" id="milk_day" name="milk_day[]" required
                                data-placeholder-hi="दूध/प्रतिदिन/प्रति पशु" autocomplete="off"
                                data-placeholder-en="Milk/day/Per Animal">
                        </div>

                       
                        <div class="form-group col-md-1">
                            <span class="add btn btn-primary btn-sm"> <span data-hi="जोड़ें" data-en="Add"></span> </span>
                           
                        </div>
                    </div>
                </div>


            </div>

           
           
            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="मंडल" data-en="Mandal"></span> </label>
                <select name="division_id" id="district" class="form-control" autofocus required>
                    <option value="" data-hi="मंडल चुनें" data-en="Select Mandal"></option>
                    @if(count($divisions)>0)
                    @foreach($divisions as $key => $val)
                    <option value="{{$val->id}}">{{$val->name_hindi}}</option>
                    @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="ज़िला" data-en="District"></span> </label>
                <select name="district_id" id="mandal" class="form-control" autofocus required>

                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="तहसील" data-en="Tehsil"></span> </label>
                <select name="tehsil" id="tehsil" class="form-control" placeholder="तहसील" autofocus required>

                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="विकास खण्ड" data-en="Vikas Khand"></span> </label>
                <select name="block" id="vikas_khand" class="form-control" placeholder="विकास खण्ड" autofocus required>

                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="inputEmail4"> <span data-hi="पोस्ट ऑफिस" data-en="Post Office"></span> </label>
                <input type="text" name="post_office" id="post_office" required class="form-control"
                    placeholder="पोस्ट ऑफिस" autofocus>
            </div>


            <div class="form-group col-md-6">
                <label for="inputEmail4"><span data-hi="पिनकोड" data-en="Pincode"></span></label>
                <span id="error-message" style="color: red; display:none; font-size:10px; ">(Pincode must be a 6-digit
                    number.)</span>
                <input type="text" name="pincode" maxlength="6" id="pincode" required class="form-control"
                    data-placeholder-en="Enter Pincode Here" data-placeholder-hi="यहां पिनकोड दर्ज करें" autofocus>
            </div>
            


            <div class="form-group col-md-6">
                <label for="inputPassword4">
                    <span data-hi="ग्राम पंचायत" data-en="Gram Panchayat"></span>
                </label>
                <input type="text" class="form-control" id="gram_panchayat" required name="gram_panchayat" required
                    data-placeholder-hi="ग्राम पंचायत" autocomplete="off" data-placeholder-en="Gram Panchayat">
            </div>
        </div>
       
        <div class="row">
            <div class="mb-4 mt-4 text-center">
                <button type="submit" class="btn btn-primary submit buttonWizard">
                    <span data-hi="सबमिट" data-en="Submit"></span>
                </button>
            </div>
        </div>
    </form>
            </div>
        </div>
    </div>
</div>


@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        // $.ajax({
        //     url: "{{ route('check.user.details') }}",
        //     type: "GET",
        //     success: function (response) {
        //         if (response.status === "not_filled") {
        //           $('#userDetailsModal').modal('show');
        //         } else if (response.status === "filled") {
        //           console.log("User details are already filled.");
        //         }
        //     },
        //     error: function (xhr) {
        //         console.error("An error occurred:", xhr.responseJSON.message);
        //     }
        // });

        // $('#user-details-form').on('submit', function (e) {
        //     e.preventDefault();
        //     const formData = $(this).serialize();

        //     $.ajax({
        //         url: "/submit-user-details", // Update with your actual endpoint
        //         type: "POST",
        //         data: formData,
        //         success: function (response) {
        //             alert("Details submitted successfully!");
        //             $('#userDetailsModal').modal('hide'); // Hide the modal
        //         },
        //         error: function (xhr) {
        //             console.error("An error occurred:", xhr.responseJSON.message);
        //         }
        //     });
        // });
    });
</script>

<script type="text/javascript">

  $(window).on('load', function() {
    var modelShown = localStorage.getItem('farmer');
    console.log('localStorage',localStorage,modelShown)
    if(modelShown != 'YES'){
      $('#exampleModal').modal('show');
      localStorage.setItem('farmer', 'YES');
    }
  });
</script>