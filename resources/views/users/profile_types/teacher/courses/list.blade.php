
<div class="course_lk">
	<div class="row">
		@if(count($courses)) 
		@foreach($courses as $course)
			@include('users.partials.course_card', ['course' => $course])  
		@endforeach 
		@else
		<div class="col-lg-12">
			<div class="no__data"> 
				<h5>Вы не добавили ни одного курса</h5>
			</div>
		</div>
		@endif
		<div class="col-lg-12">
			<hr>
			<a class="btn_add_course" href="{{ route(userRoute('add_course')) }}">Добавить курс</a>
		</div>
	</div>
</div>
 