@extends('layouts.app')

@section('content')
<div class="container no__home">
	<div class="row">
		<div class="col-md-12">
 
			@if(@count(Session::get('courseMsg')))
			    <div class="alert alert-{{ Session::get('courseMsg.success') ? 'success' : 'danger' }}">
			    	<p>{{ Session::get('courseMsg.success') ? Session::get('courseMsg.success') : Session::get('courseMsg.error') }}</p>
			    </div> 
			@endif 

			<h1>{{ $course->name }}</h1>
			<ul class="icons__info"> 
				@if($canMakeRequest == true)
					@php $flag=true; @endphp
					@if($course->hide_after_end == 1)
						@if($course->max_nr_people > count($course->userRequests) 
					    && dateToTimestamp($course->is_open_to) > dateToTimestamp(date('Y-m-d')))
							<li><i class="fa fa-calendar"></i> &nbsp;
								Идет набор до {{ date('d.m.Y', strtotime($course->is_open_to)) }}
							</li> 
						@else
							@php $flag=false; @endphp
						@endif
					@elseif($course->max_nr_people == count($course->userRequests))
						@php $flag=false; @endphp 
					@endif

					@if($flag==false)
						<li> 
							<i class="fa fa-calendar"></i>  Набор закончен
						</li>
					@endif
				@endif  

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
							₽{{ $course->price }}
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

			@php
				
			@endphp
			<button type="button" 
					@if($canMakeRequest==false && Auth::check() == true)
						disabled
					@endif
			        onclick="courseRequest(this, {{ $course->id }}, '{{ Auth::check() }}', '{{ $canMakeRequest }}')" 
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
					@php $sectionNum = 1; @endphp
					@foreach($course->sections as $section)
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
									@php $lectureNum = 1; @endphp
									@foreach($section->lectures as $lecture)
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
										@php $lectureNum++ @endphp
									@endforeach
								</table>
					        </div>
					      </div>
					    </div> 
					    @php $sectionNum++ @endphp
				    @endforeach
				</div> 
			</div>
			<a href="/courses" class="btn btn-default">Вернуться в каталог курсов</a>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('li.courseSections').text('{{ $lectureNum }} {{ lectionCase($lectureNum) }}');
	});
</script>

<style>

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