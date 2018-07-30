<div class="col-md-3">
	<div class="item__block eq_list__item">
		<div class="item__img">
			<img class="img-responsive" src="{{ imageThumb(@$item->user->avatar, 'uploads/users', 400, 300, 'universities') }}">
		</div>

		<div class="item__info">
			<div class="item__name">{{ $item->full_name }}</div>  
			<span>
				{{ count($item->user->courses) }} {{ format_by_count(count($item->user->courses), 'КУРС','КУРСА','КУРСОВ') }}
			</span>

			<span>
				{{ count($item['user']['connectionTeachers']) }}   
				{{ format_by_count(count($item['user']['connectionTeachers']), 'ПРЕПОДАВАТЕЛЬ','ПРЕПОДАВАТЕЛЯ','ПРЕПОДАВАТЕЛЕЙ') }}
			</span>
		</div>
		
		<div class="item__footer"> 
		@if(!empty($item['connects']) && !$item['connects']['decline'])
			<div class="item__status">  
				<span class="for_review">ВАША ЗАЯВКА НА РАССМОТРЕНИИ</span>
				<span class="for_review_date">с {{ date('d.m.Y', strtotime($item['connects']['created_at'])) }}</span> 
			</div>
			<a class="btn btn-success decline confirm__item" style="margin-top:10px;" href="{{ route(userRoute('user_universities_delete_request'), ['id' => $item['connects']['id']]) }}">
				ОТМЕНИТЬ ЗАЯВКУ
			</a>
		@else
			@if(@$item['connects']['decline'])
				<div class="item__status" style="margin-bottom: 10px;"> 
					<span class="decline">
						К СОЖАЛЕНИЮ, ВУЗ НЕ ПОДТВЕРДИЛ ЗАПРОШЕННУЮ ИНФОРМАЦИЮ
					</span> 
					<span class="repeat_request">Вы можете отправить заявку вновь</span>
				</div>

				<a class="btn btn-success decline confirm__item" style="margin-top:10px;margin-bottom:10px;" href="{{ route(userRoute('user_universities_delete_request'), ['id' => $item['connects']['id']]) }}">
					УДАЛИТЬ ЗАЯВКУ
				</a>
			@endif

			<button class="btn btn-success" href="#connect_model_{{$item->id_user}}" data-toggle="modal">ПРЕПОДАЮ / УЧИЛСЯ</button>

			<div id="connect_model_{{$item->id_user}}" class="modal fade connect_model" tabindex="-1" data-backdrop="static" data-keyboard="false">
	           <div class="modal-dialog">
	              <div class="modal-content">
	                 <div class="modal-header"> 
	                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
	                        <i class="fa fa-times" aria-hidden="true"></i>
	                    </button>
	                    <h4 class="modal-title">ЗАЯВКА НА ПРИВЯЗКУ К ВУЗУ</h4>
	                 </div>
	                 <div class="modal-body">
	                    <form method="POST" action="{{ route(userRoute('user_universities_request'), ['id' => $item->id_user]) }}" class="ajax__submit has--preload">
	                    	{{ csrf_field() }}
	                    	<div class="row">
								<label class="col-md-4 control-label">СОПРОВОДИТЕЛЬНОЕ ПИСЬМО <span class="req">*</span></label>
								<div class="col-md-8">
									<div class="form-group">
										<textarea class="form-control" maxlength="200" name="letter" style="min-height: 125px;"></textarea>
										<div class="maxlength__label"><span>0</span> символов (200 максимум)</div>
									</div>
								</div>
							</div>

							<div class="row">
								<label class="col-md-4 control-label">ПРОШУ ПОДТВЕРДИТЬ, ЧТО Я <span class="req">*</span></label>
								<div class="col-md-8">
									<div class="form-group">
										<label class="radio-inline">
										  <input type="radio" name="teaching" checked id="inlineRadio1" value="1"> ПРЕПОДАЮ
										</label>
										<label class="radio-inline">
										  <input type="radio" name="teaching" id="inlineRadio2" value="0"> ОБУЧАЛСЯ
										</label>
									</div>
								</div>
							</div>

							<div class="row">
								<label class="col-md-4 control-label">ПРИКРЕПИТЬ ФАЙЛ</label>
								<div class="col-md-8">
									<div class="form-group">
										<input type="file" name="files[]" multiple>
										<p style="font-size: 12px; margin-top: 10px;">Прикрепите копию свидетельства об образовании, диплома, или паспорта, которые доказывают данную информацию</p>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div id="error-respond"></div>
									<button type="submit" style="float: none;" class="btn btn_save">Сохранить</button> 
								</div>
							</div>
	                    </form>
	                 </div> 
	              </div>
	           </div>
	        </div>
		@endif
		</div> 
	</div>
</div>