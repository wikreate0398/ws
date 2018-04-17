@extends('layouts.app')

@section('content')
    @if(!empty($university))
        <div class="educational_blog no__home">
            <div class="container">
                <div class="row">
                    <div class="col-lg-11">
                        <h3 style="font-weight: bold;">Учебные заведения</h3>
                        <br>
                    </div>
                    <div class="col-lg-12"> 
                        <div id="partner_universities">
                            @foreach($university as $item)
                                <div class="col-md-3"> 
                                    <div class="item"> 
                                        <?php $img = !empty($item['user']['image']) ? '/public/uploads/users/' . $item['user']['image'] : noImg()  ?>
                                        <a href="/institution/{{ $item['id'] }}/" class="img__institution" style="background-image: url({{ $img }})"></a> 
                                        <h3 style="cursor: pointer;" onclick="window.location='/institution/{{ $item['id'] }}/'">{{ $item['full_name'] }}</h3>
                                       <!--  <ul class="list-unstyled">
                                            <li>10 КУРСОВ</li>
                                            <li>15 ПРЕПОДАВАТЕЛЕЙ</li>
                                        </ul> -->
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