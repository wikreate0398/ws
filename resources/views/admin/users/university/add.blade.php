@extends('layouts.admin')
 
@section('content') 
<div class="row">
	<div class="col-md-12">
		<form action="/{{ $method }}/create" class="form-horizontal ajax__submit"> 
            {{ csrf_field() }} 

            <div class="row" style="padding-top: 20px;">
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

                            <div class="row" style="justify-content: space-between; display: flex; align-items: center;">
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
                        Создать
                    </button>
                </div>
            </div>
        </form>
	</div>
</div>

@stop
