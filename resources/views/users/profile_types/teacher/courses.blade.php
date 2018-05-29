
<div class="course_lk">
	<div class="row">
		@if(isset($courses)) 
		@foreach($courses as $course)
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
					<h3>{{ $course->name }}</h3>
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
					<div class="row">
						<div class="col-lg-6">
							<div class="more_card"><a href="/user/profile/course/{{ $course->id }}/edit">Управлять курсом</a></div>
						</div>
						<div class="col-lg-6">
							<div class="more_card delete__item"><a href="{{ route('delete_course', ['id' => $course->id]) }}">Удалить</a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endforeach 
		@else
		<div class="col-lg-12">
			<h5>Вы не добавили ни одного курса</h5>
		</div>
		@endif
		<div class="col-lg-12">
			<hr>
			<a class="btn_add_course" href="{{ route('add_course') }}">Добавить курс</a>
		</div>
	</div>
</div>
 