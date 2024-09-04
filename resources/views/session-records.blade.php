@extends('master')
@section('content')
<div class="container main-div" style="background-color:white;">
    <h1 style="margin-top:10px;text-align: center;margin-bottom:20px;">
        <span data-hi="प्रत्येक सत्र की सभी जिलों की मैत्री का रिकार्ड"  data-en="Record of maitri of all districts in each session"></span>
    </h1>
    <div class="row">
        <div class="form-group col-md-12">
            <table class="table table-bordered">
                <tr style="background-color:#d3d3d3;"> 
                    <!-- <th > <span data-hi="क्रं सं" data-en="S.No."></span>  </th> -->
                    <th > <span data-hi="ज़िला" data-en="District"></span>  </th>
                    <th ><span data-hi="तहसील" data-en="Tehsil"></span> </th>
                    <th ><span data-hi="ब्लॉक" data-en="Block"></span> </th>
                    <th ><span data-hi="ग्राम पंचायत की संख्या" data-en="Number of Gram Panchayat"></span></th>
                    <th ><span data-hi="प्रजनन योग्य आबादी" data-en="Reproductive population"></span></th>
                    <th ><span data-hi="सत्र" data-en="Session"></span>  (2013-14)</th>
                    <th ><span data-hi="सत्र" data-en="Session"></span>  (2014-15)</th>
                    <th ><span data-hi="सत्र" data-en="Session"></span>  (2016-17)</th>
                    <th ><span data-hi="सत्र" data-en="Session"></span>  (2021-22)</th>
                    <th ><span data-hi="सत्र" data-en="Session"></span>  (2022-23)</th>
                    <th ><span data-hi="सत्र" data-en="Session"></span>  (2023-24)</th>
                    <th ><span data-hi="कुल" data-en="Total"></span>  </th>
                </tr>
                @if ($results->count())
                    @foreach ($results as $key=> $row)
                    @php 
                    $total  =( $row->session_2013_14)+($row->session_2014_15)+($row->session_2016_17)+($row->session_2021_2022)+($row->session_2022_23)+($row->session_2023_24);
                    @endphp

                    <tr>
                        <!-- <td>{{$key+1}}</td> -->
                        <td>{{$row->distric}}</td>
                        <td> {{$row->tehsil}} </td>
                        <td>{{$row->block}}</td>
                        <td>{{$row->no_of_gram_panchayat}}</td>
                        <td>{{($row->breedable_population)?$row->breedable_population:''}}</td>
                        <td>{{($row->session_2013_14?$row->session_2013_14:'')}}</td>
                        <td>{{($row->session_2014_15)?$row->session_2014_15:''}}</td>
                        <td>{{($row->session_2016_17)?$row->session_2016_17:''}}</td>
                        <td>{{($row->session_2021_2022)?$row->session_2021_2022:''}}</td>
                        <td>{{($row->session_2022_23)?$row->session_2022_23:''}}</td>
                        <td>{{($row->session_2023_24)?$row->session_2023_24:''}}</td>
                        <td>{{$total}}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center ">No record found..</td>
                    </tr>
                @endif
            </table>
        </div>
        <div class="row">
            {{ $results->links() }}
        </div>
    </div>
</div>
@endsection
