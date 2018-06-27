@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="header_block">ПОПУЛЯРНЫЕ КУРСЫ</h2>
                <ul class="nav nav-tabs popular_courses">
                    @php $i=0; @endphp
                    @foreach($courseCategories as $category)
                        <li class="{{ ($i==0) ? 'active' : '' }}">
                            <a data-toggle="tab" href="#course_category_{{ $category->id }}">
                                {{ $category->name }} {{ count($category->courses) }}
                            </a>
                        </li> @php $i++ @endphp
                    @endforeach 
                     
                </ul>
            </div>
            <div class="col-lg-12">
                <div class="tab-content">
                    @php $i=0; @endphp
                    @foreach($courseCategories as $category) 
                    <div id="course_category_{{ $category->id }}" class="tab-pane fade in {{ ($i==0) ? 'active' : '' }}"> 
                        @foreach($category->courses as $course)  
                        <div class="col-lg-4">
                            <div class="external_card">
                                <div class="caption">
                                    <ul class="list-inline card_tag">
                                        <li class="tag_sticker">
                                            <span>{{ @$category->name }}</span>
                                        </li> 
                                        @if(@Auth::check()) 
                                            @php 
                                                $favorite = in_array(Auth::user()->id, $course->userFavorite->pluck('id')->toArray()); 
                                            @endphp
                                            <li class="bookmark_tag">
                                                <i class="fa course_heart 
                                                   {{ $favorite ? 'is_favorite fa-heart' : 'fa-heart-o' }}" 
                                                   onclick="courseFavorite(this, {{ $course->id }});"  
                                                   aria-hidden="true"></i> 
                                            </li> 
                                        @endif 
                                    </ul>
                                    <h3>{{ $course->name }}</h3> 
                                    <h4>
                                        @if($course->user->user_type==3)
                                            {{ $course->user->university['full_name'] }} 
                                        @else
                                            {{ $course->user->name }} 
                                        @endif
                                    </h4>
                                    <ul class="list-unstyled card_info">
                                        <li>
                                            Стоимость 
                                            <span> 
                                                @if($course->pay == 1)
                                                    бесплатно
                                                @else
                                                    ₽{{ $course->price }}
                                                @endif 
                                            </span>
                                        </li>
                                        <li>
                                            Длительность 
                                            <span>
                                                @php 
                                                    $diff = dateDiff($course->date_from, $course->date_to);
                                                @endphp
                                                @if($diff->m)
                                                    {{ $diff->m }} {{ monthCase($diff->m) }}
                                                @endif 

                                                @if($diff->d) 
                                                    @if($diff->m)
                                                        и
                                                    @endif 
                                                    {{ $diff->d }}  
                                                    @php 
                                                        echo dayCase($diff->d);
                                                    @endphp  
                                                @endif 
                                            </span>
                                        </li>
                                        <li>
                                            Рейтинг 
                                            <span class="rating_star"> 
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i> 
                                            </span>
                                        </li>
                                    </ul>
                                    <ul class="list-inline card_date_info">
                                        <li class="left_date"><i class="fa fa-user"></i> {{ $course->user_requests_count }}</li> 
                                        @php 
                                            $esablishDate = $courseFacadeInstance->setId($course->id)->esablishDate();  
                                        @endphp
                                        <li class="right_date"> 
                                            {{ $esablishDate['status'] }} {{ $esablishDate['date'] }}
                                        </li> 
                                    </ul>
                                    <div class="more_card"><a href="/course/{{ $course->id }}">Подробнее</a></div>
                                </div>
                            </div>
                        </div>
                        @endforeach  
                    </div>
                    @php $i++ @endphp
                    @endforeach    
                </div>
            </div>
            <div class="col-lg-12">
                <div class="link_more">
                    <a href="/courses">Все курсы</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="banner_block">
                    <img class="img-responsive" src="/images/banner_1.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
	<div class="container about_us_block">
		<div class="row">
			<div class="col-lg-10 col-lg-offset-1">
				<h1>ПРОЕКТ "КОРПОРАЦИЯ МОЗГА"</h1>
				<p>LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT. AENEAN EUISMOD BIBENDUM LAOREET. PROIN GRAVIDA DOLOR SIT AMET LACUS ACCUMSAN ET VIVERRA JUSTO COMMODO. PROIN SODALES PULVINAR TEMPOR. CUM SOCIIS NATOQUE PENATIBUS ET MAGNIS DIS PARTURIENT MONTES, NASCETUR RIDICULUS MUS. NAM FERMENTUM, NULLA LUCTUS PHARETRA VULPUTATE, FELIS TELLUS MOLLIS ORCI, SED RHONCUS SAPIEN NUNC EGET.</p>
			</div>
			<div class="col-lg-12">
				<img class="img-responsive" src="/images/about_us.png" alt="">
			</div>
		</div>
	</div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if(!empty($university))
                    <h2 class="header_block">ВУЗЫ ПАРТНЕРЫ</h2>
                    <div id="partner_universities" class="owl-carousel owl-theme">
                        @foreach($university as $item)
                            <div class="item">  
                                <a href="/university/{{ $item['id'] }}/">
									<img class="img-responsive" src="{{ imageThumb(@$item->user->avatar, 'uploads/users', 400, 300, 'universities') }}">
								</a> 
                                <h3><a href="/university/{{ $item['id'] }}">{{ $item['full_name'] }}</a></h3>
                                <ul class="list-unstyled">
                                    <li>
                                        {{ count($item->user->courses) }} 
                                        {{ format_by_count(count($item->user->courses), 'курс', 'курса', 'курсов') }}
                                    </li>
                                    <li>15 ПРЕПОДАВАТЕЛЕЙ</li>
                                </ul>
                            </div> 
                        @endforeach 
                    </div>
                @endif

                <div class="link_more">
                    <a href="/universities/">Все вузы</a>
                </div>
				
                <div class="banner_block">
                    <img class="img-responsive" src="/images/banner_2.jpg" alt="">
                </div>

                @if(!empty($teachers))
                <h2 class="header_block">ЛУЧШИЕ ПРЕПОДАВАТЕЛИ</h2>
                <div id="teacher_carousel" class="owl-carousel owl-theme">
                    @foreach($teachers as $teacher)
                        <div class="item"> 
                            <a href="/teacher/{{ $teacher['id'] }}/">
								<img style="" 
                                     class="img-responsive" 
                                     src="{{ imageThumb(@$teacher->image, 'uploads/users', 400, 500, 'list') }}">
							</a> 
                            <h3><a href="/teacher/{{ $teacher['id'] }}/">{{ $teacher['name'] }} {{ $teacher['surname'] }}</a></h3>
                            <p>ЕГЭ, ФИЗИКА, МАТЕМАТИКА</p>
                        </div> 
                    @endforeach
                </div>
                @endif

            </div>
        </div>
    </div> 
	<div class="container user_type_block">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="header_block">НАЙДЕМ МЕСТО КАЖДОМУ</h2>
			</div>
			<div class="col-lg-4">
				<div class="user_type_home">
					<img class="img-responsive img-thumbnail" src="/public/images/user_type_home_img_one.png" alt="">
					<h3>УЧЕНИКАМ/АБИТУРИЕНТАМ</h3>
					<p>
						Найдите учебный курс с наиболее подходящим для вас содержанием и условием обучения. Получите доступ к максимально полной базе онлайн-семинаров, лекций и полноценных учебных программ!
					</p>
					<a href="">ИСКАТЬ КУРС</a>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="user_type_home">
					<img class="img-responsive img-thumbnail" src="/public/images/user_type_home_img_two.png" alt="">
					<h3>ВУЗАМ И ОНЛАЙН ШКОЛАМ</h3>
					<p>
						Станьте нашим партнером, разместив максимально подробную информацию о вашем учебном заведении на страницах нашего сайта. Расскажите о вашем ВУЗе или онлайн-школе потенциальным абитуриентам!
					</p>
					<a href="">СТАТЬ ПАРТНЕРАМИ</a>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="user_type_home">
					<img class="img-responsive img-thumbnail" src="/public/images/user_type_home_img_three.png" alt="">
					<h3>ПРЕПОДАВАТЕЛЯМ</h3>
					<p>
						Создайте профиль на нашем сайте, опишите свою квалификацию и направление работы – и уже скоро вы сможете передавать свои знания максимальному количеству учеников.
					</p>
					<a href="">НАЧАТЬ ОБУЧАТЬ</a>
				</div>
			</div>
		</div>
	</div>
@stop