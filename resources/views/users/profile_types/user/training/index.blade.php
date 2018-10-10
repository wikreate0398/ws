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
            <a href="" class="additioinal__info">Подробная информация о курсе</a> @if($course->user->user_type==3)
            <a href="" class="add__name">
                    {{ $course->user->university['full_name'] }} 
                </a> @else
            <a href="" class="add__name">
                    {{ $course->user->name }} 
                </a> @endif

            <ul class="list-inline tr_short_info">
                @php $esablishDate = Course::manager($course)->esablishDate(); @endphp
                <li><i class="fa fa-calendar"></i> {{ $esablishDate['status'] }} {{ $esablishDate['date'] }}</li>
                <li><i class="fa fa-user" aria-hidden="true"></i> {{ $course->userRequests->count() }}</li>
                <li><i class="fa fa-clock-o" aria-hidden="true"></i> @php $diff = dateDiff($course->date_from, $course->date_to); @endphp @if($diff->m) {{ $diff->m }} {{ monthCase($diff->m) }} @endif @if($diff->d) @if($diff->m) и @endif {{ $diff->d }} @php echo dayCase($diff->d); @endphp @endif
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
        <div class="col-md-9">
            <h3>УЧЕБНЫЙ ПЛАН</h3>

            <div class="panel-group program_group user_program_group" id="accordion">
                @php $sectionNum = 0; @endphp @php $totaLecture = 0; @endphp @foreach($course->sections as $section) @php $sectionNum++ @endphp
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
                            @php $lectureNum = 0; @endphp @foreach($section->lectures as $lecture) @php $lectureNum++; $totaLecture++ @endphp

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
                                        <source src="/uploads/courses/video/{{ $lecture->video_file }}" type="{{ mime_content_type(public_path('/uploads/courses/video/' . $lecture->video_file)) }}">
                                    </video>
                                </div>
                                @elseif($lecture->video_link)
                                <div class="scl__media">
                                    {!! youtubeEmbed($lecture->video_link,0) !!}
                                </div>
                                @endif @if($lecture->materials->count())
                                <div class="scl_materials">
                                    <strong>материалы для подготовки</strong>
                                    <div class="scl_materials_list">
                                        @foreach($lecture->materials as $material)
                                        <a href="{{ route(userRoute('course_file_download'), ['file' => base64_encode('materials/'.$material['material'])]) }}">
                                            <img src="/images/file.png" style="max-width: 30px;" alt=""> {{ $material['material'] }}
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endif @if($lecture->has_homework)
                                <div class="scl__homework">
                                    <strong>домашнее задание</strong>
                                    <div class="scl__homework_desc">{{ $lecture->homework_letter }}</div>
                                    @if($lecture->homework_file)
                                    <a href="{{ route(userRoute('course_file_download'), ['file' => base64_encode('homework/'.$lecture->homework_file)]) }}" class="scl__homework_file">
                                        <img src="/images/file.png" style="max-width: 30px;" alt=""> {{ $lecture->homework_file }}
                                    </a>
                                    @endif

                                    @if(empty($lecture->userHomework) or !empty($lecture->userHomework->rejected))
                                        @if(!empty($lecture->userHomework->rejected))
                                            <hr>
                                            <p class="alert alert-danger">
                                                Преподаватель пока не может оценить ваше домашнее задание.
                                            </p>
                                            @if($lecture->userHomework->teacher_comment)
                                                <p class="scl__homework_teacher_comment">
                                                    {{ $lecture->userHomework->teacher_comment }}
                                                </p>
                                            @endif 
                                        @endif 
                                        <button class="btn2" data-toggle="modal" href="#tz_{{ $lecture->id }}">Выполнить Дз</button>

                                        <div id="tz_{{ $lecture->id }}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <h4 class="modal-title">Заполните Дз</h4>
                                                    </div>
                                                    <form class="ajax__submit scl__homework_form" 
                                                          method="POST" 
                                                          action="{{ route(userRoute('training_homework')) }}">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="id_course" value="{{ $course->id }}">
                                                        <input type="hidden" name="id_lecture" value="{{ $lecture->id }}">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="telephone">Файл</label>
                                                                <input type="file" name="file">
                                                                <small>Формат <code>doc,docx,pdf,rtf,zip</code></small>  
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="description">Комментарий <span class="req">*</span></label>
                                                                <textarea class="form-control" id="description" name="message"></textarea>
                                                            </div>
                                                            <div id="error-respond"></div>
                                                            <button type="submit" class="btn btn2" style="width: auto;">
                                                                Отправить
                                                            </button>
                                                        </div>                                                  
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($lecture->userHomework->confirm) 
                                        <hr>
                                        <p class="alert alert-success" >
                                            Учитель одобрил ваше задание. 
                                            @if($lecture->userHomework->appraisal)
                                                <code>Ваша Оценка:</code> <span class="badge">{{ $lecture->userHomework->appraisal }}</span>
                                            @endif
                                        </p> 
                                        @if($lecture->userHomework->teacher_comment)
                                            <p class="scl__homework_teacher_comment">
                                                {{ $lecture->userHomework->teacher_comment }}
                                            </p>
                                        @endif 
                                    @else
                                        <hr>
                                        <p class="alert alert-info">
                                            Преподаватель проверяет ваше домашнее задание.
                                        </p> 
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
        
        @function (generateFormMessage($teacherId, $idCourse))
            <div id="msg_{{ $teacherId }}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Отправить сообщение</h4>
                        </div>
                        <form class="ajax__submit scl__homework_form" 
                              method="POST" 
                              action="{{ route(userRoute('write_message')) }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id_teacher" value="{{ $teacherId }}"> 
                            <input type="hidden" name="id_course" value="{{ $idCourse }}">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="telephone">Файл</label>
                                    <input type="file" name="file">
                                    <small>Формат <code>doc,docx,pdf,rtf,zip</code></small>  
                                </div>
                                <div class="form-group">
                                    <label for="description">Комментарий <span class="req">*</span></label>
                                    <textarea class="form-control" id="description" name="message"></textarea>
                                </div>
                                <div id="error-respond"></div>
                                <button type="submit" class="btn btn2" style="width: auto;">
                                    Отправить
                                </button>
                            </div>                                                  
                        </form>
                    </div>
                </div>
            </div>
        @endfunction
        <div class="col-md-3">
            @if($course->user->user_type==3)
                @if(count($course->teachers))
                    <div id="course_teachers_slider" class="owl-carousel owl-theme">
                        @foreach($course->teachers as $teacher)
                            <div class="trainer__box">
                                @php
                                    $link = '/teacher/' . $teacher->id;
                                @endphp
                                <a href="{{ $link }}" class="trainer_photo" style="background-image: url({{ imageThumb(($teacher->avatar ? $teacher->avatar : $teacher->image), 'uploads/users', 150, 150, 'small') }})"> 
                                </a>
                                <a href="{{ $link }}" class="trainer_name">
                                    {{ $teacher->name }} 
                                </a>
                                <div class="trainer_description">
                                    {{ str_limit($teacher->about, 100) }} 
                                </div>
                                <button class="btn2" data-toggle="modal" style="padding: 5px 15px; margin-top: 10px;" href="#msg_{{ $teacher->id }}">
                                Написать сообщение</button>    
                            </div>
                        @endforeach
                    </div>
                    @foreach($course->teachers as $teacher)
                        @generateFormMessage($teacher->id, $course->id)   
                    @endforeach

                @endif 
            @else
                <div class="trainer__box">
                    @php
                        $link = '/teacher/' . $course->user->id;
                    @endphp
                    <a href="{{ $link }}" class="trainer_photo" style="background-image: url({{ imageThumb(($course->user->avatar ? $course->user->avatar : $course->user->image), 'uploads/users', 150, 150, 'small') }})"> 
                    </a>
                    <a href="{{ $link }}" class="trainer_name">
                        {{ $course->user->name }} 
                    </a>
                    <div class="trainer_description">
                        {{ str_limit($course->user->about, 100) }} 
                    </div>
                    <button class="btn2" data-toggle="modal" style="padding: 5px 15px; margin-top: 10px;" href="#msg_{{ $teacher->id }}">
                                Написать сообщение</button> 
                    @generateFormMessage($course->user->id, $course->id)      
                </div>
            @endif

            @if($course->reviews->count())
                <div class="trc_review"> 
                    <h4 class="trc_review_header">Отзывы участников курса</h4>
                    @foreach($course->reviews as $review)
                        <div class="row trc_review_item">
                            <div class="col-md-9">
                                <small>{{ date('d.m.Y', strtotime($review['created_at'])) }}</small>
                                <p class="trc_review_usr">{{ $review->user->name }}</p>
                                <div class="stars stars-example-fontawesome">
                                    <select class="rating-stars" name="rating" data-readonly="true" data-current-rating="{{ $review['rating'] }}" autocomplete="off">
                                      <option value="1">1</option> 
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      <option value="4">4</option>
                                      <option value="5">5</option>
                                    </select> 
                                </div>
                                <a data-toggle="modal" style="padding: 5px 15px;" href="#review_{{ $review->id }}">посмотреть отзыв</a> 
                                <div id="review_{{ $review->id }}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h4 class="modal-title">Отзыв</h4>
                                            </div>
                                             
                                            <div class="modal-body">
                                                <p>{{ $review['review'] }}</p>
                                            </div>      
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-3">
                                <div class="review__user_image" style="background-image: url({{ imageThumb(($review->user->avatar ? $review->user->avatar : $review->user->image), 'uploads/users', 150, 150, 'small') }})"></div>
                            </div>
                        </div>
                    @endforeach 
                </div>
            @endif
            @if(!Course::manager($course)->ifHasUserReview(@Auth::user()->id))
                <div id="review" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Заполните Дз</h4>
                            </div>
                            <form class="ajax__submit scl__homework_form" 
                                  method="POST" 
                                  action="{{ route(userRoute('write_review'), ['id' => $course->id]) }}">
                                {{ csrf_field() }} 
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="description">Комментарий <span class="req">*</span></label>
                                        <textarea name="message" class="form-control"></textarea> 
                                    </div>
                                    <div class="stars stars-example-fontawesome">
                                        <select class="rating-stars" name="rating" autocomplete="off">
                                          <option value="1">1</option> 
                                          <option value="2">2</option>
                                          <option value="3">3</option>
                                          <option value="4">4</option>
                                          <option value="5">5</option>
                                        </select> 
                                    </div>
                                    <div id="error-respond"></div>
                                    <button type="submit" class="btn btn2" style="width: auto;">
                                        Отправить
                                    </button>
                                </div>                                                  
                            </form>
                        </div>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 20px;">
                    <button class="btn2" data-toggle="modal" style="padding: 5px 15px;" href="#review">Оставить отзыв</button>
                </div> 
            @endif

        </div>
    </div>
</div>

<style>

    .trc_review_header{
        font-weight: bold;
        font-size: 18px;
        border-bottom: 3px solid #ccc;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .trc_review_usr{
        text-transform: uppercase;
        font-size: 16px;
        font-weight: bold;
    }

    .review__user_image{
        display: block;
        border-radius: 50%;
        width: 60px;
        height: 60px; 
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        background-color: #ededed;
    }

    .trc_review_item{
        margin-bottom: 30px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 10px; 
    }

    .trainer__box{
        background: #fff;
        border-radius: 5%;
        box-shadow: 0 1px 3px rgba(0,0,0,.3);
        padding: 15px;
        margin:5px;
        text-align: center;
        margin-top: 55px;
    } 

    .trainer_photo{
        display: block;
        border-radius: 50%;
        width: 100px;
        height: 100px;
        margin: auto;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        background-color: #ededed;
    }

    .trainer_name, .trainer_name:hover, .trainer_name:focus{
        text-transform: uppercase;
        font-weight: bold;
        color: #333;
        font-size: 13px;
        margin:15px 0;
        text-decoration: none;
        line-height: 21px;
        display: block;
    }

    .trainer_description{
        font-size: 12px;
    }     

    .scl__homework_form #error-respond{
        position: relative;
        top: 0;
        left: 0;
        background-color: transparent !important;
        box-shadow:none;
        color: #f97f7f;
        padding:0;
    }

    .scl__homework_form .close__error_respond{
        display: none;
    }

    .scl__homework .btn2 {
        padding: 5px 15px;
        margin-top: 10px;
    }
    
    .user_program_group .panel-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .scl__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .scl__header h4 {
        font-weight: bold;
    }
    
    .scl_desc,
    .scl__homework_desc,
    .scl__homework_teacher_comment {
        font-size: 14px;
        color: #8c8c8c;
    }
    
    .scl_materials,
    .scl__media,
    .scl__homework {
        margin: 15px 0;
    }
    
    .scl_materials_list a,
    .scl__homework_file {
        font-size: 14px;
        text-decoration: underline;
        color: #8c8c8c;
        display: block;
    }
    
    .user_program_group .panel-title .sc__date {
        font-size: 14px;
    }
    
    .tr_header_points {
        text-align: center;
    }
    
    .tr_header_points h1 {
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
        margin: auto;
    }
    
    .training__page .tr_header {
        background: #c9c9c9;
        padding: 30px 0;
        margin-top: 50px;
    }
    
    .tr_header_info h1 {
        color: #fff;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 24px;
        margin: 0 0 10px 0;
    }
    
    .tr_header_info h2 {
        color: #000;
        font-weight: bold;
        font-size: 24px;
        margin: 0 0 10px 0;
    }
    
    .additioinal__info {
        text-transform: uppercase;
        display: block;
        font-size: 12px;
        text-decoration: underline;
        color: #199ED8;
        margin-bottom: 5px;
    }
    
    .add__name {
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