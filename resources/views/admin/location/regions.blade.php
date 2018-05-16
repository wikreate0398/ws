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

	          		<a style="margin-left: 5px;" href="/{{ $method }}/{{ $item['id'] }}/cities/" class="btn btn-primary btn-xs">Города</a> 
	          	</p>   
	       </div> 
	    </li>
	@endforeach
@endfunction

@section('content') 
	<div class="row">
		<!-- <div class="col-md-12" style="margin-bottom: 20px;">
			<a href="/{{ $method }}/add/" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Добавить</a>
		</div> -->

		<div class="col-md-12" style="margin-bottom: 20px;">
			<form action="/{{ $method }}/">
				<input value="{{ @request()->input('query') }}" name="query" style="width: 250px; float: left; margin-right: 10px;" type="text" placeholder="Поиск" class="form-control">  
				<button type="submit" class="btn btn-success">Поиск</button>
				@if(@request()->input('query'))
					<a href="/{{ $method }}/" class="btn btn-danger">Сбросить</a>
				@endif
			</form>
		</div>

	   	<div class="col-md-12">  
	      	<div class="dd nestable" data-depth="2" data-table="{{ $table }}" data-action="{{ route('depth_sort') }}">
	        	<ol class="dd-list">  
	        	@php $cities = $data->toArray(); @endphp
               	@catList(map_tree($cities['data']), $method, $table) 
	        	</ol>
	      	</div> 
	   	</div>

	   	<div class="col-md-12">
	   		{{ $data->appends(request()->input())->links() }}
	   	</div>
	</div>
@stop

