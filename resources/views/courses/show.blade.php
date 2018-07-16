@extends('layouts.app')

@section('content')
<div class="container no__home">
	<div class="row course__in">
		<div class="col-md-9">
			<ul class="breadcrumb">
				<li><a href="/">Главная</a></li>
				<li><a href="/courses">Курсы</a></li>
				<li><span>{{ $course->name }}</span></li>
			</ul>
 
			@if(@count(Session::get('courseMsg')))
			    <div class="alert alert-{{ Session::get('courseMsg.success') ? 'success' : 'danger' }}">
			    	<p>{{ Session::get('courseMsg.success') ? Session::get('courseMsg.success') : Session::get('courseMsg.error') }}</p>
			    </div> 
			@endif 

			<h1>{{ $course->name }}</h1>
			<h3>
				@if($course->user->user_type==3)
	            		{{ $course->user->university['full_name'] }} 
	            	@else
						{{ $course->user->name }} 
	            @endif
			</h3>
			<ul class="icons__info">
				@php 
                    $esablishDate = Course::manager($course)->esablishDate();  
                @endphp 
				<li> 
					<i class="fa fa-calendar"></i> {{ $esablishDate['status'] }} {{ $esablishDate['date'] }}
				</li> 
				<li>
					<i class="fa fa-user" aria-hidden="true"></i>
					&nbsp;{{ count($course->userRequests) }}
				</li>
				<li>
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
				<li class="courseSections">
				
				</li>
			</ul>

			<ul class="price_review">
				<li>
					<button class="price__in_course">
						@if($course->pay == 1)
							БЕСПЛАТНО
						@else
							₽{{ priceString(Course::generatePrice($course)) }}
        				@endif 
					</button>
				</li>
				<li>
					<a href="">СКАЧАТЬ ПРОГРАММУ</a>
				</li>
				<li>
					ОТЗЫВЫ (6) &nbsp;&nbsp;
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
				</li> 
			</ul>
  
			<button type="button" 
					@if(Course::request($course)->canMakeRequest() !== true && Auth::check() == true)
						disabled
					@endif
			        onclick="courseRequest(this, {{ $course->id }}, '{{ Auth::check() }}', '{{ (Course::request($course)->canMakeRequest()!==true) ? false : true }}')" 
			        class="btn course_request_btn">
			    ЗАПИСАТЬСЯ НА КУРС
			</button> 

			<div class="about__course">
				<h2>О КУРСЕ</h2>
				<p>{{ $course->text }}</p>
			</div>

			<div class="academic_plan">
				<h2>УЧЕБНЫЙ ПЛАН</h2>

				<div class="panel-group" id="accordion">
					@php $sectionNum = 0; @endphp
					@php $totaLecture = 0; @endphp
					@foreach($course->sections as $section)
						@php $sectionNum++ @endphp
					    <div class="panel panel-default">
					      <div class="panel-heading">
					        <h4 class="panel-title">
					       		<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $sectionNum }}">
					        		<strong>Раздел {{ $sectionNum }}:</strong> {{ $section->name }}
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
									@endforeach
								</table>
					        </div>
					      </div>
					    </div>  
				    @endforeach
				</div> 
			</div>
			<a href="/courses" class="btn btn-default">Вернуться в каталог курсов</a>
		</div>

		<div class="col-md-3">
			<div class="course__sidebar_box">
				@if($course->user->user_type == 2)
					<h3>ПРЕПОДАВАТЕЛь КУРСА</h3>
				@else
					<h3>ПРЕПОДАВАТЕЛИ КУРСА</h3>
				@endif
				<div class="trainer__box">
					@php
						if($course->user->user_type==3){
							$link = '/university/' . $course->user->university->id;
						}else{
							$link = '/teacher/' . $course->user->id;
						}
					@endphp
					<a href="{{ $link }}" class="trainer_photo" style="background-image: url(/public/uploads/users/{{ $course->user->avatar ? $course->user->avatar : $course->user->image }}{{'?v=' . time()}})"> 
					</a>
					<a href="{{ $link }}" class="trainer_name">
						@if($course->user->user_type==3)
			            		{{ $course->user->university['full_name'] }} 
			            	@else
								{{ $course->user->name }} 
			            @endif
					</a>
					<div class="trainer_description">
						{{ str_limit($course->user->about, 100) }} 
					</div>
				</div>
			</div>

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

	.course__in h1{
		text-transform: uppercase;
		font-size: 22px;
		font-weight: bold;
	}
	.course__in h3 {
		color: #ccc;
		text-transform: uppercase;
		font-size: 16px;
		margin-top: 0px;
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
</style>

@stop