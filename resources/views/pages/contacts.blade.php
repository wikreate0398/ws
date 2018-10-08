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
                    127018, Российская Федерация, Москва, улица Сущёвский Вал, 5с20
                </p>
            </div>
        </div>


    </div>

    <div class="row address__section">
        <div class="col-md-3">
            <p>Телефон для связи<br> в Москве  </p>
            <strong>+7 (499) 753–45–25</strong>
        </div>
        <div class="col-md-3">
            <p>Техническая <br> поддержка</p>
            <strong>+7 (926) 078-48-52</strong>
        </div>
        <div class="col-md-3">
            <p>По вопросам<br> сотрудничества</p>
            <strong>info@brainincorporated.com</strong>
        </div>
        <div class="col-md-3">
            <p>Бухгалтерия<br> Brain Incorporated</p>
            <strong>buh@brainincorporated.com</strong>
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
                    <label>Ваше имя <span class="req">*</span></label>
                    <input type="text" name="name" class="form-control" id="" placeholder="Имя">
                </div>
                <div class="form-group">
                    <label>Email адресс</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="telephone">Номер телефона <span class="req">*</span></label>
                    <input type="tel" name="phone" class="form-control" id="telephone" placeholder="Телефон">
                </div>
                <div class="form-group">
                    <label for="description">Сообщение <span class="req">*</span></label>
                    <textarea class="form-control" id="description" name="message" placeholder="Сообщение"></textarea>
                </div>
                <div class="form__footer">
                    <small>Нажимая кнопку «Отправить», Вы принимаете условия Пользовательского соглашения и политики конфиденциальности нашего портала</small>
                    <div id="error-respond"></div>
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
            <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A2c8ad848ea8a24dcef62d361e8e27eb0a8ce3fd13c947643e231669aaf7f9214&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
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