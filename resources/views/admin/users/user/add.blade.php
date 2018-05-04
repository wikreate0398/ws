@extends('layouts.admin')
 
@section('content') 
<div class="row">
	<div class="col-md-12">
		<form action="/{{ $method }}/create" class="form-horizontal ajax__submit"> 
            {{ csrf_field() }} 

            <div class="row" style="padding-top:20px;">
                <div class="col-md-6">
                    <!-- <div class="form-group">
                        <label class="col-md-12 control-label">Фамилия <span class="req">*</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="surname" value="" required autofocus>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label class="col-md-12 control-label">Имя <span class="req">*</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="name" value=""
                                   required>
                        </div>
                    </div>

                   <!--  <div class="form-group">
                        <label class="col-md-12 control-label">Отчество <span class="req">*</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="patronymic"
                                   value="" required>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label class="col-md-12 control-label">Город</label>
                        <div class="col-md-12">
                            <select name="city"  class="form-control">
                                <option value="">Выбрать</option>
                                @foreach($cities as $item)
                                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12 control-label">E-mail <span class="req">*</span></label>
                        <div class="col-md-12">
                            <input type="email" class="form-control" name="email" value=""
                                   required>
                        </div>
                    </div>

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
                            <input type="password" class="form-control"
                                   name="password_confirmation" value="" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12 control-label">Дата рождения <span class="req">*</span>

                        </label>
                        <div class="col-md-12">
                            <input type="text" class="form-control datepicker" name="date_birth"
                                   value="" required placeholder="DD/MM/YY">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12 control-label">Номер телефона <span class="req">*</span>

                        </label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="phone" value=""
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12 control-label">Сайт

                        </label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="site" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12 control-label">Фото </label>
                        <div class="col-md-12">
                            <input type="file" name="image">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12" id="error-respond"></div>
                <div class="col-md-6 ">
                    <button type="submit" class="btn btn-primary">
                        Создать
                    </button>
                </div>
            </div>
        </form>
	</div>
</div>

@stop
