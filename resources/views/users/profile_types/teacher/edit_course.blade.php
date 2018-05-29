@extends('layouts.app')

@section('content')  
 
<div class="container no__home">
   <div class="row">
      <div class="row">
         <div class="col-lg-10 col-lg-offset-1">
            <ul class="breadcrumb">
               <li><a href="/">Главная</a></li>
               <li><a href="{{ route('user_profile') }}">Личный кабинет</a></li>
               <li class="active">Редактировать курс</li>
            </ul>
            <h1 class="title_page">РЕДАКТИРОВАТЬ КУРС</h1>
            <p class="title_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget.</p>
         </div>
      </div>
      <div class="row">
         <ul class="nav add_course" role="tablist">
            <li role="presentation" class="active">
               <a href="#about" aria-controls="about" role="tab" data-toggle="tab">О курсе</a>
            </li>
            <li role="presentation">
               <a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Настройки курса</a>
            </li>
            <li role="presentation">
               <a href="#programm" aria-controls="programm" role="tab" data-toggle="tab">Программа курса</a>
            </li>
            <li role="presentation">
               <a href="#participants" aria-controls="participants" role="tab" data-toggle="tab">Участники курса</a>
            </li>
            <li role="presentation">
               <a href="#certificate" aria-controls="certificate" role="tab" data-toggle="tab">Сертификат/диплом</a>
            </li>
         </ul>
         <form class="ajax__submit" method="POST" action="{{ route('edit_course', ['id' => $course->id]) }}">
            {{ csrf_field() }}
            <div class="col-lg-8 col-lg-offset-2">
               <div class="tab-content course_form">
                  <div role="tabpanel" class="tab-pane active" id="about">
                     <div class="col-md-12">
                        <h3 class="header_blok_course">Общая информация о курсе</h3>
                     </div>
                     <label class="col-md-5 control-label">НАЗВАНИЕ КУРСА <span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <input class="form-control" name="name" value="{{ $course->name }}" type="text">
                        </div>
                     </div>
                     <div class="clearfix"></div>
                     <label class="col-md-5 control-label">
                        КРАТКОЕ ОПИСАНИЕ КУРСА <span class="req">*</span>
                        <p>Опишите кратко Ваш курс</p>
                     </label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <textarea class="form-control" maxlength="200" name="description">{{ $course->description }}</textarea>
                           <div class="maxlength__label"><span>0</span> символов (200 максимум)</div>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                     <label class="col-md-5 control-label">
                        ПОДРОБНОЕ ОПИСАНИЕ КУРСА <span class="req">*</span>
                        <p>Опишите подробно Ваш курс, для кого он предназначен, какие навыки развивает, какой уровень образования нужен, для прохождения курса?</p>
                     </label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <textarea class="form-control" maxlength="2000" name="text">{{ $course->text }}</textarea>
                           <div class="maxlength__label"><span>0</span> символов (2000 максимум)</div>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                     <label class="col-md-5 control-label">
                        КУРАТОР КУРСА <span class="req">*</span>
                        <p>Если вы представитель ВУЗа, то здесь будет отображаться список созданных преподавателей</p>
                     </label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <textarea class="form-control" maxlength="1200" name="" disabled>{{ Auth::user()->name }}</textarea> 
                        </div>
                     </div>
                     <div class="clearfix"></div>
                     <label class="col-md-5 control-label">
                        КАТЕГОРИЯ И ПОДКАТЕГОРИЯ <span class="req">*</span>
                        <p>Укажите одну или несколько категорий, которые максимально охватывают вашу целевую аудиторию курса</p>
                     </label>
                     <div class="col-md-7">
                        <div class="row">
                           	<div class="col-md-12" id="course__cats">
                              <div class="form-group select_form">
                                 <select name="id_category" class="form-control" onchange="loadCourseSubcats(this, {{ $course->id_subcat }})">
                                    <option value="">Выбрать</option>
                                    @foreach($categories as $item)
                                    <option {{ ($course->id_category == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">{{$item['name']}}</option>
                                    @endforeach
                                 </select>
                              </div>
                           	</div>
                           	<div class="col-md-12" id="load__subcats"></div>
                           	<script>
				            	$(window).load(function(){ $('#course__cats select').change(); });
				            </script>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                     <div class="col-md-12">
                        <h3 class="header_blok_course">Цена и скидки</h3>
                     </div>
                     <div class="col-md-5 form-group">
                        <div class="radio">
                           <label>
                           <input type="radio" name="pay" {{ ($course->pay == 1) ? 'checked' : '' }} value="1" onchange="setPayCourse(this)"> Бесплатный курс
                           </label>
                        </div>
                        <div class="radio">
                           <label>
                           <input type="radio" name="pay" {{ ($course->pay == 2) ? 'checked' : '' }} value="2" onchange="setPayCourse(this)"> Платный курс
                           </label>
                        </div>
                     </div>
                     <div class="col-md-7">
                        <div class="form-group">
                           <input type="text" class="form-control price__course" autocomplete="off" name="price" value="{{ $course->price }}" placeholder="Стоимость, руб *" {{ ($course->pay == 1) ? 'disabled' : '' }}>
                        </div>
                     </div>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="settings">
                     <div class="col-md-12">
                        <h3 class="header_blok_course">Настройки курса</h3>
                     </div>
                     <label class="col-md-5 control-label">ЗАПИСЬ НА КУРС ОТКРЫТА ДО <span class="req">*</span>
                     </label>
                     <div class="col-md-7">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <input class="form-control datepicker" autocomplete="off" name="is_open_until" value="{{ date('d.m.Y', strtotime($course->is_open_until)) }}" placeholder="" type="text">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <button class="btn turn_on">Включить запись</button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                     <div class="col-md-12">
                        <h3 class="header_blok_course">Доступность на сайте</h3>
                     </div>
                     <div class="col-md-12 form-group">
                        <div class="radio">
                           <label>
                           <input type="radio" {{ ($course->available == 1) ? 'checked' : '' }} name="available" value="1"> Всем желающим
                           </label>
                        </div>
                        <div class="radio">
                           <label>
                           <input type="radio" {{ ($course->available == 2) ? 'checked' : '' }} name="available" value="2"> Только для зарегистрированных пользователей
                           </label>
                        </div>
                        <div class="radio">
                           <label>
                           <input type="radio" {{ ($course->available == 3) ? 'checked' : '' }} name="available" value="1"> Скрыть курс по окончанию набора
                           </label>
                        </div>
                     </div>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="programm">
                  	<div class="course__sections">  
						<?php $sectionsNum = 0; $lecturesNum = 0; ?> 
						@foreach($course->sections as $section)
						<div class="panel panel-default course__section {{ ($sectionsNum==0) ? 'first_block' : '' }}">
							
							@if($sectionsNum>0)
								<div class="close__item" onclick="deleteSectionBlock(this, '{{ $section->id }}');">X</div>
							@endif

					        <div class="panel-heading">
					            <h3 class="panel-title">Раздел</h3>
					        </div>
					        <div class="panel-body"> 
					            <div class="row">
					                <div class="col-md-12">
			                 
							            <div class="form-group">
							                <label class="control-label" style="white-space: nowrap;">Название Раздела<span class="req">*</span></label>
							                <div class="">
							                    <input type="text" class="form-control required__input" name="section[name][]" value="{{ $section->name }}" placeholder="">
							                </div>
							            </div> 

							            <div class="lecture__sections">  
							            	<?php $l = 0; ?>
							            	@foreach($section->lectures as $lecture)
								            <div class="panel panel-warning lecture__section {{ ($lecturesNum==0) ? 'first_block' : '' }}">

								            	@if($l>0)
													<div class="close__item" onclick="deleteLectureBlock(this, '{{ $lecture->id }}');">X</div>
												@endif

								            	<div class="panel-heading">
										            <h3 class="panel-title">Добавления лекции</h3>
										        </div>
								            	<div class="panel-body"> 
								            		<div class="form-group">
											            <label class="col-md-12 control-label">Название лекции <span class="req">*</span></label>
											            <div class="col-md-12">
											                <input type="text" class="form-control required__input" name="lecture[{{$sectionsNum}}][name][]" value="{{ $lecture->name }}">
											            </div>
											        </div>

											        <div class="form-group">
											            <label class="col-md-12 control-label">Описание лекции <span class="req">*</span></label>
											            <div class="col-md-12">
											            	<textarea name="lecture[{{$sectionsNum}}][description][]" class="form-control required__input" placeholder=""="">{{ $lecture->description }}</textarea> 
											            </div>
											        </div>

											        <div class="form-group">
											            <label class="col-md-12 control-label">Длительность лекции <span class="req">*</span></label>
											            <div class="col-md-2">
											            	<input type="text" 
											            	       class="form-control number_field required__input" 
											            	       name="lecture[{{$sectionsNum}}][hourse][]" 
											            	       placeholder="чч" 
											            	       value="{{ $lecture->duration_hourse }}">
											            </div>
											            <div class="col-md-2">
											            	<input type="text" 
											            	       class="form-control number_field required__input" 
											            	       name="lecture[{{$sectionsNum}}][minutes][]" 
											            	       placeholder="мм" value="{{ $lecture->duration_minutes }}">
											            </div>
											        </div>
								            	</div>
								            </div>
								            <?php $lecturesNum++; $l++; ?>
								            @endforeach
							            </div>
					         
					                </div> 
					 
					                <div class="col-md-12">
					                    <button type="button" onclick="addLecture(this);" class="btn btn-sm btn-dafault add__more">
					                    	Добавить лекцию
					                    </button>
					                </div> 			            
					            </div> 
					        </div>
						</div>
						<?php $sectionsNum++ ?>
						@endforeach 
					</div>
                     <button class="btn btn-default btn-sm" type="button" onclick="addCourseSection()">Добавить раздел</button>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="participants">
                     <div class="col-md-12">
                        <h3 class="header_blok_course">Данная страница на стадии разработки</h3>
                     </div>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="certificate">
                     <div class="col-md-12">
                        <h3 class="header_blok_course">Данная страница на стадии разработки</h3>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div id="error-respond"></div>
                     <button type="submit" class="btn btn_save" style="display: inline-block; width: auto;">
                     Добавить 
                     </button>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div> 
@stop