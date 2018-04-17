@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#user" aria-controls="user" role="tab" data-toggle="tab">User</a></li>
                        <li role="presentation"><a href="#teacher" aria-controls="teacher" role="tab" data-toggle="tab">Teacher</a></li>
                        <li role="presentation"><a href="#university" aria-controls="university" role="tab" data-toggle="tab">University</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="user">
                            <div class="row" style="padding-top:20px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="surname" class="col-md-12 control-label">Фамилия</label>
                                        <div class="col-md-12">
                                            <input id="surname" type="text" class="form-control" name="surname" value="" required autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="col-md-12 control-label">Имя</label>
                                        <div class="col-md-12">
                                            <input id="name" type="text" class="form-control" name="name" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="patronymic" class="col-md-12 control-label">Отчество</label>
                                        <div class="col-md-12">
                                            <input id="patronymic" type="text" class="form-control" name="patronymic" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Город</label>
                                        <div class="col-md-12">
                                            <select name="city" id="" class="form-control">
                                                <option value="0">Выбрать</option>
                                                @foreach($cities as $item)
                                                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="col-md-12 control-label">E-mail</label>
                                        <div class="col-md-12">
                                            <input id="email" type="email" class="form-control" name="email" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="col-md-12 control-label">Пароль</label>
                                        <div class="col-md-12">
                                            <input id="password" type="password" class="form-control" name="password" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="repeat_password" class="col-md-12 control-label">Повторите пароль

                                        </label>
                                        <div class="col-md-12">
                                            <input id="repeat_password" type="password" class="form-control" name="repeat_password" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date_birth" class="col-md-12 control-label">Дата рождения

                                        </label>
                                        <div class="col-md-12">
                                            <input id="date_birth" type="text" class="form-control" name="date_birth" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone" class="col-md-12 control-label">Номер телефона

                                        </label>
                                        <div class="col-md-12">
                                            <input id="phone" type="text" class="form-control" name="phone" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="site" class="col-md-12 control-label">Сайт

                                        </label>
                                        <div class="col-md-12">
                                            <input id="site" type="text" class="form-control" name="site" value="">
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
                        </div>
                        <div role="tabpanel" class="tab-pane" id="teacher">
                            <div class="row" style="padding-top:20px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="surname" class="col-md-12 control-label">Фамилия</label>
                                        <div class="col-md-12">
                                            <input id="surname" type="text" class="form-control" name="surname" value="" required autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="col-md-12 control-label">Имя</label>
                                        <div class="col-md-12">
                                            <input id="name" type="text" class="form-control" name="name" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="patronymic" class="col-md-12 control-label">Отчество</label>
                                        <div class="col-md-12">
                                            <input id="patronymic" type="text" class="form-control" name="patronymic" value="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date_birth" class="col-md-12 control-label">Дата рождения

                                        </label>
                                        <div class="col-md-12">
                                            <input id="date_birth" type="text" class="form-control" name="date_birth" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone" class="col-md-12 control-label">Номер телефона

                                        </label>
                                        <div class="col-md-12">
                                            <input id="phone" type="text" class="form-control" name="phone" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="site" class="col-md-12 control-label">Сайт

                                        </label>
                                        <div class="col-md-12">
                                            <input id="site" type="text" class="form-control" name="site" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">ОБРАЗОВАНИЕ</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="phone" class="col-md-12 control-label">Время работы </label>
                                                <div class="col-md-3">
                                                    <select name="education[from]" id="" class="form-control">
                                                        @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                                            <option value="{{$year}}">{{$year}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select name="education[to]" id="" class="form-control">
                                                        @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                                            <option value="{{$year}}">{{$year}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="ed_institution" class="col-md-12 control-label">Образовательное учреждение

                                                </label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" name="education[institution]" value="">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ed_institution" class="col-md-12 control-label">Кафедра</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" name="education[institution]" value="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="ed_institution" class="col-md-12 control-label">Примечания</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" name="education[institution]" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ed_institution" class="col-md-12 control-label">Специальность</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" name="education[institution]" value="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="ed_institution" class="col-md-12 control-label">Степень</label>
                                                <div class="col-md-12">
                                                    <select name="city" id="" class="form-control">
                                                        <option value="0">Выбрать</option>
                                                        @foreach($grade_education as $item)
                                                            @if(!empty($item['childs']))
                                                                <optgroup label="{{$item['name']}}">
                                                                    @foreach($item['childs'] as $child)
                                                                        <option value="{{$child['id']}}">{{$child['name']}}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                                @else
                                                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Город</label>
                                        <div class="col-md-12">
                                            <select name="city" id="" class="form-control">
                                                <option value="0">Выбрать</option>
                                                @foreach($cities as $item)
                                                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="col-md-12 control-label">E-mail</label>
                                        <div class="col-md-12">
                                            <input id="email" type="email" class="form-control" name="email" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="col-md-12 control-label">Пароль</label>
                                        <div class="col-md-12">
                                            <input id="password" type="password" class="form-control" name="password" value="" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="repeat_password" class="col-md-12 control-label">Повторите пароль

                                        </label>
                                        <div class="col-md-12">
                                            <input id="repeat_password" type="password" class="form-control" name="repeat_password" value="" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Фото </label>
                                        <div class="col-md-12">
                                            <input type="file" name="image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="university">

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 ">
                            <button type="submit" class="btn btn-primary">
                                Register
                            </button>
                        </div>
                    </div>
                </form>




            </div>

        </div>
    </div>
@endsection
