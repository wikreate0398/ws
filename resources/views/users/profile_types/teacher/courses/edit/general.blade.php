@extends('users.profile_types.teacher.courses.edit')

@section('edit_form')   
	<form class="ajax__submit" method="POST" action="{{ route(userRoute('update_course_general'), ['id' => $course->id]) }}">
	    {{ csrf_field() }}
	    <div class="col-lg-8 col-lg-offset-2 course_form">
			
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
                   <input type="text" class="form-control price__course price__input" autocomplete="off" name="price" value="{{ $course->price }}" placeholder="" {{ ($course->pay == 1) ? 'disabled' : '' }}>
                   <small class="helper-form">Стоимость, руб *</small>
                </div>
 
                <div class="form-group">
                   <input type="text" class="form-control price__course price__input course_discount_price" 
                          autocomplete="off" 
                          name="discount_price" 
                          value="{{ $course->discount_price }}" 
                          placeholder=""
                          {{ (!$course->discount_price && $course->discount_percent) ? 'disabled' : '' }}>
                   <small class="helper-form">Скидка, руб</small>
                </div>

                <div class="form-group">
                   <input type="text" 
                          class="form-control price__course number_field course_discount_percent" 
                          autocomplete="off" 
                          name="discount_percent" 
                          value="{{ $course->discount_percent }}" 
                          placeholder=""
                          {{ (!$course->discount_percent && $course->discount_price) ? 'disabled' : '' }}>
                   <small class="helper-form">Скидка, %</small>
                </div>

             </div>

			<div class="row">
	          <div class="col-md-12">
	             <div id="error-respond"></div>
	             <button type="submit" class="btn btn_save" style="display: inline-block; width: auto;">
	             Сохранить 
	             </button>
	          </div>
	       </div>
		</div>
	</form> 
@stop