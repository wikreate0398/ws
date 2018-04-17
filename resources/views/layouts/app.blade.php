<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Проект</title>
    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">

    <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
     
    <link href="{{ asset('css/style.css') . '?v=' . time() }}" rel="stylesheet">
    <link href="{{ asset('css/loader.css') . '?v=' . time() }}" rel="stylesheet">
    <link href="{{ asset('css/media-queries.css') }}" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <script src="{{ asset('js/jquery-ui.min.js') }}" crossorigin="anonymous"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/fontawesome-all.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') . '?v=' . time()}}"></script>
</head>

<body>
<header>
    <div class="header_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-8 col-xs-12">
                    <ul class="list-inline about_menu">
                        <li class="pull-left">
                            <a href="#"><i class="fas fa-map-marker-alt"></i>Москва<span class="caret"></span></a>
                        </li>
                        <li>
                            <a href="/about/">О портале</a>
                        </li>
                        <li>
                            <a href="/under-construction/">Как найти уроки</a>
                        </li>
                        <li>
                            <a href="/under-construction/">Как разместиться</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <ul class="list-inline header_top_social">
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fab fa-vk"></i></a></li>
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <ul class="list-inline" id="header_top_info">
                        <li><a href="#"><i class="fas fa-phone"></i> +7 (495) 123-15-24</a></li>
                        <li><a href="#"><i class="far fa-envelope"></i> info@email.ru</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header_bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                    <a href="/">
                        <img class="img-responsive" src="/images/logo.png" alt="">
                    </a>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="input-group search_block">
                                <input type="text" class="form-control" placeholder="Поиск">
                                <span class="input-group-addon">
                                        <button type="submit">
                                            <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                    </span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <ul class="list-inline enter_list">
                                @if(Auth::check())
                                <li><a href="{{ route('user_profile') }}">Профиль</a></li> 
                                <li><a href="{{ route('logout') }}">Выйти</a></li> 
                                @else
                                <li><a href="{{ route('login') }}"><img src="/images/enter_student.png" alt="">Войти учеником</a></li>
                                <li><a href="{{ route('login') }}"><img src="/images/enter_teacher.png" alt="">Войти учителем</a></li>
                                <li><a href="{{ route('registration') }}"><img src="/images/enter_registration.png" alt="">Регистрация</a></li>
                                @endif 
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-12 col-md-12 hidden-sm col-xs-12">
                            <hr>
                            <ul class="list-inline nav-justified" id="main_menu">
                                <li>
                                    <a href="/educational-institutions/">Каталог учебных заведений</a>
                                </li>
                                <li>
                                    <a href="/under-construction/">Рейтинги учебных заведений</a>
                                </li>
                                <li>
                                    <a href="/under-construction/">Календарь событий</a>
                                </li>
                                <li>
                                    <a href="/under-construction/">Сотрудничество</a>
                                </li>
                                <li>
                                    <a href="/contacts/">Контакты</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@yield('content')

<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <img src="/images/logo.png" alt="Корпорация мозга">
            </div>
            <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
                <ul class="nav nav-justified" id="footer_nav_top">
                    <li><a href="/educational-institutions/">Каталог учебных заведений</a></li>
                    <li><a href="/under-construction/">Рейтинги учебных заведений</a></li>
                    <li><a href="/under-construction/">Календарь событий</a></li>
                    <li><a href="/under-construction/">Сотрудничество</a></li>
                    <li><a href="/contacts/">Контакты</a></li>
                </ul>
            </div>
            <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
                <ul class="nav nav-justified" id="footer_info_nav">
                    <li><a href="#"><i class="fas fa-map-marker-alt"></i> Москва</a></li>
                    <li><a href="#"><i class="fas fa-phone"></i> +7 (495) 123-15-24</a></li>
                    <li><a href="#"><i class="far fa-envelope"></i> info@email.ru</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                Copyrighht 2018
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <ul class="list-inline" id="footer_nav_bottom">
                    <li><a href="/about/">О портале</a></li>
                    <li><a href="/under-construction/">Как найти уроки</a></li>
                    <li><a href="/under-construction/">Как разместиться</a></li>
                    <li><a href="/terms-of-use/">Пользовательское соглашение</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" id="footer_pay">
                <img src="/images/sposobi_oplati.png" alt="Способы оплаты">
            </div>
        </div>
    </div>
</footer>
<div class="modal fade" id="myModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p id="content">
                    У вас нет доступов, обратитесь к администратору сайта для доступов.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
</body>

</html>