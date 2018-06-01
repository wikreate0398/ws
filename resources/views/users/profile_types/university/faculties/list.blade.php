
<div class="course_lk">
	
	<div class="row" style="margin-bottom: 30px;">
		<form action="{{ route(userRoute('user_faculties')) }}" method="GET">
			<input type="hidden" name="search" value="1">
			<div class="col-md-3">
				<select name="type" class="form-control">
					<option value="0">Форма обучения</option>
					<option {{ (request()->input('type') == 'full_time_learning') ? 'selected' : '' }} value="full_time_learning">Очная</option>
					<option {{ (request()->input('type') == 'non_public_learning') ? 'selected' : '' }} value="non_public_learning">Заочная</option>
					<option {{ (request()->input('type') == 'distance_learning') ? 'selected' : '' }} value="distance_learning">Дистанционная</option>
				</select>
			</div>

			<div class="col-md-3">
				<select name="duration_learning" class="form-control">
					<option value="0">Лет обучения</option>
					@foreach($durationLearning as $duration)
						<option {{ (request()->input('duration_learning') == $duration['duration_learning']) ? 'selected' : '' }} value="{{ $duration['duration_learning']}}">{{ $duration['duration_learning'] }}</option> 
					@endforeach
				</select>
			</div>

			<div class="col-md-3">
				<input type="text" class="form-control" value="{{ request()->input('searchByName') }}" name="searchByName" placeholder="Поиск по названию">
			</div>

			<div class="col-md-3">
				<button class="btn btn-default" type="submit">Применить</button>
				@if(request()->has('search'))
					<a class="btn btn-danger" href="{{ route(userRoute('user_faculties')) }}">Сбросить</a>
				@endif
			</div>
		</form>
	</div>

	<div class="row">
		@if(count($faculties) > 0) 
		@foreach($faculties as $faculty)
		<div class="col-md-4">
			<div style="background-color: #ededed; padding: 15px;">  
				<h4>
					<a href="" style="font-weight: bold; color: #333; text-decoration: none; font-size: 16px;">{{ $faculty->name }}</a>
				</h4>
				<a href="{{ route(userRoute('edit_faculty'), ['id' => $faculty->id]) }}">Редактировать</a> &nbsp;
				<a class="delete__item" href="{{ route(userRoute('delete_faculty'), ['id' => $faculty->id]) }}">Удалить</a>
			</div>
		</div>
		@endforeach 
		@else
		<div class="col-lg-12">
			<div class="no__data"> 
				@if(request()->has('search'))
					<h5>Ничего не найденно</h5>
					@else
					<h5>Вы не добавили ни одного факультета</h5>
				@endif 
			</div>
		</div>
		@endif
		<div class="col-lg-12">
			<hr>
			<a class="btn_add_course" href="{{ route(userRoute('add_faculty')) }}">Добавить факультет</a>
		</div>
	</div>
</div>
 