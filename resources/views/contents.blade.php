@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;">
    <!--First row Start -->
	 
    <h3 class="text-center fw-bold m-4">{{$result->title}}</h3>
@if(session()->get('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}  
  </div>
@endif

        <!------Summary Page Start---------------->
        
        
        <div class="col-12 p-4">
    <div class="row">
        <div class="col-12 col-md-12">
           <?php echo $result->description;?>
        </div>
    </div>
  </div> 
        
        
        <!------Summary Page End---------------->
     
        

</div>

 @endsection 
