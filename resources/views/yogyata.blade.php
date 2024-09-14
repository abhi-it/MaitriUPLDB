@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;">
    <!--First row Start -->
	 
    <h3 class="text-center fw-bold m-4">योग्यता</h3>
@if(session()->get('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}  
  </div>
@endif

        <!------Summary Page Start---------------->
        <div class="row" style="height: 350px;">
			
        </div>
        <!------Summary Page End---------------->
     
        

</div>

 @endsection 
