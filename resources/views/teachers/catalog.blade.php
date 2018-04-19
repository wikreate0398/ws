@extends('layouts.app')

@section('content')
    @if(!empty($teachers))
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
@stop