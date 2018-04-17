@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1>Контакты</h1>
        </div>
        <div class="col-lg-6">
            <p><strong>Комерческий отдел</strong></p>
            <ul class="list-unstyled">
                <li>
                    <a href="#"><i class="fas fa-phone"></i> +7 (495) 123-15-24</a>
                </li>
                <li>
                    <a href="#"><i class="far fa-envelope"></i> info@email.ru</a>
                </li>
            </ul>
        </div>
        <div class="col-lg-6">
            <form>
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
                <div>
                    <button type="button" class="btn btn-default submit"><i class="fa fa-paper-plane" aria-hidden="true"></i> Отправить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop