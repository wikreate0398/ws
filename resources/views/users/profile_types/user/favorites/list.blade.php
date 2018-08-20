<div class="favorite__conections_container"> 
	<div class="row">
		<div class="col-md-12">
			<ul class="links">
				<li>
					<a class="{{ (request()->input('p')=='university' or !request()->input('p')) ? 'active' : '' }}" 
					   href="{{ route(userRoute('user_favorites')) }}?p=university">Вузы ({{ count(@$university) }})</a>
				</li>
				<li>
					<a class="{{ (request()->input('p')=='courses') ? 'active' : '' }}"
					   href="{{ route(userRoute('user_favorites')) }}?p=courses">Курсы ({{ count(@$courses) }})</a>
				</li>
				<li>
					<a class="{{ (request()->input('p')=='teachers') ? 'active' : '' }}"
					   href="{{ route(userRoute('user_favorites')) }}?p=teachers">Преподаватели ({{ count(@$teachers) }})</a>
				</li>
			</ul>
		</div>
	</div> 

    @include($page)
</div>

<style>
	
	.favorite__conections_container ul.links{
		padding: 0;
		margin-bottom: 50px;
	}

	.favorite__conections_container ul.links li{
		display: inline-block;
		margin-right: 15px;
		text-transform: uppercase;
		list-style: none;
	}

	.favorite__conections_container ul.links li a{
		font-weight: bold;
		color: #333;
		text-decoration: none;
	}

	.favorite__conections_container ul.links li a:hover, .favorite__conections_container ul.links li a.active{
		color: #999;
	}
 

	.favorite__conections_container .item__block{
        border: 1px solid #ededed;
        padding: 15px;
        text-align: center;
        margin-bottom: 20px;
    }

    .favorite__conections_container .item__img img{
        max-width: 100%;
        width: 100%;
    }

    .favorite__conections_container .item__info .item__name{ 
        font-weight: bold;
        font-size: 12px;
        text-transform: uppercase;
        color: #000;
    }

    .favorite__conections_container .item__info span{
        font-size: 10px;
        display: block;
        text-transform: uppercase;
    }

    .favorite__conections_container .item__info{
        padding: 15px 0;
        border-bottom: 1px solid #333;
        margin-bottom: 15px;
    }

    .favorite__conections_container .item__info .btn{
		border-radius: 20px;
        background-color: #ededed;
        border: 1px solid #ededed;
        outline: none;
        color: #333;
        margin-top: 15px;
    }

    .favorite__conections_container .item__block .modal-content{
        text-align: left;
    }

    .favorite__conections_container .item__footer .btn{
        border-radius: 20px;
        background-color: rgba(153, 153, 204, 1);
        border: 1px solid rgba(153, 153, 204, 1);
        outline: none;
        color: #fff;
    }   
</style>