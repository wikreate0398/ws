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
                        <tr>
                            <td>ТЕЛЕФОН:</td>
                            <td>{{ $university->user->phone }}</td>
                        </tr>
                    </table>
                    @if($university->user->universityDepartment->count())
                        <br>
                        <strong>ОТДЕЛЫ</strong>
                        <table>
                            @foreach($university->user->universityDepartment as $department)
                                <tr>
                                    <th>{{ $department->name }}</th>
                                    <td>{{ $department->phone }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @endif

                    @if($university->placemark)
                        <div id="map"
                             data-iconCaption="{{ $university->full_name }}"
                             data-placemark="{{ $university->placemark }}"
                             style="width: 100%; height: 400px; margin-top: 20px;"></div>
                    @endif
                </div>
            </div>

            @if($university->reviews->count())
                <div class="review__container">
                    <h3>Отзывы ({{ $university->reviews->count() }})</h3>
                    <div class="reviews_items">
                        @foreach($university->reviews as $review)
                            <div class="review_item">

                                <div class="review__top_side">
                                    <div class="review__left_side">
                                        <div class="review__user_image" style="background-image: url({{ imageThumb(($review->user->avatar ? $review->user->avatar : $review->user->image), 'uploads/users', 150, 150, 'small') }})"></div>
                                        <div class="review__user_info">
                                            <div class="review__post_date">
                                                {{ date('d.m.Y H:i', strtotime($review['created_at'])) }}
                                            </div>
                                            <div class="review__user_name">
                                                {{ $review->user->name }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="stars stars-example-fontawesome">
                                        <select class="rating-stars" name="rating" data-readonly="true" data-current-rating="{{ $review['rating'] }}" autocomplete="off">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="review__message">
                                    {{ $review['review'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(Auth::check() && !in_array(Auth::user()->id, $university->reviews->pluck('id_user')->toArray()) && @Auth::user()->user_type == 1)
                <div class="review__container">
                    <button class="btn" onclick="$('.review__form').slideToggle()">Оставить Отзыв</button>
                    <div class="review__form" style="display: none;">
                        <form action="{{ route('university_review', ['id' => $university->user->id]) }}" class="ajax__submit">
                            {{ csrf_field() }}
                            <textarea name="message" placeholder="Комментарий" class="form-control"></textarea>
                            <div class="stars stars-example-fontawesome">
                                <select class="rating-stars" name="rating" autocomplete="off">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div id="error-respond"></div>
                            <button class="btn btn_save" type="submit">Добавить</button>
                        </form>
                    </div>
                </div>
            @endif

            <style>
                .review__container{
                    margin-bottom: 20px;
                    margin-top: 40px;
                }

                .title__review_section{
                    font-weight: bold !important;
                    font-size: 18px !important;
                    text-transform: uppercase;
                    color: #333 !important;
                    margin-top: 30px !important;
                    margin-bottom: 20px;
                }

                .review__form{
                    margin-top: 20px;
                }

                .review__form .btn_save{
                    margin-top: 10px;
                    float: none !important;
                }

                .stars{
                    margin-top:10px;
                }

                .review__user_image{
                    display: block;
                    border-radius: 50%;
                    width: 60px;
                    height: 60px;
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: cover;
                    background-color: #ededed;
                }

                .review_item {
                    padding: 20px;
                    -webkit-box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.349019607843137);
                    box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.349019607843137);
                    margin-bottom: 20px;
                }

                .review__post_date{
                    color: #ccc;
                    font-size: 12px;
                }

                .review__user_name{
                    font-weight: bold;
                    text-transform: uppercase;
                    font-size: 15px;
                }

                .review__left_side{
                    justify-content: flex-start;
                    display: flex;
                    align-items: center;
                }

                .review__top_side{
                    justify-content: space-between;
                    display: flex;
                    align-items: center;
                }

                .review__user_info{
                    margin-left: 10px;
                }

                .review__message{
                    margin-top: 10px;
                    font-size: 14px;
                    color: #333;
                }

            </style>

        </div>
        <div class="col-md-3">
            <div class="vuz_page_sidebar">
                <div class="image">
                    <img src="/public/uploads/users/{{ $university->user->avatar ? $university->user->avatar : $university->user->image }}{{'?v=' . time()}}"
                         title="Brain Incorporated | Учебное заведение {{ $university['full_name'] }} образовательного портала России и мира | Лучшие ВУЗы Москвы"
                         alt="Корпорация Мозга | Учебное заведение {{ $university['full_name'] }} образовательного портала России и мира | Лучшие ВУЗы Москвы">
                    <span class="reviews_vuz_page">
                        {{ $university->reviews->count() }} {{ format_by_count($university->reviews->count(), 'Отзыв', 'Отзыва', 'Отзывов') }}
                    </span>
                </div>
                <div class="price_box">
                    От <span>{{ priceString($university->price) }}</span> р./год
                </div>
                <div class="vuz_page_rating">
                    <select class="rating-stars" name="rating" data-readonly="true" data-current-rating="{{ floatval($university->reviews->avg('rating')) }}" autocomplete="off">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                </div>
                <button class="default__btn btn_study_here">ХОЧУ УЧИТЬСЯ ЗДЕСЬ</button>
            </div>
        </div>
    </div>
</div>
@stop