@extends('layouts.admin')
@section('content') 
<div class="row">
   <div class="col-md-12">
      <ul class="nav nav-tabs user_edit">
         <li class="active">
            <a data-toggle="tab" href="#panel1"> О Вас </a>
         </li>
         <li>
            <a data-toggle="tab" href="#panel2"> Я репетитор </a>
         </li>
         <li>
            <a data-toggle="tab" href="#panel3"> Сертификат/Диплом </a>
         </li>
      </ul>
      <form class="form-horizontal ajax__submit" method="POST" action="/{{ $method }}/{{ $user['id'] }}/update">
         {{ csrf_field() }}
         <input type="hidden" name="user_type" value="1">
         <div class="row" style="padding-top: 20px;">
            <div class="tab-content user_form">
               <div id="panel1" class="tab-pane fade in active">
                  <div class="col-md-12">
                     <h3 class="header_blok_user">Общий профиль</h3>
                  </div>
                  <label class="col-md-4 control-label">ВАШЕ ФИО <span class="req">*</span></label>
                  <div class="col-md-8">
                     <div class="form-group">
                        <input class="form-control" value="{{ $user->name }}" name="name" required type="text">
                     </div>
                  </div>
                  <label class="col-md-4 control-label">КОРОТКО  О ВАС <span class="req">*</span></label>
                  <div class="col-md-8">
                     <div class="form-group">
                        <textarea class="form-control" maxlength="1200" name="about" required autofocus="">{{ $user->about }}</textarea>
                        <div class="maxlength__label"><span>0</span> символов (1200 максимум)</div>
                     </div>
                  </div>
                  <label class="col-md-4 control-label">ДАТА РОЖДЕНИЯ <span class="req">*</span></label>
                  <div class="col-md-8">
                     <div class="form-group"> 
                        <input type="text" 
                           class="form-control datepicker ll-skin-melon" 
                           name="date_birth"
                           value="{{ !empty($user->date_birth) ? date('d.m.Y', strtotime($user->date_birth)) : '' }}" 
                           required 
                           autocomplete="off" 
                           placeholder="ДД.ММ.ГГГГ"> 
                     </div>
                  </div>
                  <label class="col-md-4 control-label">ВАШ ПОЛ <span class="req">*</span></label>
                  <div class="col-md-8">
                     <div class="form-group">
                        <div class="input-group">
                           <div class="icheck-inline"> 
                              <label style="padding-left: 0;">
                              <input type="radio" class="icheck" required name="sex" {{ ($user->sex=='female') ? 'checked' : '' }} id="inlineRadio1" value="female"> Женский
                              </label>
                              <label>
                              <input type="radio" class="icheck" name="sex" {{ ($user->sex=='male') ? 'checked' : '' }} id="inlineRadio2" value="male"> Мужской
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>
                  
                  <label class="col-md-4 control-label">Расположение</label>
                  <div class="col-md-8">
                     <div class="row">
                        <div class="col-md-12 regions__area" style="padding-left: 0px;">
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
                  </div>

                  <div class="col-md-12">
                     <h3 class="header_blok_user">Мое образование</h3>
                  </div>
                  <label class="col-md-4 control-label">ГДЕ ВЫ УЧИЛИСЬ?</label>
                  <div class="col-md-8">
                     @if(count($user->educations))
                     <?php $i=0; ?>
                     @foreach($user->educations as $education) 
                     <div class="row multi__container education__container {{ ($i == 0) ? 'first_block' : '' }}">
                        @if($i > 0)
                        <span class="close__item delete__item" 
                           onclick="Ajax.toDelete(this, 'users_educations', {{ $education->id }}, true)">X</span>
                        @endif
                        @include('admin.users.teacher.partials.grade_education')
                     </div>
                     <?php $i++ ?>
                     @endforeach
                     @else
                     <div class="row multi__container education__container first_block">
                        @include('admin.users.teacher.partials.grade_education')        
                     </div>
                     @endif  
                     <button class="btn btn-sm btn-dafault add__more" 
                        onclick="addBlock('education__container');" 
                        type="button">
                     + Добавить еще
                     </button> 
                  </div>
                  <div class="col-md-12">
                     <h3 class="header_blok_user">Контактные данные</h3>
                  </div>
                  <label class="col-md-4 control-label">АДРЕС <span class="req">*</span></label>
                  <div class="col-md-8">
                     <div class="form-group">
                        <input class="form-control" name="address" value="{{ $user->address }}" required type="text">
                     </div>
                  </div>
                  <label class="col-md-4 control-label">ТЕЛЕФОН <span class="req">*</span></label>
                  <div class="col-md-8">
                     <div class="form-group">
                        <input class="form-control" name="phone" value="{{ $user->phone }}" required type="text">
                     </div>
                  </div>
                  <div class="col-md-12">
                     <h3 class="header_blok_user">Регистрационные данные</h3>
                  </div>
                  <label class="col-md-4 control-label">E-MAIL <span class="req">*</span></label>
                  <div class="col-md-8">
                     <div class="form-group">
                        <input class="form-control" name="email" value="{{ $user->email }}" required type="text">
                     </div>
                  </div>
                  <label class="col-md-4 control-label">СТАРЫЙ ПАРОЛЬ <span class="req">*</span></label>
                  <div class="col-md-8">
                     <div class="form-group">
                        <input class="form-control" name="old_password" value="" type="password">
                     </div>
                  </div>
                  <label class="col-md-4 control-label">ПАРОЛЬ <span class="req">*</span></label>
                  <div class="col-md-8">
                     <div class="form-group">
                        <input class="form-control" name="password" value="" type="password">
                     </div>
                  </div>
                  <label class="col-md-4 control-label">ПОВТОРИТЕ ПАРОЛЬ <span class="req">*</span></label>
                  <div class="col-md-8">
                     <div class="form-group">
                        <input class="form-control" name="password_confirmation" value="" type="password">
                     </div>
                  </div>
               </div>
               <div id="panel2" class="tab-pane fade">
                  <div class="col-md-12">
                     <h3 class="header_blok_user">Я умею учить</h3>
                  </div>
                  <label class="col-md-4 control-label">СТЕПЕНЬ ВАШЕГО ОПЫТА <span class="req">*</span></label>
                  <div class="col-md-8">
                     <div class="form-group select_form">
                        <select class="form-control" name="grade_experience">
                           <option value="0">Выбрать</option>
                           @foreach($degree_experience as $item)
                           <option {{ ($user['grade_experience'] == $item->id) ? 'selected' : '' }} value="{{$item->id}}">
                           {{$item->name}}
                           </option>
                           @endforeach  
                        </select>
                     </div>
                  </div>
                  <label class="col-md-4 control-label">ОПЫТ РАБОТЫ УЧИТЕЛЕМ С <span class="req">*</span></label>
                  <div class="col-md-8">
                     <div class="form-group">
                        <input class="form-control datepicker ll-skin-melon" 
                           name="experience_from" 
                           value="{{ !empty($user->experience_from) ? date('d.m.Y', strtotime($user->experience_from)) : '' }}" 
                           required="" 
                           autocomplete="off" 
                           type="text">
                     </div>
                  </div>
                  <label class="col-md-4 control-label">СРЕДНЯЯ СТОИМОСТЬ ЧАСА (₽)<span class="req">*</span></label>
                  <div class="col-md-8">
                     <div class="form-group">
                        <input class="form-control rp" name="price_hour" value="{{ $user->price_hour }}" required="" type="text">
                     </div>
                  </div>
                  <div class="col-md-12">
                     <h3 class="header_blok_user">Ваша специализация</h3>
                  </div>
                  <div class="col-md-12">
                     @php
                     $teacher_specializations = array_map(function ($item) {
                     return $item['id_specialization'];
                     }, $teacher_specializations->toArray());    
                     @endphp
                     @foreach($specializations_list as $specialization)
                     <label class="checkbox-inline">
                     <input type="checkbox" 
                     {{ in_array($specialization->id, $teacher_specializations) ? 'checked' : '' }}
                     name="specializations[{{ $specialization->id }}]" 
                     id="specialization{{ $specialization->id }}"> {{ $specialization->name }}
                     </label>
                     @endforeach 
                  </div>
                  <div class="col-md-12">
                     <h3 class="header_blok_user">Ваша предметная область</h3>
                  </div>
                  <label class="col-md-4 control-label">ПРЕДМЕТЫ <span class="req">*</span></label>
                  <div class="col-md-8">
                     <div class="form-group">
                        <select name="" class="form-control teacher_subjects_select" onchange="teacherSubject(this)">
                           <option value="0">Выбрать</option>
                           @php
                              $teacherSubjectsId = $user->subjects->pluck('id')->toArray();
                           @endphp
                           @foreach($subjects_list as $subject) 
                              @php
                                 $disabled = '';
                                 if(in_array($subject->id, $teacherSubjectsId)){
                                 $disabled = 'disabled';
                                 }
                              @endphp
                              <option {{ $disabled }} value="{{ $subject->id }}">{{ $subject->name }}</option>
                           @endforeach
                        </select>
                        <div class="selected__teacher_subjects" style=" {{ !count($user->subjects) ? 'display: none;' : ''  }}">
                           @if(count($user->subjects))
                           @foreach($user->subjects as $subject)
                           <span id="teacher_subjects_{{ $subject->id }}" data-id="{{ $subject->id }}">
                              <div class="subject_tag"> 
                                 {{ $subject->name }} 
                              </div>
                              <div onclick="deleteTeacherSubject({{ $subject->id }});" class="delete__subject">
                                 <i class="fa fa-times" aria-hidden="true"></i>
                              </div>
                           </span>
                           @endforeach
                           @endif
                        </div>
                        <div class="selected__teacher_inputs">
                           @if(count($user->subjects))
                           @foreach($user->subjects as $subject)
                           <input type="hidden" id="teacher_subjects_input_{{ $subject->id }}" value="{{ $subject->id }}" name="teacher_subjects[]">
                           @endforeach
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <h3 class="header_blok_user">Варианты проведения занятий</h3>
                  </div>
                  <div class="col-md-12" style="margin-bottom: 15px;"> 
                     @php
                     $teacher_lesson_options = $user->lesson_options->pluck('id')->toArray() ;  
                     @endphp
                     @foreach($lesson_options_list as $lesson_option)
                     <label class="checkbox-inline">
                     <input type="checkbox" 
                     {{ in_array($lesson_option->id, $teacher_lesson_options) ? 'checked' : '' }}
                     name="lesson_options[{{ $lesson_option->id }}]" 
                     id="lesson_options_list{{ $lesson_option->id }}"> {{ $lesson_option->name }}
                     </label>
                     @endforeach 
                  </div>
                  <label class="col-md-4 control-label">У ВАС (РЕПЕТИТОРА) НА ДОМУ</label>
                  <div class="col-md-8">
                     <div class="form-group">
                        <textarea class="form-control" name="lesson_place" autofocus="">{{ $user->lesson_place }}</textarea>
                     </div>
                  </div>
               </div>
               <div id="panel3" class="tab-pane fade">
                  <div id="certificates__images" class="uploaderContainter" style="margin-bottom: 40px;">
                     @foreach($user->certificates as $certificate)
                     <div class='col-md-3 load-thumbnail'>
                        <div class="uploadedImg" 
                           style="background-image: url(/public/uploads/users/certificates/{{ $certificate->image }})"></div>
                        <div class='actions__upload_img'>
                           <span onclick='deleteUploadImg(this, {{ $certificate->id }}, {{ $user->id }})' class="delete__upload_img"></span> 
                        </div>
                     </div>
                     @endforeach
                     <div class="col-md-3 {{ !count($user->certificates) ? 'col-md-offset-4' : ''}}">
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
<style>
   .checkbox-inline, .radio-inline{
   padding-left: 0px;
   }
</style>
@stop