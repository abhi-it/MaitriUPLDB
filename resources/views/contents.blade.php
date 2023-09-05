@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;">
    <!--First row Start -->
	 
 <h1 style="margin-top:10px;text-align: center;">{{$result->title}}</h1>
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
