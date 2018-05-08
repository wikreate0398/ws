@extends('layouts.app')

@section('content')
    <div class="header-bg"> 
        <div class="container">
            <div class="header_bottom">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <h2>
                            НАЙДИТЕ СВОЕ ПРИЗВАНИЕ <br> В ПОЛНОМ КАТАЛОГЕ ВУЗОВ И КУРСОВ
                        </h2>
                        <ul class="list-inline list_information">
                            <li>
                                <a href="/educational-institution/">
                                    {{ $stats['institutions'] }} 
                                    @if($stats['institutions'] == 1)
                                        ВУЗ
                                    @elseif($stats['institutions'] <= 4)
                                        ВУЗА
                                    @else
                                        ВУЗОВ 
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    {{ $stats['courses'] }} 
                                    @if($stats['courses'] == 1)
                                        КУРС
                                    @elseif($stats['courses'] <= 4)
                                        КУРСА
                                    @else
                                        КУРСОВ 
                                    @endif 
                                </a>
                            </li>
                            <li>
                                <a href="/teachers/">
                                    {{ $stats['teachers'] }} 
                                    @if($stats['teachers'] == 1)
                                        ПРЕПОДАВАТЕЛь
                                    @elseif($stats['teachers'] <= 4)
                                        ПРЕПОДАВАТЕЛЯ
                                    @else
                                        ПРЕПОДАВАТЕЛЕЙ 
                                    @endif  
                                </a>
                            </li>
                        </ul>
                        <form id="search_form">
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Введите название">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-primary">Поиск</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="header_block">ПОПУЛЯРНЫЕ КУРСЫ</h2>
                <ul class="nav nav-tabs popular_courses">
                    <li class="active"><a data-toggle="tab" href="#panel1">ВСЕ КУРСЫ 450</a></li>
                    <li><a data-toggle="tab" href="#panel2">IT-КУРСЫ 5</a></li>
                    <li><a data-toggle="tab" href="#panel1">ПРОФЕССИОНАЛЬНЫЙ РОСТ 10</a></li>
                    <li><a data-toggle="tab" href="#panel2">БИЗНЕС И ФИНАНСЫ 40</a></li>
                    <li><a data-toggle="tab" href="#panel1">WEB-ДИЗАЙН 10</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div id="panel1" class="tab-pane fade in active">
                    <div class="col-lg-4">
                        <div class="external_card">
                            <div class="caption">
                                <ul class="list-inline card_tag">
                                    <li class="tag_sticker">
										<span>ПРОФЕССИОНАЛЬНЫЙ РОСТ</span>
									</li>
                                    <li class="bookmark_tag">
                                        <span>
                                           <button class="btn btn-default">
                                               <i class="fa fa-heart-o"></i>
                                           </button>
                                       </span>
									</li>
                                </ul>
                                <h3>ТАЙМ-МЕНЕДЖМЕНТ И СТРУКТУРА ОРГАНИЗАЦИИ</h3>
                                <h4>МОСКОВСКИЙ ГОСУДАРСТВЕННЫЙ УНИВЕРСИТЕТ</h4>
                                <ul class="list-unstyled card_info">
                                    <li>
                                        Стоимость <span> бесплатно </span>
                                    </li>
                                    <li>
                                        Длительность <span> 1 месяц </span>
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
                                    <li class="left_date"><i class="fa fa-user"></i> 10</li>
                                    <li class="right_date"><i class="fa fa-calendar"></i> Идет набор до 20.10.2018</li>
                                </ul>
								<div class="more_card"><a href="#">Подробнее</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="external_card">
                            <div class="caption">
                                <ul class="list-inline card_tag">
                                    <li class="tag_sticker">
										<span>ПРОФЕССИОНАЛЬНЫЙ РОСТ</span>
									</li>
                                    <li class="bookmark_tag">
                                        <span>
                                           <button class="btn btn-default">
                                               <i class="fa fa-heart-o"></i>
                                           </button>
                                       </span>
									</li>
                                </ul>
                                <h3>ТАЙМ-МЕНЕДЖМЕНТ И СТРУКТУРА ОРГАНИЗАЦИИ</h3>
                                <h4>МОСКОВСКИЙ ГОСУДАРСТВЕННЫЙ УНИВЕРСИТЕТ</h4>
                                <ul class="list-unstyled card_info">
                                    <li>
                                        Стоимость <span> бесплатно </span>
                                    </li>
                                    <li>
                                        Длительность <span> 1 месяц </span>
                                    </li>
                                    <li>
                                        Рейтинг 
										<span class="rating_star"> 
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-half-o"></i> 
										</span>
                                    </li>
                                </ul>
								<ul class="list-inline card_date_info">
                                    <li class="left_date"><i class="fa fa-user"></i> 10</li>
                                    <li class="right_date"><i class="fa fa-calendar"></i> Идет набор до 20.10.2018</li>
                                </ul>
								<div class="more_card"><a href="#">Подробнее</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="external_card">
                            <div class="caption">
                                <ul class="list-inline card_tag">
                                    <li class="tag_sticker">
										<span>ПРОФЕССИОНАЛЬНЫЙ РОСТ</span>
									</li>
                                    <li class="bookmark_tag">
                                        <span>
                                           <button class="btn btn-default">
                                               <i class="fa fa-heart-o"></i>
                                           </button>
                                       </span>
									</li>
                                </ul>
                                <h3>ТАЙМ-МЕНЕДЖМЕНТ И СТРУКТУРА ОРГАНИЗАЦИИ</h3>
                                <h4>МОСКОВСКИЙ ГОСУДАРСТВЕННЫЙ УНИВЕРСИТЕТ</h4>
                                <ul class="list-unstyled card_info">
                                    <li>
                                        Стоимость <span> бесплатно </span>
                                    </li>
                                    <li>
                                        Длительность <span> 1 месяц </span>
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
                                    <li class="left_date"><i class="fa fa-user"></i> 10</li>
                                    <li class="right_date"><i class="fa fa-calendar"></i> Идет набор до 20.10.2018</li>
                                </ul>
								<div class="more_card"><a href="#">Подробнее</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="external_card">
                            <div class="caption">
                                <ul class="list-inline card_tag">
                                    <li class="tag_sticker">
										<span>ПРОФЕССИОНАЛЬНЫЙ РОСТ</span>
									</li>
                                    <li class="bookmark_tag">
                                        <span>
                                           <button class="btn btn-default">
                                               <i class="fa fa-heart-o"></i>
                                           </button>
                                       </span>
									</li>
                                </ul>
                                <h3>ТАЙМ-МЕНЕДЖМЕНТ И СТРУКТУРА ОРГАНИЗАЦИИ</h3>
                                <h4>МОСКОВСКИЙ ГОСУДАРСТВЕННЫЙ УНИВЕРСИТЕТ</h4>
                                <ul class="list-unstyled card_info">
                                    <li>
                                        Стоимость <span> бесплатно </span>
                                    </li>
                                    <li>
                                        Длительность <span> 1 месяц </span>
                                    </li>
                                    <li>
                                        Рейтинг 
										<span class="rating_star"> 
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-half-o"></i> 
										</span>
                                    </li>
                                </ul>
								<ul class="list-inline card_date_info">
                                    <li class="left_date"><i class="fa fa-user"></i> 10</li>
                                    <li class="right_date"><i class="fa fa-calendar"></i> Идет набор до 20.10.2018</li>
                                </ul>
								<div class="more_card"><a href="#">Подробнее</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="external_card">
                            <div class="caption">
                                <ul class="list-inline card_tag">
                                    <li class="tag_sticker">
										<span>ПРОФЕССИОНАЛЬНЫЙ РОСТ</span>
									</li>
                                    <li class="bookmark_tag">
                                        <span>
                                           <button class="btn btn-default">
                                               <i class="fa fa-heart-o"></i>
                                           </button>
                                       </span>
									</li>
                                </ul>
                                <h3>ТАЙМ-МЕНЕДЖМЕНТ И СТРУКТУРА ОРГАНИЗАЦИИ</h3>
                                <h4>МОСКОВСКИЙ ГОСУДАРСТВЕННЫЙ УНИВЕРСИТЕТ</h4>
                                <ul class="list-unstyled card_info">
                                    <li>
                                        Стоимость <span> бесплатно </span>
                                    </li>
                                    <li>
                                        Длительность <span> 1 месяц </span>
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
                                    <li class="left_date"><i class="fa fa-user"></i> 10</li>
                                    <li class="right_date"><i class="fa fa-calendar"></i> Идет набор до 20.10.2018</li>
                                </ul>
								<div class="more_card"><a href="#">Подробнее</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="external_card">
                            <div class="caption">
                                <ul class="list-inline card_tag">
                                    <li class="tag_sticker">
										<span>ПРОФЕССИОНАЛЬНЫЙ РОСТ</span>
									</li>
                                    <li class="bookmark_tag">
                                        <span>
                                           <button class="btn btn-default">
                                               <i class="fa fa-heart-o"></i>
                                           </button>
                                       </span>
									</li>
                                </ul>
                                <h3>ТАЙМ-МЕНЕДЖМЕНТ И СТРУКТУРА ОРГАНИЗАЦИИ</h3>
                                <h4>МОСКОВСКИЙ ГОСУДАРСТВЕННЫЙ УНИВЕРСИТЕТ</h4>
                                <ul class="list-unstyled card_info">
                                    <li>
                                        Стоимость <span> бесплатно </span>
                                    </li>
                                    <li>
                                        Длительность <span> 1 месяц </span>
                                    </li>
                                    <li>
                                        Рейтинг 
										<span class="rating_star"> 
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-half-o"></i> 
										</span>
                                    </li>
                                </ul>
								<ul class="list-inline card_date_info">
                                    <li class="left_date"><i class="fa fa-user"></i> 10</li>
                                    <li class="right_date"><i class="fa fa-calendar"></i> Идет набор до 20.10.2018</li>
                                </ul>
								<div class="more_card"><a href="#">Подробнее</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="panel2" class="tab-pane fade">
					<div class="col-lg-4">
                        <div class="external_card">
                            <div class="caption">
                                <ul class="list-inline card_tag">
                                    <li class="tag_sticker">
										<span>ПРОФЕССИОНАЛЬНЫЙ РОСТ</span>
									</li>
                                    <li class="bookmark_tag">
                                        <span>
                                           <button class="btn btn-default">
                                               <i class="fa fa-heart-o"></i>
                                           </button>
                                       </span>
									</li>
                                </ul>
                                <h3>ТАЙМ-МЕНЕДЖМЕНТ И СТРУКТУРА ОРГАНИЗАЦИИ</h3>
                                <h4>МОСКОВСКИЙ ГОСУДАРСТВЕННЫЙ УНИВЕРСИТЕТ</h4>
                                <ul class="list-unstyled card_info">
                                    <li>
                                        Стоимость <span> бесплатно </span>
                                    </li>
                                    <li>
                                        Длительность <span> 1 месяц </span>
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
                                    <li class="left_date"><i class="fa fa-user"></i> 10</li>
                                    <li class="right_date"><i class="fa fa-calendar"></i> Идет набор до 20.10.2018</li>
                                </ul>
								<div class="more_card"><a href="#">Подробнее</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="external_card">
                            <div class="caption">
                                <ul class="list-inline card_tag">
                                    <li class="tag_sticker">
										<span>ПРОФЕССИОНАЛЬНЫЙ РОСТ</span>
									</li>
                                    <li class="bookmark_tag">
                                        <span>
                                           <button class="btn btn-default">
                                               <i class="fa fa-heart-o"></i>
                                           </button>
                                       </span>
									</li>
                                </ul>
                                <h3>ТАЙМ-МЕНЕДЖМЕНТ И СТРУКТУРА ОРГАНИЗАЦИИ</h3>
                                <h4>МОСКОВСКИЙ ГОСУДАРСТВЕННЫЙ УНИВЕРСИТЕТ</h4>
                                <ul class="list-unstyled card_info">
                                    <li>
                                        Стоимость <span> бесплатно </span>
                                    </li>
                                    <li>
                                        Длительность <span> 1 месяц </span>
                                    </li>
                                    <li>
                                        Рейтинг 
										<span class="rating_star"> 
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-half-o"></i> 
										</span>
                                    </li>
                                </ul>
								<ul class="list-inline card_date_info">
                                    <li class="left_date"><i class="fa fa-user"></i> 10</li>
                                    <li class="right_date"><i class="fa fa-calendar"></i> Идет набор до 20.10.2018</li>
                                </ul>
								<div class="more_card"><a href="#">Подробнее</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="external_card">
                            <div class="caption">
                                <ul class="list-inline card_tag">
                                    <li class="tag_sticker">
										<span>ПРОФЕССИОНАЛЬНЫЙ РОСТ</span>
									</li>
                                    <li class="bookmark_tag">
                                        <span>
                                           <button class="btn btn-default">
                                               <i class="fa fa-heart-o"></i>
                                           </button>
                                       </span>
									</li>
                                </ul>
                                <h3>ТАЙМ-МЕНЕДЖМЕНТ И СТРУКТУРА ОРГАНИЗАЦИИ</h3>
                                <h4>МОСКОВСКИЙ ГОСУДАРСТВЕННЫЙ УНИВЕРСИТЕТ</h4>
                                <ul class="list-unstyled card_info">
                                    <li>
                                        Стоимость <span> бесплатно </span>
                                    </li>
                                    <li>
                                        Длительность <span> 1 месяц </span>
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
                                    <li class="left_date"><i class="fa fa-user"></i> 10</li>
                                    <li class="right_date"><i class="fa fa-calendar"></i> Идет набор до 20.10.2018</li>
                                </ul>
								<div class="more_card"><a href="#">Подробнее</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="external_card">
                            <div class="caption">
                                <ul class="list-inline card_tag">
                                    <li class="tag_sticker">
										<span>ПРОФЕССИОНАЛЬНЫЙ РОСТ</span>
									</li>
                                    <li class="bookmark_tag">
                                        <span>
                                           <button class="btn btn-default">
                                               <i class="fa fa-heart-o"></i>
                                           </button>
                                       </span>
									</li>
                                </ul>
                                <h3>ТАЙМ-МЕНЕДЖМЕНТ И СТРУКТУРА ОРГАНИЗАЦИИ</h3>
                                <h4>МОСКОВСКИЙ ГОСУДАРСТВЕННЫЙ УНИВЕРСИТЕТ</h4>
                                <ul class="list-unstyled card_info">
                                    <li>
                                        Стоимость <span> бесплатно </span>
                                    </li>
                                    <li>
                                        Длительность <span> 1 месяц </span>
                                    </li>
                                    <li>
                                        Рейтинг 
										<span class="rating_star"> 
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-half-o"></i> 
										</span>
                                    </li>
                                </ul>
								<ul class="list-inline card_date_info">
                                    <li class="left_date"><i class="fa fa-user"></i> 10</li>
                                    <li class="right_date"><i class="fa fa-calendar"></i> Идет набор до 20.10.2018</li>
                                </ul>
								<div class="more_card"><a href="#">Подробнее</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="external_card">
                            <div class="caption">
                                <ul class="list-inline card_tag">
                                    <li class="tag_sticker">
										<span>ПРОФЕССИОНАЛЬНЫЙ РОСТ</span>
									</li>
                                    <li class="bookmark_tag">
                                        <span>
                                           <button class="btn btn-default">
                                               <i class="fa fa-heart-o"></i>
                                           </button>
                                       </span>
									</li>
                                </ul>
                                <h3>ТАЙМ-МЕНЕДЖМЕНТ И СТРУКТУРА ОРГАНИЗАЦИИ</h3>
                                <h4>МОСКОВСКИЙ ГОСУДАРСТВЕННЫЙ УНИВЕРСИТЕТ</h4>
                                <ul class="list-unstyled card_info">
                                    <li>
                                        Стоимость <span> бесплатно </span>
                                    </li>
                                    <li>
                                        Длительность <span> 1 месяц </span>
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
                                    <li class="left_date"><i class="fa fa-user"></i> 10</li>
                                    <li class="right_date"><i class="fa fa-calendar"></i> Идет набор до 20.10.2018</li>
                                </ul>
								<div class="more_card"><a href="#">Подробнее</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="external_card">
                            <div class="caption">
                                <ul class="list-inline card_tag">
                                    <li class="tag_sticker">
										<span>ПРОФЕССИОНАЛЬНЫЙ РОСТ</span>
									</li>
                                    <li class="bookmark_tag">
                                        <span>
                                           <button class="btn btn-default">
                                               <i class="fa fa-heart-o"></i>
                                           </button>
                                       </span>
									</li>
                                </ul>
                                <h3>ТАЙМ-МЕНЕДЖМЕНТ И СТРУКТУРА ОРГАНИЗАЦИИ</h3>
                                <h4>МОСКОВСКИЙ ГОСУДАРСТВЕННЫЙ УНИВЕРСИТЕТ</h4>
                                <ul class="list-unstyled card_info">
                                    <li>
                                        Стоимость <span> бесплатно </span>
                                    </li>
                                    <li>
                                        Длительность <span> 1 месяц </span>
                                    </li>
                                    <li>
                                        Рейтинг 
										<span class="rating_star"> 
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-half-o"></i> 
										</span>
                                    </li>
                                </ul>
								<ul class="list-inline card_date_info">
                                    <li class="left_date"><i class="fa fa-user"></i> 10</li>
                                    <li class="right_date"><i class="fa fa-calendar"></i> Идет набор до 20.10.2018</li>
                                </ul>
								<div class="more_card"><a href="#">Подробнее</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="link_more">
                    <a href="">Все курсы</a>
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
                                <?php $img = !empty($item['user']['image']) ? '/public/uploads/users/' . $item['user']['image'] : noImg()  ?>
                                <a href="/institution/{{ $item['id'] }}/">
									<img class="img-responsive" src="{{ $img }}">
								</a> 
                                <h3><a href="/institution/{{ $item['id'] }}">{{ $item['full_name'] }}</a></h3>
                                <ul class="list-unstyled">
                                    <li>10 КУРСОВ</li>
                                    <li>15 ПРЕПОДАВАТЕЛЕЙ</li>
                                </ul>
                            </div> 
                        @endforeach 
                    </div>
                @endif

                <div class="link_more">
                    <a href="/educational-institution/">Все вузы</a>
                </div>
				
                <div class="banner_block">
                    <img class="img-responsive" src="/images/banner_2.jpg" alt="">
                </div>

                @if(!empty($teachers))
                <h2 class="header_block">ЛУЧШИЕ ПРЕПОДАВАТЕЛИ</h2>
                <div id="teacher_carousel" class="owl-carousel owl-theme">
                    @foreach($teachers as $teacher)
                        <div class="item">
                            <?php $img = !empty($teacher['image']) ? '/public/uploads/users/' . $teacher['image'] : noImg()  ?>
                            <a href="/institution/{{ $teacher['id'] }}/" onclick="return false;">
								<img style="width: 180px; height: 180px;" class="img-responsive img-circle" src="{{ $img }}">
							</a> 
                            <h3><a href="/institution/{{ $teacher['id'] }}/" onclick="return false;">{{ $teacher['name'] }} {{ $teacher['surname'] }}</a></h3>
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
					<h3>УЧЕНИКАМ/АББИТУРИЕНТАМ</h3>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor.
					</p>
					<a href="">ИСКАТЬ КУРС</a>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="user_type_home">
					<img class="img-responsive img-thumbnail" src="/public/images/user_type_home_img_two.png" alt="">
					<h3>ВУЗАМ И ОНЛАЙН ШКОЛАМ</h3>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor.
					</p>
					<a href="">СТАТЬ ПАРТНЕРАМИ</a>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="user_type_home">
					<img class="img-responsive img-thumbnail" src="/public/images/user_type_home_img_three.png" alt="">
					<h3>ПРЕПОДАВАТЕЛЯМ</h3>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor.
					</p>
					<a href="">НАЧАТЬ ОБУЧАТЬ</a>
				</div>
			</div>
		</div>
	</div>
@stop