@extends('layouts.app')

@section('content')

<input type="hidden" id="baseUrl" value="{{ $baseUrl }}">

<div class="container no__home">
	<div class="row">
        <div class="col-lg-12">
            <ul class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active">Каталог Курсов</li>
            </ul>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <h1 class="title_page">ВСЕ КУРСЫ</h1>
        </div>
        <div class="col-lg-6 col-lg-offset-3">
			<form class="no_home courses__search_form" id="search_form" action="{{ $baseUrl }}" method="Get" data-url-autocomplete="/courses/autocomplete" >
					<div class="input-group">
						<input name="q" 
							   autocomplete="off" 
							   class="form-control" 
							   id="search__input" 
							   placeholder="Введите название курса"
							   value="{{ @urldecode(request()->input('q')) }}">
						<div class="loaded__search_result"></div>
						<span class="input-group-btn">
							<button type="submit" class="btn btn_search">Начать поиск</button>
						</span>
					</div>
			</form>
        </div>
    </div>

    <div class="row">
    	<div class="col-lg-9">
    		<div class="filter_top">
                <div class="row">
                    <div class="col-lg-4">
                        <ul class="list-inline available_list">
                            <li class="{{ (request()->input('pay') == 'all' or request()->input('pay') == null) ? 'active' : '' }}">
                                <a data-pay="all" onclick="courses_pay_filter(this); return false;" href="#">ВСЕ</a>
                            </li> 
                            <li class="{{ (request()->input('pay') == '2') ? 'active' : '' }}">
                                <a data-pay="2" onclick="courses_pay_filter(this); return false;" href="#">ПЛАТНЫЕ</a>
                            </li>

                            <li class="{{ (request()->input('pay') == '1') ? 'active' : '' }}">
                                <a data-pay="1" onclick="courses_pay_filter(this); return false;" href="#">БЕСПЛАТНЫЕ</a>
                            </li>
                        </ul>
                        <input type="hidden" 
                               id="courses_pay" 
                               value="{{ @request()->input('pay') ? request()->input('pay') : 'all' }}">
                    </div>
                    <div class="col-lg-4">
                        <ul class="list-inline sorting_list">
                            <li><a href=""><i class="fa fa-caret-down" aria-hidden="true"></i> ДАТА</a></li>
                            <li><a href=""><i class="fa fa-caret-up" aria-hidden="true"></i> ОТЗЫВЫ</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4" style="text-align: right;">
                        <ul class="list-inline per_page_list">
                            <li class="{{ (request()->input('per_page') == '12' or request()->input('per_page') == null) ? 'active' : '' }}">
                                <a data-perpage="12" onclick="courses_perpage_filter(this); return false;" href="#">12</a>
                            </li>
                            <li class="{{ (request()->input('per_page') == '24') ? 'active' : '' }}">
                                <a data-perpage="24" onclick="courses_perpage_filter(this); return false;" href="#">24</a>
                            </li>
                            <li class="{{ (request()->input('per_page') == '48') ? 'active' : '' }}">
                                <a data-perpage="48" onclick="courses_perpage_filter(this); return false;" href="#">48</a>
                            </li>
                        </ul>
                        <input type="hidden" 
                               id="per_page" 
                               value="{{ @request()->input('per_page') ? request()->input('per_page') : '6' }}">

                        <input type="hidden" 
                               id="page" 
                               value="{{ @request()->input('page') ? request()->input('page') : '1' }}">
                    </div>
                </div>
            </div>

            <div class="row course__catalog">

            	@foreach($courses as $course)
            	<div class="col-md-4"> 
	            	<div class="course_card eq_list__item">
	            		@if(@Auth::check()) 
	            			@php $favorite = in_array(Auth::user()->id, $course->userFavorite->pluck('id')->toArray()); @endphp
		            		<i class="fa course_heart 
		            		   {{ $favorite ? 'is_favorite fa-heart' : 'fa-heart-o' }}" 
		            		   onclick="courseFavorite(this, {{ $course->id }});"  
		            		   aria-hidden="true"></i>
	            		@endif
	            		<div class="body__course_card">
	            			<div class="cat-name"> 
	            				@if(!empty(@$course->subCategory->name)) 
									{{ @$course->subCategory->name }}
								@else 
									{{ @$course->category->name }}
	            				@endif 
	            			</div>
		            		<h2>
		            			<a href="/course/{{ $course->id }}">
		            				{{ $course->name }}
		            			</a>
		            		</h2> 
		            		<h4>
					            @if($course->user->user_type==3)
					            		{{ $course->user->university['full_name'] }} 
					            	@else
										{{ $course->user->name }} 
					            @endif
				        	</h4>
		            		<table>
		            			<tr>
		            				<td>Начало</td> 
		            				<td>
										{{ date('d.m.Y', strtotime($course->date_from)) }}
		            				 </td>
		            			</tr> 
		            			<tr>
		            				<td>СТОИМОСТЬ</td> 
		            				<td>
										@if($course->pay == 1)
											БЕСПЛАТНО
										@else
											₽{{ priceString(Course::generatePrice($course)) }}
			            				@endif 
		            				 </td>
		            			</tr> 
		            			<tr> 
		            				<td>ДЛИТЕЛЬНОСТЬ</td> 
		            				<td style="text-transform: uppercase;">
		            					@php 
						                    $diff = dateDiff($course->date_from, $course->date_to);
		            					@endphp
		            					@if($diff->m)
											{{ $diff->m }} {{ monthCase($diff->m) }}
		            					@endif 

		            					@if($diff->d) 
			            					@if($diff->m)
												и
			            					@endif 
											{{ $diff->d }}  
											@php 
												echo dayCase($diff->d);
											@endphp  
		            					@endif 
		            				</td>
		            			</tr> 
		            			<tr> 
		            				<td>РЕЙТИНГ</td>
		            				<td>
		            					<i class="fa fa-star" aria-hidden="true"></i>
		            					<i class="fa fa-star" aria-hidden="true"></i>
		            					<i class="fa fa-star" aria-hidden="true"></i>
		            					<i class="fa fa-star" aria-hidden="true"></i>
		            				</td>
		            			</tr>
		            		</table>
	            		</div>

	            		<div class="footer__course_card">
	            			<div class="pers__num">
	            				<i class="fa fa-user" aria-hidden="true"></i>
	            				<span>{{ count($course->userRequests) }}</span>
	            			</div>
	            			<div class="set__going">   
	            				@php 
                                    $esablishDate = Course::manager($course)->esablishDate();  
                                @endphp 
								<i class="fa fa-calendar" aria-hidden="true"></i>
							    <div class="set__going_date">  
									<span> {{ $esablishDate['status'] }} </span> 
									@if($esablishDate['date'])
										<strong> {{ $esablishDate['date'] }} </strong>
									@endif 
    							</div>  
	            			</div>
	            		</div>
	            	</div>
            	</div>
            	@endforeach 
            </div>
            <div class="row">
            	<div class="col-lg-12">
            		{{ $courses->appends(request()->input())->links() }}
            	</div>
            </div>
    	</div>
		
		<div class="col-lg-3">
			<ul class="courses__cats">
				<li class="{{ !request()->segment(3) ? 'active' : '' }}">
					<a href="/courses">Все Курсы <span class="badge badge-default">{{ $totalCourses }}</span></a>
				</li>
				@foreach($categories as $category)
					<li class="{{ (request()->segment(3) == $category['url']) ? 'active' : '' }}">
						<a href="/courses/cat/{{ $category['url'] }}">
							{{ $category['name'] }} 
							<span class="badge badge-default">
								@if($subcatFlag == false)
									{{ count($category->courses) }}
								@else
									{{ count($category->coursesSubcat) }}
								@endif
							</span>
						</a>
					</li>
				@endforeach
			</ul>
		</div>

    </div>
</div> 
@stop