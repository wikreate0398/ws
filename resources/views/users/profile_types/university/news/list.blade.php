
<div class="course_lk">
	
	<div class="row" style="margin-bottom: 30px;">
		<form action="{{ route(userRoute('user_news')) }}" method="GET">
			<input type="hidden" name="search" value="1">
			<div class="col-md-3">
				<input type="text" autocomplete="off" class="form-control datepicker" value="{{ request()->input('date') }}" name="date" placeholder="Дата">
			</div> 

			<div class="col-md-6">
				<input type="text" class="form-control" value="{{ request()->input('searchByName') }}" name="searchByName" placeholder="Поиск по названию">
			</div>

			<div class="col-md-3">
				<button class="btn btn-default" type="submit">Применить</button>
				@if(request()->has('search'))
					<a class="btn btn-danger" href="{{ route(userRoute('user_news')) }}">Сбросить</a>
				@endif
			</div>
		</form>
	</div>

	<div class="row">
		@if(count($news) > 0) 
		@foreach($news as $item)
		<div class="col-md-4">
			<div style="background-color: #ededed; padding: 15px;">
				<h4>
					<a href="" style="font-weight: bold; color: #333; text-decoration: none; font-size: 16px;">{{ $item->name }}</a>
				</h4>
				<span style="display: block; color: #757575; font-size: 13px;">{{ date('d.m.Y', strtotime($item['created_at'])) }}</span>
				<a href="{{ route(userRoute('edit_news'), ['id' => $item->id]) }}">Редактировать</a> &nbsp;
				<a class="delete__item" href="{{ route(userRoute('delete_news'), ['id' => $item->id]) }}">Удалить</a>
			</div>
		</div>
		@endforeach 
		@else
		<div class="col-lg-12">
			<div class="no__data"> 
				@if(request()->has('search'))
					<h5>Ничего не найденно</h5>
					@else
					<h5>Вы не добавили ни одной новости</h5>
				@endif 
			</div>
		</div>
		@endif
		<div class="col-lg-12">
			<hr>
			<a class="btn_add_course" href="{{ route(userRoute('add_news')) }}">Добавить Новость</a>
		</div>
	</div>
</div>
 