@extends('layouts.app')
@section('content')  
<div class="container no__home"> 
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			<ul class="breadcrumb">
			  <li><a href="/">Главная</a></li>
			  <li><a href="{{ route(userRoute('user_profile')) }}">Личный кабинет</a></li>
			  <li class="active">Редактировать информацию</li>
			</ul>
			<h1 class="title_page">РЕДАКТИРОВАТЬ ПРОФИЛЬ</h1>
			<p class="title_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget.</p>
		</div>
		<div class="col-lg-12">
			<ul class="nav nav-tabs user_edit">
				<li class="{{ isActive(route(userRoute('user_edit'))) ? 'active' : '' }}">
					<a data-toggle="tab" href="#profile" onclick="window.location='{{ route(userRoute('user_edit')) }}'">Профиль ВУЗА</a>
				</li>
				<li class="{{ isActive(route(userRoute('user_general_edit'))) ? 'active' : '' }}">
					<a data-toggle="tab" href="#information" onclick="window.location='{{ route(userRoute('user_general_edit')) }}'">Общая информация</a>
				</li>
				<li class="{{ isActive(route(userRoute('user_certificates_edit'))) ? 'active' : '' }}">
					<a data-toggle="tab" href="#certificate" onclick="window.location='{{ route(userRoute('user_certificates_edit')) }}'"> Сертификат/Диплом </a>
				</li>
			</ul>
		</div>
		@yield('edit_form')  
	</div>
	<div class="clearfix"></div>
</div> 

@stop