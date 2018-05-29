<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Проект</title>
    
    <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') . '?v=' . time() }}" rel="stylesheet">
    <link href="{{ asset('css/loader.css') }}" rel="stylesheet">
    <link href="{{ asset('css/media-queries.css') }}" rel="stylesheet">

    <!-- Cropper -->
    <link  href="{{ asset('js/cropperjs/dist/cropper.css') }}" rel="stylesheet">

    <!-- Datepicker --> 
    <link href="{{ asset('js/datepicker/datepicker.css') }}" rel="stylesheet">

    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
     
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') . '?v=' . time() }}"></script>
    <script src="{{ asset('js/switcher.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script> 
    
    <!-- Cropper --> 
    <script src="{{ asset('js/cropperjs/dist/cropper.js') }}"></script>
    
    <!-- Datepicker -->
    <script src="{{ asset('js/datepicker/datepicker.js') }}"></script> 
 
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content'); 
    </script>

    <script src="{{ asset('js/custom.js') . '?v=' . time() }}"></script>
</head>

<body>
	<header>
		<div class="container">
			<div class="header_top">
				<div class="row">
					<div class="col-lg-12">
						<ul class="list-inline header_top_nav">
							@if(Auth::check())
							<li>
								<a href="{{ route('logout') }}">Выйти</a>
							</li>
							@else 
							<li class="register_link">
								<a href="{{ route('registration') }}">Хочу обучать</a>
							</li>
							<li>
								<a href="{{ route('login') }}">Войти</a>
							</li>
							@endif
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="header_bottom">
			<nav class="navbar navbar-default">
			  <div class="container">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="/"><img src="/images/logo.png" alt=""></a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				  <ul class="nav navbar-nav">
					<li><a href="/about/">О ПРОЕКТЕ</a></li>
					<li><a href="/courses/">КУРСЫ</a></li>
					<li><a href="/educational-institutions/">ВУЗЫ И ШКОЛЫ</a></li>
					<li><a href="/teachers/">ПРЕПОДАВАТЕЛИ</a></li>
				  </ul>
				  @if(Auth::check())
				  <ul class="nav navbar-nav navbar-right">
					<li>
                        <a href="{{ route('user_profile') }}">
                            <img src="{{ imageThumb(@Auth::user()->avatar, 'uploads/users', 40, 40, 'icon') }}">
                        </a>
                    </li>
					<li><a href="#"><img src="/images/icon_bookmark.png"></a></li>
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="/images/icon_profile.png"></a>
					  <ul class="dropdown-menu">
						<li><a href="{{ route('user_profile') }}">Личный кабинет</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="{{ route('logout') }}">Выйти</a></li>
					  </ul>
					</li>
				  </ul>
				  @endif
				</div>
			  </div>
			</nav>
			@if(request()->segment(1) == '')
			<div class="container">
				<div class="row">
					<div class="col-lg-8 col-lg-offset-2">
						<h2>
							НАЙДИТЕ СВОЕ ПРИЗВАНИЕ В ПОЛНОМ КАТАЛОГЕ ВУЗОВ И КУРСОВ
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
						<form class="home" id="search_form" action="/search/" data-url-autocomplete="/autocomplete">
							<div class="input-group">
								<input name="q" autocomplete="off" class="form-control" id="search__input" placeholder="">
								<div class="loaded__search_result"></div>
								<span class="input-group-btn">
									<button type="submit" class="btn btn_search"><i class="fa fa-search"></i></button>
								</span>
							</div>
						</form>
					</div>
				</div>
			</div>
			@else
			@endif
		</div>
	</header>
        @yield('content')
    <div class="container">
        <div class="banner_block">
            <div class="row">
                <div class="col-lg-4">
                    <img class="img-responsive" src="/images/banner_3.jpg" alt="">
                </div>
                <div class="col-lg-4">
                    <img class="img-responsive" src="/images/banner_4.jpg" alt="">
                </div>
                <div class="col-lg-4">
                    <img class="img-responsive" src="/images/banner_5.jpg" alt="">
                </div>
            </div>
        </div>
    </div>

    <footer>
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3">
					<div class="footer_logo">
						<img class="img-responsive" src="/images/footer_logo.png" alt="">
					</div>
					<ul class="list-inline nav-justified social_menu">
						<li>
							<a href="#">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-vk fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
						<li>
							<a href="#">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
						<li>
							<a href="#">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
						<li>
							<a href="#">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-odnoklassniki fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
						<li>
							<a href="#">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-skype fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="col-lg-8 col-lg-offset-1 col-md-8 col-md-offset-1">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<ul class="list-inline footer_menu">
								<li><a href="">О ПРОЕКТЕ</a></li>
								<li><a href="">РЕКЛАМА НА САЙТЕ</a></li>
								<li><a href="">ВУЗАМ И ПРЕПОДАВАТЕЛЯМ</a></li>
							</ul>
						</div>
					</div>
					<div class="row">
                        <div class="col-lg-3">
							<div class="footer_menu_bottom">
								<h3>ЛИЧНЫЙ КАБИНЕТ</h3>
								<ul class="list-unstyled"> 
									@if(Auth::check())
									<li><a href="{{ route('user_profile') }}">Профиль</a></li> 
									@else  
									<li><a href="{{ route('login') }}">Войти</a></li>
									<li><a href="{{ route('registration') }}">Регистрация</a></li>
									@endif  
								</ul>
							</div>
                        </div>
                        <div class="col-lg-3">
							<div class="footer_menu_bottom">
								<h3>КУРСЫ</h3>
								<ul class="list-unstyled">
									<li><a href="#">Разместить курс</a></li>
								</ul>
							</div>
                        </div>
                        <div class="col-lg-3">
							<div class="footer_menu_bottom">
								<h3>ВУЗЫ И ШКОЛЫ</h3>
								<ul class="list-unstyled">
									<li><a href="#">Стать партнером сайта</a></li>
								</ul>
							</div>
                        </div>
                        <div class="col-lg-3">
							<div class="footer_menu_bottom">
								<h3>ПРЕПОДВАТЕЛИ</h3>
								<ul class="list-unstyled">
									<li><a href="#">Опубликооать профиль</a></li>
								</ul>
							</div>
                        </div>
					</div>
					<div class="row">
                        <div class="col-lg-12 col-md-12">
							<span class="copyright">Все права защищены © КОРПОРАЦИЯ МОЗГА, 2018</span>
						</div>
					</div>
				</div>
			</div>
		</div>
        <!--<div class="container">
            <div class="row">
                <div class="col-lg-3 col-xs-12">
                    <a href="/"><img src="images/logo.png" alt=""></a>
                </div>
                <div class="col-lg-6 col-xs-12">
                    <ul class="list-inline footer_menu">
                        <li><a href="#">О ПРОЕКТЕ</a></li>
                        <li><a href="#">РЕКЛАМА НА САЙТЕ</a></li>
                        <li><a href="#">ВУЗАМ И ПРЕПОДАВАТЕЛЯМ</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-xs-12">
                    <ul class="list-inline social_menu">
                        <li>МЫ В СОЦ, СЕТЯХ</li>
                        <li>
                            <a href="#">
                                <i class="fa fa-facebook-square" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-vk" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-odnoklassniki-square" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row footer_bottom">
                <div class="col-lg-12">
                    <br>
                </div>
                <div class="col-lg-3">
                    <p>
                        Все права защищены <br>
                        © КОРПОРАЦИЯ МОЗГА, 2018
                    </p>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-3">
                            <h3>ЛИЧНЫЙ КАБИНЕТ</h3>
                            <ul class="list-unstyled"> 
                                @if(Auth::check())
                                <li><a href="{{ route('user_profile') }}">Профиль</a></li> 
                                @else  
                                <li><a href="{{ route('login') }}">Войти</a></li>
                                <li><a href="{{ route('registration') }}">Регистрация</a></li>
                                @endif  
                            </ul>
                        </div>
                        <div class="col-lg-3">
                            <h3>КУРСЫ</h3>
                            <ul class="list-unstyled">
                                <li><a href="#">Разместить курс</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3">
                            <h3>ВУЗЫ И ШКОЛЫ</h3>
                            <ul class="list-unstyled">
                                <li><a href="#">Стать партнером сайта</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3">
                            <h3>ПРЕПОДВАТЕЛИ</h3>
                            <ul class="list-unstyled">
                                <li><a href="#">Опубликооать профиль</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
    </footer>

    <div id="overlay"></div>

    @if(Auth::check())
    <div class="cropper__section">
        <div class="cropper__close" onclick="$('.cropper__section, #overlay').fadeOut(150);">Закрыть</div>

        <div class="row">
            <div class="col-md-12">
                <div class="cropper__image_content">
                    <img src="" id="image__crop" alt="">
                </div>
            </div> 

            <div class="col-md-12">
                <button id="crop__btn"  type="button" class="btn btn-default">Сохранить</button>
                <!-- <button style="display: none;" 
                        class="btn primary btn-sm save__cropped_image"
                        onclick="$('form.profile__image_form').submit();">Сохранить</button> -->  
                <div id="result"></div>
            </div> 
        </div> 
    </div>  
    @endif

    @if(!empty($scripts))
        @foreach($scripts as $key => $script)
            {!! setScript('/public/', $script) !!}
        @endforeach
    @endif 
</body>

</html>