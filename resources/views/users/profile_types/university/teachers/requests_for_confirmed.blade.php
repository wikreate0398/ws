<div class="row teacher__new_requests"> 
	@if(count($requestFromTeachers)) 
		@foreach($requestFromTeachers as $teacher)
			<div class="col-md-12">
				<div class="row" style="align-items: stretch; display: flex;">
					<div class="col-md-3 teacher__info">
						<div class="teacher__info_inner"> 
							<div class="img" style="background-image: url({{ imageThumb(($teacher->teacher->avatar ? $teacher->teacher->avatar : $teacher->teacher->image), 'uploads/users', 400, 300, 'universities') }});"> 
							</div>
							<div class="name">{{ $teacher->teacher->name }}</div>
							<a href="/teacher/{{ $teacher->teacher->id }}" target="_blank" class="btn btn-default">Подробнее</a>
						</div>
					</div>
					<div class="col-md-9 teacher__request_info">
						<div class="teacher__request_info_inner">
							<h3>ПОЖАЛУЙСТА ПОДВЕРДИТЕ, ЧТО Я:</h3>
							<p class="tay_univ">
								{{ $teacher['teaching'] ? 'ПРЕПОДАЮ' : 'ОБУЧАЛСЯ' }} В ВАШЕМ ВУЗЕ</p>
							<p class="req_from">СОПРОВОДИТЕЛЬНОЕ ПИСЬМО ОТ <b>{{ date('d.m.Y', strtotime($teacher['created_at'])) }}</b></p>
							<p class="letter">{{ $teacher->letter }}</p>
							@if($teacher->attach)
								@php $attaches = explode(',', $teacher->attach); @endphp
								<p class="attached_files_label">ПРИКРЕПЛЕННЫЕ ФАЙЛЫ:</p>
								<ul class="attaches">
									@foreach($attaches as $key => $attach)
										<li><a href="{{ url('uploads/users/teacher_connects/' . $attach) }}" target="_blank">{{ $attach }}</a></li>
									@endforeach
								</ul>
							@endif
							<div class="actions">
								<a href="{{ route(userRoute('user_teachers_confirm'), ['id' => $teacher['id']]) }}" class="btn confirm__item">ПОДТВЕРДИТЬ</a>
								&nbsp;
								<a href="{{ route(userRoute('user_teachers_decline'), ['id' => $teacher['id']]) }}" class="btn decline confirm__item">ОТКЛОНИТЬ</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	@else
		<div class="col-lg-12">
			<div class="no__data"> 
				<h5>Нет заявок на подтверждение</h5>
			</div>
		</div>
	@endif
</div>

<style>
	.teacher__request_info h3{
		text-transform: uppercase;
		font-weight: bold;
		color: #333;
		font-size: 16px;
	}
	.teacher__request_info p.tay_univ{
		margin: 15px 0;
		font-size: 14px;
		text-transform: uppercase;
	}
	.req_from{
		font-size: 14px;
		text-transform: uppercase;
		margin-bottom: 0px;
	}
	.letter{
		font-size: 14px; 
	}

	ul.attaches{
		padding: 0;
		list-style: none;
		margin-top: 0px;
	}

	ul.attaches li{
		display: inline-block;
		margin-right: 10px;
		font-size: 12px;
	}

	.attached_files_label{
		margin-bottom: 0px;
	}

	.teacher__new_requests .teacher__info{
		background: #fff;
		-webkit-box-shadow: 1px 2px 10px rgba(0, 0, 0, 0.349019607843137);
		box-shadow: 1px 2px 10px rgba(0, 0, 0, 0.349019607843137);
		display: flex;
		justify-content: center;
		align-items: center;
		flex-flow: wrap;  
		text-align: center;
	}

	.teacher__info_inner{
		padding: 15px 0;
	}

	.teacher__info_inner .btn{
		border-radius: 20px;
        background-color: #ededed;
        border: 1px solid #ededed;
        outline: none;
        color: #333;
        margin-top: 15px;
	}
  
	.teacher__info .img{
		border-radius: 50%;
		width: 80px;
		height: 80px;
		overflow: hidden;
		background-repeat: no-repeat;
		background-position: center;
		-webkit-background-size: cover;
		background-size: cover;
		margin: auto;
	}

	.teacher__info .name{
		margin: 10px 0;
		font-weight: bold;
		font-size: 16px;
	}

	.teacher__request_info{
		background: rgba(242, 242, 242, 1);
	}

	.actions .btn{
		border-radius: 20px;
        background-color: rgba(153, 153, 204, 1);
        border: 1px solid rgba(153, 153, 204, 1);
        outline: none;
        color: #fff;
	}

	.actions .btn.decline{
		background:transparent;
		border: 1px solid #333;
		color: #333;
	}

	.actions{
		border-top: 1px solid #333;
		padding-top: 20px;
		margin-bottom: 20px;
	}
</style>