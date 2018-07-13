@extends('users.profile_types.teacher.edit')

@section('edit_form')  
<form class="ajax__submit has--preload listener__change_form teacher__form_hc" method="POST" action="{{ route(userRoute('user_update_general')) }}">
   	
   	  
    {{ csrf_field() }}
 	<input type="hidden" name="redirectUri" id="redirectUri">
	<div class="col-lg-8 col-lg-offset-2" style="min-height: 300px;">
		<div class="user_form"> 
			<div class="row">
				<div class="col-md-12">
					<h3 class="header_blok_user">Общий профиль</h3>
				</div>
			</div>
			
			<div class="row">
				<label class="col-md-4 control-label">ВАШЕ ФИО <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" value="{{ $user->name }}" name="name" type="text">
					</div>
				</div>
			</div>

			<div class="row">
				<label class="col-md-4 control-label">КОРОТКО  О ВАС <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<textarea class="form-control" maxlength="1200" name="about">{{ $user->about }}</textarea>
						<div class="maxlength__label"><span>0</span> символов (1200 максимум)</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<label class="col-md-4 control-label">ДАТА РОЖДЕНИЯ <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group"> 
						<input type="text" 
                           class="form-control datepicker_birthdate datepicker__input ll-skin-melon" 
                           name="date_birth"
                           value="{{ !empty($user->date_birth) ? date('d.m.Y', strtotime($user->date_birth)) : '' }}"  
                           autocomplete="off"
                           placeholder="ДД.ММ.ГГГГ"> 
					</div>
				</div>
			</div>
			
			<div class="row">
				<label class="col-md-4 control-label">ВАШ ПОЛ <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<label class="radio-inline">
						  <input type="radio" name="sex" {{ ($user->sex=='female') ? 'checked' : '' }} id="inlineRadio1" value="female"> Женский
						</label>
						<label class="radio-inline">
						  <input type="radio" name="sex" {{ ($user->sex=='male') ? 'checked' : '' }} id="inlineRadio2" value="male"> Мужской
						</label>
					</div>
				</div>
			</div>

			<div class="row">
				<label class="col-md-4 control-label">Расположение <span class="req">*</span></label>  
				<div class="col-md-8"> 
					<div class="row">
						<div class="col-md-6 regions__area">
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
						<div class="col-md-6 cities__area" style="display: none;"></div> 
					</div>
				</div>
			</div>

			<script>
            	$(window).load(function(){ $('select#select__regions').change(); });
            </script>

			<div class="row">
				<div class="col-md-12">
					<h3 class="header_blok_user">Мое образование</h3>
				</div>
			</div>

			<div class="row">
				<label class="col-md-4 control-label">ГДЕ ВЫ УЧИЛИСЬ?</label>
				<div class="col-md-8">
					@if(count($user->educations))
						<?php $i=0; ?>
						@foreach($user->educations as $education) 
							<div class="row multi__container education__container {{ ($i == 0) ? 'first_block' : '' }}">
								@if($i > 0)
				                    <a class="close__item delete__item" href="{{ route(userRoute('delete_education'), ['id' => $education->id]) }}">X</a> 
				                @endif
								@include('users.profile_types.teacher.partials.grade_education')
							</div> 
							<?php $i++ ?>
						@endforeach
					@else
						<div class="row multi__container education__container first_block">
							@include('users.profile_types.teacher.partials.grade_education')		
						</div> 
					@endif  

					<button class="btn btn-sm btn-dafault add__more" 
					        onclick="addBlock('education__container');" 
					        type="button">
					    + Добавить еще
					</button> 
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<h3 class="header_blok_user">Контактные данные</h3>
				</div>
			</div>
			<div class="row">
				<label class="col-md-4 control-label">АДРЕС <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" name="address" value="{{ $user->address }}" type="text">
					</div>
				</div>
			</div>
			<div class="row">
				<label class="col-md-4 control-label">ТЕЛЕФОН <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" name="phone" value="{{ $user->phone }}" type="text">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h3 class="header_blok_user">Регистрационные данные</h3>
				</div>
			</div>
			<div class="row">
				<label class="col-md-4 control-label">E-MAIL <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" name="email" value="{{ $user->email }}" type="text">
					</div>
				</div>
			</div>
			<div class="row">
				<label class="col-md-4 control-label">СТАРЫЙ ПАРОЛЬ <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" autocomplete="off" name="old_password" value="" type="password">
					</div>
				</div>
			</div>
			<div class="row">
				<label class="col-md-4 control-label">ПАРОЛЬ <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" autocomplete="off" name="password" value="" type="password">
					</div>
				</div>
			</div>
			<div class="row">
				<label class="col-md-4 control-label">ПОВТОРИТЕ ПАРОЛЬ <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" autocomplete="off" name="password_confirmation" value="" type="password">
					</div>
				</div>
			</div> 
			 
			<div class="row">
				<div id="error-respond"></div>
		        <div class="col-md-12 ">
		            <button type="submit" class="btn btn_save" style="width: auto;">
		                Сохранить
		            </button>
		        </div>
			</div> 
		</div> 
	</div>
	 
</form>
@stop