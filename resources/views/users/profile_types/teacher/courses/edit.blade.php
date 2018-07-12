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
               <a href="#about" aria-controls="about" onclick="window.location='<?=route(userRoute('edit_course'), ['id' => $course->id])?>'" role="tab" data-toggle="tab">О курсе</a>
            </li>
            <li role="presentation" 
                class="{{ isActive(route(userRoute('edit_course_settings'), ['id' => $course->id])) ? 'active' : '' }} {{ $disabled }}">
               <a href="#settings" aria-controls="settings" onclick="window.location='<?=route(userRoute('edit_course_settings'), ['id' => $course->id])?>'" role="tab" data-toggle="tab">Настройки курса</a>
            </li>
            <li role="presentation" 
                class="{{ isActive(route(userRoute('edit_course_program'), ['id' => $course->id])) ? 'active' : '' }} {{ $disabled }}">
               <a href="#programm" aria-controls="programm" onclick="window.location='<?=route(userRoute('edit_course_program'), ['id' => $course->id])?>'" role="tab" data-toggle="tab">Программа курса</a>
            </li>
            <li role="presentation" 
                class="{{ isActive(route(userRoute('course_participants'), ['id' => $course->id])) ? 'active' : '' }}">
               <a href="#participants" aria-controls="participants" onclick="window.location='<?=route(userRoute('course_participants'), ['id' => $course->id])?>'" role="tab" data-toggle="tab">Участники курса ({{ count($course->userRequests) }})</a>
            </li>
            <li role="presentation" 
                class="{{ isActive(route(userRoute('edit_course_сertificates'), ['id' => $course->id])) ? 'active' : '' }}">
               <a href="#certificate" aria-controls="certificate" onclick="window.location='<?=route(userRoute('edit_course_сertificates'), ['id' => $course->id])?>'" role="tab" data-toggle="tab">Сертификат/диплом</a>
            </li>
         </ul>
         
         @yield('edit_form')
    
      </div>
   </div>
</div> 
@stop