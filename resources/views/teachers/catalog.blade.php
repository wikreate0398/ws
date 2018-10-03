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
            <div class="col-lg-12">
				<ul class="nav nav-tabs filter_tabs">
					<li class="{{ !request()->tab ? 'active' : '' }}">
						<a href="{{ addUriParam(['tab' => '']) }}">
							Все
						</a>
					</li>
					<li class="{{ (request()->tab == 'popular') ? 'active' : '' }}">
						<a href="{{ addUriParam(['tab' => 'popular', 'dateSort' => '', 'reviewSort' => '']) }}">
							Популярные
						</a>
					</li>
					<li class="{{ (request()->tab == 'for_exams') ? 'active' : '' }}">
						<a href="{{ addUriParam(['tab' => 'for_exams', 'dateSort' => '', 'reviewSort' => '']) }}">
							Подготовка к ЕГЭ
						</a>
					</li>
					<li class="{{ (request()->tab == 'featured') ? 'active' : '' }}">
						<a href="{{ addUriParam(['tab' => 'featured', 'dateSort' => '', 'reviewSort' => '']) }}">
							Рекомендуемые
						</a>
					</li>
					<!--
					<li class="{{ (request()->tab == 'discount') ? 'active' : '' }}">
						<a href="{{ addUriParam(['tab' => 'discount']) }}">
							Есть скидка
						</a>
					</li>-->
					<li class="{{ (request()->tab == 'online_training') ? 'active' : '' }}">
						<a href="{{ addUriParam(['tab' => 'online_training', 'dateSort' => '', 'reviewSort' => '']) }}">
							Онлайн обучение
						</a>
					</li>
				</ul>
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
                                    <a href="{{ addUriParam(['teacher_available' => '', 'dateSort' => '', 'reviewSort' => '']) }}">ВСЕ</a>
                                </li>
                                <li class="{{ (request()->input('teacher_available') == '1') ? 'active' : '' }}">
                                    <a href="{{ addUriParam(['teacher_available' => '1']) }}">СВОБОДЕН</a>
                                </li>
                                <li class="{{ (request()->input('teacher_available') == '0') ? 'active' : '' }}">
                                    <a href="{{ addUriParam(['teacher_available' => '0']) }}">ЗАНЯТ</a>
                                </li>
                            </ul>
                            <input type="hidden" 
                                   id="teacher_available" 
                                   value="{{ @request()->input('teacher_available') ? request()->input('teacher_available') : 'all' }}">
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-inline sorting_list">
	                           <li>
	                            	@php 
	                            		$dateSort = (request()->dateSort == 'asc') ? 'desc' : 'asc';  
	                            		$dateSortClass = (request()->dateSort == 'desc') ? 'fa-caret-down' : 'fa fa-caret-up';  
	                            		$dateSortStatus = request()->dateSort ? 'active' : '';  
	                            	@endphp
	                            	<a href="{{ addUriParam(['dateSort' => $dateSort, 'reviewSort' => '']) }}" class="{{ $dateSortStatus }}">
	                            		<i class="fa {{ $dateSortClass }}" aria-hidden="true"></i> ДАТА
	                            	</a>
	                            </li>
	                            <li>
	                            	@php 
	                            		$reviewSort = (request()->reviewSort == 'asc') ? 'desc' : 'asc';  
	                            		$reviewSortClass = (request()->reviewSort == 'desc') ? 'fa-caret-down' : 'fa fa-caret-up';  
	                            		$reviewSortStatus = request()->reviewSort ? 'active' : '';  
	                            	@endphp
	                            	<a href="{{ addUriParam(['reviewSort' => $reviewSort, 'dateSort' => '']) }}" class="{{ $reviewSortStatus }}">
	                            		<i class="fa {{ $reviewSortClass }}" aria-hidden="true"></i> ОТЗЫВЫ
	                            	</a>
	                            </li>
                            </ul>
                        </div>
                        <div class="col-lg-3" style="text-align: right;">
                            <ul class="list-inline per_page_list">
                                <li class="{{ (request()->input('per_page') == '6' or request()->input('per_page') == null) ? 'active' : '' }}">
                                    <a href="{{ addUriParam(['per_page' => '']) }}">6</a>
                                </li>
                                <li class="{{ (request()->input('per_page') == '12') ? 'active' : '' }}">
                                    <a href="{{ addUriParam(['per_page' => '12']) }}">12</a>
                                </li>
                                <li class="{{ (request()->input('per_page') == '24') ? 'active' : '' }}">
                                    <a href="{{ addUriParam(['per_page' => '24']) }}">24</a>
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
								<img class="img-responsive"
									 src="{{ imageThumb(@$teacher->image, 'uploads/users', 400, 500, 'list') }}"
									 title="Brain Incorporated | Учитель {{ $teacher['name'] }} образовательного портала России и мира"
									 alt="Корпорация Мозга | Учитель {{ $teacher['name'] }} образовательного портала России и мира">
							</a>
							@php
								$hasRequest = ($teachersRequests->setIdTeacher($teacher->id)
                                                                ->setIdUser(@Auth::user()->id)
                                                                ->setUserType(@Auth::user()->user_type)
                                                                ->canMakeRequest() === true) ? false : true; 
							@endphp
							<button @if($hasRequest==true && Auth::check() == true)
										disabled
									@endif
									type="button" 
							        class="btn submit_application"
							        onclick="teacherRequest(this, {{ $teacher->id }}, '{{ Auth::check() }}', '{{ @$hasRequest }}')">
							    Оставить заявку
							</button>
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
                              	@else
                                   	Без опыта
								@endif
								</span>
								<ul class="list-inline teachers_label">
                                    @if(@Auth::check()) 
                                        <li class="teachers_bookmark"> 
                                            <i class="fa {{ @in_array($teacher->id, $userTeacherBoockmarks) ? 'is_favorite fa-heart' : 'fa-heart-o' }}" 
                                               onclick="teacherBookmark(this, {{ $teacher->id }});" 
                                               aria-hidden="true"></i>
                                        </li>
                                    @endif

									<li class="teachers_employment">
										{{ $teacher->is_available ? 'Свободен' : 'Занят' }}
									</li>
									<li class="teachers_rating">
										<select class="rating-stars" name="rating" data-readonly="true" data-current-rating="{{ floatval($teacher->teacherReviews->avg('rating')) }}" autocomplete="off">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</li>
									<li class="teachers_comment">
										{{ $teacher->teacherReviews->count() }} {{ format_by_count($teacher->teacherReviews->count(), 'Отзыв', 'Отзыва', 'Отзывов') }}
									</li>
								</ul>
							</div>
							<div class="teachers_adress">
								<i class="fa fa-map-marker" aria-hidden="true"></i> {{ @$teacher->cityData->name }}, {{ @$teacher->address }}
							</div>

							@if(count($teacher->teacherSpecializations))			
							<ul class="list-inline teachers_specialization">
								@foreach($teacher->teacherSpecializations as $specialization)
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

                @if($minMaxPrice['min'] > 0 && $minMaxPrice['max'] > 0 && $minMaxPrice['min'] <> $minMaxPrice['max'])
				<div class="price_options">
					<div class="form-group">
					<label class="control-label">СТОИМОСТЬ ЧАСА</label>
						<input type="hidden" name="min_price" value="{{ @request()->input('min_price') }}" id="min_price">
						<input type="hidden" name="max_price" value="{{ @request()->input('max_price') }}" id="max_price">
						<div id="slider-range"></div>
						<input type="text" id="amount" readonly>
					</div>
				</div>
				@endif 

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
									<input value="{{ $specialization->id }}" 
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
									<input value="{{ $lesson_option->id }}" 
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