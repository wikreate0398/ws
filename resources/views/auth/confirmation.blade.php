@extends('layouts.app')

@section('content') 
<div class="container">
	<div class="row">
		<div class="col-md-12">
			@if(!empty($user->id))

				@if(empty($user->activate))
					Ваш профиль успешно активировался
				@else
					Ваш профиль уже активировался
				@endif 
			@else
				Ошибка активации.
			@endif
		</div>
	</div>
</div> 
@stop