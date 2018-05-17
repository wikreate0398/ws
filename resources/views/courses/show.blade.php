@extends('layouts.app')

@section('content')
<div class="container no__home">
	<div class="row">
		<div class="col-md-12">
			<h1>{{ $course->name }}</h1>
			<ul class="icons__info">
				<li>
					<i class="fa fa-calendar" aria-hidden="true"></i>
					&nbsp;20.10.2018
				</li>
				<li>
					<i class="fa fa-user" aria-hidden="true"></i>
					&nbsp;1
				</li>
				<li>
					1 месяц
				</li>
				<li>
					8 лекций
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
</style>

@stop