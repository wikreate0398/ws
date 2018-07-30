<div class="row" style="border-bottom: 1px solid #ededed; padding-bottom: 30px; margin-bottom: 20px;">
	<div class="col-md-6 col-md-offset-3"> 
		<input type="text" 
		       placeholder="Введите название учебного заведения" 
		       class="form-control" 
		       data-url-autocomplete="{{ route(userRoute('user_universities_autocomplete')) }}" 
		       id="search_universities">
	</div>
</div> 
<div class="row teacher__universities">  
	<div class="loaded__teacher__universities"></div>
	@if(count($data)) 
		<div class="exists__connection">
			@foreach($data as $item)
				@include('users.profile_types.teacher.universities.item', ['item' => $item]) 
			@endforeach
		</div> 
	@endif
</div> 
