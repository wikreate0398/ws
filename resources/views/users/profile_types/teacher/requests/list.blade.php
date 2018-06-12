 
@if(count($user->teacherRequests) > 0)
<div class="row">
	@foreach($user->teacherRequests as $userRequest)
		<div class="col-md-6 request__info_inner">
			<div class="rows">
				<div class="col-md-6 request__user_name_img">
					<div class="profile__img" 
	                     style="background-image: url(/public/uploads/users/{{ $userRequest->avatar ? $userRequest->avatar : $userRequest->image }}{{'?v=' . time()}});">
	                </div>
	                <strong>
	                   {{ $userRequest['name'] }}
	                </strong>
				</div>
				<div class="col-md-6 request__user_info">
					<div>
	                   <strong>ТЕЛЕФОН</strong>
	                   <a class="request__phone" href="tel:{{ $userRequest['phone'] }}">{{ $userRequest['phone'] }}</a>
	                </div>
	                <br> 
	                <div>
	                   <strong>E-MAIL</strong>
	                   <a class="request__email" href="mailto:{{ $userRequest['email'] }}">{{ $userRequest['email'] }}</a>
	                </div>
	                <br> 
	                <div>
	                   <strong>ДАТА ПОДАЧИ ЗАЯВКИ</strong>
	                   <p>{{ date('d.m.Y', strtotime($userRequest['created_at'])) }}</p>
	                </div>
				</div>
			</div>
		</div>
	@endforeach
</div>
<style> 

	.request__info_inner{
		margin-bottom: 15px;
	}

	.request__info_inner > .rows {
        -webkit-box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.349019607843137);
         box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.349019607843137); 
         padding:15px;  
     }

     .rows:after, .rows:before{
     	display: table;
     	content: " ";
     	clear: both;
     }
  

     .request__user_info strong{
        font-size: 11px;
        display: block;
     }

     .request__phone{
        font-size: 16px;
        font-weight: bold;
        text-decoration: none;
        color: #333;
     }

     .request__email{
        font-size: 13px;
     }

     .request__user_name_img{
        text-align: center;
        border-right: 1px solid #98cdfe;
     }

     .request__user_name_img .profile__img{
        padding-top: 0;
        width: 100px;
        height: 100px; 
     }

     .request__user_name_img strong{
        font-size: 16px;
     }
</style>
@else
	<div class="col-md-12">
		<div class="no__data"> 
			<h5>Вы не добавили ни одного курса</h5>
		</div>
	</div>
@endif 