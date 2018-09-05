@extends('layouts.app')

@section('content')
<div class="container no__home">
    <div class="row">
        <div class="col-lg-12">
            <ul class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li><span>{{ $page->name }}</span></li>
            </ul>

            <div class="header__contact">
                <h1 class="page__title">{{ $page->name }}</h1>
                <span><i class="fa fa-map-marker" aria-hidden="true"></i> <br>АДРЕС ЦЕНТРАЛЬНОГО <br> ОФИСА</span>
                <p class="general_address">
                    119991, Российская Федерация, Москва, Ленинские горы, д. 1, Московский <br> государственный университет имени М.В.Ломоносова
                </p>
            </div>
        </div>


    </div>

    <div class="row address__section">
        <div class="col-md-3">
            <p>ТЕЛЕФОН ПО ВОПРОСАМ <br> СОТРУДНИЧЕСТВА  </p>
            <strong>8 800 123-45-67</strong>
        </div>
        <div class="col-md-3">
            <p>ТЕЛЕФОН ПО ВОПРОСАМ <br> РЕКЛАМЫ</p>
            <strong>8 800 123-45-67</strong>
        </div>
        <div class="col-md-3">
            <p>E-MAIL ПО ВОПРОСАМ <br> СОТРУДНИЧЕСТВА</p>
            <strong>info@yandex.ru</strong>
        </div>
        <div class="col-md-3">
            <p>E-MAIL <br> ОТДЕЛА РЕКЛАМЫ</p>
            <strong>info@yandex.ru</strong>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="btn__feedback">
                <a href="" class="btn btn2" onclick="$('.feedback_form').toggleClass('show'); return false;">Обратная связь</a>
            </div>
        </div>

        <div class="col-md-6 col-md-offset-3 feedback_form" style="display: none;">
            <form class="ajax__submit" method="POST" action="/contacts">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Ваше имя</label>
                    <input type="text" class="form-control" id="" placeholder="Имя">
                </div>
                <div class="form-group">
                    <label>Email адресс</label>
                    <input type="email" class="form-control" id="exampleInputEmail" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="telephone">Номер телефона</label>
                    <input type="tel" class="form-control" id="telephone" placeholder="Телефон">
                </div>
                <div class="form-group">
                    <label for="description">Сообщение</label>
                    <textarea class="form-control" id="description" placeholder="Сообщение"></textarea>
                </div>
                <div class="form__footer">
                    <small>Нажимая кнопку «Отправить», Вы принимаете условия Пользовательского соглашения и политики конфиденциальности нашего портала</small>

                    <button type="submit" class="btn btn2" style="width: auto;">
                        Отправить
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row contact__map">
        <div class="col-md-12">
            <h2 class="page__title">МЫ НА КАРТЕ</h2>
            <iframe id="u5458_input" scrolling="auto" frameborder="1" webkitallowfullscreen mozallowfullscreen allowfullscreen src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3179.507210366911!2d37.529724895772674!3d55.70200681261701!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54c6435a66743%3A0xfae7174706dad052!2z0JzQvtGB0LrQvtCy0YHQutC40Lkg0LPQvtGB0YPQtNCw0YDRgdGC0LLQtdC90L3Ri9C5INGD0L3QuNCy0LXRgNGB0LjRgtC10YIg0LjQvNC10L3QuCDQnC7Qki7Qm9C-0LzQvtC90L7RgdC-0LLQsA!5e0!3m2!1sru!2sua!4v1536078247798"></iframe>

        </div>
    </div>

    <style>
        .page__title{
            font-weight: bold;
            text-align: center;
            margin-top: 40px;
            margin-bottom: 30px;
        }
        .contact__map{

        }
        .contact__map iframe{
            width: 100% !important;
            height: 400px;
        }
        .feedback_form{
            margin-top: 20px;
        }
        .feedback_form form{
            background: #fafafa;
            border: 1px solid #ededed;
            padding: 20px;
        }

        .feedback_form form small{
            display: block;
        }

        .feedback_form form label{
            text-transform: uppercase;
            font-size: 12px;
        }

        .feedback_form.show{
            display:block !important;
        }
        
        .form__footer{
            text-align: center;
        }

        .form__footer .btn{
            margin-top: 10px;
        }

        .header__contact{
            text-align: center;
        }

        .header__contact span i{
            font-size: 30px;
        }

        .header__contact p.general_address{
            font-weight: bold;
            margin-top: 10px;
        }

        .address__section{
            margin-top: 20px;
        }

        .address__section strong{
            font-size: 18px;
        }

        .address__section p{
            font-size: 14px;
        }
        
        .btn__feedback {
            text-align: center;
            margin-top: 40px;
        }

        .btn__feedback a{
            font-size: 18px;
        }
    </style>

</div>
@stop