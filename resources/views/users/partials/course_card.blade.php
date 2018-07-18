<div class="col-lg-4">
	<div class="external_card">
		<div class="caption">
			<ul class="list-inline card_tag">
				<li class="tag_sticker">
					<span>{{ @$course->category->name }}</span>
				</li>
				@if(@Auth::check()) 
                    @php 
                        $favorite = in_array(Auth::user()->id, $course->userFavorite->pluck('id')->toArray()); 
                    @endphp
                    <li class="bookmark_tag">
                        <i class="fa course_heart 
                           {{ $favorite ? 'is_favorite fa-heart' : 'fa-heart-o' }}" 
                           onclick="courseFavorite(this, {{ $course->id }});"  
                           aria-hidden="true"></i> 
                    </li> 
                @endif
			</ul>
			<h3>{{ $course->name }}</h3>
			<h4>
	            @if($course->user->user_type==3)
	            		{{ $course->user->university['full_name'] }} 
	            	@else
						{{ $course->user->name }} 
	            @endif
        	</h4>
			<ul class="list-unstyled card_info">
				<li>
					Стоимость 
					<span> 
						@if($course->pay == 1)
							бесплатно
						@else
							₽{{ priceString(Course::generatePrice($course)) }}
        				@endif 
					</span>
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
                        <select class="rating-stars" name="rating" data-readonly="true" data-current-rating="{{ floatval($course->reviews->avg('rating')) }}" autocomplete="off">
                          <option value="1">1</option> 
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select> 
                    </span> 
				</li>
			</ul>
			<ul class="list-inline card_date_info">
				<li class="left_date"><i class="fa fa-user"></i> {{ count($course->userRequests) }}</li>
				@php  
					$esablishDate = Course::manager($course)->esablishDate();  
                @endphp
                <li class="right_date"> 
                    {{ $esablishDate['status'] }} {{ $esablishDate['date'] }}
                </li> 
			</ul>
			<div class="row">
				<div class="col-lg-6">
					<div class="more_card"><a href="{{ route(userRoute('edit_course'), ['id' => $course->id]) }}">Управлять курсом</a></div>
				</div>
				@if(!Course::manager($course)->isStarted()) 
					<div class="col-lg-6">
						<div class="more_card delete__item"><a href="{{ route(userRoute('delete_course'), ['id' => $course->id]) }}">Удалить</a></div>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>