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
	<!---->
	<style>
.cmn-toggle 
{
  position: absolute;
  margin-left: -9999px;
  visibility: hidden;
}

.cmn-toggle + label 
{
  display: block;
  position: relative;
  cursor: pointer;
  outline: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

input.cmn-toggle-round-flat + label 
{
  padding: 2px;
  width: 75px;
  height: 30px;
  background-color: #dddddd;
  -webkit-border-radius: 60px;
  -moz-border-radius: 60px;
  -ms-border-radius: 60px;
  -o-border-radius: 60px;
  border-radius: 60px;
  -webkit-transition: background 0.4s;
  -moz-transition: background 0.4s;
  -o-transition: background 0.4s;
  transition: background 0.4s;
  display: inline-block;
}

input.cmn-toggle-round-flat + label:before, input.cmn-toggle-round-flat + label:after 
{
  display: block;
  position: absolute;
  content: "";
}

input.cmn-toggle-round-flat + label:before 
{
  top: 2px;
  left: 2px;
  bottom: 2px;
  right: 2px;
  background-color: #fff;
  -webkit-border-radius: 60px;
  -moz-border-radius: 60px;
  -ms-border-radius: 60px;
  -o-border-radius: 60px;
  border-radius: 60px;
  -webkit-transition: background 0.4s;
  -moz-transition: background 0.4s;
  -o-transition: background 0.4s;
  transition: background 0.4s;
}

input.cmn-toggle-round-flat + label:after 
{
  top: 4px;
  left: 4px;
  bottom: 4px;
  width: 22px;
  background-color: #dddddd;
  -webkit-border-radius: 52px;
  -moz-border-radius: 52px;
  -ms-border-radius: 52px;
  -o-border-radius: 52px;
  border-radius: 52px;
  -webkit-transition: margin 0.4s, background 0.4s;
  -moz-transition: margin 0.4s, background 0.4s;
  -o-transition: margin 0.4s, background 0.4s;
  transition: margin 0.4s, background 0.4s;
}

input.cmn-toggle-round-flat:checked + label 
{
  background-color: #27A1CA;
}

input.cmn-toggle-round-flat:checked + label:after 
{
  margin-left: 45px;
  background-color: #27A1CA;
}

.switch span{
	display: inline-block;
}
	</style>
	<div class="container teacher_lk">
		<div class="row">
			<div class="col-lg-3">
				<img class="img-responsive" src="http://via.placeholder.com/400x400">
			</div>
			<div class="col-lg-9">
				<span class="teacher_type">ПРЕПОДАВАТЕЛЬ</span>
				<h1>Гапонова Маргарита Поликарповна</h1>
				<div class="switch">
					<span>Свободен</span>
					<input id="cmn-toggle-4" class="cmn-toggle cmn-toggle-round-flat" type="checkbox">
					<label for="cmn-toggle-4"></label>
					<span>Занят</span>
				</div>
				<div>
					<button class="btn btn-default">Публиковать профиль</button>
					Для того, чтобы Вы появились в разделе репетиторов,  
					вам нужно подробно заполнить свой профиль
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
                <ul class="nav nav-tabs registration_type" role="tablist">
                    <li role="presentation" class="active">
						<a href="#user" aria-controls="user" role="tab" data-toggle="tab">МОИ КУРСЫ (ОБУЧАЮ)</a>
					</li>
                    <li role="presentation">
						<a href="#teacher" aria-controls="teacher" role="tab" data-toggle="tab">МОИ ЗАЯВКИ</a>
                    </li>
                    <li role="presentation">
						<a href="#university" aria-controls="university" role="tab" data-toggle="tab">ПОДПИСКИ</a>
					</li>
                    <li role="presentation">
						<a href="#university" aria-controls="university" role="tab" data-toggle="tab">УЧЕБНЫЕ ЗАВЕДЕНИЯ</a>
					</li>
                    <li role="presentation">
						<a href="#university" aria-controls="university" role="tab" data-toggle="tab">ОТЗЫВЫ И КОММЕНТАРИИ</a>
					</li>
                </ul>
			</div>
		</div>
	</div>
	<!---->
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