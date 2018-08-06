<div class="row">
	@if(count($user->connectionTeachers))
		@foreach($user->connectionTeachers as $item)
			<div class="col-md-3">
				<div class="item__block eq_list__item">
					<div class="item__img">
						<img class="img-responsive" src="{{ imageThumb(@$item->image, 'uploads/users', 400, 500, 'list') }}">
					</div>

					<div class="item__info">
						<div class="item__name">{{ $item->name }}</div> 
						<a href="/teacher/{{ $item->id }}" target="_blank" class="btn btn-default">Подробнее</a>
					</div>
					
					<div class="item__footer"> 
						<a class="btn btn-default confirm__item" href="{{ route(userRoute('user_teachers_delete'), ['id' => $item->id]) }}">Удалить</a>
					</div> 
 
				</div>
			</div>
		@endforeach
	@else
		<div class="col-lg-12">
			<div class="no__data"> 
				<h5>Нет подтвержденных записей</h5>
			</div>
		</div>
	@endif
</div>