@extends('layouts.app')

@section('content')
<div class="container no__home">
	<div class="row course__in course_page">
	    <div class="col-lg-12">
			<ul class="breadcrumb">
				<li><a href="/">Главная</a></li>
				<li><a href="/courses">Курсы</a></li>
				<li><span>{{ $course->name }}</span></li>
			</ul>
			<ul class="list-inline card_tag">
				<li class="tag_sticker">
					<span>Профессиональные курсы</span>
				</li> 
				<li class="bookmark_tag">
					<i class="fa fa-bookmark-o" onclick="courseFavorite(this, 6);" aria-hidden="true"></i> 
				</li> 
			</ul>
			<h1>{{ $course->name }}</h1>
			<h2>
				@if($course->user->user_type==3)
	            		{{ $course->user->university['full_name'] }} 
	            	@else
						{{ $course->user->name }} 
	            @endif
			</h2>
			<ul class="list-inline short_info_course">
				@php 
                    $esablishDate = Course::manager($course)->esablishDate();  
                @endphp 
				<li><i class="fa fa-calendar"></i> {{ $esablishDate['status'] }} {{ $esablishDate['date'] }}</li>
				<li><i class="fa fa-user" aria-hidden="true"></i> {{ count($course->userRequests) }}</li>
				<li><i class="fa fa-clock-o" aria-hidden="true"></i>
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
				</li>
				<li class="courseSections"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></li>
			</ul>
			<ul class="list-inline price_info_course">
				<li class="price">
					@if($course->pay == 1)
						Бесплатно
					@else
						₽{{ priceString(Course::generatePrice($course)) }}
					@endif 
				</li>
				<li class="download_program">
					<a href="">Скачать программу</a>
				</li>
				<li class="review_count">
					<div class="course_top_stars" style="display: inline-block; vertical-align: middle;">
		                <select class="rating-stars" name="rating" data-readonly="true" data-current-rating="{{ floatval($course->reviews->avg('rating')) }}" autocomplete="off">
		                  <option value="1">1</option> 
		                  <option value="2">2</option>
		                  <option value="3">3</option>
		                  <option value="4">4</option>
		                  <option value="5">5</option>
		                </select> 
		          	</div> 
					({{ count($course->reviews) }})
				</li>
			</ul>
			<ul class="list-inline add_list_course">
				<li>
					<button type="button" 
						@if(Course::request($course)->canMakeRequest() !== true && Auth::check() == true)
							disabled
						@endif
						onclick="courseRequest(this, {{ $course->id }}, '{{ Auth::check() }}', '{{ (Course::request($course)->canMakeRequest()!==true) ? false : true }}')" 
						class="btn add_course_btn course_request_btn">
						ЗАПИСАТЬСЯ НА КУРС
					</button> 
				</li>
				<li>
					<button type="button" 
						@if(Course::request($course)->canMakeRequest() !== true && Auth::check() == true)
							disabled
						@endif
						onclick="courseRequest(this, {{ $course->id }}, '{{ Auth::check() }}', '{{ (Course::request($course)->canMakeRequest()!==true) ? false : true }}')" 
						class="btn add_course_free course_request_btn">
						ПОПРОБЫВАТЬ БЕСПЛАТНО
					</button> 
				</li>
			</ul>
		</div>
		<div class="col-md-9">
 
			@if(@count(Session::get('courseMsg')))
				<script> 
					$(document).ready(function(){  
						showFadeModal("{{ Session::get('courseMsg.success') ? 'success' : 'danger' }}", 
							          "{{ Session::get('courseMsg.success') ? Session::get('courseMsg.success') : Session::get('courseMsg.error') }}");
					});
				</script> 
			@endif

			<div class="about__course">
				<p>{{ $course->text }}</p>
			</div>
			<div class="program_plan">
				<h3>УЧЕБНЫЙ ПЛАН</h3>
				<div class="panel-group program_group" id="accordion">
					@php $sectionNum = 0; @endphp
					@php $totaLecture = 0; @endphp
					@foreach($course->sections as $section)
						@php $sectionNum++ @endphp
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $sectionNum }}">
										Раздел {{ $sectionNum }}: <span>{{ $section->name }}</span>
									</a>
								</h4>
							</div>
							<div id="collapse{{ $sectionNum }}" class="panel-collapse collapse {{ ($sectionNum == 1) ? 'in' : ''}}">
								 <div class="panel-body">
									<table class="table">
										@php $lectureNum = 0; @endphp
										@foreach($section->lectures as $lecture)
											@php $lectureNum++; $totaLecture++ @endphp
											<tr>
												<td>
													ЛЕКЦИЯ {{ $sectionNum }}.{{ $lectureNum }}
													{{ $lecture->name }}
												</td>
												<td style="text-align: right;">
													<i class="fa fa-clock-o" aria-hidden="true"></i>
													{{ $lecture->duration_hourse }} ч {{ $lecture->duration_minutes }} мин.
												</td>
											</tr> 
											<tr>
												<td colspan="2" style="font-size: 14px; padding-top: 0px;">
													{{ $lecture->description }}
												</td>
											</tr>
										@endforeach
									</table>
								 </div>
							</div>
						</div>
					@endforeach
				</div>
			</div>

			@if(count($course->reviews) > 0)
				<div class="review__container">
					<h3>Отзывы ({{ count($course->reviews) }})</h3>
					<div class="reviews_items"> 
						@foreach($course->reviews as $review)
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
  
			@if(Course::manager($course)->isFinished() && Course::request($course)->ifHasRequest()) 
				@if(!Course::manager($course)->ifHasUserReview(@Auth::user()->id))
					<div class="review__container">
						<button class="btn" onclick="$('.review__form').slideToggle()">Оставить Отзыв</button>
						<div class="review__form" style="display: none;">
							<form action="{{ route('course_review', ['id' => $course->id]) }}" class="ajax__submit">
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
			@endif 

			<style>
				.review__container{
					margin-bottom: 20px;
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

			<a href="/courses" class="btn btn-default">Вернуться в каталог курсов</a>
		</div>

		<div class="col-md-3">
			@if($course->user->user_type==3)
				@if(count($course->teachers))
					<div id="course_teachers_slider" class="owl-carousel owl-theme">
						@foreach($course->teachers as $teacher)
							<div class="trainer__box">
								@php
									$link = '/teacher/' . $teacher->id;
								@endphp
								<a href="{{ $link }}" class="trainer_photo" style="background-image: url({{ imageThumb(($teacher->avatar ? $teacher->avatar : $teacher->image), 'uploads/users', 150, 150, 'small') }})"> 
								</a>
								<a href="{{ $link }}" class="trainer_name">
									{{ $teacher->name }} 
								</a>
								<div class="trainer_description">
									{{ str_limit($teacher->about, 100) }} 
								</div>
							</div>
						@endforeach
					</div>
				@endif 
			@else
				<div class="trainer__box">
					@php
						$link = '/teacher/' . $course->user->id;
					@endphp
					<a href="{{ $link }}" class="trainer_photo" style="background-image: url({{ imageThumb(($course->user->avatar ? $course->user->avatar : $course->user->image), 'uploads/users', 150, 150, 'small') }})"> 
					</a>
					<a href="{{ $link }}" class="trainer_name">
						{{ $course->user->name }} 
					</a>
					<div class="trainer_description">
						{{ str_limit($course->user->about, 100) }} 
					</div>
				</div>
			@endif
			
			@if(count($course->certificates) > 0)
				<div class="course__sidebar_box" style="padding-bottom: 30px;">
					<h3>СЕРТИФИКАТ ОБ <br> ОКОНЧАНИИ</h3>
					<div class="certificates__box owl-carousel owl-theme" id="certificates__box">
					 	@foreach($course->certificates as $certificate)
							<div class="certificate_slider__item">
								<img src="/public/uploads/courses/certificates/{{ $certificate->image }}" alt="">
							</div>
					 	@endforeach
					</div>
				</div>
			@endif

		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('li.courseSections').text('{{ $totaLecture }} {{ lectionCase($totaLecture) }}');
	});
</script>

<style>
	
	.certificate_slider__item img{
		max-width: 100%;
	}

	.course__sidebar_box{
		background: #f2f2f2;
		padding:0 20px 50px 20px;
		text-align: center;
		margin-bottom: 20px;
	}

	.course__sidebar_box h3{
		text-transform: uppercase;
		font-weight: 700;
		text-align: center;
		font-size: 16px;
		color: #333 !important;
		padding: 25px 0;
		margin: 0;
	}

	.trainer__box{
		background: #fff;
		border-radius: 5%;
		box-shadow: 0 1px 3px rgba(0,0,0,.3);
		padding: 15px;
		margin:5px;
		text-align: center;
	}

	#course_teachers_slider{
		margin-bottom: 20px;
	}

	.trainer_photo{
		display: block;
		border-radius: 50%;
		width: 100px;
		height: 100px;
		margin: auto;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		background-color: #ededed;
	}

	.trainer_name, .trainer_name:hover, .trainer_name:focus{
		text-transform: uppercase;
		font-weight: bold;
		color: #333;
		font-size: 13px;
		margin:15px 0;
		text-decoration: none;
		line-height: 21px;
		display: block;
	}

	.trainer_description{
		font-size: 12px;
	}


	.academic_plan table tr td{
		border:none;
	}
	
	.about__course h2, .academic_plan h2{
		font-weight: bold;
		text-transform: uppercase;
		font-size: 18px;
	}

	.icons__info{
		font-size: 12px;
		padding: 0;
		margin-top: 30px; 
	}
	.icons__info li{
		list-style: none;
		display: inline-block;
		margin-right: 20px;
		color: #b93777;
	}

	.price_review{
		padding: 0;
		margin-top: 30px;
		text-transform: uppercase;
		font-size: 12px;
	}

	.price_review li{
		list-style: none;
		display: inline-block;
		margin-right: 20px; 
	}

	.price__in_course{
		padding:8px 15px;
		font-weight: bold;
		color: #fff;
		font-size: 18px;
		border-radius: 5px;
		background-color: #b93777;
		outline: none;
		border: none;
	}

	.course_request_btn{
		border: none;
		background-color: #b93777;
		color: #fff;
		text-transform: uppercase;
		padding: 5px 15px;
		border-radius: 20px;
	}

	.course_request_btn:disabled{
		background-color: #ccc;
	}

	.course_top_stars a{
		font-size: 14px !important;
	}

	.course_top_stars .br-widget{
		height: auto !important;
	}
</style>

@stop