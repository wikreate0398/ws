<div class="reviews__conections_container">
    <div class="row">
        <div class="col-md-12">
            <ul class="links">
                <li>
                    <a class="{{ (request()->input('p')=='university' or !request()->input('p')) ? 'active' : '' }}"
                       href="{{ route(userRoute('user_reviews')) }}?p=university">Вузы ({{ count(@$university) }})</a>
                </li>
                <li>
                    <a class="{{ (request()->input('p')=='courses') ? 'active' : '' }}"
                       href="{{ route(userRoute('user_reviews')) }}?p=courses">Курсы ({{ @$user->userCourseReviews->count() }})</a>
                </li>
                <li>
                    <a class="{{ (request()->input('p')=='teachers') ? 'active' : '' }}"
                       href="{{ route(userRoute('user_reviews')) }}?p=teachers">Преподаватели ({{ @$user->userTeacherReviews->count() }})</a>
                </li>
            </ul>
        </div>
    </div>

    @include($page)
</div>

<style>

    .reviews__conections_container ul.links{
        padding: 0;
        margin-bottom: 50px;
    }

    .reviews__conections_container ul.links li{
        display: inline-block;
        margin-right: 15px;
        text-transform: uppercase;
        list-style: none;
    }

    .reviews__conections_container ul.links li a{
        font-weight: bold;
        color: #333;
        text-decoration: none;
    }

    .reviews__conections_container ul.links li a:hover, .reviews__conections_container ul.links li a.active{
        color: #999;
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

    .review_item {
        padding: 20px;
        -webkit-box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.349019607843137);
        box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.349019607843137);
        margin-bottom: 20px;
    }

    .review__post_date{
        color: #ccc;
        font-size: 12px;
    }

    .review__user_name{
        font-weight: bold;
        text-transform: uppercase;
        font-size: 15px;
    }

    .review__left_side a.review__name{
        margin:0;
        font-size: 16px;
        text-transform: uppercase;
        font-weight:bold;
    }

    .review__left_side .pre__review_name{
        text-transform: uppercase;
    }

    .review__date{
        margin:10px 0 0 0;
        color: #bfbfbf;
        font-size: 14px;
    }

    .review__top_side{
        justify-content: space-between;
        display: flex;
        align-items: center;
    }

    .review__user_info{
        margin-left: 10px;
    }

    .review__message{
        margin-top: 10px;
        font-size: 14px;
        color: #333;
    }

    .on__moderation{
        text-transform: uppercase;
        font-size: 12px;
        color: red;
    }

</style>