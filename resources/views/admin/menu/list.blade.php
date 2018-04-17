@extends('layouts.admin')
@function ( catList($menu, $method) )
	@foreach ($menu as $item)  
    <li class="dd-item dd3-item" data-id="{{ $item['id'] }}">
	       <div class="dd-handle dd3-handle handle "></div>
	       <div class="dd3-content clearfix">
	          	<p style="float:left; margin:0 !important;">  
	               <input {{ !empty($category['view']) ? 'checked' : '' }} onclick="buttonView(this, 'category', '{{ $item->id }}')" class="checkbox" name="view" type="checkbox">  
	            	{{ $item['name'] }}
	          	</p>
	          	<p style="float:right; margin:0 !important;"> 
	             	<a href="/{{ $method }}/{{ $item['id'] }}/edit/" class="btn btn-primary btn-xs">Редактировать</a>  
	             	<a class="btn btn-danger btn-xs" data-toggle="modal" href="#deleteModal{{ $item['id'] }}">Удалить</a>  
	            	<!-- Modal -->
	            		@include('admin.utils.delete', ['id' => $item['id']])
	           		<!-- Modal --> 
	          	</p>   
	       </div>
	        @if($item['childs']) 
	           	<ol class="dd-list">
	             	{{ catList($item['childs'], $method) }}
	           	</ol>
	        @endif
	    </li>
	@endforeach
@endfunction
@section('content')
   	<style>
      	.dd3-item > button{ 
      		display: none !important;
      	}
   	</style>
	<div class="row">
	   <div class="col-md-12">  
	      <div class="dd" id="nestable" data-table="{{ $table }}" data-action="/{{ $method }}/sortable/">
	         <ol class="dd-list">  
               	@catList(map_tree($menu), $method) 
	         </ol>
	      </div>
	   </div>
	</div>
@stop