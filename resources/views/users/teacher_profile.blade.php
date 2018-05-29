@extends('layouts.app')

@section('content')  

<div class="no__home" style="margin-top: 50px;">
	<div class="container teacher_lk">
		<div class="top_lk">
			<div class="row">
				<div class="col-lg-3">

					<form class="form-horizontal ajax__submit profile__image_form" method="POST" action="{{ route('update_image') }}">
		    			{{ csrf_field() }}
						<div class="profile__img" style="background-image: url(/public/uploads/users/{{ $user->avatar ? $user->avatar : $user->image }}{{'?v=' . time()}});">
							<div class="actions__upload_photo">
								<span class="btn-file">
								    <i class="fa fa-file-image-o" aria-hidden="true"></i>
								    <input type="file" name="image" onchange="profilePhoto(this)">
								</span>

								<input type="hidden" name="avatar" id="avatar">
								<!-- <span style="display: none;" 
								        onclick="$('.cropper__section, #overlay').fadeIn(150); " 
								        class="edit__profile__photo-icon">
								        	<i style="position: relative; top: 1px;left: 1px;" class="fa fa-pencil-square-o" aria-hidden="true"></i>
								</span>  -->

							</div>
						</div>
						<div id="error-respond"></div>
						 
						 
					</form> 
				</div> 
				<div class="col-lg-9">
					<span class="teacher_type">ПРЕПОДАВАТЕЛЬ</span>
					<h1>
						@php
							$nameExplode = explode(' ', $user['name']);
							echo $nameExplode[0] . '<br>'; unset($nameExplode[0]);
							echo implode(' ', $nameExplode);
						@endphp
					</h1>
					<div class="teacher_employment">
						<label class="checkbox-inline checbox-switch switch-light">
							<input type="checkbox" name="" {{ ($user->is_available==1) ? 'checked' : '' }} onchange="teacherStatus(this)">
							Свободен
							<span></span>
							Занят
						</label>
					</div>
					@if(Auth::user()->data_filled == 0)  
						<div class="data_coverage">
							<a href="{{ route('user_edit') }}" class="btn edit_profile">Публиковать профиль</a>
							<span>Для того, чтобы Вы появились в разделе репетиторов, </br>
							вам нужно подробно заполнить свой профиль</span>
						</div>
					@else
						<div class="data_coverage">
							<a href="{{ route('user_edit') }}" class="btn edit_profile">Личные данные</a>
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				@if(Auth::user()->data_filled == 1)
                <ul class="nav lk_menu"> 
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
                </ul>
				@endif
			</div>
		</div>
	</div> 

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