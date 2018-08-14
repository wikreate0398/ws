@extends('layouts.app')
@section('content')
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
            <li class="bookmark_tag">
                <i class="fa fa-bookmark-o" onclick="courseFavorite(this, 6);" aria-hidden="true"></i> 
            </li> 
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
               <p>{{ $university->user->about }}</p>
               <br>
               @php
               $true = '<i class="fa fa-check-circle" aria-hidden="true"></i>';
               $false = '<i class="fa fa-times-circle" aria-hidden="true"></i>';
               @endphp
               <table class="univ__tbl">
                  <tr>
                     <th>Средний балл ЕГЭ</th>
                     <td>На бюджет  <label class="badge">{{ $university->budget_points_admission }}</label></td>
                     <td>На платное <label class="badge">{{ $university->payable_points_admission }}</label></td>
                  </tr>
                  <tr>
                      <th>Наличие военной кафедры</th>
                      <td> 
                        <i class="fa fa-check-circle {{ $university->has_military_department ? 'active__icon' : 'inactive__icon' }}" aria-hidden="true"></i>
                      </td>
                      <td> 
                        <i class="fa fa-times-circle {{ !$university->has_military_department ? 'active__icon' : 'inactive__icon' }}" aria-hidden="true"></i>
                      </td>
                  </tr>
                  <tr>
                     <th>Наличие общежития</th>
                     <td> 
                        <i class="fa fa-check-circle {{ $university->has_hostel ? 'active__icon' : 'inactive__icon' }}" aria-hidden="true"></i>
                     </td>
                      <td>
                        <i class="fa fa-times-circle {{ !$university->has_hostel ? 'active__icon' : 'inactive__icon' }}" aria-hidden="true"></i>
                      </td>
                  </tr>
                  <tr>
                     <th>Дистанционное обучение</th>
                     <td>  
                        <i class="fa fa-check-circle {{ $university->distance_learning ? 'active__icon' : 'inactive__icon' }}" aria-hidden="true"></i>
                      </td>
                      <td>
                        <i class="fa fa-times-circle {{ !$university->distance_learning ? 'active__icon' : 'inactive__icon' }}" aria-hidden="true"></i>
                      </td>
                  </tr>
               </table>
            </div>
            <div id="course" class="tab-pane fade">
               <div class="row course__catalog">
                    @if(count($university->user->courses))
                  @foreach($university->user->courses as $course)
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
                          <div class="course_item_stars" >
                              <select class="rating-stars" name="rating" data-readonly="true" data-current-rating="{{ floatval($course->reviews->avg('rating')) }}" autocomplete="off">
                                <option value="1">1</option> 
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                              </select> 
                          </div>  
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
                  @else
                    <div class="col-md-12 no__data"> 
                        <h5>Нет курсов</h5>
                    </div>
                  @endif
               </div>
            </div>
            <div id="teachers" class="tab-pane fade">
                <div class="col-md-12 no__data"> 
                    <h5>Нет преподов</h5>
                </div>
            </div>
            <div id="faculties" class="tab-pane fade">
               <div class="row">
                <div class="col-md-12"> 
                    <style>
                        .faculties__table{
                            width: 100%;
                        }

                        .faculties__table tr th{
                            font-size: 12px;
                            font-weight: 300 !important;
                        }

                        .faculties__table tr td strong{
                            display: block;
                            font-size: 16px;
                        }

                        .faculties__table tr td b{ 
                            font-size: 20px; 
                        }

                        .faculties__table tr td, .faculties__table tr{
                            vertical-align: middle !important;
                        }

                        .faculties__table tr td.price__faculty{
                            font-size: 14px;
                        }
                    </style>
                    @if(count($university->faculties))
                        <table class="table faculties__table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>БЮДЖЕТНЫХ МЕСТ</th>
                                    <th>ПРОХОДНОЙ БАЛЛ</th>
                                    <th>СТОИМОСТЬ ОБУЧЕНИЯ</th>
                                </tr>
                            </thead>
                            <tbody> 
                                @foreach($university->faculties as $faculty)
                                    <tr>
                                        <td>
                                            <strong>Факультет русской филологии</strong>
                                            @php $slash=''; @endphp
                                            @if($faculty->full_time_learning)очная @php $slash='/'; @endphp @endif
                                            @if($faculty->non_public_learning){{$slash}}заочная @php $slash='/'; @endphp @endif
                                            @if($faculty->distance_learning){{$slash}}дистанционная@endif 

                                            <strong style="margin-top: 10px;">Длительность обучения</strong>
                                                {{ $faculty->duration_learning }}
                                                @if($faculty->duration_learning == 1) 
                                                    год
                                                @elseif($faculty->duration_learning > 1 && $faculty->duration_learning <= 4)
                                                    года
                                                @else
                                                лет
                                                @endif
                                              
                                            <strong style="margin-top: 10px;">Экзамены для поступления</strong>
                                            @php
                                               $facultySubjects = $faculty->subjects->pluck('name')->toArray();
                                               echo implode(', ', $facultySubjects);
                                            @endphp
                                        </td>
                                        <td><b>{{ priceString($faculty->qty_budget) }}</b></td>
                                        <td><b>{{ priceString($faculty->average_nr_points) }}</b></td>
                                        <td class="price__faculty"><b>{{ priceString($faculty->price) }}</b> руб. в год</td>
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
                    @if(count($university->news))
                        @foreach($university->news as $news)
                        <div class="col-md-4">
                            <a href="/university/news/{{ $news->id }}">{{ $news->name }}</a>
                        </div>
                        @endforeach
                    @else
                        <div class="col-md-12 no__data"> 
                            <h5>Нет новостей</h5>
                        </div>
                    @endif
               </div>
            </div>
            <div id="contacts" class="tab-pane fade">
               
            </div>
         </div>
      </div>
      <div class="col-md-3">
          <div class="vuz__card_sidebar">
            <div class="vuz__logo" style="background-image: url(/public/uploads/users/{{ $university->user->avatar ? $university->user->avatar : $university->user->image }}{{'?v=' . time()}});)"> 
            </div>
            <div class="vuz__price_box">
              <small>От</small>
              <span class="vuz_price">
                {{ priceString($university->price) }}
              </span>
              <small>р./год</small>
              <button class="default__btn btn_study_here">ХОЧУ УЧИТЬСЯ ЗДЕСЬ</button>
              <i class="fa fa-star" aria-hidden="true"></i>
              <i class="fa fa-star" aria-hidden="true"></i>
              <i class="fa fa-star" aria-hidden="true"></i>
              <i class="fa fa-star" aria-hidden="true"></i>
              <sup>4.5</sup>
              <a href="" class="vuz__review_link">15 отзывов</a>
            </div>
          </div>
      </div>
   </div>
</div>
<style>

.vuz__card_sidebar{
  text-align: center;
  background: rgba(242, 242, 242, 1);
  padding: 20px;
}

.vuz__logo{
  width: 100%;
  padding-bottom: 100%;
  background-color: #ccc;
  margin-bottom: 20px;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
}

.vuz_price{
  font-size: 30px;
}

.vuz__price_box small{
  color: #999999;
}

.vuz__review_link{
  display: block;
}

      .default__btn{
          width: 100%; 
          color: #fff;
          text-transform: uppercase;
          border-radius: 20px;
          padding:10px 0;
          border:none;
          outline: none;
          font-size: 13px;
          margin-bottom: 10px;
          display: inline-block;
          text-align: center;
          text-decoration: none;
       }

       .default__btn.btn_study_here{
          background-color: rgba(153, 153, 204, 1);
          font-weight: bold;
          margin: 10px 0;
       }

    .university__news a{
        color: #333;
        text-decoration:underline;
    }
   .university__show .nav-tabs{
   margin-top: 50px;
   }
   .university__show .tab-pane{
   padding-top: 30px;
   }
   .university__show .nav-tabs>li>a{ 
   font-size: 13px;
   }
   .univ__tbl {
   width: 100%;
   }
   .university__header{
   text-align: center;
   }
   .university__data_list{
   display: flex;
   justify-content: center;
   align-items: center;
   list-style: none;
   margin-top: 30px;
   }
   .university__data_list li{
   text-align: center;  
   font-size: 12px;
   padding:0 20px;
   border-left: 1px solid #8a8a8a;
   }
   .university__data_list li:first-child{
   border-left:0;
   }
   .university__data_list li strong{
   font-size: 40px;
   display: block;
   }

   .active__icon{
    color: #aa51b5;
   }

    .inactive__icon{
    color: #ccc;
   }
</style>
@stop