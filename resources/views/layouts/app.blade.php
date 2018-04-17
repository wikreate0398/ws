<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Проект</title>

    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') . '?v=' . time() }}" rel="stylesheet">
    <link href="{{ asset('css/loader.css') }}" rel="stylesheet">
    <link href="{{ asset('css/media-queries.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') . '?v=' . time() }}"></script>
    <script src="{{ asset('js/custom.js') . '?v=' . time() }}"></script>
     

</head>

<body>
    <header>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
                    <a class="navbar-brand" href="/"><img src="/images/logo.png" alt=""></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav main_menu" style="margin-top: 5px;">
                        <li><a href="/about/">О ПРОЕКТЕ</a></li>
                        <li><a href="/under-construction/">КУРСЫ</a></li>
                        <li><a href="/educational-institutions/">ВУЗЫ И ШКОЛЫ</a></li>
                        <li><a href="/under-construction/">ПРЕПОДАВАТЕЛИ</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right" style="margin-top: 14px;">
                        @if(Auth::check())
                        <li><a href="{{ route('user_profile') }}"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Профиль</a></li>
                        <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Выйти</a></li> 
                        @else  
                        <li><a href="{{ route('login') }}""><i class="fa fa-sign-in" aria-hidden="true"></i> Войти</a></li>  
                        <li><a href="{{ route('registration') }}"><i class="fa fa-user-plus" aria-hidden="true"></i> Регистрация</a></li>
                        @endif 
                    </ul>
                </div>
            </div>
        </nav>  
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
    <!--<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div>
      </div>
    </nav> -->

</body>

</html>