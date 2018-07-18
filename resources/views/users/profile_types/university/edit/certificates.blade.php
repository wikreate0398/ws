@extends('users.profile_types.university.edit')

@section('edit_form')  
	<form class="ajax__submit has--preload listener__change_form univ__form_hc" method="POST" action="{{ route(userRoute('update_certificates')) }}">
	    {{ csrf_field() }} 
	    <input type="hidden" name="redirectUri" id="redirectUri">
		<div class="col-lg-8 col-lg-offset-2 user_form">  
			<div id="certificate">
				<div id="certificates__images" class="row uploaderContainter" style="margin-bottom: 40px;"> 
	        		@foreach($user->certificates as $certificate)
						<div class='col-md-4 load-thumbnail'> 
			            	 
			            	<div class="uploadedImg" 
			            	     style="background-image: url(/public/uploads/users/certificates/{{ $certificate->image }})"></div>
			            	<div class='actions__upload_img'>
			            		<span onclick='deleteUploadImg(this, {{ $certificate->id }})' class="delete__upload_img"></span> 
	                        </div>
	    		     	</div>
					@endforeach 
					<div class="col-md-4 {{ !count($user->certificates) ? 'col-md-offset-4' : ''}}">
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
			</div> 
			<div class="col-lg-12" style="text-align: center;">
				<div id="error-respond"></div>
				<button type="submit" class="btn btn_save" style="float: none;">
					@if($user->univ_certificates_filled)
	                    Сохранить
	                @else
	                    Сохранить и активировать
	                @endif 
				</button>
			</div> 
		</div>
	</form>
@stop