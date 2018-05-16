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
				<form class="no_home" id="search_form" data-url-autocomplete="/teachers/autocomplete" >
						<div class="input-group">
							<input name="q" 
								   autocomplete="off" 
								   class="form-control" 
								   id="search__input" 
								   placeholder="Введите ФИО преподавателя">
							<div class="loaded__search_result"></div>
							<span class="input-group-btn">
								<button type="button" class="btn btn_search">Начать поиск</button>
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
                            <?php $img = !empty($teacher['image']) ? '/public/uploads/users/' . $teacher['image'] : noImg()  ?>
							<a href="/teacher/{{ $teacher['id'] }}/"><img class="img-responsive" src="{{ $img }}"></a>
							<button type="button" class="btn submit_application">Оставить заявку</button>
							<span class="price_hour">От {{ $teacher->price_hour }} р/час</span>
						</div>
						<div class="col-md-9">
							<div class="teachers_name">
								<h2>{{ $teacher['name'] }}</h2>
								<span class="teachers_date">{{ date('Y') - date('Y', strtotime($teacher->date_birth)) }} лет, 
								@if($teacher->experience_from)
									опыт работы {{date('Y') - date('Y', strtotime($teacher->experience_from)) }} лет
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
								<p>{{ $teacher->about }}</p>
							</div>
							@if(count($lesson_options))
							<ul class="list-inline place_realization">	
								@foreach($lesson_options as $lesson_option)
								<li>
									<div class="checkbox">
									  <label>
										<input type="checkbox" value="" disabled {{ in_array($lesson_option['id'], $teacher->lesson_options->pluck('id')->toArray()) ? 'checked' : '' }}>
										<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
										{{ $lesson_option->name }}
									  </label>
									</div>
								</li>
								@endforeach 
							</ul>
							@endif
							<!--<ul class="list-inline place_realization">
								<li>
									<div class="checkbox">
									  <label>
										<input type="checkbox" value="" checked disabled>
										<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
										Выезд
									  </label>
									</div>
								</li>
								<li>
									<div class="checkbox">
									  <label>
										<input type="checkbox" value="" checked disabled>
										<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
										Занятия в группе
									  </label>
									</div>
								</li>
								<li>
									<div class="checkbox">
									  <label>
										<input type="checkbox" value="" checked disabled>
										<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
										Индивидуально
									  </label>
									</div>
								</li>
								<li>
									<div class="checkbox">
									  <label>
										<input type="checkbox" value="" disabled>
										<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
										Онлайн
									  </label>
									</div>
								</li>
							</ul> -->
						</div>
					</div>
				</div>
                <!--<div class="teachers_external_card">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="left_teachers_external_card">
                                <?php $img = !empty($teacher['image']) ? '/public/uploads/users/' . $teacher['image'] : noImg()  ?>
                                <a href="/teacher/{{ $teacher['id'] }}/" 
                                   class="img__teacher"  
                                   style="background-image: url({{ $img }})"></a>
                                <span>{{ $teacher->is_available ? 'Свободен' : 'Занят' }}</span>
                                <a class="more_link" href="/teacher/{{ $teacher['id'] }}/">Подробнее</a>
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <div class="right_teachers_external_card">
                                <div class="row">
                                    <div class="col-lg-9">
                                        <h2> <a href="/teacher/{{ $teacher['id'] }}/"> {{ $teacher['name'] }}</a> <br>
                                            <span>{{ date('Y') - date('Y', strtotime($teacher->date_birth)) }} лет

                                                @if($teacher->experience_from) 
                                                    , опыт преподавания {{date('Y') - date('Y', strtotime($teacher->experience_from)) }} лет
                                                @endif 
                                            </span>
                                        </h2>

                                        @if(count($teacher->specializations))
                                        <ul class="list-inline">
                                            @foreach($teacher->specializations as $specialization)
                                                <li>{{ $specialization->name }}</li>
                                            @endforeach
                                        </ul>
                                        @endif

                                        @if(count($teacher->subjects))
                                        <b>предметы</b>
                                        <ul class="list-inline">
                                            @foreach($teacher->subjects as $subject)
                                                <li>{{ $subject->name }}</li>
                                            @endforeach                                            
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="col-lg-3">
                                        <span> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </span>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="teacher_about">
                                            {{ $teacher->about }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="list-inline nav-justified type_training">
                                            @if(count($lesson_options))
                                                @foreach($lesson_options as $lesson_option)
                                                <li class="{{ in_array($lesson_option['id'], $teacher->lesson_options->pluck('id')->toArray()) ? 'active' : '' }}"> 
                                                    <i class="fa fa-chevron-circle-down"></i>
                                                    {{ $lesson_option->name }}
                                                </li>
                                                @endforeach 
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="price_block">
                                            Стоимость<br><span>от {{ $teacher->price_hour }}/час</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <button class="btn">Оставить заявку</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
                @endforeach

                {{ $teachers->appends(request()->input())->links() }}
            </div>
            <div class="col-lg-3">
			<div class="filter_block">
				<div class="sex_person">
					<div class="checkbox">
						<label>
							<input name="" type="checkbox">
							<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
							Мужчина
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input name="" type="checkbox">
							<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
							Женшина
						</label>
					</div>
				</div>
				<div class="specializations_teacher">
					<div class="checkbox">
						<label>
							<input name="" type="checkbox">
							<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
							Дошкольник
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input name="" type="checkbox">
							<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
							1-3 Класс
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input name="" type="checkbox">
							<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
							4-9 Класс
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input name="" type="checkbox">
							<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
							10-11 Класс
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input name="" type="checkbox">
							<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
							Подготовка к ЕГЭ
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input name="" type="checkbox">
							<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
							Подготовка к ОГЭ
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input name="" type="checkbox">
							<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
							Вступительные экзамены
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input name="" type="checkbox">
							<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
							Студентам вузов
						</label>
					</div>
				</div>
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
				<div class="lesson_options">
					<div class="checkbox">
						<label>
							<input name="" type="checkbox">
							<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
							Выезд
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input name="" type="checkbox">
							<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
							Занятие в группе
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input name="" type="checkbox">
							<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
							Индивидуально
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input name="" type="checkbox">
							<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
							Онлайн
						</label>
					</div>
				</div>
				<div class="reset_filter">
					<a href="">Сбросить фильтр </a>
				</div>
			</div>
                <script>
                    $(document).ready(function(){
                        var minMaxPrice = {'min':parseFloat({{ $minMaxPrice['min'] }}), 'max': parseFloat({{ $minMaxPrice['max'] }})};
                        if (minMaxPrice.min > 0 && minMaxPrice.max > 0 && minMaxPrice.max != minMaxPrice.min) {

                            var inputMin = parseFloat($('input#min_price').val());
                            var inputMax = parseFloat($('input#max_price').val()); 
                            valueMin = (inputMin > 0 && inputMin >= minMaxPrice.min && inputMin <= minMaxPrice.max) ? inputMin : minMaxPrice.min;
                            valueMax = (inputMax > 0 && inputMax >= minMaxPrice.min && inputMax <= minMaxPrice.max) ? inputMax : minMaxPrice.max;
                             
                            $( "#slider-range" ).slider({
                                range: true,
                                min: minMaxPrice.min,
                                max: minMaxPrice.max,
                                values: [ valueMin, valueMax ],
                                slide: function( event, ui ) {
                                    $( "#amount" ).val( "₽" + ui.values[ 0 ] + " - ₽" + ui.values[ 1 ] );
                                },
                                stop: function(){
                                    $('input#min_price').val($( "#slider-range" ).slider( "values", 0 ));
                                    $('input#max_price').val($( "#slider-range" ).slider( "values", 1 ));
                                    teacherFilter();
                                }
                            });
                            $( "#amount" ).val( "₽" + $( "#slider-range" ).slider( "values", 0 ) +
                            " - ₽" + $( "#slider-range" ).slider( "values", 1 ) );
                            $('input#min_price').val($( "#slider-range" ).slider( "values", 0 ));
                            $('input#max_price').val($( "#slider-range" ).slider( "values", 1 ));
                        }
                    
                        $('div.filter_block form').find('input').change(function(){
                            teacherFilter();
                        });

                        $('div.filter_block form').find('select').change(function(){
                            teacherFilter();
                        });
                    });

                    function teacherFilter(){
                        var teacher_available = $('input#teacher_available').val();
                        var per_page  = $('input#per_page').val();
                        var page      = $('input#page').val();
                        var subject   = $('select#subjects').val();
                        var sex       = $('input.sex:checked').val();
                        var min_price = $('input#min_price').val();
                        var max_price = $('input#max_price').val();

                        var specializations = '';
                        if ($('input.specialization_input').length > 0) {
                        pluser='';  
                            $.each($('input.specialization_input'),function() {
                                if ($(this).is(':checked')) {
                                    specializations+=pluser+$(this).val();
                                    pluser=',';
                                }
                            });
                        }

                        var lesson_options = '';
                        if ($('input.lesson_option_input').length > 0) {
                        pluser='';  
                            $.each($('input.lesson_option_input'),function() {
                                if ($(this).is(':checked')) {
                                    lesson_options+=pluser+$(this).val();
                                    pluser=',';
                                }
                            });
                        }

                        flt='?flt=1';
                        if(teacher_available) flt+='&teacher_available='+teacher_available;
                        if(subject != '0') flt+='&subject='+subject;
                        if(sex) flt+='&sex='+sex;
                        if(min_price) flt+='&min_price='+min_price;
                        if(max_price) flt+='&max_price='+max_price;
                        if(specializations) flt+='&specializations='+specializations;
                        if(lesson_options) flt+='&lesson_options='+lesson_options;
                        if(per_page) flt+='&per_page='+per_page;
                        if(page) flt+='&page=1';

                        olink='/teachers';  
                        var redirect=olink+flt;  
                        window.location=redirect;
                    }

                    function teacher_available_filter(item){
                        var value = $(item).attr('data-availbale');
                        $('input#teacher_available').val(value);

                        teacherFilter();
                    }

                    function teacher_perpage_filter(item){
                        var value = $(item).attr('data-perpage');
                        $('input#per_page').val(value);

                        teacherFilter();
                    }

                </script>

                <div class="filter_block">
                    <form action="">
                        @if(request()->input('flt') == 1)
                            <div style="margin-bottom: 20px;">
                                <a href="/teachers" class="btn btn-warning">Сбросить</a>
                            </div>
                        @endif

                        @if(count($subjects))
                        <div class="form-group">
                            <label class="control-label">ПРЕДМЕТ</label>
                            <select class="form-control" id="subjects">
                                <option value="0">Выбрать</option>
                                @foreach($subjects as $subject)
                                    <option {{ (request()->input('subject') == $subject->name) ? 'selected' : '' }} value="{{ $subject->name }}">
                                        {{ $subject->name }}
                                    </option> 
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        @endif

                        <div class="form-group">
                            <div class="control-label">ПОЛ</div>
                            <label class="radio-inline">
                                <input type="radio" name="sex" class="sex" value="all" {{ (request()->input('sex') == 'all' or !request()->input('sex')) ? 'checked' : '' }}>
                                Все
                            </label><br>
                            <label class="radio-inline">
                                <input type="radio" name="sex" class="sex" value="male" {{ (request()->input('sex') == 'male') ? 'checked' : '' }}>
                                Мужской
                            </label>

                            <label class="radio-inline" style="margin-left: 0;">
                                <input type="radio" name="sex" class="sex" value="female" {{ (request()->input('sex') == 'female') ? 'checked' : '' }}>
                                Женский
                            </label>
                        </div>
                        <hr>
                        
                        @if(!empty($specializations))
                        <div class="form-group">
                            <div class="control-label">КАТЕГОРИЯ ПРЕПОДАВАНИЯ</div>
                            @php
                                $specializationsArray = [];
                                if(request()->input('specializations')){
                                    $specializationsArray = explode(',', request()->input('specializations'));
                                }
                            @endphp
                            @foreach($specializations as $specialization)
                                <label class="checkbox-inline" style="margin-left: 0;">
                                    <input type="checkbox"
                                           value="{{ $specialization->id_specialization }}" 
                                           class="specialization_input"
                                           {{ in_array($specialization->id_specialization, $specializationsArray) ? 'checked' : '' }}>
                                    {{ $specialization->specializations_list->name }}
                                </label>
                            @endforeach
                        </div>
                        <hr>
                        @endif
                        
                        @if($minMaxPrice['min'] > 0 && $minMaxPrice['max'] > 0 && $minMaxPrice['min'] <> $minMaxPrice['max'])
                        <div class="form-group">
                            <label class="control-label">СТОИМОСТЬ ЧАСА</label>
                            <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                            <input type="hidden" name="min_price" value="{{ @request()->input('min_price') }}" id="min_price">
                            <input type="hidden" name="max_price" value="{{ @request()->input('max_price') }}" id="max_price">
                            <div id="slider-range"></div>
                        </div><hr>
                        @endif
                        
                        @if(!empty($lesson_filter_options))
                        <div class="form-group">
                            <div class="control-label">МЕСТО ПРОВЕДЕНИЯ</div>
                            @php
                                $lessonOptionsArray = [];
                                if(request()->input('lesson_options')){
                                    $lessonOptionsArray = explode(',', request()->input('lesson_options'));
                                }
                            @endphp
                            @foreach($lesson_filter_options as $lesson_option)
                                <label class="checkbox-inline" style="margin-left: 0;">
                                    <input type="checkbox" 
                                           value="{{ $lesson_option->id_lesson_option }}" 
                                           class="lesson_option_input"
                                           {{ in_array($lesson_option->id_lesson_option, $lessonOptionsArray) ? 'checked' : '' }}>
                                    {{ $lesson_option->lesson_options_list->name }}
                                </label>
                            @endforeach
                        </div>
                        @endif

                    </form>
                </div>
            </div>
        </div>

        @endif
    </div>
@stop