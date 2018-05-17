@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12">  
		<div class="portlet light bg-inverse"> 
			<div class="portlet-body form"> 
				<form action="/{{ $method }}/{{ $data['id'] }}/{{ $table }}/update" class="ajax__submit form-horizontal">  

					{{ csrf_field() }}
					
					<div class="form-body" style="padding-top: 20px;"> 
						@include('admin.utils.input', ['label' => 'Название', 'name' => 'data[name]', 'value' => $data['name']])

						@if($table=='lesson_options_list')
							@include('admin.utils.input', ['label' => 'Короткое название', 'name' => 'data[name2]', 'value' => $data['name2']])
						@endif 
					</div>
					<div class="form-actions">
						<div class="btn-set pull-left"> 
							<button type="submit" class="btn green">Сохранить</button> 
						</div> 
					</div>
				</form> 
			</div>
		</div>
	</div>
</div>
@stop