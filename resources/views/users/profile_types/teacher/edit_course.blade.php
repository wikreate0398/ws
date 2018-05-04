<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
    	<a href="#about" aria-controls="about" role="tab" data-toggle="tab">О курсе</a>
    </li>
    <li role="presentation">
    	<a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Настройки курса</a>
    </li> 
    <li role="presentation">
    	<a href="#programm" aria-controls="programm" role="tab" data-toggle="tab">Программа курса</a>
    </li> 
</ul>

<form class="form-horizontal ajax__submit" method="POST" action="{{ route('save_course') }}">
	 {{ csrf_field() }}
<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="about" style="padding-top: 20px;">
		
		<div class="form-group">
            <label class="col-md-12 control-label">Название курса <span class="req">*</span></label>
            <div class="col-md-12">
                <input type="text" class="form-control" name="name" value="{{ $course->name }}" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-12 control-label">Краткое описание курса <span class="req">*</span></label>
            <div class="col-md-12">
            	<textarea name="description" class="form-control" placeholder="200" required>{{ $course->description }}</textarea> 
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-12 control-label">Подробное описание курса</label>
            <div class="col-md-12">
            	<textarea name="text" class="form-control" placeholder="2000">{{ $course->text }}</textarea> 
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-12 control-label">Куратор курса <span class="req">*</span></label>
            <div class="col-md-12">
                <input type="text" 
                       class="form-control" 
                       name="" 
                       value="{{ Auth::user()->name }} {{ Auth::user()->surname }} {{ Auth::user()->patronymic }}" 
                       required
                       disabled>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-12 control-label">Категория и подкатегория <span class="req">*</span></label>
            <div class="col-md-12">
                <select name="id_category" id="id_category" class="form-control" onchange="loadCourseSubcats(this, '{{ $course->id_subcat }}')">
                    <option value="">Выбрать</option>
                    @foreach($categories as $item)
                        <option {{ ($course->id_category == $item['id']) ? 'selected' : '' }} value="{{$item['id']}}">
                        	{{$item['name']}}
                        </option>
                    @endforeach
                </select>
            </div>
            <script>
            	$(window).load(function(){ $('select#id_category').change(); });
            </script>

            <div class="col-md-12" id="load__subcats" style="display: none; margin-top: 20px;"> 
            </div>
        </div>

        <h2 style="font-size: 24px; margin-top: 40px;">Цены и скидки <span class="req">*</span></h2>
		
		 
	        <div class="form-check">
		        <input type="radio" name="pay" value="1" {{ ($course->pay == 1) ? 'checked' : '' }} onchange="setPayCourse(this)" class="form-check-input" id="exampleCheck1">
		        <label class="form-check-label" for="exampleCheck1">Бесплатный курс</label>
		  	</div> 

	      	<div class="form-check">
	        	<input type="radio" name="pay" value="2" {{ ($course->pay == 2) ? 'checked' : '' }} onchange="setPayCourse(this)" class="form-check-input" id="exampleCheck2">
	        	<label class="form-check-label" for="exampleCheck2">Платный курс</label>
	      	</div>
	      	<br>
	       	<input type="text" 
	       	       class="form-control price__course" 
	       	       name="price"  
	       	       placeholder="Стоимость, руб *" 
	       	       required 
	       	       value="{{ $course->price }}" 
	       	       {{ ($course->pay == 1) ? 'disabled' : '' }}>
       
	</div>

	<div role="tabpanel" class="tab-pane" id="settings" style="padding-top: 20px;">
		<div class="col-md-12">
            <div class="form-group">
                <label class="col-md-12 control-label" style="white-space: nowrap;">Запись курса открыта до <span class="req">*</span></label>
                <div class="col-md-9">
                    <input type="text" class="form-control datepicker" name="is_open_until" value="{{ date('d/m/Y', strtotime($course->is_open_until)) }}" placeholder="DD/MM/YY" required>
                </div>
            </div> 
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-12 control-label" style="white-space: nowrap;">Доступность на сайте <span class="req">*</span></label>
                <div class="col-md-9"> 
                    <div class="form-check">
				        <input type="radio" {{ ($course->available == 1) ? 'checked' : '' }} name="available" value="1" class="form-check-input" id="exampleCheck11">
				        <label class="form-check-label" for="exampleCheck11">Всем желающим</label>
				  	</div>
			      	<div class="form-check">
			        	<input type="radio" {{ ($course->available == 2) ? 'checked' : '' }} name="available" value="2" class="form-check-input" id="exampleCheck22">
			        	<label class="form-check-label" for="exampleCheck22">Только для зарегистрированных пользователей</label>
			      	</div>
			      	<div class="form-check">
				        <input type="radio" {{ ($course->available == 3) ? 'checked' : '' }} name="available" value="3" class="form-check-input" id="exampleCheck33">
				        <label class="form-check-label" for="exampleCheck33">Скрыть курс по окончанию набора</label>
				  	</div>  
                </div>
            </div> 
        </div>
	</div>

	<div role="tabpanel" class="tab-pane" id="programm" style="padding-top: 20px;">
	
		<div class="course__sections"> 

				<div class="panel panel-default course__section first_block">
			        <div class="panel-heading">
			            <h3 class="panel-title">Раздел</h3>
			        </div>
			        <div class="panel-body"> 
			            <div class="row">
			                <div class="col-md-12">
                     
					            <div class="form-group">
					                <label class="col-md-12 control-label" style="white-space: nowrap;">Название Раздела<span class="req">*</span></label>
					                <div class="col-md-9">
					                    <input type="text" class="form-control" name="section[name][]" value="" placeholder="" required>
					                </div>
					            </div> 

					            <div class="lecture__sections"> 
						            <div class="panel panel-warning lecture__section first_block">
						            	<div class="panel-heading">
								            <h3 class="panel-title">Добавления лекции</h3>
								        </div>
						            	<div class="panel-body"> 
						            		<div class="form-group">
									            <label class="col-md-12 control-label">Название лекции <span class="req">*</span></label>
									            <div class="col-md-12">
									                <input type="text" class="form-control" name="lecture[0][name][]" value="" required>
									            </div>
									        </div>

									        <div class="form-group">
									            <label class="col-md-12 control-label">Описание лекции <span class="req">*</span></label>
									            <div class="col-md-12">
									            	<textarea name="lecture[0][description][]" class="form-control" placeholder="" required=""></textarea> 
									            </div>
									        </div>

									        <div class="form-group">
									            <label class="col-md-12 control-label">Длительность лекции <span class="req">*</span></label>
									            <div class="col-md-2">
									            	<input type="text" class="form-control number_field" name="lecture[0][hourse][]" placeholder="чч" value="" required>
									            </div>
									            <div class="col-md-2">
									            	<input type="text" class="form-control number_field" name="lecture[0][minutes][]" placeholder="мм" value="">
									            </div>
									        </div>
						            	</div>
						            </div>
					            </div>
			         
			                </div> 
			 
			                <div class="col-md-12">
			                    <button type="button" onclick="addLecture(this);" class="btn btn-sm btn-dafault add__more">
			                    	Добавить лекцию
			                    </button>
			                </div> 			            
			            </div> 
			        </div>
    			</div>
 
		</div>

		<button class="btn btn-default btn-sm" type="button" onclick="addCourseSection()">Добавить раздел</button>
	</div>
</div>
<div style="margin-top: 30px;">
	<div id="error-respond"></div>
	<button type="submit" class="btn btn-success" style="display: inline-block; width: auto;">
	    Редактировать 
	</button>
</div>

</form> 

 