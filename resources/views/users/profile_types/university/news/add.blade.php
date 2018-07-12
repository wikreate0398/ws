@extends('layouts.app')
@section('content')    
<div class="container no__home">
   <div class="row">
      <div class="row">
         <div class="col-lg-10 col-lg-offset-1">
            <ul class="breadcrumb">
               <li><a href="/">Главная</a></li>
               <li><a href="{{ route(userRoute('user_profile')) }}">Личный кабинет</a></li>
               <li><a href="{{ route(userRoute('user_news')) }}">Новости</a></li>
               <li class="active">Добавить Новость</li>
            </ul>
            <h1 class="title_page">ДОБАВИТЬ Новость</h1>
            <p class="title_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget.</p>
         </div>
      </div>
      <div class="row">
      
         <form class="ajax__submit course_form" method="POST" action="{{ route(userRoute('save_news')) }}">
            {{ csrf_field() }}
            <div class="col-lg-8 col-lg-offset-2">

				<div class="row">
					 
                     <div class="col-md-12">
                        <h3 class="header_blok_course">ИНФОРМАЦИЯ</h3>
                     </div>

                     <label class="col-md-5 control-label">ТИП НОВОСТИ<span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group select_form">
                           <select class="form-control" name="type">
                              <option value="news">Новость</option>
                              <option value="event">Событие (день открытых дверей)</option>                               
                           </select>
                        </div>
                     </div>
                     <div class="clearfix"></div> 

                     <label class="col-md-5 control-label">НАЗВАНИЕ Новости <span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <input class="form-control" name="name" type="text">
                        </div>
                     </div>
                     <div class="clearfix"></div>

                     <label class="col-md-5 control-label">ОПИСАНИЕ<span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <textarea class="form-control" maxlength="200" name="description"></textarea>
                           <div class="maxlength__label">(200 символов минимум)</div>
                        </div>
                     </div>
                     <div class="clearfix"></div> 

                     <label class="col-md-5 control-label">Активность <span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <div class="checkbox">
                           <label>
                              <input name="view" type="checkbox">
                              <span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span> 
                           </label>
                           </div>
                        </div>
                     </div>
                     <div class="clearfix"></div>
 
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