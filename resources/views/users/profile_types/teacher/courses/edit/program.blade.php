@extends('users.profile_types.teacher.courses.edit')

@section('edit_form')   
	<script>
		var courseFrom = '{{ $course->date_from }}';
		var courseTo = '{{ $course->date_to }}';
	</script>
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

						            <div class="form-group">
						                <label class="control-label" style="white-space: nowrap;">Дата Проведения<span class="req">*</span></label>
						                <div class="">
						                    <input  class="form-control datepicker__input required__input course_section_date" 
					                                autocomplete="off" 
					                                name="section[date][]" 
					                                value="{{ !empty($section->date) ? date('d.m.Y', strtotime($section->date)) : '' }}" 
					                                type="text">
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
										            <label class="control-label">Название лекции <span class="req">*</span></label>
										            <div>
										                <input type="text" class="form-control required__input" name="lecture[{{$sectionsNum}}][name][]" value="{{ $lecture->name }}">
										            </div>
										        </div>

										        <div class="form-group">
										            <label class="control-label">Описание лекции <span class="req">*</span></label>
										            <div>
										            	<textarea name="lecture[{{$sectionsNum}}][description][]" class="form-control required__input" placeholder="">{{ $lecture->description }}</textarea> 
										            </div>
										        </div>

										        <div class="form-group">
		                                            <label class="control-label">Видео</label>
		                                            <div class="video__program_control">
		                                             	  
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
												                	<video width="250" data-setup='{"controls": true, "autoplay": false, "preload": "auto"}' class="video-js">
																	  <source src="/uploads/courses/video/{{ $lecture->video_file }}" 
																	          type="{{ mime_content_type(public_path('/uploads/courses/video/' . $lecture->video_file)) }}">
																	</video> 
																</div>
										                	@endif
										                </div>
		                                            </div>
		                                        </div>

										        <div class="form-group">
										            <div>
										            	<label class="control-label">Длительность лекции <span class="req">*</span></label>
										            </div>
										            <div style="justify-content: flex-start; display: flex;">
										            	<input type="text" 
										            	       class="form-control number_field required__input" 
										            	       name="lecture[{{$sectionsNum}}][hourse][]" 
										            	       placeholder="чч" 
										            	       min="0" max="23"
										            	       value="{{ $lecture->duration_hourse }}"
										            	       style="width: 60px; margin-right: 10px;">
										            	<input type="text" 
										            	       class="form-control number_field required__input" 
										            	       name="lecture[{{$sectionsNum}}][minutes][]" 
										            	       placeholder="мм" 
										            	       min="0" 
										            	       max="59" 
										            	       value="{{ $lecture->duration_minutes }}" 
										            	       style="width: 60px;">
										            </div>
										        </div>
												
												<hr>
										        <div class="form-group materias-group">
		                                            <label class="control-label">ПРИКРЕПИТЬ МАТЕРИАЛЫ ЛЕКЦИИ</label> 
		                                            <div> 
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
												<hr>
												<div class="homework__inner"> 
			                                        <div class="form-group"> 
											            <div>
											            	<label> 
											            	<input type="checkbox"  
											            	       name=""   
											            	       {{ $lecture->has_homework ? 'checked' : '' }}
											            	       onchange="showHomeworkBlock(this)">
											            	       Домашнее задание
											            	    <input type="hidden" 
											            	           name="lecture[{{$sectionsNum}}][homework][]" 
											            	           class="has_homework" 
											            	           value="{{ $lecture->has_homework ? '1' : '' }}">
											            	</label> 
											            </div>
											        </div>

											        <div class="lecture__homework" style="{{ !$lecture->has_homework ? 'display: none;' : '' }}">
											        	<div class="form-group">
												            <label class="control-label">Сопроводительное письмо:</label>
												            <div>
												            	<textarea name="lecture[{{$sectionsNum}}][homework_letter][]" 
												            	          class="form-control" 
												            	          placeholder="">{{ @$lecture->homework_letter }}</textarea> 
												            </div>
												        </div> 

												        <div class="form-group">
												            <label class="control-label">
												            	ОБЯЗАТЕЛЬНОЕ К ВЫПОЛНЕНИЮ: 
												            </label>
												            <div>
												            	<label> 
																    <input type="checkbox"   
														                   name="" 
														                   {{ ($lecture->homework_required) ? 'checked' : '' }}
														                   onchange="setChbInputVal(this)">
																    Да
																    <input type="hidden"   
																           name="lecture[0][homework_required][]" 
																           class="chb__val_input"
																           value="{{ ($lecture->homework_required) ? '1' : '' }}">
												            	</label>
												            </div> 
												        </div>

												        <div class="form-group">
				                                            <label class="control-label">Файл:</label> 
				                                            <div>  
				                                                <input type="file" name="lecture_homework[{{$sectionsNum}}][]">
				                                                <small>Формат <code>doc,docx,pdf,rtf,zip</code></small>   
				                                                @if($lecture->homework_file) 
																	<div class="homework-upload-item">  
																		<input type="hidden" name="lecture[{{$sectionsNum}}][old_homework_file][]" value="{{ $lecture->homework_file }}">
																		<img src="/images/file.png" style="max-width: 50px;" alt="">
																		{{ $lecture->homework_file }} 
																	</div>
				                                                @endif
				                                            </div>   
				                                        </div>  
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

                                <div class="form-group">
					                <label class="control-label" style="white-space: nowrap;">Дата Проведения<span class="req">*</span></label>
					                <div class="">
					                    <input  class="form-control datepicker__input required__input course_section_date" 
				                                autocomplete="off" 
				                                name="section[date][]" 
				                                value="" 
				                                type="text">
					                </div>
					            </div>

                                <div class="lecture__sections">
                                   <div class="panel panel-warning lecture__section first_block" data-lecture="0">
                                      <div class="panel-heading">
                                         <h3 class="panel-title">Добавления лекции</h3>
                                      </div>
                                      <div class="panel-body">
                                         <div class="form-group">
                                            <label class="control-label">Название лекции <span class="req">*</span></label>
                                            <div>
                                               <input type="text" class="form-control required__input" name="lecture[0][name][]" value="">
                                            </div>
                                         </div>
                                         <div class="form-group">
                                            <label class="control-label">Описание лекции <span class="req">*</span></label>
                                            <div>
                                               <textarea name="lecture[0][description][]" class="form-control required__input" placeholder=""></textarea> 
                                            </div>
                                         </div>
                                        <div class="form-group">
                                            <label class="control-label">Видео</label>
                                            <div class="video__program_control">
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
                                            <label class="control-label">Длительность лекции <span class="req">*</span></label>
                                          
                                            <div style="justify-content: flex-start; display: flex;"> 
										            	        
                                               <input type="number" class="form-control number_field required__input" name="lecture[0][hourse][]" placeholder="чч" min="0" max="23" value="" autocomplete="false" style="width: 60px; margin-right: 10px;"> 
                                             
                                               <input type="number" class="form-control number_field required__input" name="lecture[0][minutes][]" placeholder="мм" min="0" max="59" autocomplete="false" value="" style="width: 60px; margin-right: 10px;"> 
                                            </div>  
                                        </div>
										
										<hr>

                                        <div class="form-group">
                                            <label class="control-label">ПРИКРЕПИТЬ МАТЕРИАЛЫ ЛЕКЦИИ</label> 
                                            <div>
                                               <input type="file" name="lecture_materials[0][0][]" multiple>
                                               <small>Формат <code>doc,docx,pdf,rtf,zip</code></small>
                                            </div>   
                                        </div>

                                        <hr>
										<div class="homework__inner"> 
	                                        <div class="form-group"> 
									            <div>
									            	<label> 
									            	<input type="checkbox"  
									            	       name=""    
									            	       onchange="showHomeworkBlock(this)">
									            	       Домашнее задание 
									            	       <input type="hidden" name="lecture[0][homework][]" class="has_homework" value=""> 
									            	</label> 
									            </div>
									        </div>

									        <div class="lecture__homework" style="display: none;">
									        	<div class="form-group">
										            <label class="control-label">Сопроводительное письмо:</label>
										            <div>
										            	<textarea name="lecture[0][homework_letter][]" 
										            	          class="form-control" 
										            	          placeholder="">{{ @$lecture->homework_letter }}</textarea> 
										            </div>
										        </div>

										        <div class="form-group">
										            <label class="control-label">
										            	ОБЯЗАТЕЛЬНОЕ К ВЫПОЛНЕНИЮ: 
										            </label>
										            <div>
										            	<label>
										            		<input type="checkbox"   
															       name="" 
															       onchange="setChbInputVal(this)">
															   Да
															   <input type="hidden"   
															          name="lecture[0][homework_required][]" 
															          class="chb__val_input">
										            	</label>
										            </div> 
										        </div>

										        <div class="form-group materias-group">
		                                            <label class="control-label">Файл:</label> 
		                                            <div> 
		                                                <input type="file" name="lecture_homework[0][]">
		                                                <small>Формат <code>doc,docx,pdf,rtf,zip</code></small>   
		                                            </div>   
		                                        </div>  
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
	<style>
		.delete__upload_material{
			color: red;
			cursor: pointer;
		}

		.lecture__homework .checkbox-inline{
			padding-left: 0px !important;
		}
	</style>
@stop