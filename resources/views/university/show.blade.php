@extends('layouts.app')
@section('content')
<div class="container no__home">
   <div class="row university__show">
      <div class="col-md-9">
         <div class="university__header">
            <label class="badge">
            @if($university->status == 1)
            Государственный
            @else
            Коммерческий
            @endif
            </label>
            <h1>{{ $university->full_name }}</h1>
            <p>г.{{ $university->user->cityData->name }}</p>
            <ul class="university__data_list">
               <li>
                  <strong>{{ count($university->user->courses) }}</strong>
                  КУРСОВ
               </li>
               <li>
                  <strong>10</strong>
                  ПРЕПОДАВАТЕЛЕЙ
               </li>
               <li>
                  <strong>{{ count($university->faculties) }}</strong>
                  ФАКУЛЬТЕТОВ
               </li>
               <li>
                  <strong>{{ $university->qty_budget }}</strong>
                  БЮДЖЕТНЫХ МЕСТ
               </li>
            </ul>
         </div>
         <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#general">ОБЩАЯ ИНФОРМАЦИЯ</a></li>
            <li><a data-toggle="tab" href="#course">КУРСЫ И ПРОГРАММЫ</a></li>
            <li><a data-toggle="tab" href="#teachers">ПРЕПОДАВАТЕЛИ</a></li>
            <li><a data-toggle="tab" href="#faculties">ФАКУЛЬТЕТЫ</a></li>
            <li><a data-toggle="tab" href="#news">НОВОСТИ</a></li>
            <li><a data-toggle="tab" href="#contacts">КОНТАКТЫ</a></li>
         </ul>
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
                     <td>На бюджет  <label class="badge">32</label></td>
                     <td>На платное <label class="badge">2</label></td>
                  </tr>
                  <tr>
                     <th>Наличие военной кафедры</th>
                     <td>
                        @if($university->has_military_department)
                        {!! $true  !!}
                        @else
                        {!! $false  !!}
                        @endif
                     </td>
                     <td> 
                     </td>
                  </tr>
                  <tr>
                     <th>Наличие общежития</th>
                     <td>
                        @if($university->has_hostel)
                        {!! $true  !!}
                        @else
                        {!! $false  !!}
                        @endif
                     </td>
                     <td></td>
                  </tr>
                  <tr>
                     <th>Дистанционное обучение</th>
                     <td>
                        @if($university->distance_learning)
                        {!! $true  !!}
                        @else
                        {!! $false  !!}
                        @endif
                     </td>
                     <td></td>
                  </tr>
               </table>
            </div>
            <div id="course" class="tab-pane fade">
               <div class="row">
                    @if(count($university->user->courses))
                  @foreach($university->user->courses as $course)
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
          
      </div>
   </div>
</div>
<style>
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
</style>
@stop