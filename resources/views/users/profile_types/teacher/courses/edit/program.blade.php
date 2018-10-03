@extends('users.profile_types.teacher.courses.edit')

@section('edit_form')   
	<form class="ajax__submit has--preload listener__change_form course__form_hc" method="POST" action="{{ route(userRoute('update_course_program'), ['id' => $course->id]) }}">
	    {{ csrf_field() }}
	    <input type="hidden" name="redirectUri" id="redirectUri">
	    <div class="col-lg-8 col-lg-offset-2 course_form">

	    	<div class="course__sections">  
	    		@if(count($course->sections) > 0) 
					<?php $sectionsNum = 0; $lecturesNum = 0; ?> 
					@foreach($course->sections as $section)
					<div class="panel panel-default course__section {{ ($sectionsNum==0) ? 'first_block' : '' }}" data-section="{{ $sectionsNum }}">
						
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

							            <div class="panel panel-warning lecture__section {{ ($lecturesNum==0) ? 'first_block' : '' }}" data-lecture="{{ $l }}">
											<input type="hidden" name="lecture[{{$sectionsNum}}][last_id][]" value="{{ $lecture->id }}">
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
										            	<textarea name="lecture[{{$sectionsNum}}][description][]" class="form-control required__input" placeholder="">{{ $lecture->description }}</textarea> 
										            </div>
										        </div>

										        <div class="form-group">
		                                            <label class="col-md-12 control-label">Видео</label>
		                                            <div class="col-md-12 video__program_control">
		                                             	  
										                <div style="margin-bottom: 10px;">
		                                            		<button class="btn btn-xs  
		                                            		        {{ ($lecture->video_type == 'link') ? 'active__video' : '' }}" 
		                                            		        type="button" 
		                                            		        onclick="showProgramVideoArea(this, 'link');">
			                                            		ссылка на Youtube
			                                            	</button>

			                                            	<button class="btn btn-xs 
			                                            	        {{ ($lecture->video_type == 'file') ? 'active__video' : '' }}" 
			                                            	        type="button" 
			                                            	        onclick="showProgramVideoArea(this, 'file');">
			                                            		прикрепите файл
			                                            	</button>
			                                            	<input type="hidden" id="video_type" name="lecture[0][video_type][]" value="{{$lecture['video_type']}}">  
		                                            	</div> 

		                                            	@php
															$linkArea = ($lecture->video_type == 'file') ? 'display: none;' : '';
															$fileArea = ($lecture->video_type == 'link') ? 'display: none;' : '';
															if(!$lecture->video_type)
															{
																$linkArea=$fileArea='display: none;';
															}
		                                            	@endphp
										                <div class="video_link__area video__area" style="{{ $linkArea }}">
										                	<input type="text" placeholder="Ссылка" class="form-control" name="lecture[{{$sectionsNum}}][video_link][]" value="{{ $lecture->video_link }}">  
										                </div>

										                <div class="video_file__area video__area" style="{{ $fileArea }} margin-bottom:10px;">
										                	<input type="file" name="lecture_video[{{$sectionsNum}}][]" value="">
										                	<small>Формат <code>mp4,ogv,ogg,m4v</code></small>
										                	@if($lecture->video_file)
											                	<div class="video__upload"> 
											                		<input type="hidden" name="lecture[{{$sectionsNum}}][old_video_file][]" value="{{ $lecture->video_file }}">
												                	<hr>  
												                	<video width="100" height="100" controls>
																	  <source src="/uploads/courses/video/{{ $lecture->video_file }}" 
																	          type="{{ mime_content_type(public_path('/uploads/courses/video/' . $lecture->video_file)) }}">
																	</video> 
																</div>
										                	@endif
										                </div>
		                                            </div>
		                                        </div>

										        <div class="form-group">
										            <label class="col-md-12 control-label">Длительность лекции <span class="req">*</span></label>
										            <div class="col-md-2">
										            	<input type="text" 
										            	       class="form-control number_field required__input" 
										            	       name="lecture[{{$sectionsNum}}][hourse][]" 
										            	       placeholder="чч" 
										            	       min="0" max="23"
										            	       value="{{ $lecture->duration_hourse }}">
										            </div>
										            <div class="col-md-2">
										            	<input type="text" 
										            	       class="form-control number_field required__input" 
										            	       name="lecture[{{$sectionsNum}}][minutes][]" 
										            	       placeholder="мм" min="0" max="59" value="{{ $lecture->duration_minutes }}">
										            </div>
										        </div>

										        <div class="form-group materias-group">
		                                            <label class="col-md-12 control-label">ПРИКРЕПИТЬ МАТЕРИАЛЫ ЛЕКЦИИ</label> 
		                                            <div class="col-md-12"> 
		                                                <input type="file" name="lecture_materials[{{$sectionsNum}}][{{$l}}][]" multiple>
		                                                <small>Формат <code>doc,docx,pdf,rtf,zip</code></small>  
		                                               	@if($lecture->materials->count()) 
			                                               	<hr>
		                                               		<div class="material__upload_files">  
																@foreach($lecture->materials as $material)
																	<div class="material-upload-item"> 
																		<img src="/images/file.png" style="max-width: 50px;" alt="">
																		{{ $material['material'] }}
																		<span class="delete__upload_material" onclick="deleteUploadMaterial(this, {{ $material['id'] }});">X</span>
																	</div>
																@endforeach 
															</div>
		                                               	@endif
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
					<style>
						.delete__upload_material{
							color: red;
							cursor: pointer;
						}
					</style>
				@else
					<div class="panel panel-default course__section first_block" data-section="0">
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
                                   <div class="panel panel-warning lecture__section first_block" data-lecture="0">
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
                                               <textarea name="lecture[0][description][]" class="form-control required__input" placeholder=""></textarea> 
                                            </div>
                                         </div>
                                        <div class="form-group">
                                            <label class="col-md-12 control-label">Видео</label>
                                            <div class="col-md-12 video__program_control">
                                            	<div style="margin-bottom: 10px;">
                                            		<button class="btn btn-xs" type="button" onclick="showProgramVideoArea(this, 'link');">
	                                            		ссылка на Youtube
	                                            	</button>

	                                            	<button class="btn btn-xs" type="button" onclick="showProgramVideoArea(this, 'file');">
	                                            		прикрепите файл
	                                            	</button>
	                                            	<input type="hidden" id="video_type" name="lecture[0][video_type][]" value="">  
                                            	</div> 
								                <div class="video_link__area video__area" style="display: none;">
								                	<input type="text" placeholder="Ссылка" class="form-control" name="lecture[0][video_link][]" value="">  
								                </div> 
								                <div class="video_file__area video__area" style="display: none; margin-bottom:10px;">
								                	<input type="file" name="lecture_video[0][]" value="">
								                	<small>Формат <code>mp4,ogv,ogg,m4v</code></small>
								                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-md-12 control-label">Длительность лекции <span class="req">*</span></label>
                                          
                                            <div class="col-md-2">
                                               <input type="number" class="form-control number_field required__input" name="lecture[0][hourse][]" placeholder="чч" min="0" max="23" value="" autocomplete="false">
                                            </div>
                                            <div class="col-md-2">
                                               <input type="number" class="form-control number_field required__input" name="lecture[0][minutes][]" placeholder="мм" min="0" max="59" autocomplete="false" value="">
                                            </div>  
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12 control-label">ПРИКРЕПИТЬ МАТЕРИАЛЫ ЛЕКЦИИ</label> 
                                            <div class="col-md-2">
                                               <input type="file" name="lecture_materials[0][0][]" multiple>
                                               <small>Формат <code>doc,docx,pdf,rtf,zip</code></small>
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