
<div class="course_lk">
	<div class="row">
		@if(count($faculties) > 0) 
		@foreach($faculties as $faculty)
		<div class="col-md-4" style="background-color: #ededed; padding: 15px; margin: 0 15px;">
			<h4>
				<a href="" style="font-weight: bold; color: #333; text-decoration: none; font-size: 16px;">{{ $faculty->name }}</a>
			</h4>
			<a href="{{ route(userRoute('edit_faculty'), ['id' => $faculty->id]) }}">Редактировать</a> &nbsp;
			<a class="delete__item" href="{{ route(userRoute('delete_faculty'), ['id' => $faculty->id]) }}">Удалить</a>
		</div>
		@endforeach 
		@else
		<div class="col-lg-12">
			<div class="no__data"> 
				<h5>Вы не добавили ни одного факультета</h5>
			</div>
		</div>
		@endif
		<div class="col-lg-12">
			<hr>
			<a class="btn_add_course" href="{{ route(userRoute('add_faculty')) }}">Добавить факультет</a>
		</div>
	</div>
</div>
 