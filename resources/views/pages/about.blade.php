@extends('layouts.app')

@section('content')
<div class="container no__home">
    <div class="row">
        <div class="col-lg-6">
            <h1>О портале</h1>
            <p>«Корпорация мозга» – самый полный в рунете путеводитель по семинарам и тренингам, образованию для детей, школьников, абитуриентов и взрослых. А также множество курсов по повышению квалификации, перепрофилированию и непрофессиональной подготовки.</p>
            <p>На одной площадке brainincorporated.ru собраны почти все русскоязычные семинары, специалисты и образовательные учреждения.</p>
            <p>«Корпорация мозга» - это высокотехнологичная площадка для анонсирования событий, которая дает возможность продвигать ваши мероприятия. «Корпорация мозга» привлекает множество преподавателей, репетиторов и учебных заведений благодаря современному дизайну, удобству и простоте использования.</p>
            <p>Если вы хотите разместить анонс вашего мероприятия на нашем сайте, вам нужно зарегистрироваться. После этого вы можете размещать любое количество мероприятий и учебных заведений. </p>
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