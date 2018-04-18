@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12"> 
		<div class="tabbable-line"> 
			<ul class="nav nav-tabs" style="border-bottom: 1px solid #ededed;">
				<li class="active">
					<a href="#tab_1" data-toggle="tab">
					Основное </a>
				</li> 
				<li class="">
					<a href="#tab_2" data-toggle="tab">
					Seo </a>
				</li> 
			</ul> 
 
			<form action="/{{ $method }}/{{ $data['id'] }}/update" class="ajax__submit">  

				{{ csrf_field() }}
				
				<div class="form-body" style="padding-top: 20px;"> 
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1"> 
							@include('admin.utils.input', ['label' => 'Название', 'name' => 'name', 'value' => $data['name']])
							
							@if($data['alone'] == 0)
								@include('admin.utils.input', ['label' => 'Ссылка', 'name' => 'url', 'value' => $data['url'], 'help' => 'Без http://www и.т.п просто английская фраза, без пробелов, отражающая пункт меню, например Наш подход - our-approach'])  
							@endif

							@include('admin.utils.textarea', ['label' => 'Описание', 'name' => 'text', 'ckeditor' => true, 'value' => $data['text']])
						</div>
					 
						<div class="tab-pane" id="tab_2">
							@include('admin.utils.input', ['label' => 'Заголовок', 'name' => 'seo_title', 'value' => $data['seo_title']])

							@include('admin.utils.textarea', ['label' => 'Описание', 'name' => 'seo_description', 'value' => $data['seo_description']]) 
						</div>
					</div> 
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
 
@stop