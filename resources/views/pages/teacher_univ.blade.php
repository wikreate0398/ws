@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="title_page_in">Инновационные возможности </br> Для вузов и преподавателей</h1>
			<h2 class="title_page_in_sub">Больше студентов, ресурсов и занятости</h2>
		</div>
	</div>
</div>
<div class="parallax_first" data-parallax="scroll" data-image-src="/images/vuzam_prepod/paralax_one.png"></div>
<div class="container">
	<div class="row">
		<div class="col-lg-6">
			<div class="advanced_in">
				<img src="/images/vuzam_prepod/entrant.png">
				<h3>больше абитуриентов</h3>
				<span>Привлекайте больше абитуриентов в ваше учебное заведение, не переплачивая за рекламу</span>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="advanced_in">
				<img src="/images/vuzam_prepod/earn.png">
				<h3>Зарабатывайте</h3>
				<span>Зарабатывайте на проведении курсов и обучающих вебинаров в интернете и на рабочем месте</span>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="advanced_in">
				<img src="/images/vuzam_prepod/profile.png">
				<h3>профиль ВУЗа</h3>
				<span>Разместите профиль ВУЗа и о нем узнают тысячи пользователей портала</span>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="advanced_in">
				<img src="/images/vuzam_prepod/publication.png">
				<h3>Публикации</h3>
				<span>Публикуйте ваши уникальные обучающие материалы на портале и получайте деньги за продажи</span>
			</div>
		</div>
	</div>
</div>
<div class="parallax_two" data-parallax="scroll" data-image-src="/images/vuzam_prepod/paralax_two.png">
	<div class="container">
		<div class="row">
			<div class="col-lg-5">
				<div class="publish-courses">
					<div class="publish-courses-item">
						<h3>
							Размещение в разделе
						</h3>
						<p>
						Где студенты и специалисты ищут соответствующие материалы для обучения и повышения квалификации
						</p>
					</div>
					<div class="publish-courses-item">
						<h3>
							Подробная статистика
						</h3>
						<p>
						Получайте актуальную информацию о просмотрах, скачиваниях и покупках ваших курсов
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="employment">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h3>ЗАНЯТОСТЬ ПРЕПОДАВАТЕЛЯ <span>ПОВЫШается ДО</span></h3>
				<div class="text-center">
					<span class="percent">100%</span>
				</div>
				<p>
					Станьте преподавателем <span>«КОРПОРАЦИИ МОЗГА»</span> и вы никогда не останетесь без работы. 
					<br>
					<br>
					Реализуйте свой потенциал с помощью проведения вебинаров, онлайн- и офлайн-занятий, а также благодаря публикации обучающих материалов на портале. Ваша потенциальная целевая аудитория уже ищет подходящего преподавателя на нашем сайте. 
					<br>
					<br>
					Так может быть они ищут именно вас?
				</p>
			</div>
			<div class="col-lg-12">
				<img class="img-responsive" src="/images/vuzam_prepod/employment.png">
			</div>
		</div>
	</div>
</div>
<div class="parallax_three" data-parallax="scroll" data-image-src="/images/vuzam_prepod/paralax_three.png"></div>
<div class="tabs_in">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<ul class="nav nav-tabs nav_tabs_in">
                    <li class="active">
                        <a data-toggle="tab" href="#nav_tabs_in_university">ВУЗы</a>
                    </li>       
                    <li>
                        <a data-toggle="tab" href="#nav_tabs_in_teacher">Преподаватели</a>
                    </li>       
                    <li>
                        <a data-toggle="tab" href="#nav_tabs_in_courses">Курсы</a>
                    </li>                   
                </ul>
			</div>
		</div>
	</div>
	<div class="tab-content tab-content_in">
		<div id="nav_tabs_in_university" class="tab-pane fade in active">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<h3>ПОВЫШЕНИЕ УЗНАВАЕМОСТИ ВУЗА</h3>
						<p>Расскажите о вашем ВУЗе аудитории потенциальных абитуриентов, которые находятся в поиске подходящего учебного заведения. Разместите данные о ВУЗе бесплатно на нашем портале. Публикуйте факультеты, принимайте заявки от педагогов, которые преподают в вашем заведении и получайте отклики от студентов. 
						<br>
						<br>
						С «КОРПОРАЦИЕЙ МОЗГА» ваш ВУЗ всегда будет востребован.</p>
					</div>
				</div>
			</div>
		</div>
		<div id="nav_tabs_in_teacher" class="tab-pane fade">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<h3>ПОВЫШЕНИЕ Количества учеников</h3>
						<p>Расскажите о вашем ВУЗе аудитории потенциальных абитуриентов, которые находятся в поиске подходящего учебного заведения. Разместите данные о ВУЗе бесплатно на нашем портале. Публикуйте факультеты, принимайте заявки от педагогов, которые преподают в вашем заведении и получайте отклики от студентов. 
						<br>
						<br>
						С «КОРПОРАЦИЕЙ МОЗГА» ваш ВУЗ всегда будет востребован.</p>
					</div>
				</div>
			</div>
		</div>
		<div id="nav_tabs_in_courses" class="tab-pane fade">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<h3>Удобное ведение курсов</h3>
						<p>Расскажите о вашем ВУЗе аудитории потенциальных абитуриентов, которые находятся в поиске подходящего учебного заведения. Разместите данные о ВУЗе бесплатно на нашем портале. Публикуйте факультеты, принимайте заявки от педагогов, которые преподают в вашем заведении и получайте отклики от студентов. 
						<br>
						<br>
						С «КОРПОРАЦИЕЙ МОЗГА» ваш ВУЗ всегда будет востребован.</p>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<div class="row">
				<h3 class="scope_heading">ВОЗМОЖНОСТИ ПОРТАЛА</h3>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="scope">
		<div class="row">
			<div class="col-lg-5 col-lg-offset-1">
				<h3 class="scope_items_heading">ВУЗАМ</h3>
				<div class="scope_items">
					<h3>Публикации</h3>
					<p>Опубликуйте информацию о вашем ВУЗе. Разместите факультеты, требования для поступления и студенты вами заинтересуются</p>
				</div>
				<div class="scope_items">
					<h3>Партнерство</h3>
					<p>Станьте партнером «КОРПОРАЦИИ МОЗГА» и получите доступ ко всем выгодам бесплатной рекламы в режиме 24/7</p>
				</div>
				<div class="scope_items">
					<h3>Абитуриенты</h3>
					<p>Станьте ближе к вашей целевой аудитории. Взаимодействуйте с вашими настоящими и будущими студентами в онлайн- и офлайн-режимах</p>
				</div>
			</div>
			<div class="col-lg-5">
				<h3 class="scope_items_heading">ПЕДАГОГАМ</h3>
				<div class="scope_items">
					<h3>Курсы</h3>
					<p>Делитесь своими обучающими материалами с посетителями портала на платной и бесплатной основах. С «КОРПОРАЦИЕЙ МОЗГА» ваши труды будут всегда востребованными</p>
				</div>
				<div class="scope_items">
					<h3>Работа</h3>
					<p>Мы поможем вам получить постоянную занятость. Просто разместите информацию о том, чему вы готовы обучить студентов и получайте заявки онлайн!</p>
				</div>
				<div class="scope_items">
					<h3>Реклама</h3>
					<p>Набирайте группы учеников на свои курсы с помощью возможностей нашего портала. Получите бесплатное продвижение ваших услуг среди учеников и студентов</p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="stage">
	<div class="container">
		<div class="row">
			<div class="col-lg-2 col-lg-offset-2">
				<div class="stage-item">
					<img src="/images/vuzam_prepod/1.png">
					<p>Публикуйте обучающие материалы</p>
				</div>
			</div>
			<div class="col-lg-2">
				<div class="stage-item">
					<img src="/images/vuzam_prepod/2.png">
					<p>Разместите информацию <br>о ВУЗе</p>
				</div>
			</div>
			<div class="col-lg-2">
				<div class="stage-item">
					<img src="/images/vuzam_prepod/3.png">
					<p>Расскажите о том, что вы готовы обучать студентов</p>
				</div>
			</div>
			<div class="col-lg-2">
				<div class="stage-item">
					<img src="/images/vuzam_prepod/4.png">
					<p>Ведите общение с заинтересованными пользователями</p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="paralax_four" data-parallax="scroll" data-image-src="/images/vuzam_prepod/paralax_four.png"></div>
<div class="register_in">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h3>Контакты <span>Обратитесь к нам за бесплатной консультацией <br> по любым вопросам:</span></h3>
				<h4><a href="tel:+79260784852">+7 (926) 078-48-52</a></h4>
				<h4><a href="mailto:info@brainincorporated.com">info@brainincorporated.com</a></h4>
				<h3>Регистрируйтесь <span>ЗА 10 СЕКУНД</span></h3>
				<form class="form-horizontal">
					<div class="col-md-10 col-md-offset-1">
						<div class="row">
							<div class="col-md-4">
								<input class="form-control" type="text" placeholder="Имя">
							</div>
							<div class="col-md-4">
								<input class="form-control" type="text" placeholder="Email">
							</div>
							<div class="col-md-4">
								<button type="submit" class="btn btn-primary btn_registration_in">
									Зарегистрироваться 
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop