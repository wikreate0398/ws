@extends('layouts.app')
@section('content')    
<div class="container no__home">
   <div class="row">
      <div class="row">
         <div class="col-lg-10 col-lg-offset-1">
            <ul class="breadcrumb">
               <li><a href="/">Главная</a></li>
               <li><a href="{{ route(userRoute('user_profile')) }}">Личный кабинет</a></li>
               <li><a href="{{ route(userRoute('user_faculties')) }}">Факультеты</a></li>
               <li class="active">Редактировать Факультет</li>
            </ul>
            <h1 class="title_page">Редактировать Факультет</h1>
            <p class="title_desc">Заполните информацию о факультете ВУЗа. Укажите название, форму обучения, длительность и другие данные. Чем больше факультетов вы опубликуете, тем более исчерпывающую информацию о факультете получит абитуриент.</p>
         </div>
      </div>
      <div class="row">
      
         <form class="ajax__submit course_form has--preload" method="POST" action="{{ route(userRoute('update_faculty'), ['id' => $faculty->id]) }}">
            {{ csrf_field() }}
            <div class="col-lg-8 col-lg-offset-2">

				<div class="row">
					 
                     <div class="col-md-12">
                        <h3 class="header_blok_course">О ФАКУЛЬТЕТЕ</h3>
                     </div>
                     <label class="col-md-5 control-label">НАЗВАНИЕ ФАКУЛЬТЕТА <span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <input class="form-control" name="name" value="{{ $faculty->name }}" type="text">
                        </div>
                     </div>
                     <div class="clearfix"></div>

                     <label class="col-md-5 control-label">ДЛИТЕЛЬНОСТЬ ОБУЧЕНИЯ (ЛЕТ) <span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <input class="form-control number_field" name="duration_learning" value="{{ $faculty->duration_learning }}" type="text">
                        </div>
                     </div>
                     <div class="clearfix"></div>

                     <label class="col-md-5 control-label">СРЕДНЕЕ КОЛИЧЕСТВО БАЛЛОВ <span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <input class="form-control number_field" value="{{ $faculty->average_nr_points }}" name="average_nr_points" type="text">
                        </div>
                     </div>
                     <div class="clearfix"></div>

                     <label class="col-md-5 control-label">КОЛИЧЕСТВО БЮДЖЕТНЫХ МЕСТ <span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <input class="form-control number_field" value="{{ $faculty->qty_budget }}" name="qty_budget" type="text">
                        </div>
                     </div>
                     <div class="clearfix"></div>

                     <label class="col-md-5 control-label">СТОИМОСТЬ ОБУЧЕНИЯ в ГОД (₽) <span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <input class="form-control number_field price__input" value="{{ $faculty->price }}" name="price" type="text">
                        </div>
                     </div>
                     <div class="clearfix"></div>

                    <div class="col-md-12">
                        <h3 class="header_blok_course">ФОРМЫ ОБУЧЕНИЯ</h3>
                    </div> 
                    <div class="col-md-12">
						<div class="form-group">
							<ul class="list-inline list_checkbox">	
								<li>
									<div class="checkbox">
									<label>
										<input name="type[full_time_learning]" {{ ($faculty->full_time_learning == 1) ? 'checked' : '' }} type="checkbox">
										<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
										ОЧНАЯ
									</label>
									</div>
								</li>
								<li>
									<div class="checkbox">
									<label>
										<input name="type[non_public_learning]" {{ ($faculty->non_public_learning == 1) ? 'checked' : '' }} type="checkbox">
										<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
										ЗАОЧНАЯ
									</label>
									</div>
								</li>
								<li>
									<div class="checkbox">
									<label>
										<input name="type[distance_learning]" {{ ($faculty->distance_learning == 1) ? 'checked' : '' }} type="checkbox">
										<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
										ДИСТАНЦИОННАЯ
									</label>
									</div>
								</li>
							</ul>
						</div>
					</div>

					<div class="col-md-12">
                        <h3 class="header_blok_course">ЭКЗАМЕНЫ ДЛЯ ПОСТУПЛЕНИЯ</h3>
                    </div> 

                    <label class="col-md-5 control-label">Предметы <span class="req">*</span></label>
               <div class="col-md-7">
                  <div class="form-group"> 
                     <div class="category--subjects"> 
                        <div class="selected--subjects-list"> 
                           @if(count($faculty->subjects))
                              @foreach($faculty->subjects as $subject)
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

                           <p style="{{ count($faculty->subjects) ? 'display: none;' : '' }}" class="select--subjects-label">
                              Выбрать
                           </p>
                        </div>
                        <div class="dropdown-category">  
                           <ul>
                           @php
                              $teacherSubjectsId = $faculty->subjects->pluck('id')->toArray(); 
                              $teacherDirectionId = $faculty->direction->pluck('id')->toArray();
                           @endphp
                           @foreach($categories as $direction) 
                              @if(count($direction['childs']))
                                 <li>
                                    <span onclick="openDirectionSubjects(this);" 
                                          direction-id="{{ $direction['name'] }}">{{ $direction['name'] }}</span>
                                    <ul style="{{ in_array($direction['id'], $teacherDirectionId) ? 'display: block' : '' }}""> 
                                       @foreach($direction['childs'] as $subject)  
                                          <li>
                                             <span onclick="selectSubject(this);" 
                                                   direction-id="{{ $direction['id'] }}" 
                                                   subject-id="{{ $subject['id'] }}"
                                                   class="{{ in_array($subject['id'], $teacherSubjectsId) ? 'selected--subject' : ''}}">
                                                {{ $subject['name'] }}
                                             </span>
                                          </li>
                                       @endforeach
                                    </ul>
                                 </li> 
                              @endif
                           @endforeach
                           </ul>
                        </div>
                     </div>

                     <div class="selected__teacher_inputs">
                        @if(count($faculty->subjects)) 
                           @foreach($faculty->subjects as $subject)
                              <input type="hidden"  
                                     id="teacher_subjects_input_{{ $subject->id }}" 
                                     value="{{ $subject->id }}" 
                                     name="teacher_subjects[{{ $subject->pivot->id_direction }}][]">
                           @endforeach
                        @endif
                     </div>
                  </div>
               </div> 
				</div>
                
                <div class="row">
                  <div class="col-md-12">
                     <div id="error-respond"></div>
                     <button type="submit" class="btn btn_save" style="display: inline-block; width: auto;">
                     Редактировать 
                     </button>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div> 
@stop