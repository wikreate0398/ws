<div class="row">
	@if(count($university))
		@foreach($university as $item)
			<div class="col-md-3">
				<div class="item__block eq_list__item">
					<div class="item__img">
						<img class="img-responsive" src="{{ imageThumb(@$item->avatar, 'uploads/users', 400, 300, 'universities') }}">
					</div>

					<div class="item__info">
						<div class="item__name">{{ $item->full_name }}</div> 
						<span>
							{{ count($item->university->courses) }} {{ format_by_count(count($item->university->courses), 'КУРС','КУРСА','КУРСОВ') }}
						</span>
						<span>
							{{ count($item->connectionTeachers) }}   
							{{ format_by_count(count($item->connectionTeachers), 'ПРЕПОДАВАТЕЛЬ','ПРЕПОДАВАТЕЛЯ','ПРЕПОДАВАТЕЛЕЙ') }}
						</span>
					</div>
					
					<div class="item__footer"> 
						<a class="btn btn-default confirm__item" href="{{ route(userRoute('user_favorites_delete'), ['id' => $item->id]) }}?type=university">Удалить</a>
					</div> 

				</div>
			</div>
		@endforeach 
	@else
		<div class="col-lg-12">
			<div class="no__data"> 
				<h5>Нет закладок</h5>
			</div>
		</div>
	@endif
</div>