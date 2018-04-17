@extends('layouts.app')

@section('content')
    @if(!empty($university))
        <div class="educational_blog">
            <div class="container">
                <div class="row">
                    <div class="col-lg-11">
                        <h3 style="font-weight: bold;">Учебные заведения</h3>
                        <br>
                    </div>
                    <div class="col-lg-12">
                        <div id="slider_univ_list" class="owl-carousel owl-theme" style="margin-top: 0px;">
                            @foreach($university as $item)
                            <div class="item">
                                <div class="educational_blog_desc">
                                    <div class="educational_blog_image">
                                        <?php $img = !empty($item['user']['image']) ? '/public/uploads/users/' . $item['user']['image'] : noImg()  ?>
                                        <a href="/institution/{{ $item['id'] }}/" class="univ__img" style="background-image: url({{ $img }})"> 
                                        </a>
                                    </div>
                                    <div class="educational_blog_name">
                                        <h4 style="cursor: pointer;" onclick="window.location='/institution/{{ $item['id'] }}/'">{{ $item['full_name'] }}</h4>
                                    </div>
                                    <div class="educational_blog_more text-right">
                                        <a href="/institution/{{ $item['id'] }}/">Подробнее</a>
                                    </div>
                                </div>
                            </div> 
                            @endforeach 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .univ__img{
                display: block;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                width: 252px;
                height: 194px;
            }
        </style>
    @endif
@stop