@extends('layouts.app')

@section('content')

<div class="no__home" style="margin-top: 50px;">
	<div class="container teacher_lk">
		<div class="top_lk">
			<div class="row">
				<div class="col-lg-3">

					<form class="form-horizontal ajax__submit profile__image_form" method="POST" action="{{ route('update_image') }}">
		    			{{ csrf_field() }}
						<div class="profile__img" 
						     style="background-image: url({{ imageThumb(($user->avatar ? $user->avatar : $user->image), 'uploads/users', 400, 300, 'universities') }});">
							<div class="actions__upload_photo" onclick="$('input.avatar__fileimage').click()">
								<span class="btn-file">
								    <i class="fa fa-file-image-o" aria-hidden="true"></i> 
								</span>
								<input type="file" class="avatar__fileimage" name="image" onchange="profilePhoto(this)"> 
								<input type="hidden" name="avatar" id="avatar">  
							</div>

							<div class="preloader__image_content" style="display: none;">
								<div class="loader-inner ball-pulse"> 
	            					<div></div> 
	            					<div></div> 
	            					<div></div> 
            					</div>
							</div>
						</div>
						<div id="error-respond"></div>
					</form> 
				</div> 
				<div class="col-lg-9">
					<span class="teacher_type">Учебное заведение</span>
					<h1>{{ $user['university']['full_name'] }}</h1>
					@if(Auth::user()->data_filled == 0)  
						<div class="data_coverage">
							<a href="{{ route(userRoute('user_edit')) }}" class="btn edit_profile">Публиковать профиль</a>
							<span>Для того, чтобы Вы появились в разделе репетиторов, </br>
							вам нужно подробно заполнить свой профиль</span>
						</div>
					@else
						<div class="data_coverage">
							<a href="{{ route(userRoute('user_edit')) }}" class="btn edit_profile">Личные данные</a>
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				@if(Auth::user()->data_filled == 1)
                <ul class="nav lk_menu">
                    @if(Auth::user()->data_filled == 1)
			      	<li class="{{ isActive(route(userRoute('user_profile'))) ? 'active' : '' }}">
			      		<a href="{{ route('university_user_profile') }}">МОИ КУРСЫ (ОБУЧАЮ) ({{ count(Auth::user()->courses) }})</a>
			      	</li> 
					
					<li class="{{ isActive(route(userRoute('user_teachers'))) ? 'active' : '' }}">
			      		<a href="{{ route(userRoute('user_teachers')) }}">ПРЕПОДАВАТЕЛИ ({{ count(Auth::user()->connectionTeachers) }})</a>
			      	</li>  

			      	<li class="{{ isActive(route(userRoute('user_faculties'))) ? 'active' : '' }}">
			      		<a href="{{ route(userRoute('user_faculties')) }}">Факультеты ({{ count(Auth::user()->university->faculties) }})</a>
			      	</li> 

			      	<li class="{{ isActive(route(userRoute('user_news'))) ? 'active' : '' }}">
			      		<a href="{{ route(userRoute('user_news')) }}">Новости ({{ count(Auth::user()->university->news) }})</a>
			      	</li> 
					@endif
                </ul>
				@endif
			</div>
		</div>
	</div> 

	<div class="container"> 
		<div class="row">
			 
			<div class="col-md-12">   
				@if(Session::has('flash_message') or Session::has('error_flash_message'))
					@php
						$message = @Session::has('flash_message') ? @Session::get('flash_message') : @Session::get('error_flash_message');
						$status  = @Session::has('flash_message') ? 'alert-success' : 'alert-danger';
					@endphp
				    <div class="alert {{ $status }}">
				    	<p>{{ $message }}</p>
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