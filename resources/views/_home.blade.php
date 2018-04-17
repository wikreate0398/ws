@extends('layouts.app')

@section('content')
<div class="grey_block category_block">
    <div class="container">
        <div class="row">
            <div class="col-lg-11 col-lg-offset-1">
                <div class="header_block_bg">
                    <h3></h3>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="category_block_item">
                    <div class="category_block_item_header children">
                        <img src="/images/children.png" alt=""> <span>Детям</span>
                    </div>
                    <ul class="list-unstyled categoty_list">
                        <li>
                            <a href="#">Ясли-сад</a>
                        </li>
                        <li>
                            <a href="#">Детский сад</a>
                        </li>
                        <li>
                            <a href="#">Детский сад компенсирующего вида</a>
                        </li>
                        <li>
                            <a href="#">Детский сад комбинированного вида</a>
                        </li>
                        <li>
                            <a href="#">Центр развития ребенка</a>
                        </li>
                        <li>
                            <a href="#">Школа</a>
                        </li>
                        <li>
                            <a href="#">Лицей</a>
                        </li>
                        <li>
                            <a href="#">Гимназия</a>
                        </li>
                        <li>
                            <a href="#">Иностранные языки</a>
                        </li>
                        <li>
                            <a href="#">Секции</a>
                        </li>
                        <li>
                            <a href="#">Кружки по интересам</a>
                        </li>
                        <li>
                            <a href="#">Лагеря</a>
                        </li>
                        <li>
                            <a href="#">Дни открытых дверей</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="category_block_item">
                    <div class="category_block_item_header">
                        <img src="/images/applicants.png" alt=""> <span>Абитуриентам</span>
                    </div>
                    <ul class="list-unstyled categoty_list">
                        <li>
                            <a href="#">Ясли-сад</a>
                        </li>
                        <li>
                            <a href="#">Детский сад</a>
                        </li>
                        <li>
                            <a href="#">Детский сад компенсирующего вида</a>
                        </li>
                        <li>
                            <a href="#">Детский сад комбинированного вида</a>
                        </li>
                        <li>
                            <a href="#">Центр развития ребенка</a>
                        </li>
                        <li>
                            <a href="#">Школа</a>
                        </li>
                        <li>
                            <a href="#">Лицей</a>
                        </li>
                        <li>
                            <a href="#">Гимназия</a>
                        </li>
                        <li>
                            <a href="#">Иностранные языки</a>
                        </li>
                        <li>
                            <a href="#">Секции</a>
                        </li>
                        <li>
                            <a href="#">Кружки по интересам</a>
                        </li>
                        <li>
                            <a href="#">Лагеря</a>
                        </li>
                        <li>
                            <a href="#">Дни открытых дверей</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="category_block_item">
                    <div class="category_block_item_header">
                        <img src="/images/adults.png" alt=""> <span>Взрослым</span>
                    </div>
                    <ul class="list-unstyled categoty_list">
                        <li>
                            <a href="#">Ясли-сад</a>
                        </li>
                        <li>
                            <a href="#">Детский сад</a>
                        </li>
                        <li>
                            <a href="#">Детский сад компенсирующего вида</a>
                        </li>
                        <li>
                            <a href="#">Детский сад комбинированного вида</a>
                        </li>
                        <li>
                            <a href="#">Центр развития ребенка</a>
                        </li>
                        <li>
                            <a href="#">Школа</a>
                        </li>
                        <li>
                            <a href="#">Лицей</a>
                        </li>
                        <li>
                            <a href="#">Гимназия</a>
                        </li>
                        <li>
                            <a href="#">Иностранные языки</a>
                        </li>
                        <li>
                            <a href="#">Секции</a>
                        </li>
                        <li>
                            <a href="#">Кружки по интересам</a>
                        </li>
                        <li>
                            <a href="#">Лагеря</a>
                        </li>
                        <li>
                            <a href="#">Дни открытых дверей</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="search_lessons">
                    <h4>Быстрый поиск уроков</h4>
                    <h5>*Таблица всех уроков и мероприятий</h5>
                    <form>
                        <div class="form-group">
                            <label>Вид образования</label>
                            <select class="form-control">
                                <option>Тренинг</option>
                                <option>Курсы</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Специализация</label>
                            <select class="form-control">
                                <option>Дизайн</option>
                                <option>Програмирование</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Страна</label>
                            <select class="form-control">
                                <option>Россия</option>
                                <option>Франция</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Город</label>
                            <select class="form-control">
                                <option>Москва</option>
                                <option>Санкт-Петербург</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Поиск</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="upcoming_events">
    <div class="container">
        <div class="row">
            <div class="col-lg-11 col-lg-offset-1">
                <div class="header_block_bg">
                    <h3>Ближайшие события</h3>
                </div>
            </div>
            <div class="col-lg-9">
                <ul class="nav nav-tabs nav-justified upcoming_events_nav" role="tablist">
                    <li class="active">
                        <a class="nav-link active" data-toggle="tab" href="#courses" role="tab">
                            <img src="/images/courses_icon.png" alt=""> <span>Курсы</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" data-toggle="tab" href="#trainings" role="tab">
                            <img src="/images/trainings_icon.png" alt=""> <span>Тренинги</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" data-toggle="tab" href="#foreign_language" role="tab">
                            <img src="/images/foreign_language_icon.png" alt=""> <span>Иностранные языки</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" data-toggle="tab" href="#development_children" role="tab">
                            <img src="/images/development_children_icon.png" alt=""> <span>Развитие детей</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" data-toggle="tab" href="#open_day" role="tab">
                            <img src="/images/open_day_icon.png" alt=""> <span>Дни открытых дверей</span>
                        </a>
                    </li>
                </ul>
                <div class="row">
                    <div class="tab-content">
                        <div class="tab-pane active" id="courses" role="tabpanel">
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="trainings" role="tabpanel">
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="foreign_language" role="tabpanel">
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="development_children" role="tabpanel">
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="open_day" role="tabpanel">
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="upcoming_events_item">
                                    <div class="list_upcoming_events pull-left">
                                        <ul class="list-unstyled list_upcoming_events_item">
                                            <li class="date_upcoming_events">
                                                <span>10</span> февраля
                                            </li>
                                            <li class="authentication_upcoming_events">
                                                <img src="/images/proxy_authentication.png" alt="">
                                            </li>
                                            <li class="time_upcoming_events">
                                                пятница<br>19.00
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="upcoming_events_item_img pull-left">
                                        <img src="/images/upcoming_events_item_foto.png" alt="">
                                    </div>
                                    <div class="upcoming_events_item_desc">
                                        <h2>Начало регулярного курса "Мощный бухгалтер"</h2>
                                        <hr>
                                        <ul class="list-inline upcoming_events_list_desc">
                                            <li class="pull-left"><span>От кого:</span> 1С студия</li>
                                            <li><span>Длительность:</span> 5 недель</li>
                                        </ul>
                                        <div class="upcoming_events_item_desc_text">
                                            <span>Описание:</span> В данный курс входят все известные практики бухгалтерского искусства. Все, что Вы хотели узнать о бухгалтерии, сможете сделать это здесь.
                                        </div>
                                        <table class="table upcoming_events_item_price_block">
                                            <tbody>
                                            <tr>
                                                <td class="upcoming_events_item_desc_advanced">
                                                    <span>Преимущества:</span> 70% скидка, подарок, сертификат, реальное общение
                                                </td>
                                                <td class="upcoming_events_item_desc_price">
                                                    <span>Цена:</span>
                                                    <span class="price_block">21 999 руб</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="about_portal_subscription">
                    <h4>*Весь календарь событий</h4>
                    <img src="/images/upcoming_events_banner.png" alt="">
                    <img src="/images/upcoming_events_banner_2.png" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="grey_block awards_week">
    <div class="container">
        <div class="row">
            <div class="col-lg-11 col-lg-offset-1">
                <div class="header_block_bg">
                    <h3>Награды недели</h3>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 item_awards_week">
                <div class="item_awards_week_desc">
                    <div class="item_awards_week_desc_image">
                        <img src="/images/awards_week.png" alt="">
                    </div>
                    <div class="item_awards_week_desc_name">
                        <h4>Московский Государственный Университет</h4>
                    </div>
                    <div class="item_awards_week_desc_award">
                        <table class="table">
                            <tr>
                                <td>
                                    <h5>
                                        <span>Награда:</span> ЗЕЛЕНЫЙ ПРОРЫВ
                                    </h5>
                                </td>
                                <td class="item_awards_week_desc_award_emblem">
                                    <img src="/images/emblem_award.png" alt="">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <hr>
                    <div class="item_awards_week_desc_text">
                        Ботанический сад МГУ "Аптекарский город" просит проявить "экологическую ответственность" и не дарить букеты на 14 февраля и 8 марта. Срезанные цветы можно заменить на живые в горшках, рассказали в пресс-службе сада.
                    </div>
                    <div class="item_awards_week_desc_more">
                        <a href="#">Подробнее</a>
                    </div>
                    <hr>
                    <div class="item_awards_week_desc_will_share">
                        <ul class="list-inline">
                            <li class="pull-left">Поделиться</li>
                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fab fa-vk"></i></a></li>
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 item_awards_week">
                <div class="item_awards_week_desc">
                    <div class="item_awards_week_desc_image">
                        <img src="/images/awards_week.png" alt="">
                    </div>
                    <div class="item_awards_week_desc_name">
                        <h4>Московский Государственный Университет</h4>
                    </div>
                    <div class="item_awards_week_desc_award">
                        <table class="table">
                            <tr>
                                <td>
                                    <h5>
                                        <span>Награда:</span> ЗЕЛЕНЫЙ ПРОРЫВ
                                    </h5>
                                </td>
                                <td class="item_awards_week_desc_award_emblem">
                                    <img src="/images/emblem_award.png" alt="">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <hr>
                    <div class="item_awards_week_desc_text">
                        Ботанический сад МГУ "Аптекарский город" просит проявить "экологическую ответственность" и не дарить букеты на 14 февраля и 8 марта. Срезанные цветы можно заменить на живые в горшках, рассказали в пресс-службе сада.
                    </div>
                    <div class="item_awards_week_desc_more">
                        <a href="#">Подробнее</a>
                    </div>
                    <hr>
                    <div class="item_awards_week_desc_will_share">
                        <ul class="list-inline">
                            <li class="pull-left">Поделиться</li>
                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fab fa-vk"></i></a></li>
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 item_awards_week">
                <div class="item_awards_week_desc">
                    <div class="item_awards_week_desc_image">
                        <img src="/images/awards_week.png" alt="">
                    </div>
                    <div class="item_awards_week_desc_name">
                        <h4>Московский Государственный Университет</h4>
                    </div>
                    <div class="item_awards_week_desc_award">
                        <table class="table">
                            <tr>
                                <td>
                                    <h5>
                                        <span>Награда:</span> ЗЕЛЕНЫЙ ПРОРЫВ
                                    </h5>
                                </td>
                                <td class="item_awards_week_desc_award_emblem">
                                    <img src="/images/emblem_award.png" alt="">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <hr>
                    <div class="item_awards_week_desc_text">
                        Ботанический сад МГУ "Аптекарский город" просит проявить "экологическую ответственность" и не дарить букеты на 14 февраля и 8 марта. Срезанные цветы можно заменить на живые в горшках, рассказали в пресс-службе сада.
                    </div>
                    <div class="item_awards_week_desc_more">
                        <a href="#">Подробнее</a>
                    </div>
                    <hr>
                    <div class="item_awards_week_desc_will_share">
                        <ul class="list-inline">
                            <li class="pull-left">Поделиться</li>
                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fab fa-vk"></i></a></li>
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="rating_educational_institutions">
    <div class="container">
        <div class="row">
            <div class="col-lg-11 col-lg-offset-1">
                <div class="header_block_bg">
                    <h3>Рейтинг учебных заведений</h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 item_rating_educational_institutions">
                <div class="rating_educational_institutions_desc">
                    <div class="rating_educational_institutions_name">
                        <h4>ВУЗы</h4>
                    </div>
                    <div class="rating_educational_institutions_list">
                        <ol class="list-unstyled">
                            <li class="top_one"><img src="/images/rating_educational_institutions.png" alt=""> 1. МГУ имени М.В. Ломоносова</li>
                            <li>2. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>3. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>4. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>5. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>6. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>7. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>8. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>9. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>10. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                        </ol>
                    </div>
                    <div class="criteria_for_evaluation">
                        <a href="#">Критерии оценки</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 item_rating_educational_institutions">
                <div class="rating_educational_institutions_desc">
                    <div class="rating_educational_institutions_name">
                        <h4>Колледжи</h4>
                    </div>
                    <div class="rating_educational_institutions_list">
                        <ol class="list-unstyled">
                            <li class="top_one"><img src="/images/rating_educational_institutions.png" alt=""> 1. МГУ имени М.В. Ломоносова</li>
                            <li>2. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>3. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>4. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>5. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>6. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>7. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>8. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>9. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>10. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                        </ol>
                    </div>
                    <div class="criteria_for_evaluation">
                        <a href="#">Критерии оценки</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 item_rating_educational_institutions">
                <div class="rating_educational_institutions_desc">
                    <div class="rating_educational_institutions_name">
                        <h4>Курсы английского</h4>
                    </div>
                    <div class="rating_educational_institutions_list">
                        <ol class="list-unstyled">
                            <li class="top_one"><img src="/images/rating_educational_institutions.png" alt=""> 1. МГУ имени М.В. Ломоносова</li>
                            <li>2. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>3. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>4. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>5. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>6. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>7. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>8. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>9. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>10. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                        </ol>
                    </div>
                    <div class="criteria_for_evaluation">
                        <a href="#">Критерии оценки</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 item_rating_educational_institutions">
                <div class="rating_educational_institutions_desc">
                    <div class="rating_educational_institutions_name">
                        <h4>Центры развития детей</h4>
                    </div>
                    <div class="rating_educational_institutions_list">
                        <ol class="list-unstyled">
                            <li class="top_one"><img src="/images/rating_educational_institutions.png" alt=""> 1. МГУ имени М.В. Ломоносова</li>
                            <li>2. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>3. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>4. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>5. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>6. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>7. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>8. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>9. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>10. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                        </ol>
                    </div>
                    <div class="criteria_for_evaluation">
                        <a href="#">Критерии оценки</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 item_rating_educational_institutions">
                <div class="rating_educational_institutions_desc">
                    <div class="rating_educational_institutions_name">
                        <h4>Заочное обучение</h4>
                    </div>
                    <div class="rating_educational_institutions_list">
                        <ol class="list-unstyled">
                            <li class="top_one"><img src="/images/rating_educational_institutions.png" alt=""> 1. МГУ имени М.В. Ломоносова</li>
                            <li>2. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>3. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>4. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>5. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>6. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>7. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>8. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>9. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>10. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                        </ol>
                    </div>
                    <div class="criteria_for_evaluation">
                        <a href="#">Критерии оценки</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 item_rating_educational_institutions">
                <div class="rating_educational_institutions_desc">
                    <div class="rating_educational_institutions_name">
                        <h4>Специальности</h4>
                    </div>
                    <div class="rating_educational_institutions_list">
                        <ol class="list-unstyled">
                            <li class="top_one"><img src="/images/rating_educational_institutions.png" alt=""> 1. МГУ имени М.В. Ломоносова</li>
                            <li>2. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>3. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>4. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>5. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>6. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>7. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>8. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>9. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                            <li>10. <img src="/images/rating_educational_institutions_2.png" alt=""> МГУ имени М.В. Ломоносова</li>
                        </ol>
                    </div>
                    <div class="criteria_for_evaluation">
                        <a href="#">Критерии оценки</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div id="slider_university" class="owl-carousel owl-theme">
                <div class="item">
                    <img src="/images/univer.png" alt="">
                    <div class="col-lg-5 description_item_university">
                        <h3>Московский государственный университет имени М.В.Ломоносова</h3>
                        <hr>
                        <div class="item_date_of_foundation">
                            <span>Дата основания:</span> 25 января 1755 г.
                        </div>
                        <div class="item_graduates">
                            <div class="row">
                                <div class="col-lg-4">
                                    <span>Выпускники:</span>
                                </div>
                                <div class="col-lg-8">
                                    <ul class="list-unstyled">
                                        <li>- Антон Чехов</li>
                                        <li>- Михаил Горбачев</li>
                                        <li>- Андрей Сахаров</li>
                                        <li>- Иван Тургенев</li>
                                        <li>- Борис Пастернак</li>
                                        <li>- Александр Грибоедов</li>
                                        <li>- Михаил Лермонтов</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <ul class="list-inline item_more">
                            <li class="pull-left"><a href="#">Мировое признание</a></li>
                            <li class="pull-right"><a href="#">Подробнее</a></li>
                        </ul>
                    </div>
                </div>
                <div class="item">
                    <img src="/images/univer.png" alt="">
                    <div class="col-lg-5 description_item_university">
                        <h3>Московский государственный университет имени М.В.Ломоносова</h3>
                        <hr>
                        <div class="item_date_of_foundation">
                            <span>Дата основания:</span> 25 января 1755 г.
                        </div>
                        <div class="item_graduates">
                            <div class="row">
                                <div class="col-lg-4">
                                    <span>Выпускники:</span>
                                </div>
                                <div class="col-lg-8">
                                    <ul class="list-unstyled">
                                        <li>- Антон Чехов</li>
                                        <li>- Михаил Горбачев</li>
                                        <li>- Андрей Сахаров</li>
                                        <li>- Иван Тургенев</li>
                                        <li>- Борис Пастернак</li>
                                        <li>- Александр Грибоедов</li>
                                        <li>- Михаил Лермонтов</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <ul class="list-inline item_more">
                            <li class="pull-left"><a href="#">Мировое признание</a></li>
                            <li class="pull-right"><a href="#">Подробнее</a></li>
                        </ul>
                    </div>
                </div>
                <div class="item">
                    <img src="/images/univer.png" alt="">
                    <div class="col-lg-5 description_item_university">
                        <h3>Московский государственный университет имени М.В.Ломоносова</h3>
                        <hr>
                        <div class="item_date_of_foundation">
                            <span>Дата основания:</span> 25 января 1755 г.
                        </div>
                        <div class="item_graduates">
                            <div class="row">
                                <div class="col-lg-4">
                                    <span>Выпускники:</span>
                                </div>
                                <div class="col-lg-8">
                                    <ul class="list-unstyled">
                                        <li>- Антон Чехов</li>
                                        <li>- Михаил Горбачев</li>
                                        <li>- Андрей Сахаров</li>
                                        <li>- Иван Тургенев</li>
                                        <li>- Борис Пастернак</li>
                                        <li>- Александр Грибоедов</li>
                                        <li>- Михаил Лермонтов</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <ul class="list-inline item_more">
                            <li class="pull-left"><a href="#">Мировое признание</a></li>
                            <li class="pull-right"><a href="#">Подробнее</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="grey_block educational_blog">
    <div class="container">
        <div class="row">
            <div class="col-lg-11 col-lg-offset-1">
                <div class="header_block_bg">
                    <h3>Образовательный блог</h3>
                </div>
            </div>
            <div class="col-lg-12">
                <div id="slider_educational_blog" class="owl-carousel owl-theme">
                    <div class="item">
                        <div class="educational_blog_desc">
                            <div class="educational_blog_image">
                                <img src="/images/news.png" alt="">
                            </div>
                            <div class="educational_blog_name">
                                <h4>Сергей Глазьев: "В МГУ нас приучили к работе"</h4>
                            </div>
                            <hr>
                            <div class="educational_blog_text">
                                Нам все время говорили, что, если мы хотим стать действительно кем-то, то должны начинать работать уже сейчас, уже в университете. Я усвоил это хорошо, только благодаря этому я являюсь тем, кто есть...
                            </div>
                            <div class="educational_blog_more text-right">
                                <a href="#">Подробнее</a>
                            </div>
                            <hr>
                            <div class="educational_blog_will_share">
                                <ul class="list-inline">
                                    <li class="pull-left">Поделиться</li>
                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fab fa-vk"></i></a></li>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="educational_blog_desc">
                            <div class="educational_blog_image">
                                <img src="/images/news.png" alt="">
                            </div>
                            <div class="educational_blog_name">
                                <h4>Сергей Глазьев: "В МГУ нас приучили к работе"</h4>
                            </div>
                            <hr>
                            <div class="educational_blog_text">
                                Нам все время говорили, что, если мы хотим стать действительно кем-то, то должны начинать работать уже сейчас, уже в университете. Я усвоил это хорошо, только благодаря этому я являюсь тем, кто есть...
                            </div>
                            <div class="educational_blog_more text-right">
                                <a href="#">Подробнее</a>
                            </div>
                            <hr>
                            <div class="educational_blog_will_share">
                                <ul class="list-inline">
                                    <li class="pull-left">Поделиться</li>
                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fab fa-vk"></i></a></li>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="educational_blog_desc">
                            <div class="educational_blog_image">
                                <img src="/images/news.png" alt="">
                            </div>
                            <div class="educational_blog_name">
                                <h4>Сергей Глазьев: "В МГУ нас приучили к работе"</h4>
                            </div>
                            <hr>
                            <div class="educational_blog_text">
                                Нам все время говорили, что, если мы хотим стать действительно кем-то, то должны начинать работать уже сейчас, уже в университете. Я усвоил это хорошо, только благодаря этому я являюсь тем, кто есть...
                            </div>
                            <div class="educational_blog_more text-right">
                                <a href="#">Подробнее</a>
                            </div>
                            <hr>
                            <div class="educational_blog_will_share">
                                <ul class="list-inline">
                                    <li class="pull-left">Поделиться</li>
                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fab fa-vk"></i></a></li>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="educational_blog_desc">
                            <div class="educational_blog_image">
                                <img src="/images/news.png" alt="">
                            </div>
                            <div class="educational_blog_name">
                                <h4>Сергей Глазьев: "В МГУ нас приучили к работе"</h4>
                            </div>
                            <hr>
                            <div class="educational_blog_text">
                                Нам все время говорили, что, если мы хотим стать действительно кем-то, то должны начинать работать уже сейчас, уже в университете. Я усвоил это хорошо, только благодаря этому я являюсь тем, кто есть...
                            </div>
                            <div class="educational_blog_more text-right">
                                <a href="#">Подробнее</a>
                            </div>
                            <hr>
                            <div class="educational_blog_will_share">
                                <ul class="list-inline">
                                    <li class="pull-left">Поделиться</li>
                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fab fa-vk"></i></a></li>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
<div class="about_portal">
    <div class="container">
        <div class="row">
            <div class="col-lg-11 col-lg-offset-1">
                <div class="header_block_bg">
                    <h3>О нашем портале образования</h3>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="about_portal_advantages">
                            <img src="/images/latest_information.png" alt=""> Свежая информация
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="about_portal_advantages">
                            <img src="/images/complete_information.png" alt=""> Полная информация
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="about_portal_advantages">
                            <img src="/images/available_information.png" alt=""> Доступная информация
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <p>Ищете где получить качественное образование в Москве, России или за рубежом? На Учёбе.ру мы собрали для вас всю нужную информацию о среднем, профессиональном, высшем и бизнес-образовании. В нашем каталоге представлены все школы, колледжи, вузы и другие учебные заведения, образовательные программы и инструменты для их поиска и сравнения.</p>
                        <p>Вы можете выбрать интересующую вас специальность, сравнить программы государственного и частного образования, узнать стоимость обучения и условия поступления, ознакомиться с вариантами дистанционного или заочного обучения, выбрать куда можно пойти учиться после 9 или 11 классов и многое другое.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="about_portal_subscription">
                    <h4>Подпишитесь на нашу email-рассылку</h4>
                    <form>
                        <div class="form-group">
                            <label>Город</label>
                            <input type="text" class="form-control" placeholder="Город">
                        </div>
                        <div class="form-group">
                            <label>Имя</label>
                            <input type="text" class="form-control" placeholder="Имя">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Подписаться</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop