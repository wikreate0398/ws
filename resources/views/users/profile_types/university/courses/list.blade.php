<div class="course_lk"> 
	<div class="row" style="margin-bottom: 30px;">
		<form action="{{ route('university_user_profile') }}" method="GET">
			<input type="hidden" name="search" value="1">
			<input type="hidden" name="status" value="{{ request()->status }}">
			 
			<div class="col-md-3">
				<select name="teacher" 
				        id="teacher" 
				        class="form-control" 
				        onchange="selectFilterTeacher(this, {{ intval(request()->input('category')) }}, '{{ route(userRoute('filter_categories')) }}')">
					<option value="0">Преподаватели</option> 
					@foreach(Auth::user()->connectionTeachers as $teacher)
						<option {{ (request()->input('teacher') == $teacher['id']) ? 'selected' : '' }} value="{{ $teacher->id }}">{{ $teacher->name }}</option> 
					@endforeach
				</select>
				@if(request()->input('category'))
					<script>
						$(document).ready(function(){
							selectFilterTeacher($('select#teacher'), {{ intval(request()->input('category')) }}, '{{ route(userRoute('filter_categories')) }}');
						});
					</script>
				@endif
			</div> 

			<div class="col-md-3">
				<select name="category" id="category" class="form-control">
					<option value="0">Категория</option>
					@foreach($categories as $category)
						<option {{ (request()->input('category') == $category['id']) ? 'selected' : '' }} value="{{ $category['id']}}">{{ $category['name'] }}</option> 
					@endforeach
				</select>
			</div>

			<div class="col-md-3">
				<div id="search_form" 
				     class="filter__autocomplete_input" 
				     data-url-autocomplete="{{ route(userRoute('filter_autocomplete')) }}">
					<input type="text" autocomplete="off" id="search__input" class="form-control" value="{{ request()->input('searchByName') }}" name="searchByName" placeholder="Поиск по названию">
					<div class="loaded__search_result"></div>
				</div> 
			</div>
 

			<div class="col-md-3" style="text-align: center;">
				<button class="btn btn-default" type="submit">Применить</button>
				@if(request()->has('search'))
					<a class="btn btn-danger" href="{{ route(userRoute('user_profile')) }}">Сбросить</a>
				@endif
			</div>
		</form>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="course__status_links">
				<a href="{{ route(userRoute('user_profile')) }}" class="{{ (request()->status == 'all' or request()->status == null) ? 'active' : '' }}">
					ВСЕ
				</a> 
				&nbsp; &nbsp;
				<a href="{{ route('university_user_profile') }}?search=1&status=1" class="{{ (request()->status == '1') ? 'active' : '' }}">
					АКТИВНЫЕ
				</a>
					&nbsp; &nbsp;
				<a href="{{ route('university_user_profile') }}?search=1&status=0" class="{{ (request()->status == '0') ? 'active' : '' }}">
					ЗАВЕРШЕННЫЕ
				</a>
			</div>
		</div>
	</div>
	<div class="row">
		@if(count($courses) > 0) 
			@foreach($courses as $course)
			 	@include('users.partials.course_card', ['course' => $course])  
			@endforeach 
		@else
		<div class="col-lg-12">
			<div class="no__data"> 
				@php
					$msg = 'Вы не добавили ни одного курса';
					if(request()->search){
						$msg = 'Ничего не найдено';
					}
				@endphp
				<h5>Вы не добавили ни одного курса</h5>
			</div>
		</div>
		@endif

		@if(count(Auth::user()->connectionTeachers))
			<div class="col-lg-12">
				<hr>
				<a class="btn_add_course" href="{{ route(userRoute('add_course')) }}">Добавить курс</a>
			</div>
		@else
			<div class="col-lg-12">
				<div class="no__data warning"> 
					<h5>Что бы добавить курс вам необходимо привязать преподавателей</h5>
				</div>
			</div>
		@endif 
	</div>
</div>

<style>
	.course__status_links{
		border-top: 1px solid #ededed; 
		border-bottom: 1px solid #ededed; 
		padding: 10px 0; 
		margin-bottom: 20px;
	}

	.course__status_links a{
		color: #333;
		font-weight: bold;
	}

	.course__status_links .active{ 
		color: #999;
	}
</style>