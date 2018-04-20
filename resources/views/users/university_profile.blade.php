@extends('layouts.app')

@section('content') 

<div class="no__home" style="margin-top: 66px;"> 
	<div style="background:rgba(153, 204, 255, 1); padding:30px 0;">
		<div class="container">
			<div class="row">
				<div class="col-md-2" style="text-align: center;"> 
					<form class="form-horizontal ajax__submit" method="POST" action="{{ route('update_image') }}">
		    			{{ csrf_field() }}
						<div class="profile__img" style="background-image: url(/public/uploads/users/{{ $user->image }});"></div>
						<div id="error-respond"></div>
						<span class="btn btn-default btn-sm btn-file">
						    Выбрать <input type="file" name="image">
						</span>
						<button type="submit" class="btn primary btn-sm">Сохранить</button>  
					</form>
				</div>

				<div class="col-md-10">
					<h1 style="margin-top: 30px;">{{ $user['university']['full_name'] }}</h1>
					<a class="dashed__link" href="{{ route('user_edit') }}">Редактировать профиль</a><br><br>
					<button class="btn btn-default btn-sm" style="display: inline-block; width: auto; border-radius: 20px; cursor: default;">Учебное заведение</button>
				</div> 
			</div>
		</div>
	</div> 

	<nav class="navbar navbar-default">
	  <div class="container"> 
	    <ul class="nav navbar-nav"> 
			<li class="{{ isActive(route('user_edit')) ? 'active' : '' }}">
				<a href="{{ route('user_edit') }}">ЛИЧНЫЕ ДАННЫЕ</a>
			</li>
	    </ul>
	  </div>
	</nav>

	<div class="container"> 
		<div class="row">
			 
			<div class="col-md-12">   
				@if(Session::has('flash_message'))
				    <div class="alert alert-success" style="margin-top: 20px;">
				    	<p>{{ Session::get('flash_message') }}</p>
				    </div> 
				@endif 

				<div style="min-height: 400px;">
					@include($include)  
				</div>
			</div>
		</div>
	</div>
</div>  
@stop