<div class="col-lg-4">
	<div class="external_card">
		<div class="caption">
			<ul class="list-inline card_tag">
				<li class="tag_sticker">
					<span>ПРОФЕССИОНАЛЬНЫЙ РОСТ</span>
				</li>
				<li class="bookmark_tag">
					<span>
					   <button class="btn btn-default">
						   <i class="fa fa-heart-o"></i>
					   </button>
				   </span>
				</li>
			</ul>
			<h3>{{ $course->name }}</h3>
			<h4>
	            @if($course->user->user_type==3)
	             {{ $course->user->university['full_name'] }} 
	            @endif
        	</h4>
			<ul class="list-unstyled card_info">
				<li>
					Стоимость <span> бесплатно </span>
				</li>
				<li>
					Длительность 
					<span> 
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
					 </span>
				</li>
				<li>
					Рейтинг 
					<span class="rating_star"> 
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star"></i>
						<i class="fa fa-star-o"></i> 
					</span>
				</li>
			</ul>
			<ul class="list-inline card_date_info">
				<li class="left_date"><i class="fa fa-user"></i> {{ count($course->userRequests) }}</li>
				@php $flag=true; @endphp
				@if($course->hide_after_end == 1)
					@if($course->max_nr_people > count($course->userRequests) 
				    && dateToTimestamp($course->is_open_to) > dateToTimestamp(date('Y-m-d')))
						<li class="right_date"><i class="fa fa-calendar"></i> 
							Идет набор до {{ date('d.m.Y', strtotime($course->is_open_to)) }}
						</li> 
					@else
						@php $flag=false; @endphp 
					@endif
				@elseif($course->max_nr_people == count($course->userRequests))
					@php $flag=false; @endphp 
				@endif 

				@if($flag==false)
					<li class="right_date"> 
						Набор закончен
					</li>
				@endif
			</ul>
			<div class="row">
				<div class="col-lg-6">
					<div class="more_card"><a href="{{ route(userRoute('edit_course'), ['id' => $course->id]) }}">Управлять курсом</a></div>
				</div>
				<div class="col-lg-6">
					<div class="more_card delete__item"><a href="{{ route(userRoute('delete_course'), ['id' => $course->id]) }}">Удалить</a></div>
				</div>
			</div>
		</div>
	</div>
</div>