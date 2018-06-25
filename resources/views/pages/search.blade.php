@extends('layouts.app')

@section('content')
<div class="container no__home">
    <div class="row">

        <div class="col-md-12" style="margin-bottom: 30px;"> 
            <form class="no_home teacher__search_form" id="search_form" action="/search" method="Get" data-url-autocomplete="/autocomplete" >
                    <div class="input-group">
                        <input name="q" 
                               autocomplete="off" 
                               class="form-control" 
                               id="search__input" 
                               placeholder="Введите Название Вуза"
                               value="{{ @urldecode(request()->input('q')) }}">
                        <div class="loaded__search_result"></div>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn_search">Начать поиск</button>
                        </span>
                    </div>
            </form> 
        </div>

        <?php if (@count($data['courses'])): ?>
            <div class="col-md-12">
                <h3>Курсы</h3>
                <hr>
                @foreach($data['courses'] as $course)
                    <a href=""><i class="fa fa-angle-right" aria-hidden="true"></i> {{ $course['name'] }}</a>
                @endforeach
            </div>
        <?php endif ?> 

        <?php if (@count($data['teachers'])): ?>
            <div class="col-md-12">
                <h3>Учителя</h3>
                <hr>
                @foreach($data['teachers'] as $teacher)
                    <a href="/teacher/{{ $teacher['id'] }}">
                        <i class="fa fa-angle-right" aria-hidden="true"></i> 
                        {{ $teacher['name'] }}
                    </a>
                @endforeach
            </div>
        <?php endif ?> 

        <?php if (@count($data['university'])): ?>
            <div class="col-md-12">
                <h3>Учебные заведения</h3>
                <hr>
                @foreach($data['university'] as $university)
                    <a href="/institution/{{ $university['id'] }}">
                        <i class="fa fa-angle-right" aria-hidden="true"></i> 
                        {{ $university['full_name'] }}
                    </a>
                @endforeach
            </div>
        <?php endif ?> 

        @if(@!count($data['courses']) && @!count($data['teachers']) && @!count($data['university']))
            <div class="col-lg-12">
                <div class="no__data"> 
                    <h5>Ничего не найденно</h5>
                </div>
            </div>
        @endif
    </div>
</div>
@stop