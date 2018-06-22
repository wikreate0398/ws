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
				<a data-toggle="tab" href="#panel1"> О Вас </a>
			</li>
			<li>
				<a data-toggle="tab" href="#panel2"> Я репетитор </a>
			</li>
			<li>
				<a data-toggle="tab" href="#panel3"> Сертификат/Диплом </a>
			</li>
		</ul>
	</div> 

	<form class="ajax__submit" method="POST" action="{{ route(userRoute('update_profile')) }}">
    {{ csrf_field() }}
    <input type="hidden" name="user_type" value="2">
	<div class="col-lg-8 col-lg-offset-2" style="min-height: 300px;">
		<div class="tab-content user_form">
			<div id="panel1" class="tab-pane fade in active">
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
	                           class="form-control datepicker_birthdate ll-skin-melon" 
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
			</div>
			<div id="panel2" class="tab-pane fade">
				<div class="row">
					<div class="col-md-12">
						<h3 class="header_blok_user">Я умею учить</h3>
					</div>
				</div>
				
				<div class="row">
					<label class="col-md-4 control-label">СТЕПЕНЬ ВАШЕГО ОПЫТА <span class="req">*</span></label>
					<div class="col-md-8">
						<div class="form-group select_form">
							<select class="form-control" name="grade_experience">
							  <option value="">Выбрать</option> 
							  	@foreach($degree_experience as $item)
	                           		<option {{ ($user['grade_experience'] == $item->id) ? 'selected' : '' }} value="{{$item->id}}">
	                           			{{$item->name}}
	                           		</option>
	                        	@endforeach  
							</select>
						</div>
					</div>
				</div>
				
				<div class="row">
					<label class="col-md-4 control-label">ОПЫТ РАБОТЫ УЧИТЕЛЕМ С <span class="req">*</span></label>
					<div class="col-md-8">
						<div class="form-group">
							<input class="form-control datepicker_birthdate ll-skin-melon" 
							       name="experience_from" 
							       value="{{ !empty($user->experience_from) ? date('d.m.Y', strtotime($user->experience_from)) : '' }}"  
							       autocomplete="off"
							       type="text">
						</div>
					</div>
				</div>
				
				<div class="row">
					<label class="col-md-4 control-label">СРЕДНЯЯ СТОИМОСТЬ ЧАСА (₽) <span class="req">*</span></label>
					<div class="col-md-8">
						<div class="form-group">
							<input class="form-control number__field price__input" name="price_hour" value="{{ $user->price_hour }}" type="text">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<h3 class="header_blok_user">Ваша специализация <span class="req">*</span></h3>
					</div>
				</div>
			 
				<div class="row">
					<div class="col-md-12">
						<div class="form-group"> 
						@php
							$teacher_specializations = array_map(function ($item) {
							    return $item['id_specialization'];
							}, $teacher_specializations->toArray());    
						@endphp
						@foreach($specializations_list as $specialization)
							<label class="checkbox-inline">
								<input type="checkbox" 
								       {{ in_array($specialization->id, $teacher_specializations) ? 'checked' : '' }}
								       name="specializations[{{ $specialization->id }}]" 
								       id="specialization{{ $specialization->id }}"> {{ $specialization->name }}
							</label>
						@endforeach 
						</div>
					</div>
				</div>
			  
				<div class="row">
					<div class="col-md-12">
						<h3 class="header_blok_user">Ваша предметная область <span class="req">*</span></h3>
					</div> 
				</div> 

				<div class="row">
					<label class="col-md-4 control-label">Направления <span class="req">*</span></label>
					<div class="col-md-8">
						<div class="form-group teacher_direction_inner"> 
							<select name="" class="form-control" onchange="teacherDirections(this)">
								<option value="0">Выбрать</option>
								@php
									$teacherDirectionId = $user->direction->pluck('id')->toArray(); 
								@endphp
								@foreach($categories as $direction) 
									@php
										$disabled = '';
										if(in_array($direction['id'], $teacherDirectionId)){
											$disabled = 'disabled';
										}
									@endphp
									<option {{ $disabled }} value="{{ $direction['id'] }}">{{ $direction['name'] }}</option>
								@endforeach
							</select>  

							<div class="selected__teacher_labels" style="{{ !count($user->direction) ? 'display: none;' : ''  }}">
								@if(count($user->direction))
									@foreach($user->direction as $direction)
										<span id="teacher_label_{{ $direction->id }}" 
											  data-id="{{ $direction->id }}">
											<div class="subject_tag"> 
												{{ $direction->name }} 
											</div>
											<div onclick="deleteTeacherDirection({{ $direction->id }}, '.teacher_direction_inner');" 
												 class="delete__subject">
												<i class="fa fa-times" aria-hidden="true"></i>
											</div>
										</span>
									@endforeach
								@endif
							</div>
							<div class="selected__teacher_inputs">
								@if(count($user->direction))
									@foreach($user->direction as $direction)
										<input type="hidden" id="teacher_subjects_input_{{ $direction->id }}" value="{{ $direction->id }}" name="teacher_directions[]">
									@endforeach
								@endif
							</div> 
						</div>
					</div> 
				</div> 
				
				<div class="subjects__form-group row" style="{{ !count($user->subjects) ? 'display: none;' : ''  }}"> 
					<label class="col-md-4 control-label">Предметы <span class="req">*</span></label>
					<div class="col-md-8">
						<div class="form-group teacher_subjects_inner"> 
							<select name="" class="form-control select2" onchange="teacherSubjects(this)" style="width: 100%;"> 
								<option value="0">Выбрать</option> 
								@if(count($user->direction))
									@php
										$teacherSubjectsId = $user->subjects->pluck('id')->toArray(); 
									@endphp

									@foreach($user->direction as $direction)
										@if(!empty($categories[$direction['id']]['childs']))
											@foreach($categories[$direction['id']]['childs'] as $subject) 
												@php
													$disabled = '';
													if(in_array($subject['id'], $teacherSubjectsId)){
														$disabled = 'disabled';
													}
												@endphp 
												<option {{ $disabled }} data-parent="{{ $direction['id'] }}" 
												        value="{{ $subject['id'] }}">{{ $subject['name'] }}</option>
											@endforeach
										@endif 
									@endforeach
								@endif
							</select>  

							<div class="selected__teacher_labels" style=" {{ !count($user->subjects) ? 'display: none;' : ''  }}">
								@if(count($user->subjects))
									@foreach($user->subjects as $subject)
										<span id="teacher_label_{{ $subject->id }}" 
											  data-parent="{{ $subject->pivot->id_direction }}" 
											  data-id="{{ $subject->id }}">
											<div class="subject_tag"> 
												{{ $subject->name }} 
											</div>
											<div onclick="deleteTeacherSubject({{ $subject->id }}, 'teacher_subjects_inner');" 
												 class="delete__subject">
												<i class="fa fa-times" aria-hidden="true"></i>
											</div>
										</span>
									@endforeach
								@endif
							</div>
							<div class="selected__teacher_inputs">
								@if(count($user->subjects)) 
									@foreach($user->subjects as $subject)
										<input type="hidden" 
										       data-parent="{{ $subject->pivot->id_direction }}" 
										       id="teacher_subjects_input_{{ $subject->id }}" 
										       value="{{ $subject->id }}" 
										       name="teacher_subjects[{{ $subject->pivot->id_direction }}][]">
									@endforeach
								@endif
							</div> 
						</div>
					</div>  
				</div> 
				<script>  
					var categories = JSON.parse("<?=prepareArrayForJson($categories)?>"); 
				</script>

				<div class="row">
					<div class="col-md-12">
						<h3 class="header_blok_user">Варианты проведения занятий <span class="req">*</span></h3>
					</div> 
					<div class="col-md-12"> 
						<div class="form-group"> 
							@php
								$teacher_lesson_options = $user->lesson_options->pluck('id')->toArray() ;  
							@endphp
							@foreach($lesson_options_list as $lesson_option)
								<label class="checkbox-inline">
									<input type="checkbox" 
										   {{ in_array($lesson_option->id, $teacher_lesson_options) ? 'checked' : '' }}
									       name="lesson_options[{{ $lesson_option->id }}]" 
									       id="lesson_options_list{{ $lesson_option->id }}"> {{ $lesson_option->name }}
								</label>
							@endforeach 
						</div>
					</div>
				</div>
			 
				<div class="row">
					<label class="col-md-4 control-label">
						Адрес на дому
						<p>Укажите адрес если занятия могут проходить у вас на дому</p>
					</label>
					<div class="col-md-8">
						<div class="form-group">
							<textarea class="form-control" name="lesson_place" autofocus="">{{ $user->lesson_place }}</textarea>

						</div>
					</div>
				</div>
				 
			</div>
			<div id="panel3" class="tab-pane fade">
                
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
</div>
<div class="clearfix"></div> 
</div>

@stop