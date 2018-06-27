@extends('users.profile_types.teacher.edit')

@section('edit_form')  
<form class="ajax__submit" method="POST" action="{{ route(userRoute('user_update_tutor')) }}">
    {{ csrf_field() }}
 
	<div class="col-lg-8 col-lg-offset-2" style="min-height: 300px;">
		<div class="user_form">
		 
				<div class="row">
					<div class="col-md-12">
						<h3 class="header_blok_user">Я умею учить</h3>
					</div>
				</div>
				
				<div class="row">
					<label class="col-md-4 control-label">СТЕПЕНЬ ВАШЕГО ОПЫТА</label>
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
					<label class="col-md-4 control-label">ОПЫТ РАБОТЫ УЧИТЕЛЕМ С </label>
					<div class="col-md-8">
						<div class="form-group">
							<input class="form-control datepicker_birthdate datepicker__input ll-skin-melon" 
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
							<select name="teacher_directions_select" class="form-control" onchange="teacherDirections(this)">
								<option value="">Выбрать</option>
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
							<select name="teacher_subjects_select" class="form-control select2" onchange="teacherSubjects(this)" style="width: 100%;"> 
								<option value="">Выбрать</option> 
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
							<textarea class="form-control" name="lesson_place">{{ $user->lesson_place }}</textarea> 
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