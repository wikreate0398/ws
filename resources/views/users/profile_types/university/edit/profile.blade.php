@extends('users.profile_types.university.edit')

@section('edit_form')  
	<form class="ajax__submit has--preload listener__change_form univ__form_hc" method="POST" action="{{ route(userRoute('update_profile')) }}">
	    {{ csrf_field() }} 
	    <input type="hidden" name="redirectUri" id="redirectUri">
		<div class="col-lg-8 col-lg-offset-2 user_form"> 
			 
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
					<input class="form-control datepicker_birthdate datepicker__input" autocomplete="off" name="year_of_foundation" value="{{ !empty($userUniversity->year_of_foundation) ? date('d.m.Y', strtotime($userUniversity->year_of_foundation)) : '' }}" type="text">
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
							<select class="form-control select2 onload__change" id="select__regions" onchange="loadRegionCities(this, '{{ $user['city'] }}')" name="region">
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
			</div>
			<div class="clearfix"></div>
			<label class="col-md-4 control-label">Отделы</label>
			<div class="col-md-8">
				@if(count($user->universityDepartment))
                    <?php $i=0; ?>
					@foreach($user->universityDepartment as $department)
						<div class="row multi__container education__container {{ ($i == 0) ? 'first_block' : '' }}">
							@if($i > 0)
								<a class="close__item delete__item" href="{{ route(userRoute('delete_department'), ['id' => $department->id]) }}">X</a>
							@endif
							@include('users.profile_types.university.partials.department')
						</div>
                        <?php $i++ ?>
					@endforeach
				@else
					<div class="row multi__container education__container first_block">
						@include('users.profile_types.university.partials.department')
					</div>
				@endif

				<button class="btn btn-sm btn-dafault add__more"
						onclick="addBlock('education__container');"
						type="button">
					+ Добавить еще
				</button>
			</div>
			<div class="clearfix"></div>
			<br>
			<label class="col-md-4 control-label">Месторасположение<span class="req">*</span></label>
			<div class="col-md-8">
				<div id="map"
					 data-name="{{ $user->university->full_name }}"
					 style="width: 100%; height: 400px"></div>
				<input type="hidden" id="placemark" name="placemark" value="{{ $user->university->placemark }}">
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
	  
			<div class="col-lg-12">
				<div id="error-respond"></div>
				<button type="submit" class="btn btn_save">
					@if($user->univ_profile_filled)
	                    Сохранить
	                @else
	                    Далее
	                @endif 
				</button>
			</div> 
		</div>
	</form>
@stop