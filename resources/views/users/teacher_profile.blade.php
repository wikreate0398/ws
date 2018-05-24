@extends('layouts.app')

@section('content')  

<div class="no__home" style="margin-top: 50px;">

	<!---->
	<style>
	.checkbox.checbox-switch {
		padding-left: 0;
	}
	.checkbox.checbox-switch label,
	.checkbox-inline.checbox-switch {
		display: inline-block;
		position: relative;
		padding-left: 0;
	}
	.checkbox.checbox-switch label input,
	.checkbox-inline.checbox-switch input {
		display: none;
	}
	.checkbox.checbox-switch label span,
	.checkbox-inline.checbox-switch span {
		width: 80px;
		border-radius: 20px;
		height: 30px;
		border: 1px solid #c1c1c1;
		background-color: rgb(255, 255, 255);
		transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;
		display: inline-block;
		vertical-align: middle;
		margin-right: 7px;
		margin-left: 7px;
	}
	.checkbox.checbox-switch label span:before,
	.checkbox-inline.checbox-switch span:before {
		display: inline-block;
		width: 24px;
		height: 24px;
		border-radius: 50%;
		border: 1px solid #c1c1c1;
		background: rgb(255,255,255);
		content: " ";
		top: 2px;
		position: relative;
		left: 2px;
		transition: all 0.3s ease;
	}
	.checkbox.checbox-switch label > input:checked + span:before,
	.checkbox-inline.checbox-switch > input:checked + span:before {
		left: 53px;
	}
	.checkbox.checbox-switch.switch-light label > input:checked + span,
	.checkbox-inline.checbox-switch.switch-light > input:checked + span {
		background-color: rgb(248,249,250);
		border-color: rgb(248,249,250);
		box-shadow: rgb(248,249,250) 0px 0px 0px 8px inset;
		transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;
	}
	</style>
	<div class="container teacher_lk">
		<div class="top_lk">
			<div class="row">
				<div class="col-lg-3">
					<img class="img-responsive" src="http://via.placeholder.com/400x400">
				</div>
				<div class="col-lg-9">
					<span class="teacher_type">ПРЕПОДАВАТЕЛЬ</span>
					<h1>Гапонова Маргарита Поликарповна</h1>
					<label class="checkbox-inline checbox-switch switch-light">
						<input type="checkbox" name="" />
						Свободен
						<span></span>
						Занят
					</label>
					<div>
						<button class="btn btn-default">Публиковать профиль</button>
						Для того, чтобы Вы появились в разделе репетиторов,  
						вам нужно подробно заполнить свой профиль
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				@if(Auth::user()->data_filled == 1)
                <ul class="nav registration_type">
                    <li class="{{ isActive(route('user_profile')) ? 'active' : '' }}">
						<a href="{{ route('user_profile') }}">МОИ КУРСЫ (ОБУЧАЮ)</a>
					</li>
                    <li>
						<a href="#teacher">МОИ ЗАЯВКИ</a>
                    </li>
                    <li>
						<a href="#university">ПОДПИСКИ</a>
					</li>
                    <li>
						<a href="#university">УЧЕБНЫЕ ЗАВЕДЕНИЯ</a>
					</li>
                    <li>
						<a href="#university">ОТЗЫВЫ И КОММЕНТАРИИ</a>
					</li>
                </ul>
				@endif
			</div>
		</div>
	</div>
	<!---->
 
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