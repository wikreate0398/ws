@extends('layouts.app')

@section('content')
	<div class="container no__home">
		<div class="row">
	        <div class="col-lg-12">
	            <ul class="breadcrumb">
	                <li><a href="/">Главная</a></li>
	                @if(!empty($category['name']))
	                	<li>
							<a href="/news">Новости</a>
	                	</li>
	                	<li class="active">{{ $category['name'] }}</li>
	                @else
						<li class="active">Новости</li>
	                @endif 
	            </ul>
	        </div>
	    </div>

		<div class="row">
			@if(!empty($category['name']))
				<div class="col-md-12">
					<h1 class="page__title">{{ $category['name'] }}</h1>
				</div>
			@endif 
			<div class="col-md-9">
				<div class="row news__catalog"> 
					@foreach($news as $item)
						<div class="col-md-4">
							<div class="news__item eq_list__item">
								<a href="/news/view/{{ $item['url'] }}/" style="position: relative;">
									<span class="news_cat__label">{{ $item['category']['name'] }}</span>
									<img class="img-responsive" src="{{ imageThumb(@$item->image, 'uploads/news', 400, 300, 'list') }}">
								</a>
								<a href="/news/view/{{ $item['url'] }}/" class="news_name">
									{{ $item['name'] }}
								</a>
								<p>{{ $item['description'] }}</p>
								<a href="/news/view/{{ $item['url'] }}/" class="news_more">Подробнее >></a>
							</div>
						</div>
					@endforeach
				</div>
			</div>

			<div class="col-md-3">
				<ul class="courses__cats" style="margin-top: 0px;">
					<li class="{{ !request()->segment(3) ? 'active' : '' }}">
						<a href="/news">Все Новости <span class="badge badge-default">{{ $totalNews }}</span></a>
					</li>
					@foreach($categories as $category)
						<li class="{{ (request()->segment(3) == $category['url']) ? 'active' : '' }}">
							<a href="/news/cat/{{ $category['url'] }}">
								{{ $category['name'] }} 
								<span class="badge badge-default">
									{{ count($category->news) }}
								</span>
							</a>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div> 
@stop