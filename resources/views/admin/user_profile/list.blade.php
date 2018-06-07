@extends('layouts.admin') 
@function ( catList($menu, $method, $table) )
	@foreach ($menu as $item)  
    <li class="dd-item dd3-item" data-id="{{ $item['id'] }}">
	       <div class="dd-handle dd3-handle handle "></div>
	       <div class="dd3-content clearfix">
	          	<p style="float:left; margin:0 !important;" class="no-drag">   
	            	{{ $item['name'] }}  
	          	</p>
	          	<p style="float:right; margin:0 !important;"> 
	          		<input type="checkbox" 
	          		       class="make-switch" data-size="mini" {{ !empty($item['view']) ? 'checked' : '' }} 
	          		       data-on-text="<i class='fa fa-check'></i>" 
	          		       data-off-text="<i class='fa fa-times'></i>" 
	          		       onchange="Ajax.buttonView(this, '{{ $table }}', '{{ $item["id"] }}')"> 
	             	<a style="margin-left: 5px;" 
	             	   href="/{{ $method }}/{{ $item['id'] }}/{{ $table }}/edit/" 
	             	   class="btn btn-primary btn-xs">Редактировать</a>  
	             	<a class="btn btn-danger btn-xs" data-toggle="modal" href="#deleteModal_{{ $table }}_{{ $item['id'] }}">Удалить</a>  
	            	<!-- Modal -->
	            		@include('admin.utils.delete', ['id' => $item['id'], 'table' => $table])
	           		<!-- Modal --> 
	          	</p>   
	       </div>
	        @if(!empty($item['childs']))  
	           	<ol class="dd-list">
	             	@catList($item['childs'], $method, $table)
	           	</ol>
	        @endif
	    </li>
	@endforeach
@endfunction 

@section('content') 

	<div class="panel-group accordion scrollable" id="accordion2">
		<div class="panel panel-default" id="programs_type">
			<div class="panel-heading">
				<h4 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_1"> Уровень образования </a>
				</h4>
			</div>
			<div id="collapse_2_1" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption" 
							     style="cursor: pointer;" onclick="$(this).closest('.portlet-title').find('.tools .toggle__form').click();">
							 	Добавить
							</div>
							<div class="tools">
								<a href="javascript:;" class="toggle__form expand">
								</a> 
							</div>
						</div>

						<div class="portlet-body form" style="display: none;"> 
							<form action="/{{ $method }}/create" class="ajax__submit form-horizontal">  

								{{ csrf_field() }}

								<input type="hidden" name="tbname" value="programs_type">

								<div class="form-body" style="padding-top: 20px;">  
									@include('admin.utils.input', ['label' => 'Название', 'name' => 'data[name]'])  
								</div>
								<div class="form-actions">
									<div class="btn-set pull-left"> 
										<button type="submit" class="btn green">Сохранить</button> 
									</div> 
								</div>
							</form> 
						</div>
					</div> 

					<div class="dd nestable" data-depth="2" data-table="programs_type" data-action="{{ route('depth_sort') }}">
			        	<ol class="dd-list">   
		               		@catList(map_tree($programs_type), $method, 'programs_type') 
			        	</ol>
			      	</div> 
				</div>
			</div>
		</div>
		<div class="panel panel-default" id="degree_experience">
			<div class="panel-heading">
				<h4 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_2">
				Степень опыта </a>
				</h4>
			</div>
			<div id="collapse_2_2" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption" 
							     style="cursor: pointer;" onclick="$(this).closest('.portlet-title').find('.tools .toggle__form').click();">
							 	Добавить
							</div>
							<div class="tools">
								<a href="javascript:;" class="toggle__form expand">
								</a> 
							</div>
						</div>

						<div class="portlet-body form" style="display: none;"> 
							<form action="/{{ $method }}/create" class="ajax__submit form-horizontal">  

								{{ csrf_field() }}

								<input type="hidden" name="tbname" value="degree_experience">

								<div class="form-body" style="padding-top: 20px;">  
									@include('admin.utils.input', ['label' => 'Название', 'name' => 'data[name]'])  
								</div>
								<div class="form-actions">
									<div class="btn-set pull-left"> 
										<button type="submit" class="btn green">Сохранить</button> 
									</div> 
								</div>
							</form> 
						</div>
					</div> 

					<div class="dd nestable" data-depth="1" data-table="teacher_specializations_list" data-action="{{ route('depth_sort') }}">
			        	<ol class="dd-list">   
		               		@catList(map_tree($degree_experience), $method, 'degree_experience') 
			        	</ol>
			      	</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default" id="specializations_list">
			<div class="panel-heading">
				<h4 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_3">
				Специализации учителя </a>
				</h4>
			</div>
			<div id="collapse_2_3" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption" 
							     style="cursor: pointer;" onclick="$(this).closest('.portlet-title').find('.tools .toggle__form').click();">
							 	Добавить
							</div>
							<div class="tools">
								<a href="javascript:;" class="toggle__form expand">
								</a> 
							</div>
						</div>

						<div class="portlet-body form" style="display: none;"> 
							<form action="/{{ $method }}/create" class="ajax__submit form-horizontal">  

								{{ csrf_field() }}

								<input type="hidden" name="tbname" value="teacher_specializations_list">

								<div class="form-body" style="padding-top: 20px;">  
									@include('admin.utils.input', ['label' => 'Название', 'name' => 'data[name]'])  
								</div>
								<div class="form-actions">
									<div class="btn-set pull-left"> 
										<button type="submit" class="btn green">Сохранить</button> 
									</div> 
								</div>
							</form> 
						</div>
					</div> 

					<div class="dd nestable" data-depth="1" data-table="teacher_specializations_list" data-action="{{ route('depth_sort') }}">
			        	<ol class="dd-list">   
		               		@catList(map_tree($teacher_specializations_list), $method, 'teacher_specializations_list') 
			        	</ol>
			      	</div> 
				</div>
			</div>
		</div>

		<div class="panel panel-default" id="university_specializations_list">
			<div class="panel-heading">
				<h4 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_33">
				Специализации учебного заведения </a>
				</h4>
			</div>
			<div id="collapse_2_33" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption" 
							     style="cursor: pointer;" onclick="$(this).closest('.portlet-title').find('.tools .toggle__form').click();">
							 	Добавить
							</div>
							<div class="tools">
								<a href="javascript:;" class="toggle__form expand">
								</a> 
							</div>
						</div>

						<div class="portlet-body form" style="display: none;"> 
							<form action="/{{ $method }}/create" class="ajax__submit form-horizontal">  

								{{ csrf_field() }}

								<input type="hidden" name="tbname" value="university_specializations_list">

								<div class="form-body" style="padding-top: 20px;">  
									@include('admin.utils.input', ['label' => 'Название', 'name' => 'data[name]'])  
								</div>
								<div class="form-actions">
									<div class="btn-set pull-left"> 
										<button type="submit" class="btn green">Сохранить</button> 
									</div> 
								</div>
							</form> 
						</div>
					</div> 

					<div class="dd nestable" data-depth="1" data-table="university_specializations_list" data-action="{{ route('depth_sort') }}">
			        	<ol class="dd-list">   
		               		@catList(map_tree($university_specializations_list), $method, 'university_specializations_list') 
			        	</ol>
			      	</div> 
				</div>
			</div>
		</div>

		<div class="panel panel-default" id="subjects">
			<div class="panel-heading">
				<h4 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_4">
				Предметы </a>
				</h4>
			</div>
			<div id="collapse_2_4" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption" 
							     style="cursor: pointer;" onclick="$(this).closest('.portlet-title').find('.tools .toggle__form').click();">
							 	Добавить
							</div>
							<div class="tools">
								<a href="javascript:;" class="toggle__form expand">
								</a> 
							</div>
						</div>

						<div class="portlet-body form" style="display: none;"> 
							<form action="/{{ $method }}/create" class="ajax__submit form-horizontal">  

								{{ csrf_field() }}

								<input type="hidden" name="tbname" value="subjects">

								<div class="form-body" style="padding-top: 20px;">  
									@include('admin.utils.input', ['label' => 'Название', 'name' => 'data[name]'])  
								</div>
								<div class="form-actions">
									<div class="btn-set pull-left"> 
										<button type="submit" class="btn green">Сохранить</button> 
									</div> 
								</div>
							</form> 
						</div>
					</div> 

					<div class="dd nestable" data-depth="1" data-table="subjects" data-action="{{ route('depth_sort') }}">
			        	<ol class="dd-list">   
		               		@catList(map_tree($subjects), $method, 'subjects') 
			        	</ol>
			      	</div> 
				</div>
			</div>
		</div>

		<div class="panel panel-default" id="lesson_options_list">
			<div class="panel-heading">
				<h4 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_5">
				Варианты проведения Занятий </a>
				</h4>
			</div>
			<div id="collapse_2_5" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption" 
							     style="cursor: pointer;" onclick="$(this).closest('.portlet-title').find('.tools .toggle__form').click();">
							 	Добавить
							</div>
							<div class="tools">
								<a href="javascript:;" class="toggle__form expand">
								</a> 
							</div>
						</div>

						<div class="portlet-body form" style="display: none;"> 
							<form action="/{{ $method }}/create" class="ajax__submit form-horizontal">  

								{{ csrf_field() }}

								<input type="hidden" name="tbname" value="lesson_options_list">

								<div class="form-body" style="padding-top: 20px;">  
									@include('admin.utils.input', ['label' => 'Название', 'name' => 'data[name]']) 
									@include('admin.utils.input', ['label' => 'Короткое название', 'name' => 'data[name2]']) 
								</div>
								<div class="form-actions">
									<div class="btn-set pull-left"> 
										<button type="submit" class="btn green">Сохранить</button> 
									</div> 
								</div>
							</form> 
						</div>
					</div> 

					<div class="dd nestable" data-depth="1" data-table="lesson_options_list" data-action="{{ route('depth_sort') }}">
			        	<ol class="dd-list">   
		               		@catList(map_tree($lesson_options_list), $method, 'lesson_options_list') 
			        	</ol>
			      	</div> 
				</div>
			</div>
		</div>

	</div>
 

	<script>
		// var id = '';
		// if (window.location.hash) {
		// 	var id = window.location.hash; 
		// } 
 
		// if (id != '') {
		// 	$('.panel-collapse').removeClass('in').addClass('collapse');
		// 	$(id).find('.panel-collapse').removeClass('collapse').addClass('in');
		// }

		// // $('html,body').animate({
	 // //        scrollTop: $(id).offset().top},
	 // //        'slow');
	</script>
@stop



