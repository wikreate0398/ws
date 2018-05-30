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
			<li class="active">
				<a data-toggle="tab" href="#profile">Профиль ВУЗА</a>
			</li>
			<li>
				<a data-toggle="tab" href="#information">Общая информация</a>
			</li>
			<li>
				<a data-toggle="tab" href="#certificate"> Сертификат/Диплом </a>
			</li>
		</ul>
	</div>

	<form class="ajax__submit" method="POST" action="{{ route(userRoute('update_profile')) }}">
    {{ csrf_field() }}
    <input type="hidden" name="user_type" value="3">

	<div class="col-lg-8 col-lg-offset-2">
		<div class="tab-content user_form">
			<div id="profile" class="tab-pane fade in active">
				<div class="col-md-12">
					<h3 class="header_blok_user">Общий профиль</h3>
				</div>
				<label class="col-md-4 control-label">НАЗВАНИЕ ВУЗА <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" value="{{ $userUniversity['full_name'] }}" name="name" type="text">
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-md-4 control-label">КОРОТКО  О ВУЗе <span class="req">*</span>
				<p>Кратко опишите преимущества вашего ВУЗа</p>
				</label>
				<div class="col-md-8">
					<div class="form-group">
						<textarea class="form-control" maxlength="800" name="description">{{ $user['about'] }}</textarea>
						<div class="maxlength__label"><span>0</span> символов (800 максимум)</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-md-4 control-label">ДАТА ОСНОВАНИЯ <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control datepicker" autocomplete="off" name="year_of_foundation" value="{{ !empty($userUniversity->year_of_foundation) ? date('d.m.Y', strtotime($userUniversity->year_of_foundation)) : '' }}" type="text">
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-md-4 control-label">ГОРОД <span class="req">*</span>
				<p>Укажите город, в котором распологается основной филиал Вашего ВУЗа</p>
				</label>
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12 regions__area">
							<div class="form-group select_form">
								<select class="form-control select2" id="select__regions" onchange="loadRegionCities(this, '{{ $user['city'] }}')" name="region">
								  	<option value="">Область</option>
								  	@foreach($regions as $item)
		                           		<option {{ ($user['region'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">
		                           			{{$item['name']}}
		                           		</option>
		                        	@endforeach
								</select>
							</div>
						</div>
						<div class="cities__area col-md-6" style="display: none;"></div> 
					</div>
				</div> 
				<script>
	            	$(window).load(function(){ $('select#select__regions').change(); });
	            </script> 

				<div class="clearfix"></div>
				<div class="col-md-12">
					<h3 class="header_blok_user">КОНТАКТНЫЕ ДАННЫЕ</h3>
				</div>
				<label class="col-md-4 control-label">АДРЕС ВУЗА<span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" value="{{ $user['address'] }}" name="address" type="text">
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-md-4 control-label">АДРЕС САЙТА<span class="req"></span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" value="{{ $user['site'] }}" name="site" type="text">
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-md-4 control-label">ТЕЛЕФОН<span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" value="{{ $user['phone'] }}" name="phone" type="text">
					</div>
					<div class="form-group">
						<input class="form-control" value="{{ $user['phone2'] }}" name="phone2" type="text">
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-12">
					<h3 class="header_blok_user">РЕГИСТРАЦИОННЫЕ ДАННЫЕ</h3>
				</div>
				<label class="col-md-4 control-label">E-MAIL<span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" value="{{ $user['email'] }}" autocomplete="off" name="email" type="text">
					</div>
				</div> 
				<label class="col-md-4 control-label">СТАРЫЙ ПАРОЛЬ <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" autocomplete="off" name="old_password" value="" type="password">
					</div>
				</div>
				<label class="col-md-4 control-label">ПАРОЛЬ<span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" autocomplete="off" name="password" type="password">
					</div>
				</div>
				<label class="col-md-4 control-label">ПОВТОРИТЕ ПАРОЛЬ<span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" autocomplete="off" name="password_confirmation" type="password">
					</div>
				</div>
			</div>
			<div id="information" class="tab-pane fade">
				<div class="col-md-12">
					<h3 class="header_blok_user">РЕГИСТРАЦИОННЫЕ ДАННЫЕ</h3>
				</div>
				<label class="col-md-4 control-label">ТИП ВУЗА<span class="req">*</span>
				<p>Укажите, в каком городе вы расположены, и где преподаете</p>
				</label>
				<div class="col-md-8">
					<div class="form-group select_form">
						<select name="status" class="form-control">
	                        <option value="">Выбрать</option>
	                        <option {{ ($userUniversity->status == '1') ? 'selected' : '' }} value="1">Государвственное</option>
	                        <option {{ ($userUniversity->status == '2') ? 'selected' : '' }} value="2">Негосударвственное</option>
	                    </select>
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-md-4 control-label">СРЕДНЯЯ СТОИМОСТЬ ОБУЧЕНИЯ (₽)<span class="req">*</span>
				<p>Укажите, примерную стоимость обучения в год</p>
				</label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control number_field" value="{{ $userUniversity->price }}" name="price" type="text">
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-md-4 control-label">КОЛИЧЕСТВО МЕСТ НА БЮДЖЕТНОЙ ОСНОВЕ<span class="req">*</span>
				</label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control number_field" value="{{ $userUniversity->qty_budget }}" name="qty_budget" type="text">
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-12">
					<h3 class="header_blok_user">СРЕДНИЙ БАЛ ДЛЯ ПОСТУПЛЕНИЯ</h3>
				</div>
				<label class="col-md-4 control-label">БЮДЖЕТНАЯ ОСНОВА<span class="req">*</span>
				<p>Укажите среднее количество баллов для поступления</p>
				</label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control number_field" value="{{ $userUniversity->budget_points_admission }}" name="budget_points_admission" type="text">
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-md-4 control-label">ПЛАТНАЯ ОСНОВА<span class="req">*</span>
				<p>Укажите среднее количество баллов для поступления</p>
				</label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" value="{{ $userUniversity->payable_points_admission }}" name="payable_points_admission" type="text">
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-12">
					<h3 class="header_blok_user">ВАША СПЕЦИАЛИЗАЦИЯ</h3>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<ul class="list-inline list_checkbox">	
							@php
								$university_specializations = array_map(function ($item) {
								    return $item['id_specialization'];
								}, $university_specializations->toArray());    
							@endphp
							@foreach($specializations as $specialization)
								<li>
									<div class="checkbox">
									<label>
										<input {{ in_array($specialization->id, $university_specializations) ? 'checked' : '' }} name="specializations[{{ $specialization->id }}]" type="checkbox">
										<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
										{{ $specialization['name'] }}
									</label>
									</div>
								</li> 
                        	@endforeach
						</ul>
					</div>
				</div>
				<div class="col-md-12">
					<h3 class="header_blok_user">НАЛИЧИЕ ИНФРАСТРУКТУРЫ И ВОЕННОЙ КАФЕДРЫ</h3>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<ul class="list-inline list_checkbox">	
							<li>
								<div class="checkbox">
								<label>
									<input name="has_military_department" {{ ($userUniversity['has_military_department'] == '1') ? 'checked' : '' }} type="checkbox">
									<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
									Военная кафедра
								</label>
								</div>
							</li>
							<li>
								<div class="checkbox">
								<label>
									<input name="has_hostel" {{ ($userUniversity['has_hostel'] == '1') ? 'checked' : '' }} type="checkbox">
									<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
									Общежитие
								</label>
								</div>
							</li>
							<li>
								<div class="checkbox">
								<label>
									<input name="distance_learning" {{ ($userUniversity['distance_learning'] == '1') ? 'checked' : '' }} type="checkbox">
									<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
									Дистанционное обучение
								</label>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div id="certificate" class="tab-pane fade">
				<div id="certificates__images" class="row uploaderContainter" style="margin-bottom: 40px;">
 
            		@foreach($user->certificates as $certificate)
						<div class='col-md-4 load-thumbnail'> 
    		            	 
    		            	<div class="uploadedImg" 
    		            	     style="background-image: url(/public/uploads/users/certificates/{{ $certificate->image }})"></div>
    		            	<div class='actions__upload_img'>
    		            		<span onclick='deleteUploadImg(this, {{ $certificate->id }})' class="delete__upload_img"></span> 
                            </div>
        		     	</div>
					@endforeach
                	 
					<div class="col-md-4 {{ !count($user->certificates) ? 'col-md-offset-4' : ''}}">
						<div class="certificateLoadArea">
							<input type="file" 
						       name="diploms[]" 
						       multiple 
						       id="certificateInpuT" 
						       onchange="multipleImages(this, '#certificates__images')">
						     <span class="file__input_name"> Добавить или перетащить <br> сюда изображение</span>
						</div>
					</div>
                	 
				</div>  
			</div>
			<div class="col-lg-12">
				<div id="error-respond"></div>
				<button type="submit" class="btn btn_save">
					Сохранить
				</button>
			</div>
		</div>
	</div>
	</form>
</div>
<div class="clearfix"></div>
 
</div> 

@stop