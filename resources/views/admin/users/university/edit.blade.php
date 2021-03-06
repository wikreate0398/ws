@extends('layouts.admin')
 
@section('content') 
    <div class="row">
    	<div class="col-md-12">
    	    <form class="form-horizontal ajax__submit" method="POST" action="/{{ $method }}/{{ $user['id'] }}/update">
                <div class="col-lg-12">
        <ul class="nav nav-tabs user_edit">
            <li class="active">
                <a data-toggle="tab" href="#profile">Профиль ВУЗА</a>
            </li>
            <li>
                <a data-toggle="tab" href="#information">Общая информация</a>
            </li>
            <li>
                <a data-toggle="tab" href="#certificate"> Сертификат/Диплом </a>
            </li>
        </ul>
    </div>
    {{ csrf_field() }}
    <input type="hidden" name="user_type" value="3">
<div class="row"> 
    <div class="col-lg-12">
        <div class="tab-content user_form">
            <div id="profile" class="tab-pane fade in active">
                <div class="col-md-12">
                    <h3 class="header_blok_user">Общий профиль</h3>
                </div>
                <label class="col-md-4 control-label">НАЗВАНИЕ ВУЗА <span class="req">*</span></label>
                <div class="col-md-8">
                    <div class="form-group">
                        <input class="form-control" value="{{ $userUniversity['full_name'] }}" name="name" type="text">
                    </div>
                </div>
                <div class="clearfix"></div>
                <label class="col-md-4 control-label">КОРОТКО  О ВУЗе <span class="req">*</span>
                <p>Кратко опишите преимущества вашего ВУЗа</p>
                </label>
                <div class="col-md-8">
                    <div class="form-group">
                        <textarea class="form-control" maxlength="800" name="description">{{ $user['about'] }}</textarea>
                        <div class="maxlength__label"><span>0</span> символов (800 максимум)</div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <label class="col-md-4 control-label">ДАТА ОСНОВАНИЯ <span class="req">*</span></label>
                <div class="col-md-8">
                    <div class="form-group">
                        <input class="form-control datepicker" autocomplete="off" name="year_of_foundation" value="{{ !empty($userUniversity->year_of_foundation) ? date('d.m.Y', strtotime($userUniversity->year_of_foundation)) : '' }}" type="text">
                    </div>
                </div>
                <div class="clearfix"></div>
                <label class="col-md-4 control-label">ГОРОД <span class="req">*</span>
                <p>Укажите город, в котором распологается основной филиал Вашего ВУЗа</p>
                </label>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12 regions__area">
                            <div class="form-group select_form">
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
                        <div class="cities__area col-md-6" style="display: none;"></div> 
                    </div>
                </div> 
                <script>
                    $(window).load(function(){ $('select#select__regions').change(); });
                </script> 

                <div class="clearfix"></div>
                <div class="col-md-12">
                    <h3 class="header_blok_user">КОНТАКТНЫЕ ДАННЫЕ</h3>
                </div>
                <label class="col-md-4 control-label">АДРЕС ВУЗА<span class="req">*</span></label>
                <div class="col-md-8">
                    <div class="form-group">
                        <input class="form-control" value="{{ $user['address'] }}" name="address" type="text">
                    </div>
                </div>
                <div class="clearfix"></div>
                <label class="col-md-4 control-label">АДРЕС САЙТА<span class="req"></span></label>
                <div class="col-md-8">
                    <div class="form-group">
                        <input class="form-control" value="{{ $user['site'] }}" name="site" type="text">
                    </div>
                </div>
                <div class="clearfix"></div>
                <label class="col-md-4 control-label">ТЕЛЕФОН<span class="req">*</span></label>
                <div class="col-md-8">
                    <div class="form-group">
                        <input class="form-control" value="{{ $user['phone'] }}" name="phone" type="text">
                    </div>
                </div>
                <div class="clearfix"></div>
                <label class="col-md-4 control-label">Отделы</label>
                <div class="col-md-8">
                    <div class="form-group">
                        @if(count($user->universityDepartment))
                            <?php $i=0; ?>
                            @foreach($user->universityDepartment as $department)
                                <div class="row multi__container education__container {{ ($i == 0) ? 'first_block' : '' }}">
                                    @if($i > 0)
                                        <a class="close__item delete__item" href="{{ route(userRoute('delete_department'), ['id' => $department->id]) }}">X</a>
                                    @endif
                                    @include('users.profile_types.university.partials.department')
                                </div>
                                <?php $i++ ?>
                            @endforeach
                        @else
                            <div class="row multi__container education__container first_block">
                                @include('users.profile_types.university.partials.department')
                            </div>
                        @endif

                        <button class="btn btn-sm btn-dafault add__more"
                                onclick="addBlock('education__container');"
                                type="button">
                            + Добавить еще
                        </button>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br>
                <label class="col-md-4 control-label">Месторасположение<span class="req">*</span></label>
                <div class="col-md-8">
                    <div class="form-group">
                        <div id="map"
                             data-name="{{ $user->university->full_name }}"
                             style="width: 100%; height: 400px"></div>
                        <input type="hidden" id="placemark" name="placemark" value="{{ $user->university->placemark }}">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <h3 class="header_blok_user">РЕГИСТРАЦИОННЫЕ ДАННЫЕ</h3>
                </div>
                <label class="col-md-4 control-label">E-MAIL<span class="req">*</span></label>
                <div class="col-md-8">
                    <div class="form-group">
                        <input class="form-control" value="{{ $user['email'] }}" autocomplete="off" name="email" type="text">
                    </div>
                </div> 

                <?php if (false): ?> 
                    <label class="col-md-4 control-label">СТАРЫЙ ПАРОЛЬ <span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control" autocomplete="off" name="old_password" value="" type="password">
                        </div>
                    </div>
                    <label class="col-md-4 control-label">ПАРОЛЬ<span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control" autocomplete="off" name="password" type="password">
                        </div>
                    </div>
                    <label class="col-md-4 control-label">ПОВТОРИТЕ ПАРОЛЬ<span class="req">*</span></label>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control" autocomplete="off" name="password_confirmation" type="password">
                        </div>
                    </div> 
                <?php endif ?>
            </div>
            <div id="information" class="tab-pane fade">
                <div class="col-md-12">
                    <h3 class="header_blok_user">РЕГИСТРАЦИОННЫЕ ДАННЫЕ</h3>
                </div>
                <label class="col-md-4 control-label">ТИП ВУЗА<span class="req">*</span>
                <p>Укажите, в каком городе вы расположены, и где преподаете</p>
                </label>
                <div class="col-md-8">
                    <div class="form-group select_form">
                        <select name="status" class="form-control">
                            <option value="">Выбрать</option>
                            <option {{ ($userUniversity->status == '1') ? 'selected' : '' }} value="1">Государвственное</option>
                            <option {{ ($userUniversity->status == '2') ? 'selected' : '' }} value="2">Коммерческий</option>
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <label class="col-md-4 control-label">СРЕДНЯЯ СТОИМОСТЬ ОБУЧЕНИЯ (₽)<span class="req">*</span>
                <p>Укажите, примерную стоимость обучения в год</p>
                </label>
                <div class="col-md-8">
                    <div class="form-group">
                        <input class="form-control number_field rp" value="{{ $userUniversity->price }}" name="price" type="text">
                    </div>
                </div>
                <div class="clearfix"></div>
                <label class="col-md-4 control-label">КОЛИЧЕСТВО МЕСТ НА БЮДЖЕТНОЙ ОСНОВЕ
                </label>
                <div class="col-md-8">
                    <div class="form-group">
                        <input class="form-control number_field" value="{{ $userUniversity->qty_budget }}" name="qty_budget" type="text">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <h3 class="header_blok_user">СРЕДНИЙ БАЛ ДЛЯ ПОСТУПЛЕНИЯ</h3>
                </div>
                <label class="col-md-4 control-label">БЮДЖЕТНАЯ ОСНОВА<span class="req">*</span>
                <p>Укажите среднее количество баллов для поступления</p>
                </label>
                <div class="col-md-8">
                    <div class="form-group">
                        <input class="form-control number_field" value="{{ $userUniversity->budget_points_admission }}" name="budget_points_admission" type="text">
                    </div>
                </div>
                <div class="clearfix"></div>
                <label class="col-md-4 control-label">ПЛАТНАЯ ОСНОВА<span class="req">*</span>
                <p>Укажите среднее количество баллов для поступления</p>
                </label>
                <div class="col-md-8">
                    <div class="form-group">
                        <input class="form-control" value="{{ $userUniversity->payable_points_admission }}" name="payable_points_admission" type="text">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <h3 class="header_blok_user">ВАША СПЕЦИАЛИЗАЦИЯ</h3>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <ul class="list-inline list_checkbox">  
                            @php
                                $university_specializations = array_map(function ($item) {
                                    return $item['id_specialization'];
                                }, $university_specializations->toArray());    
                            @endphp
                            @foreach($specializations as $specialization)
                                <li>
                                    <div class="checkbox">
                                    <label>
                                        <input {{ in_array($specialization->id, $university_specializations) ? 'checked' : '' }} name="specializations[{{ $specialization->id }}]" type="checkbox">
                                         
                                        {{ $specialization['name'] }}
                                    </label>
                                    </div>
                                </li> 
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-12">
                    <h3 class="header_blok_user">НАЛИЧИЕ ИНФРАСТРУКТУРЫ И ВОЕННОЙ КАФЕДРЫ</h3>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <ul class="list-inline list_checkbox">  
                            <li>
                                <div class="checkbox">
                                <label>
                                    <input name="has_military_department" {{ ($userUniversity['has_military_department'] == '1') ? 'checked' : '' }} type="checkbox"> 
                                    Военная кафедра
                                </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox">
                                <label>
                                    <input name="has_hostel" {{ ($userUniversity['has_hostel'] == '1') ? 'checked' : '' }} type="checkbox"> 
                                    Общежитие
                                </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox">
                                <label>
                                    <input name="distance_learning" {{ ($userUniversity['distance_learning'] == '1') ? 'checked' : '' }} type="checkbox"> 
                                    Дистанционное обучение
                                </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="certificate" class="tab-pane fade">
                <div id="certificates__images" class="uploaderContainter" style="margin-bottom: 40px;">
 
                    @foreach($user->certificates as $certificate)
                        <div class='col-md-4 load-thumbnail'> 
                             
                            <div class="uploadedImg" 
                                 style="background-image: url(/public/uploads/users/certificates/{{ $certificate->image }})"></div>
                            <div class='actions__upload_img'>
                                <span onclick='deleteUploadImg(this, {{ $certificate->id }}, {{ $user->id }})' class="delete__upload_img"></span>
                            </div>
                        </div>
                    @endforeach
                     
                    <div class="col-md-4 {{ !count($user->certificates) ? 'col-md-offset-4' : ''}}">
                        <div class="certificateLoadArea">
                            <input type="file" 
                               name="diploms[]" 
                               multiple 
                               id="certificateInpuT" 
                               onchange="multipleImages(this, '#certificates__images')">
                             <span class="file__input_name"> Добавить или перетащить <br> сюда изображение</span>
                        </div>
                    </div>
                     
                </div>  
            </div>
            <div class="col-lg-12">
                <div id="error-respond"></div>
                <button type="submit" class="btn btn_save">
                    Сохранить
                </button>
            </div>
        </div>
    </div></div>
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
