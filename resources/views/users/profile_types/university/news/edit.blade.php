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
               <li class="active">Редактировать Новость</li>
            </ul>
            <h1 class="title_page">Редактировать Новость</h1>
            <p class="title_desc">Повышайте уровень взаимодействия с пользователями «КОРПОРАЦИИ МОЗГА», публикуя новости от имени ВУЗа. Освещайте важные события из жизни вашего учебного заведения или приглашайте посетителей на открытые мероприятия.</p>
         </div>
      </div>
      <div class="row">
      
         <form class="ajax__submit course_form has--preload" method="POST" action="{{ route(userRoute('update_news'), ['id' => $news->id]) }}">
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
                              <option {{ ($news['type']=='news') ? 'selected' : '' }} value="news">Новость</option>
                              <option {{ ($news['type']=='event') ? 'selected' : '' }} value="event">Событие (день открытых дверей)</option>                               
                           </select>
                        </div>
                     </div>
                     <div class="clearfix"></div> 

                     <label class="col-md-5 control-label">НАЗВАНИЕ Новости <span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <input class="form-control" name="name" value="{{ $news->name }}" type="text">
                        </div>
                     </div>
                     <div class="clearfix"></div>

                     <label class="col-md-5 control-label">ОПИСАНИЕ<span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <textarea class="form-control" name="description">{{ $news->description }}</textarea>
                           <div class="maxlength__label">(200 символов минимум)</div>
                        </div>
                     </div>
                     <div class="clearfix"></div> 

                     <label class="col-md-5 control-label">Активность <span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <div class="checkbox">
                           <label>
                              <input {{ ($news->view == 1) ? 'checked' : '' }} name="view" type="checkbox">
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