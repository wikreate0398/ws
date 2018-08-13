@extends('layouts.admin')
@function ( catList($data, $method, $table) )
	@foreach ($data as $item)  
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
	             	<a style="margin-left: 5px;" href="/{{ $method }}/{{ $item['id'] }}/edit/" class="btn btn-primary btn-xs">Редактировать</a>  
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
	<div class="row">
		<div class="col-md-12" style="margin-bottom: 20px;">
			<a href="/{{ $method }}/add/" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Добавить</a>
		</div>
		
		@if(count($data))
	   	<div class="col-md-12">   
	   		@foreach ($data as $category)  
	   		<h2>{{ $category['name'] }}</h2>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th style="text-align: center;">
							<i data-toggle="tooltip" class="fa fa-eye" aria-hidden="true"></i>
                        </th>
						<th style="width: 90%;">Заголовок</th>
						<th>Дата</th>
						<th style="text-align: center;"><i class="fa fa-cogs" aria-hidden="true"></i></th>
					</tr>
				</thead>
				<tbody> 
					@foreach ($category['news'] as $item)   
						<tr>
							<td style="width:50px; text-align:center;"> 
								<input type="checkbox" 
	          		       class="make-switch" data-size="mini" {{ !empty($item['view']) ? 'checked' : '' }} 
	          		       data-on-text="<i class='fa fa-check'></i>" 
	          		       data-off-text="<i class='fa fa-times'></i>" 
	          		       onchange="Ajax.buttonView(this, '{{ $table }}', '{{ $item["id"] }}')"> 
							</td>
							<td>{{ $item['name'] }}</td>
							<td style="white-space: nowrap;">{{ date('d.m.Y H:i', strtotime($item['created_at'])) }}</td>
							<td style="white-space: nowrap;">
								<a style="margin-left: 5px;" 
								   href="/{{ $method }}/{{ $item['id'] }}/edit/" 
								   class="btn btn-primary btn-xs">Редактировать</a>  
		             			<a class="btn btn-danger btn-xs" 
		             			   data-toggle="modal" 
		             			   href="#deleteModal_{{ $table }}_{{ $item['id'] }}">Удалить</a>  
				            	<!-- Modal -->
				            		@include('admin.utils.delete', ['id' => $item['id'], 'table' => $table])
				           		<!-- Modal --> 
							</td>
						</tr>
					@endforeach
				</tbody> 
			</table> 
			@endforeach
	   	</div>
	   	@endif
	</div>
@stop

