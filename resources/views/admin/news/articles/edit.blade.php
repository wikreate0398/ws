@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-12"> 
		<div class="portlet light bg-inverse"> 
			<div class="portlet-body form"> 
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
		 
					<form action="/{{ $method }}/{{ $data['id'] }}/update" class="ajax__submit form-horizontal">  

						{{ csrf_field() }}
						
						<div class="form-body" style="padding-top: 20px;"> 
							<div class="tab-content">
								<div class="tab-pane active" id="tab_1"> 
									@include('admin.utils.input', ['label' => 'Название', 'name' => 'data[name]', 'value' => $data['name'] ])
									 
									@include('admin.utils.input', ['label' => 'Ссылка', 'name' => 'data[url]', 'value' => $data['url'], 'help' => 'Без http://www и.т.п просто английская фраза, без пробелов, отражающая пункт меню, например Наш подход - our-approach'])

									@include('admin.utils.select', ['label' => 'Категория', 'name' => 'data[id_category]', 'data' => $categories, 'req' => true, 'value' => $data['id_category']]) 

									@include('admin.utils.textarea', ['label' => 'Анонс', 'name' => 'data[description]', 'value' => $data['description'], 'maxlength' => '255'])

									@include('admin.utils.textarea', ['label' => 'Текст', 'name' => 'data[text]', 'ckeditor' => true, 'value' => $data['text']])

									@include('admin.utils.image', [
									'inputName' => 'image', 
									'table' => $table, 
									'folder' => 'news', 
									'id' => $data['id'], 
									'filename' => $data['image']])		 
								</div>
							 
								<div class="tab-pane" id="tab_2">
									@include('admin.utils.input', ['label' => 'Заголовок', 'name' => 'data[seo_title]', 'value' => $data['seo_title']])

									@include('admin.utils.textarea', ['label' => 'Описание', 'name' => 'data[seo_description]', 'value' => $data['seo_description']]) 

									@include('admin.utils.input', ['label' => 'Ключевые слова', 'name' => 'data[seo_keywords]', 'value' => $data['seo_keywords']]) 
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
	</div>
</div>
 
@stop