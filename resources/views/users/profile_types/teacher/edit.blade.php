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
		<p class="title_desc">Укажите актуальные данные о вас. Введите ФИО, краткую информацию, укажите дату рождения, пол, город и образование. Не забудьте заполнить контактные и регистрационные данные. На вкладке «Я репетитор» укажите данные о вашем репетиторском опыте, выберите предметную область и варианты проведения занятий. Откройте вкладку «Сертификат/Диплом», чтобы загрузить изображения имеющихся у вас дипломов и сертификатов.</p>
	</div>
	<div class="col-lg-12">
		<ul class="nav nav-tabs user_edit">
			<li class="{{ isActive(route(userRoute('user_edit'))) ? 'active' : '' }}">
				<a data-toggle="tab" href="{{ route(userRoute('user_edit')) }}"> О Вас </a>
			</li>
			<li class="{{ isActive(route(userRoute('user_edit_tutor'))) ? 'active' : '' }}">
				<a data-toggle="tab" href="{{ route(userRoute('user_edit_tutor')) }}"> Я репетитор </a>
			</li>
			<li class="{{ isActive(route(userRoute('user_edit_certificates'))) ? 'active' : '' }}">
				<a data-toggle="tab" href="{{ route(userRoute('user_edit_certificates')) }}"> Сертификат/Диплом </a>
			</li>
		</ul>
	</div>
	<div class="row">
		@yield('edit_form')
	</div> 

</div>
<div class="clearfix"></div> 
</div>

@stop