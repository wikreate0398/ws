<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    @php $page = Page::meta(Page::uriName()); @endphp
    <title>{{ @$page->seo_title }}</title>
    <meta name="description" content="{{ @$page->seo_description }}">
    <meta name="seo_keywords" content="{{ @$page->seo_keywords }}">

    <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') . '?v=' . time() }}" rel="stylesheet">
    <link href="{{ asset('css/loader.css') }}" rel="stylesheet">
    <link href="{{ asset('css/media-queries.css') }}" rel="stylesheet"> 
    <link rel="stylesheet" href="{{ asset('js/bar-rating/dist/themes/fontawesome-stars-o.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.1/jquery.fancybox.min.css">

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
    <script src="{{ asset('js/bar-rating/jquery.barrating.js') }}"></script>
    <script src="{{ asset('js/switcher.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.1/jquery.fancybox.min.js"></script>

    <!-- Price Input Mask -->
    <script type="text/javascript" src="{{ asset('js/input_mask.js') }}"></script>

    <!-- Cropper --> 
    <script src="{{ asset('js/cropperjs/dist/cropper.js') }}"></script>
    
    <!-- Datepicker -->  
    <script src="{{ asset('js/datepicker/datepicker.js') }}"></script> 
    <script src="{{ asset('js/datepicker/datepicker_ru.js') }}"></script>
    
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content'); 
        var loginLink = '{{ route('login') }}';
        var currentUrl = '{{ Request::getRequestUri() }}';
    </script>

    <script src="{{ asset('js/custom.js') . '?v=' . time() }}"></script>  
</head>

<body>
	<header>
		<div class="header_bottom">
			<nav class="navbar navbar-default">
			  <div class="container">
				<div class="row header__items">
                    <div class="col-md-2">
                        <div class="navbar-header">
                          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                          </button>
                          <a class="navbar-brand hidden-xs" href="/"><img src="/images/logo2.png" alt=""></a>
                          <a class="navbar-brand visible-xs" href="/"><img src="/images/logo_mob.png" alt=""></a>
                        </div>
                    </div>   

                    <div class="col-md-7" style="text-align: center;">
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                          <ul class="nav navbar-nav">
                            @foreach(Page::top() as $menu)
                                <li>
                                    <a class="{{ (request()->segment(1) == $menu['url']) ? 'active' : '' }}" href="/{{ $menu['url'] }}">
                                        {{ $menu['name'] }}
                                    </a>
                                </li>
                            @endforeach 
                          </ul> 
                        </div>
                    </div>   
                    <div class="col-md-4">
						<ul class="nav navbar-nav nav__actions"> 
                            <li>
                                <div class="cities_header"> 
                                    <a href="#user_location" data-toggle="modal" onclick="setTimeout(function(){initSelect2();},500);">
                                        Город
                                        <i class="fa fa-sort-desc" aria-hidden="true"></i>
                                    </a> 
                                </div>

                                <div id="user_location" class="modal fade"   data-backdrop="static" data-keyboard="false">
                                   <div class="modal-dialog">
                                      <div class="modal-content">
                                         <div class="modal-header">

                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </button>
                                            <h4 class="modal-title">Выберите Область/Город</h4>
                                         </div>
                                         <div class="modal-body">
                                            <div class="row"> 
                                                <div class="col-md-12"> 
                                                    <div class="row">
                                                        <div class="col-md-6 regions__area">
                                                            <div class="form-group select_form">
                                                                <select class="form-control select2" onchange="loadRegionCities(this)" name="region">
                                                                    <option value="">Область</option>
                                                                    @foreach(\App\Models\Regions::where('country_id', 3159)->orderBy('name', 'asc')->get() as $item)
                                                                        <option value="{{$item['id']}}">
                                                                            {{$item['name']}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div> 
                                                        <div class="col-md-6 cities__area" style="display: none;"></div> 
                                                    </div> 
                                                    <button type="button" data-dismiss="modal" style="float: none;" class="btn btn_save">Сохранить</button> 
                                                </div>
                                            </div>
                                         </div>  
                                      </div>
                                   </div>
                                </div>

                            </li>

							@if(Auth::check())<li>
								<li>
									<a href="{{ route(userRoute('user_profile')) }}">
										<img src="{{ imageThumb(@Auth::user()->avatar, 'uploads/users', 40, 40, 'icon') }}">
									</a>
								</li>
								<li><a href="#"><img src="/images/icon_bookmark2.png"></a></li>
								<li>
									<a href="{{ route('logout') }}">Выйти</a>
								</li>
							@else 
								<li class="register_link">
									<a href="{{ route('registration') }}?type=teacher">Хочу обучать</a>
								</li>
								<li>
									<a href="{{ route('login') }}">Войти</a>
								</li>
							@endif
                        </ul>
 
                    </div>       
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
                            @if($stats['institutions'] > 0)
                            <li>
                                <a href="/universities/">
                                    {{ $stats['institutions'] }} 
                                    {{ format_by_count($stats['institutions'], 'ВУЗ', 'ВУЗА', 'ВУЗОВ') }}
                                </a>
                            </li>
                            @endif

                            @if($stats['courses'] > 0)
                            <li>
                                <a href="">
                                    {{ $stats['courses'] }}   
                                    {{ format_by_count($stats['courses'], 'КУРС', 'КУРСА', 'КУРСОВ') }}
                                </a>
                            </li>
                            @endif 

                            @if($stats['teachers'] > 0)
                            <li>
                                <a href="/teachers/">
                                    {{ $stats['teachers'] }} 
                                    {{ format_by_count($stats['teachers'], 'ПРЕПОДАВАТЕЛь', 'ПРЕПОДАВАТЕЛЯ', 'ПРЕПОДАВАТЕЛЕЙ') }}
                                </a>
                            </li>
                            @endif 
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
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <img class="img-responsive" src="/images/banner_3.jpg" title="Brain Incorporated | Образовательный портал России и мира"
                         alt="Корпорация Мозга | Образовательный портал России и мира">
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <img class="img-responsive" src="/images/banner_4.jpg" title="Brain Incorporated | Образовательный портал России и мира"
                         alt="Корпорация Мозга | Образовательный портал России и мира">
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <img class="img-responsive" src="/images/banner_5.jpg" title="Brain Incorporated | Образовательный портал России и мира"
                         alt="Корпорация Мозга | Образовательный портал России и мира">
                </div>
            </div>
        </div>
    </div>

    <footer>
		<div class="container">
			<div class="row visible-xs">
				<div class="col-xs-12">
					<div class="footer_logo">
						<img class="img-responsive" src="/images/footer_logo.png" alt="">
					</div>
					<ul class="list-unstyled footer_menu">
							@foreach(Page::bottom() as $menu)
								<li>
									<a class="{{ (request()->segment(1) == $menu['url']) ? 'active' : '' }}" href="/{{ $menu['url'] }}">
										{{ $menu['name'] }}
									</a>
								</li>
							@endforeach  
							@if(Auth::check())
								<li>
									<a href="{{ route(userRoute('user_edit')) }}">Личные данные</a>
								</li> 
							@else  
							@endif  
					</ul>
					<ul class="list-inline nav-justified social_menu">
						<li>
							<a href="https://vk.com/brainincorporated" target="_blank">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-vk fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
						<li>
							<a  href="https://www.facebook.com/Brainincorporated" target="_blank">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
						<li>
							<a href="https://www.instagram.com/brainincorporated/" target="_blank">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
						<li>
							<a href="https://t.me/brainincorporated" target="_blank">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-telegram fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="col-xs-12">
					<span class="copyright">Все права защищены © КОРПОРАЦИЯ МОЗГА, 2018</span>
				</div>
			</div>
			<div class="row hidden-xs">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<div class="footer_logo">
						<img class="img-responsive" src="/images/footer_logo.png" alt="">
					</div>
					<ul class="list-inline nav-justified social_menu">
						<li>
							<a href="https://vk.com/brainincorporated" target="_blank">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-vk fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
						<li>
							<a href="https://www.facebook.com/Brainincorporated" target="_blank">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
						<li>
							<a href="https://www.instagram.com/brainincorporated/" target="_blank">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
						<li>
							<a href="https://t.me/brainincorporated" target="_blank">
								<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-telegram fa-stack-1x fa-inverse"></i>
								</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="col-lg-8 col-lg-offset-1 col-md-8 col-md-offset-1">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<ul class="list-inline footer_menu"> 
                                @foreach(Page::bottom() as $menu)
                                    <li>
                                        <a class="{{ (request()->segment(1) == $menu['url']) ? 'active' : '' }}" href="/{{ $menu['url'] }}">
                                            {{ $menu['name'] }}
                                        </a>
                                    </li>
                                @endforeach  
							</ul>
						</div>
					</div>

                    @yield('footer')

                    @if(@Auth::user()->user_type == 3)
                        @include('partials.university_footer') 
                    @else
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="footer_menu_bottom">
                                    <h3>ЛИЧНЫЙ КАБИНЕТ</h3>
                                    <ul class="list-unstyled"> 
                                        @if(Auth::check())
                                            <li class="{{ isActive(route(userRoute('user_edit'))) ? 'active' : '' }}">
                                                <a href="{{ route(userRoute('user_edit')) }}">Личные данные</a></li> 
                                            <li>
                                                <a href="{{ route('logout') }}">Выйти</a>
                                            </li>
                                        @else  
                                            <li class="{{ isActive(route('login')) ? 'active' : '' }}">
                                                <a href="{{ route('login') }}">Войти</a>
                                            </li>
                                            <li class="{{ isActive(route('registration')) ? 'active' : '' }}">
                                                <a href="{{ route('registration') }}">Регистрация</a>
                                            </li>
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
                    @endif  
					 

					<div class="row">
                        <div class="col-lg-12 col-md-12">
							<span class="copyright">Все права защищены © КОРПОРАЦИЯ МОЗГА, 2018</span>
						</div>
					</div>
				</div>
			</div>
		</div>
         
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

    <div class="fade-default fade__modal">
        <div class="fade__modal__wrapper">
            <i class="close" onclick="$('.fade__modal').fadeOut();">×</i> 
            <h2></h2>
        </div>
    </div>
	
	<!-- Yandex.Metrika counter -->
	<script type="text/javascript" >
		(function (d, w, c) {
			(w[c] = w[c] || []).push(function() {
				try {
					w.yaCounter49528195 = new Ya.Metrika2({
						id:49528195,
						clickmap:true,
						trackLinks:true,
						accurateTrackBounce:true,
						webvisor:true
					});
				} catch(e) { }
			});

			var n = d.getElementsByTagName("script")[0],
				s = d.createElement("script"),
				f = function () { n.parentNode.insertBefore(s, n); };
			s.type = "text/javascript";
			s.async = true;
			s.src = "https://mc.yandex.ru/metrika/tag.js";

			if (w.opera == "[object Opera]") {
				d.addEventListener("DOMContentLoaded", f, false);
			} else { f(); }
		})(document, window, "yandex_metrika_callbacks2");
	</script>
	<noscript><div><img src="https://mc.yandex.ru/watch/49528195" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->
</body>

</html>