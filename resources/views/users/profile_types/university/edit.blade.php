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
			<p class="title_desc">Укажите информацию о вашем учебном заведении. Заполните общий профиль, введя название, краткое описание, дату основания и город. Также укажите контактные данные ВУЗа. На вкладке «Общая информация» выберите тип ВУЗа, стоимость обучения, количество бюджетных мест и доступные специальности. На вкладке «Сертификаты/Дипломы» загрузите изображения соответствующих документов: лицензии, сертификаты и грамоты.</p>
		</div>
		<div class="col-lg-12">
			<ul class="nav nav-tabs user_edit">
				<li class="{{ isActive(route(userRoute('user_edit'))) ? 'active' : '' }}">
					<a data-toggle="tab" href="{{ route(userRoute('user_edit')) }}">Профиль ВУЗА</a>
				</li>
				<li class="{{ isActive(route(userRoute('user_general_edit'))) ? 'active' : '' }} {{ !$user->univ_profile_filled ? 'disabled' : '' }}">
					<a data-toggle="tab" href="{{ route(userRoute('user_general_edit')) }}">Общая информация</a>
				</li>
				<li class="{{ isActive(route(userRoute('user_certificates_edit'))) ? 'active' : '' }} {{ (!$user->univ_profile_filled or !$user->univ_general_filled) ? 'disabled' : '' }}">
					<a data-toggle="tab" href="{{ route(userRoute('user_certificates_edit')) }}"> Сертификат/Диплом </a>
				</li>
			</ul>
		</div>
		@yield('edit_form')  
	</div>
	<div class="clearfix"></div>
</div> 

@stop