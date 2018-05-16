<form class="form-horizontal ajax__submit" method="POST" action="{{ route('update_profile') }}">
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
                            <option {{ ($userUniversity->institution_type == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">{{$item['name']}}</option>
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
                        <option {{ ($userUniversity->status == '1') ? 'selected' : '' }} value="1">Государвственное</option>
                        <option {{ ($userUniversity->status == '2') ? 'selected' : '' }} value="2">Негосударвственное</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-12 control-label">Полное название <span class="req">*</span>

                </label>
                <div class="col-md-12">
                    <input type="text" class="form-control" name="full_name" value="{{ $userUniversity['full_name'] }}" required>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-12 control-label">Краткое название <span class="req">*</span>

                </label>
                <div class="col-md-12">
                    <input type="text" class="form-control" name="short_name" value="{{ $userUniversity['short_name'] }}" required>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-12 control-label">Другие названия

                </label>
                <div class="col-md-12">
                    <input type="text" class="form-control" name="other_names" value="{{ $userUniversity['other_names'] }}">
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
                        <input type="checkbox" {{ ($userUniversity['secondary_inst'] == '1') ? 'checked' : '' }} onclick="institutionCheck(this)" name="secondary_inst" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Отметьте, если это учебное заведение является факультетом, филиалом, отделением или иной аффилированной структурой в составе другого учебного заведения</label>
                      </div> 
                </div> 

                <div class="parent_institution" style="{{ ($userUniversity['secondary_inst'] == '1') ? 'display: block' : 'display: none' }}">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12 control-label">Родительское ВУЗ <span class="req">*</span></label>
                            <div class="col-md-12">
                                <select name="parent_institution" class="form-control">
                                    <option value="">Выбрать</option>
                                    @foreach($university as $item)
                                        <option {{ ($userUniversity->parent_institution == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">{{$item['name']}}</option>
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
                                        <option {{ ($userUniversity['form_attitude'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">{{$item['name']}}</option>
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
                    <input type="text" class="form-control number_field" name="year_of_foundation" value="{{ $userUniversity['year_of_foundation'] }}" required>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-check">
            <input type="checkbox" name="has_hostel" {{ ($userUniversity['has_hostel'] == '1') ? 'checked' : '' }} class="form-check-input" id="exampleCheck2">
            <label class="form-check-label" for="exampleCheck2">Предоставляется общежитие</label>
          </div> 

          <div class="form-check">
            <input type="checkbox" name="has_military_department" {{ ($userUniversity['has_military_department'] == '1') ? 'checked' : '' }} class="form-check-input" id="exampleCheck3">
            <label class="form-check-label" for="exampleCheck3">Военная кафедра</label>
          </div> 
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="form-group">
                <label class="col-md-4 control-label" style="white-space: nowrap;">Лицензия № <span class="req">*</span></label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="license_nr" value="{{ $userUniversity['license_nr'] }}" required>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label class="col-md-3 control-label" style="white-space: nowrap;">От <span class="req">*</span></label>
                <div class="col-md-9">
                    <input type="text" class="form-control datepicker" name="license_nr_from" 
                    value="{{!empty($userUniversity->license_nr_from) ? date('d.m.Y', strtotime($userUniversity->license_nr_from)) : ''}}" placeholder="ДД.ММ.ГГГГ" required> 

                </div>
            </div> 
        </div>

        <div class="col-md-7">
            <div class="form-group">
                <label class="col-md-4 control-label" style="white-space: nowrap;">Аккредитация № <span class="req">*</span></label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="accreditation_nr" value="{{ $userUniversity['accreditation_nr'] }}" required>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label class="col-md-3 control-label" style="white-space: nowrap;">От <span class="req">*</span></label>
                <div class="col-md-9">
                    <input type="text" class="form-control datepicker" name="accreditation_nr_from"
                     value="{{ !empty($userUniversity->accreditation_nr_from) ? date('d.m.Y', strtotime($userUniversity->accreditation_nr_from)) : '' }}" placeholder="ДД.ММ.ГГГГ" required>
                      
                </div>
            </div> 
        </div>

        <div class="col-md-12">

            <div class="form-group">
                <label class="col-md-12 control-label">Краткое описание</label>
                <div class="col-md-12">
                    <textarea style="min-height: 150px;" class="form-control" name="description" placeholder="Не более 800 символов">{{ $userUniversity['description'] }}</textarea>
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
                                        <option {{ ($userUniversity['program_type'] == $child['id']) ? 'selected' : '' }} value="{{$child['id']}}">{{$child['name']}}</option>
                                    @endforeach
                                </optgroup>
                            @else
                                <option {{ ($userUniversity['program_type'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">{{$item['name']}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-12 control-label">Номер телефона <span class="req">*</span>

                </label>
                <div class="col-md-12">
                    <input type="text" class="form-control" name="phone" value="{{ $user['phone'] }}"
                           required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-12 control-label">Номер телефона 2
                </label>
                <div class="col-md-12">
                    <input type="text" class="form-control" name="phone2" value="{{ $user['phone2'] }}">
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
                    <input type="email" class="form-control" name="email" value="{{ $user['email'] }}"
                           required>
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
                            <option {{ ($userUniversity['id_category'] == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">{{$item['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-12 control-label">Факс  </label>
                <div class="col-md-12">
                    <input type="text" class="form-control"
                           name="fax" value="{{ $user['fax'] }}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-12 control-label">Сайт  </label>
                <div class="col-md-12">
                    <input type="text" class="form-control"
                           name="site" value="{{ $user['site'] }}">
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
<form action="{{ route('update_pass') }}" class="form-horizontal ajax__submit">
   {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12"> 
            <div class="form-group">
                <label class="col-md-12 control-label">Старый Пароль <span class="req">*</span></label>
                <div class="col-md-12">
                    <input type="password" class="form-control" name="old_password"
                           value="" required>
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