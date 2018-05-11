@extends('layouts.app')

@section('content') 

<div class="no__home" style="margin-top: 66px;"> 
	<div style="background:rgba(153, 204, 255, 1); padding:30px 0;">
		<div class="container">
			<div class="row">
				<div class="col-md-2" style="text-align: center;"> 
					<form class="form-horizontal ajax__submit profile__image_form" method="POST" action="{{ route('update_image') }}">
		    			{{ csrf_field() }}
						<div class="profile__img" 
						     style="background-image: url(/public/uploads/users/{{ $user->avatar ? $user->avatar : $user->image }});"></div>
						<div id="error-respond"></div>
						<span class="btn btn-default btn-sm btn-file">
						    Выбрать <input type="file" name="image" onchange="profilePhoto(this)">
						</span>
						<!-- <button type="submit" class="btn primary btn-sm">Сохранить</button>   -->

						<input type="hidden" name="avatar" id="avatar">
						<button type="button" 
						        style="display: none;" 
						        onclick="$('.cropper__section, #overlay').fadeIn(150); " 
						        class="btn primary btn-sm edit__profile__photo-icon">
						        	<i style="position: relative; top: 1px;left: 1px;" class="fa fa-pencil-square-o" aria-hidden="true"></i>
						</button>
					</form>
				</div>

				<div class="col-md-10">
					<h1 style="margin-top: 30px;">{{ $user->name }}</h1>
					<a class="dashed__link" href="{{ route('user_edit') }}">Редактировать профиль</a><br><br>
					<button class="btn btn-default btn-sm" style="display: inline-block; width: auto; border-radius: 20px; cursor: default;">Студент</button>
				</div> 
			</div>
		</div>
	</div> 

	<nav class="navbar navbar-default">
	  <div class="container"> 
	    <ul class="nav navbar-nav">
	      	<li class="{{ isActive(route('user_profile')) ? 'active' : '' }}">
	      		<a href="{{ route('user_profile') }}">МОИ КУРСЫ (ОБУЧАЮСЬ)</a>
	      	</li>
			<li class="{{ isActive(route('user_bookmarks')) ? 'active' : '' }}">
				<a href="{{ route('user_bookmarks') }}">ЗАКЛАДКИ</a>
			</li>
			<li class="{{ isActive(route('user_subscriptions')) ? 'active' : '' }}">
				<a href="{{ route('user_subscriptions') }}">ПОДПИСКИ</a>
			</li>
			<li class="{{ isActive(route('user_reviews')) ? 'active' : '' }}">
				<a href="{{ route('user_reviews') }}">ОТЗЫВЫ И КОММЕНТАРИИ</a>
			</li>
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