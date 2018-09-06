@extends('layouts.app') @section('content')
<div class="container no__home">
    <div class="row university__show university_page">
        <div class="col-lg-12">
            <ul class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li><a href="/universities">Вузы и школы</a></li>
                <li><span>{{ $university->full_name }}</span></li>
            </ul>
            <ul class="list-inline card_tag">
                <li class="tag_sticker">
                    <span>@if($university->status == 1) Государственный @else Коммерческий @endif</span>
                </li>
                 
                @if(@Auth::check()) 
                    <li class="bookmark_tag"> 
                        <i class="fa {{ $bookmark ? 'is_favorite fa-heart' : 'fa-heart-o' }}" 
                           onclick="universityBookmark(this, {{ $university->user->id }});" 
                           aria-hidden="true"></i>
                    </li>
                @endif

            </ul>
            <h1>{{ $university->full_name }}</h1>
            <span class="city_university">г.{{ $university->user->cityData->name }}</span>
            <ul class="list-inline short_info_university">
                <li><span>{{ count($university->user->courses) }}</span> курсов</li>
                <li><span>{{ count($university->user->connectionTeachers) }}</span> {{ format_by_count(count($university->user->connectionTeachers), 'преподаватель','преподавателя','преподавателей') }}</li>
                <li><span>{{ count($university->faculties) }}</span> факультетов</li>
                <li><span>{{ $university->qty_budget }}</span> бюджетных мест</li>
            </ul>
            <ul class="nav nav-tabs university_tabs">
                <li class="active"><a data-toggle="tab" href="#general">ОБЩАЯ ИНФОРМАЦИЯ</a></li>
                <li><a data-toggle="tab" href="#course" onclick="setTimeout(function(){ eqBlocksInit(); }, 200);">КУРСЫ И ПРОГРАММЫ</a></li>
                <li><a data-toggle="tab" href="#teachers">ПРЕПОДАВАТЕЛИ</a></li>
                <li><a data-toggle="tab" href="#faculties">ФАКУЛЬТЕТЫ</a></li>
                <li><a data-toggle="tab" href="#news">НОВОСТИ</a></li>
                <li><a data-toggle="tab" href="#contacts">КОНТАКТЫ</a></li>
            </ul>
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <div id="general" class="tab-pane fade in active">
                    <p class="univer_description">{{ $university->user->about }}</p>
                    @php 
                        $true = '<i class="fa fa-check-circle" aria-hidden="true"></i>'; 
                        $false = '<i class="fa fa-times-circle" aria-hidden="true"></i>'; 
                    @endphp
                    <table class="table university_option">
                        <thead>
                            <tr>
                                <th></th>
                                <th>На бюджет</th>
                                <th>На платное</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td>Средний балл ЕГЭ</td>
                              <td class="text-center"><span>{{ $university->budget_points_admission }}</span></td>
                              <td class="text-center"><span>{{ $university->payable_points_admission }}</span></td>
                            </tr>
                            <tr>
                              <td>Наличие военной кафедры</td>
                              <td class="text-center">
                                  <span class="{{ $university->has_military_department ? 'active_option' : 'inactive_option' }}">
                                      <i class="fa fa-chevron-down"></i>
                                  </span>
                              </td>
                              <td class="text-center">
                                  <span class="{{ !$university->has_military_department ? 'active_option' : 'inactive_option' }}">
                                      <i class="fa fa-chevron-down"></i>
                                  </span>
                              </td>
                            </tr>
                            <tr>
                              <td>Наличие общежития</td>
                              <td class="text-center">
                                  <span class="{{ $university->has_hostel ? 'active_option' : 'inactive_option' }}">
                                      <i class="fa fa-chevron-down"></i>
                                  </span>
                              </td>
                              <td class="text-center">
                                  <span class="{{ !$university->has_hostel ? 'active_option' : 'inactive_option' }}">
                                      <i class="fa fa-chevron-down"></i>
                                  </span>
                              </td>
                            </tr>
                            <tr>
                              <td>Дистанционное обучение</td>
                              <td class="text-center">
                                  <span class="{{ $university->distance_learning ? 'active_option' : 'inactive_option' }}">
                                      <i class="fa fa-chevron-down"></i>
                                  </span>
                              </td>
                              <td class="text-center">
                                  <span class="{{ !$university->distance_learning ? 'active_option' : 'inactive_option' }}">
                                      <i class="fa fa-chevron-down"></i>
                                  </span>
                              </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="course" class="tab-pane fade">
                    <div class="row course__catalog">
                        @if(count($university->user->courses)) @foreach($university->user->courses as $course)
                        <div class="col-md-6">
                            <div class="external_card eq_list__item">
                                <div class="caption">
                                    <ul class="list-inline card_tag_page">
                                        <li class="tag_sticker">
                                            <span>@if(!empty(@$course->subCategory->name)) {{ @$course->subCategory->name }} @else {{ @$course->category->name }} @endif</span>
                                        </li> 
                                        @if(@Auth::check()) 
                                            @php 
                                                $favorite = in_array(Auth::user()->id, $course->userFavorite->pluck('id')->toArray()); 
                                            @endphp
                                            <li class="bookmark_tag">
                                                <i class="fa course_heart 
                                                   {{ $favorite ? 'is_favorite fa-heart' : 'fa-heart-o' }}" 
                                                   onclick="courseFavorite(this, {{ $course->id }});"  
                                                   aria-hidden="true"></i> 
                                            </li> 
                                        @endif
                                    </ul>
                                    <h3>{{ $course->name }}</h3> 
                                    <h4>
                                        @if($course->user->user_type==3) 
                                            {{ $course->user->university['full_name'] }} 
                                        @else 
                                            {{ $course->user->name }} 
                                        @endif
                                    </h4>
                                    <ul class="list-unstyled card_info">
                                        <li>
                                            Стоимость 
                                            <span> 
                                                @if($course->pay == 1) 
                                                    бесплатно 
                                                @else 
                                                    ₽{{ priceString(Course::generatePrice($course)) }} 
                                                @endif
                                            </span>
                                        </li>
                                        <li>
                                            Длительность 
                                            <span>
                                                @php
                                                    $diff = dateDiff($course->date_from, $course->date_to);
                                                @endphp 
                                                @if($diff->m)
                                                    {{ $diff->m }} {{ monthCase($diff->m) }} 
                                                @endif @if($diff->d) 
                                                    @if($diff->m) 
                                                        и 
                                                    @endif 
                                                    {{ $diff->d }} 
                                                    @php 
                                                        echo dayCase($diff->d); 
                                                    @endphp 
                                                @endif
                                            </span>
                                        </li>
                                        <li>
                                            Рейтинг 
                                            <span class="rating_star">  
                                                <select class="rating-stars" name="rating" data-readonly="true" data-current-rating="{{ floatval($course->reviews->avg('rating')) }}" autocomplete="off">
                                                  <option value="1">1</option> 
                                                  <option value="2">2</option>
                                                  <option value="3">3</option>
                                                  <option value="4">4</option>
                                                  <option value="5">5</option>
                                                </select> 
                                            </span> 
                                        </li>
                                    </ul>
                                    <ul class="list-inline card_date_info">
                                        <li class="left_date"><i class="fa fa-user"></i> {{ count($course->userRequests) }}</li> 
                                        @php 
                                            $esablishDate = Course::manager($course)->esablishDate();
                                        @endphp
                                        <li class="right_date"> 
                                            {{ $esablishDate['status'] }} @if($esablishDate['date']) {{ $esablishDate['date'] }} @endif
                                        </li> 
                                    </ul>
                                    <div class="more_card"><a href="/course/{{ $course->id }}">Подробнее</a></div>
                                </div>
                            </div>
                        </div>
                        @endforeach @else
                        <div class="col-md-12 no__data">
                            <h5>В данный момент нету курсов</h5>
                        </div>
                        @endif
                    </div>
                </div>
                <div id="teachers" class="tab-pane fade">
                      <div class="row">
                        @if(count($university->user->connectionTeachers))
                            @foreach($university->user->connectionTeachers as $teacher)
                            <div class="col-md-4">
                                <div class="teacher_card_page">
                                    <div class="teacher_image">
                                        <a href="/teacher/{{ $teacher['id'] }}/">
                                          <img class="img-responsive" src="{{ imageThumb(@$teacher->image, 'uploads/users', 400, 500, 'list') }}">
                                        </a>
                                    </div>
                                    <h3><a href="/teacher/{{ $teacher['id'] }}/">{{ $teacher['name'] }} {{ $teacher['surname'] }}</a></h3>
                                    <p>{{ implode(',', array_slice($teacher->subjects->pluck('name')->toArray(), 0, 2)) }}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="col-md-12 no__data">
                            <h5>В данный момент нету преподователей</h5>
                        </div>
                        @endif
                    </div>
                </div>
                <div id="faculties" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-12">
                            @if(count($university->faculties))
                            <table class="table faculties_table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Бюджетных мест</th>
                                        <th>Проходной балл</th>
                                        <th>Стоимость обучения</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($university->faculties as $faculty)
                                    <tr>
                                        <td>
                                            <h3>Факультет русской филологии</h3>
                                            <span> 
                                                @php $slash=''; 
                                                @endphp @if($faculty->full_time_learning)
                                                    очная 
                                                @php $slash='/'; 
                                                @endphp @endif @if($faculty->non_public_learning)
                                                    {{$slash}} заочная 
                                                @php 
                                                $slash='/'; 
                                                @endphp @endif @if($faculty->distance_learning)
                                                    {{$slash}} дистанционная
                                                @endif
                                            </span>
                                            <h4>Длительность обучения</h4> 
                                            <span>
                                                {{ $faculty->duration_learning }}
                                                @if($faculty->duration_learning == 1)
                                                    год
                                                @elseif($faculty->duration_learning > 1 && $faculty->duration_learning <= 4 )
                                                    года
                                                @else
                                                    лет
                                                @endif
                                            </span>
                                            <h4>Экзамены для поступления</h4>
                                            <span>
                                                @php 
                                                    $facultySubjects = $faculty->subjects->pluck('name')->toArray(); echo implode(', ', $facultySubjects);
                                                @endphp
                                            </span>
                                        </td>
                                        <td class="info_table"><span>{{ priceString($faculty->qty_budget) }}</span></td>
                                        <td class="info_table"><span>{{ priceString($faculty->average_nr_points) }}</span></td>
                                        <td class="info_table"><span>{{ priceString($faculty->price) }}</span> руб. в год</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <div class="no__data">
                                <h5>Нет факультетов</h5>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div id="news" class="tab-pane fade">
                    <div class="row university__news">
                        @if(count($university->news)) @foreach($university->news as $news)
                        <div class="col-md-6">
                            <div class="news_item">
                                <span class="data_news">10.10.2018</span>
                                <a href="/university/news/{{ $news->id }}">{{ $news->name }}</a>
                            </div>
                        </div>
                        @endforeach @else
                        <div class="col-md-12 no__data">
                            <h5>Нет новостей</h5>
                        </div>
                        @endif
                    </div>
                </div>
                <div id="contacts" class="tab-pane fade">
                    <table>
                        <tr>
                            <td>АДРЕС:</td>
                            <td>{{ $university->user->address }}</td>
                        </tr>
                        @if($university->user->site)
                            <tr>
                                <td>АДРЕС САЙТА:</td>
                                <td>{{ $university->user->site }}</td>
                            </tr>
                        @endif
                    </table>
                    <br>
                    <strong>КОНТАКТЫ</strong>
                    <table>
                        <tr>
                            <td>ПРИЕМНАЯ КОМИССИЯ:</td>
                            <td>{{ $university->user->phone }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="vuz_page_sidebar">
                <div class="image">
                    <img src="/public/uploads/users/{{ $university->user->avatar ? $university->user->avatar : $university->user->image }}{{'?v=' . time()}}"
                         title="Brain Incorporated | Учебное заведение {{ $university['full_name'] }} образовательного портала России и мира | Лучшие ВУЗы Москвы"
                         alt="Корпорация Мозга | Учебное заведение {{ $university['full_name'] }} образовательного портала России и мира | Лучшие ВУЗы Москвы">
                    <span class="reviews_vuz_page">
                        0 отзывов
                    </span>
                </div>
                <div class="price_box">
                    От <span>{{ priceString($university->price) }}</span> р./год
                </div>
                <div class="vuz_page_rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                </div>
                <button class="default__btn btn_study_here">ХОЧУ УЧИТЬСЯ ЗДЕСЬ</button>
            </div>
        </div>
    </div>
</div>
@stop