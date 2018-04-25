@extends('layouts.admin')
 
@section('content') 
<div class="row">
	<div class="col-md-12">
		<form action="/{{ $method }}/create" class="form-horizontal ajax__submit"> 
            {{ csrf_field() }} 

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
                    
                <div class="col-md-12">
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
