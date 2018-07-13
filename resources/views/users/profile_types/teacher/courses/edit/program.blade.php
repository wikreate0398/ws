@extends('users.profile_types.teacher.courses.edit')

@section('edit_form')   
	<form class="ajax__submit listener__change_form course__form" method="POST" action="{{ route(userRoute('update_course_program'), ['id' => $course->id]) }}">
	    {{ csrf_field() }}
	    <input type="hidden" name="redirectUri" id="redirectUri">
	    <div class="col-lg-8 col-lg-offset-2 course_form">

	    	<div class="course__sections">  
	    		@if(count($course->sections) > 0) 
					<?php $sectionsNum = 0; $lecturesNum = 0; ?> 
					@foreach($course->sections as $section)
					<div class="panel panel-default course__section {{ ($sectionsNum==0) ? 'first_block' : '' }}">
						
						@if($sectionsNum>0)
							<div class="close__item" onclick="deleteSectionBlock(this, '{{ $section->id }}');">X</div>
						@endif

				        <div class="panel-heading">
				            <h3 class="panel-title">Раздел</h3>
				        </div>
				        <div class="panel-body"> 
				            <div class="row">
				                <div class="col-md-12">
		                 
						            <div class="form-group">
						                <label class="control-label" style="white-space: nowrap;">Название Раздела<span class="req">*</span></label>
						                <div class="">
						                    <input type="text" class="form-control required__input" name="section[name][]" value="{{ $section->name }}" placeholder="">
						                </div>
						            </div> 

						            <div class="lecture__sections">  
						            	<?php $l = 0; ?>
						            	@foreach($section->lectures as $lecture)
							            <div class="panel panel-warning lecture__section {{ ($lecturesNum==0) ? 'first_block' : '' }}">

							            	@if($l>0)
												<div class="close__item" onclick="deleteLectureBlock(this, '{{ $lecture->id }}');">X</div>
											@endif

							            	<div class="panel-heading">
									            <h3 class="panel-title">Добавления лекции</h3>
									        </div>
							            	<div class="panel-body"> 
							            		<div class="form-group">
										            <label class="col-md-12 control-label">Название лекции <span class="req">*</span></label>
										            <div class="col-md-12">
										                <input type="text" class="form-control required__input" name="lecture[{{$sectionsNum}}][name][]" value="{{ $lecture->name }}">
										            </div>
										        </div>

										        <div class="form-group">
										            <label class="col-md-12 control-label">Описание лекции <span class="req">*</span></label>
										            <div class="col-md-12">
										            	<textarea name="lecture[{{$sectionsNum}}][description][]" class="form-control required__input" placeholder=""="">{{ $lecture->description }}</textarea> 
										            </div>
										        </div>

										        <div class="form-group">
										            <label class="col-md-12 control-label">Длительность лекции <span class="req">*</span></label>
										            <div class="col-md-2">
										            	<input type="text" 
										            	       class="form-control number_field required__input" 
										            	       name="lecture[{{$sectionsNum}}][hourse][]" 
										            	       placeholder="чч" 
										            	       value="{{ $lecture->duration_hourse }}">
										            </div>
										            <div class="col-md-2">
										            	<input type="text" 
										            	       class="form-control number_field required__input" 
										            	       name="lecture[{{$sectionsNum}}][minutes][]" 
										            	       placeholder="мм" value="{{ $lecture->duration_minutes }}">
										            </div>
										        </div>
							            	</div>
							            </div>
							            <?php $lecturesNum++; $l++; ?>
							            @endforeach
						            </div>
				         
				                </div> 
				 
				                <div class="col-md-12">
				                    <button type="button" onclick="addLecture(this);" class="btn btn-sm btn-dafault add__more">
				                    	Добавить лекцию
				                    </button>
				                </div> 			            
				            </div> 
				        </div>
					</div>
					<?php $sectionsNum++ ?>
					@endforeach 
				@else
					<div class="panel panel-default course__section first_block">
                       <div class="panel-heading">
                          <h3 class="panel-title">Раздел</h3>
                       </div>
                       <div class="panel-body">
                          <div class="row">
                             <div class="col-md-12">
                                <div class="form-group">
                                   <label class="control-label" style="white-space: nowrap;">Название Раздела<span class="req">*</span></label>
                                   <div class="">
                                      <input type="text" class="form-control required__input" name="section[name][]" value="" placeholder="">
                                   </div>
                                </div>
                                <div class="lecture__sections">
                                   <div class="panel panel-warning lecture__section first_block">
                                      <div class="panel-heading">
                                         <h3 class="panel-title">Добавления лекции</h3>
                                      </div>
                                      <div class="panel-body">
                                         <div class="form-group">
                                            <label class="col-md-12 control-label">Название лекции <span class="req">*</span></label>
                                            <div class="col-md-12">
                                               <input type="text" class="form-control required__input" name="lecture[0][name][]" value="">
                                            </div>
                                         </div>
                                         <div class="form-group">
                                            <label class="col-md-12 control-label">Описание лекции <span class="req">*</span></label>
                                            <div class="col-md-12">
                                               <textarea name="lecture[0][description][]" class="form-control required__input" placeholder=""=""></textarea> 
                                            </div>
                                         </div>
                                         <div class="form-group">
                                            <label class="col-md-12 control-label">Длительность лекции <span class="req">*</span></label>
                                            <div class="col-md-2">
                                               <input type="text" class="form-control number_field required__input" name="lecture[0][hourse][]" placeholder="чч" value="" autocomplete="false">
                                            </div>
                                            <div class="col-md-2">
                                               <input type="text" class="form-control number_field required__input" name="lecture[0][minutes][]" placeholder="мм" autocomplete="false" value="">
                                            </div>
                                         </div>
                                      </div>
                                   </div>
                                </div>
                             </div>
                             <div class="col-md-12">
                                <button type="button" onclick="addLecture(this);" class="btn btn-sm btn-dafault add__more">
                                Добавить лекцию
                                </button>
                             </div>
                          </div>
                       </div>
                    </div>
	    		@endif
			</div>
             <button class="btn btn-default btn-sm" type="button" onclick="addCourseSection()">Добавить раздел</button>
		
			<div class="row">
	          <div class="col-md-12">
	             <div id="error-respond"></div>
	             <button type="submit" class="btn btn_save" style="display: inline-block; width: auto;">
	             	@if($course->program_filled)
                    	Сохранить
                  	@else
                    	Далее
                  	@endif  
	             </button>
	          </div>
	       </div>
		</div>
	</form> 
@stop