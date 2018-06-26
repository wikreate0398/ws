@extends('layouts.app')

@section('content')  
<div class="container no__home"> 
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <ul class="breadcrumb">
          <li><a href="/">Главная</a></li>
          <li><a href="{{ route(userRoute('user_profile')) }}">Личный кабинет</a></li>
          <li class="active">Редактировать информацию</li>
        </ul>
        <h1 class="title_page">РЕДАКТИРОВАТЬ ПРОФИЛЬ</h1>
        <p class="title_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget.</p>
    </div>
     

    <form class="ajax__submit" method="POST" action="{{ route(userRoute('update_profile')) }}">
    {{ csrf_field() }}
    <input type="hidden" name="user_type" value="2">
    <div class="col-lg-8 col-lg-offset-2 user_form" style="min-height: 300px;">

                <div class="row">
                    <div class="col-md-12">
                        <h3 class="header_blok_user">Общий профиль</h3>
                    </div>
                </div>
                
                <div class="row">
                    <label class="col-md-4 control-label">ВАШЕ ФИО <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control" value="{{ $user->name }}" name="name" type="text">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-4 control-label">ВАШ ПОЛ <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="radio-inline">
                              <input type="radio" name="sex" {{ ($user->sex=='female') ? 'checked' : '' }} id="inlineRadio1" value="female"> Женский
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="sex" {{ ($user->sex=='male') ? 'checked' : '' }} id="inlineRadio2" value="male"> Мужской
                            </label>
                        </div>
                    </div>
                </div>
  
                <div class="row">
                    <label class="col-md-4 control-label">ДАТА РОЖДЕНИЯ <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="form-group"> 
                            <input type="text" 
                               class="form-control datepicker_birthdate ll-skin-melon datepicker__input" 
                               name="date_birth"
                               value="{{ !empty($user->date_birth) ? date('d.m.Y', strtotime($user->date_birth)) : '' }}"  
                               autocomplete="off"
                               placeholder="ДД.ММ.ГГГГ"> 
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <label class="col-md-4 control-label">Расположение <span class="req">*</span></label>  
                    <div class="col-md-8"> 
                        <div class="row">
                            <div class="col-md-6 regions__area">
                                <div class="form-group select_form">
                                    <select class="form-control select2" id="select__regions" onchange="loadRegionCities(this, '{{ $user['city'] }}')" name="region">
                                        <option value="">Область</option>
                                        @foreach($regions as $item)
                                            <option {{ ($user['region'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">
                                                {{$item['name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                            <div class="col-md-6 cities__area" style="display: none;"></div> 
                        </div>
                    </div>
                </div>

                <script>
                    $(window).load(function(){ $('select#select__regions').change(); });
                </script>
 
                 
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="header_blok_user">Контактные данные</h3>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-4 control-label">АДРЕС <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control" name="address" value="{{ $user->address }}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-4 control-label">ТЕЛЕФОН <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control" name="phone" value="{{ $user->phone }}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="header_blok_user">Регистрационные данные</h3>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-4 control-label">E-MAIL <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control" name="email" value="{{ $user->email }}" type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-4 control-label">СТАРЫЙ ПАРОЛЬ <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control" autocomplete="off" name="old_password" value="" type="password">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-4 control-label">ПАРОЛЬ <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control" autocomplete="off" name="password" value="" type="password">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-4 control-label">ПОВТОРИТЕ ПАРОЛЬ <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control" autocomplete="off" name="password_confirmation" value="" type="password">
                        </div>
                    </div>
                </div> 
             
            

            <div class="row">
                <div id="error-respond"></div>
                <div class="col-md-12 ">
                    <button type="submit" class="btn btn_save" style="width: auto;">
                        Сохранить
                    </button>
                </div>
            </div>
 
    </div>
     
    </form>
</div>
<div class="clearfix"></div> 
</div>

@stop