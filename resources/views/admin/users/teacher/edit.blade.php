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
                            <label class="col-md-12 control-label">Фамилия <span class="req">*</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="surname" value="{{ $user->surname }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Имя <span class="req">*</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}"
                                       required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Отчество <span class="req">*</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="patronymic"
                                       value="{{ $user->patronymic }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Город</label>
                            <div class="col-md-12">
                                <select name="city"  class="form-control">
                                    <option value="">Выбрать</option>
                                    @foreach($cities as $item)
                                        <option {{ ($user['city'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">{{$item['name']}}</option>
                                    @endforeach
                                </select>
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
                                       value="{{ date('d-m-Y', strtotime($user->date_birth)) }}" required placeholder="DD/MM/YY">
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

                    <div class="col-md-12">
                         <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">ОБРАЗОВАНИЕ</h3>
        </div>
        <div class="panel-body">
            <?php $i=0; ?>
            @foreach($usersEducations as $education) 
            <div class="row multi__container education__container {{ ($i == 0) ? 'first_block' : '' }}"> 
                @if($i > 0)
                    <a class="close__item delete__item" onclick="Ajax.toDelete(this, 'users_educations', '<?=$education['id']?>', true)">X</a>
                @endif
                <input type="hidden" class="id__block" name="edit_education[id][]" value="{{ $education['id'] }}">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="col-md-12 control-label">Время обучения <span class="req">*</span></label>
                        <div class="col-md-3">
                            <select name="edit_education[from][]"  class="form-control">
                                <option value="">С</option>
                                @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                    <option {{ ($education['from_year'] == $year) ? 'selected' : '' }} value="{{$year}}">{{$year}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="edit_education[to][]"  class="form-control">
                                <option value="">По</option>
                                @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                    <option {{ ($education['to_year'] == $year) ? 'selected' : '' }} value="{{$year}}">{{$year}}</option>
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
                                   name="edit_education[institution][]" value="{{ $education['institution_name'] }}" required>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label  
                               class="col-md-12 control-label">Кафедра</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control"
                                   name="edit_education[department][]" value="{{ $education['department'] }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label  
                               class="col-md-12 control-label">Примечания</label>
                        <div class="col-md-12">
                            <textarea name="edit_education[notes][]" class="form-control" style="min-height: 120px;">{{ $education['notes'] }}</textarea> 
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12 control-label">Специальность <span class="req">*</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control"
                                   name="edit_education[specialty][]" value="{{ $education['specialty'] }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12 control-label">Степень <span class="req">*</span></label>
                        <div class="col-md-12">
                            <select name="edit_education[grade][]"  class="form-control">
                                <option value="">Выбрать</option>
                                @foreach($grade_education as $item)
                                    @if(!empty($item['childs']))
                                        <optgroup label="{{$item['name']}}">
                                            @foreach($item['childs'] as $child)
                                                <option {{ ($education['grade'] == $child['id']) ? 'selected' : '' }} value="{{$child['id']}}">{{$child['name']}}</option>
                                            @endforeach
                                        </optgroup>
                                    @else
                                        <option {{ ($education['grade'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">
                                            {{$item['name']}}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div> 
                </div>
            </div>
            <?php $i++ ?>
            @endforeach

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
            <input type="checkbox" {{ (count($usersTeachingActivities) > 0) ? 'checked' : '' }} class="disable_block" onclick="disableBlock(this);">
        </div>
        <div class="panel-body">
            @if(count($usersTeachingActivities) > 0) 
                <?php $i=0; ?>
                @foreach($usersTeachingActivities as $activities) 
                <div class="row multi__container teach_activity_container {{ ($i == 0) ? 'first_block' : '' }}">
                    @if($i > 0)
                        <a class="close__item delete__item" onclick="Ajax.toDelete(this, 'users_teaching_activities', '<?=$activities['id']?>', true)">
                            X
                        </a> 
                    @endif
                    <input type="hidden" class="id__block" name="edit_teach_activity[id][]" value="{{ $activities['id'] }}">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Время работы <span class="req">*</span></label>
                            <div class="col-md-3">
                                <select name="edit_teach_activity[from][]"  class="form-control">
                                    <option value="">С</option>
                                    @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                        <option {{ ($activities['from_year'] == $year) ? 'selected' : '' }} value="{{$year}}">{{$year}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="edit_teach_activity[to][]"  class="form-control">
                                    <option value="">По</option>
                                    @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                        <option {{ ($activities['to_year'] == $year) ? 'selected' : '' }} value="{{$year}}">{{$year}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Учреждение <span class="req">*</span>
                            </label>
                            <div class="col-md-12">
                                <input type="text" class="form-control"
                                       name="edit_teach_activity[institution][]" value="{{ $activities['institution_name'] }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Должность <span class="req">*</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control"
                                       name="edit_teach_activity[position][]" value="{{ $activities['position'] }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Описание</label>
                            <div class="col-md-12">
                                <textarea style="min-height: 120px;" class="form-control" name="edit_teach_activity[description][]" placeholder="навыки, достижения, общее описание">{{ $activities['description'] }}</textarea>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Типы программ <span class="req">*</span></label>
                            <div class="col-md-12">
                                <select name="edit_teach_activity[program_type][]"  class="form-control">
                                    <option value="">Выбрать</option>
                                    @foreach($programs_type as $item)
                                        @if(!empty($item['childs']))
                                            <optgroup label="{{$item['name']}}">
                                                @foreach($item['childs'] as $child)
                                                    <option {{ ($activities['program_type'] == $child['id']) ? 'selected' : '' }} value="{{$child['id']}}">{{$child['name']}}</option>
                                                @endforeach
                                            </optgroup>
                                        @else
                                            <option {{ ($activities['program_type'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">{{$item['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Основные рубрики <span class="req">*</span>
                            </label>
                            <div class="col-md-12">
                                <select name="edit_teach_activity[id_category][]"  class="form-control">
                                    <option value="">Выбрать</option>
                                    @foreach($teach_activ_cat as $item)
                                        <option {{ ($activities['id_category'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">
                                            {{$item['name']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $i++ ?>
                @endforeach

            @else
        
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
                                        <option value="{{$item['id']}}">
                                            {{$item['name']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            @endif

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
                <input type="checkbox" {{ (count($usersWorkExperience) > 0) ? 'checked' : '' }} class="disable_block" onclick="disableBlock(this);">
            </div> 
        </div>
        <div class="panel-body">
            @if(count($usersWorkExperience) > 0)
                <?php $i=0; ?>
                @foreach($usersWorkExperience as $experience) 
                <div class="row multi__container work_experience_container {{ ($i == 0) ? 'first_block' : '' }}">
                    @if($i > 0)
                        <a class="close__item delete__item" onclick="Ajax.toDelete(this, 'users_work_experience', '<?=$experience['id']?>', true)">X</a> 
                    @endif
                    <input type="hidden" class="id__block" name="edit_work_experience[id][]" value="{{ $experience['id'] }}">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Время работы <span class="req">*</span></label>
                            <div class="col-md-3"> 
                                <select name="edit_work_experience[from][]"  class="form-control">
                                    <option value="">С</option>
                                    @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                        <option {{ ($experience['from_year'] == $year) ? 'selected' : '' }} value="{{$year}}">{{$year}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="edit_work_experience[to][]"  class="form-control">
                                    <option value="">По</option>
                                    @for($year = date('Y'); $year > (date('Y')-25); $year--)
                                        <option {{ ($experience['to_year'] == $year) ? 'selected' : '' }} value="{{$year}}">{{$year}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Учреждение <span class="req">*</span>
                            </label>
                            <div class="col-md-12">
                                <input type="text" class="form-control"
                                       name="edit_work_experience[institution][]" value="{{ $experience['institution_name'] }}">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Должность <span class="req">*</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control"
                                       name="edit_work_experience[position][]" value="{{ $experience['position'] }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Описание</label>
                            <div class="col-md-12">
                                <textarea style="min-height: 120px;" class="form-control" name="edit_work_experience[description][]" placeholder="навыки, достижения, общее описание">{{ $experience['description'] }}</textarea>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Направление <span class="req">*</span></label>
                            <div class="col-md-12">
                                <select name="edit_work_experience[direction][]"  class="form-control">
                                    <option value="">Выбрать</option>
                                    @foreach($work_experience_direction as $item)
                                        <option {{ ($experience['direction'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">{{$item['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label">Обязанности</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control"
                                       name="edit_work_experience[responsibility][]" value="{{ $experience['responsibility'] }}">
                            </div>
                        </div>
                    </div>
                </div>
                <?php $i++ ?>
                @endforeach

            @else 
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
            @endif

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
