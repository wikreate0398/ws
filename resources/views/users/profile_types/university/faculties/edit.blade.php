@extends('layouts.app')
@section('content')    
<div class="container no__home">
   <div class="row">
      <div class="row">
         <div class="col-lg-10 col-lg-offset-1">
            <ul class="breadcrumb">
               <li><a href="/">Главная</a></li>
               <li><a href="{{ route(userRoute('user_profile')) }}">Личный кабинет</a></li>
               <li><a href="{{ route(userRoute('user_faculties')) }}">Факультеты</a></li>
               <li class="active">Редактировать Факультет</li>
            </ul>
            <h1 class="title_page">Редактировать Факультет</h1>
            <p class="title_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget.</p>
         </div>
      </div>
      <div class="row">
      
         <form class="ajax__submit course_form" method="POST" action="{{ route(userRoute('update_faculty'), ['id' => $faculty->id]) }}">
            {{ csrf_field() }}
            <div class="col-lg-8 col-lg-offset-2">

				<div class="row">
					 
                     <div class="col-md-12">
                        <h3 class="header_blok_course">О ФАКУЛЬТЕТЕ</h3>
                     </div>
                     <label class="col-md-5 control-label">НАЗВАНИЕ ФАКУЛЬТЕТА <span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <input class="form-control" name="name" value="{{ $faculty->name }}" type="text">
                        </div>
                     </div>
                     <div class="clearfix"></div>

                     <label class="col-md-5 control-label">ДЛИТЕЛЬНОСТЬ ОБУЧЕНИЯ (ЛЕТ) <span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <input class="form-control number_field" name="duration_learning" value="{{ $faculty->duration_learning }}" type="text">
                        </div>
                     </div>
                     <div class="clearfix"></div>

                     <label class="col-md-5 control-label">СРЕДНЕЕ КОЛИЧЕСТВО БАЛЛОВ <span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <input class="form-control number_field" value="{{ $faculty->average_nr_points }}" name="average_nr_points" type="text">
                        </div>
                     </div>
                     <div class="clearfix"></div>

                     <label class="col-md-5 control-label">КОЛИЧЕСТВО БЮДЖЕТНЫХ МЕСТ <span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <input class="form-control number_field" value="{{ $faculty->qty_budget }}" name="qty_budget" type="text">
                        </div>
                     </div>
                     <div class="clearfix"></div>

                     <label class="col-md-5 control-label">СТОИМОСТЬ ОБУЧЕНИЯ в ГОД (₽) <span class="req">*</span></label>
                     <div class="col-md-7">
                        <div class="form-group">
                           <input class="form-control number_field price__input" value="{{ $faculty->price }}" name="price" type="text">
                        </div>
                     </div>
                     <div class="clearfix"></div>

                    <div class="col-md-12">
                        <h3 class="header_blok_course">ФОРМЫ ОБУЧЕНИЯ</h3>
                    </div> 
                    <div class="col-md-12">
						<div class="form-group">
							<ul class="list-inline list_checkbox">	
								<li>
									<div class="checkbox">
									<label>
										<input name="type[full_time_learning]" {{ ($faculty->full_time_learning == 1) ? 'checked' : '' }} type="checkbox">
										<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
										ОЧНАЯ
									</label>
									</div>
								</li>
								<li>
									<div class="checkbox">
									<label>
										<input name="type[non_public_learning]" {{ ($faculty->non_public_learning == 1) ? 'checked' : '' }} type="checkbox">
										<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
										ЗАОЧНАЯ
									</label>
									</div>
								</li>
								<li>
									<div class="checkbox">
									<label>
										<input name="type[distance_learning]" {{ ($faculty->distance_learning == 1) ? 'checked' : '' }} type="checkbox">
										<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
										ДИСТАНЦИОННАЯ
									</label>
									</div>
								</li>
							</ul>
						</div>
					</div>

					<div class="col-md-12">
                        <h3 class="header_blok_course">ЭКЗАМЕНЫ ДЛЯ ПОСТУПЛЕНИЯ</h3>
                    </div> 

                    <label class="col-md-5 control-label">Предметы <span class="req">*</span>
					<p>Укажите предметы, которые вы преподаете</p>
					</label>
					<div class="col-md-7">
						<div class="form-group select_form">
							<select name="" class="form-control teacher_subjects_select" onchange="addSubject(this)">
   							<option value="0">Выбрать</option> 
                        @php
                           $facultySubjectsId = $faculty->subjects->pluck('id')->toArray();
                        @endphp
   							@foreach($subjects_list as $subject)  
                           @php
                              $disabled = '';
                              if(in_array($subject->id, $facultySubjectsId)){
                                 $disabled = 'disabled';
                              }
                           @endphp
   								<option {{ $disabled }} value="{{ $subject->id }}">{{ $subject->name }}</option>
   							@endforeach
   						</select>  
   						<div class="selected__teacher_labels" style=" {{ !count($faculty->subjects) ? 'display: none;' : ''  }}">
                        @if(count($faculty->subjects))
                           @foreach($faculty->subjects as $subject)
                              <span id="teacher_subjects_{{ $subject->id }}" data-id="{{ $subject->id }}">
                                 <div class="subject_tag"> 
                                    {{ $subject->name }} 
                                 </div>
                                 <div onclick="deleteSubject({{ $subject->id }});" class="delete__subject">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                 </div>
                              </span>
                           @endforeach
                        @endif
                     </div>
                     <div class="selected__teacher_inputs">
                        @if(count($faculty->subjects))
                           @foreach($faculty->subjects as $subject)
                              <input type="hidden" id="teacher_subjects_input_{{ $subject->id }}" value="{{ $subject->id }}" name="teacher_subjects[]">
                           @endforeach
                        @endif
                     </div> 
						</div>
					</div>  
				</div>
                
                <div class="row">
                  <div class="col-md-12">
                     <div id="error-respond"></div>
                     <button type="submit" class="btn btn_save" style="display: inline-block; width: auto;">
                     Редактировать 
                     </button>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div> 
@stop