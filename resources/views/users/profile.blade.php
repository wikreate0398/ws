@extends('layouts.app')

@section('content') 
<div class="container no__home">
	<div class="row">
		<div class="col-md-12"> 
			<h3>Профиль</h3> 
			
			@if(Session::has('flas_message'))
			    <div class="alert alert-success" style="margin-top: 20px;">
			    	<p>{{ Session::get('flas_message') }}</p>
			    </div> 
			@endif 

			@include($include)  
		</div>
	</div>
</div> 
@stop