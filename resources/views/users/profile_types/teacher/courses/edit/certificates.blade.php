@extends('users.profile_types.teacher.courses.edit')

@section('edit_form')   
	<form class="ajax__submit has--preload listener__change_form course__form_hc" method="POST" action="{{ route(userRoute('update_course_сertificates'), ['id' => $course->id]) }}">
	    {{ csrf_field() }}
      <input type="hidden" name="redirectUri" id="redirectUri">
	    <div class="col-lg-8 col-lg-offset-2 course_form">
			 
            <div id="certificates__images" class="row uploaderContainter" style="margin-bottom: 40px;"> 
               	@foreach($course->certificates as $certificate)
                  	<div class='col-md-4 load-thumbnail'> 
                         
                        <div class="uploadedImg" 
                             style="background-image: url(/public/uploads/courses/certificates/{{ $certificate->image }})"></div>
                        <div class='actions__upload_img'>
                           <span onclick='deleteCourseUploadImg(this, {{ $certificate->id }})' class="delete__upload_img"></span> 
                            </div>
                  	</div>
               	@endforeach
                   
               <div class="col-md-4 {{ !count($course->certificates) ? 'col-md-offset-4' : ''}}">
                  <div class="certificateLoadArea">
                     <input type="file" 
                         name="diploms[]" 
                         multiple 
                         id="certificateInpuT" 
                         onchange="multipleImages(this, '#certificates__images')">
                       <span class="file__input_name"> Добавить или перетащить <br> сюда изображение</span>
                  </div>
               </div> 
            </div>    

			<div class="row">
	          <div class="col-md-12" style="text-align: center;">
	             <div id="error-respond"></div>
	             <button type="submit" class="btn btn_save" style="display: inline-block; width: auto; float: none;"> 
                  @if($course->сertificates_filled)
                    Сохранить
                  @else
                    Добавить курс
                  @endif 
	             </button>
	          </div>
	       </div>
		</div>
	</form> 
@stop