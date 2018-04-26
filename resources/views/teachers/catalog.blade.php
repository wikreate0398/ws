@extends('layouts.app')

@section('content')
    @if(false) <!-- !empty($teachers) -->
        <div class="educational_blog no__home">
            <div class="container">
                <div class="row">
                    <div class="col-lg-11">
                        <h3 style="font-weight: bold;">Преподаватели</h3>
                        <br>
                    </div>
                    <div class="col-lg-12"> 
                        <div id="teacher_carousel">
                            @foreach($teachers as $teacher)
                                <div class="col-md-2"> 
                                    <div class="item">
                                        <?php $img = !empty($teacher['image']) ? '/public/uploads/users/' . $teacher['image'] : noImg()  ?>
                                        <a href="/institution/{{ $teacher['id'] }}/" onclick="return false;" class="img__teacher" style="background-image: url({{ $img }})"></a> 
                                        <h3>{{ $teacher['name'] }} {{ $teacher['surname'] }}</h3>
                                        <!-- <p>ЕГЭ, ФИЗИКА, МАТЕМАТИКА</p> -->
                                    </div> 
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    @endif
    
    <div class="container" style="margin-top: 66px;">
        <div class="row">
            <div class="col-lg-12">
                <ul class="breadcrumb">
                    <li><a href="/">Главная</a></li>
                    <li class="active">Каталог преподавателей</li>
                </ul>
            </div>
        </div>
         
        <div class="row">
            <div class="col-lg-12">
                <h1 class="header_page">ВСЕ ПРЕПОДАВАТЕЛИ</h1>
            </div>
            <form id="search_form">
                <div class="col-lg-6 col-lg-offset-2">
                    <div class="form-group">
                        <input class="form-control" placeholder="Введите ФИО преподавателя">
                    </div>
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-primary">Начать поиск</button>
                </div>
            </form>
        </div>
        
        @if(!empty($teachers))  
        <div class="row">
            <div class="col-lg-10">
                <div class="filter_top">
                    <div class="row">
                        <div class="col-lg-4">
                            <ul class="list-inline">
                                <li><a href="">ВСЕ</a></li>
                                <li><a href="">СВОБОДЕН</a></li>
                                <li><a href="">ЗАНЯТ</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <ul class="list-inline">
                                <li>СОРТИРОВАТЬ ПО: </li>
                                <li><a href="">ПО ДАТЕ <i class="fa fa-long-arrow-down" aria-hidden="true"></i></a></li>
                                <li><a href="">ПО ОТЗЫВАМ <i class="fa fa-long-arrow-up" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <ul class="list-inline">
                                <li>ВЫВОДИТЬ ПО: </li>
                                <li><a href="">6</a></li>
                                <li><a href="">12</a></li>
                                <li><a href="">24</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                @foreach($teachers as $teacher)
                <div class="teachers_external_card">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="left_teachers_external_card">
                                <?php $img = !empty($teacher['image']) ? '/public/uploads/users/' . $teacher['image'] : noImg()  ?>
                                <a href="/institution/{{ $teacher['id'] }}/" 
                                   class="img__teacher" 
                                   onclick="return false;" 
                                   style="background-image: url({{ $img }})"></a>
                                <span>Свободен</span>
                                <a class="more_link">Подробнее</a>
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <div class="right_teachers_external_card">
                                <div class="row">
                                    <div class="col-lg-9">
                                        <h2>{{ $teacher['name'] }} <br>
                                        {{ $teacher['surname'] }} {{ $teacher['patronymic'] }} <span>38 лет, опыт работы 5 лет</span></h2>
                                        <ul class="list-inline">
                                            <li>ПОДГОТОВКА К ЕГЭ</li>
                                            <li>ВСТУПИТЕЛЬНЫЕ ЭКЗАМЕНЫ</li>
                                            <li>10-11 КЛАСС</li>
                                        </ul>
                                        <b>предметы</b>
                                        <ul class="list-inline">
                                            <li>МАТЕМАТИКА</li>
                                            <li>ФИЗИКА</li>
                                            <li>ГЕОМЕТРИЯ</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-3">
                                        <span> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </span>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="teacher_about">
                                            Являюсь постоянным участником научных конференций ЮФУ, имею собственные статьи и публикации. В работе и подготовке к экзаменам отдаю предпочтение зарубежным издательствам.
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="list-inline nav-justified type_training">
                                            <li><span><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></span>ВОЗМОЖЕН ВЫЕЗД</li>
                                            <li><span><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></span>ЗАНЯТИЯ В ГРУППЕ</li>
                                            <li><span><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></span>ИНДИВИДУАЛЬНО</li>
                                            <li><span><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></span>ОНЛАЙН</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="price_block">
                                            Стоимость<br><span>от 500Р/час</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <button class="btn">Оставить заявку</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-lg-2">
                <div class="filter_block">
                    <form action="">

                    </form>
                </div>
            </div>
        </div>

        @endif
    </div>
@stop