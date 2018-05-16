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
			{{ date('Y') - date('Y', strtotime($teacher->date_birth)) }} лет

			@if($teacher->experience_from != null)
                , опыт преподавания {{ date('Y', strtotime($teacher->experience_from)) }} лет
            @endif
 
			  <br>
			ГОРОД:<br>
			{{ @$teacher->cityData->name }}, ЦАО, ВОРОШИЛОВСКОЕ ШОССЕ<br>

			@if(count($teacher->specializations))
				СПЕЦИАЛИЗАЦИЯ: {{ implode(', ', $teacher->specializations->pluck('name')->toArray()) }}<br>
			@endif
			
			@if(count($teacher->subjects))
				ПРЕДМЕТНАЯ ОБЛАСТЬ: {{ implode(', ', $teacher->subjects->pluck('name')->toArray()) }}<br>
			@endif

			ПОЛ:{{ ($teacher->sex == 'male') ? 'Мужской' : 'Женский' }}<br>

			@if(count($teacher->educations)) 
				ОБРАЗОВАНИЕ <br>
				{{ implode(', ', $teacher->educations->pluck('institution_name')->toArray()) }}<br>
			@endif
			 
			О СЕБЕ<br>
			{{ $teacher->about }}<br>
			МЕСТА ПРОВЕДЕНИЯ ЗАНЯТИЙ<br>
			<ul class="list-inline">
				<li>
					<i class="fa fa-map-marker"></i>
					МОСКВА, ЦАО, ВОРОШИЛОВСКОЕ ШОССЕ
				</li>
				@if(count($teacher->lesson_options))
					@foreach($lesson_options as $lesson_option)
						<li class="{{ in_array($lesson_option['id'], $teacher->lesson_options->pluck('id')->toArray()) ? 'active' : '' }}"> 
							<i class="fa fa-chevron-circle-down"></i>
							{{ $lesson_option->name }}
						</li>
					@endforeach 
				@endif
			</ul>

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