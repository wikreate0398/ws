@extends('layouts.app')

@section('content')
<div class="container no__home teacher_page">
	<div class="row">
 
		<div class="col-lg-10 col-lg-offset-1">
			<ul class="breadcrumb">
			  <li><a href="/">Главная</a></li>
			  <li><a href="/teachers">Каталог преподавателей</a></li>
			  <li class="active">Гапонова Маргариа Поликарповна</li>
			</ul>
		</div>
		<div class="col-lg-3"> 
			<img class="img-responsive"
				 style="width: 100%;"
				 src="{{ imageThumb(@$teacher->image, 'uploads/users', 400, 500, 'list') }}"
				 title="Brain Incorporated | Учитель {{ $teacher['name'] }} образовательного портала России и мира"
				 alt="Корпорация Мозга | Учитель {{ $teacher['name'] }} образовательного портала России и мира">
			<button @if($hasRequest==true && Auth::check() == true)
						disabled
					@endif
			        type="button" 
			        class="btn submit_application"
			        onclick="teacherRequest(this, {{ $teacher->id }}, '{{ Auth::check() }}', '{{ @$hasRequest }}')">
			    Оставить заявку
			</button>
			<span class="price_hour">От {{ $teacher->price_hour }} р/час</span>
		</div>
		<div class="col-lg-9">
			@if(@count(Session::get('teacherMsg')))
			    <div class="alert alert-{{ Session::get('teacherMsg.success') ? 'success' : 'danger' }}">
			    	<p>{{ Session::get('teacherMsg.success') ? Session::get('teacherMsg.success') : Session::get('teacherMsg.error') }}</p>
			    </div> 
			@endif

			<div class="teachers_name">
				<ul class="list-inline teachers_label pull-left">
					@if(@Auth::check())
					<li class="teachers_bookmark"> 
						<i class="fa course_heart {{ $bookmark ? 'is_favorite fa-heart' : 'fa-heart-o' }}" 
						   onclick="teacherBookmark(this, {{ $teacher->id }});" 
						   aria-hidden="true"></i>
					</li>
					@endif
					<li class="teachers_employment">
						{{ $teacher->is_available ? 'Свободен' : 'Занят' }}
					</li>
				</ul>
				<ul class="list-inline teachers_label pull-right">
					<li class="teachers_rating">
						<select class="rating-stars" name="rating" data-readonly="true" data-current-rating="{{ floatval($teacher->teacherReviews->avg('rating')) }}" autocomplete="off">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
					</li>
					<li class="teachers_comment">
						{{ $teacher->teacherReviews->count() }} {{ format_by_count($teacher->teacherReviews->count(), 'Отзыв', 'Отзыва', 'Отзывов') }}
					</li>
				</ul>
				<div class="clearfix"></div>
				<h2>
					@php
						$nameExplode = explode(' ', $teacher['name']);
						echo $nameExplode[0] . '<br>'; unset($nameExplode[0]);
						echo implode(' ', $nameExplode);
					@endphp 
				</h2>
				<span class="teachers_date">{{ getUserYears($teacher->date_birth) }} лет, 
				@php 
                    $d1 = new DateTime(date('Y-m-d'));
                    $d2 = new DateTime($teacher->experience_from); 
                    $diff = $d2->diff($d1);  
                @endphp
				@if($teacher->experience_from) 
                    @if($diff->y > 0 or $diff->m > 1 ) опыт работы  @endif 
                    @if($diff->y > 0)
                        {{ $diff->y }}
                        @if($diff->y == 1)
                            год
                        @elseif($diff->y > 1 && $diff->y < 5)
                            года
                        @else
                            лет
                        @endif
                    @endif
                    
                    @if($diff->m)
                        @if($diff->y > 0) и @endif
                         
                        @if($diff->m == 1) 
                            @if($diff->y > 0  && $diff->y > 0)
                                {{ $diff->m }} месяц  
                            @else
                                Без опыта
                            @endif 

                        @elseif($diff->m > 1 && $diff->m < 5)
                            {{ $diff->m }} месяца
                        @else
                            {{ $diff->m }} месяцев
                        @endif
                    @elseif($diff->y == 0 && $diff->m == 0)
                        Без опыта
                    @endif 
                @else
                	Без опыта
				@endif
				, {{ ($teacher->sex == 'male') ? 'Мужской' : 'Женский' }}
				</span>
			</div>
			<div class="teachers_adress">
				<i class="fa fa-map-marker" aria-hidden="true"></i> {{ @$teacher->cityData->name }}, {{ @$teacher->address }}
			</div>
			@if(count($teacher->teacherSpecializations))			
			<ul class="list-inline teachers_specialization">
				@foreach($teacher->teacherSpecializations as $specialization)
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
			@if(count($teacher->educations)) 
				<div class="teachers_education">
				{{ implode(', ', $teacher->educations->pluck('institution_name')->toArray()) }}
				</div>
			@endif
			<div class="teachers_about">
				{{ $teacher->about }}
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col-lg-12">
			<hr class="teacher_delimiter">
		</div>
		<div class="col-lg-3">
			<div class="share_block">
				<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
				<script src="//yastatic.net/share2/share.js"></script>
				<div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter"></div>
			</div>
			<div id="page_teacher_universities" class="owl-carousel owl-theme">
				@foreach($universities as $university)
				<div class="item"> 
					<a href="/university/<?=$university['id']?>/"> 
						<img class="img-responsive"
							 src="{{ imageThumb(@$university['user']['image'], 'uploads/users', 400, 400, 'university_list') }}"
							 title="Brain Incorporated | Учебное заведение {{ $university['full_name'] }} образовательного портала России и мира | Лучшие ВУЗы Москвы"
							 alt="Корпорация Мозга | Учебное заведение {{ $university['full_name'] }} образовательного портала России и мира | Лучшие ВУЗы Москвы">
					</a> 
					<h3><a href="/university/<?=$university['id']?>">{{ $university['full_name'] }}</a></h3>
					<ul class="list-unstyled">
						<li>
							{{ count($university->user->courses) }} 
                       		{{ format_by_count(count($university->user->courses), 'курс', 'курса', 'курсов') }}
						</li>
						<li>
							{{ count($university->user->connectionTeachers) }}   
                            {{ format_by_count(count($university->user->connectionTeachers), 'ПРЕПОДАВАТЕЛЬ','ПРЕПОДАВАТЕЛЯ','ПРЕПОДАВАТЕЛЕЙ') }} 
						</li>
					</ul>
				</div>
				@endforeach
				 
			</div>
		</div>
		<div class="col-lg-9">
			 
			<div class="teachers_locations">
			<h3>Места проведения занятий</h3>
				<span>
				<i class="fa fa-map-marker" aria-hidden="true"></i> 
				@if($teacher->lesson_place)
					{{ $teacher->lesson_place }}
				@else
					{{ @$teacher->cityData->name }}, {{ @$teacher->address }}
				@endif
				</span>
			</div>
			 
			@if(count($lesson_options))
			<ul class="list-inline place_realization">	
				@foreach($lesson_options as $lesson_option)
				<li>
					<div class="checkbox">
					  <label>
						<input type="checkbox" value="" disabled {{ in_array($lesson_option['id'], $teacher->lesson_options->pluck('id')->toArray()) ? 'checked' : '' }}>
						<span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
						{{ $lesson_option->name2 ? $lesson_option->name2 : $lesson_option->name }}
					  </label>
					</div>
				</li>
				@endforeach 
			</ul>
			@endif
			@if(count($teacher->certificates))
			<div class="licenses_diplomas">
				<h3>ЛИЦЕНЗИИ И ДИПЛОМЫ</h3>
				<div class="row">
					@foreach($teacher->certificates as $certificate)
						<div class="col-lg-4">
							<a href="/public/uploads/users/certificates/{{ @$certificate->image }}" class="fancybox">
								<img class="img-responsive" src="{{ imageThumb(@$certificate->image, 'uploads/users/certificates', 400, 500, 'teacher_in') }}">
						    </a>
						</div>
					@endforeach
				</div>
			</div>
			@endif

			@if(count($teacher->teacherReviews) > 0)
				<div class="review__container">
					<h3>Отзывы ({{ count($teacher->teacherReviews) }})</h3>
					<div class="reviews_items">
						@foreach($teacher->teacherReviews as $review)
							<div class="review_item">

								<div class="review__top_side">
									<div class="review__left_side">
										<div class="review__user_image" style="background-image: url({{ imageThumb(($review->user->avatar ? $review->user->avatar : $review->user->image), 'uploads/users', 150, 150, 'small') }})"></div>
										<div class="review__user_info">
											<div class="review__post_date">
												{{ date('d.m.Y H:i', strtotime($review['created_at'])) }}
											</div>
											<div class="review__user_name">
												{{ $review->user->name }}
											</div>
										</div>
									</div>

									<div class="stars stars-example-fontawesome">
										<select class="rating-stars" name="rating" data-readonly="true" data-current-rating="{{ $review['rating'] }}" autocomplete="off">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</div>

								</div>

								<div class="review__message">
									{{ $review['review'] }}
								</div>
							</div>
						@endforeach
					</div>
				</div>
			@endif

			@if(Auth::check() && !in_array(Auth::user()->id, $teacher->teacherReviews->pluck('id_user')->toArray()) && @Auth::user()->user_type == 1)
				<div class="review__container">
					<button class="btn" onclick="$('.review__form').slideToggle()">Оставить Отзыв</button>
					<div class="review__form" style="display: none;">
						<form action="{{ route('teacher_review', ['id' => $teacher->id]) }}" class="ajax__submit">
							{{ csrf_field() }}
							<textarea name="message" placeholder="Комментарий" class="form-control"></textarea>
							<div class="stars stars-example-fontawesome">
								<select class="rating-stars" name="rating" autocomplete="off">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
							</div>
							<div id="error-respond"></div>
							<button class="btn btn_save" type="submit">Добавить</button>
						</form>
					</div>
				</div>
			@endif

			<style>
				.review__container{
					margin-bottom: 20px;
					margin-top: 40px;
				}

				.title__review_section{
					font-weight: bold !important;
					font-size: 18px !important;
					text-transform: uppercase;
					color: #333 !important;
					margin-top: 30px !important;
					margin-bottom: 20px;
				}

				.review__form{
					margin-top: 20px;
				}

				.review__form .btn_save{
					margin-top: 10px;
					float: none !important;
				}

				.stars{
					margin-top:10px;
				}

				.review__user_image{
					display: block;
					border-radius: 50%;
					width: 60px;
					height: 60px;
					background-repeat: no-repeat;
					background-position: center;
					background-size: cover;
					background-color: #ededed;
				}

				.review_item {
					padding: 20px;
					-webkit-box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.349019607843137);
					box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.349019607843137);
					margin-bottom: 20px;
				}

				.review__post_date{
					color: #ccc;
					font-size: 12px;
				}

				.review__user_name{
					font-weight: bold;
					text-transform: uppercase;
					font-size: 15px;
				}

				.review__left_side{
					justify-content: flex-start;
					display: flex;
					align-items: center;
				}

				.review__top_side{
					justify-content: space-between;
					display: flex;
					align-items: center;
				}

				.review__user_info{
					margin-left: 10px;
				}

				.review__message{
					margin-top: 10px;
					font-size: 14px;
					color: #333;
				}

			</style>

		</div>
	</div>
</div>
@stop