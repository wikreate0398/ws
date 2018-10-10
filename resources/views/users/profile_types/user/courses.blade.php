<!-- <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
    	<a href="#active" aria-controls="active" role="tab" data-toggle="tab">АКТИВНЫЕ</a>
    </li>
    <li role="presentation">
    	<a href="#finish" aria-controls="finish" role="tab" data-toggle="tab">ЗАВЕРШЕННЫЕ</a>
    </li> 
</ul> --> 

<div class="course_lk">
		<div class="row">

			<div class="col-md-12" style="margin:0 0 25px 0;">
				<button class="btn btn-default toggle__course active" data-show=".is_active" onclick="activeFinishCourse(this);">
					АКТИВНЫЕ
				</button>

				<button class="btn btn-default toggle__course" data-show=".is_finished" onclick="activeFinishCourse(this);">
					ЗАВЕРШЕННЫЕ
				</button>
			</div>
		</div>
 	 
		@if(count($user->coursesRequests)) 
			<div class="row course__catalog"> 
			@foreach($user->coursesRequests as $course)
				@php  
					$id = '';
					if (Course::manager($course)->isFinished()) {
						$id .= 'is_finished';
					}else{
						$id .= 'is_active';
					}
				@endphp
				<div class="col-md-4 {{ $id }}">
					<div class="course_card eq_list__item">
	            		@if(@Auth::check()) 
	            			@php $favorite = in_array(Auth::user()->id, $course->userFavorite->pluck('id')->toArray()); @endphp
		            		<i class="fa course_heart 
		            		   {{ $favorite ? 'is_favorite fa-heart' : 'fa-heart-o' }}" 
		            		   onclick="courseFavorite(this, {{ $course->id }});"  
		            		   aria-hidden="true"></i>
	            		@endif
	            		<div class="body__course_card">
	            			<div class="cat-name"> 
	            				@if(!empty(@$course->subCategory->name)) 
									{{ @$course->subCategory->name }}
								@else 
									{{ @$course->category->name }}
	            				@endif 
	            			</div>
		            		<h2>
		            			<a href="/course/{{ $course->id }}/userRequest/{{ $user->id }}">
		            				{{ $course->name }}
		            			</a>
		            		</h2>
		            		<h4>
		            			@if($course->user->user_type==3)
					            		{{ $course->user->university['full_name'] }} 
					            	@else
										{{ $course->user->name }} 
					            @endif
		            		</h4>
		            		<table>
		            			<tr>
		            				<td>СТОИМОСТЬ</td> 
		            				<td>
										@if($course->pay == 1)
											БЕСПЛАТНО
										@else
											₽{{ priceString(Course::generatePrice($course)) }}
			            				@endif 
		            				 </td>
		            			</tr>

		            			<tr> 
		            				<td>ДЛИТЕЛЬНОСТЬ</td> 
		            				<td style="text-transform: uppercase;">
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
		            				</td>
		            			</tr>

		            			<tr> 
		            				<td>ПРОГРЕСС ЗАВЕРШЕНИЯ</td>
		            				<td>
		            					 
		            				</td>
		            			</tr>
		            		</table>
							
		            		<div class="row" style="margin-top: 10px;">
		            			<div class="col-md-6">  
		            				@if(!Course::manager($course)->isFinished()) 
		            					@php $disable = Course::manager($course)->isStarted() ? '' : 'disable__link' @endphp
		            					<a href="{{ route(userRoute('course_training'), ['id' => $course->id]) }}" 
		            					   class="course__btn learning__course {{ $disable }}">Обучение</a> 
		            				@elseif(Course::manager($course)->isFinished())
										<a href="" class="dwn__diplom">Скачать Диплом</a> 
		            				@endif   
		            			</div>
		            			<div class="col-md-6">
		            				<a href="/course/{{ $course->id }}/userRequest/{{ $user->id }}" class="course__btn about__course">О курсе</a>
		            			</div>
		            		</div>
	            		</div> 

	            		<div class="footer__course_card">
	            			<div class="pers__num">
	            				<i class="fa fa-user" aria-hidden="true"></i>
	            				<span>{{ count($course->userRequests) }}</span>
	            			</div>
	            			<div class="set__going">   
	            				@if(Course::manager($course)->isFinished())
									<i class="fa fa-calendar" aria-hidden="true"></i>
								    <div class="set__going_date">  
										<span> Завершен </span> 
										<strong>{{ date('d.m.Y', strtotime($course->date_to)) }}</strong> 
									</div>
									@elseif(Course::manager($course)->isNotStarted())
										<i class="fa fa-calendar" aria-hidden="true"></i>
									    <div class="set__going_date">  
											<span> Начнется </span> 
											<strong>{{ date('d.m.Y', strtotime($course->date_from)) }}</strong> 
										</div>
									@else
									<i class="fa fa-calendar" aria-hidden="true"></i>
								    <div class="set__going_date">  
										<span> Начат с </span> 
										<strong>{{ date('d.m.Y', strtotime($course->date_from)) }}</strong> 
									</div>
	            				@endif
	            			</div>
	            		</div>
	            	</div>
				</div>
			@endforeach 
			</div>

			<style>
    			.course__btn{
                    width: 100%; 
                    color: #fff;
                    text-transform: uppercase;
                    border-radius: 20px;
                    padding:5px 0;
                    border:none;
                    outline: none;
                    font-size: 13px;
                    margin-bottom: 10px;
                    display: inline-block;
                    text-align: center;
                    text-decoration: none;
                 }

                 .course__btn.learning__course{
                    background-color: rgba(153, 153, 204, 1);
                 }

                 .course__btn.about__course{
                    background-color: #fff;
                    color: #333;
                    border:1px solid rgba(153, 51, 102, 1);
                 }

                .course__btn:hover{
                	text-decoration: none;
                }

                 .dwn__diplom{
                 	text-transform: uppercase;
                 	color: #333;
                 	font-size: 13px;
                 	font-weight: bold;
                 	text-decoration: underline;
                 } 

                .disable__link{
					opacity: 0.5;
					pointer-events: none;
                }
    		</style>

		@else
		<div class="row"> 
			<div class="col-lg-12">
				<div class="no__data"> 
					<h5>Вы не записаны на курсы</h5>
				</div>
			</div>
		</div>
		@endif 
	 
</div>
 