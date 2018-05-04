
<a href="{{ route('add_course') }}" class="btn btn-info  " style="display: inline-block; width: auto; border-radius: 20px;">Добавить свой курс</a>
<br><br>
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active">
    	<a href="#not_active" aria-controls="not_active" role="tab" data-toggle="tab">НЕ АКТИВНЫЕ</a>
    </li>

    <li role="presentation" class="">
    	<a href="#active" aria-controls="active" role="tab" data-toggle="tab">АКТИВНЫЕ</a>
    </li>

    <li role="presentation">
    	<a href="#finish" aria-controls="finish" role="tab" data-toggle="tab">ЗАВЕРШЕННЫЕ</a>
    </li> 
</ul>

<div class="tab-content">

	<div role="tabpanel" class="tab-pane active" id="not_active" style="padding-top: 20px;">
		@if(isset($courses))
			@foreach($courses as $course)
				<div><a href="/user/profile/course/{{ $course->id }}/edit">{{ $course->name }}</a></div>
			@endforeach
		@endif
	</div>

	<div role="tabpanel" class="tab-pane" id="active" style="padding-top: 20px;">
		Активные курсы
	</div>

	<div role="tabpanel" class="tab-pane" id="finish" style="padding-top: 20px;">
		Завершенные курсы
	</div>
</div>