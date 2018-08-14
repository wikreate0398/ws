@extends('layouts.app')

@section('content')  
 
<div class="container no__home">
   <div class="row">
      <div class="row">
         <div class="col-lg-10 col-lg-offset-1">
            <ul class="breadcrumb">
               <li><a href="/">Главная</a></li>
               <li><a href="{{ route(userRoute('user_profile')) }}">Личный кабинет</a></li>
               <li class="active">Редактировать курс</li>
            </ul>
            <h1 class="title_page">РЕДАКТИРОВАТЬ КУРС</h1>
            <p class="title_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget.</p>
         </div>
      </div>
      @php
          $disabled = '';
          if(Course::manager($course)->canManage() != true){
            $disabled = 'disabled';
          }
      @endphp
      <div class="row">
         <ul class="nav add_course" role="tablist">
            <li role="presentation" 
                class="{{ isActive(route(userRoute('edit_course'), ['id' => $course->id])) ? 'active' : '' }} {{ $disabled }}">
               <a aria-controls="about" href="<?=route(userRoute('edit_course'), ['id' => $course->id])?>">О курсе</a>
            </li>
            <li role="presentation" 
                class="{{ isActive(route(userRoute('edit_course_settings'), ['id' => $course->id])) ? 'active' : '' }} 
                       {{ $course->general_filled ? $disabled : 'disabled' }}">
               <a aria-controls="settings" href="{{ route(userRoute('edit_course_settings'), ['id' => $course->id]) }}">Настройки курса</a>
            </li>
            <li role="presentation" 
                class="{{ isActive(route(userRoute('edit_course_program'), ['id' => $course->id])) ? 'active' : '' }} 
                       {{ ($course->settings_filled && $course->general_filled) ? $disabled : 'disabled' }}">
               <a aria-controls="programm" href="{{ route(userRoute('edit_course_program'), ['id' => $course->id]) }}">Программа курса</a>
            </li> 
            <li role="presentation" 
                class="{{ isActive(route(userRoute('edit_course_сertificates'), ['id' => $course->id])) ? 'active' : '' }}
                       {{ ($course->program_filled &&$course->settings_filled && $course->general_filled) ? '' : 'disabled' }}">
               <a aria-controls="certificate" href="{{ route(userRoute('edit_course_сertificates'), ['id' => $course->id]) }}">Сертификат/диплом</a>
            </li>
            <li role="presentation" 
                class="{{ isActive(route(userRoute('course_participants'), ['id' => $course->id])) ? 'active' : '' }}
                {{ Course::manager($course)->ifAdded() ? '' : 'disabled' }}">
               <a aria-controls="participants" href="{{ route(userRoute('course_participants'), ['id' => $course->id]) }}">Участники курса ({{ count($course->userRequests) }})</a>
            </li>
         </ul>
         
         @yield('edit_form')
    
      </div>
   </div>
</div> 
 
@stop