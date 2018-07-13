@extends('layouts.app')
@section('content')  
<div class="container no__home">
   <div class="row">
      <div class="row">
         <div class="col-lg-10 col-lg-offset-1">
            <ul class="breadcrumb">
               <li><a href="/">Главная</a></li>
               <li><a href="{{ route(userRoute('user_profile')) }}">Личный кабинет</a></li>
               <li class="active">Добавить курс</li>
            </ul>
            <h1 class="title_page">ДОБАВИТЬ КУРС</h1>
            <p class="title_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget.</p>
         </div>
      </div>
      <div class="row">
         <ul class="nav add_course" role="tablist">
            <li role="presentation" class="active">
               <a href="#about" aria-controls="about" role="tab" data-toggle="tab">О курсе</a>
            </li>
            <li role="presentation" class="disabled">
               <a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Настройки курса</a>
            </li>
            <li role="presentation" class="disabled">
               <a href="#programm" aria-controls="programm" role="tab" data-toggle="tab">Программа курса</a>
            </li> 
            <li role="presentation" class="disabled">
               <a href="#certificate" aria-controls="certificate" role="tab" data-toggle="tab">Сертификат/диплом</a>
            </li>
         </ul>
         <form class="ajax__submit course__form" method="POST" action="{{ route(userRoute('save_course')) }}">
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
                           <input class="form-control" name="name" type="text">
                        </div>
                     </div>
                     <div class="clearfix"></div>
                     <label class="col-md-5 control-label">
                        КРАТКОЕ ОПИСАНИЕ КУРСА <span class="req">*</span>
                        <p>Опишите кратко Ваш курс</p>
                     </label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <textarea class="form-control" maxlength="200" name="description"></textarea>
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
                           <textarea class="form-control" maxlength="2000" name="text"></textarea>
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
                           <textarea class="form-control" maxlength="1200" name="" disabled> {{ Auth::user()->name }}</textarea> 
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
                                 <select name="id_category"  class="form-control" onchange="loadCourseSubcats(this)">
                                    <option value="">Выбрать</option>
                                    @foreach($categories as $item)
                                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-12" id="load__subcats"></div>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                     <div class="col-md-12">
                        <h3 class="header_blok_course">Цена и скидки</h3>
                     </div>
                     <div class="col-md-5 form-group">
                        <div class="radio">
                           <label>
                           <input type="radio" name="pay" value="1" onchange="setPayCourse(this)"> Бесплатный курс
                           </label>
                        </div>
                        <div class="radio">
                           <label>
                           <input type="radio" name="pay" checked value="2" onchange="setPayCourse(this)"> Платный курс
                           </label>
                        </div>
                     </div>
                     <div class="col-md-7">
                        <div class="form-group">
                           <input type="text" class="form-control price__course price__input" autocomplete="off" name="price" value="" placeholder="">
                           <small class="helper-form">Стоимость, руб *</small>
                        </div>

                        <div class="form-group">
                           <input type="text" class="form-control price__course price__input course_discount_price" 
                                  autocomplete="off" 
                                  name="discount_price" 
                                  value="" 
                                  placeholder="">
                           <small class="helper-form">Скидка, руб</small>
                        </div>

                        <div class="form-group">
                           <input type="text" 
                                  class="form-control price__course number_field course_discount_percent" 
                                  autocomplete="off" 
                                  name="discount_percent" 
                                  value="" 
                                  placeholder="">
                           <small class="helper-form">Скидка, %</small>
                        </div>
                     </div>
                  </div> 
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div id="error-respond"></div>
                     <button type="submit" class="btn btn_save" style="display: inline-block; width: auto;">
                        Далее 
                     </button>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
@stop