@extends('master')
@section('content')
<div class="container main-div" style="background-color:white; height: 100%;">
    <!--First row Start -->
	 
 <h1 style="margin-top:10px;text-align: center;">योग्यता</h1>
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
