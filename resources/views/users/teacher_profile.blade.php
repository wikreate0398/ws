@extends('layouts.app')

@section('content')  

<div class="no__home" style="margin-top: 66px;"> 
	<div style="background: rgba(188, 188, 188, 1); padding:30px 0;">
		<div class="container">
			<div class="row">
				<div class="col-md-2" style="text-align: center;"> 
					<form class="form-horizontal ajax__submit profile__image_form" method="POST" action="{{ route('update_image') }}">
		    			{{ csrf_field() }}
						<div class="profile__img" style="background-image: url(/public/uploads/users/{{ $user->avatar ? $user->avatar : $user->image }});"></div>
						<div id="error-respond"></div>
						<span class="btn btn-default btn-sm btn-file">
						    Выбрать <input type="file" name="image" onchange="profilePhoto(this)">
						</span>
						<input type="hidden" name="avatar" id="avatar">
						<button type="button" 
						        style="display: none;" 
						        onclick="$('.cropper__section, #overlay').fadeIn(150); " 
						        class="btn primary btn-sm edit__profile__photo-icon">
						        	<i style="position: relative; top: 1px;left: 1px;" class="fa fa-pencil-square-o" aria-hidden="true"></i>
						</button>
						<!-- <button type="submit" class="btn primary btn-sm">Сохранить</button>   -->
					</form>
				</div>

				<div class="col-md-7">
					<h1 style="margin-top: 30px;">{{ $user->name }}</h1>
					<a class="dashed__link" href="{{ route('user_edit') }}">Редактировать профиль</a><br><br>
					<input type="checkbox" id="teacher_status" {{ ($user->is_available==1) ? 'checked' : '' }} onchange="teacherStatus(this)">
					<button class="btn btn-info btn-sm" style="display: inline-block; width: auto; margin-top: 10px; border-radius: 20px; cursor: default;">Преподаватель</button>
				</div> 

				<div class="col-md-3" style="position: relative; top: 70px;">
					@if(Auth::user()->data_filled == 0)
						<div class="alert alert-danger">
							Заполните профиль для дальнейших действий
						</div>
					@endif
				</div>
			</div>
		</div>
	</div> 

	<nav class="navbar navbar-default">
	  <div class="container"> 
	    <ul class="nav navbar-nav">
	    	@if(Auth::user()->data_filled == 1)
	      	<li class="{{ isActive(route('user_profile')) ? 'active' : '' }}">
	      		<a href="{{ route('user_profile') }}">МОИ КУРСЫ (ОБУЧАЮ)</a>
	      	</li>
			<li class="{{ isActive(route('user_diplomas')) ? 'active' : '' }}">
				<a href="{{ route('user_diplomas') }}">МОИ ДИПЛОМЫ</a>
			</li>
			<li class="{{ isActive(route('user_subscriptions')) ? 'active' : '' }}">
				<a href="{{ route('user_subscriptions') }}">ПОДПИСКИ</a>
			</li>
			<li class="{{ isActive(route('user_reviews')) ? 'active' : '' }}">
				<a href="{{ route('user_reviews') }}">ОТЗЫВЫ И КОММЕНТАРИИ</a>
			</li>
			@endif
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