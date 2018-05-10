@extends('layouts.app')

@section('content')
<div class="container no__home">
    <div class="row">

        <div class="col-md-12">
            <form id="search_form" action="/search/" style="margin-bottom: 20px;">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="form-group input-search-area">
                            <input name="q" autocomplete="off" value="{{ urldecode(request()->input('q')) }}" class="form-control" id="search__input" placeholder="Введите название">
                            <div class="loaded__search_result"></div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-primary">Поиск</button>
                    </div>
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
    </div>
</div>
@stop