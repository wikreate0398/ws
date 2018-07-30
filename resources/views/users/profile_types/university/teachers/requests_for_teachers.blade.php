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
	@if(count($requestForTeachers)) 
		<div class="exists__connection row">
			@foreach($requestForTeachers as $item)
				@include('users.profile_types.university.teachers.item', ['item' => $item]) 
			@endforeach
		</div> 
	@endif
</div> 
