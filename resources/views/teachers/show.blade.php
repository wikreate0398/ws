@extends('layouts.app')

@section('content')
<div class="container no__home teacher_page">
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			<ul class="breadcrumb">
			  <li><a href="#">Главная</a></li>
			  <li><a href="#">Каталог преподавателей</a></li>
			  <li class="active">Гапонова Маргариа Поликарповна</li>
			</ul>
		</div>
		<div class="col-lg-3"> 
			<img class="img-responsive" src="/public/uploads/users/{{ $teacher->avatar ? $teacher->avatar : $teacher->image }}">
			<button type="button" class="btn submit_application">Оставить заявку</button>
			<span class="price_hour">От {{ $teacher->price_hour }} р/час</span>
		</div>
		<div class="col-lg-9">
			<div class="teachers_name">
				<ul class="list-inline teachers_label pull-left">
					<li class="teachers_bookmark">
						<i class="fa fa-bookmark" aria-hidden="true"></i>
					</li>
					<li class="teachers_employment">
						{{ $teacher->is_available ? 'Свободен' : 'Занят' }}
					</li>
				</ul>
				<ul class="list-inline teachers_label pull-right">
					<li class="teachers_rating">
						<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
					</li>
					<li class="teachers_comment">
						15 отзывов
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
				<span class="teachers_date">{{ date('Y') - date('Y', strtotime($teacher->date_birth)) }} лет, 
				@php 
					$d1 = new DateTime(date('Y-m-d'));
					$d2 = new DateTime($teacher->experience_from); 
					$diff = $d2->diff($d1);  
				@endphp
				@if($teacher->experience_from)
					опыт работы   
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
						{{ $diff->m }}
						@if($diff->m == 1)
							месяц
						@elseif($diff->m > 1 && $diff->m < 5)
							месяца
						@else
							месяцев
						@endif
					@endif 
				@endif
				, {{ ($teacher->sex == 'male') ? 'Мужской' : 'Женский' }}
				</span>
			</div>
			<div class="teachers_adress">
				<i class="fa fa-map-marker" aria-hidden="true"></i> {{ @$teacher->cityData->name }}, ЦАО, ВОРОШИЛОВСКОЕ ШОССЕ
			</div>
			@if(count($teacher->specializations))			
			<ul class="list-inline teachers_specialization">
				@foreach($teacher->specializations as $specialization)
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
		
		</div>
		<div class="col-lg-9">
			Места проведения занятий
			<i class="fa fa-map-marker" aria-hidden="true"></i> {{ @$teacher->cityData->name }}, ЦАО, ВОРОШИЛОВСКОЕ ШОССЕ
			
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
			ЛИЦЕНЗИИ И ДИПЛОМЫ
			<div class="row">
				@foreach($teacher->certificates as $certificate)
					<div class="col-lg-4">
						<img class="img-responsive" src="/public/uploads/users/certificates/{{ $certificate->image }}">
					</div> 
				@endforeach
			</div>
			@endif
		</div>
	</div>
</div>
@stop