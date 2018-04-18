@extends('layouts.app')

@section('content') 
<div class="container no__home">
	<div class="row">
		<div class="col-md-12"> 
			<h3>Профиль</h3> 
			
			@if(Session::has('flash_message'))
			    <div class="alert alert-success" style="margin-top: 20px;">
			    	<p>{{ Session::get('flash_message') }}</p>
			    </div> 
			@endif 

			@include($include)  
		</div>
	</div>
</div> 
@stop