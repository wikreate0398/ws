<div class="row">
	<div class="col-md-12">
		<div style="border-bottom: 1px solid #ededed; padding-bottom: 15px; margin-bottom: 15px;"> 
			<a href="{{ route(userRoute('user_universities_connect')) }}" class="btn btn-default">Создать запрос</a>
		</div>
	</div>
</div> 
 
<div class="teacher__universities">  

	@if(count($requests))
	<div class="row">
		<div class="col-md-12">
			<h3>ЗАЯВКИ</h3>
			<br>
		</div>

		@foreach($requests as $item)
			<div class="col-md-3">
				<div class="item__block eq_list__item">
					<div class="item__img">
						<img class="img-responsive" src="{{ imageThumb(@$item->university->avatar, 'uploads/users', 400, 300, 'universities') }}">
					</div>

					<div class="item__info">
						<div class="item__name">{{ $item->full_name }}</div> 
						<span>
							{{ count($item->university->courses) }} {{ format_by_count(count($item->university->courses), 'КУРС','КУРСА','КУРСОВ') }}
						</span>
						<span>
							{{ count($item->university->connectionTeachers) }}   
							{{ format_by_count(count($item->university->connectionTeachers), 'ПРЕПОДАВАТЕЛЬ','ПРЕПОДАВАТЕЛЯ','ПРЕПОДАВАТЕЛЕЙ') }}
						</span>
					</div>
					
					<div class="item__footer"> 
						<a class="btn btn-default confirm__item" href="{{ route(userRoute('user_universities_confirm'), ['id' => $item['id']]) }}">Подтвердить</a> &nbsp;&nbsp;
						<a class="btn btn-default decline confirm__item" href="{{ route(userRoute('user_universities_decline'), ['id' => $item['id']]) }}">Отклонить</a>
					</div>  
				</div>
			</div>
		@endforeach
	</div>
	@endif
	
	 
	<div class="row"> 
		@if(count($user->connectionUniversities))
		<div class="col-md-12">
			<h3>ПОДТВЕРЖДЕННЫЕ ЗАПИСИ</h3>
			<br>
		</div>  
			@foreach($user->connectionUniversities as $item)
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
							<a class="btn btn-default confirm__item" href="{{ route(userRoute('user_universities_delete_connect'), ['id' => $item->id]) }}">Удалить</a>
						</div> 
	 
					</div>
				</div>
			@endforeach 
		@else
			<div class="col-lg-12">
				<div class="no__data"> 
					<h5>Вы не привязаны ни к одному учебному заведению</h5>
				</div>
			</div>
		@endif
	</div> 
	 
</div>
