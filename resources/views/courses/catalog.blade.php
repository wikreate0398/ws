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
			<form class="no_home" id="search_form" action="{{ $baseUrl }}" method="Get" data-url-autocomplete="/courses/autocomplete" >
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

            <div class="row">

            	@foreach($courses as $course)
            	<div class="col-md-4"> 
	            	<div class="course_card">
	            		<i class="fa fa-heart-o course_heart" aria-hidden="true"></i>
	            		<div class="body__course_card">
	            			<div class="cat-name">
	            				@if(!empty($course->subCategory))
									{{ $course->subCategory->name }}
								@else
									{{ $course->category->name }}
	            				@endif 
	            			</div>
		            		<h2>
		            			<a href="/course/{{ $course->id }}">
		            				{{ $course->name }}
		            			</a>
		            		</h2>
		            		<table>
		            			<tr>
		            				<td>СТОИМОСТЬ</td> 
		            				<td>
										@if($course->pay == 1)
											БЕСПЛАТНО
										@else
											₽{{ $course->price }}
			            				@endif 
		            				 </td>
		            			</tr>

		            			<tr> 
		            				<td>ДЛИТЕЛЬНОСТЬ</td> 
		            				<td>1 МЕСЯЦ</td>
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
	            				<span>10</span>
	            			</div>
	            			<div class="set__going">
	            				<i class="fa fa-calendar" aria-hidden="true"></i>
            					<div class="set__going_date">
            						<span> ИДЕТ НАБОР ДО </span> 
            						<strong>20.10.2018</strong> 
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
							<span class="badge badge-default">{{ count($category->courses) }}</span>
						</a>
					</li>
				@endforeach
			</ul>
		</div>

    </div>
</div>

<style>

	.courses__cats{
		margin-top: 30px;
		list-style: none; 
		background-color: #ededed;
		padding:10px;
	}

	.courses__cats li a{
		display: block;
		padding:7px 0;
		border-bottom: 1px solid #ccc;
		text-decoration: none;
		text-transform: uppercase;
		font-size: 12px;
		color: #333;
	}

	.courses__cats li.active a{
		color:#b93777;
	}

	.courses__cats li:last-child a{
		border-bottom: none;
	}

	.courses__cats li a .badge{
		float: right;
		border-radius: 0;
	}
	
	.course_card {
		-webkit-box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.349019607843137);
		box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.349019607843137);
		position: relative;
	}

	.course_card .course_heart{
		position: absolute;
		top: 15px;
		right: 15px;
		cursor: pointer;
	}

	.course_card .cat-name{
		font-size: 11px;
		color: #b93777;
		text-transform: uppercase;
	}

	.course_card h2 {
		text-transform: uppercase; 
		font-size: 18px;
		font-weight: bold; 
	} 

	.course_card h2 a {
		color: #000066;
		text-decoration: none;
	}

	.course_card .body__course_card{ 
		padding:15px;
	}

	.course_card .body__course_card table{
		width: 100%;
		font-size: 11px;
		color: #333;
	}

	.course_card .body__course_card table tr td:last-child{
		text-align: right;
	}

	.course_card .footer__course_card .pers__num span{
		font-size: 11px;
	}

	.course_card .footer__course_card{
		width: 100%;
		display: flex;
		justify-content: space-between;
		align-items: center;
		color: #fff;
		padding:10px 15px;
		background-color: rgba(153, 153, 153, 1);
	}

	.course_card .footer__course_card .set__going_date{
		display: inline-block;
		vertical-align: middle;
		margin-left: 10px;
	}

	.course_card .footer__course_card .set__going_date span, .course_card .footer__course_card .set__going_date strong{
		font-size: 11px;
		display: block;
	}

	.course_card .footer__course_card i{
		font-size: 18px;
	}
</style>
@stop