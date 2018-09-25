@extends('users.profile_types.university.edit')

@section('edit_form')  
	<form class="ajax__submit has--preload listener__change_form univ__form_hc" method="POST" action="{{ route(userRoute('update_general')) }}">
	    {{ csrf_field() }} 
	    <input type="hidden" name="redirectUri" id="redirectUri">
		<div class="col-lg-8 col-lg-offset-2 user_form"> 
			 
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
	                        <option {{ ($userUniversity->status == '2') ? 'selected' : '' }} value="2">Коммерческий</option>
	                    </select>
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-md-4 control-label">СРЕДНЯЯ СТОИМОСТЬ ОБУЧЕНИЯ (₽)<span class="req">*</span>
				<p>Укажите, примерную стоимость обучения в год</p>
				</label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control number_field price__input" value="{{ $userUniversity->price }}" name="price" type="text">
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-md-4 control-label">КОЛИЧЕСТВО МЕСТ НА БЮДЖЕТНОЙ ОСНОВЕ
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
						<input class="form-control number_field" min="0" max="100" value="{{ $userUniversity->budget_points_admission }}" name="budget_points_admission" type="text">
					</div>
				</div>
				<div class="clearfix"></div>
				<label class="col-md-4 control-label">ПЛАТНАЯ ОСНОВА<span class="req">*</span>
				<p>Укажите среднее количество баллов для поступления</p>
				</label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" min="0" max="100" value="{{ $userUniversity->payable_points_admission }}" name="payable_points_admission" type="text">
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-12">
					<h3 class="header_blok_user">ВАША СПЕЦИАЛИЗАЦИЯ <span class="req">*</span></h3>
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
	  
			<div class="col-lg-12">
				<div id="error-respond"></div>
				<button type="submit" class="btn btn_save"> 
					@if($user->univ_general_filled)
	                    Сохранить
	                @else
	                    Далее
	                @endif 
				</button>
			</div> 
		</div>
	</form>
@stop