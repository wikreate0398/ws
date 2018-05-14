<div class="row">
	<div class="col-lg-10 col-lg-offset-1">
		<ul class="breadcrumb">
		  <li><a href="#">Главная</a></li>
		  <li><a href="#">Личный кабинет</a></li>
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

	<form class="ajax__submit" method="POST" action="{{ route('update_profile') }}">
    {{ csrf_field() }}
    <input type="hidden" name="user_type" value="2">
	<div class="col-lg-8 col-lg-offset-2" style="min-height: 300px;">
		<div class="tab-content user_form">
			<div id="panel1" class="tab-pane fade in active">
				<div class="col-md-12">
					<h3 class="header_blok_user">Общий профиль</h3>
				</div>
				
				<label class="col-md-4 control-label">ВАШЕ ФИО <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" value="{{ $user->name }}" name="name" required type="text">
					</div>
				</div>
				<label class="col-md-4 control-label">КОРОТКО  О ВАС <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<textarea class="form-control" name="about" required autofocus="">{{ $user->about }}</textarea>
					</div>
				</div>
				<label class="col-md-4 control-label">ДАТА РОЖДЕНИЯ <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group"> 
						<input type="text" 
                           class="form-control datepicker" 
                           name="date_birth"
                           value="{{ !empty($user->date_birth) ? date('d-m-Y', strtotime($user->date_birth)) : '' }}" 
                           required 
                           placeholder="DD/MM/YY"> 
					</div>
				</div>
				<label class="col-md-4 control-label">ВАШ ПОЛ <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<label class="radio-inline">
						  <input type="radio" required name="sex" {{ ($user->sex=='female') ? 'checked' : '' }} id="inlineRadio1" value="female"> Женский
						</label>
						<label class="radio-inline">
						  <input type="radio" name="sex" {{ ($user->sex=='male') ? 'checked' : '' }} id="inlineRadio2" value="male"> Мужской
						</label>
					</div>
				</div>
				<label class="col-md-4 control-label">ГОРОД</label>
				<div class="col-md-4">
					<div class="form-group select_form">
						<select class="form-control" name="city">
							<option value="0">Город</option>
							@foreach($cities as $item)
                           		<option {{ ($user['city'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">{{$item['name']}}</option>
                        	@endforeach
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group select_form">
						<select class="form-control" name="region">
						  <option>Район города</option>
						</select>
					</div>
				</div>
				<div class="col-md-12">
					<h3 class="header_blok_user">Мое образование</h3>
				</div>
				<label class="col-md-4 control-label">ГДЕ ВЫ УЧИЛИСЬ? <span class="req">*</span></label>
				<div class="col-md-8">
					@if(count($usersEducations))
						<?php $i=0; ?>
						@foreach($usersEducations as $education) 
							<div class="row multi__container education__container {{ ($i == 0) ? 'first_block' : '' }}">
								@if($i > 0)
				                    <a class="close__item delete__item" href="/user/deleteUserEducation/<?=$education['id']?>">X</a>
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
				</div>

				<div class="col-md-12">
					<h3 class="header_blok_user">Контактные данные</h3>
				</div>
				<label class="col-md-4 control-label">АДРЕС <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" name="address" value="{{ $user->address }}" required type="text">
					</div>
				</div>
				<label class="col-md-4 control-label">ТЕЛЕФОН <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" name="phone" value="{{ $user->phone }}" required type="text">
					</div>
				</div>
				<div class="col-md-12">
					<h3 class="header_blok_user">Регистрационные данные</h3>
				</div>
				<label class="col-md-4 control-label">E-MAIL <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" name="email" value="{{ $user->email }}" required type="text">
					</div>
				</div>
				<label class="col-md-4 control-label">СТАРЫЙ ПАРОЛЬ <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" name="old_password" value="" type="password">
					</div>
				</div>
				<label class="col-md-4 control-label">ПАРОЛЬ <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" name="password" value="" type="password">
					</div>
				</div>
				<label class="col-md-4 control-label">ПОВТОРИТЕ ПАРОЛЬ <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" name="password_confirmation" value="" type="password">
					</div>
				</div>
			</div>
			<div id="panel2" class="tab-pane fade">
				<div class="col-md-12">
					<h3 class="header_blok_user">Я умею учить</h3>
				</div>
				<label class="col-md-4 control-label">СТЕПЕНЬ ВАШЕГО ОПЫТА <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group select_form">
						<select class="form-control" name="grade_experience">
						  <option>Студент педагогического вуза</option>
						</select>
					</div>
				</div>
				<label class="col-md-4 control-label">ОПЫТ РАБОТЫ УЧИТЕЛЕМ С <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control number_field" name="experience_from" value="{{ $user->experience_from }}" required="" type="text">
					</div>
				</div>
				<label class="col-md-4 control-label">СРЕДНЯЯ СТОИМОСТЬ ЧАСА <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<input class="form-control" name="price_hour" value="{{ $user->price_hour }}" required="" type="text">
					</div>
				</div>
				<div class="col-md-12">
					<h3 class="header_blok_user">Ваша специализация</h3>
				</div>
				<div class="col-md-12">
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
				 
				<div class="col-md-12">
					<h3 class="header_blok_user">Ваша предметная область</h3>
				</div>
				<label class="col-md-4 control-label">ПРЕДМЕТЫ <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						@php
							$teacher_subjects = array_map(function ($item) {
							    return $item['name'];
							}, $teacher_subjects->toArray());    
						@endphp
						<input class="form-control" 
						       name="teacher_subjects" 
						       value="{{ implode(', ', $teacher_subjects)  }}" 
						       required
						       type="text">
					</div>
				</div>
				<div class="col-md-12">
					<h3 class="header_blok_user">Варианты проведения занятий</h3>
				</div>
				<div class="col-md-12"> 
					@php
						$teacher_lesson_options = array_map(function ($item) {
						    return $item['id_lesson_option'];
						}, $teacher_lesson_options->toArray());    
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
				<label class="col-md-4 control-label">У ВАС (РЕПЕТИТОРА) НА ДОМУ <span class="req">*</span></label>
				<div class="col-md-8">
					<div class="form-group">
						<textarea class="form-control" value="" autofocus=""></textarea>
					</div>
				</div>
			</div>
			<div id="panel3" class="tab-pane fade">
				<div class="col-md-12">
					<h3 class="header_blok_user">Мои дипломы/сертификаты</h3>
					<input type="file" 
					       name="diploms[]" 
					       multiple 
					       id="exampleInputFile" 
					       onchange="multipleImages(this, '#certificates__images')">
					<div id="certificates__images" class="uploaderContainter">
						@foreach($certificates as $certificate)
							<div class='img-thumbnail'>
            		            <div class='actions__upload_img'>
            		            	<i onclick='deleteUploadImg(this, {{ $certificate->id }})' 
            		            	   class='fa fa-trash-o' 
            		            	   aria-hidden='true'></i>
                                </div>
        		            	<img class='uploadedImg' src='/public/uploads/users/certificates/{{ $certificate->image }}'> 
            		     	</div>
						@endforeach
					</div> 
				</div>
			</div>
		</div> 
	</div>
	<div class="col-lg-10 col-lg-offset-2">
		<div class="form-group">
	        <div class="col-md-12" id="error-respond"></div>
	        <div class="col-md-6 ">
	            <button type="submit" class="btn btn-primary btn-sm" style="width: auto;">
	                Сохранить
	            </button>
	        </div>
	    </div>
	</div>
	</form>
</div>
<div class="clearfix"></div>

<?php if (false): ?> 
 
<form class="form-horizontal ajax__submit" method="POST" action="{{ route('update_profile') }}">
    {{ csrf_field() }}
    <input type="hidden" name="user_type" value="2">
    <div class="row" style="padding-top:20px;">
        <div class="col-md-6">

            <div class="form-group">
                <label class="col-md-12 control-label">Имя <span class="req">*</span></label>
                <div class="col-md-12">
                    <input type="text" class="form-control" name="name" value="{{ $user->name }}"
                           required>
                </div>
            </div>
 
            <div class="form-group">
                <label class="col-md-12 control-label">Номер телефона <span class="req">*</span>

                </label>
                <div class="col-md-12">
                    <input  type="text" class="form-control" name="phone" value="{{ $user->phone }}"
                           required>
                </div>
            </div> 
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-12 control-label">Дата рождения <span class="req">*</span>

                </label>
                <div class="col-md-12">
                    <input type="text" 
                           class="form-control datepicker" 
                           name="date_birth"
                           value="{{ !empty($user->date_birth) ? date('d-m-Y', strtotime($user->date_birth)) : '' }}" 
                           required 
                           placeholder="DD/MM/YY">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-12 control-label">Сайт

                </label>
                <div class="col-md-12">
                    <input type="text" class="form-control" name="site" value="{{ $user->site }}">
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">ОБРАЗОВАНИЕ</h3>
        </div>
        <div class="panel-body">

            @if(count($usersEducations) > 0) 
            <?php $i=0; ?>
            @foreach($usersEducations as $education) 
            <div class="row multi__container education__container {{ ($i == 0) ? 'first_block' : '' }}"> 
                @if($i > 0)
                    <a class="close__item delete__item" href="/user/deleteUserEducation/<?=$education['id']?>">X</a>
                @endif

                <input type="hidden" class="id__block" name="edit_education[id][]" value="{{ $education['id'] }}">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="col-md-12 control-label">Время обучения <span class="req">*</span></label>
                        <div class="col-md-3">
                            <select name="edit_education[from][]"  class="form-control">
                                <option value="">С</option>
                                @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                    <option {{ ($education['from_year'] == $year) ? 'selected' : '' }} value="{{$year}}">{{$year}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="edit_education[to][]"  class="form-control">
                                <option value="">По</option>
                                @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                    <option {{ ($education['to_year'] == $year) ? 'selected' : '' }} value="{{$year}}">{{$year}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12 control-label">Образовательное
                            учреждение <span class="req">*</span>

                        </label>
                        <div class="col-md-12">
                            <input type="text" class="form-control"
                                   name="edit_education[institution][]" value="{{ $education['institution_name'] }}" required>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label  
                               class="col-md-12 control-label">Кафедра</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control"
                                   name="edit_education[department][]" value="{{ $education['department'] }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label  
                               class="col-md-12 control-label">Примечания</label>
                        <div class="col-md-12">
                            <textarea name="edit_education[notes][]" class="form-control" style="min-height: 120px;">{{ $education['notes'] }}</textarea> 
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12 control-label">Специальность <span class="req">*</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control"
                                   name="edit_education[specialty][]" value="{{ $education['specialty'] }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12 control-label">Степень <span class="req">*</span></label>
                        <div class="col-md-12">
                            <select name="edit_education[grade][]"  class="form-control">
                                <option value="">Выбрать</option>
                                @foreach($grade_education as $item)
                                    @if(!empty($item['childs']))
                                        <optgroup label="{{$item['name']}}">
                                            @foreach($item['childs'] as $child)
                                                <option {{ ($education['grade'] == $child['id']) ? 'selected' : '' }} value="{{$child['id']}}">{{$child['name']}}</option>
                                            @endforeach
                                        </optgroup>
                                    @else
                                        <option {{ ($education['grade'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">
                                            {{$item['name']}}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div> 
                </div>
            </div>
            <?php $i++ ?>
            @endforeach

            @else

            <div class="row multi__container education__container first_block"> 
                 
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="col-md-12 control-label">Время обучения <span class="req">*</span></label>
                        <div class="col-md-3">
                            <select name="education[from][]"  class="form-control">
                                <option value="">С</option>
                                @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                    <option value="{{$year}}">{{$year}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="education[to][]"  class="form-control">
                                <option value="">По</option>
                                @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                    <option value="{{$year}}">{{$year}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12 control-label">Образовательное
                            учреждение <span class="req">*</span>

                        </label>
                        <div class="col-md-12">
                            <input type="text" class="form-control"
                                   name="education[institution][]" value="" required>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label  
                               class="col-md-12 control-label">Кафедра</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control"
                                   name="education[department][]" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label  
                               class="col-md-12 control-label">Примечания</label>
                        <div class="col-md-12">
                            <textarea name="education[notes][]" class="form-control" style="min-height: 120px;"></textarea> 
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12 control-label">Специальность <span class="req">*</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control"
                                   name="education[specialty][]" value="" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12 control-label">Степень <span class="req">*</span></label>
                        <div class="col-md-12">
                            <select name="education[grade][]"  class="form-control">
                                <option value="">Выбрать</option>
                                @foreach($grade_education as $item)
                                    @if(!empty($item['childs']))
                                        <optgroup label="{{$item['name']}}">
                                            @foreach($item['childs'] as $child)
                                                <option value="{{$child['id']}}">{{$child['name']}}</option>
                                            @endforeach
                                        </optgroup>
                                    @else
                                        <option value="{{$item['id']}}">
                                            {{$item['name']}}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div> 
                </div>
            </div>

            @endif

            <div class="row">
                <div class="col-md-12">
                    <button type="button" onclick="addBlock('education__container');" class="btn btn-sm btn-dafault add__more">Добавить еще</button>
                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading" style="justify-content: space-between; display: flex; align-items: center;">
            <h3 class="panel-title">Преподовательская деятельность</h3>
            <input type="checkbox" {{ (count($usersTeachingActivities) > 0) ? 'checked' : '' }} class="disable_block" onclick="disableBlock(this);">
        </div>
        <div class="panel-body">
            @if(count($usersTeachingActivities) > 0) 
                <?php $i=0; ?>
                @foreach($usersTeachingActivities as $activities) 
                <div class="row multi__container teach_activity_container {{ ($i == 0) ? 'first_block' : '' }}">
                    @if($i > 0)
                        <a class="close__item delete__item" href="/user/deleteUserActivities/<?=$activities['id']?>">X</a> 
                    @endif
                    <input type="hidden" class="id__block" name="edit_teach_activity[id][]" value="{{ $activities['id'] }}">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Время работы <span class="req">*</span></label>
                            <div class="col-md-3">
                                <select name="edit_teach_activity[from][]"  class="form-control">
                                    <option value="">С</option>
                                    @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                        <option {{ ($activities['from_year'] == $year) ? 'selected' : '' }} value="{{$year}}">{{$year}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="edit_teach_activity[to][]"  class="form-control">
                                    <option value="">По</option>
                                    @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                        <option {{ ($activities['to_year'] == $year) ? 'selected' : '' }} value="{{$year}}">{{$year}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Учреждение <span class="req">*</span>
                            </label>
                            <div class="col-md-12">
                                <input type="text" class="form-control"
                                       name="edit_teach_activity[institution][]" value="{{ $activities['institution_name'] }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Должность <span class="req">*</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control"
                                       name="edit_teach_activity[position][]" value="{{ $activities['position'] }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Описание</label>
                            <div class="col-md-12">
                                <textarea style="min-height: 120px;" class="form-control" name="edit_teach_activity[description][]" placeholder="навыки, достижения, общее описание">{{ $activities['description'] }}</textarea>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Типы программ <span class="req">*</span></label>
                            <div class="col-md-12">
                                <select name="edit_teach_activity[program_type][]"  class="form-control">
                                    <option value="">Выбрать</option>
                                    @foreach($programs_type as $item)
                                        @if(!empty($item['childs']))
                                            <optgroup label="{{$item['name']}}">
                                                @foreach($item['childs'] as $child)
                                                    <option {{ ($activities['program_type'] == $child['id']) ? 'selected' : '' }} value="{{$child['id']}}">{{$child['name']}}</option>
                                                @endforeach
                                            </optgroup>
                                        @else
                                            <option {{ ($activities['program_type'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">{{$item['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Основные рубрики <span class="req">*</span>
                            </label>
                            <div class="col-md-12">
                                <select name="edit_teach_activity[id_category][]"  class="form-control">
                                    <option value="">Выбрать</option>
                                    @foreach($teach_activ_cat as $item)
                                        <option {{ ($activities['id_category'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">
                                            {{$item['name']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $i++ ?>
                @endforeach

            @else
        
            <div class="row multi__container teach_activity_container first_block">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Время работы <span class="req">*</span></label>
                            <div class="col-md-3">
                                <select name="teach_activity[from][]"  class="form-control">
                                    <option value="">С</option>
                                    @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                        <option value="{{$year}}">{{$year}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="teach_activity[to][]"  class="form-control">
                                    <option value="">По</option>
                                    @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                        <option value="{{$year}}">{{$year}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Учреждение <span class="req">*</span>
                            </label>
                            <div class="col-md-12">
                                <input type="text" class="form-control"
                                       name="teach_activity[institution][]" value="">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Должность <span class="req">*</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control"
                                       name="teach_activity[position][]" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Описание</label>
                            <div class="col-md-12">
                                <textarea style="min-height: 120px;" class="form-control" name="teach_activity[description][]" placeholder="навыки, достижения, общее описание"></textarea>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Типы программ <span class="req">*</span></label>
                            <div class="col-md-12">
                                <select name="teach_activity[program_type][]"  class="form-control">
                                    <option value="">Выбрать</option>
                                    @foreach($programs_type as $item)
                                        @if(!empty($item['childs']))
                                            <optgroup label="{{$item['name']}}">
                                                @foreach($item['childs'] as $child)
                                                    <option value="{{$child['id']}}">{{$child['name']}}</option>
                                                @endforeach
                                            </optgroup>
                                        @else
                                            <option value="{{$item['id']}}">{{$item['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Основные рубрики <span class="req">*</span>
                            </label>
                            <div class="col-md-12">
                                <select name="teach_activity[id_category][]"  class="form-control">
                                    <option value="">Выбрать</option>
                                    @foreach($teach_activ_cat as $item)
                                        <option value="{{$item['id']}}">
                                            {{$item['name']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            @endif

            <div class="row">
                <div class="col-md-12">
                    <button type="button" onclick="addBlock('teach_activity_container');" class="btn btn-sm btn-dafault add__more">Добавить еще</button>
                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-heading" style="justify-content: space-between; display: flex; align-items: center;">
            <h3 class="panel-title">Трудовая деятельность</h3>
                <input type="checkbox" {{ (count($usersWorkExperience) > 0) ? 'checked' : '' }} class="disable_block" onclick="disableBlock(this);">
            </div> 
        </div>
        <div class="panel-body">
            @if(count($usersWorkExperience) > 0)
                <?php $i=0; ?>
                @foreach($usersWorkExperience as $experience) 
                <div class="row multi__container work_experience_container {{ ($i == 0) ? 'first_block' : '' }}">
                    @if($i > 0)
                        <a class="close__item delete__item" href="/user/deleteUserExperience/<?=$experience['id']?>">X</a>  
                    @endif
                    <input type="hidden" class="id__block" name="edit_work_experience[id][]" value="{{ $experience['id'] }}">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Время работы <span class="req">*</span></label>
                            <div class="col-md-3"> 
                                <select name="edit_work_experience[from][]"  class="form-control">
                                    <option value="">С</option>
                                    @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                        <option {{ ($experience['from_year'] == $year) ? 'selected' : '' }} value="{{$year}}">{{$year}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="edit_work_experience[to][]"  class="form-control">
                                    <option value="">По</option>
                                    @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                        <option {{ ($experience['to_year'] == $year) ? 'selected' : '' }} value="{{$year}}">{{$year}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Учреждение <span class="req">*</span>
                            </label>
                            <div class="col-md-12">
                                <input type="text" class="form-control"
                                       name="edit_work_experience[institution][]" value="{{ $experience['institution_name'] }}">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Должность <span class="req">*</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control"
                                       name="edit_work_experience[position][]" value="{{ $experience['position'] }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Описание</label>
                            <div class="col-md-12">
                                <textarea style="min-height: 120px;" class="form-control" name="edit_work_experience[description][]" placeholder="навыки, достижения, общее описание">{{ $experience['description'] }}</textarea>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Направление <span class="req">*</span></label>
                            <div class="col-md-12">
                                <select name="edit_work_experience[direction][]"  class="form-control">
                                    <option value="">Выбрать</option>
                                    @foreach($work_experience_direction as $item)
                                        <option {{ ($experience['direction'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">{{$item['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Обязанности</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control"
                                       name="edit_work_experience[responsibility][]" value="{{ $experience['responsibility'] }}">
                            </div>
                        </div>
                    </div>
                </div>
                <?php $i++ ?>
                @endforeach

            @else 
                <div class="row multi__container work_experience_container first_block">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Время работы <span class="req">*</span></label>
                            <div class="col-md-3"> 
                                <select name="work_experience[from][]"  class="form-control">
                                    <option value="">С</option>
                                    @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                        <option value="{{$year}}">{{$year}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="work_experience[to][]"  class="form-control">
                                    <option value="">По</option>
                                    @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                        <option value="{{$year}}">{{$year}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Учреждение <span class="req">*</span>
                            </label>
                            <div class="col-md-12">
                                <input type="text" class="form-control"
                                       name="work_experience[institution][]" value="">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Должность <span class="req">*</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control"
                                       name="work_experience[position][]" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Описание</label>
                            <div class="col-md-12">
                                <textarea style="min-height: 120px;" class="form-control" name="work_experience[description][]" placeholder="навыки, достижения, общее описание"></textarea>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Направление <span class="req">*</span></label>
                            <div class="col-md-12">
                                <select name="work_experience[direction][]"  class="form-control">
                                    <option value="">Выбрать</option>
                                    @foreach($work_experience_direction as $item)
                                        <option value="{{$item['id']}}">{{$item['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Обязанности</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control"
                                       name="work_experience[responsibility][]" value="">
                            </div>
                        </div>
                    </div>
                </div> 
            @endif

            <div class="row">
                <div class="col-md-12">
                    <button type="button" onclick="addBlock('work_experience_container');" class="btn btn-sm btn-dafault add__more">Добавить еще</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-12 control-label">Город</label>
                <div class="col-md-12">
                    <select name="city"  class="form-control">
                        <option value="">Выбрать</option>
                        @foreach($cities as $item)
                            <option {{ ($user['city'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">{{$item['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-12 control-label">E-mail <span class="req">*</span></label>
                <div class="col-md-12">
                    <input type="email" class="form-control" name="email" value="{{ $user->email }}"
                           required>
                </div>
            </div> 
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-12 control-label">Фото </label>
                <div class="col-md-12">
                    <input type="file" name="image">
                    @if($user['image']) 
                        <img src="/public/uploads/users/{{ $user['image'] }}" alt="" class="img-thumbnail" style="margin-top: 20px; max-width: 150px;"> 
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12" id="error-respond"></div>
        <div class="col-md-6 ">
            <button type="submit" class="btn btn-primary">
                Сохранить
            </button>
        </div>
    </div>
</form>
<?php endif ?>

<?php if (false): ?> 
<br><br>
<h4>Сменить пароль</h4>
<hr>
<form action="{{ route('update_pass') }}" class="form-horizontal ajax__submit">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12"> 
            <div class="form-group">
                <label class="col-md-12 control-label">Старый Пароль <span class="req">*</span></label>
                <div class="col-md-12">
                    <input type="password" class="form-control" name="old_password"
                           value="" required>
                </div>
            </div>
              
            <div class="form-group">
                <label class="col-md-12 control-label">Пароль <span class="req">*</span></label>
                <div class="col-md-12">
                    <input type="password" class="form-control" name="password"
                           value="" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-12 control-label">Подтверждение пароля
                    <span class="req">*</span>
                </label>
                <div class="col-md-12">
                    <input type="password" class="form-control" name="password_confirmation" value="" required>
                </div>
            </div>
        </div> 
    </div>

    <div class="form-group">
        <div class="col-md-12" id="error-respond"></div>
        <div class="col-md-6 ">
            <button type="submit" class="btn btn-primary">
                Сохранить
            </button>
        </div>
    </div>
</form>
<?php endif ?>