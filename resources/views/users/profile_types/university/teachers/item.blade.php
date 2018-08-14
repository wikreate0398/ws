<div class="col-md-3">
	<div class="item__block eq_list__item">
		<div class="item__img">
			<img class="img-responsive" src="{{ imageThumb(@$item->avatar, 'uploads/users', 400, 500, 'list') }}">
		</div>

		<div class="item__info">
			<div class="item__name">{{ $item->name }}</div> 
			<a href="/teacher/{{ $item->id }}" target="_blank" class="btn btn-default">Подробнее</a>
		</div>
		
		<div class="item__footer"> 
			@if(!empty($item['connectsUniversityRequest']) && !$item['connectsUniversityRequest']['decline'])
				<div class="item__status">  
					<span class="for_review">ВАША ЗАЯВКА НА РАССМОТРЕНИИ</span>
					<span class="for_review_date">с {{ date('d.m.Y', strtotime($item['connectsUniversityRequest']['created_at'])) }}</span> 
				</div> 

				<a class="btn btn-success decline confirm__item" style="margin-top:10px;" href="{{ route(userRoute('user_teachers_delete_request'), ['id' => $item->connectsUniversityRequest->id]) }}">
					ОТМЕНИТЬ ЗАЯВКУ
				</a>
			@else
				@if(@$item['connectsUniversityRequest']['decline'])
					<div class="item__status" style="margin-bottom: 10px;"> 
						<span class="decline">
							К СОЖАЛЕНИЮ, ПОЛЬЗОВАТЕЛЬ НЕ ПОДТВЕРДИЛ, ЧТО РАБОТАЕТ У ВАС
						</span> 
						<span class="repeat_request">Вы можете отправить заявку вновь</span>
					</div> 

					<a class="btn btn-success decline confirm__item" style="margin-top:10px; margin-bottom: 10px;" href="{{ route(userRoute('user_teachers_delete_request'), ['id' => $item->connectsUniversityRequest->id]) }}">
						УДАЛИТЬ ЗАЯВКУ
					</a>
				@endif
				<a href="{{ route(userRoute('user_teachers_request'), ['id' => $item['id']]) }}" class="btn btn-default confirm__item">ОТПРАВИТЬ ЗАПРОС</a>  
			@endif 
		</div> 
	</div>
</div>