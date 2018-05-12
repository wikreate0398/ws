@extends('layouts.app')

@section('content')
<div class="container no__home">
	<div class="row">
		<div class="col-lg-3"> 
			<img class="img-responsive img-circle" src="/public/uploads/users/{{ $teacher->avatar ? $teacher->avatar : $teacher->image }}">
			<div>
			от {{ $teacher->price_hour }} руб/час
			</div>
		</div>
		<div class="col-lg-9">
			<ul class="list-inline">
				<li>{{ $teacher->is_available ? 'Свободен' : 'Занят' }}</li>
				<li>Добавить в избранное</li>
			</ul>
			<h1>{{ $teacher->name }}</h1>
			{{ date('Y') - date('Y', strtotime($teacher->date_birth)) }} лет, опыт преподавания {{ date('Y') - $teacher->experience_from }} лет <br>
			ГОРОД:<br>
			{{ @$teacher->cityData->name }}, ЦАО, ВОРОШИЛОВСКОЕ ШОССЕ<br>

			@if(count($teacher_specializations))
				@php 
					$teacher_specializations = array_map(function ($item) {
					    return $item['id_specialization'];
					}, $teacher_specializations->toArray());     
				@endphp
				СПЕЦИАЛИЗАЦИЯ: {{ implode(', ', $teacher_specializations) }}<br>
			@endif
			
			@if(count($teacher_subjects))
				@php
					$teacher_subjects = array_map(function ($item) {
					    return $item['name'];
					}, $teacher_subjects->toArray());    
				@endphp 
				ПРЕДМЕТНАЯ ОБЛАСТЬ: {{ implode(', ', $teacher_subjects) }}<br>
			@endif

			ПОЛ:{{ ($teacher->sex == 'male') ? 'Мужской' : 'Женский' }}<br>

			@if(count($educations))
				@php
					$educations = array_map(function ($item) {
					    return $item['institution_name'];
					}, $educations->toArray());    
				@endphp 
				ОБРАЗОВАНИЕ <br>
				{{ implode(', ', $educations) }}<br>
			@endif

			 
			О СЕБЕ<br>
			{{ $teacher->about }}<br>
			МЕСТА ПРОВЕДЕНИЯ ЗАНЯТИЙ<br>
			<ul class="list-inline">
				<li>
					<i class="fa fa-map-marker"></i>
					МОСКВА, ЦАО, ВОРОШИЛОВСКОЕ ШОССЕ
				</li>
				@php
					$teacher_lesson_options = array_map(function ($item) {
					    return $item['id_lesson_option'];
					}, $teacher_lesson_options->toArray());    
				@endphp  
				@foreach($lesson_options as $lesson_option)
					<li class="{{ in_array($lesson_option['id'], $teacher_lesson_options) ? 'active' : '' }}"> 
						<i class="fa fa-chevron-circle-down"></i>
						{{ $lesson_option->name }}
					</li>
				@endforeach 
			</ul>

			@if(count($certificates))
			ЛИЦЕНЗИИ И ДИПЛОМЫ
			<div class="row">
				@foreach($certificates as $certificate)
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