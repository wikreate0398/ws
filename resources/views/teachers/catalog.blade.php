@extends('layouts.app')

@section('content')
    
    <div class="container" style="margin-top: 66px;">
        <div class="row">
            <div class="col-lg-12">
                <ul class="breadcrumb">
                    <li><a href="/">Главная</a></li>
                    <li class="active">Каталог преподавателей</li>
                </ul>
            </div>
        </div>
         
        <div class="row">
            <div class="col-lg-12">
                <h1 class="title_page">ВСЕ ПРЕПОДАВАТЕЛИ</h1>
            </div>
            <div class="col-lg-6 col-lg-offset-3">
				<form class="no_home teacher__search_form" id="search_form" action="/teachers" method="Get" data-url-autocomplete="/teachers/autocomplete" >
						<div class="input-group">
							<input name="q" 
								   autocomplete="off" 
								   class="form-control" 
								   id="search__input" 
								   placeholder="Введите ФИО преподавателя"
								   value="{{ @urldecode(request()->input('q')) }}">
							<div class="loaded__search_result"></div>
							<span class="input-group-btn">
								<button type="submit" class="btn btn_search">Начать поиск</button>
							</span>
						</div>
				</form>
            </div>
        </div>
        @if(!empty($teachers))  
        <div class="row">
            <div class="col-lg-9">
                <div class="filter_top">
                    <div class="row">
                        <div class="col-lg-3">
                            <ul class="list-inline available_list">
                                <li class="{{ (request()->input('teacher_available') == 'all' or request()->input('teacher_available') == null) ? 'active' : '' }}">
                                    <a data-availbale="all" onclick="teacher_available_filter(this); return false;" href="#">ВСЕ</a>
                                </li>
                                <li class="{{ (request()->input('teacher_available') == '1') ? 'active' : '' }}">
                                    <a data-availbale="1" onclick="teacher_available_filter(this); return false;" href="#">СВОБОДЕН</a>
                                </li>
                                <li class="{{ (request()->input('teacher_available') == '0') ? 'active' : '' }}">
                                    <a data-availbale="0" onclick="teacher_available_filter(this); return false;" href="#">ЗАНЯТ</a>
                                </li>
                            </ul>
                            <input type="hidden" 
                                   id="teacher_available" 
                                   value="{{ @request()->input('teacher_available') ? request()->input('teacher_available') : 'all' }}">
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-inline sorting_list">
                                <li><a href=""><i class="fa fa-caret-down" aria-hidden="true"></i> ДАТА</a></li>
                                <li><a href=""><i class="fa fa-caret-up" aria-hidden="true"></i> ОТЗЫВЫ</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3" style="text-align: right;">
                            <ul class="list-inline per_page_list">
                                <li class="{{ (request()->input('per_page') == '6' or request()->input('per_page') == null) ? 'active' : '' }}">
                                    <a data-perpage="6" onclick="teacher_perpage_filter(this); return false;" href="#">6</a>
                                </li>
                                <li class="{{ (request()->input('per_page') == '12') ? 'active' : '' }}">
                                    <a data-perpage="12" onclick="teacher_perpage_filter(this); return false;" href="#">12</a>
                                </li>
                                <li class="{{ (request()->input('per_page') == '24') ? 'active' : '' }}">
                                    <a data-perpage="24" onclick="teacher_perpage_filter(this); return false;" href="#">24</a>
                                </li>
                            </ul>
                            <input type="hidden" 
                                   id="per_page" 
                                   value="{{ @request()->input('per_page') ? request()->input('per_page') : '6' }}">

                            <input type="hidden" 
                                   id="page" 
                                   value="{{ @request()->input('page') ? request()->input('page') : '1' }}">
                        </div>
                    </div>
                </div>
                @foreach($teachers as $teacher)
				<div class="teachers_external_card">
					<div class="row">
						<div class="col-md-3"> 
							<a href="/teacher/{{ $teacher['id'] }}/">
								<img class="img-responsive" src="{{ imageThumb(@$teacher->image, 'uploads/users', 400, 500, 'list') }}">
							</a>
							<button type="button" class="btn submit_application">Оставить заявку</button>
							<span class="price_hour">От {{ $teacher->price_hour }} р/час</span>
						</div>
						<div class="col-md-9">
							<div class="teachers_name">
								<h2>
									<a href="/teacher/{{ $teacher['id'] }}/">
									@php
										$nameExplode = explode(' ', $teacher['name']);
										echo $nameExplode[0] . '<br>'; unset($nameExplode[0]);
										echo implode(' ', $nameExplode);
									@endphp
									</a> 
								</h2>
								<span class="teachers_date">{{ date('Y') - date('Y', strtotime($teacher->date_birth)) }} лет, 
                                @php 
                                    $d1 = new DateTime(date('Y-m-d'));
                                    $d2 = new DateTime($teacher->experience_from); 
                                    $diff = $d2->diff($d1);  
                                @endphp
								@if($teacher->experience_from) 
                                    @if($diff->y > 0 or $diff->m > 1 ) опыт работы  @endif 
                                    @if($diff->y > 0)
                                        {{ $diff->y }}
                                        @if($diff->y == 1)
                                            год
                                        @elseif($diff->y > 1 && $diff->y < 5)
                                            года
                                        @else
                                            лет
                                        @endif
                                    @endif
                                    
                                    @if($diff->m)
                                        @if($diff->y > 0) и @endif
                                         
                                        @if($diff->m == 1) 
                                            @if($diff->y > 0  && $diff->y > 0)
                                                {{ $diff->m }} месяц  
                                            @else
                                                Без опыта
                                            @endif 
 
                                        @elseif($diff->m > 1 && $diff->m < 5)
                                            {{ $diff->m }} месяца
                                        @else
                                            {{ $diff->m }} месяцев
                                        @endif
                                    @elseif($diff->y == 0 && $diff->m == 0)
                                        Без опыта
                                    @endif 
								@endif
								</span>
								<ul class="list-inline teachers_label">
									<li class="teachers_employment">
										{{ $teacher->is_available ? 'Свободен' : 'Занят' }}
									</li>
									<li class="teachers_rating">
										<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
									</li>
									<li class="teachers_comment">
										15 отзывов
									</li>
								</ul>
							</div>
							<div class="teachers_adress">
								<i class="fa fa-map-marker" aria-hidden="true"></i> {{ @$teacher->cityData->name }}, {{ @$teacher->address }}
							</div>

							@if(count($teacher->specializations))			
							<ul class="list-inline teachers_specialization">
								@foreach($teacher->specializations as $specialization)
								<li>
									{{ $specialization->name }}
								</li>
                                @endforeach
							</ul>
                            @endif
                            @if(count($teacher->subjects))
							<ul class="list-inline teachers_subjects">
								@foreach($teacher->subjects as $subject)
									<li>{{ $subject->name }}</li>
								@endforeach                                            
							</ul>
							@endif
							<div class="teachers_about">
								<p>{{ str_limit($teacher->about, 160, '...') }}</p>
							</div>
							@if(count($lesson_options))
							<ul class="list-inline place_realization">	
								@foreach($lesson_options as $lesson_option)
								<li>
									<div class="checkbox">
									  <label>
										<input type="checkbox" value="" disabled {{ in_array($lesson_option['id'], $teacher->lesson_options->pluck('id')->toArray()) ? 'checked' : '' }}>
										<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
										{{ $lesson_option->name2 ? $lesson_option->name2 : $lesson_option->name }}
									  </label>
									</div>
								</li>
								@endforeach 
							</ul>
							@endif
						</div>
					</div>
				</div>
                @endforeach

                {{ $teachers->appends(request()->input())->links() }}
            </div>
            <div class="col-lg-3">
			<div class="filter_block">
				 
				@if(!empty($subjects))
                    <div class="subjects_teacher">
                        @php  
                        	$subjectsArr = [];
                        	if(@request()->input('subjects'))
                        	{
								$subjectsArr = explode(',', request()->input('subjects'));
                        	} 
						@endphp
                        <select class="form-control" id="subjects" onchange="subjectsFilter(this)">
                            <option value="0">Выбрать</option>
                            @foreach($subjects as $subject)
                            	@php
									$disabled = '';
									if(in_array($subject->id, $subjectsArr)){
										$disabled = 'disabled';
									}
								@endphp
                                <option {{ $disabled }} 
                                        {{ (request()->input('subject') == $subject->name) ? 'selected' : '' }} 
                                        value="{{ $subject->id }}">
                                    {{ $subject->name }}
                                </option> 
                            @endforeach
                        </select>
						
						@if(!empty($subjectsArr))
                        <div class="subjects_filter__tags"> 
                        	@foreach($subjects as $subject)
                        		@if(in_array($subject['id'], $subjectsArr))
									<span id="teacher_subjects_{{ $subject->id }}" data-id="{{ $subject->id }}">
										<div class="subject_tag"> 
											{{ $subject->name }} 
										</div>
										<div onclick="deleteFilterSubject({{ $subject->id }});" class="delete__subject">
											<i class="fa fa-times" aria-hidden="true"></i>
										</div>
									</span>
								@endif
                        	@endforeach 
                        </div>
                        @endif

                        <div class="subjects_filter__inputs">
                        	@if(!empty($subjectsArr)) 
	                        	@foreach($subjectsArr as $key => $subjectId)
									<input type="hidden" 
									       id="teacher_subject_input_{{ $subjectId }}" 
									       class="teacher_subjects" 
									       value="{{ $subjectId }}">
	                        	@endforeach
                        	@endif
                        </div>
                    </div>
                @endif 
				 
				<div class="sex_person">
					@php  
						$sexArr = explode(',', request()->input('sex'));
					@endphp
					<div class="checkbox">
						<label>
							<input class="sex" 
							       name="" 
							       type="checkbox" 
							       value="male" 
							       {{ (in_array('male', $sexArr)) ? 'checked' : '' }}>
							<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
							Мужчина
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input name="" 
							       class="sex" 
							       value="female" 
							       type="checkbox" 
							       {{ (in_array('female', $sexArr)) ? 'checked' : '' }}>
							<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
							Женшина
						</label>
					</div>
				</div>				 

				@if(!empty($specializations))
                    <div class="specializations_teacher">
                        @php
                            $specializationsArray = [];
                            if(request()->input('specializations')){
                                $specializationsArray = explode(',', request()->input('specializations'));
                            }
                        @endphp
                        @foreach($specializations as $specialization) 
                            <div class="checkbox">
								<label>
									<input value="{{ $specialization->id_specialization }}" 
									       class="specialization_input"
                                           {{ in_array($specialization->id, $specializationsArray) ? 'checked' : '' }}
                                           type="checkbox">
									<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
									{{ $specialization->name }}
								</label>
							</div> 
                        @endforeach
                    </div>
                @endif
				 
				@if($minMaxPrice['min'] > 0 && $minMaxPrice['max'] > 0 && $minMaxPrice['min'] <> $minMaxPrice['max'])
				<div class="price_options">
					<div class="form-group">
					<label class="control-label">СТОИМОСТЬ ЧАСА</label>
						<input type="hidden" name="min_price" value="{{ @request()->input('min_price') }}" id="min_price">
						<input type="hidden" name="max_price" value="{{ @request()->input('max_price') }}" id="max_price">
						<div id="slider-range"></div>
						<input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
					</div>
				</div>
				@endif

				@if(!empty($lesson_filter_options))  
					<div class="lesson_options"> 
				 		@php
	                        $lessonOptionsArray = [];
	                        if(request()->input('lesson_options')){
	                            $lessonOptionsArray = explode(',', request()->input('lesson_options'));
	                        }
	                    @endphp
	                    @foreach($lesson_filter_options as $lesson_option)  
	                        <div class="checkbox">
								<label>
									<input value="{{ $lesson_option->id_lesson_option }}" 
	                                       class="lesson_option_input"
	                                       {{ in_array($lesson_option->id, $lessonOptionsArray) ? 'checked' : '' }} 
	                                       type="checkbox">
									<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>  
                                    {{ $lesson_option->name2 ? $lesson_option->name2 : $lesson_option->name }} 
								</label>
							</div>
	                    @endforeach 
					</div>
				@endif

				@if(request()->input('flt') == 1)
                    <div class="reset_filter">
						<a href="/teachers">Сбросить фильтр </a>
					</div> 
                @endif
			</div>
                <script>
                	var minMaxPrice = {'min':parseFloat({{ $minMaxPrice['min'] }}), 'max': parseFloat({{ $minMaxPrice['max'] }})}; 
                </script> 
            </div>
        </div>

        @endif
    </div>
@stop