@extends('master')
@section('content')

<style>
    .search__button{
    display: flex;
    align-items: flex-end;
    gap: 10px;
    }
</style>
    <div x-data="" class="container main-div" style="background-color:white; height: 100%;min-height:380px;">
        <h3 class="text-center m-4 fw-bold">  <span data-hi="मासिक मांग अनुरोध सूची" data-en="Monthly Demand Request List"></span> </h3>
        <div class="row">
            <div class="col-md-12"> 
            <form method="get" action="{{ Request::url() }}" class="form-comman">
            @csrf

            <div class="row">
            <div class="form-group col-md-4">
                <label for="inputEmail4" class="fw-bold">सेलेक्ट जनपद </label>
                <select class="form-control" name="id" id="id">
                    <option value="">Select Janpad</option>
                    @if(count($district)>0)
                        @foreach($district as $val)
                            <option value="{{$val->name_hindi}}"
                            {{ request()->get('id') == $val->name_hindi ? 'selected' : '' }}>{{$val->name_hindi}}</option>
                        @endforeach
                    @endif
                </select>  
            </div>
            <div class="form-group col-md-3 search__button">
                <button type="submit" class="btn btn-primary">सर्च करें</button>
                <a href="{{ Request::url() }}" class="btn btn-secondary">रीसेट करें</a>
            </div>
            </div>

            </form> 
            <form method="get" action="{{ route('exportDemandRequest') }}"> 
                @csrf
                <div class="row">
                 <div class="col-md-1 mb-4">
                    <input type="hidden" id="dis_id" name="dis_id" value="{{ (request()->get('id')) ? request()->get('id') : '' }}">
                    <button class="btn btn-primary" type="submit" id="demandRequest" >Export</button>
                </div>
                </div>
            </form>
            </div>
        </div>

        <table  class="table table-striped  table-responsive table-bordered">
            <thead>
                <tr>
                    <th><span data-hi="नाम" data-en="Name "></span></th>    
                    <th> <span data-hi="जन्म तिथि" data-en="Date Of Birth "></span> </th>
                    <th><span data-hi="लिंग" data-en="Gender "></span> </th>
                    <th><span data-hi="प्रशिक्षण केंद्र आईडी" data-en="Training Center Id "></span>  </th>
                    <th> <span data-hi="जिले" data-en=" Districts"></span></th>
                    <th> <span data-hi="तहसील" data-en=" Tehsil"></span></th>
                    <th> <span data-hi="पोस्ट ऑफ़िस" data-en=" Post - Office"></span></th>
                    <th><span data-hi="मोबाइल नंबर" data-en=" Mobile No"></span ></th>
                    <th><span data-hi="अनुरोध तिथि" data-en=" Request Date"></span ></th>
                    <th> <span data-hi="कार्रवाई" data-en="Action"></span> </th>
                </tr>
            </thead>
            <tbody>
            @if(count($data)>0)
            @foreach($data as $val)
            @php
            $dis_name  =  App\Models\Districts::where(['id'=>$val->district])->select('name_hindi')->pluck('name_hindi')->first();
            @endphp

            <tr>
                <td>{{$val->name}}</td>
                <td>{{ date('j F, Y', strtotime($val->date_of_birth))}}</td>
                <td>{{$val->gender}}</td>
                <td>{{$val->training_center_id}}</td>
                <!-- <td>{{($val->district)?$dis_name:'N/A'}} </td> -->
                <td>{{($val->district) ? $val->district:'N/A'}} </td>
                <td>{{($val->tehsil)?$val->tehsil:'N/A'}} </td>
                <td>{{($val->post_office)?$val->post_office:'N/A'}} </td>
                <td>{{$val->smart_mobile_no}}</td> 
                <td> <a href="javascript:void(0)" class="btn btn-secondary">{{date('d/m/Y', strtotime($val->created_at))}}</a>  </td>
            <td>
                <a href="{{ url('view-request-details') }}/{{ $val->id }}" class="btn btn-secondary">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </a> 
                <button class="btn btn-danger deleteRequest" data-id="{{$val->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
            
            </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6" style="color:red;">No record found..</td>
            </tr>
            @endif
            </tbody>
        </table>
        <div class="row">
       {!! $data->links() !!}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>	
 const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });

$('.deleteRequest').click(function() {
    var val = $(this).data("id");
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "{{ route('deleteRequests') }}",
                    dataType: 'json',
                    data: { id: val, _token: "{{ csrf_token() }}" },
                    success: function (result) {
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Your record has been deleted.',
                            'success'
                        );
                        location.reload();
                    }
                });
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your record is safe!',
                    'error'
                );
            }
        });
});
// $('#id').change(function() {
//     $('#dis_id').val();
//     var val = $("#id option:selected").val();
//     console.log('val',val)
//     if(val){
//         $('#dis_id').val(val);
//     }
// });
</script>

@endsection

