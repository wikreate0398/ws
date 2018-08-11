@extends('layouts.app')

@section('content')
	<div class="container no__home">
		<div class="row">
	        <div class="col-lg-12">
	            <ul class="breadcrumb">
	                <li><a href="/">Главная</a></li>
	                <li>
						<a href="/news">Новости</a>
                	</li>
                	<li>
						<a href="/news/cat/{{ $data['category']['url'] }}">{{ $data['category']['name'] }}</a>
                	</li>
                	<li class="active">{{ $data['name'] }}</li>
	            </ul>
	        </div>
	    </div>

		<div class="row"> 
			<div class="@if(count($more_news)) col-md-8 @else col-md-12 @endif"> 
				<div class="row news__show"> 
					<div class="col-md-12">
						<span class="nws__time">{{ date('d.m.Y H:i', strtotime($data['created_at'])) }}</span>
						<h1 class="page__title">{{ $data['name'] }}</h1> 
						<div>{!! $data['text'] !!}</div>
						<br>
						<a href="/news" class="btn btn2">Назад к новостям</a>
					</div>
				</div>
			</div>
			
			@if(count($more_news))
			<div class="col-md-4">
				<ul class="more_news" style="margin-top: 0px;"> 
					@foreach($more_news as $item)
						<li> 
							<div class="side_image__nws">
								<img class="img-responsive" src="{{ imageThumb(@$item->image, 'uploads/news', 400, 300, 'list') }}">
							</div>
							<div class="side_desc__nws">
								<a href="/news/view/{{ $item['url'] }}" class="news__name">
									{{ $item['name'] }}
								</a>
								<a href="/news/view/{{ $item['url'] }}/" class="news_more">Подробнее >></a>
							</div> 
						</li>
					@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div> 

@stop