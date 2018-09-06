@extends('layouts.app')

@section('content')  

<div class="no__home" style="margin-top: 50px;">
	<div class="container teacher_lk">
		<div class="top_lk">
			<div class="row">
				<div class="col-lg-3">

					<form class="form-horizontal ajax__submit profile__image_form" method="POST" action="{{ route('update_image') }}">
		    			{{ csrf_field() }}
						<div class="profile__img" style="background-image: url({{ imageThumb(($user->avatar ? $user->avatar : $user->image), 'uploads/users', 400, 300, 'universities') }});"> 
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
					<span class="teacher_type">Ученик</span>
					<h1>
						@php
							$nameExplode = explode(' ', $user['name']);
							echo $nameExplode[0] . '<br>'; unset($nameExplode[0]);
							echo implode(' ', $nameExplode);
						@endphp
					</h1>
					 
					<div class="data_coverage">
						<a href="{{ route(userRoute('user_edit')) }}" class="btn edit_profile">Личные данные</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12"> 
                <ul class="nav lk_menu"> 
			      	<li class="{{ isActive(route(userRoute('user_profile'))) ? 'active' : '' }}">
			      		<a href="{{ route(userRoute('user_profile')) }}">МОИ КУРСЫ (ОБУЧАЮСЬ)</a>
			      	</li> 

			      	<li class="{{ isActive(route(userRoute('user_favorites'))) ? 'active' : '' }}">
			      		<a href="{{ route(userRoute('user_favorites')) }}">Избранное</a>
			      	</li> 

                </ul> 
			</div>
		</div>
	</div> 

	<div class="container"> 
		<div class="row">
			<div class="col-md-12">
				<div style="min-height: 400px;">
					@include($include)  
				</div>
			</div>
		</div>
	</div>
</div>  
 
@stop