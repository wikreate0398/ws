<div class="row" style="border-bottom: 1px solid #ededed; padding-bottom: 30px; margin-bottom: 20px;">
	<div class="col-md-6 col-md-offset-3"> 
		<input type="text" 
		       placeholder="Введите название учебного заведения" 
		       class="form-control" 
		       data-url-autocomplete="{{ route(userRoute('user_teachers_autocomplete')) }}" 
		       id="search_teachers">
	</div>
</div> 
<div class="row teacher__universities">  
	<div class="loaded__university__teacher row"></div>
	<div class="invite__teacher" style="display: none; text-align: center;">
		<p>Не нашли преподавателя?</p>
		<button class="btn btn-info btn2" href="#invite" data-toggle="modal">Пригласить</button>
		<div id="invite" class="modal fade connect_model" tabindex="-1" data-backdrop="static" data-keyboard="false">
           <div class="modal-dialog">
              <div class="modal-content">
                 <div class="modal-header"> 
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <h4 class="modal-title">ЗАПРОС ПРЕПОДОВАТЕЛЮ</h4>
                 </div>
                 <div class="modal-body">
                    <form method="POST" action="{{ route(userRoute('user_teacher_invite')) }}" class="ajax__submit has--preload">
                    	{{ csrf_field() }}
                    	<div class="row"> 
							<div class="col-md-12">
								<div class="form-group"> 
									<input type="text" class="form-control" name="email" required placeholder="Введите E-mail"> 
								</div>
							</div>
						</div>  
						<div class="row">
							<div class="col-md-12">
								<div id="error-respond"></div>
								<button type="submit" style="float: none;" class="btn btn_save">Отправить</button> 
							</div>
						</div>
                    </form>
                 </div> 
              </div>
           </div>
        </div>
	</div>
	@if(count($requestForTeachers)) 
		<div class="exists__connection row">
			@foreach($requestForTeachers as $item)
				@include('users.profile_types.university.teachers.item', ['item' => $item]) 
			@endforeach
		</div> 
	@endif
</div> 
