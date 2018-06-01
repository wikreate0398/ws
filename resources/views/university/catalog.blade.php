@extends('layouts.app')

@section('content')
    
    <div class="container" style="margin-top: 66px;">
        <div class="row">
            <div class="col-lg-12">
                <ul class="breadcrumb">
                    <li><a href="/">Главная</a></li>
                    <li class="active">Каталог Вузов</li>
                </ul>
            </div>
        </div>
         
        <div class="row">
            <div class="col-lg-12">
                <h1 class="title_page">ВСЕ Вузы</h1>
            </div>
            <div class="col-lg-6 col-lg-offset-3">
                <form class="no_home teacher__search_form" id="search_form" action="/universities" method="Get" data-url-autocomplete="/universities/autocomplete" >
                        <div class="input-group">
                            <input name="q" 
                                   autocomplete="off" 
                                   class="form-control" 
                                   id="search__input" 
                                   placeholder="Введите Название Вуза"
                                   value="{{ @urldecode(request()->input('q')) }}">
                            <div class="loaded__search_result"></div>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn_search">Начать поиск</button>
                            </span>
                        </div>
                </form>
            </div>
        </div>
        @if(!empty($universities))  
        <div class="row" style="margin-bottom: 100px;">
            <div class="col-lg-9">
                <div class="filter_top">
                    <div class="row">
                        <div class="col-lg-4">
                            <ul class="list-inline status_list">
                                <li class="{{ (request()->input('status') == 'all' or request()->input('status') == null) ? 'active' : '' }}">
                                    <a data-status="all" onclick="university_status_filter(this); return false;" href="#">ВСЕ</a>
                                </li>
                                <li class="{{ (request()->input('status') == '1') ? 'active' : '' }}">
                                    <a data-status="1" onclick="university_status_filter(this); return false;" href="#">ГОСУДАРСТВЕННЫЕ</a>
                                </li>
                                <li class="{{ (request()->input('status') == '2') ? 'active' : '' }}">
                                    <a data-status="2" onclick="university_status_filter(this); return false;" href="#">КОММЕРЧЕСКИЕ</a>
                                </li>
                            </ul>
                            <input type="hidden" 
                                   id="university_status" 
                                   value="{{ @request()->input('status') ? request()->input('status') : 'all' }}">
                        </div>
                        <div class="col-lg-4">
                            <ul class="list-inline sorting_list univ__sorting_list">
                                <li><a href=""><i class="fa fa-caret-down" aria-hidden="true"></i> ДАТА</a></li>
                                <li><a href=""><i class="fa fa-caret-up" aria-hidden="true"></i> ОТЗЫВЫ</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-4" style="text-align: right;">
                            <ul class="list-inline per_page_list">
                                <li class="{{ (request()->input('per_page') == '6' or request()->input('per_page') == null) ? 'active' : '' }}">
                                    <a data-perpage="6" onclick="university_perpage_filter(this); return false;" href="#">6</a>
                                </li>
                                <li class="{{ (request()->input('per_page') == '12') ? 'active' : '' }}">
                                    <a data-perpage="12" onclick="university_perpage_filter(this); return false;" href="#">12</a>
                                </li>
                                <li class="{{ (request()->input('per_page') == '24') ? 'active' : '' }}">
                                    <a data-perpage="24" onclick="university_perpage_filter(this); return false;" href="#">24</a>
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

                <style>
                    .university__img img{
                        width: 100%;
                    }

                    .university__item{
                        border:1px solid #ededed;
                        padding: 15px;
                        font-family: 'Cuprum Regular';
                    }

                    .university__item h3{
                        text-transform: uppercase;
                        font-weight: bold;
                        font-size: 14px;
                        text-align: center;
                    }

                    .university__item table{
                        width: 100%;
                        font-size: 13px;  
                    }

                    .university__item table tr td:first-child{
                        color: #9a9a9a;
                    }

                    .university__item table tr td:last-child{
                        text-align: right;
                    }

                    .univ__footer{
                        justify-content: space-between;
                        display: flex;
                        width: 100%;
                        align-items: center;
                    }

                    .univ__footer .univ__price strong{
                        font-size: 18px;
                        color: #333;
                    }

                    .univ__footer .univ__price{
                        font-size: 12px;
                        color: #9a9a9a;
                    }
                </style>

                <div class="row">
                    @foreach($universities as $university)
                        <div class="col-md-4">
                            <div class="university__item">
                                <div class="university__img">
                                    <a href="">
                                        <img class="img-responsive" src="{{ imageThumb(@$university->user->avatar, 'uploads/users', 400, 300, 'universities') }}">
                                    </a>
                                </div>
                                <h3>{{ $university->full_name }}</h3>
                                <hr>
                                <table>
                                    <tr>
                                        <td>КУРСОВ</td> 
                                        <td>{{ count($university->user->courses) }}</td>
                                    </tr>

                                    <tr> 
                                        <td>ПРЕПОДАВАТЕЛЕЙ</td> 
                                        <td>2</td>
                                    </tr>

                                    <tr> 
                                        <td>ФАКУЛЬТЕТОВ</td> 
                                        <td>{{ count($university->faculties) }}</td>
                                    </tr> 

                                    <tr> 
                                        <td>БЮДЖЕТНЫХ МЕСТ</td> 
                                        <td>{{ $university->qty_budget }}</td>
                                    </tr> 
                                </table>
                                <hr>
                                <div class="univ__footer">
                                    <div class="univ__review">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <sup>(12)</sup>
                                    </div>

                                    <div class="univ__price">
                                        От <strong>{{ priceString($university->price) }}</strong> р./год
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach  
                </div>
                {{ $universities->appends(request()->input())->links() }}
                  
            </div>
            <div class="col-lg-3">
            <div class="filter_block">                 
                @if(count($filter['specializationList']))
                    <div class="specializations_teacher">
                        <h4 class="filter__ttl">СПЕЦИАЛИЗАЦИЯ</h4>
                        @php
                            $specializationsArray = [];
                            if(request()->input('specializations')){
                                $specializationsArray = explode(',', request()->input('specializations'));
                            }
                        @endphp
                        @foreach($filter['specializationList'] as $specialization) 
                            <div class="checkbox">
                                <label>
                                    <input value="{{ $specialization->id }}" 
                                           class="specialization_input" 
                                           {{ in_array($specialization->id, $specializationsArray) ? 'checked' : '' }}
                                           type="checkbox">
                                    <span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
                                    {{ $specialization->name }}
                                </label>
                            </div> 
                        @endforeach
                    </div>
                @endif 

                 @php  
                    $hasMilitaryDepartmentArr = explode(',', request()->input('has_military_department'));
                @endphp
                <div class="specializations_teacher">
                    <h4 class="filter__ttl">НАЛИЧИЕ ВОЕННОЙ КАФЕДРЫ</h4>
                    <div class="checkbox">
                        <label>
                            <input value="1" 
                                   class="has_military_department" 
                                   {{ in_array('1', $hasMilitaryDepartmentArr) ? 'checked' : '' }}
                                   type="checkbox">
                            <span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
                            Да
                        </label>
                    </div> 
                    <div class="checkbox">
                        <label>
                            <input value="0" 
                                   class="has_military_department" 
                                   {{ in_array('0', $hasMilitaryDepartmentArr) ? 'checked' : '' }}
                                   type="checkbox">
                            <span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
                            Нет
                        </label>
                    </div> 
                </div>
                
                @php  
                    $hasHostelArr = explode(',', request()->input('has_hostel'));
                @endphp
                <div class="specializations_teacher">
                    <h4 class="filter__ttl">НАЛИЧИЕ ОБЩЕЖИТИЯ</h4>
                    <div class="checkbox">
                        <label>
                            <input value="1" 
                                   class="has_hostel" 
                                   {{ in_array('1', $hasHostelArr) ? 'checked' : '' }}
                                   type="checkbox">
                            <span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
                            Да
                        </label>
                    </div> 
                    <div class="checkbox">
                        <label>
                            <input value="0" 
                                   class="has_hostel" 
                                   {{ in_array('0', $hasHostelArr) ? 'checked' : '' }}
                                   type="checkbox">
                            <span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
                            Нет
                        </label>
                    </div> 
                </div>
                
                @php  
                    $distanceLearningArr = explode(',', request()->input('distance_learning'));
                @endphp
                <div class="specializations_teacher">
                    <h4 class="filter__ttl">ДИСТАНЦИОННОЕ ОБУЧЕНИЕ</h4>
                    <div class="checkbox">
                        <label>
                            <input value="1" 
                                   class="distance_learning" 
                                   {{ in_array('1', $distanceLearningArr) ? 'checked' : '' }}
                                   type="checkbox">
                            <span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
                            Да
                        </label>
                    </div> 
                    <div class="checkbox">
                        <label>
                            <input value="0" 
                                   class="distance_learning" 
                                   {{ in_array('0', $distanceLearningArr) ? 'checked' : '' }}
                                   type="checkbox">
                            <span class="jackdaw"><i class="jackdaw-icon fa fa-check"></i></span>
                            Нет
                        </label>
                    </div> 
                </div>

                @if($filter['minMaxPrice']['min'] > 0 && $filter['minMaxPrice']['max'] > 0 && $filter['minMaxPrice']['min'] <> $filter['minMaxPrice']['max'])
                <div class="price_options">
                    <h4 class="filter__ttl">СТОИМОСТЬ ГОДА ОБУЧЕНИЯ</h4>
                    <div class="form-group"> 
                        <input type="hidden" name="min_price" value="{{ @request()->input('min_price') }}" id="min_price">
                        <input type="hidden" name="max_price" value="{{ @request()->input('max_price') }}" id="max_price">
                        <div id="slider-range"></div>
                        <input type="text" id="amount" readonly>
                    </div>
                </div>
                @endif
                <script>
                    var minMaxPrice = {'min':parseFloat({{ $filter['minMaxPrice']['min'] }}), 'max': parseFloat({{ $filter['minMaxPrice']['max'] }})}; 
                </script> 
 
                @if(request()->input('flt') == 1)
                    <div class="reset_filter">
                        <a href="/universities">Сбросить фильтр </a>
                    </div> 
                @endif
            </div>
            <script>
                
            </script> 
            </div>
        </div>

        @endif
    </div>
@stop