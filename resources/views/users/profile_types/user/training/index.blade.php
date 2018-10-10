 
<div class="container training__page"> 
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <ul class="breadcrumb">
          <li><a href="/">Главная</a></li>
          <li><a href="{{ route(userRoute('user_profile')) }}">Курсы</a></li>
          <li class="active">Обучение</li>
        </ul> 
    </div> 
</div>

<div class="row tr_header">
    <div class="col-md-8 tr_header_info">
        <h1>Список занятий</h1>
        <h2>{{ $course->name }}</h2>
        <label class="badge">{{ $course->category->name }}</label>
        <a href="" class="additioinal__info">Подробная информация о курсе</a>
        @if($course->user->user_type==3)
                <a href="" class="add__name">
                    {{ $course->user->university['full_name'] }} 
                </a>
            @else
                <a href="" class="add__name">
                    {{ $course->user->name }} 
                </a> 
        @endif

        <ul class="list-inline tr_short_info">
                @php 
                    $esablishDate = Course::manager($course)->esablishDate();  
                @endphp 
                <li><i class="fa fa-calendar"></i> {{ $esablishDate['status'] }} {{ $esablishDate['date'] }}</li>
                <li><i class="fa fa-user" aria-hidden="true"></i> {{ $course->userRequests->count() }}</li>
                <li><i class="fa fa-clock-o" aria-hidden="true"></i>
                    @php 
                        $diff = dateDiff($course->date_from, $course->date_to);
                    @endphp
                    @if($diff->m)
                        {{ $diff->m }} {{ monthCase($diff->m) }}
                    @endif 

                    @if($diff->d) 
                        @if($diff->m)
                            и
                        @endif 
                        {{ $diff->d }}  
                        @php 
                            echo dayCase($diff->d);
                        @endphp  
                    @endif 
                </li>
               <!--  <li class="courseSections"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></li> -->
            </ul>
    </div>

    <div class="col-md-4 tr_header_points">
        <h1>НАБРАННО БАЛЛОВ</h1>
        <div class="points_circle">
            N
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <h3>УЧЕБНЫЙ ПЛАН</h3> 
 
        <div class="panel-group program_group user_program_group" id="accordion">
            @php $sectionNum = 0; @endphp
            @php $totaLecture = 0; @endphp
            @foreach($course->sections as $section)
                @php $sectionNum++ @endphp
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $sectionNum }}">
                                <strong>Раздел {{ $sectionNum }}:</strong> <span>{{ $section->name }}</span>
                            </a>
                            @if($section->date)
                                <strong class="sc__date">{{ date('d.m.Y', strtotime($section->date))  }}</strong>
                            @endif 
                        </h4>
                    </div>
                    <div id="collapse{{ $sectionNum }}" class="panel-collapse collapse {{ ($sectionNum == 1) ? 'in' : ''}}">
                         <div class="panel-body sc__lectures"> 
                            @php $lectureNum = 0; @endphp
                            @foreach($section->lectures as $lecture)
                                @php $lectureNum++; $totaLecture++ @endphp
                                
                                <div class="sc__lecture">
                                    <div class="scl__header">
                                        <h4>ЛЕКЦИЯ {{ $sectionNum }}.{{ $lectureNum }} {{ $lecture->name }}</h4>
                                        <span>
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        {{ $lecture->duration_hourse }} ч {{ $lecture->duration_minutes }} мин.
                                        </span>
                                    </div>

                                    <div class="scl_desc">
                                        {{ $lecture->description }}
                                    </div> 
                                    
                                    @if($lecture->video_file)
                                        <div class="scl__media">
                                            <video width="250" data-setup='{"controls": true, "autoplay": false, "preload": "auto"}' class="video-js">
                                                <source src="/uploads/courses/video/{{ $lecture->video_file }}" 
                                                        type="{{ mime_content_type(public_path('/uploads/courses/video/' . $lecture->video_file)) }}">
                                            </video> 
                                        </div>
                                    @elseif($lecture->video_link)
                                        <div class="scl__media"> 
                                            {!! youtubeEmbed($lecture->video_link,0) !!}
                                        </div>
                                    @endif

                                    @if($lecture->materials->count())
                                        <div class="scl_materials"> 
                                            <strong>материалы для подготовки</strong>
                                            <div class="scl_materials_list"> 
                                                @foreach($lecture->materials as $material)
                                                    <a href="{{ route(userRoute('course_file_download'), ['file' => base64_encode('materials/'.$material['material'])]) }}"> 
                                                        <img src="/images/file.png" style="max-width: 30px;" alt="">
                                                        {{ $material['material'] }} 
                                                    </a> 
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if($lecture->has_homework)
                                        <div class="scl__homework">
                                            <strong>домашнее задание</strong>
                                            <div class="scl__homework_desc">{{ $lecture->homework_letter }}</div>
                                            @if($lecture->homework_file)
                                                <a href="{{ route(userRoute('course_file_download'), ['file' => base64_encode('homework/'.$lecture->homework_file)]) }}" class="scl__homework_file"> 
                                                    <img src="/images/file.png" style="max-width: 30px;" alt="">
                                                    {{ $lecture->homework_file }} 
                                                </a>
                                            @endif 
                                        </div>
                                    @endif
                                </div>
                            @endforeach 
                         </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-md-">
        
    </div>
</div>
</div>
 
<style>
    
    .user_program_group .panel-title{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .scl__header{
        display: flex;
        justify-content: space-between;
        align-items: center;
    } 

    .scl__header h4{
        font-weight: bold;
    }

    .scl_desc, .scl__homework_desc{
        font-size: 14px;
        color: #8c8c8c;
    }

    .scl_materials, .scl__media, .scl__homework{
        margin: 15px 0;
    }

    .scl_materials_list a, .scl__homework_file {
        font-size: 14px;
        text-decoration: underline;
        color: #8c8c8c;
        display: block;
    } 

    .user_program_group .panel-title .sc__date{
        font-size: 14px;
    }
    
    .tr_header_points{
        text-align: center;
    }

    .tr_header_points h1{
        color: #000;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 18px;
        margin: 0 0 10px 0;
    }

    .points_circle {
        background: rgba(215, 215, 215, 1);
        border-radius: 50%;
        font-size: 55px;
        text-align: center;
        width: 150px;
        height: 150px;
        line-height: 150px;
        margin:auto;
    }

    .training__page .tr_header{
        background: #c9c9c9;
        padding: 30px 0;
        margin-top: 50px;
    }     

    .tr_header_info h1{
        color: #fff;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 24px;
        margin: 0 0 10px 0;
    }
    .tr_header_info h2{
        color: #000;
        font-weight: bold; 
        font-size: 24px;
        margin: 0 0 10px 0;
    }

    .additioinal__info{
        text-transform: uppercase;
        display: block;
        font-size: 12px;
        text-decoration: underline;
        color: #199ED8;
        margin-bottom: 5px;
    }

    .add__name{
        text-transform: uppercase;
        display: block;
        font-size: 12px;
        text-decoration: underline;
        color: #666666;
    }

    .tr_short_info{
        margin-top: 10px;
        color: #993366;
        font-size: 14px;
    }
</style>