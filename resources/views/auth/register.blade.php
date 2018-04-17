@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#user" aria-controls="user" role="tab"
                                                              data-toggle="tab">Ученик</a></li>
                    <li role="presentation"><a href="#teacher" aria-controls="teacher" role="tab" data-toggle="tab">Учитель </a>
                    </li>
                    <li role="presentation"><a href="#university" aria-controls="university" role="tab"
                                               data-toggle="tab">Учебное заведение</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="user">
                        <form class="form-horizontal ajax__submit" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="user_type" value="1">

                            <div class="row" style="padding-top:20px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Фамилия <span class="req">*</span></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="surname" value="" required autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Имя <span class="req">*</span></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="name" value=""
                                                   required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Отчество <span class="req">*</span></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="patronymic"
                                                   value="" required>
                                        </div>
                                    </div>

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
                                        Зарегистрироваться
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="teacher">
                        <form class="form-horizontal ajax__submit" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_type" value="2">
                            <div class="row" style="padding-top:20px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Фамилия <span class="req">*</span></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="surname" value=""
                                                   required autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Имя <span class="req">*</span></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="name" value=""
                                                   required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Отчество <span class="req">*</span></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="patronymic"
                                                   value="" required>
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
                                            <input  type="text" class="form-control" name="phone" value=""
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
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">ОБРАЗОВАНИЕ</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row multi__container education__container first_block"> 
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Время обучения <span class="req">*</span></label>
                                                <div class="col-md-3">
                                                    <select name="education[from][]"  class="form-control">
                                                        <option value="">С</option>
                                                        @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                                            <option value="{{$year}}">{{$year}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select name="education[to][]"  class="form-control">
                                                        <option value="">По</option>
                                                        @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                                            <option value="{{$year}}">{{$year}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Образовательное
                                                    учреждение <span class="req">*</span>

                                                </label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control"
                                                           name="education[institution][]" value="" required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label  
                                                       class="col-md-12 control-label">Кафедра</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control"
                                                           name="education[department][]" value="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label  
                                                       class="col-md-12 control-label">Примечания</label>
                                                <div class="col-md-12">
                                                    <textarea name="education[notes][]" class="form-control" style="min-height: 120px;"></textarea> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Специальность <span class="req">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control"
                                                           name="education[specialty][]" value="" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Степень <span class="req">*</span></label>
                                                <div class="col-md-12">
                                                    <select name="education[grade][]"  class="form-control">
                                                        <option value="">Выбрать</option>
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

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" onclick="addBlock('education__container');" class="btn btn-sm btn-dafault add__more">Добавить еще</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" style="justify-content: space-between; display: flex; align-items: center;">
                                    <h3 class="panel-title">Преподовательская деятельность</h3>
                                    <input type="checkbox" class="disable_block" onclick="disableBlock(this);">
                                </div>
                                <div class="panel-body">
                                    <div class="row multi__container teach_activity_container first_block">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Время работы <span class="req">*</span></label>
                                                <div class="col-md-3">
                                                    <select name="teach_activity[from][]"  class="form-control">
                                                        <option value="">С</option>
                                                        @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                                            <option value="{{$year}}">{{$year}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select name="teach_activity[to][]"  class="form-control">
                                                        <option value="">По</option>
                                                        @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                                            <option value="{{$year}}">{{$year}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Учреждение <span class="req">*</span>
                                                </label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control"
                                                           name="teach_activity[institution][]" value="">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Должность <span class="req">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control"
                                                           name="teach_activity[position][]" value="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Описание</label>
                                                <div class="col-md-12">
                                                    <textarea style="min-height: 120px;" class="form-control" name="teach_activity[description][]" placeholder="навыки, достижения, общее описание"></textarea>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Типы программ <span class="req">*</span></label>
                                                <div class="col-md-12">
                                                    <select name="teach_activity[program_type][]"  class="form-control">
                                                        <option value="">Выбрать</option>
                                                        @foreach($programs_type as $item)
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

                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Основные рубрики <span class="req">*</span>
                                                </label>
                                                <div class="col-md-12">
                                                    <select name="teach_activity[id_category][]"  class="form-control">
                                                        <option value="">Выбрать</option>
                                                        @foreach($teach_activ_cat as $item)
                                                            <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" onclick="addBlock('teach_activity_container');" class="btn btn-sm btn-dafault add__more">Добавить еще</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-heading" style="justify-content: space-between; display: flex; align-items: center;">
                                    <h3 class="panel-title">Трудовая деятельность</h3>
                                        <input type="checkbox" class="disable_block" onclick="disableBlock(this);">
                                    </div> 
                                </div>
                                <div class="panel-body">
                                    <div class="row multi__container work_experience_container first_block">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Время работы <span class="req">*</span></label>
                                                <div class="col-md-3"> 
                                                    <select name="work_experience[from][]"  class="form-control">
                                                        <option value="">С</option>
                                                        @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                                            <option value="{{$year}}">{{$year}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select name="work_experience[to][]"  class="form-control">
                                                        <option value="">По</option>
                                                        @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                                            <option value="{{$year}}">{{$year}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Учреждение <span class="req">*</span>
                                                </label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control"
                                                           name="work_experience[institution][]" value="">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Должность <span class="req">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control"
                                                           name="work_experience[position][]" value="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Описание</label>
                                                <div class="col-md-12">
                                                    <textarea style="min-height: 120px;" class="form-control" name="work_experience[description][]" placeholder="навыки, достижения, общее описание"></textarea>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Направление <span class="req">*</span></label>
                                                <div class="col-md-12">
                                                    <select name="work_experience[direction][]"  class="form-control">
                                                        <option value="">Выбрать</option>
                                                        @foreach($work_experience_direction as $item)
                                                            <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-12 control-label">Обязанности</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control"
                                                           name="work_experience[responsibility][]" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" onclick="addBlock('work_experience_container');" class="btn btn-sm btn-dafault add__more">Добавить еще</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
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
                                            <input type="password" class="form-control" name="password_confirmation" value="" required>
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
                            <div class="form-group">
                                <div class="col-md-12" id="error-respond"></div>
                                <div class="col-md-6 ">
                                    <button type="submit" class="btn btn-primary">
                                        Зарегистрироваться
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="university"> 

                        <form class="form-horizontal ajax__submit" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_type" value="3">
                               
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Тип <span class="req">*</span></label>
                                        <div class="col-md-12">
                                            <select name="institution_type" class="form-control">
                                                <option value="">Выбрать</option>
                                                @foreach($inst_type as $item)
                                                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>  
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Статус <span class="req">*</span></label>
                                        <div class="col-md-12">
                                            <select name="status" class="form-control">
                                                <option value="">Выбрать</option>
                                                <option value="1">Государвственное</option>
                                                <option value="2">Негосударвственное</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Полное название <span class="req">*</span>

                                        </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="full_name" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Краткое название <span class="req">*</span>

                                        </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="short_name" value="" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Другие названия

                                        </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="other_names" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                              <!--   <div class="panel-heading">
                                    <h3 class="panel-title">ОБРАЗОВАНИЕ</h3>
                                </div> -->
                                <div class="panel-body">
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <input type="checkbox" onclick="institutionCheck(this)" name="secondary_inst" class="form-check-input" id="exampleCheck1">
                                                <label class="form-check-label" for="exampleCheck1">Отметьте, если это учебное заведение является факультетом, филиалом, отделением или иной аффилированной структурой в составе другого учебного заведения</label>
                                              </div> 
                                        </div> 

                                        <div class="parent_institution" style="display: none;">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-12 control-label">Родительское ВУЗ <span class="req">*</span></label>
                                                    <div class="col-md-12">
                                                        <select name="parent_institution" class="form-control">
                                                            <option value="">Выбрать</option>
                                                            @foreach($university as $item)
                                                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-12 control-label">Форма отношения <span class="req">*</span></label>
                                                    <div class="col-md-12">
                                                        <select name="form_attitude" class="form-control">
                                                            <option value="">Выбрать</option>
                                                            @foreach($univ_form_attitude as $item)
                                                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>          
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Год основания <span class="req">*</span></label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control number_field" name="year_of_foundation" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                    <input type="checkbox" name="has_hostel" class="form-check-input" id="exampleCheck2">
                                    <label class="form-check-label" for="exampleCheck2">Предоставляется общежитие</label>
                                  </div> 

                                  <div class="form-check">
                                    <input type="checkbox" name="has_military_department" class="form-check-input" id="exampleCheck3">
                                    <label class="form-check-label" for="exampleCheck3">Военная кафедра</label>
                                  </div> 
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" style="white-space: nowrap;">Лицензия № <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="license_nr" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" style="white-space: nowrap;">От <span class="req">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control datepicker" name="license_nr_from" value="" placeholder="DD/MM/YY" required>
                                        </div>
                                    </div> 
                                </div>

                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" style="white-space: nowrap;">Аккредитация № <span class="req">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="accreditation_nr" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" style="white-space: nowrap;">От <span class="req">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control datepicker" name="accreditation_nr_from" value="" placeholder="DD/MM/YY" required>
                                        </div>
                                    </div> 
                                </div>

                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Краткое описание</label>
                                        <div class="col-md-12">
                                            <textarea style="min-height: 150px;" class="form-control" name="description" placeholder="Не более 800 символов"></textarea>
                                        </div>
                                    </div> 

                                     
                                </div>
                            </div>
 
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Типы программ <span class="req">*</span></label>
                                        <div class="col-md-12">
                                            <select name="program_type"  class="form-control">
                                                <option value="">Выбрать</option>
                                                @foreach($programs_type as $item)
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

                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Номер телефона <span class="req">*</span>

                                        </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="phone" value=""
                                                   required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Номер телефона 2
                                        </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="phone2" value="">
                                        </div>
                                    </div>

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
                                        <label for="ed_institution"
                                               class="col-md-12 control-label">Основные рубрики <span class="req">*</span>
                                        </label>
                                        <div class="col-md-12">
                                            <select name="id_category"  class="form-control">
                                                <option value="">Выбрать</option>
                                                @foreach($teach_activ_cat as $item)
                                                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Факс  </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control"
                                                   name="fax" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Сайт  </label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control"
                                                   name="site" value="">
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
                                        Зарегистрироваться 
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
