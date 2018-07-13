@extends('users.profile_types.teacher.courses.edit')

@section('edit_form')   
	<form class="ajax__submit listener__change_form course__form" method="POST" action="{{ route(userRoute('update_course_settings'), ['id' => $course->id]) }}">
	    {{ csrf_field() }}
      <input type="hidden" name="redirectUri" id="redirectUri">
	    <div class="col-lg-8 col-lg-offset-2 course_form">

	    	<div class="col-md-12">
                <h3 class="header_blok_course">Настройки курса</h3>
             </div>
             
             <label class="col-md-5 control-label">
                УКАЖИТЕ ТИП <span class="req">*</span>
                <p>от типа зависит разовое или постоянно действуещее событие</p>
             </label>
             <div class="col-md-7">
                <div class="row">
                   <div class="col-md-12" id="course__cats">
                      <div class="form-group select_form">
                         <select name="type" class="form-control">
                            <option value="">Выбрать</option>
                            <option {{ ($course->type == '1') ? 'selected' : '' }} value="1">Курс</option>
                            <option {{ ($course->type == '2') ? 'selected' : '' }} value="2">Семинар</option>
                            <option {{ ($course->type == '3') ? 'selected' : '' }} value="3">Вебинар</option>
                         </select>
                      </div>
                   </div>
                   <div class="col-md-12" id="load__subcats"></div>
                </div>
             </div>
             <div class="clearfix"></div>

             <label class="col-md-5 control-label">УКАЖИТЕ Длительность <span class="req">*</span>
             </label>
             <div class="col-md-7">
                <div class="row">
                   <div class="col-md-6">
                      <div class="form-group">
                         <input class="form-control course_date_from datepicker__input" 
                                autocomplete="off" 
                                name="date_from" 
                                value="{{ !empty($course->date_from) ? date('d.m.Y', strtotime($course->date_from)) : '' }}" 
                                placeholder="от" 
                                type="text">
                      </div>
                   </div>
                   <div class="col-md-6">
                      <div class="form-group">
                         <input class="form-control course_date_to datepicker__input" 
                                autocomplete="off" 
                                name="date_to" 
                                value="{{ !empty($course->date_to) ? date('d.m.Y', strtotime($course->date_to)) : '' }}" 
                                placeholder="до" 
                                type="text">
                      </div>
                   </div>
                </div>
             </div>
             <div class="clearfix"></div>

             <label class="col-md-5 control-label">УКАЖИТЕ кол-во людей 
             </label>
             <div class="col-md-7">
                <div class="form-group">
                   <input class="form-control number_field" autocomplete="off" name="max_nr_people" value="{{ $course->max_nr_people }}" type="text">
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

                <div class="list_checkbox"> 
                   <div class="checkbox"> 
                      <label> 
                         <input type="checkbox" name="hide_after_end" onchange="showCourseDuration(this)" {{ $course->hide_after_end ? 'checked' : '' }} name="hide_after_end">
                         <span class="jackdaw">
                            <i class="jackdaw-icon fa fa-check"></i>
                         </span>
                         Скрыть курс по окончанию набора
                      </label> 
                   </div>
                </div>

                <div class="course__duration row" style="{{ !$course->hide_after_end ? 'display: none;' : '' }} ">
                   <label class="col-md-5 control-label">УКАЖИТЕ ИНТЕРВАЛ ДОСТУПНОСТИ ЗАПИСИ 
                      <span class="req">*</span>
                   </label>
                   <div class="col-md-7">
                      <div class="row">
                         <div class="col-md-6">
                            <div class="form-group">
                               <input class="form-control course_is_open is_open_from datepicker__input" 
                                      autocomplete="off" 
                                      name="is_open_from" 
                                      value="{{ !empty($course->is_open_from) ? date('d.m.Y', strtotime($course->is_open_from)) : '' }}" 
                                      placeholder="от" 
                                      type="text">
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="form-group">
                               <input class="form-control course_is_open is_open_to datepicker__input" 
                                      autocomplete="off" 
                                      name="is_open_to" 
                                      value="{{ !empty($course->is_open_to) ? date('d.m.Y', strtotime($course->is_open_to)) : '' }}" 
                                      placeholder="до" 
                                      type="text">
                            </div>
                         </div>
                      </div>
                   </div> 
                </div> 

             </div>
		
			<div class="row">
	          <div class="col-md-12">
	             <div id="error-respond"></div>
	             <button type="submit" class="btn btn_save" style="display: inline-block; width: auto;">
	                @if($course->settings_filled)
                    Сохранить
                  @else
                    Далее
                  @endif  
	             </button>
	          </div>
	       </div>
		</div>
	</form> 
@stop