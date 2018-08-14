
<div class="row">
	<div class="col-md-12">
		<div style="border-bottom: 1px solid #ededed; padding-bottom: 15px; margin-bottom: 15px;"> 
			<a href="{{ route(userRoute('user_teachers')) }}?p=requests_for_teachers" class="btn btn-default">Создать запрос</a>
		</div>
	</div>
</div>

<div class="teachers__conections_container"> 
	<div class="row">
		<div class="col-md-12">
			<ul class="links">
				<li>
					<a class="{{ (request()->input('p')=='confirmed_records' or !request()->input('p')) ? 'active' : '' }}" 
					   href="{{ route(userRoute('user_teachers')) }}?p=confirmed_records">ПОДТВЕРЖДЕННЫЕ ЗАПИСИ ({{ count($user->connectionTeachers) }})</a>
				</li>
				<li>
					<a class="{{ (request()->input('p')=='requests_for_confirmed') ? 'active' : '' }}"
					   href="{{ route(userRoute('user_teachers')) }}?p=requests_for_confirmed">ЗАЯВКИ НА ПОДТВЕРЖДЕНИЕ ({{ count($requestFromTeachers) }})</a>
				</li>
				<li>
					<a class="{{ (request()->input('p')=='requests_for_teachers') ? 'active' : '' }}"
					   href="{{ route(userRoute('user_teachers')) }}?p=requests_for_teachers">ЗАПРОСЫ К ПРЕПОДАВАТЕЛЯМ ({{ count($requestForTeachers) }})</a>
				</li>
			</ul>
		</div>
	</div>

	@include($teacherPage)   
</div>

<style>
	
	.teachers__conections_container ul.links{
		padding: 0;
		margin-bottom: 50px;
	}

	.teachers__conections_container ul.links li{
		display: inline-block;
		margin-right: 15px;
		text-transform: uppercase;
		list-style: none;
	}

	.teachers__conections_container ul.links li a{
		font-weight: bold;
		color: #333;
		text-decoration: none;
	}

	.teachers__conections_container ul.links li a:hover, .teachers__conections_container ul.links li a.active{
		color: #999;
	}
 

	.teachers__conections_container .item__block{
        border: 1px solid #ededed;
        padding: 15px;
        text-align: center;
        margin-bottom: 20px;
    }

    .teachers__conections_container .item__img img{
        max-width: 100%;
        width: 100%;
    }

    .teachers__conections_container .item__info .item__name{ 
        font-weight: bold;
        font-size: 12px;
        text-transform: uppercase;
        color: #000;
    }

    .teachers__conections_container .item__info span{
        font-size: 10px;
        display: block;
        text-transform: uppercase;
    }

    .teachers__conections_container .item__info{
        padding: 15px 0;
        border-bottom: 1px solid #333;
        margin-bottom: 15px;
    }

    .teachers__conections_container .item__info .btn{
		border-radius: 20px;
        background-color: #ededed;
        border: 1px solid #ededed;
        outline: none;
        color: #333;
        margin-top: 15px;
    }

    .teachers__conections_container .item__block .modal-content{
        text-align: left;
    }

    .teachers__conections_container .item__footer .btn{
        border-radius: 20px;
        background-color: rgba(153, 153, 204, 1);
        border: 1px solid rgba(153, 153, 204, 1);
        outline: none;
        color: #fff;
    }   
</style>