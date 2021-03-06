@extends('layouts.admin')
 
@section('content') 
    <div class="row">
    	<div class="col-md-12">
    	    <form class="form-horizontal ajax__submit" method="POST" action="/{{ $method }}/{{ $user['id'] }}/update">
                {{ csrf_field() }}

                <input type="hidden" name="user_type" value="1">

                <div class="row" style="padding-top:20px;">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="col-md-12 control-label">Имя <span class="req">*</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}"
                                       required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Пол <span class="req">*</span></label>
                            <div class="col-md-12">
                                <label class="radio-inline">
                                    <input type="radio" name="sex" {{ ($user->sex=='female') ? 'checked' : '' }} id="inlineRadio1" value="female"> Женский
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="sex" {{ ($user->sex=='male') ? 'checked' : '' }} id="inlineRadio2" value="male"> Мужской
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Расположение</label>
                            <div class="col-md-12 regions__area">
                                <div class="select_form">
                                    <select class="form-control select2" id="select__regions" onchange="Ajax.loadRegionCities(this, '{{ $user['city'] }}')" name="region">
                                        <option value="">Область</option>
                                        @foreach($regions as $item)
                                            <option {{ ($user['region'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">
                                                {{$item['name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <script>
                                $(window).load(function(){ $('select#select__regions').change(); });
                            </script> 
                            <div class="col-md-6 cities__area" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Адрес <span class="req">*</span></label>
                            <div class="col-md-12">
                                <input class="form-control" name="address" value="{{ $user->address }}" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">E-mail <span class="req">*</span></label>
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}"
                                       required>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Дата рождения <span class="req">*</span>

                            </label>
                            <div class="col-md-12">
                                <input type="text" class="form-control datepicker" name="date_birth"
                                       value="{{ !empty($user->date_birth) ? date('d.m.Y', strtotime($user->date_birth)) : '' }}" required placeholder="DD.MM.YY">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Номер телефона <span class="req">*</span>

                            </label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}"
                                       required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Сайт

                            </label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="site" value="{{ $user->site }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Фото </label>
                            <div class="col-md-12">
                                <input type="file" name="image">
                                @if($user['image'])
                                    <img src="/public/uploads/users/{{ $user['image'] }}" alt="" class="img-thumbnail" style="margin-top: 20px; max-width: 150px;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12" id="error-respond"></div>
                    <div class="col-md-6 ">
                        <button type="submit" class="btn btn-primary">
                            Сохранить
                        </button>
                    </div>
                </div>
            </form>

            <br><br>
            <h4>Сменить пароль</h4>
            <hr>
            <form action="/{{ $method }}/{{ $user['id'] }}/updatePassword" class="form-horizontal ajax__submit">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12"> 
                          
                        <div class="form-group">
                            <label class="col-md-12 control-label">Пароль <span class="req">*</span></label>
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password"
                                       value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Подтверждение пароля
                                <span class="req">*</span>
                            </label>
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password_confirmation" value="" required>
                            </div>
                        </div>
                    </div> 
                </div>

                <div class="form-group">
                    <div class="col-md-12" id="error-respond"></div>
                    <div class="col-md-6 ">
                        <button type="submit" class="btn btn-primary">
                            Сохранить
                        </button>
                    </div>
                </div>
            </form>
    	</div>
    </div>

@stop
