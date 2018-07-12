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
				<li class="{{ isActive(route(userRoute('login'))) ? 'active' : '' }}">
					<a href="{{ route('login') }}">Войти</a>
				</li>
				<li class="{{ isActive(route(userRoute('registration'))) ? 'active' : '' }}">
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
				<li class="{{ isActive(route(userRoute('add_course'))) ? 'active' : '' }}">
					<a href="{{ route(userRoute('add_course')) }}">Разместить курс</a>
				</li>
                <li class="{{ isActive(route(userRoute('user_profile'))) ? 'active' : '' }}">
                	<a href="{{ route(userRoute('user_profile')) }}">Мои курсы</a>
                </li>
			</ul>
		</div>
    </div>
    <div class="col-lg-3">
		<div class="footer_menu_bottom">
			<h3>Факультеты</h3>
			<ul class="list-unstyled">
				<li class="{{ isActive(route(userRoute('add_faculty'))) ? 'active' : '' }}">
					<a href="{{ route(userRoute('add_faculty')) }}">Добавить факультет</a>
				</li>
				<li class="{{ isActive(route(userRoute('user_faculties'))) ? 'active' : '' }}">
					<a href="{{ route(userRoute('user_faculties')) }}">Мои факультеты</a>
				</li>
			</ul>
		</div>
    </div>
    <div class="col-lg-3">
		<div class="footer_menu_bottom">
			<h3>Новости</h3>
			<ul class="list-unstyled">
				<li class="{{ isActive(route(userRoute('add_news'))) ? 'active' : '' }}">
					<a href="{{ route(userRoute('add_news')) }}">Добавить новость</a>
				</li>
				<li class="{{ isActive(route(userRoute('user_news'))) ? 'active' : '' }}">
					<a href="{{ route(userRoute('user_news')) }}">Мои новости</a>
				</li>
			</ul>
		</div>
    </div>
</div>